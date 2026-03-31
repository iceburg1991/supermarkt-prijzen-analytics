# Project Structure

This project follows DDD and SRP principles while staying close to Laravel's standard directory structure. No separate Architecture/, Infrastructure/, or Domain/ folders.

```
├── app/
│   ├── Http/
│   │   └── Controllers/          # Thin HTTP controllers — delegate to Services
│   ├── Models/                   # Eloquent models
│   ├── Services/                 # Business logic & data aggregation (DDD service layer)
│   ├── Providers/                # Service providers
│   └── View/
│       └── Components/           # Blade component classes (Laravel standard)
├── bootstrap/                    # Framework bootstrap files
├── config/                       # Configuration files
├── database/
│   ├── factories/                # Model factories for testing
│   ├── migrations/               # Database migrations
│   └── seeders/                  # Database seeders
├── lang/
│   ├── nl/                       # Dutch translations
│   └── en/                       # English translations
├── public/                       # Web server document root
├── resources/
│   ├── css/                      # Stylesheets (processed by Vite)
│   ├── js/                       # JavaScript modules (processed by Vite)
│   └── views/
│       ├── components/           # Blade component templates
│       └── {resource}/           # Resource-specific views (e.g., dashboard/)
├── routes/
│   ├── web.php                   # Web routes
│   └── console.php               # Artisan commands
├── storage/                      # Logs, cache, compiled views
├── tests/
│   ├── Feature/                  # Feature/integration tests
│   └── Unit/                     # Unit tests
└── vendor/                       # Composer dependencies
```

## Architecture Principles

- **DDD light**: Business logic lives in `app/Services/`, not in controllers or models
- **SRP**: Each class has one responsibility — controllers handle HTTP, services handle logic, models handle data
- **Laravel standard**: No custom base folders — use Laravel's conventions (`make:component`, `make:model`, etc.)
- **Thin controllers**: Controllers delegate to service classes, never contain business logic directly
- **Performance-first / Big Data mindset**: This is a POC for big data processing — all design decisions must prioritize query performance
  - Denormalize where it avoids expensive JOINs on large tables (e.g., `week_number` and `year` on detail tables)
  - Store pre-aggregated values instead of recalculating (e.g., `revenue_contribution` as a snapshot)
  - Use composite indexes that match common query patterns
  - Prefer `restrictOnDelete()` over `cascadeOnDelete()` — protect historical data, never silently delete
  - Eager load relationships, use `chunk()` / `chunkById()` for large datasets
  - Server-side data aggregation over client-side processing

## Key Conventions

### Models
- Located in `app/Models/`
- Use PHP 8 attributes for `#[Fillable]` and `#[Hidden]`
- Extend `Illuminate\Database\Eloquent\Model` or `Authenticatable`

### Controllers
- Located in `app/Http/Controllers/`
- Extend base `Controller` class
- Keep thin — inject and delegate to Services
- Use resource controllers when appropriate

### Services
- Located in `app/Services/`
- Contain business logic, data aggregation, and domain operations
- Injected into controllers via constructor dependency injection
- One service per domain concern (e.g., `ChartDataService`, `ProductService`)

### Blade Components
- Class: `app/View/Components/` (generated via `php artisan make:component`)
- Template: `resources/views/components/`
- Used for reusable UI elements (e.g., `<x-chart-bar>`)

### JavaScript Modules
- Located in `resources/js/`
- Shared configs as separate modules (e.g., `highcharts-config.js`, `highcharts-locales.js`)
- Import per component/page, never globally in `app.js` for heavy libraries

### Routes
- Web routes in `routes/web.php`
- API routes in `routes/api.php` (create if needed)
- Group related routes with prefixes and middleware

### Translations
- Located in `lang/{locale}/`
- Default locale: NL
- All UI-facing text via `__()` / `@lang()`

### Migrations
- Timestamped files in `database/migrations/`
- Use descriptive names: `create_tablename_table`, `add_column_to_table`

### Views
- Blade templates in `resources/views/`
- Organized per resource: `resources/views/{resource}/index.blade.php`
- Use layouts and components for reusability

### Tests
- Feature tests for HTTP endpoints and integrations
- Unit tests for isolated class/method testing
- Name test methods in camelCase, always starting with `test`
