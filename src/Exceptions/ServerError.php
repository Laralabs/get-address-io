<?php

namespace Laralabs\GetAddress\Exceptions;

class ServerError extends \Exception
{
    /**
     * Exception Message.
     *
     * @var string
     */
    protected $message = 'getAddress.io is currently having issues.';
}
