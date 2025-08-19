<?php

namespace App\Providers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\KycApplication;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Shop;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        Route::bind('shop', function (string $slug) {
            return Shop::whereSlug(Str::lower($slug))->first();
        });
        Route::bind('product', function (string $slug) {
            return Product::whereSlug(Str::lower($slug))->first();
        });

        Relation::enforceMorphMap([
            'cart' => Cart::class,
            'category' => Category::class,
            'product' => Product::class,
            'product_variant' => ProductVariant::class,
            'shop' => Shop::class,
            'user' => User::class,
            'wishlist' => Wishlist::class,
            'kyc_application' => KycApplication::class,
        ]);
    }
}
