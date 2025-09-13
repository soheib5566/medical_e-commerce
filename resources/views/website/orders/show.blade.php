@extends('layouts.app')

@section('title', 'Order Confirmation - MedStore')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Success Header -->
        <div class="text-center mb-12">
            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="h-10 w-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h1 class="text-4xl font-bold text-green-600 mb-4">Order Confirmed!</h1>
            <p class="text-xl text-gray-600">Thank you for your order. We'll send you updates as your order ships.</p>
        </div>

        <!-- Order Details Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <svg class="h-5 w-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <h2 class="text-lg font-semibold text-gray-900">Order Details</h2>
                    </div>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                        {{ $order->id }}
                    </span>
                </div>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-600">Order Date</p>
                        <p class="text-lg font-medium text-gray-900">{{ $order->created_at->format('F d, Y \a\t g:i A') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Estimated Delivery</p>
                        <p class="text-lg font-medium text-gray-900">{{ $order->created_at->addDays(3)->format('F d, Y') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delivery Information Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center">
                    <svg class="h-5 w-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    <h2 class="text-lg font-semibold text-gray-900">Delivery Information</h2>
                </div>
            </div>
            <div class="p-6">
                <div class="space-y-3">
                    <div>
                        <p class="text-sm text-gray-600">Full Name</p>
                        <p class="text-lg font-medium text-gray-900">{{ $order->full_name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Phone Number</p>
                        <p class="text-lg font-medium text-gray-900">{{ $order->phone_number }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Delivery Address</p>
                        <p class="text-lg font-medium text-gray-900">{{ $order->delivery_address }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Items Ordered Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center">
                    <svg class="h-5 w-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    <h2 class="text-lg font-semibold text-gray-900">Items Ordered</h2>
                </div>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @foreach($order->items as $item)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            @if($item->product && $item->product->image)
                                <img 
                                    src="{{ $item->product->image_url }}" 
                                    alt="{{ $item->product->name }}" 
                                    class="w-12 h-12 object-cover rounded border"
                                >
                            @else
                                <div class="w-12 h-12 bg-gray-200 rounded border flex items-center justify-center">
                                    <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                </div>
                            @endif
                            <div>
                                <p class="font-medium text-gray-900">{{ $item->product->name ?? 'Product Deleted' }}</p>
                                <p class="text-sm text-gray-600">Quantity: {{ $item->quantity }}</p>
                                <p class="text-sm text-gray-600">${{ number_format($item->price, 2) }} each</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-medium text-gray-900">${{ number_format($item->price * $item->quantity, 2) }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <!-- Total -->
                <div class="border-t border-gray-200 pt-4 mt-6">
                    <div class="flex justify-between items-center">
                        <span class="text-lg font-semibold text-gray-900">Total</span>
                        <span class="text-xl font-bold text-blue-600">${{ number_format($order->total_price, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- What's Next Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-8">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">What's Next?</h2>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <!-- Processing Step -->
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                <svg class="h-4 w-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1">
                            <p class="font-medium text-gray-900">1 Order Processing</p>
                            <p class="text-sm text-gray-600">We're preparing your items for shipment</p>
                        </div>
                    </div>
                    
                    <!-- Shipping Step -->
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center">
                                <span class="text-sm font-medium text-gray-600">2</span>
                            </div>
                        </div>
                        <div class="flex-1">
                            <p class="font-medium text-gray-900">2 Shipping</p>
                            <p class="text-sm text-gray-600">Your order will be shipped within 1-2 business days</p>
                        </div>
                    </div>
                    
                    <!-- Delivery Step -->
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center">
                                <span class="text-sm font-medium text-gray-600">3</span>
                            </div>
                        </div>
                        <div class="flex-1">
                            <p class="font-medium text-gray-900">3 Delivery</p>
                            <p class="text-sm text-gray-600">Estimated delivery in 3-5 business days</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Button -->
        <div class="text-center">
            <a href="{{ route('website.products.index') }}" 
               class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
                Continue Shopping
            </a>
        </div>
    </div>
</div>
@endsection
