<?php

namespace Laralabs\GetAddress\Exceptions;

class Handler
{
    /**
     * @throws ServerError
     * @throws TooManyRequests
     * @throws InvalidPostcode
     * @throws PostcodeNotFound
     * @throws Unknown
     * @throws Forbidden
     */
    public static function throwException(int $statusCode): void
    {
        throw match ($statusCode) {
            400 => new InvalidPostcode(),
            401 => new Forbidden(),
            404 => new PostcodeNotFound(),
            429 => new TooManyRequests(),
            500 => new ServerError(),
            default => new Unknown($statusCode),
        };
    }
}
