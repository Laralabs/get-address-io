<?php

namespace Laralabs\GetAddress\Responses;

class Domain extends AbstractWhitelist
{
    /**
     * Get Domain.
     *
     * @return string
     */
    public function getDomain(): string
    {
        return $this->name;
    }
}
