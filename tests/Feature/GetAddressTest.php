<?php

namespace Laralabs\GetAddress\Tests\Feature;

use Laralabs\GetAddress\Facades\GetAddress;
use Laralabs\GetAddress\Tests\Support\Responses\ResponseFactory;
use Laralabs\GetAddress\Tests\TestCase;

class GetAddressTest extends TestCase
{
    /** @test */
    public function it_can_do_a_postcode_lookup_using_find(): void
    {
        ResponseFactory::make('successfulFindResponse.json')->getHttpFake();

        $results = GetAddress::find('B13 9SZ');

        $this->assertCount(14, $results->getAddresses());
        $this->assertEquals('B13 9SZ', $results->getPostcode());
    }

    /** @test */
    public function it_can_do_a_postcode_lookup_with_property_number_using_find(): void
    {
        ResponseFactory::make('successfulFindResponse.json')->getHttpFake();

        $results = get_address()->find('B13 9SZ', 32);

        $this->assertCount(14, $results->getAddresses());
        $this->assertEquals('B13 9SZ', $results->getPostcode());
    }
}