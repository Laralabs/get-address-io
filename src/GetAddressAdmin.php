<?php

namespace Laralabs\GetAddress;

class GetAddressAdmin extends GetAddressBase
{
    public function __construct($adminKey = null)
    {
        parent::__construct(null, $adminKey);
    }
}