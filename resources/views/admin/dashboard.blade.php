@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="animate-fade-in">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="card">
            <div class="card-content pt-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-muted-foreground">Total Products</p>
                        <p class="text-2xl font-bold">{{ $stats['total_products'] }}</p>
                    </div>
                    <div class="h-12 w-12 rounded-full bg-blue-100 flex items-center justify-center">
                        <i data-lucide="package" class="h-6 w-6 text-blue-600"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-content pt-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-muted-foreground">Total Orders</p>
                        <p class="text-2xl font-bold">{{ $stats['total_orders'] }}</p>
                    </div>
                    <div class="h-12 w-12 rounded-full bg-green-100 flex items-center justify-center">
                        <i data-lucide="shopping-cart" class="h-6 w-6 text-green-600"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-content pt-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-muted-foreground">Low Stock Items</p>
                        <p class="text-2xl font-bold">{{ $stats['low_stock'] }}</p>
                    </div>
                    <div class="h-12 w-12 rounded-full bg-orange-100 flex items-center justify-center">
                        <i data-lucide="alert-triangle" class="h-6 w-6 text-orange-600"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-content pt-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-muted-foreground">Revenue</p>
                        <p class="text-2xl font-bold">${{ number_format($stats['total_revenue'], 2) }}</p>
                    </div>
                    <div class="h-12 w-12 rounded-full bg-purple-100 flex items-center justify-center">
                        <i data-lucide="dollar-sign" class="h-6 w-6 text-purple-600"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders & Low Stock -->
    <div class="grid lg:grid-cols-2 gap-8">
        <!-- Recent Orders -->
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Recent Orders</h2>
            </div>
            <div class="card-content">
                <div class="space-y-4">
                    @forelse($recent_orders as $order)
                        <div class="flex items-center justify-between p-3 border rounded-lg">
                            <div>
                                <p class="font-medium">{{ $order->full_name }}</p>
                                <p class="text-sm text-muted-foreground">{{ $order->created_at->format('M d, Y') }}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-semibold">${{ number_format($order->total_price, 2) }}</p>
                                <span class="badge badge-secondary">{{ $order->status }}</span>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted-foreground text-center py-4">No recent orders</p>
                    @endforelse
                </div>
                @if($recent_orders->count() > 0)
                    <div class="mt-4">
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-ghost w-full">
                            View All Orders
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Low Stock Products -->
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Low Stock Products</h2>
            </div>
            <div class="card-content">
                <div class="space-y-4">
                    @forelse($low_stock_products as $product)
                        <div class="flex items-center gap-3 p-3 border rounded-lg">
                            <img 
                                src="{{ $product->image_url }}" 
                                alt="{{ $product->name }}"
                                class="w-12 h-12 object-cover rounded bg-accent/20"
                            >
                            <div class="flex-1">
                                <p class="font-medium">{{ $product->name }}</p>
                                <p class="text-sm text-muted-foreground">${{ number_format($product->price, 2) }}</p>
                            </div>
                            <div class="text-right">
                                <span class="badge {{ $product->stock <= 2 ? 'bg-red-100 text-red-800' : 'bg-orange-100 text-orange-800' }}">
                                    {{ $product->stock }} left
                                </span>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted-foreground text-center py-4">All products are well stocked</p>
                    @endforelse
                </div>
                @if($low_stock_products->count() > 0)
                    <div class="mt-4">
                        <a href="{{ route('admin.products.index') }}" class="btn btn-ghost w-full">
                            Manage Products
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
