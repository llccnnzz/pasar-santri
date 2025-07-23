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
                'featured' => Product::with(['defaultImage', 'hoverImage', 'shop'])
                    ->where('is_featured', true)
                    ->orderByRaw('CASE WHEN stock > 0 THEN 0 ELSE 1 END, stock DESC')
                    ->limit(10)
                    ->get(),
                'popular' => Product::with(['defaultImage', 'hoverImage', 'shop'])
                    ->where('is_popular', true)
                    ->orderByRaw('CASE WHEN stock > 0 THEN 0 ELSE 1 END, stock DESC')
                    ->limit(8)
                    ->get(),
                'latest' => Product::with(['defaultImage', 'hoverImage', 'shop'])
                    ->orderByRaw('CASE WHEN stock > 0 THEN 0 ELSE 1 END, created_at DESC')
                    ->limit(8)
                    ->get(),
                'categories' => Category::with('icon')
                    ->whereNull('parent_id')
                    ->limit(8)
                    ->get(),
                'categoryProducts' => Category::with(['products' => function($query) {
                        $query->with(['defaultImage', 'hoverImage', 'shop'])
                              ->orderByRaw('CASE WHEN stock > 0 THEN 0 ELSE 1 END, stock DESC')
                              ->limit(10);
                    }])
                    ->whereHas('products')
                    ->limit(5)
                    ->get(),
            ];
        });

        // Prepare SEO data for homepage
        $seoData = [
            'title' => env('APP_NAME') . ' - Your Trusted Online Marketplace',
            'description' => 'Discover quality products from trusted sellers at ' . env('APP_NAME') . '. Shop electronics, fashion, home & garden, and more with confidence. Great deals, fast shipping, secure payments.',
            'keywords' => 'marketplace, online shopping, electronics, fashion, home garden, deals, trusted sellers, secure payments, fast shipping',
            'canonical' => route('homepage'),
        ];

        return view('welcome', array_merge($homepageData, compact('seoData')));
    }

    public function list(Request $request)
    {
        $query = Shop::withCount('products')->where('is_open', true);

        // Search functionality
        if ($request->filled('search')) {
            $query->where('name', 'ilike', '%' . $request->search . '%');
        }

        // Sorting
        switch ($request->get('sort', 'name')) {
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            case 'products_count':
                $query->orderBy('products_count', 'desc');
                break;
            case 'newest':
                $query->latest();
                break;
            default:
                $query->orderBy('name', 'asc');
                break;
        }

        $perPage = $request->get('per_page', 12);
        $shops = $query->paginate($perPage);

        return view('buyer.shops.index', compact('shops'));
    }

    public function show(Request $request, Shop $shop)
    {
        // Build query for shop products
        $query = $shop->products()
            ->with(['defaultImage', 'hoverImage', 'shop', 'categories']);

        // Search functionality
        if ($request->filled('search')) {
            $query->where('name', 'ilike', '%' . $request->search . '%');
        }

        // Category filter
        if ($request->filled('category')) {
            $query->whereHas('categories', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Price range filter
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Sorting with stock priority
        switch ($request->get('sort', 'name')) {
            case 'price_low':
                $query->orderByRaw('CASE WHEN stock > 0 THEN 0 ELSE 1 END, price ASC');
                break;
            case 'price_high':
                $query->orderByRaw('CASE WHEN stock > 0 THEN 0 ELSE 1 END, price DESC');
                break;
            case 'rating':
                $query->orderByRaw('CASE WHEN stock > 0 THEN 0 ELSE 1 END, created_at DESC');
                break;
            case 'newest':
                $query->orderByRaw('CASE WHEN stock > 0 THEN 0 ELSE 1 END, created_at DESC');
                break;
            default:
                $query->orderByRaw('CASE WHEN stock > 0 THEN 0 ELSE 1 END, name ASC');
                break;
        }

        $perPage = $request->get('per_page', 15);
        $products = $query->paginate($perPage);

        // Get shop categories with product counts
        $categories = Category::whereHas('products', function($q) use ($shop) {
            $q->where('shop_id', $shop->id);
        })->withCount(['products' => function($q) use ($shop) {
            $q->where('shop_id', $shop->id);
        }])->get();

        // Get price range for filters
        $priceRange = $shop->products()
            ->selectRaw('MIN(final_price) as min_price, MAX(price) as max_price')
            ->first();

        // Load shop with logo
        $shop->load('media');

        // Calculate shop rating (we'll use average price as a placeholder)
        $avgRating = 4.2; // Default rating since we don't have rating column

        $socialLinks = $shop->social_links ? json_decode($shop->social_links, true) : [];

        // Prepare SEO data for shop page
        $seoData = [
            'title' => $shop->name . ' - Shop | ' . env('APP_NAME'),
            'description' => $shop->description ?: 
                            'Shop from ' . $shop->name . ' on ' . env('APP_NAME') . '. Discover quality products with great deals and reliable service.',
            'keywords' => $shop->name . ', shop, marketplace, products, ' . ($shop->categories ?? 'electronics, fashion, home garden'),
            'canonical' => request()->url(),
            'og_image' => $shop->media->first() ? asset('storage/' . $shop->media->first()->path) : asset('/assets/imgs/theme/logo.png'),
        ];

        return view('buyer.shops.show', compact('shop', 'products', 'categories', 'priceRange', 'avgRating','socialLinks', 'seoData'));
    }
}
