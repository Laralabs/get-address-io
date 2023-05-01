<?php

namespace Laralabs\GetAddress\Tests;

use Laralabs\GetAddress\GetAddressServiceProvider;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app): array
    {
        return [
            GetAddressServiceProvider::class,
        ];
    }
}
