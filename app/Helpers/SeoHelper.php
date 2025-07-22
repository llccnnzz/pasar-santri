<?php

namespace App\Helpers;

class SeoHelper
{
    /**
     * Generate SEO meta data for product pages
     */
    public static function generateProductSeo($product)
    {
        return [
            'title' => $product->name . ' - ' . $product->shop->name . ' | ' . env('APP_NAME'),
            'description' => $product->meta_description ?: 
                            strip_tags($product->long_description) ?: 
                            'Buy ' . $product->name . ' from ' . $product->shop->name . ' at best price.',
            'keywords' => $product->tags ? implode(', ', $product->tags) : '',
            'image' => $product->defaultImage ? $product->defaultImage->getFullUrl() : asset('/assets/imgs/theme/no-image.jpg'),
            'url' => request()->url(),
            'price' => $product->final_price,
            'currency' => 'IDR',
            'availability' => $product->stock > 0 ? 'InStock' : 'OutOfStock',
            'category' => $product->categories->pluck('name')->join(', '),
            'brand' => $product->shop->name,
            'sku' => $product->sku,
            'canonical' => request()->url(),
        ];
    }

    /**
     * Generate SEO meta data for shop pages
     */
    public static function generateShopSeo($shop)
    {
        return [
            'title' => $shop->name . ' - Shop | ' . env('APP_NAME'),
            'description' => $shop->description ?: 
                            'Shop from ' . $shop->name . ' on ' . env('APP_NAME') . '. Discover quality products with great deals and reliable service.',
            'keywords' => $shop->name . ', shop, marketplace, products, electronics, fashion, home garden',
            'canonical' => request()->url(),
            'og_image' => $shop->media->first() ? asset('storage/' . $shop->media->first()->path) : asset('/assets/imgs/theme/logo.png'),
        ];
    }

    /**
     * Generate SEO meta data for category pages
     */
    public static function generateCategorySeo($category)
    {
        return [
            'title' => $category->name . ' Products | ' . env('APP_NAME'),
            'description' => 'Browse ' . $category->name . ' products from trusted sellers. Find quality items at competitive prices with secure payment and fast shipping.',
            'keywords' => $category->name . ', products, marketplace, online shopping, deals',
            'canonical' => request()->url(),
        ];
    }

    /**
     * Generate SEO meta data for search results
     */
    public static function generateSearchSeo($query)
    {
        return [
            'title' => 'Search Results for "' . $query . '" | ' . env('APP_NAME'),
            'description' => 'Search results for "' . $query . '" on ' . env('APP_NAME') . '. Find the best products from trusted sellers.',
            'keywords' => $query . ', search, products, marketplace, online shopping',
            'canonical' => request()->url(),
            'robots' => 'noindex, follow', // Prevent indexing of search result pages
        ];
    }

    /**
     * Generate structured data for products
     */
    public static function generateProductStructuredData($product, $seoData)
    {
        return [
            '@context' => 'https://schema.org/',
            '@type' => 'Product',
            'name' => $product->name,
            'description' => $seoData['description'],
            'image' => $seoData['image'],
            'sku' => $seoData['sku'],
            'brand' => [
                '@type' => 'Brand',
                'name' => $seoData['brand']
            ],
            'category' => $seoData['category'],
            'offers' => [
                '@type' => 'Offer',
                'price' => $seoData['price'],
                'priceCurrency' => $seoData['currency'],
                'availability' => 'https://schema.org/' . $seoData['availability'],
                'seller' => [
                    '@type' => 'Organization',
                    'name' => $seoData['brand']
                ]
            ]
        ];
    }

    /**
     * Generate breadcrumb structured data
     */
    public static function generateBreadcrumbStructuredData($breadcrumbs)
    {
        $items = [];
        foreach ($breadcrumbs as $index => $breadcrumb) {
            $items[] = [
                '@type' => 'ListItem',
                'position' => $index + 1,
                'name' => $breadcrumb['name'],
                'item' => $breadcrumb['url']
            ];
        }

        return [
            '@context' => 'https://schema.org/',
            '@type' => 'BreadcrumbList',
            'itemListElement' => $items
        ];
    }

    /**
     * Clean text for SEO description
     */
    public static function cleanDescription($text, $maxLength = 155)
    {
        $text = strip_tags($text);
        $text = preg_replace('/\s+/', ' ', $text);
        $text = trim($text);
        
        if (strlen($text) > $maxLength) {
            $text = substr($text, 0, $maxLength - 3) . '...';
        }
        
        return $text;
    }

    /**
     * Generate keywords from text
     */
    public static function generateKeywords($text, $additionalKeywords = [])
    {
        $text = strtolower(strip_tags($text));
        $words = str_word_count($text, 1);
        $words = array_filter($words, function($word) {
            return strlen($word) > 3; // Only words longer than 3 characters
        });
        
        $keywords = array_merge($additionalKeywords, array_slice(array_unique($words), 0, 10));
        
        return implode(', ', $keywords);
    }
}
