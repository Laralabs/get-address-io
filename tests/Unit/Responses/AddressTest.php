<?php

namespace Laralabs\GetAddress\Tests\Unit\Responses;

use Laralabs\GetAddress\Responses\Address;
use Laralabs\GetAddress\Tests\Support\Responses\ResponseFactory;
use Laralabs\GetAddress\Tests\TestCase;

class AddressTest extends TestCase
{
    public ?Address $address = null;

    public function setUp(): void
    {
        parent::setUp();

        $this->address = ResponseFactory::make('singleFindResponse.json')
            ->makeAddressCollectionResponse()->getAddresses()[0];
    }

    /** @test */
    public function it_can_get_line_one(): void
    {
        $this->assertEquals('32 Clarence Road', $this->address->getLine1());
    }

    /** @test */
    public function it_can_get_line_two(): void
    {
        $this->assertEquals(' ', $this->address->getLine2());
    }

    /** @test */
    public function it_can_get_line_three(): void
    {
        $this->assertEquals(' ', $this->address->getLine3());
    }

    /** @test */
    public function it_can_get_line_four(): void
    {
        $this->assertEquals(' ', $this->address->getLine4());
    }

    /** @test */
    public function it_can_get_a_line_by_the_given_number(): void
    {
        $this->assertEquals('32 Clarence Road', $this->address->getLine(1));
        $this->assertNull($this->address->getLine(5));
    }

    /** @test */
    public function it_can_get_the_locality(): void
    {
        $this->assertEquals(' Moseley', $this->address->getLocality());
    }

    /** @test */
    public function it_can_get_the_town(): void
    {
        $this->assertEquals(' Birmingham', $this->address->getTown());
    }

    /** @test */
    public function it_can_get_the_city(): void
    {
        $this->assertEquals(' Birmingham', $this->address->getCity());
    }

    /** @test */
    public function it_can_get_the_county(): void
    {
        $this->assertEquals(' West Midlands', $this->address->getCounty());
    }

    /** @test */
    public function it_can_get_the_district(): void
    {
        $this->assertNull($this->address->getDistrict());
    }

    /** @test */
    public function it_can_get_the_country(): void
    {
        $this->assertNull($this->address->getCountry());
    }

    /** @test */
    public function it_can_transform_address_to_string_and_remove_empty_elements(): void
    {
        $this->assertEquals(
            '32 Clarence Road, Moseley, Birmingham, West Midlands',
            $this->address->toString(true)
        );
    }

    /** @test */
    public function it_can_transform_address_to_string(): void
    {
        $this->assertEquals(
            '32 Clarence Road, , , , Moseley, Birmingham, West Midlands',
            $this->address->toString()
        );
    }

    /** @test */
    public function it_can_cast_the_address_to_a_string(): void
    {
        $this->assertEquals(
            '32 Clarence Road, , , , Moseley, Birmingham, West Midlands',
            (string) $this->address
        );
    }

    /** @test */
    public function it_can_can_check_if_two_address_responses_are_the_same(): void
    {
        $address = ResponseFactory::make('singleFindResponse.json')
            ->makeAddressCollectionResponse()->getAddresses()[0];

        $this->assertTrue($this->address->sameAs($address));
    }
}