<?php

namespace Laralabs\GetAddress\Responses;

use Illuminate\Http\JsonResponse;

class AddressCollectionResponse
{
    /**
     * @var string
     */
    protected $postcode;

    /**
     * Latitude
     *
     * @var float
     */
    protected $latitude;

    /**
     * Longitude
     *
     * @var float
     */
    protected $longitude;

    /**
     * Addresses
     *
     * @var array
     */
    protected $addresses = [];

    /**
     * Constructor
     *
     * @param string $postcode
     * @param float $latitude
     * @param float $longitude
     * @param array $addresses
     */
    public function __construct($postcode, $latitude, $longitude, array $addresses = [])
    {
        $this->postcode = $postcode;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->addresses = $addresses;
    }

    /**
     * Get Postcode
     *
     * @return string
     */
    public function getPostcode(): string
    {
        return $this->postcode;
    }

    /**
     * Get Latitude
     *
     * @return float
     */
    public function getLatitude(): float
    {
        return $this->latitude;
    }

    /**
     * Get Longitude
     *
     * @return float
     */
    public function getLongitude(): float
    {
        return $this->longitude;
    }

    /**
     * Get Addresses
     *
     * @return array
     */
    public function getAddresses(): array
    {
        return $this->addresses;
    }

    /**
     * Return response as array
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'postcode' => $this->postcode,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'addresses' => array_map(function ($address) {
                if ($address instanceof Address) {
                    return $address->toString(true);
                }
                if ($address instanceof ExpandedAddress) {
                    return $address->toArray();
                }

                return $address;
            }, $this->addresses)
        ];
    }

    /**
     * Return a json response
     *
     * @return JsonResponse
     */
    public function respond(): JsonResponse
    {
        return response()->json($this->toArray());
    }
}
