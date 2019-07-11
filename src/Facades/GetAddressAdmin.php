<?php

namespace Laralabs\GetAddress\Facades;

use Illuminate\Support\Facades\Facade;

class GetAddressAdmin extends Facade
{
    public static function getFacadeRoot(): \Laralabs\GetAddress\GetAddressAdmin
    {
        return app('getaddress-admin', ['adminKey' => null]);
    }
}