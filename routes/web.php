<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ShopController::class, 'index']);
Route::get('/products', [ProductController::class, 'index']);

Auth::routes();

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart', [CartController::class, 'add'])->name('cart.add');

Route::get('/home', [HomeController::class, 'index'])->name('home');




Route::get('/{product:slug}', [ProductController::class, 'show']);
