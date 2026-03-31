<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Revenue Chart Translations (EN)
    |--------------------------------------------------------------------------
    |
    | English translations for the weekly revenue stacked bar chart feature.
    |
    */

    // Chart labels
    'chart_title' => 'Weekly Revenue',
    'base_revenue' => 'Base Revenue',
    'bonus_revenue' => 'Bonus Revenue',
    'y_axis_label' => 'Revenue (€)',

    // Series filter
    'filter_all' => 'All Revenue',
    'filter_base' => 'Base Revenue',
    'filter_bonus' => 'Bonus Revenue',

    // Tooltip
    'tooltip_total' => 'Total',
    'tooltip_week' => 'Week',

    // Architecture explanation
    'architecture_intro' => 'This chart displays weekly revenue as a stacked bar chart, built with Highcharts and Alpine.js.',
    'architecture_dataset' => 'The dataset is limited and static: a maximum of 52 weeks (one year) of revenue data. This influenced the architectural decisions.',
    'architecture_single_call' => 'All data is fetched in a single API call and kept entirely in browser memory.',
    'architecture_client_filter' => 'Filtering is handled client-side via Alpine.js using series.setVisible(), without additional API calls, because the dataset is small enough.',
    'architecture_scaling' => 'For larger or dynamic datasets, different choices would be made, such as server-side filtering, pagination, or streaming.',

];
