@extends('layouts.app')

@section('title', $product->name)

@section('content')
    <div class="mb-4 flex items-center justify-between">
        <a href="{{ route('dashboard.index') }}" class="text-sm text-[#325ff4] hover:underline">
            &larr; @lang('product.back_to_overview')
        </a>
    </div>

    @include('product.partials.nav', ['product' => $product, 'active' => 'show'])

    <div class="rounded-lg bg-white p-6 shadow-sm">
        <div class="flex items-start gap-6">
            @if ($product->image_url)
                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="shrink-0 rounded-lg object-contain" style="max-width: 120px; max-height: 120px;">
            @else
                <div class="flex shrink-0 items-center justify-center rounded-lg bg-gray-100 text-sm text-gray-400" style="width: 80px; height: 80px;">—</div>
            @endif

            <div>
                <h1 class="text-2xl font-semibold text-gray-900">{{ $product->name }}</h1>
                <dl class="mt-3 grid grid-cols-2 gap-x-8 gap-y-2 text-sm">
                    <dt class="text-gray-500">Retailer</dt>
                    <dd class="text-gray-900">{{ $product->retailer }}</dd>
                    <dt class="text-gray-500">SKU</dt>
                    <dd class="text-gray-900">{{ $product->sku }}</dd>
                </dl>
            </div>
        </div>
    </div>

    {{-- Product revenue chart --}}
    <div class="mt-6 rounded-lg bg-white p-6 shadow-sm" x-data="{ activeFilter: 'all' }">
        <h2 class="mb-4 text-lg font-semibold text-gray-900">@lang('revenue.chart_title')</h2>

        {{-- Series filter buttons --}}
        <div class="mb-4 flex flex-wrap gap-2">
            <button
                type="button"
                class="rounded-full px-4 py-1.5 text-sm font-medium transition-colors"
                :class="activeFilter === 'all'
                    ? 'bg-[#325ff4] text-white'
                    : 'bg-gray-100 text-gray-600 hover:bg-gray-200'"
                @click="activeFilter = 'all'; $dispatch('filter-change', { filter: 'all' })"
            >
                @lang('revenue.filter_all')
            </button>
            <button
                type="button"
                class="rounded-full px-4 py-1.5 text-sm font-medium transition-colors"
                :class="activeFilter === 'base'
                    ? 'bg-[#325ff4] text-white'
                    : 'bg-gray-100 text-gray-600 hover:bg-gray-200'"
                @click="activeFilter = 'base'; $dispatch('filter-change', { filter: 'base' })"
            >
                @lang('revenue.filter_base')
            </button>
            <button
                type="button"
                class="rounded-full px-4 py-1.5 text-sm font-medium transition-colors"
                :class="activeFilter === 'bonus'
                    ? 'bg-[#325ff4] text-white'
                    : 'bg-gray-100 text-gray-600 hover:bg-gray-200'"
                @click="activeFilter = 'bonus'; $dispatch('filter-change', { filter: 'bonus' })"
            >
                @lang('revenue.filter_bonus')
            </button>
        </div>

        {{-- Highcharts stacked bar chart component --}}
        <x-chart-bar
            :api-url="url('/api/revenue/product/' . $product->id)"
            :locale="$locale"
            :chart-title="__('revenue.chart_title')"
            :base-revenue-name="__('revenue.base_revenue')"
            :bonus-revenue-name="__('revenue.bonus_revenue')"
            :y-axis-label="__('revenue.y_axis_label')"
            :tooltip-total="__('revenue.tooltip_total')"
            :tooltip-week="__('revenue.tooltip_week')"
        />
    </div>
@endsection
