<?php

namespace Laralabs\GetAddress\Tests\Unit\Responses;

use Laralabs\GetAddress\Responses\ExpandedAddress;
use Laralabs\GetAddress\Tests\Support\Responses\ResponseFactory;
use Laralabs\GetAddress\Tests\TestCase;

class ExpandedAddressTest extends TestCase
{
    public ?ExpandedAddress $address = null;

    public function setUp(): void
    {
        parent::setUp();

        $this->address = ResponseFactory::make('successfulGetResponse.json', true)
            ->makeSingleAddressCollectionResponse()->getAddress();
    }

    /** @test */
    public function it_can_get_the_thoroughfare(): void
    {
        $this->assertEquals('Clarence Road', $this->address->getThoroughfare());
    }

    /** @test */
    public function it_can_get_the_building_name(): void
    {
        $this->assertEquals('Clarence Mill', $this->address->getBuildingName());
    }

    /** @test */
    public function it_can_get_the_sub_building_name(): void
    {
        $this->assertEquals('', $this->address->getSubBuildingName());
    }

    /** @test */
    public function it_can_get_the_building_number(): void
    {
        $this->assertEquals('', $this->address->getBuildingNumber());
    }

    /** @test */
    public function it_can_get_the_sub_building_number(): void
    {
        $this->assertEquals('32', $this->address->getSubBuildingNumber());
    }

    /** @test */
    public function it_can_get_line_one(): void
    {
        $this->assertEquals('Apartment 32', $this->address->getLine1());
    }

    /** @test */
    public function it_can_get_line_two(): void
    {
        $this->assertEquals('Clarence Mill', $this->address->getLine2());
    }

    /** @test */
    public function it_can_get_line_three(): void
    {
        $this->assertEquals('Clarence Road', $this->address->getLine3());
    }

    /** @test */
    public function it_can_get_line_four(): void
    {
        $this->assertEquals('', $this->address->getLine4());
    }

    /** @test */
    public function it_can_get_a_line_by_the_given_number(): void
    {
        $this->assertEquals('Clarence Road', $this->address->getLine(3));
        $this->assertNull($this->address->getLine(5));
    }

    /** @test */
    public function it_can_get_the_locality(): void
    {
        $this->assertEquals('Bollington', $this->address->getLocality());
    }

    /** @test */
    public function it_can_get_the_town(): void
    {
        $this->assertEquals('Macclesfield', $this->address->getTown());
    }

    /** @test */
    public function it_can_get_the_city(): void
    {
        $this->assertEquals('Macclesfield', $this->address->getCity());
    }

    /** @test */
    public function it_can_get_the_county(): void
    {
        $this->assertEquals('Cheshire', $this->address->getCounty());
    }

    /** @test */
    public function it_can_get_the_country(): void
    {
        $this->assertEquals('England', $this->address->getCountry());
    }

    /** @test */
    public function it_can_transform_expanded_address_to_array(): void
    {
        $response = ResponseFactory::make('successfulGetResponse.json', true)->getDecodedResponse();
        $this->assertEquals(
            array_merge($response, ['formatted_string' => $this->address->toString(true)]),
            $this->address->toArray()
        );
    }
}