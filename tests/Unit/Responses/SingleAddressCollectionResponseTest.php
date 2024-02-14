<?php

namespace Laralabs\GetAddress\Tests\Unit\Responses;

use Laralabs\GetAddress\Tests\Support\Responses\ResponseFactory;
use Laralabs\GetAddress\Tests\TestCase;

class SingleAddressCollectionResponseTest extends TestCase
{
    /** @test */
    public function it_can_get_the_address_response_object(): void
    {
        $response = ResponseFactory::make('successfulGetResponse.json')->makeSingleAddressCollectionResponse();

        $address = $response->getAddress();
        $this->assertEquals('Apartment 32', $address->getLine1());
        $this->assertEquals('Clarence Mill', $address->getLine2());
        $this->assertEquals('Clarence Road', $address->getLine3());
        $this->assertEquals('', $address->getLine4());
        $this->assertEquals('Bollington', $address->getLocality());
        $this->assertEquals('Macclesfield', $address->getTown());
        $this->assertEquals('Macclesfield', $address->getCity());
        $this->assertEquals('Cheshire', $address->getCounty());
        $this->assertEquals('Cheshire East', $address->getDistrict());
        $this->assertEquals('England', $address->getCountry());
        $this->assertTrue($address->isResidential());
    }
}