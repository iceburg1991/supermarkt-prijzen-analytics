{{-- Highcharts line chart wrapped in an Alpine.js component --}}
<div
    x-data="chartLine({
        apiUrl: @js($apiUrl),
        locale: @js($locale),
        chartTitle: @js($chartTitle),
        seriesName: @js($seriesName),
        yAxisLabel: @js($yAxisLabel),
        promotionLabel: @js($promotionLabel),
    })"
    x-init="init()"
    x-on:teardown.window="destroy()"
    {{ $attributes->merge(['class' => 'w-full']) }}
>
    {{-- Chart render target --}}
    <div x-ref="chartContainer" x-show="!loading && !error" class="w-full" style="min-height: 300px;"></div>

    {{-- Loading spinner --}}
    <div x-show="loading" class="flex items-center justify-center py-12">
        <svg class="h-8 w-8 animate-spin text-[#325ff4]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
        </svg>
    </div>

    {{-- Error message --}}
    <div x-show="error" x-cloak class="rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-600">
        <span x-text="error"></span>
    </div>
</div>
