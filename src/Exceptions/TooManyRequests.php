<?php

namespace Laralabs\GetAddress\Exceptions;

class TooManyRequests extends \Exception
{
    /**
     * Exception Message.
     *
     * @var string
     */
    protected $message = 'You have made too many requests for this key.';
}
