<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'SupermarketData') }} — @yield('title', 'Dashboard')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#f1f5f9] font-[Inter] antialiased">
    <nav class="bg-white shadow-sm">
        <div class="mx-auto flex max-w-6xl items-center px-4 pt-3">
            <span class="pb-3 text-lg font-semibold text-[#325ff4]">SupermarketData Inc.</span>
            <div class="ml-6 flex gap-6">
                <a href="{{ route('dashboard.home') }}"
                   class="border-b-2 pb-3 text-sm font-medium {{ request()->routeIs('dashboard.home') ? 'border-[#325ff4] text-[#325ff4]' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-900' }}">
                    Home
                </a>
                <a href="{{ route('dashboard.chart') }}"
                   class="border-b-2 pb-3 text-sm font-medium {{ request()->routeIs('dashboard.chart') ? 'border-[#325ff4] text-[#325ff4]' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-900' }}">
                    Grafiek
                </a>
                <a href="{{ route('dashboard.index') }}"
                   class="border-b-2 pb-3 text-sm font-medium {{ request()->routeIs('dashboard.index', 'dashboard.show', 'dashboard.priceTable', 'dashboard.productChart') ? 'border-[#325ff4] text-[#325ff4]' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-900' }}">
                    Producten
                </a>
            </div>
            <div class="ml-auto flex items-center gap-1 pb-3 text-sm">
                <form method="POST" action="{{ route('locale.switch', 'nl') }}" class="inline">
                    @csrf
                    <button type="submit"
                            class="rounded px-2 py-1 font-medium transition-colors {{ app()->getLocale() === 'nl' ? 'text-[#325ff4]' : 'text-gray-400 hover:text-gray-700' }}">
                        NL
                    </button>
                </form>
                <span class="text-gray-300">|</span>
                <form method="POST" action="{{ route('locale.switch', 'en') }}" class="inline">
                    @csrf
                    <button type="submit"
                            class="rounded px-2 py-1 font-medium transition-colors {{ app()->getLocale() === 'en' ? 'text-[#325ff4]' : 'text-gray-400 hover:text-gray-700' }}">
                        EN
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="mx-auto max-w-6xl px-4 py-8">
        @yield('content')
    </div>
</body>
</html>
