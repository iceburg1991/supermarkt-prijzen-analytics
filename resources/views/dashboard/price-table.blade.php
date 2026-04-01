@extends('layouts.app')

@section('title', $product->name . ' — Prijstabel')

@section('content')
    <div class="mb-4 flex items-center justify-between">
        <a href="{{ route('dashboard.index') }}" class="text-sm text-[#325ff4] hover:underline">
            &larr; Terug naar overzicht
        </a>
    </div>

    @include('dashboard.partials.product-nav', ['product' => $product, 'active' => 'priceTable'])

    <div class="rounded-lg bg-white p-6 shadow-sm">
        <h1 class="mb-6 text-2xl font-semibold text-gray-900">{{ $product->name }} — Prijstabel</h1>

        @if ($prices->isEmpty())
            <p class="text-gray-500">Geen prijshistorie beschikbaar voor dit product.</p>
        @else
            <div class="overflow-hidden rounded-lg border border-gray-200">
                <table class="w-full text-left text-sm">
                    <thead class="border-b bg-gray-50 text-xs uppercase tracking-wider text-gray-500">
                        <tr>
                            <th class="px-6 py-3">Datum</th>
                            <th class="px-6 py-3">Prijs</th>
                            <th class="px-6 py-3">Oude prijs</th>
                            <th class="px-6 py-3">Promotie</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($prices as $price)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-3 text-gray-900">
                                    {{ $price->changed_at->format('d-m-Y') }}
                                </td>
                                <td class="px-6 py-3 font-medium text-gray-900">
                                    € {{ number_format($price->price, 2, ',', '.') }}
                                </td>
                                <td class="px-6 py-3 text-gray-500">
                                    @if ($price->old_price)
                                        € {{ number_format($price->old_price, 2, ',', '.') }}
                                    @else
                                        —
                                    @endif
                                </td>
                                <td class="px-6 py-3">
                                    @if ($price->is_promotion)
                                        <span class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800">
                                            Ja
                                        </span>
                                    @else
                                        <span class="text-gray-400">Nee</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $prices->links() }}
            </div>
        @endif
    </div>
@endsection
