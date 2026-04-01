@extends('layouts.app')

@section('title', $product->name . ' — ' . __('product.price_table_title'))

@section('content')
    <div class="mb-4 flex items-center justify-between">
        <a href="{{ route('dashboard.index') }}" class="text-sm text-[#325ff4] hover:underline">
            &larr; @lang('product.back_to_overview')
        </a>
    </div>

    @include('product.partials.nav', ['product' => $product, 'active' => 'priceTable'])

    {{-- Price history line chart --}}
    <div class="rounded-lg bg-white p-6 shadow-sm">
        <h2 class="mb-4 text-lg font-semibold text-gray-900">@lang('product.price_history_title')</h2>

        <x-chart-line
            :api-url="url('/api/product/' . $product->id . '/prices')"
            :locale="$locale"
            :chart-title="''"
            :series-name="__('product.price')"
            :y-axis-label="__('product.price') . ' (€)'"
            :promotion-label="__('product.promotion_label')"
        />
    </div>

    <div class="mt-6 rounded-lg bg-white p-6 shadow-sm">
        <h1 class="mb-6 text-2xl font-semibold text-gray-900">{{ $product->name }} — @lang('product.price_table_title')</h1>

        @if ($prices->isEmpty())
            <p class="text-gray-500">@lang('product.no_price_history')</p>
        @else
            <div class="overflow-hidden rounded-lg border border-gray-200">
                <table class="w-full text-left text-sm">
                    <thead class="border-b bg-gray-50 text-xs uppercase tracking-wider text-gray-500">
                        <tr>
                            <th class="px-6 py-3">@lang('product.column_date')</th>
                            <th class="px-6 py-3">@lang('product.column_price')</th>
                            <th class="px-6 py-3">@lang('product.column_old_price')</th>
                            <th class="px-6 py-3">@lang('product.column_promotion')</th>
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
                                            @lang('product.yes')
                                        </span>
                                    @else
                                        <span class="text-gray-400">@lang('product.no')</span>
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
