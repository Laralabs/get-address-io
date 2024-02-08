<?php

namespace Laralabs\GetAddress\Tests\Unit\Responses;

use Laralabs\GetAddress\Responses\Address;
use Laralabs\GetAddress\Responses\AddressCollectionResponse;
use Laralabs\GetAddress\Tests\Support\Responses\ResponseFactory;
use Laralabs\GetAddress\Tests\TestCase;
use Spatie\Snapshots\MatchesSnapshots;

class AddressCollectionResponseTest extends TestCase
{
    use MatchesSnapshots;

    protected ?AddressCollectionResponse $response = null;

    public function setUp(): void
    {
        parent::setUp();

        $this->response = ResponseFactory::make('successfulFindResponse.json')
            ->makeAddressCollectionResponse();
    }

    /** @test */
    public function it_can_get_the_postcode(): void
    {
        $this->assertEquals('B13 9SZ', $this->response->getPostcode());
    }

    /** @test */
    public function it_can_get_the_latitude(): void
    {
        $this->assertEquals(52.437353914285715, $this->response->getLatitude());
    }

    /** @test */
    public function it_can_get_the_longitude(): void
    {
        $this->assertEquals(-1.8828399142857144, $this->response->getLongitude());
    }

    /** @test */
    public function it_can_get_the_addresses(): void
    {
        $addresses = collect($this->response->getAddresses());

        $this->assertCount(14, $addresses);
        $this->assertInstanceOf(Address::class, $addresses->first());
    }

    /** @test */
    public function it_can_transform_to_the_expected_array(): void
    {
        $this->assertMatchesJsonSnapshot($this->response->toArray());
    }
}