<?php

namespace Laralabs\GetAddress\Responses;

use Illuminate\Http\JsonResponse;

class AddressCollectionResponse
{
    public function __construct(
        protected ?string $postcode,
        protected ?float $latitude,
        protected ?float $longitude,
        protected array $addresses = []
    ) {
    }

    public function getPostcode(): ?string
    {
        return $this->postcode;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function getAddresses(): array
    {
        return $this->addresses;
    }

    public function toArray(): array
    {
        return [
            'postcode'  => $this->postcode,
            'latitude'  => $this->latitude,
            'longitude' => $this->longitude,
            'addresses' => array_map(static function ($address) {
                if ($address instanceof Address) {
                    return $address->toString(true);
                }
                if ($address instanceof ExpandedAddress) {
                    return $address->toArray();
                }

                return $address;
            }, $this->addresses),
        ];
    }

    public function respond(): JsonResponse
    {
        return response()->json($this->toArray());
    }
}
