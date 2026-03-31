# Tech Stack

## Backend
- PHP 8.3+
- Laravel 13.x framework
- SQLite (default), MySQL/MariaDB/PostgreSQL/SQL Server supported

## Frontend
- Vite 8.x (asset bundling)
- Tailwind CSS 4.x
- Blade templating engine
- Axios for HTTP requests

## Development Tools
- Laravel Pint (code formatting)
- PHPUnit 12.x (testing)
- Laravel Pail (log tailing)
- Faker (test data generation)
- Mockery (mocking)

## Common Commands

```bash
# Initial setup
composer setup

# Start development server (runs server, queue, logs, vite concurrently)
composer dev

# Run tests
composer test
# or
php artisan test

# Code formatting
./vendor/bin/pint

# Database
php artisan migrate
php artisan migrate:fresh --seed
php artisan db:seed

# Cache management
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# Generate code
php artisan make:model ModelName -mfc  # with migration, factory, controller
php artisan make:controller ControllerName
php artisan make:migration create_table_name

# Tinker (REPL)
php artisan tinker
```

## Testing

- Unit tests: `tests/Unit/`
- Feature tests: `tests/Feature/`
- Tests use in-memory SQLite database
- Run specific test: `php artisan test --filter=TestName`
