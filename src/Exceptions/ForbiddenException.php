<?php

namespace Laralabs\GetAddress\Exceptions;

class ForbiddenException extends \Exception
{
    /**
     * Exception Message.
     *
     * @var string
     */
    protected $message = 'Your API key is not valid for this request.';
}
