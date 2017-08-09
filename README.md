InfyOm Routes Explorer (still in beta)
==============================

Explore your laravel application routes with the better GUI.

![Laravel Routes Explorer](http://infyom.com/images/routes-explorer.png "Laravel Routes Explorer")

## Installation

`composer require infyomlabs/routes-explorer`

Add Service Provider in your `config/app.php`:

    \InfyOm\RoutesExplorer\RoutesExplorerServiceProvider::class,

Run publish command:

    php artisan vendor:publish

Open `http://{your_domain}/routes-explorer`

## Customization
1. Customize Routes

    You can customize your route to anything other than `routes-explorer`.

    Open `config/infyom/routes_explorer.php`.

    Change the value of `route` parameter to your favorite one.

2. Customize View

    Publish view file:

    `php artisan vendor:publish --tag=views`

    After running this command, view file will be published to `resources/views/routes/routes.php`. Customize it the way you want.

3. Change `view` parameter in `config/infyom/routes_explorer.php` to `routes.routes`.

## Security
Of course, you need to secure this route `routes-explorer` in the production environment.

You can find option `enable_explorer` into `config/infyom/routes_explorer.php` and simply make it false while in production environment directly or via `.env`. 

## Track Api calls count

By the time, our project grows with lots of routes and api endpoints. And it's really difficult to figure out which routes are most used or used or not used at all.

In some cases, we also want to know, which routes are frequently called and we want to cache those data. Other lots of real life practical problems and use cases can be there with our routes.

To start tracking api calls, you need to perform following steps:

1. Publish migration for tracking api calls.

    `php artisan vendor:publish --tag=migrations`

    It will publish migration file into `database/migrations`.

2. Migrate your database by,

    `php artisan migrate`

    It will create table `api_calls_count`.

3. Change config file `config/infyom/routes_explorer.php`.

    Make `collections.api_calls_count => true`

And you're done.

You will see one new column `count` in the data table.

