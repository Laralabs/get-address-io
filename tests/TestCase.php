<?php

namespace Laralabs\GetAddress\Tests;

use Laralabs\GetAddress\GetAddressServiceProvider;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [
            GetAddressServiceProvider::class,
        ];
    }
}
