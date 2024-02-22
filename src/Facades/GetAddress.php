<?php

namespace Laralabs\GetAddress\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static find(string $postcode, null|int|string $propertyNumber = null, bool $sortNumerically = true)
 * @method static autocomplete(string $term, array $parameters = [])
 * @method static get(string $id)
 * @method static expand()
 */
class GetAddress extends Facade
{
    public static function getFacadeRoot(): \Laralabs\GetAddress\GetAddress
    {
        return app('getaddress', ['apiKey' => null]);
    }
}
