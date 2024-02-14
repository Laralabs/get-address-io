<?php

namespace Laralabs\GetAddress\Responses;

class Address
{
    protected array $address = [];

    public function __construct(string|array $address)
    {
        $this->address = is_string($address) ? explode(',', $address) : $address;
    }

    public function getLine1(): string
    {
        return $this->address[0] ?? $this->address['line_1'];
    }

    public function getLine2(): string
    {
        return $this->address[1] ?? $this->address['line_2'];
    }

    public function getLine3(): string
    {
        return $this->address[2] ?? $this->address['line_3'];
    }

    public function getLine4(): string
    {
        return $this->address[3] ?? $this->address['line_4'];
    }

    public function getLine(int $line): string
    {
        return $this->address[$line - 1];
    }

    public function getLocality(): string
    {
        return $this->address[4] ?? $this->address['locality'];
    }

    public function getTown(): string
    {
        return $this->address[5] ?? $this->address['town_or_city'];
    }

    public function getCity(): string
    {
        return $this->address[5] ?? $this->address['town_or_city'];
    }

    public function getCounty(): string
    {
        return $this->address[6] ?? $this->address['county'];
    }

    public function getDistrict(): string
    {
        return $this->address[7] ?? $this->address['district'];
    }

    public function getCountry(): string
    {
        return $this->address[8] ?? $this->address['country'];
    }

    public function isResidential(): bool
    {
        return $this->address[9] ?? $this->address['residential'];
    }

    /**
     * Return a formatted array for the address.
     *
     * @param array $keys Override default key names
     */
    public function toArray(array $keys = []): array
    {
        $keys = array_replace(
            ['line_1', 'line_2', 'line_3', 'line_4', 'locality', 'town_or_city', 'county'],
            $keys
        );

        return array_combine($keys, $this->address);
    }

    /**
     * Returns a string based on the address.
     *
     * @param bool $removeEmptyElements Prevents strings having conjoining commas
     */
    public function toString(bool $removeEmptyElements = false): string
    {
        if ($removeEmptyElements === false) {
            return implode(',', $this->address);
        }

        return implode(',', array_filter($this->address, function ($value) {
            return trim($value) !== '';
        }));
    }

    /**
     * Compare two addresses to see if they are equal.
     *
     * @param \Laralabs\GetAddress\Responses\Address $address Address to compare
     */
    public function sameAs(self $address): bool
    {
        return !array_diff($this->address, $address->toArray());
    }

    public function __toString(): string
    {
        return $this->toString();
    }
}
