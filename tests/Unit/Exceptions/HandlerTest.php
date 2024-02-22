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
        try {
            Handler::throwException(418);
        } catch (Unknown $exception) {
            $this->assertEquals('getAddress responded with a 418 http status', $exception->getMessage());

            return;
        }

        $this->fail('Unknown exception not thrown');
    }

    /** @test */
    public function it_throws_an_invalid_postcode_exception(): void
    {
        try {
            Handler::throwException(400);
        } catch (InvalidPostcode $exception) {
            $this->assertEquals('The postcode you provided was not a valid format.', $exception->getMessage());

            return;
        }

        $this->fail('InvalidPostcode exception not thrown');
    }

    /** @test */
    public function it_throws_a_forbidden_exception(): void
    {
        try {
            Handler::throwException(401);
        } catch (Forbidden $exception) {
            $this->assertEquals('Your API key is not valid for this request.', $exception->getMessage());

            return;
        }

        $this->fail('Forbidden exception not thrown');
    }

    /** @test */
    public function it_throws_a_postcode_not_found_exception(): void
    {
        try {
            Handler::throwException(404);
        } catch (PostcodeNotFound $exception) {
            $this->assertEquals('The postcode you provided could not be found.', $exception->getMessage());

            return;
        }

        $this->fail('PostcodeNotFound exception not thrown');
    }

    /** @test */
    public function it_throws_a_too_many_requests_exception(): void
    {
        try {
            Handler::throwException(429);
        } catch (TooManyRequests $exception) {
            $this->assertEquals('You have made too many requests for this key.', $exception->getMessage());

            return;
        }

        $this->fail('TooManyRequests exception not thrown');
    }

    /** @test */
    public function it_throws_a_server_exception(): void
    {
        try {
            Handler::throwException(500);
        } catch (ServerError $exception) {
            $this->assertEquals('getAddress.io is currently having issues.', $exception->getMessage());

            return;
        }

        $this->fail('ServerError exception not thrown');
    }
}
