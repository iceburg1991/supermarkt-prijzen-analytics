<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

/**
 * Reusable Highcharts line chart component.
 *
 * Wraps a Highcharts chart in an Alpine.js component that handles
 * async data fetching, locale configuration, and chart lifecycle.
 */
class ChartLine extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $apiUrl,
        public string $locale = 'nl',
        public string $chartTitle = '',
        public string $seriesName = '',
        public string $yAxisLabel = '',
    ) {}

    /**
     * Get the view that represents the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.chart-line');
    }
}
