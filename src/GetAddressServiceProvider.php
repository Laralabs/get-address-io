<?php

namespace Laralabs\GetAddress;

use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Laralabs\GetAddress\Http\Client;

class GetAddressServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/getaddress.php',
            'getaddress'
        );

        $this->app->singleton(Client::class, function (Application $app, array $parameters): Client { //phpcs:ignore
            return new Client($parameters['apiKey'] ?? null, $parameters['adminKey'] ?? null);
        });

        $this->app->bind('getaddress', function (Application $app, array $parameters): GetAddress { //phpcs:ignore
            return new GetAddress(app(Client::class, ['apiKey' => $parameters['apiKey'] ?? null]));
        });

        $this->app->bind('getaddress-admin', function (Application $app, array $parameters): GetAddressAdmin { //phpcs:ignore
            return new GetAddressAdmin($parameters['adminKey']);
        });
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/getaddress.php'  => config_path('getaddress.php'),
        ], 'getaddress-config');

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }
}
