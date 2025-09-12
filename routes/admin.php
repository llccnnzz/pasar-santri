<?php

use App\Http\Controllers\Admin\AdminAdsController;
use App\Http\Controllers\Admin\AdminBannerController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminKycController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminPromoController;
use App\Http\Controllers\Admin\AdminSellerController;
use App\Http\Controllers\Admin\AdminServiceFeeController;
use App\Http\Controllers\Admin\AdminShippingController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| These routes handle all admin functionality including dashboard,
| seller management, KYC, products, orders, and system settings.
|
*/

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'role:admin']], function () {

    // Admin Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.index');
    Route::get('/profile', [AdminController::class, 'profile'])->name('admin.profile');
    Route::get('/notifications/{type}', [NotificationController::class, 'index'])->name('admin.notifications.index');
    Route::post('/notifications/{id}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('admin.notifications.markAsRead');

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

        Route::post('/{user}/suspend-shop', [AdminSellerController::class, 'suspendShop'])
            ->middleware('can:admin-dashboard|update seller')
            ->name('admin.sellers.suspend-shop');

        Route::post('/{user}/unsuspend-shop', [AdminSellerController::class, 'unsuspendShop'])
            ->middleware('can:admin-dashboard|update seller')
            ->name('admin.sellers.unsuspend-shop');
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

        Route::put('/payment/{order}/{status}', [AdminOrderController::class, 'bypassPayment'])
            ->middleware('can:admin-dashboard|update order')
            ->name('admin.orders.bypass-payment');

        Route::put('/payment/bulk-bypass-payment', [AdminOrderController::class, 'bulkBypassPayments'])
            ->middleware('can:admin-dashboard|update order')
            ->name('admin.orders.bulk-bypass-payment');

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

        Route::put('/{banner}', [AdminBannerController::class, 'update'])
            ->middleware('can:admin-dashboard|update banner')
            ->name('admin.banners.update');
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

        Route::post('/bulk-action', [AdminAdsController::class, 'bulkAction'])
            ->middleware('can:admin-dashboard|update ads')
            ->name('admin.ads.bulk-action');

        Route::get('/auto-suggestions/{category}', [AdminAdsController::class, 'autoSuggestions'])
            ->middleware('can:admin-dashboard|index ads')
            ->name('admin.ads.auto-suggestions');

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
    });

    // ===================================================================
    // SERVICE FEE MANAGEMENT
    // ===================================================================
    Route::group(['prefix' => 'service-fees'], function () {
        Route::get('/', [AdminServiceFeeController::class, 'index'])
            ->middleware('can:admin-dashboard|index service fee')
            ->name('admin.service-fees.index');

        Route::put('/{serviceFee}', [AdminServiceFeeController::class, 'update'])
            ->middleware('can:admin-dashboard|update service fee')
            ->name('admin.service-fees.update');
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
