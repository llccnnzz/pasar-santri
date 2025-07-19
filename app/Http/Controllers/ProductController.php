<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Shop;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index(Request $request)
    {
        $categories = Category::all();
        $brands = Shop::where('is_open', true)->get();
        $tags = Product::pluck('tags')->flatten()->unique()->filter()->values();

        $minPrice = Product::min('final_price');
        $maxPrice = Product::max('final_price');
        return view('products.index', compact('categories', 'brands', 'tags', 'minPrice', 'maxPrice'));
    }

    public function show(Request $request, Product $product)
    {
        $product->load(['variants.attributeValues.attribute', 'categories', 'defaultImage', 'hoverImage', 'images']);
        $categoryIds = $product->categories->pluck('id');

        $relatedProducts = Product::where('id', '!=', $product->id)
            ->whereHas('categories', function ($query) use ($categoryIds) {
                $query->whereIn('categories.id', $categoryIds);
            })
            ->with(['defaultImage', 'hoverImage'])
            ->limit(4)
            ->get();
        return view('products.show', compact('product', 'relatedProducts'));
    }
}
