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
use App\Http\Controllers\Seller\KycController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Seller\OrderController;
use App\Http\Controllers\Seller\SellerController;
use App\Http\Controllers\Seller\WalletController;
use App\Http\Controllers\Admin\AdminAdsController;

// Admin Controllers
use App\Http\Controllers\Admin\AdminKycController;
use App\Http\Controllers\Seller\ProfileController;
use App\Http\Controllers\Seller\CategoryController;
use App\Http\Controllers\Seller\ShopBankController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminPromoController;
use App\Http\Controllers\Seller\InventoryController;
use App\Http\Controllers\Admin\AdminBannerController;
use App\Http\Controllers\Admin\AdminSellerController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminShippingController;
use App\Http\Controllers\Admin\AdminServiceFeeController;

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
                Route::get('/', [OrderController::class, 'index'])->name('seller.orders.index');
                Route::get('/{order}', [OrderController::class, 'show'])->name('seller.orders.show');
                Route::put('/{order}/status', [OrderController::class, 'updateStatus'])->name('seller.orders.update-status');
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

    // ===================================================================
    // ADMIN ROUTES - Requires Authentication + Admin Role
    // ===================================================================
    Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'role:admin']], function () {

        // Admin Dashboard
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/', [AdminController::class, 'dashboard'])->name('admin.index');
        Route::get('/profile', [AdminController::class, 'profile'])->name('admin.profile');

        // ===================================================================
        // SELLER MANAGEMENT
        // ===================================================================
        Route::group(['prefix' => 'sellers'], function () {
            Route::get('/', [AdminSellerController::class, 'index'])
                ->middleware('can:admin-dashboard|index seller')
                ->name('admin.sellers.index');

            Route::get('/{user}', [AdminSellerController::class, 'show'])
                ->middleware('can:admin-dashboard|show seller')
                ->name('admin.sellers.show');

            Route::put('/{user}', [AdminSellerController::class, 'update'])
                ->middleware('can:admin-dashboard|update seller')
                ->name('admin.sellers.update');

            Route::post('/{user}/toggle-status', [AdminSellerController::class, 'toggleStatus'])
                ->middleware('can:admin-dashboard|update seller')
                ->name('admin.sellers.toggle-status');

            Route::get('/{user}/shop', [AdminSellerController::class, 'showShop'])
                ->middleware('can:admin-dashboard|show seller')
                ->name('admin.sellers.shop');
        });

        // ===================================================================
        // KYC MANAGEMENT
        // ===================================================================
        Route::group(['prefix' => 'kyc'], function () {
            Route::get('/', [AdminKycController::class, 'index'])
                ->middleware('can:admin-dashboard|index kyc')
                ->name('admin.kyc.index');

            Route::get('/pending-count', [AdminKycController::class, 'pendingCount'])
                ->middleware('can:admin-dashboard|index kyc')
                ->name('admin.kyc.pending-count');

            Route::post('/bulk-action', [AdminKycController::class, 'bulkAction'])
                ->middleware('can:admin-dashboard|update kyc')
                ->name('admin.kyc.bulk-action');

            Route::get('/{kycApplication}', [AdminKycController::class, 'show'])
                ->middleware('can:admin-dashboard|show kyc')
                ->name('admin.kyc.show');

            Route::post('/{kycApplication}/approve', [AdminKycController::class, 'approve'])
                ->middleware('can:admin-dashboard|update kyc')
                ->name('admin.kyc.approve');

            Route::post('/{kycApplication}/reject', [AdminKycController::class, 'reject'])
                ->middleware('can:admin-dashboard|update kyc')
                ->name('admin.kyc.reject');

        });

        // ===================================================================
        // PRODUCT MANAGEMENT
        // ===================================================================
        Route::group(['prefix' => 'products'], function () {
            Route::get('/', [AdminProductController::class, 'index'])
                ->middleware('can:admin-dashboard|index product')
                ->name('admin.products.index');

            Route::get('/{product}', [AdminProductController::class, 'show'])
                ->middleware('can:admin-dashboard|show product')
                ->name('admin.products.show');

            Route::put('/{product}', [AdminProductController::class, 'update'])
                ->middleware('can:admin-dashboard|update product')
                ->name('admin.products.update');

            Route::post('/{product}/toggle-featured', [AdminProductController::class, 'toggleFeatured'])
                ->middleware('can:admin-dashboard|update product')
                ->name('admin.products.toggle-featured');

            Route::post('/{product}/toggle-popular', [AdminProductController::class, 'togglePopular'])
                ->middleware('can:admin-dashboard|update product')
                ->name('admin.products.toggle-popular');

            Route::post('/bulk-action', [AdminProductController::class, 'bulkAction'])
                ->middleware('can:admin-dashboard|update product')
                ->name('admin.products.bulk-action');
        });

        // ===================================================================
        // ORDER MANAGEMENT
        // ===================================================================
        Route::group(['prefix' => 'orders'], function () {
            Route::get('/', [AdminOrderController::class, 'index'])
                ->middleware('can:admin-dashboard|index order')
                ->name('admin.orders.index');

            Route::get('/{order}', [AdminOrderController::class, 'show'])
                ->middleware('can:admin-dashboard|show order')
                ->name('admin.orders.show');

            Route::put('/{order}', [AdminOrderController::class, 'update'])
                ->middleware('can:admin-dashboard|update order')
                ->name('admin.orders.update');

            Route::post('/{order}/refund', [AdminOrderController::class, 'processRefund'])
                ->middleware('can:admin-dashboard|update order')
                ->name('admin.orders.refund');

            Route::get('/analytics/dashboard', [AdminOrderController::class, 'analytics'])
                ->middleware('can:admin-dashboard|show order')
                ->name('admin.orders.analytics');
        });

        // ===================================================================
        // SHIPPING METHOD MANAGEMENT
        // ===================================================================
        Route::group(['prefix' => 'shipping-methods'], function () {
            Route::get('/', [AdminShippingController::class, 'index'])
                ->middleware('can:admin-dashboard|index shipping method')
                ->name('admin.shipping.index');

            Route::get('/{shippingMethod}', [AdminShippingController::class, 'show'])
                ->middleware('can:admin-dashboard|show shipping method')
                ->name('admin.shipping.show');

            Route::post('/{shippingMethod}/toggle-status', [AdminShippingController::class, 'toggleStatus'])
                ->middleware('can:admin-dashboard|update shipping method')
                ->name('admin.shipping.toggle-status');

            Route::post('/courier/{courierCode}/toggle-status', [AdminShippingController::class, 'toggleCourierStatus'])
                ->middleware('can:admin-dashboard|update shipping method')
                ->name('admin.shipping.toggle-courier-status');

            Route::post('/sync-from-api', [AdminShippingController::class, 'syncFromApi'])
                ->middleware('can:admin-dashboard|create shipping method')
                ->name('admin.shipping.sync-api');
        });

        // ===================================================================
        // BANNER MANAGEMENT
        // ===================================================================
        Route::group(['prefix' => 'banners'], function () {
            Route::get('/', [AdminBannerController::class, 'index'])
                ->middleware('can:admin-dashboard|index banner')
                ->name('admin.banners.index');

            Route::get('/create', [AdminBannerController::class, 'create'])
                ->middleware('can:admin-dashboard|create banner')
                ->name('admin.banners.create');

            Route::post('/', [AdminBannerController::class, 'store'])
                ->middleware('can:admin-dashboard|create banner')
                ->name('admin.banners.store');

            Route::get('/{banner}', [AdminBannerController::class, 'show'])
                ->middleware('can:admin-dashboard|show banner')
                ->name('admin.banners.show');

            Route::get('/{banner}/edit', [AdminBannerController::class, 'edit'])
                ->middleware('can:admin-dashboard|update banner')
                ->name('admin.banners.edit');

            Route::put('/{banner}', [AdminBannerController::class, 'update'])
                ->middleware('can:admin-dashboard|update banner')
                ->name('admin.banners.update');

            Route::delete('/{banner}', [AdminBannerController::class, 'destroy'])
                ->middleware('can:admin-dashboard|delete banner')
                ->name('admin.banners.destroy');

            Route::post('/{banner}/toggle-status', [AdminBannerController::class, 'toggleStatus'])
                ->middleware('can:admin-dashboard|update banner')
                ->name('admin.banners.toggle-status');

            Route::post('/reorder', [AdminBannerController::class, 'reorder'])
                ->middleware('can:admin-dashboard|update banner')
                ->name('admin.banners.reorder');

            Route::get('/{banner}/analytics', [AdminBannerController::class, 'analytics'])
                ->middleware('can:admin-dashboard|show banner')
                ->name('admin.banners.analytics');
        });

        // ===================================================================
        // PRODUCT ADS MANAGEMENT
        // ===================================================================
        Route::group(['prefix' => 'ads'], function () {
            Route::get('/', [AdminAdsController::class, 'index'])
                ->middleware('can:admin-dashboard|index ads')
                ->name('admin.ads.index');

            Route::get('/create', [AdminAdsController::class, 'create'])
                ->middleware('can:admin-dashboard|create ads')
                ->name('admin.ads.create');

            Route::post('/', [AdminAdsController::class, 'store'])
                ->middleware('can:admin-dashboard|create ads')
                ->name('admin.ads.store');

            Route::get('/{productAd}', [AdminAdsController::class, 'show'])
                ->middleware('can:admin-dashboard|show ads')
                ->name('admin.ads.show');

            Route::get('/{productAd}/edit', [AdminAdsController::class, 'edit'])
                ->middleware('can:admin-dashboard|update ads')
                ->name('admin.ads.edit');

            Route::put('/{productAd}', [AdminAdsController::class, 'update'])
                ->middleware('can:admin-dashboard|update ads')
                ->name('admin.ads.update');

            Route::delete('/{productAd}', [AdminAdsController::class, 'destroy'])
                ->middleware('can:admin-dashboard|delete ads')
                ->name('admin.ads.destroy');

            Route::post('/{productAd}/approve', [AdminAdsController::class, 'approve'])
                ->middleware('can:admin-dashboard|update ads')
                ->name('admin.ads.approve');

            Route::post('/{productAd}/reject', [AdminAdsController::class, 'reject'])
                ->middleware('can:admin-dashboard|update ads')
                ->name('admin.ads.reject');

            Route::post('/{productAd}/pause', [AdminAdsController::class, 'pause'])
                ->middleware('can:admin-dashboard|update ads')
                ->name('admin.ads.pause');

            Route::post('/{productAd}/resume', [AdminAdsController::class, 'resume'])
                ->middleware('can:admin-dashboard|update ads')
                ->name('admin.ads.resume');

            Route::get('/analytics/dashboard', [AdminAdsController::class, 'analytics'])
                ->middleware('can:admin-dashboard|show ads')
                ->name('admin.ads.analytics');

            Route::get('/revenue/report', [AdminAdsController::class, 'revenueReport'])
                ->middleware('can:admin-dashboard|show ads')
                ->name('admin.ads.revenue-report');
        });

        // ===================================================================
        // PROMO MANAGEMENT
        // ===================================================================
        Route::group(['prefix' => 'promos'], function () {
            Route::get('/', [AdminPromoController::class, 'index'])
                ->middleware('can:admin-dashboard|index promo')
                ->name('admin.promos.index');

            Route::get('/create', [AdminPromoController::class, 'create'])
                ->middleware('can:admin-dashboard|create promo')
                ->name('admin.promos.create');

            Route::post('/', [AdminPromoController::class, 'store'])
                ->middleware('can:admin-dashboard|create promo')
                ->name('admin.promos.store');

            Route::get('/{promotion}', [AdminPromoController::class, 'show'])
                ->middleware('can:admin-dashboard|show promo')
                ->name('admin.promos.show');

            Route::get('/{promotion}/edit', [AdminPromoController::class, 'edit'])
                ->middleware('can:admin-dashboard|update promo')
                ->name('admin.promos.edit');

            Route::put('/{promotion}', [AdminPromoController::class, 'update'])
                ->middleware('can:admin-dashboard|update promo')
                ->name('admin.promos.update');

            Route::delete('/{promotion}', [AdminPromoController::class, 'destroy'])
                ->middleware('can:admin-dashboard|delete promo')
                ->name('admin.promos.destroy');

            Route::post('/{promotion}/toggle-status', [AdminPromoController::class, 'toggleStatus'])
                ->middleware('can:admin-dashboard|update promo')
                ->name('admin.promos.toggle-status');

            Route::get('/{promotion}/usage-report', [AdminPromoController::class, 'usageReport'])
                ->middleware('can:admin-dashboard|show promo')
                ->name('admin.promos.usage-report');

            Route::post('/generate-code', [AdminPromoController::class, 'generateCode'])
                ->middleware('can:admin-dashboard|create promo')
                ->name('admin.promos.generate-code');
        });

        // ===================================================================
        // SERVICE FEE MANAGEMENT
        // ===================================================================
        Route::group(['prefix' => 'service-fees'], function () {
            Route::get('/', [AdminServiceFeeController::class, 'index'])
                ->middleware('can:admin-dashboard|index service fee')
                ->name('admin.service-fees.index');

            Route::get('/create', [AdminServiceFeeController::class, 'create'])
                ->middleware('can:admin-dashboard|create service fee')
                ->name('admin.service-fees.create');

            Route::post('/', [AdminServiceFeeController::class, 'store'])
                ->middleware('can:admin-dashboard|create service fee')
                ->name('admin.service-fees.store');

            Route::get('/{serviceFee}', [AdminServiceFeeController::class, 'show'])
                ->middleware('can:admin-dashboard|show service fee')
                ->name('admin.service-fees.show');

            Route::get('/{serviceFee}/edit', [AdminServiceFeeController::class, 'edit'])
                ->middleware('can:admin-dashboard|update service fee')
                ->name('admin.service-fees.edit');

            Route::put('/{serviceFee}', [AdminServiceFeeController::class, 'update'])
                ->middleware('can:admin-dashboard|update service fee')
                ->name('admin.service-fees.update');

            Route::delete('/{serviceFee}', [AdminServiceFeeController::class, 'destroy'])
                ->middleware('can:admin-dashboard|delete service fee')
                ->name('admin.service-fees.destroy');

            Route::post('/{serviceFee}/toggle-status', [AdminServiceFeeController::class, 'toggleStatus'])
                ->middleware('can:admin-dashboard|update service fee')
                ->name('admin.service-fees.toggle-status');

            Route::get('/calculator/test', [AdminServiceFeeController::class, 'testCalculator'])
                ->middleware('can:admin-dashboard|show service fee')
                ->name('admin.service-fees.test-calculator');

            Route::get('/revenue/report', [AdminServiceFeeController::class, 'revenueReport'])
                ->middleware('can:admin-dashboard|show service fee')
                ->name('admin.service-fees.revenue-report');
        });

        // ===================================================================
        // ANALYTICS & REPORTS
        // ===================================================================
        Route::group(['prefix' => 'analytics'], function () {
            Route::get('/dashboard', [AdminController::class, 'analyticsDashboard'])
                ->middleware('can:admin-dashboard|show analytics')
                ->name('admin.analytics.dashboard');

            Route::get('/sales', [AdminController::class, 'salesAnalytics'])
                ->middleware('can:admin-dashboard|show analytics')
                ->name('admin.analytics.sales');

            Route::get('/users', [AdminController::class, 'userAnalytics'])
                ->middleware('can:admin-dashboard|show analytics')
                ->name('admin.analytics.users');

            Route::get('/revenue', [AdminController::class, 'revenueAnalytics'])
                ->middleware('can:admin-dashboard|show analytics')
                ->name('admin.analytics.revenue');
        });

        // ===================================================================
        // SYSTEM SETTINGS
        // ===================================================================
        Route::group(['prefix' => 'settings'], function () {
            Route::get('/', [AdminController::class, 'settings'])
                ->middleware('can:admin-dashboard|show settings')
                ->name('admin.settings.index');

            Route::put('/update', [AdminController::class, 'updateSettings'])
                ->middleware('can:admin-dashboard|update settings')
                ->name('admin.settings.update');

            Route::get('/cache/clear', [AdminController::class, 'clearCache'])
                ->middleware('can:admin-dashboard|update settings')
                ->name('admin.settings.clear-cache');
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
