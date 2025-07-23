<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RobotsController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Route;

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
    
    // Address management routes
    Route::get('/me/addresses', [AddressController::class, 'index'])->name('addresses.index');
    Route::post('/addresses', [AddressController::class, 'store'])->name('addresses.store');
    Route::put('/addresses/{addressId}', [AddressController::class, 'update'])->name('addresses.update');
    Route::delete('/addresses/{addressId}', [AddressController::class, 'destroy'])->name('addresses.destroy');
    Route::post('/addresses/set-primary', [AddressController::class, 'setPrimary'])->name('addresses.setPrimary');
    Route::get('/api/addresses', [AddressController::class, 'getAddresses'])->name('api.addresses');

    Route::group(['prefix' => 'seller', 'middleware' => 'auth'], function () {
        // Dashboard
        Route::get('/dashboard', [SellerController::class, 'dashboard'])->name('seller.dashboard');
        
        // Product & SKU Management
        Route::group(['prefix' => 'products'], function () {
            Route::get('/', [SellerController::class, 'productsList'])->name('seller.products.index');
            Route::get('/create', [SellerController::class, 'productsCreate'])->name('seller.products.create');
            Route::post('/', [SellerController::class, 'productsStore'])->name('seller.products.store');
            Route::get('/{product}/edit', [SellerController::class, 'productsEdit'])->name('seller.products.edit');
            Route::put('/{product}', [SellerController::class, 'productsUpdate'])->name('seller.products.update');
            Route::delete('/{product}', [SellerController::class, 'productsDestroy'])->name('seller.products.destroy');
            Route::post('/{product}/variants', [SellerController::class, 'addVariant'])->name('seller.products.variants.store');
            Route::delete('/variants/{variant}', [SellerController::class, 'removeVariant'])->name('seller.products.variants.destroy');
        });
        
        // Category Management
        Route::group(['prefix' => 'categories'], function () {
            Route::get('/', [SellerController::class, 'categoriesList'])->name('seller.categories.index');
            Route::get('/create', [SellerController::class, 'categoriesCreate'])->name('seller.categories.create');
            Route::post('/', [SellerController::class, 'categoriesStore'])->name('seller.categories.store');
            Route::get('/{category}/edit', [SellerController::class, 'categoriesEdit'])->name('seller.categories.edit');
            Route::put('/{category}', [SellerController::class, 'categoriesUpdate'])->name('seller.categories.update');
            Route::delete('/{category}', [SellerController::class, 'categoriesDestroy'])->name('seller.categories.destroy');
        });
        
        // Bank Account Management
        Route::group(['prefix' => 'bank-accounts'], function () {
            Route::get('/', [SellerController::class, 'bankAccountsList'])->name('seller.bank-accounts.index');
            Route::get('/create', [SellerController::class, 'bankAccountsCreate'])->name('seller.bank-accounts.create');
            Route::post('/', [SellerController::class, 'bankAccountsStore'])->name('seller.bank-accounts.store');
            Route::get('/{account}/edit', [SellerController::class, 'bankAccountsEdit'])->name('seller.bank-accounts.edit');
            Route::put('/{account}', [SellerController::class, 'bankAccountsUpdate'])->name('seller.bank-accounts.update');
            Route::delete('/{account}', [SellerController::class, 'bankAccountsDestroy'])->name('seller.bank-accounts.destroy');
            Route::post('/{account}/set-primary', [SellerController::class, 'setPrimaryBankAccount'])->name('seller.bank-accounts.set-primary');
        });
        
        // Shipping Method Setup
        Route::group(['prefix' => 'shipping'], function () {
            Route::get('/', [SellerController::class, 'shippingList'])->name('seller.shipping.index');
            Route::get('/create', [SellerController::class, 'shippingCreate'])->name('seller.shipping.create');
            Route::post('/', [SellerController::class, 'shippingStore'])->name('seller.shipping.store');
            Route::get('/{shipping}/edit', [SellerController::class, 'shippingEdit'])->name('seller.shipping.edit');
            Route::put('/{shipping}', [SellerController::class, 'shippingUpdate'])->name('seller.shipping.update');
            Route::delete('/{shipping}', [SellerController::class, 'shippingDestroy'])->name('seller.shipping.destroy');
            Route::post('/{shipping}/toggle-status', [SellerController::class, 'toggleShippingStatus'])->name('seller.shipping.toggle-status');
        });
        
        // Wallet & Withdraw Flow
        Route::group(['prefix' => 'wallet'], function () {
            Route::get('/', [SellerController::class, 'walletDashboard'])->name('seller.wallet.index');
            Route::get('/transactions', [SellerController::class, 'walletTransactions'])->name('seller.wallet.transactions');
            Route::get('/withdraw', [SellerController::class, 'walletWithdrawForm'])->name('seller.wallet.withdraw.form');
            Route::post('/withdraw', [SellerController::class, 'walletWithdrawRequest'])->name('seller.wallet.withdraw.request');
            Route::get('/withdraw-history', [SellerController::class, 'walletWithdrawHistory'])->name('seller.wallet.withdraw.history');
            Route::get('/earnings', [SellerController::class, 'walletEarnings'])->name('seller.wallet.earnings');
        });
        
        // Shop Settings
        Route::group(['prefix' => 'shop'], function () {
            Route::get('/settings', [SellerController::class, 'shopSettings'])->name('seller.shop.settings');
            Route::put('/settings', [SellerController::class, 'shopSettingsUpdate'])->name('seller.shop.settings.update');
        });
        
        // Orders Management
        Route::group(['prefix' => 'orders'], function () {
            Route::get('/', [SellerController::class, 'ordersList'])->name('seller.orders.index');
            Route::get('/{order}', [SellerController::class, 'ordersShow'])->name('seller.orders.show');
            Route::put('/{order}/status', [SellerController::class, 'ordersUpdateStatus'])->name('seller.orders.update-status');
        });
    });

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
