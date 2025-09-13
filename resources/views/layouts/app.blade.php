<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'MedStore - Professional Medical Supplies')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-background text-foreground">
    @include('components.header')
    
    <main>
        @yield('content')
    </main>
    
    @if(session('success'))
        <div class="toast toast-success">{{ session('success') }}</div>
    @endif
    
    @if(session('error'))
        <div class="toast toast-error">{{ session('error') }}</div>
    @endif
    
    <!-- Cart Script -->
    <script src="{{ asset('js/cart.js') }}"></script>
</body>
</html>