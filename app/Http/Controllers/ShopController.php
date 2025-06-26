<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with(['defaultImage', 'hoverImage', 'images', 'categories'])->get();
        $categories = Category::with(['products.defaultImage', 'products.hoverImage', 'products.categories', 'icon'])->get();
        return view('welcome', compact('products', 'categories'));
    }
}
