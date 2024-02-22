<?php

namespace Laralabs\GetAddress\Tests;

use Laralabs\GetAddress\GetAddressServiceProvider;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app): array //phpcs:ignore
    {
        return [
            GetAddressServiceProvider::class,
        ];
    }
}
