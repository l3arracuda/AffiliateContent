# Changelog

## v0.1.1 — Phase 0 QA fixes

- Blocked additional personal-use claims, including “I have tried” and “I've tested”, across draft text and prompts before a product reaches a real-use stage.
- Excluded rejected and archived products from Market Watch opportunities, top opportunities, and main content selection while retaining them in the all-products view.
- Reflowed Market Watch filters into one column on mobile screens.
- Verified the 390px layout in Chrome with no horizontal overflow and verified a browser click copies the mock affiliate URL to the clipboard.

## v0.1.0 — Phase 0 foundation

- Bootstrapped Laravel 12 with SQLite as the local default and MySQL/MariaDB configuration support.
- Added products, images, snapshots, pages, content drafts, and activity logs.
- Added the canonical product lifecycle and freshness timestamps.
- Added Dashboard, Market Watch filters, product detail and editing, mock image downloads, content matrix, pages, and settings screens.
- Added 24 fictional products, 5 pages, 7 content drafts, 49 local image records, and 24 snapshots.
- Enforced EXTRA COMM for the main opportunity and content workflow, with basic protection against pre-test personal-use claims.
- Added setup documentation and automated Phase 0 tests.

Verification: migration and repeatable seeding passed; 17 automated tests passed with 69 assertions; local HTTP checks returned 200 for key pages and downloads. User acceptance and Work QA remain pending.
