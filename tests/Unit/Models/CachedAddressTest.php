<?php

namespace Laralabs\GetAddress\Tests\Unit\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laralabs\GetAddress\Models\CachedAddress;
use Laralabs\GetAddress\Tests\TestCase;

class CachedAddressTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_get_the_expected_formatted_string(): void
    {
        $cachedAddress = CachedAddress::factory()->create();

        $this->assertEquals(
            '123 Example Street, Moseley, Birmingham, West Midlands',
            $cachedAddress->getFormattedStringAttribute()
        );
    }

    /** @test */
    public function it_can_convert_the_cached_address_to_string_without_stripping_empty_elements(): void
    {
        $cachedAddress = CachedAddress::factory()->create();

        $this->assertEquals(
            '123 Example Street,,,,Moseley,Birmingham,West Midlands',
            $cachedAddress->toString()
        );
    }
}
