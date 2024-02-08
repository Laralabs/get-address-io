<?php

namespace Laralabs\GetAddress\Exceptions;

class PostcodeNotFound extends \Exception
{
    /**
     * Exception Message.
     *
     * @var string
     */
    protected $message = 'The postcode you provided could not be found.';
}
