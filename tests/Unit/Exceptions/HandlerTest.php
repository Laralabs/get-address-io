<?php

namespace Laralabs\GetAddress\Tests\Unit\Exceptions;

use Laralabs\GetAddress\Exceptions\ForbiddenException;
use Laralabs\GetAddress\Exceptions\Handler;
use Laralabs\GetAddress\Exceptions\InvalidPostcodeException;
use Laralabs\GetAddress\Exceptions\PostcodeNotFoundException;
use Laralabs\GetAddress\Exceptions\ServerException;
use Laralabs\GetAddress\Exceptions\TooManyRequestsException;
use Laralabs\GetAddress\Exceptions\UnknownException;
use Laralabs\GetAddress\Tests\TestCase;

class HandlerTest extends TestCase
{
    /** @test */
    public function it_throws_an_unknown_exception_when_no_match(): void
    {
        $this->expectException(UnknownException::class);

        Handler::throwException(418);
    }

    /** @test */
    public function it_throws_an_invalid_postcode_exception(): void
    {
        $this->expectException(InvalidPostcodeException::class);

        Handler::throwException(400);
    }

    /** @test */
    public function it_throws_a_forbiddin_exception(): void
    {
        $this->expectException(ForbiddenException::class);

        Handler::throwException(401);
    }

    /** @test */
    public function it_throws_a_postcode_not_found_exception(): void
    {
        $this->expectException(PostcodeNotFoundException::class);

        Handler::throwException(404);
    }

    /** @test */
    public function it_throws_a_too_many_requests_exception(): void
    {
        $this->expectException(TooManyRequestsException::class);

        Handler::throwException(429);
    }

    /** @test */
    public function it_throws_a_server_exception(): void
    {
        $this->expectException(ServerException::class);

        Handler::throwException(500);
    }
}
