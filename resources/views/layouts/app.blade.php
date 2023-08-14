<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    
    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>
<body class="bg-gray-100 h-screen antialiased leading-none font-sans">
<div id="app">
    <nav class="bg-white shadow-md">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <a class="text-xl font-semibold text-blue-500" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <div class="space-x-4">
                    @guest
                        <a class="text-gray-600 hover:text-gray-800 px-3" href="{{ route('login') }}">Login</a>
                        @if (Route::has('register'))
                            <a class="text-gray-600 hover:text-gray-800 px-3" href="{{ route('register') }}">Register</a>
                        @endif
                    @else
                        <span class="text-gray-600">{{ Auth::user()->name }}</span>
                        <a href="{{ route('logout') }}" class="text-gray-600 hover:text-gray-800 px-3" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                            @csrf
                        </form>
                        <a href="{{ route('stores.index') }}" class="text-gray-600 hover:text-gray-800 px-3">Stores</a>
                        <a href="{{ route('stores.create') }}" class="text-gray-600 hover:text-gray-800 px-3">Create Store</a>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>
</div>
</body>
</html>
