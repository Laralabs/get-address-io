<?php

namespace Laralabs\GetAddress\Responses;

class ExpandedAddress
{
    /**
     * Address string.
     *
     * @var array
     */
    protected $address = [];

    /**
     * Constructor.
     *
     * @param string $address
     *
     * @return void
     */
    public function __construct($address)
    {
        $this->address = $address;
    }

    /**
     * Get Thoroughfare.
     *
     * @return string
     */
    public function getThoroughfare(): string
    {
        return $this->address['thoroughfare'];
    }

    /**
     * Get Building Name.
     *
     * @return string
     */
    public function getBuildingName(): string
    {
        return $this->address['building_name'];
    }

    /**
     * Get Sub Building Name.
     *
     * @return string
     */
    public function getSubBuildingName(): string
    {
        return $this->address['sub_building_name'];
    }

    /**
     * Get Building Number.
     *
     * @return string
     */
    public function getBuildingNumber(): string
    {
        return $this->address['building_number'];
    }

    /**
     * Get Sub Building Number.
     *
     * @return string
     */
    public function getSubBuildingNumber(): string
    {
        return $this->address['sub_building_number'];
    }

    /**
     * Get Line 1.
     *
     * @return string
     */
    public function getLine1(): string
    {
        return $this->address['line_1'];
    }

    /**
     * Get Line 2.
     *
     * @return string
     */
    public function getLine2(): string
    {
        return $this->address['line_2'];
    }

    /**
     * Get Line 3.
     *
     * @return string
     */
    public function getLine3(): string
    {
        return $this->address['line_3'];
    }

    /**
     * Get Line 4.
     *
     * @return string
     */
    public function getLine4(): string
    {
        return $this->address['line_4'];
    }

    /**
     * Get Line.
     *
     * @param int $line
     *
     * @return string
     */
    public function getLine($line): string
    {
        return $this->address['line_'.$line];
    }

    /**
     * Get Locality.
     *
     * @return string
     */
    public function getLocality(): string
    {
        return $this->address['locality'];
    }

    /**
     * Get Town.
     *
     * @return string
     */
    public function getTown(): string
    {
        return $this->address['town_or_city'];
    }

    /**
     * Get City.
     *
     * @return string
     *
     * @see ExpandedAddress:getTown()
     */
    public function getCity(): string
    {
        return $this->address['town_or_city'];
    }

    /**
     * Get County.
     *
     * @return string
     */
    public function getCounty(): string
    {
        return $this->address['county'];
    }

    /**
     * Get District.
     *
     * @return string
     */
    public function getDistrict(): string
    {
        return $this->address['district'];
    }

    /**
     * Get Country.
     *
     * @return string
     */
    public function getCountry(): string
    {
        return $this->address['country'];
    }

    /**
     * Return a formatted array for the address.
     *
     * @param array $keys Override default key names
     *
     * @return array
     */
    public function toArray(array $keys = []): array
    {
        return array_merge([
            'formatted_string' => $this->toString(true),
        ], $this->address);
    }

    /**
     * Returns a string based on the address.
     *
     * @param bool $removeEmptyElements Prevents strings having conjoining commas
     *
     * @return string
     */
    public function toString($removeEmptyElements = false): string
    {
        if (!$removeEmptyElements) {
            return implode(',', $this->address['formatted_address']);
        }

        return implode(', ', array_filter($this->address['formatted_address']));
    }

    /**
     * Compare two addresses to see if they are equal.
     *
     * @param \Laralabs\GetAddress\Responses\Address $address Address to compare
     *
     * @return bool
     */
    public function sameAs(Address $address): bool
    {
        return !array_diff($this->address, $address->toArray());
    }

    /**
     * Convert the address to a comma separated string.
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->toString();
    }
}
