<?php

namespace Laralabs\GetAddress\Cache;

use Illuminate\Support\Collection;
use Laralabs\GetAddress\Models\CachedAddress;
use Laralabs\GetAddress\Responses\Address;
use Laralabs\GetAddress\Responses\AddressCollectionResponse;
use Laralabs\GetAddress\Responses\ExpandedAddress;

class Manager
{
    protected int $expiry = 30;

    protected bool $expand = false;

    public function __construct()
    {
        $this->expiry = config('getaddress.cache_expiry');
        $this->expand = config('getaddress.expanded_results');
    }

    public function checkCache(string $postcode, string|int $property): ?array
    {
        $params = ['postcode' => $postcode, 'property' => $property];

        $results = CachedAddress::where(static function ($query) use ($params) {
            $params['property'] !== null ? $query->where('postcode', '=', $params['postcode'])
                ->where('line_1', 'LIKE', '%'.$params['property'].'%') : $query->where(
                    'postcode',
                    '=',
                    $params['postcode']
            );
        })->get();

        if (count($results) >= 1) {
            return $this->checkExpiry($results);
        }

        return null;
    }

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

    protected function checkExpiry(Collection $results): ?array
    {
        $address = $results->first();

        if ($address->created_at <= now()->subDays($this->expiry)) {
            CachedAddress::where('postcode', '=', $address->postcode)->delete();

            return null;
        }

        return $this->formatCachedAddresses($results);
    }

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

                return $address->formatted_string;
            })->toArray(),
        ];
    }
}
