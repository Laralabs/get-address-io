<?php

namespace Laralabs\GetAddress\Responses;

class Ip extends AbstractWhitelist
{
    /**
     * Get Ip.
     *
     * @return string
     */
    public function getIp(): string
    {
        return $this->name;
    }
}
