# Butler

Butler is an Implementation Manager for laravel applications made with [Trident](https://github.com/j0hnys/trident) and [Vista](https://github.com/j0hnys/vista).

## Installation

 1. clone repo and `cd` to it
 2. `composer update`
 3. `npm install`
 4. make `.env` from `.env.example`. update variables if necessary
 5. `php artisan key:generate`
 6. make `config/database.php` from `config/database.butler.php`
 7. `php artisan migrate`