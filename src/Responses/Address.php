<?php

namespace Laralabs\GetAddress\Responses;

class Address
{
    /**
     * Sort returned addresses numerically.
     *
     * @var bool
     */
    const SORT_NUMERICALLY = true;

    /**
     * Dont perform any specific sort on the returned addresses.
     *
     * @var bool
     */
    const NO_SORT = false;

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
        $this->address = explode(',', $address);
    }

    /**
     * Get Line 1.
     *
     * @return string
     */
    public function getLine1(): string
    {
        return $this->address[0];
    }

    /**
     * Get Line 2.
     *
     * @return string
     */
    public function getLine2(): string
    {
        return $this->address[1];
    }

    /**
     * Get Line 3.
     *
     * @return string
     */
    public function getLine3(): string
    {
        return $this->address[2];
    }

    /**
     * Get Line 4.
     *
     * @return string
     */
    public function getLine4(): string
    {
        return $this->address[3];
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
        return $this->address[$line - 1];
    }

    /**
     * Get Locality.
     *
     * @return string
     */
    public function getLocality(): string
    {
        return $this->address[4];
    }

    /**
     * Get Town.
     *
     * @return string
     */
    public function getTown(): string
    {
        return $this->address[5];
    }

    /**
     * Get City.
     *
     * @return string
     *
     * @see Address:getTown()
     */
    public function getCity(): string
    {
        return $this->address[5];
    }

    /**
     * County.
     *
     * @return string
     */
    public function getCounty(): string
    {
        return $this->address[6];
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
     *
     * @return string
     */
    public function toString($removeEmptyElements = false): string
    {
        if (!$removeEmptyElements) {
            return implode(',', $this->address);
        }

        return implode(',', array_filter($this->address, function ($value) {
            return $value !== ' ';
        }));
    }

    /**
     * Compare two addresses to see if they are equal.
     *
     * @param \Laralabs\GetAddress\Responses\Address $address Address to compare
     *
     * @return bool
     */
    public function sameAs(self $address): bool
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
