<div class="bg-card border border-border rounded-lg overflow-hidden hover:shadow-medical transition-all duration-300">
    <div class="aspect-square overflow-hidden bg-accent/20">
        <img 
            src="{{ $product->image ? Storage::url($product->image) : '/placeholder-product.jpg' }}" 
            alt="{{ $product->name }}"
            class="w-full h-full object-cover hover:scale-105 transition-transform duration-300"
        />
    </div>
    
    <div class="p-4">
        <div class="flex items-start justify-between gap-2 mb-2">
            <h3 class="text-lg font-semibold text-foreground line-clamp-2">
                {{ $product->name }}
            </h3>
            <span class="bg-secondary text-secondary-foreground px-2 py-1 rounded text-xs shrink-0">
                {{ $product->category->name }}
            </span>
        </div>
        
        <p class="text-muted-foreground text-sm mb-3 line-clamp-2">
            {{ $product->description }}
        </p>
        
        <div class="flex items-center gap-2 mb-3">
            <svg class="h-4 w-4 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
            </svg>
            <span class="text-sm text-muted-foreground">Stock: {{ $product->stock }}</span>
        </div>
        
        <div class="text-2xl font-bold text-primary mb-4">
            ${{ number_format($product->price, 2) }}
        </div>
        
        <form class="add-to-cart-form" action="{{ route('website.products.cart.store', $product) }}" method="POST">
            @csrf
            <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors duration-200 flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed" {{ $product->stock <= 0 ? 'disabled' : '' }}>
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6.5-5v6a1 1 0 01-1 1H9a1 1 0 01-1-1v-6m8 0V9a1 1 0 00-1-1H9a1 1 0 00-1-1V7a1 1 0 011-1h6a1 1 0 011 1v1"></path>
                </svg>
                {{ $product->stock <= 0 ? 'Out of Stock' : 'Add to Cart' }}
            </button>
        </form>
    </div>
</div>