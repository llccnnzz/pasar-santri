<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ShopController::class, 'index']);
Route::get('/products', [ProductController::class, 'index']);

Auth::routes();

Route::get('/me', [HomeController::class, 'account'])->name('account');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart', [CartController::class, 'add'])->name('cart.add');
Route::delete('/cart/{product}', [CartController::class, 'remove'])->name('cart.remove');

Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
Route::post('/wishlist', [WishlistController::class, 'add'])->name('wishlist.add');
Route::delete('/wishlist/{product}', [WishlistController::class, 'remove'])->name('wishlist.remove');

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/s/{shops:slug}', [ShopController::class, 'show']);

Route::get('/{product:slug}', [ProductController::class, 'show']);
