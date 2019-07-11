<?php

namespace Laralabs\GetAddress\Cache;

use Illuminate\Support\Collection;
use Laralabs\GetAddress\Models\CachedAddress;
use Laralabs\GetAddress\Responses\Address;
use Laralabs\GetAddress\Responses\AddressCollectionResponse;
use Laralabs\GetAddress\Responses\ExpandedAddress;

class Manager
{
    /**
     * @var int
     */
    protected $expiry;

    /**
     * @var bool
     */
    protected $expand;

    public function __construct()
    {
        $this->expiry = config('getaddress.cache_expiry');
        $this->expand = config('getaddress.expanded_results');
    }

    /**
     * @param $postcode
     * @param $property
     *
     * @return array|null
     */
    public function checkCache($postcode, $property): ?array
    {
        $params = ['postcode' => $postcode, 'property' => $property];

        $results = CachedAddress::where(function ($query) use ($params) {
            $params['property'] !== null ? $query->where('postcode', '=', $params['postcode'])->where('line_1', 'LIKE', '%'.$params['property'].'%')
                : $query->where('postcode', '=', $params['postcode']);
        })->get();

        if (count($results) >= 1) {
            return $this->checkExpiry($results);
        }

        return null;
    }

    /**
     * Store response in cache.
     *
     * @param AddressCollectionResponse $response
     *
     * @return AddressCollectionResponse
     */
    public function responseToCache(AddressCollectionResponse $response): AddressCollectionResponse
    {
        foreach ($response->getAddresses() as $address) {
            if ($address instanceof ExpandedAddress) {
                CachedAddress::create(array_merge($address->toArray(), [
                    'longitude'       => $response->getLongitude(),
                    'latitude'        => $response->getLatitude(),
                    'postcode'        => $response->getPostcode(),
                    'expanded_result' => true,
                ]));
            }

            if ($address instanceof Address) {
                CachedAddress::create(array_merge($address->toArray(), [
                    'longitude'       => $response->getLongitude(),
                    'latitude'        => $response->getLatitude(),
                    'postcode'        => $response->getPostcode(),
                    'expanded_result' => false,
                ]));
            }
        }

        return $response;
    }

    /**
     * @param Collection $results
     *
     * @return array|null
     */
    protected function checkExpiry(Collection $results): ?array
    {
        $address = $results->first();

        if ($address->created_at <= now()->subDays($this->expiry)) {
            CachedAddress::where('postcode', '=', $address->postcode)->delete();

            return null;
        }

        return $this->formatCachedAddresses($results);
    }

    /**
     * @param Collection $results
     *
     * @return array
     */
    protected function formatCachedAddresses(Collection $results): array
    {
        return [
            'longitude' => (float) $results->first()->longitude,
            'latitude'  => (float) $results->first()->latitude,
            'addresses' => $results->map(function ($address) {
                if ($this->expand) {
                    return array_merge([
                        'formatted_string'  => $address->formatted_string,
                        'formatted_address' => array_values($address->only(CachedAddress::$fields)),
                    ], $address->only(CachedAddress::$expandedFields));
                }

                return $address->formatted_address;
            })->toArray(),
        ];
    }
}
