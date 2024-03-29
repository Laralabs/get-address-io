<?php

namespace Laralabs\GetAddress;

use Laralabs\GetAddress\Cache\Manager;
use Laralabs\GetAddress\Http\Client;
use Laralabs\GetAddress\Responses\Address;
use Laralabs\GetAddress\Responses\AddressCollectionResponse;
use Laralabs\GetAddress\Responses\AutocompleteCollectionResponse;
use Laralabs\GetAddress\Responses\ExpandedAddress;
use Laralabs\GetAddress\Responses\SingleAddressCollectionResponse;

class GetAddress
{
    protected Client $http;

    protected bool $cache = false;

    protected ?Manager $manager;

    protected bool $expand = false;

    public function __construct(Client $client)
    {
        $this->http = $client;
        $this->cache = config('getaddress.enable_cache');
        $this->manager = $this->cache ? new Manager() : null;
        $this->expand = config('getaddress.expanded_results');
    }

    /**
     * Find an address or range of addresses by a postcode, and optional number/string.
     *
     * @param string $postcode Postcode to search for
     * @param null|int|string $propertyNumber Property number or name
     * @param bool $sortNumerically Sorts addresses numerically
     */
    public function find(
        string $postcode,
        null|int|string $propertyNumber = null,
        bool $sortNumerically = true
    ): AddressCollectionResponse {
        if ($this->cache) {
            $cached = $this->manager->expand($this->expand)->checkCache($postcode, $propertyNumber);

            if ($cached !== null) {
                return $this->createAddressCollectionResponse($postcode, $cached);
            }
        }

        $response = $this->createAddressCollectionResponse(
            $postcode,
            $this->http->get('find', [$postcode, $propertyNumber], [
                'sort' => (int) $sortNumerically,
                'expand' => $this->expand,
            ])
        );

        if ($this->cache && $propertyNumber === null) {
            $this->manager->responseToCache($response);
        }

        return $response;
    }

    /**
     * Get an autocomplete response for the given search term.
     * Use 'id' returned to get full address information using: @see get()
     *
     * @param string $term Search term
     * @param array $parameters Additional parameters
     */
    public function autocomplete(string $term, array $parameters = []): AutocompleteCollectionResponse
    {
        return new AutocompleteCollectionResponse(
            $this->http->post('autocomplete', $term, $parameters)['suggestions'] ?? null
        );
    }

    /**
     * Get the full address information for the given ID.
     * This method should be used when using: @see autocomplete()
     *
     * @param string $id Address unique ID.
     */
    public function get(string $id): SingleAddressCollectionResponse
    {
        return new SingleAddressCollectionResponse($this->http->get('get', $id), $this->expand);
    }

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
            array_map(function (string|array $address): ExpandedAddress|Address {
                return $this->expand && is_array($address) ? new ExpandedAddress($address) : new Address($address);
            }, $response['addresses'])
        );
    }
}
