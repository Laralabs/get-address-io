<?php

if (!function_exists('get_address')) {
    function get_address($apiKey = null)
    {
        $getAddress = app('getaddress', ['apiKey' => $apiKey]);

        return $getAddress;
    }
}

if (!function_exists('get_address_admin')) {
    function get_address_admin($adminKey = null)
    {
        $getAddressAdmin = app('getaddress-admin', ['adminKey' => $adminKey]);

        return $getAddressAdmin;
    }
}
