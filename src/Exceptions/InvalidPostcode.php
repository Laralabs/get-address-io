<?php

namespace Laralabs\GetAddress\Exceptions;

use Exception;

class InvalidPostcode extends Exception
{
    protected $message = 'The postcode you provided was not a valid format.';
}
