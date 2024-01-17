<?php

namespace Laralabs\GetAddress\Exceptions;

class Handler
{
    /**
     * @throws ServerException
     * @throws TooManyRequestsException
     * @throws InvalidPostcodeException
     * @throws PostcodeNotFoundException
     * @throws UnknownException
     * @throws ForbiddenException
     */
    public static function throwException(int $statusCode): void
    {
        throw match ($statusCode) {
            400 => new InvalidPostcodeException(),
            401 => new ForbiddenException(),
            404 => new PostcodeNotFoundException(),
            429 => new TooManyRequestsException(),
            500 => new ServerException(),
            default => new UnknownException($statusCode),
        };
    }
}
