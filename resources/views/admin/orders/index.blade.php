@extends('layouts.admin')

@section('title', 'Order Management')

@section('content')
<div class="animate-fade-in">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Order Management</h1>
        <p class="text-gray-600 mt-2">Manage customer orders and track their status</p>
    </div>

    <!-- Search Bar -->
    <div class="mb-6">
        <div class="relative max-w-md">
            <input 
                type="text" 
                id="search-orders" 
                placeholder="Search orders..." 
                class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                value="{{ request('search') }}"
            >
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i data-lucide="search" class="h-4 w-4 text-gray-400"></i>
            </div>
        </div>
    </div>

    <!-- Orders List -->
    <div class="space-y-6">
        @forelse($orders as $order)
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition-shadow">
            <div class="p-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Left Column - Customer Details -->
                    <div class="space-y-4">
                        <!-- Order ID and Date -->
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">{{ $order->id }}</h3>
                                <p class="text-sm text-gray-600">{{ $order->created_at->format('M d, Y') }}</p>
                            </div>
                            <div class="text-right">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                    @if($order->status === 'processing') bg-green-100 text-green-800
                                    @elseif($order->status === 'shipped') bg-blue-100 text-blue-800
                                    @elseif($order->status === 'delivered') bg-purple-100 text-purple-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                        </div>

                        <!-- Customer Details -->
                        <div>
                            <h4 class="text-sm font-medium text-gray-900 mb-3">Customer Details</h4>
                            <div class="space-y-2 text-sm">
                                <div class="flex items-center gap-2">
                                    <i data-lucide="user" class="h-4 w-4 text-gray-400"></i>
                                    <span class="text-gray-700">{{ $order->full_name }}</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <i data-lucide="phone" class="h-4 w-4 text-gray-400"></i>
                                    <span class="text-gray-700">{{ $order->phone_number }}</span>
                                </div>
                                <div class="flex items-start gap-2">
                                    <i data-lucide="map-pin" class="h-4 w-4 text-gray-400 mt-0.5"></i>
                                    <span class="text-gray-700">{{ $order->delivery_address }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex gap-3">
                            <button onclick="viewOrderDetails('{{ $order->id }}')" 
                                    class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                <i data-lucide="eye" class="h-4 w-4"></i>
                                View Details
                            </button>
                            <form method="POST" action="{{ route('admin.orders.update', $order) }}" class="inline">
                                @csrf
                                @method('PUT')
                                <select name="status" 
                                        onchange="this.form.submit()" 
                                        class="px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent
                                               @if($order->status === 'shipped') bg-gray-100 cursor-not-allowed @endif"
                                        {{ $order->status === 'shipped' ? 'disabled' : '' }}>
                                    <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                                    <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                                    <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                                </select>
                            </form>
                        </div>
                    </div>

                    <!-- Right Column - Order Items -->
                    <div class="space-y-4">
                        <h4 class="text-sm font-medium text-gray-900">Order Items</h4>
                        <div class="space-y-3">
                            @foreach($order->items as $item)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center gap-3">
                                    @if($item->product && $item->product->image)
                                        <img src="{{ $item->product->image_url }}" 
                                             alt="{{ $item->product->name }}" 
                                             class="w-12 h-12 object-cover rounded border">
                                    @else
                                        <div class="w-12 h-12 bg-gray-200 rounded border flex items-center justify-center">
                                            <i data-lucide="package" class="h-6 w-6 text-gray-400"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $item->product->name ?? 'Product Deleted' }}</p>
                                        <p class="text-sm text-gray-600">Quantity: {{ $item->quantity }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="font-medium text-gray-900">${{ number_format($item->price, 2) }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <!-- Total -->
                        <div class="border-t border-gray-200 pt-4">
                            <div class="flex items-center justify-between">
                                <span class="text-lg font-semibold text-gray-900">Total</span>
                                <span class="text-xl font-bold text-blue-600">${{ number_format($order->total_price, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="text-center py-12">
            <i data-lucide="shopping-cart" class="h-12 w-12 mx-auto text-gray-400 mb-4"></i>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No orders found</h3>
            <p class="text-gray-600">Orders will appear here when customers make purchases.</p>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($orders->hasPages())
    <div class="mt-8">
        {{ $orders->links() }}
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    function viewOrderDetails(orderId) {
        // This could open a modal or redirect to a detailed view
        alert('Order details for: ' + orderId);
    }

    // Search functionality
    document.getElementById('search-orders').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            const search = this.value;
            const url = new URL(window.location);
            
            if (search) {
                url.searchParams.set('search', search);
            } else {
                url.searchParams.delete('search');
            }
            
            window.location = url;
        }
    });

    // Initialize Lucide icons
    document.addEventListener('DOMContentLoaded', function() {
        lucide.createIcons();
    });
</script>
@endpush
