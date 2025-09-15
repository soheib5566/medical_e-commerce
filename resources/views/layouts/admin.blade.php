<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') - MedStore Admin Panel</title>
    
    {{-- Tailwind & JS via Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
</head>
<body class="min-h-screen bg-gray-50">
    <div class="min-h-screen">
        <!-- Header -->
        <header class="bg-white border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center py-6">
                    <div>
                        <h1 class="text-3xl font-bold text-blue-600">MedStore Admin Panel</h1>
                        <p class="text-gray-600 mt-1">Manage your medical supplies store</p>
                    </div>
                    <div class="flex items-center gap-4">
                        <span class="text-sm text-gray-600">Welcome, {{ auth()->user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-gray-600 hover:text-gray-900 transition-colors">
                                <i data-lucide="log-out" class="h-5 w-5"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <!-- Navigation Tabs -->
        <nav class="bg-white border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex space-x-8">
                    <a href="{{ route('admin.dashboard') }}" 
                       class="py-4 px-1 border-b-2 font-medium text-sm {{ request()->routeIs('admin.dashboard') ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('admin.products.index') }}" 
                       class="py-4 px-1 border-b-2 font-medium text-sm {{ request()->routeIs('admin.products*') ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        Products
                    </a>
                    <a href="{{ route('admin.orders.index') }}" 
                       class="py-4 px-1 border-b-2 font-medium text-sm {{ request()->routeIs('admin.orders*') ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        Orders
                    </a>
                    <a href="{{ route('admin.product-logs.index') }}" 
                       class="py-4 px-1 border-b-2 font-medium text-sm {{ request()->routeIs('admin.product-logs*') ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        Product Logs
                    </a>
                    <a href="/" 
                       class="py-4 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                        View Store
                    </a>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            @if(session('success'))
                <div class="toast toast-success mb-6">
                    <div class="flex items-center gap-3">
                        <i data-lucide="check-circle" class="h-5 w-5"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="toast toast-error mb-6">
                    <div class="flex items-center gap-3">
                        <i data-lucide="alert-circle" class="h-5 w-5"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <!-- Toast Container -->
    <div id="toast-container" class="fixed top-4 right-4 z-50 space-y-2"></div>

    <!-- Custom Scripts -->
    <script src="{{ asset('js/toast.js') }}"></script>
    <script src="{{ asset('js/admin.js') }}"></script>
    <script>
        // Initialize Lucide icons
        lucide.createIcons();
        
        // Auto-hide flash messages
        document.addEventListener('DOMContentLoaded', function() {
            const flashMessages = document.querySelectorAll('.toast');
            flashMessages.forEach(toast => {
                setTimeout(() => {
                    toast.style.opacity = '0';
                    toast.style.transform = 'translateX(100%)';
                    setTimeout(() => toast.remove(), 300);
                }, 5000);
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html>
