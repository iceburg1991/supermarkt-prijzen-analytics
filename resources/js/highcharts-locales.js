/**
 * Highcharts locale configurations for NL and EN.
 *
 * Each locale defines decimal/thousands separators and
 * localized month/day names used by Highcharts formatting.
 */

export const locales = {
    nl: {
        decimalPoint: ',',
        thousandsSep: '.',
        months: [
            'januari', 'februari', 'maart', 'april', 'mei', 'juni',
            'juli', 'augustus', 'september', 'oktober', 'november', 'december',
        ],
        shortMonths: [
            'jan', 'feb', 'mrt', 'apr', 'mei', 'jun',
            'jul', 'aug', 'sep', 'okt', 'nov', 'dec',
        ],
        weekdays: [
            'zondag', 'maandag', 'dinsdag', 'woensdag',
            'donderdag', 'vrijdag', 'zaterdag',
        ],
        numericSymbols: null,
    },
    en: {
        decimalPoint: '.',
        thousandsSep: ',',
        months: [
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December',
        ],
        shortMonths: [
            'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
            'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec',
        ],
        weekdays: [
            'Sunday', 'Monday', 'Tuesday', 'Wednesday',
            'Thursday', 'Friday', 'Saturday',
        ],
        numericSymbols: null,
    },
};

/**
 * Apply the locale matching the given key to Highcharts.
 *
 * Falls back to NL when the requested locale is not defined.
 *
 * @param {object} Highcharts - The Highcharts module instance.
 * @param {string} locale     - Locale key ('nl' or 'en').
 */
export function applyLocale(Highcharts, locale) {
    const lang = locales[locale] ?? locales.nl;

    Highcharts.setOptions({ lang });
}
