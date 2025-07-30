<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RobotsController;
use App\Http\Controllers\Seller\CategoryController;
use App\Http\Controllers\Seller\InventoryController;
use App\Http\Controllers\Seller\SellerController;
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
            Route::get('/', [InventoryController::class, 'index'])->name('seller.products.index');
            Route::get('/create', [InventoryController::class, 'create'])->name('seller.products.create');
            Route::post('/', [InventoryController::class, 'store'])->name('seller.products.store');
            Route::get('/{product}', [InventoryController::class, 'show'])->name('seller.products.show');
            Route::get('/{product}/edit', [InventoryController::class, 'edit'])->name('seller.products.edit');
            Route::put('/{product}', [InventoryController::class, 'update'])->name('seller.products.update');
            Route::delete('/{product}', [InventoryController::class, 'destroy'])->name('seller.products.destroy');
            Route::post('/{product}/variants', [InventoryController::class, 'addVariant'])->name('seller.products.variants.store');
            Route::delete('/variants/{variant}', [InventoryController::class, 'removeVariant'])->name('seller.products.variants.destroy');
            Route::post('/bulk-status-update', [InventoryController::class, 'bulkStatusUpdate'])->name('seller.products.bulk-status-update');
            Route::post('/bulk-delete', [InventoryController::class, 'bulkDelete'])->name('seller.products.bulk-delete');
        });
        
        // Category Management
        Route::group(['prefix' => 'categories'], function () {
            Route::get('/', [CategoryController::class, 'index'])->name('seller.categories.index');
            Route::get('/create', [CategoryController::class, 'create'])->name('seller.categories.create');
            Route::post('/', [CategoryController::class, 'store'])->name('seller.categories.store');
            Route::get('/{category}', [CategoryController::class, 'show'])->name('seller.categories.show');
            Route::get('/{category}/edit', [CategoryController::class, 'edit'])->name('seller.categories.edit');
            Route::put('/{category}', [CategoryController::class, 'update'])->name('seller.categories.update');
            Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('seller.categories.destroy');
        });
        
        // Bank Account Management
        Route::group(['prefix' => 'bank-accounts'], function () {
            Route::get('/', [App\Http\Controllers\Seller\ShopBankController::class, 'index'])->name('seller.bank-accounts.index');
            Route::get('/create', [App\Http\Controllers\Seller\ShopBankController::class, 'create'])->name('seller.bank-accounts.create');
            Route::post('/', [App\Http\Controllers\Seller\ShopBankController::class, 'store'])->name('seller.bank-accounts.store');
            Route::get('/{bankAccount}', [App\Http\Controllers\Seller\ShopBankController::class, 'show'])->name('seller.bank-accounts.show');
            Route::get('/{bankAccount}/edit', [App\Http\Controllers\Seller\ShopBankController::class, 'edit'])->name('seller.bank-accounts.edit');
            Route::put('/{bankAccount}', [App\Http\Controllers\Seller\ShopBankController::class, 'update'])->name('seller.bank-accounts.update');
            Route::delete('/{bankAccount}', [App\Http\Controllers\Seller\ShopBankController::class, 'destroy'])->name('seller.bank-accounts.destroy');
            Route::post('/{bankAccount}/set-primary', [App\Http\Controllers\Seller\ShopBankController::class, 'setPrimary'])->name('seller.bank-accounts.set-primary');
        });

        // Test View Route for Development
        Route::get('/test-view', function () {
            return view('seller.test-view');
        })->name('seller.test-view');
        
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
            Route::get('/', [App\Http\Controllers\Seller\WalletController::class, 'index'])->name('seller.wallet.index');
            Route::get('/transactions', [App\Http\Controllers\Seller\WalletController::class, 'transactions'])->name('seller.wallet.transactions');
            Route::get('/withdraw', [App\Http\Controllers\Seller\WalletController::class, 'withdrawForm'])->name('seller.wallet.withdraw.form');
            Route::post('/withdraw', [App\Http\Controllers\Seller\WalletController::class, 'withdrawRequest'])->name('seller.wallet.withdraw.request');
            Route::get('/withdraw-history', [App\Http\Controllers\Seller\WalletController::class, 'withdrawHistory'])->name('seller.wallet.withdraw.history');
            Route::get('/earnings', [App\Http\Controllers\Seller\WalletController::class, 'earnings'])->name('seller.wallet.earnings');
            Route::get('/transaction/{id}', [App\Http\Controllers\Seller\WalletController::class, 'transactionDetails'])->name('seller.wallet.transaction.details');
        });
        
        // Shop Settings
        Route::group(['prefix' => 'shop'], function () {
            Route::get('/setup', [SellerController::class, 'shopSetup'])->name('seller.shop.setup');
            Route::post('/setup', [SellerController::class, 'shopSetupStore'])->name('seller.shop.setup.store');
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
