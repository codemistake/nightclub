<?php

namespace App\Libs\Database;

use Illuminate\Database\Connection;
use Illuminate\Support\ServiceProvider;

class FixedMySqlConnectionServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Connection::resolverFor('mysql', function ($connection, $database, $prefix, $config) {
            return new FixedMySqlConnection($connection, $database, $prefix, $config);
        });
    }
}
