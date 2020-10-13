<?php

namespace Laralabs\GetAddress;

use Illuminate\Support\ServiceProvider;

class GetAddressServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/getaddress.php',
            'getaddress'
        );

        $this->app->bind('getaddress', function ($app, $parameters) {
            return new GetAddress($parameters['apiKey']);
        });

        $this->app->bind('getaddress-admin', function ($app, $parameters) {
            return new GetAddressAdmin($parameters['adminKey']);
        });
    }

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/getaddress.php'  => config_path('getaddress.php'),
        ], 'getaddress-config');

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }
}
