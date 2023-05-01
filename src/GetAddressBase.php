<?php

namespace Laralabs\GetAddress;

use GuzzleHttp\Client;
use Laralabs\GetAddress\Exceptions\ForbiddenException;
use Laralabs\GetAddress\Exceptions\Handler;
use Laralabs\GetAddress\Exceptions\InvalidPostcodeException;
use Laralabs\GetAddress\Exceptions\PostcodeNotFoundException;
use Laralabs\GetAddress\Exceptions\ServerException;
use Laralabs\GetAddress\Exceptions\TooManyRequestsException;
use Laralabs\GetAddress\Exceptions\UnknownException;

class GetAddressBase
{
    /**
     * @var string
     */
    protected $apiKey;

    /**
     * @var string
     */
    protected $adminKey;

    /**
     * @var bool
     */
    protected $requiresAdminKey = false;

    /**
     * @var int
     */
    protected $delay;

    /**
     * @var string
     */
    protected $url;

    /**
     * @var bool
     */
    protected $expand;

    /**
     * @var array
     */
    protected $queryString = [];

    /**
     * @var \GuzzleHttp\Client
     */
    protected $http;

    public function __construct($apiKey = null, $adminKey = null)
    {
        $this->apiKey = $apiKey ?? config('getaddress.api_key');
        $this->adminKey = $adminKey ?? config('getaddress.admin_key');
        $this->delay = config('getaddress.limit_delay');
        $this->url = config('getaddress.url');
        $this->expand = config('getaddress.expanded_results');
        $this->http = new Client();
    }

    /**
     * Call an external resource.
     *
     * @param $method
     * @param $url
     * @param array $parameters
     *
     * @throws ForbiddenException
     * @throws InvalidPostcodeException
     * @throws PostcodeNotFoundException
     * @throws ServerException
     * @throws TooManyRequestsException
     * @throws UnknownException
     *
     * @return array
     */
    public function call($method, $url, array $parameters = []): array
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
