<?php

namespace Laralabs\GetAddress\Responses;

class PrivateAddress extends Address
{
    /**
     * Private address ID
     *
     * @var string
     */
    protected $privateAddressId;

    /**
     * Constructor
     *
     * @param string $addressId
     * @param string $address
     *
     * @return void
     */
    public function __construct($addressId, $address)
    {
        parent::__construct($address);

        $this->privateAddressId = $addressId;
    }

    /**
     * Create a new private address object ready to submit to the API
     *
     * @param string $line1
     * @param string $line2
     * @param string $line3
     * @param string $line4
     * @param string $locality
     * @param string $townOrCity
     * @param string $county
     *
     * @return \Laralabs\GetAddress\Responses\PrivateAddress
     */
    public static function create(
        $line1 = '',
        $line2 = '',
        $line3 = '',
        $line4 = '',
        $locality = '',
        $townOrCity = '',
        $county = ''
    ) {
        $address = implode(',', func_get_args());

        return new static(null, $address);
    }

    /**
     * Get Address ID
     *
     * @return string
     */
    public function getAddressId(): string
    {
        return $this->privateAddressId;
    }

    /**
     * Is Saved
     *
     * @return boolean
     */
    public function isSaved(): bool
    {
        return $this->privateAddressId !== null;
    }
}
