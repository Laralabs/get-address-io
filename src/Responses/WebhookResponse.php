<?php

namespace Laralabs\GetAddress\Responses;

class WebhookResponse
{
    /**
     * Message.
     *
     * @var string
     */
    protected $message;

    /**
     * Hooks.
     *
     * @var array
     */
    protected $hooks = [];

    /**
     * Constructor.
     *
     * @param string $message
     * @param array  $hooks
     */
    public function __construct($message, array $hooks = [])
    {
        $this->message = $message;
        $this->hooks = $hooks;
    }

    /**
     * Get Message.
     *
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * Get Hooks.
     *
     * @return array
     */
    public function getHooks(): array
    {
        return $this->hooks;
    }
}
