/**
 * Shared Highcharts default configuration.
 *
 * Applies global styling defaults (colors, fonts, grid, animations)
 * via Highcharts.setOptions(). Call this once per component before
 * rendering a chart.
 *
 * @param {object} Highcharts - The Highcharts module instance.
 */
export function applyHighchartsDefaults(Highcharts) {
    Highcharts.setOptions({
        chart: {
            reflow: true,
            animation: true,
            style: {
                fontFamily: 'Inter, system-ui, sans-serif',
            },
        },
        xAxis: {
            gridLineColor: '#f1f5f9',
            lineColor: '#f1f5f9',
            tickColor: '#f1f5f9',
        },
        yAxis: {
            gridLineColor: '#f1f5f9',
            lineColor: '#f1f5f9',
            tickColor: '#f1f5f9',
        },
        credits: {
            enabled: false,
        },
    });
}
