@extends('layouts.admin')

@section('title', 'Products Management')

@section('content')
<div class="animate-fade-in">
    <!-- Dashboard Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-sm border p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i data-lucide="package" class="h-5 w-5 text-blue-600"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Products</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $products->total() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-sm border p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i data-lucide="shopping-cart" class="h-5 w-5 text-blue-600"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Orders</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ \App\Models\Order::count() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-sm border p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i data-lucide="bar-chart" class="h-5 w-5 text-blue-600"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Revenue</p>
                    <p class="text-2xl font-semibold text-gray-900">${{ number_format(\App\Models\Order::sum('total_price'), 2) }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-sm border p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center">
                        <i data-lucide="users" class="h-5 w-5 text-red-600"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Low Stock Items</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ \App\Models\Product::where('stock', '<=', 5)->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Management Section -->
    <div class="bg-white rounded-lg shadow-sm border">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">Product Management</h2>
                </div>
                <div class="flex items-center gap-4">
                    <div class="relative">
                        <input 
                            type="text" 
                            id="search-products" 
                            placeholder="Search products..." 
                            class="w-64 pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            value="{{ request('search') }}"
                        >
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i data-lucide="search" class="h-4 w-4 text-gray-400"></i>
                        </div>
                    </div>
                    <a href="{{ route('admin.products.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors flex items-center gap-2">
                        <i data-lucide="plus" class="h-4 w-4"></i>
                        Add Product
                    </a>
                </div>
            </div>
        </div>

        <div class="p-6">
            <div class="space-y-4">
                @forelse($products as $product)
                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200 hover:shadow-md transition-shadow">
                    <div class="flex items-center gap-4">
                        <!-- Product Image -->
                        <div class="flex-shrink-0">
                            <img 
                                src="{{ $product->image_url }}" 
                                alt="{{ $product->name }}"
                                class="w-16 h-16 object-cover rounded-lg border border-gray-200"
                            >
                        </div>
                        
                        <!-- Product Info -->
                        <div class="flex-1 min-w-0">
                            <h3 class="text-lg font-medium text-gray-900">{{ $product->name }}</h3>
                            <p class="text-sm text-gray-600 mt-1">{{ Str::limit($product->description, 80) }}</p>
                            <div class="flex items-center gap-4 mt-2">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    {{ $product->category->name ?? 'N/A' }}
                                </span>
                                <span class="text-lg font-semibold text-gray-900">${{ number_format($product->price, 2) }}</span>
                                <span class="text-sm text-gray-600">Stock: {{ $product->stock }}</span>
                            </div>
                        </div>
                        
                        <!-- Actions -->
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.products.edit', $product) }}" 
                               class="p-2 text-gray-400 hover:text-gray-600 transition-colors" 
                               title="Edit">
                                <i data-lucide="edit" class="h-5 w-5"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.products.destroy', $product) }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="p-2 text-gray-400 hover:text-red-600 transition-colors delete-btn" 
                                        data-name="{{ $product->name }}"
                                        title="Delete">
                                    <i data-lucide="trash-2" class="h-5 w-5"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-12">
                    <i data-lucide="package-x" class="h-12 w-12 mx-auto text-gray-400 mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No products found</h3>
                    <p class="text-gray-600">Get started by adding your first product.</p>
                </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($products->hasPages())
            <div class="mt-6">
                {{ $products->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function applyFilters() {
        const search = document.getElementById('search-products').value;
        
        const url = new URL(window.location);
        
        if (search) url.searchParams.set('search', search);
        else url.searchParams.delete('search');
        
        window.location = url;
    }

    // Apply filters on Enter key
    document.getElementById('search-products').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            applyFilters();
        }
    });

    // Delete confirmation
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const productName = this.getAttribute('data-name');
            if (confirm(`Are you sure you want to delete "${productName}"?`)) {
                this.closest('form').submit();
            }
        });
    });
</script>
@endpush
