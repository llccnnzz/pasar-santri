<?php

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
use App\Http\Controllers\Seller\KycController;
use App\Http\Controllers\Seller\SellerController;
use App\Http\Controllers\Seller\WalletController;
use App\Http\Controllers\Seller\ProfileController;
use App\Http\Controllers\Seller\CategoryController;
use App\Http\Controllers\Seller\ShopBankController;
use App\Http\Controllers\Seller\InventoryController;

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
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/checkout/debug-rates', [CheckoutController::class, 'debugRates']);

    // Address management routes
    Route::get('/me/addresses', [AddressController::class, 'index'])->name('addresses.index');
    Route::post('/addresses', [AddressController::class, 'store'])->name('addresses.store');
    Route::put('/addresses/{addressId}', [AddressController::class, 'update'])->name('addresses.update');
    Route::delete('/addresses/{addressId}', [AddressController::class, 'destroy'])->name('addresses.destroy');
    Route::post('/addresses/set-primary', [AddressController::class, 'setPrimary'])->name('addresses.setPrimary');
    Route::get('/api/addresses', [AddressController::class, 'getAddresses'])->name('api.addresses');

    Route::group(['prefix' => 'seller', 'middleware' => ['auth']], function () {
        // KYC Management (no middleware required, but required before shop setup)
        Route::group(['prefix' => 'kyc'], function () {
            Route::get('/', [KycController::class, 'index'])->name('kyc.index');
            Route::get('/create', [KycController::class, 'create'])->name('kyc.create');
            Route::post('/', [KycController::class, 'store'])->name('kyc.store');
            Route::get('/{kyc}', [KycController::class, 'show'])->name('kyc.show');
            Route::get('/{kyc}/reapply', [KycController::class, 'reapply'])->name('kyc.reapply');
            Route::put('/{kyc}/reapply', [KycController::class, 'updateReapplication'])->name('kyc.update-reapplication');
        });

        // Shop Setup (requires approved KYC)
        Route::group(['prefix' => 'shop', 'middleware' => ['has.approved.kyc']], function () {
            Route::get('/setup', [SellerController::class, 'shopSetup'])->name('seller.shop.setup');
            Route::post('/setup', [SellerController::class, 'shopSetupStore'])->name('seller.shop.setup.store');
        });

        // All other seller routes require shop
        Route::group(['middleware' => ['has.shop']], function () {
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
                Route::get('/', [ShopBankController::class, 'index'])->name('seller.bank-accounts.index');
                Route::get('/create', [ShopBankController::class, 'create'])->name('seller.bank-accounts.create');
                Route::post('/', [ShopBankController::class, 'store'])->name('seller.bank-accounts.store');
                Route::get('/{bankAccount}', [ShopBankController::class, 'show'])->name('seller.bank-accounts.show');
                Route::get('/{bankAccount}/edit', [ShopBankController::class, 'edit'])->name('seller.bank-accounts.edit');
                Route::put('/{bankAccount}', [ShopBankController::class, 'update'])->name('seller.bank-accounts.update');
                Route::delete('/{bankAccount}', [ShopBankController::class, 'destroy'])->name('seller.bank-accounts.destroy');
                Route::post('/{bankAccount}/set-primary', [ShopBankController::class, 'setPrimary'])->name('seller.bank-accounts.set-primary');
            });

            // Test View Route for Development
            Route::get('/test-view', function () {
                return view('seller.test-view');
            })->name('seller.test-view');

            // Shipping Method Setup
            Route::group(['prefix' => 'shipping'], function () {
                Route::get('/', [SellerController::class, 'shippingList'])->name('seller.shipping.index');
                // Route::post('/', [SellerController::class, 'shippingStore'])->name('seller.shipping.store');
                Route::post('/toggle', [SellerController::class, 'shippingToggle'])->name('seller.shipping.toggle');
                // Route::get('/{shipping}/edit', [SellerController::class, 'shippingEdit'])->name('seller.shipping.edit');
                // Route::put('/{shipping}', [SellerController::class, 'shippingUpdate'])->name('seller.shipping.update');
                Route::delete('/{shipping}', [SellerController::class, 'shippingDestroy'])->name('seller.shipping.destroy');
                Route::get('/test-biteship', [SellerController::class, 'testBiteship']);

                // Route::post('/{shipping}/toggle-status', [SellerController::class, 'toggleShippingStatus'])->name('seller.shipping.toggle-status');
            });

            // Wallet & Withdraw Flow
            Route::group(['prefix' => 'wallet'], function () {
                Route::get('/', [WalletController::class, 'index'])->name('seller.wallet.index');
                Route::get('/transactions', [WalletController::class, 'transactions'])->name('seller.wallet.transactions');
                Route::get('/withdraw', [WalletController::class, 'withdrawForm'])->name('seller.wallet.withdraw.form');
                Route::post('/withdraw', [WalletController::class, 'withdrawRequest'])->name('seller.wallet.withdraw.request');
                Route::get('/withdraw-history', [WalletController::class, 'withdrawHistory'])->name('seller.wallet.withdraw.history');
                Route::get('/earnings', [WalletController::class, 'earnings'])->name('seller.wallet.earnings');
                Route::get('/transaction/{id}', [WalletController::class, 'transactionDetails'])->name('seller.wallet.transaction.details');
            });

            // Shop Settings (require existing shop)
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

            // Profile Management
            Route::group(['prefix' => 'profile'], function () {
                Route::get('/', [ProfileController::class, 'index'])->name('seller.profile.index');
                Route::get('/edit', [ProfileController::class, 'edit'])->name('seller.profile.edit');
                Route::put('/update', [ProfileController::class, 'update'])->name('seller.profile.update');
                Route::get('/security', [ProfileController::class, 'security'])->name('seller.profile.security');
                Route::put('/password', [ProfileController::class, 'updatePassword'])->name('seller.profile.password.update');
                Route::get('/withdrawal-pin', [ProfileController::class, 'withdrawalPin'])->name('seller.profile.withdrawal-pin');
                Route::put('/withdrawal-pin', [ProfileController::class, 'updateWithdrawalPin'])->name('seller.profile.withdrawal-pin.update');
                Route::post('/verify-pin', [ProfileController::class, 'verifyPin'])->name('seller.profile.verify-pin');
            });
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
