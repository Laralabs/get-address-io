<?php

namespace Laralabs\GetAddress\Exceptions;

class UnknownException extends \Exception
{
    /**
     * Message
     *
     * @var string
     */
    protected $message = 'getAddress responded with a %d http status';

    /**
     * {@inheritdoc}
     */
    public function __construct($status)
    {
        $this->message = sprintf($this->message, $status);

        parent::__construct($this->message);
    }
}