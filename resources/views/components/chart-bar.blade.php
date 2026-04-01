{{-- Highcharts stacked bar chart wrapped in an Alpine.js component --}}
<div
    x-data="chartBar({
        apiUrl: @js($apiUrl),
        locale: @js($locale),
        chartTitle: @js($chartTitle),
        baseRevenueName: @js($baseRevenueName),
        bonusRevenueName: @js($bonusRevenueName),
        yAxisLabel: @js($yAxisLabel),
        tooltipTotal: @js($tooltipTotal),
        tooltipWeek: @js($tooltipWeek),
    })"
    x-init="init()"
    x-on:teardown.window="destroy()"
    @filter-change.window="applyFilter($event.detail.filter)"
    {{ $attributes->merge(['class' => 'w-full']) }}
>
    {{-- Chart render target --}}
    <div x-ref="chartContainer" x-show="!loading && !error" class="w-full" style="min-height: 400px;"></div>

    {{-- Performance metrics panel --}}
    <div x-show="perfMeta && !loading && !error" x-cloak class="mt-4 rounded-lg border border-slate-200 bg-slate-50 p-4">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-full" :class="perfMeta?.cache_hit ? 'bg-green-100 text-green-600' : 'bg-blue-100 text-blue-600'">
                    <i class="fa-solid text-lg" :class="perfMeta?.cache_hit ? 'fa-bolt' : 'fa-database'"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-slate-900">
                        Data geladen vanuit <span x-text="perfMeta?.cache_hit ? 'cache' : 'database'"></span>
                    </p>
                    <p class="text-xs text-slate-500">
                        Query tijd: <span class="font-mono font-medium" x-text="perfMeta?.query_time_ms + 'ms'"></span>
                    </p>
                </div>
            </div>
            <button
                type="button"
                class="inline-flex items-center gap-1.5 rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm font-medium text-slate-700 shadow-sm transition-colors hover:bg-slate-50 disabled:opacity-50"
                :disabled="clearing"
                @click="clearCacheAndReload()"
            >
                <i class="fa-solid" :class="clearing ? 'fa-spinner fa-spin' : 'fa-trash'"></i>
                <span x-text="clearing ? 'Bezig...' : 'Cache legen'"></span>
            </button>
        </div>
    </div>

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
