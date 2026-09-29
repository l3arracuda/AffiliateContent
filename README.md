# AffiliateContent

An internal Laravel web application for a Shopee affiliate workflow. Phase 0 provides a database-backed foundation with fictional products. It does not connect to Shopee, generate live links, use paid APIs, or publish content.

## Business workflow

Market Watch → require EXTRA COMM → inspect links and images → choose opportunities → draft distinct content for five pages → measure results in later phases → order winning products → make real reviews. See PROJECT_OVERVIEW.md for the project-wide direction.

EXTRA COMM is a hard eligibility requirement for the main opportunity list and content workflow. Rejected and archived products are excluded from those workflows even if they have EXTRA COMM. All products remain visible on the all-products page. Pre-test content is non-personal; real review drafts require a received, real_review, or scaling product.

## Current phase and stack

- Phase 0, version v0.1.1
- Laravel 12, PHP 8.2 or newer (PHP 8.3+ preferred for the long-term environment)
- Blade with local CSS and JavaScript; no Node build is needed
- SQLite by default for local evaluation; MySQL/MariaDB can be configured in .env

## Requirements

PHP 8.2+ with pdo_sqlite, mbstring, openssl, fileinfo, and zip; Composer 2. MySQL/MariaDB is optional.

## Install and run

From this repository, run:

    composer install
    Copy-Item .env.example .env
    php artisan key:generate
    New-Item database/database.sqlite -ItemType File -Force
    php artisan migrate --seed
    php artisan serve --host=127.0.0.1 --port=8000

Open http://127.0.0.1:8000. The local .env and SQLite database are ignored by Git. To use MySQL/MariaDB, create a database and set DB_CONNECTION=mysql, DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, and DB_PASSWORD in .env before migration. Never commit credentials.

For a repeatable QA dataset in a disposable database, run php artisan migrate:fresh --seed. This drops existing tables, so use it only when replacing local test data is intended. Running php artisan db:seed again is safe for seeded records.

## Browser pages

| Page | URL | Purpose |
| --- | --- | --- |
| Dashboard | / | Database counts and top mock opportunities |
| Market Watch | /market-watch | Main list, EXTRA COMM on by default |
| Products | /products | All products, including those outside main eligibility |
| Product detail | /products/{id} | Links, images, downloads, freshness, snapshots, content matrix |
| Add product | /products/create | Manual entry with validation |
| Content | /contents | Drafts and page relationships |
| Create draft | /contents/create | Manual draft with page and experience rules |
| Pages | /pages | Five seeded strategies |
| Settings | /settings | Phase and integration boundaries |

The product detail page copies a mock affiliate URL through the browser clipboard API. Browsers generally require localhost or HTTPS for clipboard access. If copying fails, the URL remains visible for manual copying. Image buttons download bundled SVG placeholders; Download all creates a ZIP.

## Data and project structure

The migration creates products, product_images, product_snapshots, pages, contents, and activity_logs alongside Laravel's standard framework tables. Products include the canonical status enum, eligibility and score fields, and four freshness timestamps. The seeder creates 24 fictional products, 5 pages, 7 content drafts, local images of varying availability, and 24 snapshots across eight products. Missing links and images allow QA of empty states and filters.

- app/Enums/ProductStatus.php: canonical product lifecycle
- app/Models: relationships and main opportunity query scope
- app/Http/Controllers: dashboard, filters, editing, drafts, downloads, and copy logging
- resources/views: Blade screens and navigation
- public/mock-products: local placeholder artwork
- public/css and public/js: static interface assets
- tests/Feature/PhaseZeroTest.php: core Phase 0 checks

## Tests

Run php artisan test. The suite uses an in-memory SQLite database independently of the local .env database.

## Known limitations and later phases

This is an internal local preview without user authentication. Bind the development server to localhost. Product details and commissions are fictional and not verified marketplace data. The content claim check covers common examples but is not a complete review; a human must verify all copy before publishing. There is no real product import, Internet image download, live affiliate link generation, AI generation, posting automation, performance tracking, or winner algorithm. These belong to later phases after source availability, permissions, and platform terms are reviewed.
