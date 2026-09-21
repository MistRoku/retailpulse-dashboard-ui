# RetailPulse Dashboard UI

## Overview

Laravel Blade + Tailwind CSS 3.4 + Alpine.js 3 frontend architecture demo. All data is synthetic (no database, no API). Tests are PHPUnit feature tests asserting routes return 200 and key content renders.

## Running

```sh
composer install
cp .env.example .env && php artisan key:generate
npm install
npm run build
php artisan serve
```

## Testing

```sh
php artisan test
```

All 12 tests must pass before pushing. The `RoutesTest` covers every registered route.

## Project Structure

- `resources/views/` — Blade components and pages
- `resources/js/components/` — Alpine.js data components
- `resources/css/app.css` — Tailwind layers and design tokens
- `app/Support/RetailPulseData.php` — hardcoded mock data
- `tests/Feature/RoutesTest.php` — route coverage

## Conventions

- No shadows, no gradients, no border-radius. Radical minimalism.
- Design tokens: `#FDFBF7` bg, `#2C3E30` ink, `#4A5D50` muted, `#8DA399` border.
- Components use `rp-*` CSS classes for consistency.
- Alpine components are registered in `resources/js/app.js`.
- Routes are defined in `routes/web.php`.
