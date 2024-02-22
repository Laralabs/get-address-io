<?php

use Laralabs\GetAddress\GetAddress;

if (!function_exists('get_address')) {
    function get_address(?string $apiKey = null): GetAddress
    {
        return app('getaddress', ['apiKey' => $apiKey]);
    }
}
