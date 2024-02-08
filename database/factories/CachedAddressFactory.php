<?php

namespace Laralabs\GetAddress\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Laralabs\GetAddress\Models\CachedAddress;

class CachedAddressFactory extends Factory
{
    protected $model = CachedAddress::class;

    public function definition(): array
    {
        return [
            'line_1' => '123 Example Street',
            'line_2' => '',
            'line_3' => '',
            'line_4' => '',
            'locality' => 'Moseley',
            'town_or_city' => 'Birmingham',
            'county' => 'West Midlands',
            'postcode' => 'B13 9SZ',
        ];
    }
}