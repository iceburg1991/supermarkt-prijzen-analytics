@extends('layouts.app')

@section('title', 'Producten')

@section('content')
    <h1 class="mb-6 text-2xl font-semibold text-gray-900">Producten</h1>

    {{-- Highlighted products --}}
    <div class="mb-8 grid grid-cols-2 gap-4 md:grid-cols-4">
        @foreach ($highlightedProducts as $product)
            <a href="{{ route('product.show', $product) }}"
               class="group flex flex-col items-center rounded-lg bg-white p-4 shadow-sm transition-all hover:shadow-md hover:ring-2 hover:ring-[#325ff4]">
                @if ($product->image_url)
                    <img src="{{ $product->image_url }}"
                         alt="{{ $product->name }}"
                         class="mb-3 h-20 w-20 object-contain transition-transform group-hover:scale-105">
                @else
                    <div class="mb-3 flex h-20 w-20 items-center justify-center rounded bg-gray-100 text-gray-400">
                        <i class="fa-solid fa-box text-2xl"></i>
                    </div>
                @endif
                <span class="text-center text-sm font-medium text-gray-900 group-hover:text-[#325ff4]">
                    {{ $product->name }}
                </span>
            </a>
        @endforeach
    </div>

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
                        <td class="px-6 py-3 font-medium text-gray-900">
                            <a href="{{ route('product.show', $product) }}" class="text-[#325ff4] hover:underline">
                                {{ $product->name }}
                            </a>
                        </td>
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
@endsection
