<?php

use App\Http\Controllers\website\CartController;
use App\Http\Controllers\website\OrderController;
use App\Http\Controllers\website\ProductController;
use Illuminate\Support\Facades\Route;



Route::get(('/'), action: [ProductController::class, 'index'])->name('website.products.index');

// cart routes
Route::get('/cart', [CartController::class, 'index'])->name('website.cart.index');
Route::put('/cart/{product}', [CartController::class, 'update'])->name('website.cart.update');
Route::delete('/cart/{product}', [CartController::class, 'destroy'])->name('website.cart.destroy');

// Order Routes
Route::get('/checkout', [OrderController::class, 'create'])->name('website.checkout.create');
Route::post('/checkout', [OrderController::class, 'store'])->name('website.checkout.store');
Route::get('/orders/{order}', [OrderController::class, 'show'])->name('website.orders.show');
