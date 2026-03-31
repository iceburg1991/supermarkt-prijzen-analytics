# Product Overview

POC web application for SupermarketData Inc. Built on Laravel 13 with Tailwind CSS 4, Alpine.js, and Highcharts.

## Branding & Styling

- Primary blue: `#325ff4`
- Background gray: `#f1f5f9` (Tailwind `slate-100`)
- Font: Inter (Google Fonts — https://fonts.google.com/specimen/Inter)
- Icons: FontAwesome (https://fontawesome.com/)
- Use these colors, font, and icon set consistently across all UI components, charts, and styling

## Current State

- Clean Laravel installation with default scaffolding
- User authentication model in place (not yet implemented with routes/views)
- SQLite database configured as default
- Tailwind CSS 4 for styling
- Alpine.js for interactivity
- Highcharts 12.x for data visualization
- Vite for asset bundling

## Locale

- Supported languages: Dutch (NL) and English (EN)
- Default language: Dutch (NL)
- NL: comma as decimal separator, dot as thousands separator, Dutch month/day names
- EN: dot as decimal separator, comma as thousands separator, English month/day names
- Locale is driven by `app()->getLocale()`
