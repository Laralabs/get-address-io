<?php

namespace Laralabs\GetAddress\Exceptions;

use Exception;

class ServerError extends Exception
{
    protected $message = 'getAddress.io is currently having issues.';
}
