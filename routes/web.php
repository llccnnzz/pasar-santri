<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\RobotsController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\BuyerOrderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [ShopController::class, 'index'])->name('homepage');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/shops', [ShopController::class, 'list']);

Auth::routes();

Route::middleware('auth')->group(function () {
    // Account management routes
    Route::get('/me', [HomeController::class, 'account'])->name('account');

    // Cart management routes
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/cart/{productId}', [CartController::class, 'remove'])->name('cart.remove');
    Route::patch('/cart/{productId}/update-quantity', [CartController::class, 'updateQuantity'])->name('cart.updateQuantity');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

    // Wishlist management routes
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist', [WishlistController::class, 'add'])->name('wishlist.add');
    Route::delete('/wishlist/{productId}', [WishlistController::class, 'remove'])->name('wishlist.remove');

    // Checkout management routes
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/shipping-methods', [CheckoutController::class, 'getShippingMethods'])->name('checkout.shippingMethods');
    Route::post('/checkout/rates', [CheckoutController::class, 'rates'])->name('checkout.rates');
    Route::post('/checkout/apply-promo', [CheckoutController::class, 'applyPromoCode'])->name('checkout.applyPromo');
    Route::post('/checkout/remove-promo', [CheckoutController::class, 'removePromoCode'])->name('checkout.removePromo');
    Route::get('/checkout/current-promo', [CheckoutController::class, 'getCurrentPromo'])->name('checkout.currentPromo');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');

    // Orders management routes
    Route::get('/me/orders', [BuyerOrderController::class, 'index'])->name('orders.index');
    Route::get('/me/orders/{order}', [BuyerOrderController::class, 'show'])->name('orders.show');

    // Address management routes
    Route::get('/me/addresses', [AddressController::class, 'index'])->name('addresses.index');
    Route::post('/addresses', [AddressController::class, 'store'])->name('addresses.store');
    Route::put('/addresses/{addressId}', [AddressController::class, 'update'])->name('addresses.update');
    Route::delete('/addresses/{addressId}', [AddressController::class, 'destroy'])->name('addresses.destroy');
    Route::post('/addresses/set-primary', [AddressController::class, 'setPrimary'])->name('addresses.setPrimary');
    Route::get('/api/addresses', [AddressController::class, 'getAddresses'])->name('api.addresses');

});

Route::get('/home', [HomeController::class, 'index'])->name('home');

// Sitemap routes
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap.index');
Route::get('/sitemap-pages.xml', [SitemapController::class, 'pages'])->name('sitemap.pages');
Route::get('/sitemap-products.xml', [SitemapController::class, 'products'])->name('sitemap.products');
Route::get('/sitemap-shops.xml', [SitemapController::class, 'shops'])->name('sitemap.shops');
Route::get('/sitemap-categories.xml', [SitemapController::class, 'categories'])->name('sitemap.categories');

// Robots.txt route
Route::get('/robots.txt', [RobotsController::class, 'robots'])->name('robots');

Route::get('/s/{shop}', [ShopController::class, 'show']);

Route::get('/{product}', [ProductController::class, 'show']);
