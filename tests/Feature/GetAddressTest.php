<?php

namespace Laralabs\GetAddress\Tests\Feature;

use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Laralabs\GetAddress\Cache\Manager;
use Laralabs\GetAddress\Facades\GetAddress;
use Laralabs\GetAddress\Models\CachedAddress;
use Laralabs\GetAddress\Tests\Support\Responses\ResponseFactory;
use Laralabs\GetAddress\Tests\TestCase;
use Spatie\Snapshots\MatchesSnapshots;

class GetAddressTest extends TestCase
{
    use LazilyRefreshDatabase, MatchesSnapshots;

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

    /** @test */
    public function it_can_perform_an_autocomplete_request(): void
    {
        ResponseFactory::make('successfulAutocompleteResponse.json')->getHttpFake();

        $results = GetAddress::autocomplete('32 Clarence');

        $this->assertCount(6, $results->all());
    }

    /** @test */
    public function it_can_perform_a_get_request_for_an_autocomplete_result_item(): void
    {
        ResponseFactory::make('successfulGetResponse.json')->getHttpFake();

        $results = GetAddress::get('NmNhMTg3ZjBkZmQ1OTg0IDEwMzgwMzg1IDdjZmFmNTA5OTI3YjkzZQ==');

        $this->assertEquals('SK10 5GR', $results->getPostcode());
        $this->assertEquals(53.2998, $results->getLatitude());
        $this->assertEquals(-2.102, $results->getLongitude());
        $this->assertMatchesJsonSnapshot($results->getAddress());
    }
}