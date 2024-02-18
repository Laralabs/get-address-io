<?php

namespace Laralabs\GetAddress\Exceptions;

use Exception;

class TooManyRequests extends Exception
{
    protected $message = 'You have made too many requests for this key.';
}
