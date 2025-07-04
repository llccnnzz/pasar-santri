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
        $cart = $currentUser->load('cart');
        if (is_null($cart)) {
            $cart = $currentUser->cart()->create(['items' => json_encode([])]);
        }

        $cartItems = json_decode($cart->items, true);

        $cartItems = collect($cartItems)->map(function ($item) {
            return [
                'id' => $item['id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'name' => $item['name'],
                'image' => $item['image'],
            ];
        });

        return view('cart.index', compact('cartItems'));
    }

    public function add(Request $request)
    {
        $currentUser = $request->user();
        $cart = $currentUser->load('cart');

        if (is_null($cart)) {
            $cart = $currentUser->cart()->create(['items' => json_encode([])]);
        }

        $cartItems = json_decode($cart->items, true);

        $productId = $request->input('product_id');
        $product = Product::find($productId);
        if (!$product) {
            return redirect()->back()->with('error', 'Product not found.');
        }
        $quantity = $request->input('quantity', 1);

        // Check if the product already exists in the cart
        $existingItemKey = collect($cartItems)->search(function ($item) use ($productId) {
            return $item['id'] == $productId;
        });

        if ($existingItemKey !== false) {
            // Update quantity if it exists
            $cartItems[$existingItemKey]['quantity'] += $quantity;
        } else {
            // Add new item to the cart
            $cartItems[] = [
                'id' => $productId,
                'quantity' => $quantity,
                'price' => $product->final_price,
                'name' => $product->name,
                'image' => $product->defaultImage ? $product->defaultImage->url : null,
            ];
        }

        // Save updated cart items
        $cart->update(['items' => json_encode($cartItems)]);

        return redirect()->route('cart.index')->with('success', 'Product added to cart successfully.');
    }
}
