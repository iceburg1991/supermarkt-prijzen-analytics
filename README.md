# SupermarketData POC

Proof of Concept webapplicatie voor SupermarketData Inc. — een dashboard voor het analyseren van supermarktprijzen en omzetdata met big data capabilities.

## Tech Stack

- PHP 8.4 / Laravel 13
- SQLite (default)
- Tailwind CSS 4
- Alpine.js
- Highcharts 12.x
- Vite 8.x

## Installatie

```bash
# Clone de repository
git clone <repository-url>
cd supermarketdata-poc

# Installeer PHP dependencies
composer install

# Installeer Node dependencies
npm install

# Kopieer environment file
cp .env.example .env

# Genereer application key
php artisan key:generate

# Maak database en seed met testdata (~520K records)
php artisan migrate:fresh --seed
```

## Development

```bash
# Start development server (Laravel + Vite + Queue)
composer dev

# Of apart:
php artisan serve      # Laravel server op http://localhost:8000
npm run dev            # Vite dev server met hot reload
```

## Handige Commando's

```bash
# Database opnieuw seeden (duurt ~1-2 min voor 520K records)
php artisan migrate:fresh --seed

# Cache legen
php artisan cache:clear

# Alle caches legen
php artisan optimize:clear

# Tests draaien
php artisan test

# Code formatting
./vendor/bin/pint
```

## Big Data Demo

De POC demonstreert big data handling met:

- **~520.000 weekly_revenue_products records** (10K producten × 52 weken)
- **Pre-geaggregeerde data** — geen realtime queries over miljoenen transacties
- **Application-level caching** — query resultaten worden 15 minuten gecached
- **Performance metrics** — elke chart toont query tijd en cache status

### Cache Demo

Op de Grafiek-pagina en product detail pagina's zie je een performance paneel:
1. Klik "Cache legen" → data wordt opgehaald uit database (~15-50ms)
2. Refresh → data komt uit cache (~1-5ms)

## Project Structuur

```
app/
├── Http/Controllers/Api/    # API controllers (JSON responses)
├── Http/Controllers/        # Web controllers (Blade views)
├── Services/                # Business logic (DDD service layer)
├── Data/                    # DTOs
└── Models/                  # Eloquent models

resources/
├── js/                      # JavaScript modules
│   ├── chart-bar.js         # Stacked bar chart component
│   ├── chart-line.js        # Line chart component
│   ├── highcharts-config.js # Shared Highcharts defaults
│   └── highcharts-locales.js# NL/EN locale configs
└── views/
    ├── components/          # Blade components
    └── dashboard/           # Dashboard views
```

## API Endpoints

| Endpoint | Beschrijving |
|----------|-------------|
| `GET /api/revenue` | Globale weekly revenue data |
| `GET /api/revenue/product/{id}` | Product-specifieke revenue data |
| `GET /api/product/{id}/prices` | Prijsgeschiedenis voor product |
| `DELETE /api/cache/revenue` | Cache legen (POC demo) |

## Meertaligheid

De applicatie ondersteunt Nederlands (NL) en Engels (EN). Wissel via de knoppen rechtsboven in de navigatie.
