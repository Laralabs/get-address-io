<?php

namespace Laralabs\GetAddress\Exceptions;

class TooManyRequestsException extends \Exception
{
    /**
     * Exception Message.
     *
     * @var string
     */
    protected $message = 'You have made too many requests for this key.';
}
