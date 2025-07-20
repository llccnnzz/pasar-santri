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
                    ->limit(10)
                    ->get(),
                'popular' => Product::with(['defaultImage', 'hoverImage', 'shop'])
                    ->where('is_popular', true)
                    ->limit(8)
                    ->get(),
                'latest' => Product::with(['defaultImage', 'hoverImage', 'shop'])
                    ->latest()
                    ->limit(8)
                    ->get(),
                'categories' => Category::with('icon')
                    ->whereNull('parent_id')
                    ->limit(8)
                    ->get(),
                'categoryProducts' => Category::with(['products' => function($query) {
                        $query->with(['defaultImage', 'hoverImage', 'shop'])->limit(10);
                    }])
                    ->whereHas('products')
                    ->limit(5)
                    ->get(),
            ];
        });

        return view('welcome', $homepageData);
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

        return view('shops.index', compact('shops'));
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

        // Sorting
        switch ($request->get('sort', 'name')) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'rating':
                $query->orderBy('created_at', 'desc'); // Use created_at instead of rating
                break;
            case 'newest':
                $query->latest();
                break;
            default:
                $query->orderBy('name', 'asc');
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

        return view('buyer.shop', compact('shop', 'products', 'categories', 'priceRange', 'avgRating','socialLinks'));
    }
}
