<?php

namespace Laralabs\GetAddress\Exceptions;

use Exception;

class PostcodeNotFound extends Exception
{
    protected $message = 'The postcode you provided could not be found.';
}
