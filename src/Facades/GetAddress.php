<?php

namespace Laralabs\GetAddress\Facades;

use Illuminate\Support\Facades\Facade;

class GetAddress extends Facade
{
    public static function getFacadeRoot(): \Laralabs\GetAddress\GetAddress
    {
        return app('getaddress', ['apiKey' => null]);
    }
}
