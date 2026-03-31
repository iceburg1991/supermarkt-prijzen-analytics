# Highcharts Guidelines

## Version
- Highcharts 12.x (installed via npm)

## Import Strategy
- Never import Highcharts globally in `app.js` — it's a large library
- Import per component/page where charts are needed:
```js
import Highcharts from 'highcharts';
```

## Primary Chart Type
- Bar charts are the primary visualization type
- Other chart types may be used but bar charts are the default

## Theme & Colors
- Brand colors are defined in `product.md` steering
- Primary series color: `#325ff4` (brand blue)
- Use shades/tints of brand blue for multiple series
- Grid and axis lines: `#f1f5f9` (slate-100)
- Apply global defaults via `Highcharts.setOptions()` in a shared config file

## Interactivity
- Tooltips: enabled by default on all charts
- Click events: charts must be clickable for drill-down / detail navigation
- Animations: enabled by default

## Responsive
- Charts must be responsive (`chart: { reflow: true }`)
- Primary target is desktop, but must work on mobile

## Localization (Multi-language: NL / EN)
- Supported locales: Dutch (NL) and English (EN)
- Default locale: NL
- Locale is determined by `app()->getLocale()` and passed to the frontend
- Define separate lang config objects per locale:
  - NL: comma decimal, dot thousands, Dutch month/day names
  - EN: dot decimal, comma thousands, English month/day names
- Apply the active locale via `Highcharts.setOptions({ lang: ... })` before rendering any chart
- Chart titles, axis labels, and tooltip text should use Laravel translation strings (`__()` / `@lang()`) passed via Blade props
- Keep locale configs in a shared JS module (e.g. `resources/js/highcharts-locales.js`)

## Data Loading
- Data loading strategy varies per chart — always ask how data should be fetched
- Options: server-side via Blade props (`@json()`), or async via API endpoint
- Prefer server-side data aggregation over client-side processing

## Integration with Alpine.js
- Wrap chart initialization in Alpine components using `x-init` or `x-data`
- Destroy chart instances on component teardown to prevent memory leaks

## Integration with Blade
- Create dedicated Blade components for reusable chart types (e.g. `<x-chart-bar>`)
- Pass data from PHP to charts via Blade component props or `@json()` directive
- Keep chart configuration in JS, pass only data from the server

## Not Enabled
- Exporting (PNG/PDF/CSV): not needed
- Dark mode: not needed
- Accessibility module: not needed for POC

## Performance
- Lazy-load charts below the fold or inside tabs
- Use `turboThreshold` for large datasets
- Avoid re-creating chart instances — use `chart.update()` or `series.setData()` for dynamic updates

## Licensing
- Highcharts requires a commercial license for commercial use
- Verify license compliance for production deployment
