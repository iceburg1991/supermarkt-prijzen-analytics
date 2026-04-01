/**
 * Alpine.js component for the price history line chart.
 *
 * Handles async data fetching, Highcharts initialization,
 * and proper chart cleanup.
 *
 * Highcharts is dynamically imported on init to avoid loading
 * the library on pages that don't use this component.
 *
 * @param {object} config - Component configuration from Blade props.
 * @returns {object} Alpine.js component definition.
 */
export default function chartLine(config) {
    return {
        chart: null,
        loading: true,
        error: null,

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

                applyLocale(Highcharts, config.locale);
                applyHighchartsDefaults(Highcharts);

                const response = await fetch(config.apiUrl);

                if (!response.ok) {
                    throw new Error(`HTTP ${response.status}`);
                }

                const json = await response.json();
                const data = json.data;

                this.loading = false;
                this.renderChart(Highcharts, data);
            } catch (e) {
                this.loading = false;
                this.error = `Failed to load chart data: ${e.message}`;
            }
        },

        /**
         * Render the Highcharts line chart.
         *
         * @param {object} Highcharts - The Highcharts module.
         * @param {object} data       - API response with categories and series arrays.
         */
        renderChart(Highcharts, data) {
            const locale = config.locale;
            const decimalSep = locale === 'nl' ? ',' : '.';
            const thousandsSep = locale === 'nl' ? '.' : ',';
            const seriesName = config.seriesName;
            const promotionLabel = config.promotionLabel || 'Promotie';
            const weekNumbers = data.weekNumbers ?? [];
            const isPromotion = data.isPromotion ?? [];

            // Build series data with per-point marker colors for promotions
            const seriesData = (data.series[0]?.data ?? []).map((value, index) => {
                const point = { y: value };

                if (isPromotion[index]) {
                    point.marker = {
                        fillColor: '#16a34a', // green-600 for promotions
                        radius: 5,
                        lineWidth: 2,
                        lineColor: '#16a34a',
                    };
                }

                return point;
            });

            this.chart = Highcharts.chart(this.$refs.chartContainer, {
                chart: {
                    type: 'line',
                    reflow: true,
                },
                title: {
                    text: config.chartTitle,
                },
                xAxis: {
                    categories: data.categories,
                    crosshair: true,
                    labels: {
                        rotation: -45,
                        style: {
                            fontSize: '11px',
                        },
                    },
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: config.yAxisLabel,
                    },
                },
                tooltip: {
                    shared: true,
                    useHTML: true,
                    formatter: function () {
                        const pointIndex = this.point.index;
                        const date = this.point.category;
                        const value = this.y;
                        const weekNumber = weekNumbers[pointIndex] ?? '';
                        const promo = isPromotion[pointIndex] ?? false;

                        let html = `<b>${date}</b>`;
                        if (weekNumber) {
                            html += `<br/><span style="font-size:11px;color:#6b7280">${weekNumber}</span>`;
                        }
                        html += `<br/><span style="color:${this.point.color}">●</span> `;
                        html += `${seriesName}: <b>€${formatNumber(value, decimalSep, thousandsSep)}</b>`;

                        if (promo) {
                            html += `<br/><span style="color:#16a34a;font-weight:600">⬤ ${promotionLabel}</span>`;
                        }

                        return html;
                    },
                },
                plotOptions: {
                    line: {
                        marker: {
                            enabled: true,
                            radius: 3,
                        },
                        lineWidth: 2,
                    },
                },
                series: [
                    {
                        name: config.seriesName,
                        data: seriesData,
                        color: '#325ff4',
                    },
                ],
                legend: {
                    enabled: false,
                },
            });
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
