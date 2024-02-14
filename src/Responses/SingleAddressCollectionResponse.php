<?php

namespace Laralabs\GetAddress\Responses;

class SingleAddressCollectionResponse extends AddressCollectionResponse
{
    protected ?string $postcode;

    protected ?float $latitude;

    protected ?float $longitude;

    protected array $address = [];

    protected bool $expand;

    public function __construct(array $address = [], bool $expand = false)
    {
        $this->postcode = $address['postcode'] ?? null;
        $this->latitude = $address['latitude'] ?? null;
        $this->longitude = $address['longitude'] ?? null;
        $this->address = $address;
        $this->expand = $expand;

        parent::__construct($this->postcode, $this->latitude, $this->longitude, [$this->address]);
    }

    public function getAddress(): ExpandedAddress|Address
    {
        return $this->expand ? new ExpandedAddress($this->address) : new Address($this->address);
    }

    public function toArray(): array
    {
        return [
            'postcode'  => $this->postcode,
            'latitude'  => $this->latitude,
            'longitude' => $this->longitude,
            'address'   => $this->address,
        ];
    }
}
