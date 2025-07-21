<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index()
    {
        $sitemaps = [
            ['url' => route('sitemap.pages'), 'lastmod' => now()->format('Y-m-d')],
            ['url' => route('sitemap.products'), 'lastmod' => now()->format('Y-m-d')],
            ['url' => route('sitemap.shops'), 'lastmod' => now()->format('Y-m-d')],
            ['url' => route('sitemap.categories'), 'lastmod' => now()->format('Y-m-d')],
        ];

        $content = view('sitemap.index', compact('sitemaps'))->render();

        return response($content, 200)
            ->header('Content-Type', 'text/xml');
    }

    public function pages()
    {
        $urls = [
            [
                'url' => route('homepage'),
                'lastmod' => now()->format('Y-m-d'),
                'changefreq' => 'daily',
                'priority' => '1.0'
            ],
            [
                'url' => route('products.index'),
                'lastmod' => now()->format('Y-m-d'),
                'changefreq' => 'daily',
                'priority' => '0.9'
            ],
        ];

        $content = view('sitemap.urlset', compact('urls'))->render();

        return response($content, 200)
            ->header('Content-Type', 'text/xml');
    }

    public function products()
    {
        $products = Product::select(['slug', 'updated_at'])
            ->where('stock', '>', 0)
            ->orderBy('updated_at', 'desc')
            ->get();

        $urls = $products->map(function ($product) {
            return [
                'url' => url('/' . $product->slug),
                'lastmod' => $product->updated_at->format('Y-m-d'),
                'changefreq' => 'weekly',
                'priority' => '0.8'
            ];
        });

        $content = view('sitemap.urlset', compact('urls'))->render();

        return response($content, 200)
            ->header('Content-Type', 'text/xml');
    }

    public function shops()
    {
        $shops = Shop::select(['slug', 'updated_at'])
            ->where('is_open', true)
            ->orderBy('updated_at', 'desc')
            ->get();

        $urls = $shops->map(function ($shop) {
            return [
                'url' => url('/s/' . $shop->slug),
                'lastmod' => $shop->updated_at->format('Y-m-d'),
                'changefreq' => 'weekly',
                'priority' => '0.7'
            ];
        });

        $content = view('sitemap.urlset', compact('urls'))->render();

        return response($content, 200)
            ->header('Content-Type', 'text/xml');
    }

    public function categories()
    {
        $categories = Category::select(['slug', 'updated_at'])
            ->orderBy('updated_at', 'desc')
            ->get();

        $urls = $categories->map(function ($category) {
            return [
                'url' => url('/categories/' . $category->slug),
                'lastmod' => $category->updated_at->format('Y-m-d'),
                'changefreq' => 'weekly',
                'priority' => '0.6'
            ];
        });

        $content = view('sitemap.urlset', compact('urls'))->render();

        return response($content, 200)
            ->header('Content-Type', 'text/xml');
    }
}
