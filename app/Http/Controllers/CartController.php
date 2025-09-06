<?php
namespace App\Http\Controllers;

use App\Models\GlobalVariable;
use App\Models\Product;
use App\Traits\CartTrait;
use Illuminate\Http\Request;

class CartController extends Controller
{
    use CartTrait;
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $currentUser = $request->user();
        $currentUser->load('cart');
        $cart = $currentUser->cart;

        if (! $cart || ! $cart->items) {
            return view('buyer.cart', [
                'cartItems'   => [],
                'summary'    => [],
            ]);
        }

        $cart = $this->handleCartData($cart);

        // Prepare totals array for view
        $summary = [
            'subtotal'    => $cart['subTotal'],
            'payment_fee' => $cart['paymentFee'],
            'total'       => $cart['total'],
        ];
        $cartItems = $cart['cartItems'];
        $outOfStockItems = $cart['outOfStockItems'];
        $paymentFeeConfig = $cart['paymentFeeConfig'];

        return view('buyer.cart', compact(
            'cartItems',
            'summary',
            'outOfStockItems',
            'paymentFeeConfig',
        ));
    }

    public function add(Request $request)
    {
        $currentUser = $request->user();
        $currentUser->load('cart');
        $cart = $currentUser->cart;

        $cartItems = json_decode($cart->items, true);

        $productId = $request->input('product_id');
        $product   = Product::find($productId);
        if (! $product) {
            return redirect()->back()->withErrors('Product not found.');
        }
        $quantity = $request->input('quantity', 1);

        // Check if the product already exists in the cart
        $existingItemKey = collect($cartItems)->search(function ($item) use ($productId) {
            return $item['id'] == $productId;
        });

        if ($existingItemKey !== false) {
            $isAvailable = true;
            $message     = null;
            if ($product->stock < ($cartItems[$existingItemKey]['quantity'] + $quantity) - 1) {
                $isAvailable = false;
                $message     = 'Out of Stock';
            }
            if ($isAvailable) {
                $cartItems[$existingItemKey]['quantity'] += $quantity;
            }
            $cartItems[$existingItemKey]['is_available'] = $isAvailable;
            $cartItems[$existingItemKey]['message']      = $message;

            if ($cartItems[$existingItemKey]['quantity'] < 1) {
                unset($cartItems[$existingItemKey]);
                $cartItems = array_values($cartItems);
            }
        } else {
            $isAvailable = true;
            $message     = null;
            if ($product->stock < $quantity) {
                $isAvailable = false;
                $message     = 'Out of Stock';
            }
            if ($quantity < 1) {
                return redirect()->back()->withErrors('Minimum Quantity is 1.');
            }
            $cartItems[] = [
                'id'           => $productId,
                'quantity'     => $quantity,
                'price'        => $product->final_price,
                'name'         => $product->name,
                'description'  => $product->meta_description,
                'weight'       => $product->weight,
                'slug'         => $product->slug,
                'image'        => $product->defaultImage ? $product->defaultImage->getFullUrl() : null,
                'is_available' => $isAvailable,
                'message'      => $message,

            ];
        }

        // Save updated cart items
        $cart->update(['items' => json_encode($cartItems)]);

        return redirect()->back()->withMessage('Product added to cart successfully.');
    }

    public function remove(Request $request, string $productId)
    {
        $product     = Product::findOrFail($productId);
        $currentUser = $request->user();
        $currentUser->load('cart');
        $cart = $currentUser->cart;

        $cartItems = json_decode($cart->items, true);

        // Find the item in the cart
        $itemKey = collect($cartItems)->search(function ($item) use ($product) {
            return $item['id'] == $product->id;
        });

        if ($itemKey !== false) {
            // Remove the item from the cart
            unset($cartItems[$itemKey]);
            // Re-index the array
            $cartItems = array_values($cartItems);
            // Save updated cart items
            $cart->update(['items' => json_encode($cartItems)]);
            return redirect()->back()->withMessage('Product removed from cart successfully.');
        }

        return redirect()->back()->withErrors('Product not found in cart.');
    }

    public function updateQuantity(Request $request, string $productId)
    {
        $product = Product::findOrFail($productId);
        $request->validate([
            'quantity' => 'required|integer|min:1|max:99',
        ]);

        $currentUser = $request->user();
        $currentUser->load('cart');
        $cart = $currentUser->cart;

        if (! $cart) {
            return response()->json(['error' => 'Cart not found'], 404);
        }

        $cartItems = json_decode($cart->items, true);

        // Check stock
        if ($product->stock < $request->quantity) {
            return response()->json([
                'error' => 'Insufficient stock. Only ' . $product->stock . ' items available.',
            ], 400);
        }

        // Update quantity
        foreach ($cartItems as $i => $item) {
            $finalQuantity = $request->quantity;

            $isAvailable       = true;
            $message           = null;
            $availableQuantity = $finalQuantity;

            // Check stock availability
            if ($product->stock <= 0) {
                $isAvailable       = false;
                $message           = 'Out of Stock';
                $availableQuantity = 0;
            } elseif ($product->stock < $finalQuantity) {
                $message           = "Only {$product->stock} available";
                $availableQuantity = $product->stock;
            }

            if ($item['id'] == $product['id'] && $finalQuantity > 0) {
                $cartItems[$i] = [
                    'id'                 => $item['id'],
                    'quantity'           => $finalQuantity,
                    'available_quantity' => $availableQuantity,
                    'price'              => $product->final_price,
                    'original_price'     => $product->price,
                    'name'               => $product->name,
                    'description'        => $product->meta_description,
                    'weight'             => $product->weight,
                    'slug'               => $product->slug,
                    'image'              => $product->defaultImage ? $product->defaultImage->getFullUrl() : null,
                    'is_available'       => $isAvailable,
                    'message'            => $message,
                    'item_total'         => $product->final_price * $availableQuantity,
                    'shop_id'            => $product->shop->id,
                    'shop_name'          => $product->shop->name ?? 'Unknown Shop',
                    'stock'              => $product->stock,
                ];
                break;
            }
        }

        $cart->update(['items' => json_encode($cartItems)]);

        // Calculate new totals
        $itemTotal = $product->final_price * $request->quantity;
        $subTotal  = array_sum(array_column($cartItems, 'item_total'));
        $paymentFeeConfig = GlobalVariable::where('key','iLike', 'payment_fee%')->get()->mapWithKeys(function ($item) {
            return [
                str_replace('payment_fee_', '', $item['key']) => ($item['type'] === 'float' ? (float) $item['value'] : $item['value'])
            ];
        })->toArray();

        // Calculate payment fee
        if ($paymentFeeConfig['type'] === 'percent') {
            $paymentFee = $subTotal * ($paymentFeeConfig['percent'] / 100);
            if ($paymentFee < $paymentFeeConfig['percent_min_value']) {
                $paymentFee = $paymentFeeConfig['percent_min_value'];
            }
        } else {
            $paymentFee = $paymentFeeConfig['fixed'];
        }

        return response()->json([
            'success'     => true,
            'item_total'  => 'Rp. ' . number_format($itemTotal),
            'subtotal'    => 'Rp. ' . number_format($subTotal),
            'payment_fee' => 'Rp. ' . number_format($paymentFee),
            'total'       => 'Rp. ' . number_format($subTotal + $paymentFee),
        ]);
    }

    public function clear(Request $request)
    {
        $currentUser = $request->user();
        $currentUser->load('cart');
        $cart = $currentUser->cart;

        try {
            // only clear the items in the cart
            $cart->update(['items' => json_encode([])]);

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Cart cleared successfully!',
                ]);
            }

            return redirect()->route('cart.index')->with('message', 'Cart cleared successfully!');
        } catch (\Exception $e) {
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to clear cart',
                ], 500);
            }

            return redirect()->route('cart.index')->with('errors', 'Failed to clear cart');
        }
    }
}
