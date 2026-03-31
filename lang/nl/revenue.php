<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Revenue Chart Translations (NL)
    |--------------------------------------------------------------------------
    |
    | Dutch translations for the weekly revenue stacked bar chart feature.
    |
    */

    // Chart labels
    'chart_title' => 'Wekelijkse Omzet',
    'base_revenue' => 'Basisomzet',
    'bonus_revenue' => 'Bonusomzet',
    'y_axis_label' => 'Omzet (€)',

    // Series filter
    'filter_all' => 'Alle omzet',
    'filter_base' => 'Basisomzet',
    'filter_bonus' => 'Bonusomzet',

    // Tooltip
    'tooltip_total' => 'Totaal',
    'tooltip_week' => 'Week',

    // Architecture explanation
    'architecture_intro' => 'Deze grafiek toont de wekelijkse omzet als een stacked bar chart, opgebouwd met Highcharts en Alpine.js.',
    'architecture_dataset' => 'De dataset is beperkt en statisch: maximaal 52 weken (één jaar) aan omzetdata. Dit heeft de architectuurkeuzes beïnvloed.',
    'architecture_single_call' => 'Alle data wordt in één API call opgehaald en volledig in browser-memory gehouden.',
    'architecture_client_filter' => 'Filtering vindt client-side plaats via Alpine.js met series.setVisible(), zonder extra API calls, omdat de dataset klein genoeg is.',
    'architecture_scaling' => 'Bij grotere of dynamische datasets zouden andere keuzes gemaakt worden, zoals server-side filtering, paginatie of streaming.',

];
