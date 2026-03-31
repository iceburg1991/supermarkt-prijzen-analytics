<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'SupermarketData') }} — @yield('title', 'Dashboard')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#f1f5f9] font-[Inter] antialiased">
    <nav class="bg-white shadow-sm">
        <div class="mx-auto flex max-w-6xl items-center gap-6 px-4 py-3">
            <span class="text-lg font-semibold text-[#325ff4]">SupermarketData Inc.</span>
            <a href="{{ route('dashboard.chart') }}"
               class="text-sm font-medium {{ request()->routeIs('dashboard.chart') ? 'text-[#325ff4]' : 'text-gray-500 hover:text-gray-900' }}">
                Grafiek
            </a>
            <a href="{{ route('dashboard.index') }}"
               class="text-sm font-medium {{ request()->routeIs('dashboard.index') ? 'text-[#325ff4]' : 'text-gray-500 hover:text-gray-900' }}">
                Producten
            </a>
        </div>
    </nav>

    <div class="mx-auto max-w-6xl px-4 py-8">
        @yield('content')
    </div>
</body>
</html>
