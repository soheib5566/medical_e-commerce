<header class="bg-white border-b border-gray-200 shadow-sm sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <!-- Logo -->
            <a href="{{ route('website.products.index') }}" class="flex items-center space-x-2">
                <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                    <svg class="h-6 w-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-xl font-bold text-blue-600">MedStore</h1>
                    <p class="text-xs text-gray-600">Medical Supplies</p>
                </div>
            </a>

            <!-- Search Bar -->
            @if(request()->route()->getName() === 'website.products.index')
                <div class="flex-1 max-w-md mx-8">
                    <form method="GET" action="{{ route('website.products.index') }}">
                        <div class="relative">
                            <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            <input 
                                type="text" 
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="Search medical products..."
                                class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            />
                        </div>
                    </form>
                </div>
            @endif

            <!-- Cart -->
            <div class="flex items-center">
                <a href="{{ route('website.cart.index') }}" class="relative p-2 text-gray-600 hover:text-blue-600 transition-colors">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6.5-5v6a1 1 0 01-1 1H9a1 1 0 01-1-1v-6m8 0V9a1 1 0 00-1-1H9a1 1 0 00-1-1V7a1 1 0 011-1h6a1 1 0 011 1v1"></path>
                    </svg>
                    @php $cartCount = session()->get('cart') ? array_sum(array_column(session('cart'), 'quantity')) : 0 @endphp
                    <span id="cart-badge" class="absolute -top-1 -right-1 bg-red-500 text-white rounded-full text-xs px-1.5 py-0.5 min-w-[20px] text-center {{ $cartCount > 0 ? '' : 'hidden' }}">
                        {{ $cartCount }}
                    </span>
                </a>
            </div>
        </div>
    </div>
</header>