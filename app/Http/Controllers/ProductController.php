<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{

    public function index(Request $request)
    {
        // Cache filter data for 1 hour
        $categories = Cache::remember('product_filters_categories', 3600, function () {
            return Category::select('id', 'name')->get();
        });
        
        $brands = Cache::remember('product_filters_brands', 3600, function () {
            return Shop::select('id', 'name', 'slug')
                ->where('is_open', true)
                ->whereHas('products', function($query) {
                    $query->whereNull('deleted_at');
                })
                ->get();
        });
        
        $tags = Cache::remember('product_filters_tags', 3600, function () {
            // Simple approach: get all products with tags and extract in PHP
            $products = Product::select('tags')
                ->whereNotNull('tags')
                ->whereRaw("json_array_length(tags) > 0")
                ->get();
            
            $allTags = collect();
            foreach ($products as $product) {
                if ($product->tags && is_array($product->tags)) {
                    $allTags = $allTags->merge($product->tags);
                }
            }
            
            return $allTags
                ->filter()
                ->unique()
                ->values()
                ->take(50); // Limit to most relevant tags
        });

        [$minPrice, $maxPrice] = Cache::remember('product_price_range', 1800, function () {
            return [
                Product::min('final_price') ?? 0,
                Product::max('final_price') ?? 0
            ];
        });

        return view('products.index', compact('categories', 'brands', 'tags', 'minPrice', 'maxPrice'));
    }

    public function show(Request $request, Product $product)
    {
        // Load product relationships efficiently
        $product->load([
            'variants.attributeValues.attribute', 
            'categories:id,name', 
            'defaultImage', 
            'hoverImage', 
            'images',
            'shop:id,name,slug'
        ]);

        // Cache related products for 30 minutes
        $cacheKey = "related_products_{$product->id}";
        $relatedProducts = Cache::remember($cacheKey, 1800, function () use ($product) {
            $categoryIds = $product->categories->pluck('id');

            return Product::select(['id', 'slug', 'name', 'shop_id', 'final_price', 'price', 'stock'])
                ->where('id', '!=', $product->id)
                ->where('stock', '>', 0)
                ->whereHas('categories', function ($query) use ($categoryIds) {
                    $query->whereIn('categories.id', $categoryIds);
                })
                ->with(['defaultImage', 'hoverImage', 'shop:id,name,slug'])
                ->limit(4)
                ->get();
        });

        return view('products.show', compact('product', 'relatedProducts'));
    }
}
