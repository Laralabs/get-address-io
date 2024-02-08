<?php

namespace Laralabs\GetAddress\Http;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Laralabs\GetAddress\Exceptions\Handler;

class Client
{
    protected string $apiKey;

    protected ?string $adminKey = null;

    protected int $delay = 0;

    protected string $url;

    protected bool $expand = false;

    protected bool $adminMode = false;

    protected int $attempts = 0;

    public function __construct(?string $apiKey = null, ?string $adminKey = null)
    {
        $this->apiKey = $apiKey ?? config('getaddress.api_key');
        $this->adminKey = $adminKey ?? config('getaddress.admin_key');
        $this->delay = config('getaddress.limit_delay');
        $this->url = config('getaddress.url');
        $this->expand = config('getaddress.expanded_results');
    }

    public function get(string $endpoint, string|array $term, array $queryParameters = []): ?array
    {
        $url = $this->buildUrl($endpoint, $term);
        $queryParameters['api-key'] = $this->getApiKey();

        if ($this->expand) {
            $queryParameters['expand'] = true;
        }

        $response = $this->handleResponse(Http::withQueryParameters($queryParameters)->get($url));

        if ($response === null && $this->attempts === 0) {
            $this->attempts = 1;

            return $this->handleResponse(Http::withQueryParameters($queryParameters)->get($url));
        }

        return $response;
    }

    private function handleResponse(PromiseInterface|Response $response): mixed
    {
        if ($response->failed() && $response->status() !== 429) {
            Handler::throwException($response->status());
        }

        if ($response->status() === 429) {
            sleep($this->delay + .25);
            return null;
        }

        if ($response->failed()) {
            Handler::throwException($response->status());
        }

        return $response->json();
    }

    private function getApiKey(): ?string
    {
        return $this->isAdminMode() ? $this->adminKey : $this->apiKey;
    }

    private function buildUrl(string $endpoint, string|array $term): string
    {
        if (is_array($term)) {
            return Str::of($this->url)
                ->append("/{$endpoint}")
                ->append("/")
                ->append(implode("/", array_filter($term)));
        }

        return Str::of($this->url)->append("/{$endpoint}")->append("/{$term}");
    }

    public function admin(): self
    {
        $this->adminMode = true;

        return $this;
    }

    public function isAdminMode(): bool
    {
        return $this->adminMode;
    }
}