@extends('layouts.app')

@section('title', 'Shopping Cart - MedStore')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('website.products.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-700 mb-4">
                <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Back to Products
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Shopping Cart</h1>
        </div>

        @php
            $cart = session()->get('cart', []);
            $cartCount = array_sum(array_column($cart, 'quantity'));
        @endphp

        @if(empty($cart))
            <!-- Empty Cart State -->
            <div class="text-center py-16">
                <div class="max-w-md mx-auto">
                    <svg class="h-24 w-24 text-gray-400 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Your cart is empty</h2>
                    <p class="text-gray-600 mb-8">Browse our medical supplies and add items to get started</p>
                    <a href="{{ route('website.products.index') }}" 
                       class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        Continue Shopping
                    </a>
                </div>
            </div>
        @else
            <!-- Cart with Items -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Cart Items -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="text-lg font-semibold text-gray-900">Shopping Cart ({{ $cartCount }} items)</h2>
                        </div>
                        
                        <div class="divide-y divide-gray-200">
                            @foreach($cart as $productId => $item)
                            <div class="p-6" id="cart-item-{{ $productId }}">
                                <div class="flex items-center space-x-4">
                                    <!-- Product Image -->
                                    <div class="flex-shrink-0">
                                        <img 
                                            src="{{ $item['image'] ? asset('storage/' . $item['image']) : asset('images/default-product.svg') }}" 
                                            alt="{{ $item['name'] }}"
                                            class="w-16 h-16 object-cover rounded-lg border border-gray-200"
                                        >
                                    </div>
                                    
                                    <!-- Product Details -->
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-lg font-medium text-gray-900">{{ $item['name'] }}</h3>
                                        <p class="text-sm text-gray-600 mt-1">Stock available: {{ $item['stock'] }}</p>
                                        <p class="text-lg font-semibold text-blue-600 mt-2">${{ number_format($item['price'], 2) }}</p>
                                    </div>
                                    
                                    <!-- Quantity Controls -->
                                    <div class="flex items-center space-x-3">
                                        <button 
                                            onclick="updateQuantity({{ $productId }}, {{ $item['quantity'] - 1 }})"
                                            class="w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center hover:bg-gray-50 transition-colors"
                                            {{ $item['quantity'] <= 1 ? 'disabled' : '' }}
                                        >
                                            <svg class="h-4 w-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                            </svg>
                                        </button>
                                        
                                        <span class="text-lg font-medium text-gray-900 w-8 text-center">{{ $item['quantity'] }}</span>
                                        
                                        <button 
                                            onclick="updateQuantity({{ $productId }}, {{ $item['quantity'] + 1 }})"
                                            class="w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center hover:bg-gray-50 transition-colors"
                                            {{ $item['quantity'] >= $item['stock'] ? 'disabled' : '' }}
                                        >
                                            <svg class="h-4 w-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                            </svg>
                                        </button>
                                    </div>
                                    
                                    <!-- Delete Button -->
                                    <button 
                                        onclick="removeFromCart({{ $productId }})"
                                        class="text-red-600 hover:text-red-700 p-2 transition-colors"
                                        title="Remove item"
                                    >
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                
                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 sticky top-8">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="text-lg font-semibold text-gray-900">Order Summary</h2>
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
                                    <span class="text-xl font-bold text-blue-600" id="cart-total">
                                        ${{ number_format(array_sum(array_map(function($item) { return $item['price'] * $item['quantity']; }, $cart)), 2) }}
                                    </span>
                                </div>
                            </div>
                            
                            <!-- Action Buttons -->
                            <div class="space-y-3">
                                <a href="{{ route('website.checkout.create') }}" 
                                   class="w-full bg-blue-600 text-white py-3 px-4 rounded-lg hover:bg-blue-700 transition-colors text-center block font-medium">
                                    Proceed to Checkout
                                </a>
                                
                                <a href="{{ route('website.products.index') }}" 
                                   class="w-full border border-gray-300 text-gray-700 py-3 px-4 rounded-lg hover:bg-gray-50 transition-colors text-center block font-medium">
                                    Continue Shopping
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Toast Container -->
<div id="toast-container" class="fixed top-4 right-4 z-50 space-y-2"></div>
@endsection

@push('scripts')
<script>
    function updateQuantity(productId, newQuantity) {
        if (newQuantity < 1) {
            removeFromCart(productId);
            return;
        }

        fetch(`/cart/${productId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ quantity: newQuantity })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload(); // Reload to update the page
            } else {
                showToast(data.message || 'Failed to update quantity', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('An error occurred. Please try again.', 'error');
        });
    }

    function removeFromCart(productId) {
        if (!confirm('Are you sure you want to remove this item from your cart?')) {
            return;
        }

        fetch(`/cart/${productId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast('Item removed from cart', 'success');
                location.reload(); // Reload to update the page
            } else {
                showToast(data.message || 'Failed to remove item', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('An error occurred. Please try again.', 'error');
        });
    }

    function showToast(message, type = 'success') {
        const toast = document.createElement('div');
        toast.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg shadow-lg transition-all duration-300 transform translate-x-full ${
            type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
        }`;
        toast.textContent = message;
        
        document.body.appendChild(toast);
        
        // Animate in
        setTimeout(() => {
            toast.classList.remove('translate-x-full');
        }, 100);
        
        // Auto remove
        setTimeout(() => {
            toast.classList.add('translate-x-full');
            setTimeout(() => {
                document.body.removeChild(toast);
            }, 300);
        }, 3000);
    }
</script>
@endpush
