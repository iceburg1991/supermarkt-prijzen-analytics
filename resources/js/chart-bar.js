/**
 * Alpine.js component for the stacked bar revenue chart.
 *
 * Handles async data fetching, Highcharts initialization,
 * series visibility toggling, and proper chart cleanup.
 *
 * Highcharts is dynamically imported on init to avoid loading
 * the library on pages that don't use this component.
 *
 * @param {object} config - Component configuration from Blade props.
 * @returns {object} Alpine.js component definition.
 */
export default function chartBar(config) {
    return {
        chart: null,
        loading: true,
        error: null,
        perfMeta: null,
        clearing: false,
        Highcharts: null,

        /**
         * Initialize the chart: dynamically import Highcharts, apply config, fetch data, render.
         */
        async init() {
            try {
                const [{ default: Highcharts }, { applyHighchartsDefaults }, { applyLocale }] =
                    await Promise.all([
                        import('highcharts'),
                        import('./highcharts-config.js'),
                        import('./highcharts-locales.js'),
                    ]);

                this.Highcharts = Highcharts;
                applyLocale(Highcharts, config.locale);
                applyHighchartsDefaults(Highcharts);

                await this.loadData();
            } catch (e) {
                this.loading = false;
                this.error = `Failed to load chart data: ${e.message}`;
            }
        },

        /**
         * Fetch data from API and render chart.
         */
        async loadData() {
            this.loading = true;
            this.error = null;

            try {
                const response = await fetch(config.apiUrl);

                if (!response.ok) {
                    throw new Error(`HTTP ${response.status}`);
                }

                const json = await response.json();
                const data = json.data;

                // Store performance metrics for display (meta is inside data)
                this.perfMeta = data.meta ?? null;

                this.loading = false;
                this.renderChart(this.Highcharts, data);
            } catch (e) {
                this.loading = false;
                this.error = `Failed to load chart data: ${e.message}`;
            }
        },

        /**
         * Clear the server-side cache and reload data.
         */
        async clearCacheAndReload() {
            this.clearing = true;

            try {
                await fetch('/api/cache/revenue', { method: 'DELETE' });
                await this.loadData();
            } catch (e) {
                this.error = `Failed to clear cache: ${e.message}`;
            } finally {
                this.clearing = false;
            }
        },

        /**
         * Get formatted performance label for display.
         *
         * @returns {string} Performance label like "⚡ 2.5ms (cached)" or "🔍 45ms (database)"
         */
        get perfLabel() {
            if (!this.perfMeta) return '';

            const icon = this.perfMeta.cache_hit ? '⚡' : '🔍';
            const source = this.perfMeta.cache_hit ? 'cached' : 'database';
            const time = this.perfMeta.query_time_ms;

            return `${icon} ${time}ms (${source})`;
        },

        /**
         * Render the Highcharts stacked bar chart.
         *
         * @param {object} Highcharts - The Highcharts module.
         * @param {object} data       - API response with categories and series arrays.
         */
        renderChart(Highcharts, data) {
            const locale = config.locale;
            const decimalSep = locale === 'nl' ? ',' : '.';
            const thousandsSep = locale === 'nl' ? '.' : ',';
            const weekStarts = data.weekStarts ?? [];

            this.chart = Highcharts.chart(this.$refs.chartContainer, {
                chart: {
                    type: 'column',
                    reflow: true,
                },
                title: {
                    text: config.chartTitle,
                },
                xAxis: {
                    categories: data.categories,
                    crosshair: true,
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: config.yAxisLabel,
                    },
                    stackLabels: {
                        enabled: false,
                    },
                },
                tooltip: {
                    shared: true,
                    useHTML: true,
                    formatter() {
                        const category = this.points[0].key;
                        const pointIndex = this.points[0].point.index;
                        const weekStart = weekStarts[pointIndex] ?? '';
                        const parts = category.match(/W(\d+)\s+(\d+)/);
                        const weekNum = parts ? parts[1] : '';
                        const year = parts ? parts[2] : '';

                        let html = `<b>${weekStart}</b>`;
                        if (weekNum && year) {
                            html += `<br/><span style="font-size:11px;color:#6b7280">${config.tooltipWeek} ${weekNum} — ${year}</span>`;
                        }
                        html += '<br/>';

                        let total = 0;
                        this.points.forEach((point) => {
                            total += point.y;
                            html += `<span style="color:${point.color}">●</span> `;
                            html += `${point.series.name}: <b>€${formatNumber(point.y, decimalSep, thousandsSep)}</b><br/>`;
                        });

                        html += `<br/><b>${config.tooltipTotal}: €${formatNumber(total, decimalSep, thousandsSep)}</b>`;

                        return html;
                    },
                },
                plotOptions: {
                    column: {
                        stacking: 'normal',
                        borderWidth: 0,
                        borderRadius: 2,
                    },
                },
                series: [
                    {
                        name: config.baseRevenueName,
                        data: data.series[0]?.data ?? [],
                        color: '#325ff4',
                    },
                    {
                        name: config.bonusRevenueName,
                        data: data.series[1]?.data ?? [],
                        color: '#f59e0b',
                    },
                ],
                legend: {
                    enabled: true,
                },
            });
        },

        /**
         * Toggle series visibility by filter type.
         *
         * @param {'all'|'base'|'bonus'} filter - Which series to show.
         */
        applyFilter(filter) {
            if (!this.chart) return;

            const baseSeries = this.chart.series[0];
            const bonusSeries = this.chart.series[1];

            switch (filter) {
                case 'base':
                    baseSeries.setVisible(true, false);
                    bonusSeries.setVisible(false, false);
                    break;
                case 'bonus':
                    baseSeries.setVisible(false, false);
                    bonusSeries.setVisible(true, false);
                    break;
                default:
                    baseSeries.setVisible(true, false);
                    bonusSeries.setVisible(true, false);
                    break;
            }

            this.chart.redraw();
        },

        /**
         * Destroy the chart instance on component teardown.
         */
        destroy() {
            if (this.chart) {
                this.chart.destroy();
                this.chart = null;
            }
        },
    };
}

/**
 * Format a number with locale-specific separators.
 *
 * @param {number} value        - The number to format.
 * @param {string} decimalSep   - Decimal separator character.
 * @param {string} thousandsSep - Thousands separator character.
 * @returns {string} Formatted number string with 2 decimal places.
 */
function formatNumber(value, decimalSep, thousandsSep) {
    const parts = value.toFixed(2).split('.');
    const intPart = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, thousandsSep);

    return `${intPart}${decimalSep}${parts[1]}`;
}
