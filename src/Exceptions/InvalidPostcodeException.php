<?php

namespace Laralabs\GetAddress\Exceptions;

class InvalidPostcodeException extends \Exception
{
    /**
     * Exception Message
     *
     * @var string
     */
    protected $message = 'The postcode you provided was not a valid format.';
}