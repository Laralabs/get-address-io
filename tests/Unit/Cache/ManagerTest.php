<?php

namespace Laralabs\GetAddress\Tests\Unit\Cache;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laralabs\GetAddress\Cache\Manager;
use Laralabs\GetAddress\Models\CachedAddress;
use Laralabs\GetAddress\Tests\Support\Responses\ResponseFactory;
use Laralabs\GetAddress\Tests\TestCase;

class ManagerTest extends TestCase
{
    use RefreshDatabase;

    protected ?Manager $manager = null;

    public function setUp(): void
    {
        parent::setUp();

        $this->manager = new Manager();
    }

    /** @test */
    public function it_can_check_for_cached_addresses_with_postcode(): void
    {
        CachedAddress::factory()->create(['line_1' => '1 Example Street', 'postcode' => 'ABC 123']);
        CachedAddress::factory()->create(['line_1' => '2 Example Street', 'postcode' => 'ABC 123']);
        CachedAddress::factory()->create(['line_1' => '3 Example Street', 'postcode' => 'ABC 321']);

        $result = $this->manager->checkCache('ABC 123', null);

        $this->assertCount(2, $result['addresses'] ?? 0);
    }

    /** @test */
    public function it_can_check_for_cached_addresses_with_postcode_and_property_number(): void
    {
        CachedAddress::factory()->create(['line_1' => '1 Example Street', 'postcode' => 'ABC 123']);
        CachedAddress::factory()->create(['line_1' => '2 Example Street', 'postcode' => 'ABC 123']);
        CachedAddress::factory()->create(['line_1' => '3 Example Street', 'postcode' => 'ABC 321']);

        $result = $this->manager->checkCache('ABC 123', 1);

        $this->assertCount(1, $result['addresses'] ?? 0);

        $this->assertEquals('1 Example Street, Moseley, Birmingham, West Midlands', $result['addresses'][0]);
        $this->assertEquals('ABC 123', $result['postcode']);
    }

    /** @test */
    public function it_can_store_the_address_collection_response_to_cache(): void
    {
        $response = ResponseFactory::make('successfulFindResponse.json')
            ->makeAddressCollectionResponse();
        $expectedAddress = $response->getAddresses()[0];

        $this->assertEquals(0, CachedAddress::count());

        $this->manager->responseToCache($response);

        $this->assertEquals(14, CachedAddress::count());
        $this->assertEquals($expectedAddress->getLine1(), CachedAddress::first()->line_1);
        $this->assertEquals($expectedAddress->getLine2(), CachedAddress::first()->line_2);
        $this->assertEquals($expectedAddress->getLine3(), CachedAddress::first()->line_3);
        $this->assertEquals($expectedAddress->getLine4(), CachedAddress::first()->line_4);
        $this->assertEquals($expectedAddress->getLocality(), CachedAddress::first()->locality);
        $this->assertEquals($expectedAddress->getTown(), CachedAddress::first()->town_or_city);
        $this->assertEquals($expectedAddress->getCity(), CachedAddress::first()->town_or_city);
        $this->assertEquals($expectedAddress->getCounty(), CachedAddress::first()->county);
        $this->assertEquals($response->getPostcode(), CachedAddress::first()->postcode);
        $this->assertIsFloat(CachedAddress::first()->longitude);
        $this->assertIsFloat(CachedAddress::first()->latitude);
    }
}