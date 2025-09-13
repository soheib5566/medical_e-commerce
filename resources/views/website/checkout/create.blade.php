@extends('layouts.app')

@section('title', 'Checkout - MedStore')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('website.cart.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-700 mb-4">
                <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Back to Cart
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Checkout</h1>
        </div>

        @php
            $cart = session()->get('cart', []);
            $cartCount = array_sum(array_column($cart, 'quantity'));
        @endphp

        @if(empty($cart))
            <!-- Empty Cart Redirect -->
            <div class="text-center py-16">
                <div class="max-w-md mx-auto">
                    <svg class="h-24 w-24 text-gray-400 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Your cart is empty</h2>
                    <p class="text-gray-600 mb-8">Add some products to your cart before checking out</p>
                    <a href="{{ route('website.products.index') }}" 
                       class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        Continue Shopping
                    </a>
                </div>
            </div>
        @else
            <!-- Checkout Form -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Delivery Information -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <div class="flex items-center">
                                <svg class="h-5 w-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                                <h2 class="text-lg font-semibold text-gray-900">Delivery Information</h2>
                            </div>
                        </div>
                        
                        <form action="{{ route('website.checkout.store') }}" method="POST" class="p-6">
                            @csrf
                            
                            <div class="space-y-6">
                                <!-- Full Name -->
                                <div>
                                    <label for="full_name" class="block text-sm font-medium text-gray-700 mb-2">
                                        Full Name <span class="text-red-500">*</span>
                                    </label>
                                    <input 
                                        type="text" 
                                        id="full_name" 
                                        name="full_name" 
                                        value="{{ old('full_name') }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('full_name') border-red-500 @enderror"
                                        placeholder="Enter your full name"
                                        required
                                    >
                                    @error('full_name')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Phone Number -->
                                <div>
                                    <label for="phone_number" class="block text-sm font-medium text-gray-700 mb-2">
                                        Phone Number <span class="text-red-500">*</span>
                                    </label>
                                    <input 
                                        type="tel" 
                                        id="phone_number" 
                                        name="phone_number" 
                                        value="{{ old('phone_number') }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('phone_number') border-red-500 @enderror"
                                        placeholder="Enter your phone number"
                                        required
                                    >
                                    @error('phone_number')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Delivery Address -->
                                <div>
                                    <label for="delivery_address" class="block text-sm font-medium text-gray-700 mb-2">
                                        Delivery Address <span class="text-red-500">*</span>
                                    </label>
                                    <textarea 
                                        id="delivery_address" 
                                        name="delivery_address" 
                                        rows="4"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('delivery_address') border-red-500 @enderror"
                                        placeholder="Enter your complete delivery address"
                                        required
                                    >{{ old('delivery_address') }}</textarea>
                                    @error('delivery_address')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                
                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 sticky top-8">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <div class="flex items-center">
                                <svg class="h-5 w-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <h2 class="text-lg font-semibold text-gray-900">Order Summary</h2>
                            </div>
                        </div>
                        
                        <div class="p-6">
                            <!-- Items List -->
                            <div class="space-y-3 mb-6">
                                @foreach($cart as $productId => $item)
                                <div class="flex justify-between items-center">
                                    <div class="flex items-center space-x-3">
                                        <img 
                                            src="{{ $item['image'] ? asset('storage/' . $item['image']) : asset('images/default-product.svg') }}" 
                                            alt="{{ $item['name'] }}"
                                            class="w-10 h-10 object-cover rounded border"
                                        >
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ $item['name'] }}</p>
                                            <p class="text-xs text-gray-600">Qty: {{ $item['quantity'] }}</p>
                                        </div>
                                    </div>
                                    <span class="text-sm font-medium text-gray-900">${{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                                </div>
                                @endforeach
                            </div>
                            
                            <!-- Total -->
                            <div class="border-t border-gray-200 pt-4 mb-6">
                                <div class="flex justify-between items-center">
                                    <span class="text-lg font-semibold text-gray-900">Total</span>
                                    <span class="text-xl font-bold text-blue-600">
                                        ${{ number_format(array_sum(array_map(function($item) { return $item['price'] * $item['quantity']; }, $cart)), 2) }}
                                    </span>
                                </div>
                            </div>
                            
                            <!-- Place Order Button -->
                            <button 
                                type="submit" 
                                form="checkout-form"
                                class="w-full bg-blue-600 text-white py-3 px-4 rounded-lg hover:bg-blue-700 transition-colors font-medium"
                            >
                                Place Order
                            </button>
                            
                            <!-- Terms -->
                            <p class="text-xs text-gray-500 text-center mt-4">
                                By placing this order, you agree to our terms and conditions
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Hidden form for order placement -->
            <form id="checkout-form" action="{{ route('website.checkout.store') }}" method="POST" class="hidden">
                @csrf
                <input type="hidden" name="full_name" id="form_full_name">
                <input type="hidden" name="phone_number" id="form_phone_number">
                <input type="hidden" name="delivery_address" id="form_delivery_address">
            </form>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        const submitButton = document.querySelector('button[type="submit"]');
        
        if (form && submitButton) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Get form data
                const fullName = document.getElementById('full_name').value;
                const phoneNumber = document.getElementById('phone_number').value;
                const deliveryAddress = document.getElementById('delivery_address').value;
                
                // Validate required fields
                if (!fullName || !phoneNumber || !deliveryAddress) {
                    alert('Please fill in all required fields.');
                    return;
                }
                
                // Set hidden form values
                document.getElementById('form_full_name').value = fullName;
                document.getElementById('form_phone_number').value = phoneNumber;
                document.getElementById('form_delivery_address').value = deliveryAddress;
                
                // Show loading state
                submitButton.innerHTML = '<svg class="animate-spin h-5 w-5 mx-auto" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Placing Order...';
                submitButton.disabled = true;
                
                // Submit the hidden form
                document.getElementById('checkout-form').submit();
            });
        }
    });
</script>
@endpush
