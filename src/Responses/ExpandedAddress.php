<?php

namespace Laralabs\GetAddress\Responses;

class ExpandedAddress
{
    public function __construct(protected array $address = [])
    {
    }

    public function getThoroughfare(): string
    {
        return $this->address['thoroughfare'];
    }

    public function getBuildingName(): string
    {
        return $this->address['building_name'];
    }

    public function getSubBuildingName(): string
    {
        return $this->address['sub_building_name'];
    }

    public function getBuildingNumber(): string
    {
        return $this->address['building_number'];
    }

    public function getSubBuildingNumber(): string
    {
        return $this->address['sub_building_number'];
    }

    public function getLine1(): string
    {
        return $this->address['line_1'];
    }

    public function getLine2(): string
    {
        return $this->address['line_2'];
    }

    public function getLine3(): string
    {
        return $this->address['line_3'];
    }

    public function getLine4(): string
    {
        return $this->address['line_4'];
    }

    public function getLine(int $line): ?string
    {
        if ($line > 4) {
            return null;
        }

        return $this->address['line_' . $line];
    }

    public function getLocality(): string
    {
        return $this->address['locality'];
    }

    public function getTown(): string
    {
        return $this->address['town_or_city'];
    }

    public function getCity(): string
    {
        return $this->address['town_or_city'];
    }

    public function getCounty(): string
    {
        return $this->address['county'];
    }

    public function getDistrict(): string
    {
        return $this->address['district'];
    }

    public function getCountry(): string
    {
        return $this->address['country'];
    }

    /**
     * Return a formatted array for the address.
     */
    public function toArray(): array
    {
        return array_merge([
            'formatted_string' => $this->toString(true),
        ], $this->address);
    }

    public function toString(bool $removeEmptyElements = false): string
    {
        if ($removeEmptyElements === false) {
            return implode(',', $this->address['formatted_address']);
        }

        return implode(', ', array_filter($this->address['formatted_address']));
    }

    public function sameAs(Address $address): bool
    {
        return count(array_diff($this->address, $address->toArray())) === 0;
    }

    public function __toString(): string
    {
        return $this->toString();
    }
}
