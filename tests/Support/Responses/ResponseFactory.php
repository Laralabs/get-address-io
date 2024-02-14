<?php

namespace Laralabs\GetAddress\Tests\Support\Responses;

use Illuminate\Http\Client\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Laralabs\GetAddress\Responses\Address;
use Laralabs\GetAddress\Responses\AddressCollectionResponse;
use Laralabs\GetAddress\Responses\SingleAddressCollectionResponse;

class ResponseFactory
{
    protected string $fileName;

    protected string $response;

    protected ?array $decodedResponse = null;

    public function __construct(string $fileName)
    {
        $this->fileName = $fileName;
        $this->response = file_get_contents(__DIR__ . '/examples/' . $fileName);
        $this->decodedResponse = json_decode($this->response, true);
    }

    public static function make(string $fileName): self
    {
        return new self($fileName);
    }

    public function getHttpFake(?array $attributes = null): Factory
    {
        return Http::fake($attributes ?? [
            '*' => Http::response(ResponseFactory::make($this->fileName)->getResponse()),
        ]);
    }

    public function getResponse(): string
    {
        return $this->response;
    }

    public function makeAddressCollectionResponse(): AddressCollectionResponse
    {
        return new AddressCollectionResponse(
            Arr::get($this->decodedResponse, 'postcode'),
            Arr::get($this->decodedResponse, 'latitude'),
            Arr::get($this->decodedResponse, 'longitude'),
            $this->hydrateAddresses()
        );
    }

    public function makeSingleAddressCollectionResponse(): SingleAddressCollectionResponse
    {
        return new SingleAddressCollectionResponse($this->decodedResponse);
    }

    private function hydrateAddresses(): array
    {
        return collect($this->decodedResponse['addresses'])->transform(
            static fn (array $address): Address => new Address(array_values($address))
        )->toArray();
    }
}