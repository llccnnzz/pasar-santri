<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        // Cache homepage data for 30 minutes
        $homepageData = Cache::remember('homepage_data', 1800, function () {
            return [
                'featured' => Product::with(['defaultImage', 'hoverImage'])
                    ->where('is_featured', true)
                    ->limit(10)
                    ->get(),
                'popular' => Product::with(['defaultImage', 'hoverImage'])
                    ->where('is_popular', true)
                    ->limit(8)
                    ->get(),
                'latest' => Product::with(['defaultImage', 'hoverImage'])
                    ->latest()
                    ->limit(8)
                    ->get(),
                'categories' => Category::with('icon')
                    ->whereNull('parent_id')
                    ->limit(8)
                    ->get(),
                'categoryProducts' => Category::with(['products' => function($query) {
                        $query->with(['defaultImage', 'hoverImage'])->limit(10);
                    }])
                    ->whereHas('products')
                    ->limit(5)
                    ->get(),
            ];
        });

        return view('welcome', $homepageData);
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
