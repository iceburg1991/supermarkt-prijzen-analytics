<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

/**
 * Reusable Highcharts stacked bar chart component.
 *
 * Wraps a Highcharts chart in an Alpine.js component that handles
 * async data fetching, locale configuration, and chart lifecycle.
 */
class ChartBar extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $apiUrl,
        public string $locale = 'nl',
        public string $chartTitle = '',
        public string $baseRevenueName = '',
        public string $bonusRevenueName = '',
        public string $yAxisLabel = '',
        public string $tooltipTotal = '',
        public string $tooltipWeek = '',
    ) {}

    /**
     * Get the view that represents the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.chart-bar');
    }
}
