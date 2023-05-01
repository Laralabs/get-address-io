<?php

namespace Laralabs\GetAddress;

use GuzzleHttp\Client;
use Laralabs\GetAddress\Exceptions\Handler;

class GetAddressBase
{
    protected string $apiKey;

    protected ?string $adminKey = null;

    protected bool $requiresAdminKey = false;

    protected int $delay = 0;

    protected string $url;

    protected bool $expand = false;

    protected array $queryString = [];

    protected Client $http;

    public function __construct($apiKey = null, $adminKey = null)
    {
        $this->apiKey = $apiKey ?? config('getaddress.api_key');
        $this->adminKey = $adminKey ?? config('getaddress.admin_key');
        $this->delay = config('getaddress.limit_delay');
        $this->url = config('getaddress.url');
        $this->expand = config('getaddress.expanded_results');
        $this->http = new Client();
    }

    public function call(string $method, string $url, array $parameters = []): array
    {
        $this->queryString['api-key'] = $this->requiresAdminKey ? $this->adminKey : $this->apiKey;

        $method = strtolower($method);
        $url = sprintf('%s/%s?%s', $this->url, $url, http_build_query($this->queryString));

        if ($this->expand) {
            $url .= '&expand=true';
        }

        $response = $this->http->{$method}($url, $parameters);

        if (floor($response->getStatusCode() / 100) > 2) {
            if ($response->getStatusCode() !== 429) {
                Handler::throwException($response->getStatusCode());
            }

            sleep($this->delay + .25);

            $response = $this->http->{$method}($url, $parameters);

            if ($response->getStatusCode() !== 200) {
                Handler::throwException($response->getStatusCode());
            }
        }

        return json_decode($response->getBody(), true);
    }
}
