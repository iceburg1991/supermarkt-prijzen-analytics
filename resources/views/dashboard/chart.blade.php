@extends('layouts.app')

@section('title', __('revenue.chart_title'))

@section('content')
    <h1 class="mb-6 text-2xl font-semibold text-gray-900">@lang('revenue.chart_title')</h1>

    {{-- Architecture explanation --}}
    <div class="mb-6 rounded-lg border border-gray-200 bg-gray-50 p-5 text-sm leading-relaxed text-gray-600">
        <p class="mb-2 font-medium text-gray-700">@lang('revenue.architecture_intro')</p>
        <ul class="list-inside list-disc space-y-1">
            <li>@lang('revenue.architecture_dataset')</li>
            <li>@lang('revenue.architecture_single_call')</li>
            <li>@lang('revenue.architecture_client_filter')</li>
            <li>@lang('revenue.architecture_scaling')</li>
        </ul>
    </div>

    {{-- Chart card with filter and chart component --}}
    <div class="rounded-lg bg-white p-6 shadow-sm" x-data="{ activeFilter: 'all' }">

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
            :api-url="url('/api/revenue')"
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
