<?php

namespace Laralabs\GetAddress\Exceptions;

class ServerException extends \Exception
{
    /**
     * Exception Message.
     *
     * @var string
     */
    protected $message = 'getAddress.io is currently having issues.';
}
