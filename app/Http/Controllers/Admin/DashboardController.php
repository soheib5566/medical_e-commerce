<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_products' => Product::count(),
            'total_orders'   => Order::count(),
            'total_revenue'  => Order::sum('total_price'),
            'low_stock'      => Product::where('stock', '<=', 5)->count(),
        ];

        $recent_orders = Order::latest()->take(5)->get();
        $low_stock_products = Product::where('stock', '<=', 5)->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recent_orders', 'low_stock_products'));
    }
}
