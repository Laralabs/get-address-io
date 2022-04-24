<?php

namespace Laralabs\GetAddress\Responses;

use Illuminate\Support\Arr;

class SingleAddressCollectionResponse extends AddressCollectionResponse
{
    protected ?string $postcode;

    protected ?float $latitude;

    protected ?float $longitude;

    protected array $address = [];

    public function __construct(array $address = [])
    {
        $this->postcode = $address['postcode'] ?? null;
        $this->latitude = $address['latitude'] ?? null;
        $this->longitude = $address['longitude'] ?? null;
        $this->address = $address;

        parent::__construct($this->postcode, $this->latitude, $this->longitude, Arr::wrap($this->address));
    }

    public function getAddress(): array
    {
        return $this->address;
    }

    /**
     * Return response as array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'postcode'  => $this->postcode,
            'latitude'  => $this->latitude,
            'longitude' => $this->longitude,
            'address' => $this->address,
        ];
    }
}
