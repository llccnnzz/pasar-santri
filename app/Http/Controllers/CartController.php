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

        $cartItems = json_decode($cart->items, true);

        $subTotal = 0;

        $products = Product::whereIn('id', collect($cartItems)->pluck('id')->toArray())->get();

        $cartItems = collect($cartItems)->map(function ($item) use (&$subTotal, $products) {
            $isAvailable = $item['is_available'];
            $message = $item['message'];

            $product = $products->where('id', $item['id'])->first();

            if(!$product) {
                $isAvailable = false;
                $message = 'Product not available';
            } else {
                if ($product->stock < $item['quantity']) {
                    $isAvailable = false;
                    $message = 'Out of Stock';
                }
            }

            $subTotal += ($item['price'] * $item['quantity']);
            return [
                'id' => $item['id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'name' => $item['name'],
                'slug' => $item['slug'],
                'image' => $item['image'],
                'is_available' => $isAvailable,
                'message' => $message,
            ];
        });

        $cart->update(['items' => json_encode($cartItems)]);

        return view('buyer.cart', compact('cartItems', 'subTotal'));
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
            if ($product->stock < $quantity) {
                $isAvailable = false;
                $message = 'Out of Stock';
            }
            $cartItems[$existingItemKey]['quantity'] += $quantity;
            $cartItems[$existingItemKey]['is_available'] = $isAvailable;
            $cartItems[$existingItemKey]['message'] = $message;
        } else {
            $isAvailable = true;
            $message = null;
            if ($product->stock < $quantity) {
                $isAvailable = false;
                $message = 'Out of Stock';
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

    public function remove(Request $request, Product $product)
    {
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
}
