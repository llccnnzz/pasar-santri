<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Shop;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with(['defaultImage', 'hoverImage', 'images', 'categories'])->get();
        $categories = Category::with(['products.defaultImage', 'products.hoverImage', 'products.categories', 'icon'])->get();
        return view('welcome', compact('products', 'categories'));
    }

    public function show(Shop $shop)
    {
//        dd($shop);
//
//        $shop->load('products.defaultImage', 'products.hoverImage', 'products.images', 'products.categories');
//        $products = $shop->products;
        return view('buyer.shop');
    }
}
