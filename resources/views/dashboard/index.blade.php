<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'SupermarketData') }} — Dashboard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#f1f5f9] font-[Inter] antialiased">
    <div class="mx-auto max-w-6xl px-4 py-8">
        <h1 class="mb-6 text-2xl font-semibold text-gray-900">Dashboard</h1>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($products as $product)
                <div class="rounded-lg bg-white p-4 shadow-sm">
                    @if ($product->image_url)
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="mb-3 h-32 w-full rounded object-contain">
                    @else
                        <div class="mb-3 flex h-32 w-full items-center justify-center rounded bg-gray-100 text-sm text-gray-400">
                            Geen afbeelding
                        </div>
                    @endif
                    <h2 class="font-medium text-gray-900">{{ $product->name }}</h2>
                    <p class="text-sm text-gray-500">{{ $product->sku }}</p>
                </div>
            @endforeach
        </div>
    </div>
</body>
</html>
