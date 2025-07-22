<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $currentUser = $request->user();
        $currentUser->load('cart');
        $cart = $currentUser->cart;

        if (!$cart || !$cart->items) {
            return view('buyer.cart', [
                'cartItems' => [],
                'subTotal' => 0,
                'shipping' => 0,
                'tax' => 0,
                'total' => 0,
                'itemCount' => 0
            ]);
        }

        $cartItems = json_decode($cart->items, true);
        $productIds = collect($cartItems)->pluck('id')->toArray();
        
        // Get current product data with fresh prices and stock
        $products = Product::whereIn('id', $productIds)
            ->with(['defaultImage', 'shop'])
            ->get()
            ->keyBy('id');

        $subTotal = 0;
        $itemCount = 0;
        $updatedCartItems = [];

        foreach ($cartItems as $item) {
            $product = $products->get($item['id']);
            
            if (!$product) {
                // Product no longer exists, skip it
                continue;
            }

            $isAvailable = true;
            $message = null;
            $availableQuantity = $item['quantity'];

            // Check stock availability
            if ($product->stock <= 0) {
                $isAvailable = false;
                $message = 'Out of Stock';
                $availableQuantity = 0;
            } elseif ($product->stock < $item['quantity']) {
                $message = "Only {$product->stock} available";
                $availableQuantity = $product->stock;
            }

            // Use current product price (in case price changed)
            $currentPrice = $product->final_price;
            $itemTotal = $currentPrice * $availableQuantity;
            
            $updatedCartItems[] = [
                'id' => $item['id'],
                'quantity' => $item['quantity'],
                'available_quantity' => $availableQuantity,
                'price' => $currentPrice,
                'original_price' => $product->price,
                'name' => $product->name,
                'slug' => $product->slug,
                'image' => $product->defaultImage ? $product->defaultImage->getFullUrl() : null,
                'is_available' => $isAvailable,
                'message' => $message,
                'item_total' => $itemTotal,
                'shop_name' => $product->shop->name ?? 'Unknown Shop',
                'stock' => $product->stock
            ];

            if ($isAvailable) {
                $subTotal += $itemTotal;
                $itemCount += $availableQuantity;
            }
        }

        // Update cart with current data
        $cart->update(['items' => json_encode($updatedCartItems)]);

        // Calculate shipping
        $shipping = $this->calculateShipping($subTotal, $itemCount);
        
        // Calculate tax (11%)
        $taxRate = 11;
        $tax = $subTotal * ($taxRate / 100);
        
        // Calculate total
        $total = $subTotal + $shipping + $tax;
        
        // Count out of stock items
        $outOfStockItems = collect($updatedCartItems)->where('is_available', false)->count();

        // Prepare totals array for view
        $totals = [
            'subtotal' => $subTotal,
            'shipping' => $shipping,
            'tax' => $tax,
            'tax_rate' => $taxRate,
            'total' => $total
        ];

        return view('buyer.cart', compact(
            'cartItems', 
            'totals',
            'outOfStockItems'
        ))->with('cartItems', $updatedCartItems);
    }

    public function add(Request $request)
    {
        $currentUser = $request->user();
        $currentUser->load('cart');
        $cart = $currentUser->cart;

        $cartItems = json_decode($cart->items, true);

        $productId = $request->input('product_id');
        $product = Product::find($productId);
        if (!$product) {
            return redirect()->back()->withErrors('Product not found.');
        }
        $quantity = $request->input('quantity', 1);

        // Check if the product already exists in the cart
        $existingItemKey = collect($cartItems)->search(function ($item) use ($productId) {
            return $item['id'] == $productId;
        });

        if ($existingItemKey !== false) {
            $isAvailable = true;
            $message = null;
            if ($product->stock < ($cartItems[$existingItemKey]['quantity'] + $quantity) - 1) {
                $isAvailable = false;
                $message = 'Out of Stock';
            }
            if ($isAvailable) {
                $cartItems[$existingItemKey]['quantity'] += $quantity;
            }
            $cartItems[$existingItemKey]['is_available'] = $isAvailable;
            $cartItems[$existingItemKey]['message'] = $message;

            if ($cartItems[$existingItemKey]['quantity'] < 1) {
                unset($cartItems[$existingItemKey]);
                $cartItems = array_values($cartItems);
            }
        } else {
            $isAvailable = true;
            $message = null;
            if ($product->stock < $quantity) {
                $isAvailable = false;
                $message = 'Out of Stock';
            }
            if ($quantity < 1) {
                return redirect()->back()->withErrors('Minimum Quantity is 1.');
            }
            $cartItems[] = [
                'id' => $productId,
                'quantity' => $quantity,
                'price' => $product->final_price,
                'name' => $product->name,
                'slug' => $product->slug,
                'image' => $product->defaultImage ? $product->defaultImage->getFullUrl() : null,
                'is_available' => $isAvailable,
                'message' => $message,
            ];
        }

        // Save updated cart items
        $cart->update(['items' => json_encode($cartItems)]);

        return redirect()->back()->withMessage('Product added to cart successfully.');
    }

    public function remove(Request $request, string $productId)
    {
        $product = Product::findOrFail($productId);
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
            'quantity' => 'required|integer|min:1|max:99'
        ]);

        $currentUser = $request->user();
        $currentUser->load('cart');
        $cart = $currentUser->cart;
        
        if (!$cart) {
            return response()->json(['error' => 'Cart not found'], 404);
        }

        $cartItems = json_decode($cart->items, true);

        // Check stock
        if ($product->stock < $request->quantity) {
            return response()->json([
                'error' => 'Insufficient stock. Only ' . $product->stock . ' items available.'
            ], 400);
        }

        // Update quantity
        foreach ($cartItems as $i => $item) {
            $finalQuantity = $request->quantity;

            $isAvailable = true;
            $message = null;
            $availableQuantity = $finalQuantity;

            // Check stock availability
            if ($product->stock <= 0) {
                $isAvailable = false;
                $message = 'Out of Stock';
                $availableQuantity = 0;
            } elseif ($product->stock < $finalQuantity) {
                $message = "Only {$product->stock} available";
                $availableQuantity = $product->stock;
            }

            if ($item['id'] == $product['id'] && $finalQuantity > 0) {
                $cartItems[$i] = [
                    'id' => $item['id'],
                    'quantity' => $finalQuantity,
                    'available_quantity' => $availableQuantity,
                    'price' => $product->final_price,
                    'original_price' => $product->price,
                    'name' => $product->name,
                    'slug' => $product->slug,
                    'image' => $product->defaultImage ? $product->defaultImage->getFullUrl() : null,
                    'is_available' => $isAvailable,
                    'message' => $message,
                    'item_total' => $product->final_price * $availableQuantity,
                    'shop_name' => $product->shop->name ?? 'Unknown Shop',
                    'stock' => $product->stock
                ];
                break;
            }
        }

        $cart->update(['items' => json_encode($cartItems)]);

        // Calculate new totals
        $itemTotal = $product->final_price * $request->quantity;
        $subTotal = array_sum(array_column($cartItems, 'item_total'));
        $shipping = $this->calculateShipping(array_sum(array_column($cartItems, 'item_total')), array_sum(array_column($cartItems, 'quantity')));
        $tax = $subTotal * 0.11;

        return response()->json([
            'success' => true,
            'item_total' => 'Rp. ' . number_format($itemTotal),
            'subtotal' => 'Rp. ' . number_format($subTotal),
            'shipping' => 'Rp. ' . number_format($shipping),
            'tax' => 'Rp. ' . number_format($tax),
            'total' => 'Rp. ' . number_format($subTotal + $shipping + $tax)
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
                    'message' => 'Cart cleared successfully!'
                ]);
            }
            
            return redirect()->route('cart.index')->with('message', 'Cart cleared successfully!');
        } catch (\Exception $e) {
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to clear cart'
                ], 500);
            }
            
            return redirect()->route('cart.index')->with('errors', 'Failed to clear cart');
        }
    }

    private function calculateShipping($subTotal, $itemCount)
    {
        // Free shipping for orders above Rp 500,000
        if ($subTotal >= 500000) {
            return 0;
        }

        // Base shipping rate
        $baseShipping = 15000; // Rp 15,000 base
        
        // Additional cost per item above 3 items
        if ($itemCount > 3) {
            $additionalItems = $itemCount - 3;
            $baseShipping += ($additionalItems * 5000); // Rp 5,000 per additional item
        }

        return $baseShipping;
    }
}
