<?php

namespace Laralabs\GetAddress\Tests\Unit\Exceptions;

use Laralabs\GetAddress\Exceptions\Forbidden;
use Laralabs\GetAddress\Exceptions\Handler;
use Laralabs\GetAddress\Exceptions\InvalidPostcode;
use Laralabs\GetAddress\Exceptions\PostcodeNotFound;
use Laralabs\GetAddress\Exceptions\ServerError;
use Laralabs\GetAddress\Exceptions\TooManyRequests;
use Laralabs\GetAddress\Exceptions\Unknown;
use Laralabs\GetAddress\Tests\TestCase;

class HandlerTest extends TestCase
{
    /** @test */
    public function it_throws_an_unknown_exception_when_no_match(): void
    {
        $this->expectException(Unknown::class);

        Handler::throwException(418);
    }

    /** @test */
    public function it_throws_an_invalid_postcode_exception(): void
    {
        $this->expectException(InvalidPostcode::class);

        Handler::throwException(400);
    }

    /** @test */
    public function it_throws_a_forbiddin_exception(): void
    {
        $this->expectException(Forbidden::class);

        Handler::throwException(401);
    }

    /** @test */
    public function it_throws_a_postcode_not_found_exception(): void
    {
        $this->expectException(PostcodeNotFound::class);

        Handler::throwException(404);
    }

    /** @test */
    public function it_throws_a_too_many_requests_exception(): void
    {
        $this->expectException(TooManyRequests::class);

        Handler::throwException(429);
    }

    /** @test */
    public function it_throws_a_server_exception(): void
    {
        $this->expectException(ServerError::class);

        Handler::throwException(500);
    }
}
