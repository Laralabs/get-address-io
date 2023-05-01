<?php

namespace Laralabs\GetAddress;

use Laralabs\GetAddress\Cache\Manager;
use Laralabs\GetAddress\Responses\Address;
use Laralabs\GetAddress\Responses\AddressCollectionResponse;
use Laralabs\GetAddress\Responses\AutocompleteCollectionResponse;
use Laralabs\GetAddress\Responses\ExpandedAddress;
use Laralabs\GetAddress\Responses\SingleAddressCollectionResponse;

class GetAddress extends GetAddressBase
{
    protected bool $cache = false;

    protected ?Manager $manager;

    public function __construct(?string $apiKey = null)
    {
        parent::__construct($apiKey);

        $this->cache = config('getaddress.enable_cache');
        $this->manager = $this->cache ? new Manager() : null;
    }

    /**
     * Find an address or range of addresses by a postcode, and optional number/string.
     *
     * @param string     $postcode        Postcode to search for
     * @param null|int|string $propertyNumber  Property number or name
     * @param bool       $sortNumerically Sorts addresses numerically
     */
    public function find(
        string $postcode,
        null|int|string $propertyNumber = null,
        bool $sortNumerically = true
    ): AddressCollectionResponse {
        if ($this->cache) {
            $cached = $this->manager->checkCache($postcode, $propertyNumber);

            if ($cached !== null) {
                return $this->createAddressCollectionResponse($postcode, $cached);
            }
        }

        $this->queryString['sort'] = (int) $sortNumerically;

        $url = sprintf('find/%s', $postcode);
        if ($propertyNumber !== null) {
            $url .= sprintf('/%s', $propertyNumber);
        }

        $response = $this->createAddressCollectionResponse($postcode, $this->call('GET', $url));

        if ($this->cache && $propertyNumber === null) {
            $this->manager->responseToCache($response);
        }

        return $response;
    }

    public function autocomplete(string $term, ?array $parameters = null): AutocompleteCollectionResponse
    {
        return new AutocompleteCollectionResponse(
            $this->call(
                'POST',
                sprintf('autocomplete/%s', $term),
                $parameters
            )['suggestions'] ?? null
        );
    }

    public function get(string $id): SingleAddressCollectionResponse
    {
        return new SingleAddressCollectionResponse($this->call('GET', sprintf('get/%s', $id)));
    }

    /** Override expanded results. */
    public function expand(): self
    {
        $this->expand = true;

        return $this;
    }

    protected function createAddressCollectionResponse(string $postcode, array $response): AddressCollectionResponse
    {
        return new AddressCollectionResponse(
            $postcode,
            $response['latitude'],
            $response['longitude'],
            array_map(function ($address) {
                return $this->expand ? new ExpandedAddress($address) : new Address($address);
            }, $response['addresses'])
        );
    }
}
