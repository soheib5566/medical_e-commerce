<?php

use App\Http\Controllers\Website\CartController;
use App\Http\Controllers\Website\OrderController;
use App\Http\Controllers\Website\ProductController;
use Illuminate\Support\Facades\Route;


// Home page
Route::get(('/'), action: [ProductController::class, 'index'])->name('website.products.index');
Route::post('/products/{product}/cart', [ProductController::class, 'store'])
    ->name('website.products.cart.store');

// cart routes
Route::get('/cart', [CartController::class, 'index'])->name('website.cart.index');
Route::get('/cart/count', [CartController::class, 'count'])->name('website.cart.count');
Route::put('/cart/{product}', [CartController::class, 'update'])->name('website.cart.update');
Route::delete('/cart/{product}', [CartController::class, 'destroy'])->name('website.cart.destroy');

// Order Routes
Route::get('/checkout', [OrderController::class, 'create'])->name('website.checkout.create');
Route::post('/checkout', [OrderController::class, 'store'])->name('website.checkout.store');
Route::get('/orders/{order}', [OrderController::class, 'show'])->name('website.orders.show');
