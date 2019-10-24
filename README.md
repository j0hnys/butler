# Butler

Butler is an Implementation Manager for laravel applications made with [Trident](https://github.com/j0hnys/trident) and [Vista](https://github.com/j0hnys/vista).

**video introduction at:** https://www.youtube.com/watch?v=4zuZATtU1GA

## Installation

 1. clone repo and `cd` to it
 2. `composer update`
 3. `npm install`
 4. make `.env` from `.env.example`. Update variables if necessary. `MIX_BASE_URL_BACKEND` and `MIX_BASE_RELATIVE_URL_BACKEND` must match current url. If not update them and `npm run prod`
 5. `php artisan key:generate`
 6. make `config/database.php` from `config/database.butler.php`
 7. `php artisan migrate`