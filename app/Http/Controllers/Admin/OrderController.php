<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\OrderUpdateRequest;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('user', 'items.product')->latest();

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                  ->orWhere('full_name', 'like', "%{$search}%")
                  ->orWhere('phone_number', 'like', "%{$search}%")
                  ->orWhere('delivery_address', 'like', "%{$search}%");
            });
        }

        $orders = $query->paginate(10);

        return view('admin.orders.index', compact('orders'));
    }

    public function update(OrderUpdateRequest $request, Order $order)
    {
        $order = $request->updateStatusOrder(order: $order);

        return redirect()
            ->route('admin.orders.index')
            ->with('success', 'Order status updated successfully.');
    }
}
