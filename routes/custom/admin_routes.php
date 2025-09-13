<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductLogController;
use Illuminate\Support\Facades\Route;



Route::middleware('auth')->prefix('admin')->group(function () {
    Route::resource('products', ProductController::class)->names('admin.products');
    Route::resource('orders', OrderController::class)
        ->names('admin.orders')->except(['create', 'store', 'destroy']);
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/product-logs', [ProductLogController::class, 'index'])->name('admin.product-logs.index');
});

require __DIR__ . '/auth.php';
