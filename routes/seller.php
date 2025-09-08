<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Seller\KycController;
use App\Http\Controllers\Seller\OrderController;
use App\Http\Controllers\Seller\SellerController;
use App\Http\Controllers\Seller\WalletController;
use App\Http\Controllers\Seller\ProfileController;
use App\Http\Controllers\Seller\CategoryController;
use App\Http\Controllers\Seller\ShopBankController;
use App\Http\Controllers\Seller\InventoryController;

/*
|--------------------------------------------------------------------------
| Seller Routes
|--------------------------------------------------------------------------
|
| These routes handle all seller-related functionality including
| KYC, shop setup, product management, orders, and more.
|
*/

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
        // Dashboard (always accessible, even for suspended shops)
        Route::get('/dashboard', [SellerController::class, 'dashboard'])->name('seller.dashboard');
        Route::get('/dashboard/data', [SellerController::class, 'dashboardData'])->name('seller.dashboard.data');

        // Product & SKU Management (requires non-suspended shop)
        Route::group(['prefix' => 'products', 'middleware' => ['check.shop.suspension']], function () {
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

        // Category Management (requires non-suspended shop)
        Route::group(['prefix' => 'categories', 'middleware' => ['check.shop.suspension']], function () {
            Route::get('/', [CategoryController::class, 'index'])->name('seller.categories.index');
            Route::get('/create', [CategoryController::class, 'create'])->name('seller.categories.create');
            Route::post('/', [CategoryController::class, 'store'])->name('seller.categories.store');
            Route::get('/{category}', [CategoryController::class, 'show'])->name('seller.categories.show');
            Route::get('/{category}/edit', [CategoryController::class, 'edit'])->name('seller.categories.edit');
            Route::put('/{category}', [CategoryController::class, 'update'])->name('seller.categories.update');
            Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('seller.categories.destroy');
        });

        // Bank Account Management (requires non-suspended shop)
        Route::group(['prefix' => 'bank-accounts', 'middleware' => ['check.shop.suspension']], function () {
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

        // Shipping Method Setup (requires non-suspended shop)
        Route::group(['prefix' => 'shipping', 'middleware' => ['check.shop.suspension']], function () {
            Route::get('/', [SellerController::class, 'shippingList'])->name('seller.shipping.index');
            Route::post('/toggle', [SellerController::class, 'shippingToggle'])->name('seller.shipping.toggle');
            Route::post('/bulk-toggle', [SellerController::class, 'shippingBulkToggle'])->name('seller.shipping.bulk-toggle');
        });

        // Wallet & Withdraw Flow (requires non-suspended shop)
        Route::group(['prefix' => 'wallet', 'middleware' => ['check.shop.suspension']], function () {
            Route::get('/', [WalletController::class, 'index'])->name('seller.wallet.index');
            Route::get('/transactions', [WalletController::class, 'transactions'])->name('seller.wallet.transactions');
            Route::get('/withdraw', [WalletController::class, 'withdrawForm'])->name('seller.wallet.withdraw.form');
            Route::post('/withdraw', [WalletController::class, 'withdrawRequest'])->name('seller.wallet.withdraw.request');
            Route::get('/withdraw-history', [WalletController::class, 'withdrawHistory'])->name('seller.wallet.withdraw.history');
            Route::get('/earnings', [WalletController::class, 'earnings'])->name('seller.wallet.earnings');
            Route::get('/transaction/{id}', [WalletController::class, 'transactionDetails'])->name('seller.wallet.transaction.details');
        });

        // Shop Settings (require existing shop, requires non-suspended shop)
        Route::group(['prefix' => 'shop', 'middleware' => ['check.shop.suspension']], function () {
            Route::get('/settings', [SellerController::class, 'shopSettings'])->name('seller.shop.settings');
            Route::put('/settings', [SellerController::class, 'shopSettingsUpdate'])->name('seller.shop.settings.update');
        });

        // Orders Management (view orders allowed, but status updates restricted for suspended shops)
        Route::group(['prefix' => 'orders'], function () {
            Route::get('/', [OrderController::class, 'index'])->name('seller.orders.index');
            Route::get('/{order}', [OrderController::class, 'show'])->name('seller.orders.show');
            Route::put('/{order}/status', [OrderController::class, 'updateStatus'])->name('seller.orders.update-status')->middleware('check.shop.suspension');
        });

        // Profile Management (always accessible)
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
