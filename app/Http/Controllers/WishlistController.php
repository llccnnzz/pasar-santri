<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $currentUser = $request->user();
        $currentUser->load('wishlist');
        $wishlist = $currentUser->wishlist;

        $wishlistItems = json_decode($wishlist->items, true);

        $wishlistItems = collect($wishlistItems)->map(function ($item) {
            return [
                'id' => $item['id'],
                'price' => $item['price'],
                'name' => $item['name'],
                'slug' => $item['slug'],
                'image' => $item['image'],
                'stock' => $item['stock']
            ];
        });

        return view('buyer.wishlist', compact('wishlistItems'));
    }

    public function add(Request $request)
    {
        $currentUser = $request->user();
        $currentUser->load('wishlist');
        $wishlist = $currentUser->wishlist;

        $wishlistItems = json_decode($wishlist->items, true);

        $productId = $request->input('product_id');
        $product = Product::find($productId);
        if (!$product) {
            return redirect()->back()->with('error', 'Product not found.');
        }

        // Check if the product already exists in the wishlist
        $existingItemKey = collect($wishlistItems)->search(function ($item) use ($productId) {
            return $item['id'] == $productId;
        });

        if ($existingItemKey === false) {
            // Add new item to the wishlist
            $wishlistItems[] = [
                'id' => $productId,
                'price' => $product->final_price,
                'name' => $product->name,
                'slug' => $product->slug,
                'image' => $product->defaultImage ? $product->defaultImage->getFullUrl() : null,
                'stock' => $product->stock
            ];
        }

        // Save updated wishlist items
        $wishlist->update(['items' => json_encode($wishlistItems)]);

        return redirect()->back()->with('success', 'Product added to wishlist successfully.');
    }

    public function remove(Request $request, Product $product)
    {
        $currentUser = $request->user();
        $currentUser->load('wishlist');
        $wishlist = $currentUser->wishlist;

        $wishlistItems = json_decode($wishlist->items, true);

        // Find the item in the wishlist
        $itemKey = collect($wishlistItems)->search(function ($item) use ($product) {
            return $item['id'] == $product->id;
        });

        if ($itemKey !== false) {
            // Remove the item from the wishlist
            unset($wishlistItems[$itemKey]);
            // Re-index the array
            $wishlistItems = array_values($wishlistItems);
            // Save updated wishlist items
            $wishlist->update(['items' => json_encode($wishlistItems)]);
            return redirect()->back()->with('success', 'Product removed from wishlist successfully.');
        }

        return redirect()->back()->with('error', 'Product not found in wishlist.');
    }
}
