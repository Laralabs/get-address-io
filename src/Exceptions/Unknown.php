<?php

namespace Laralabs\GetAddress\Exceptions;

use Exception;

class Unknown extends Exception
{
    protected $message = 'getAddress responded with a %d http status';

    public function __construct(int $status)
    {
        $this->message = sprintf($this->message, $status);

        parent::__construct($this->message);
    }
}
