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

        <div class="overflow-hidden rounded-lg bg-white shadow-sm">
            <table class="w-full text-left text-sm">
                <thead class="border-b bg-gray-50 text-xs uppercase tracking-wider text-gray-500">
                    <tr>
                        <th class="px-6 py-3">Afbeelding</th>
                        <th class="px-6 py-3">Naam</th>
                        <th class="px-6 py-3">Retailer</th>
                        <th class="px-6 py-3">SKU</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($products as $product)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-3">
                                @if ($product->image_url)
                                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="h-10 w-10 rounded object-contain">
                                @else
                                    <div class="flex h-10 w-10 items-center justify-center rounded bg-gray-100 text-xs text-gray-400">—</div>
                                @endif
                            </td>
                            <td class="px-6 py-3 font-medium text-gray-900">{{ $product->name }}</td>
                            <td class="px-6 py-3 text-gray-500">{{ $product->retailer }}</td>
                            <td class="px-6 py-3 text-gray-500">{{ $product->sku }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $products->links() }}
        </div>
    </div>
</body>
</html>
