# Movie App Api

# Description
   This is a coding test. The user can CRUD operation of movies and comment the movies.
# Technical requirement for development, 
   1. Language: PHP >= 8.1
   2. Framework: Laravel 10
   3. API Doc: Scribe (https://scribe.knuckles.wtf)

# Quick Setup
   1. Clone this repo `git clone git@github.com:LinHtetPaing/movie-api.git`
   2. Checkout `main` branch `git checkout main`
   3. Run `composer install`
   4. Create Database
   5. Copy `.env.example` to `.env` and Update `.env`
   6. To install passport run `composer require laravel/passport`
   7. Run `php artisan migrate`
   8. Run `php artisan passport:install`
   9. Run `php artisan passport:client`
   10. Run `php artisan db:seed`
   11. Run `php artisan serve`

# For generating api docs using Scribe
   1. Run `composer require --dev knuckleswtf/scribe`
   2. Run `php artisan vendor:publish --tag=scribe-config`
   3. To generate docs page run `php artisan scribe:generate`
   you can learn more information at [Scribe](https://scribe.knuckles.wtf/laravel/getting-started)

# Functions you can do
    • User can login
    • Login user can create movies 
    • Login user can see movie listings
    • Login user can delete movies 
    • Login user can edit/update movies 
    • Anyone can see movie listings/movie detail (Include relative comment)
    • Anyone can comment on the movie (Commenter required a valid email address to comment)