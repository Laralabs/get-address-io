<?php

namespace Laralabs\GetAddress\Tests\Feature;

use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Laralabs\GetAddress\Cache\Manager;
use Laralabs\GetAddress\Facades\GetAddress;
use Laralabs\GetAddress\Models\CachedAddress;
use Laralabs\GetAddress\Tests\Support\Responses\ResponseFactory;
use Laralabs\GetAddress\Tests\TestCase;

class GetAddressTest extends TestCase
{
    use LazilyRefreshDatabase;

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
        ResponseFactory::make('singleFindResponse.json')->getHttpFake();

        $results = get_address()->find('B13 9SZ', 32);

        $this->assertCount(1, $results->getAddresses());
        $this->assertEquals('B13 9SZ', $results->getPostcode());
    }

    /** @test */
    public function it_can_do_a_postcode_lookup_with_property_number_using_find_and_results_from_the_cache(): void
    {
        config()->set('getaddress.enable_cache', true);

        $manager = new Manager();
        $manager->responseToCache(
            ResponseFactory::make('successfulFindResponse.json')->makeAddressCollectionResponse()
        );

        $this->assertEquals(14, CachedAddress::count());

        $results = GetAddress::find('B13 9SZ');

        $this->assertCount(14, $results->getAddresses());
        $this->assertEquals('B13 9SZ', $results->getPostcode());
    }

    /** @test */
    public function it_can_do_a_postcode_lookup_using_find_and_results_from_the_cache(): void
    {
        config()->set('getaddress.enable_cache', true);

        $manager = new Manager();
        $manager->responseToCache(
            ResponseFactory::make('successfulFindResponse.json')->makeAddressCollectionResponse()
        );

        $this->assertEquals(14, CachedAddress::count());

        $results = get_address()->find('B13 9SZ', 32);

        $this->assertCount(2, $results->getAddresses());
        $this->assertEquals('B13 9SZ', $results->getPostcode());
    }
}