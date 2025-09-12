<?php

use App\Http\Controllers\Admin\ProductController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->prefix('admin')->group(function () {
    Route::resource('products', ProductController::class)->names('admin.products');
    Route::resource('orders', \App\Http\Controllers\Admin\OrderController::class)
        ->names('admin.orders')->except(['create', 'store', 'destroy']);
});

require __DIR__ . '/auth.php';
