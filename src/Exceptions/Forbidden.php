<?php

namespace Laralabs\GetAddress\Exceptions;

use Exception;

class Forbidden extends Exception
{
    protected $message = 'Your API key is not valid for this request.';
}
