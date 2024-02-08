<?php

namespace Laralabs\GetAddress\Tests\Support\Responses;

use Illuminate\Support\Arr;
use Laralabs\GetAddress\Responses\Address;
use Laralabs\GetAddress\Responses\AddressCollectionResponse;

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

    public function makeAddressCollectionResponse(): AddressCollectionResponse
    {
        return new AddressCollectionResponse(
            Arr::get($this->decodedResponse, 'postcode'),
            Arr::get($this->decodedResponse, 'latitude'),
            Arr::get($this->decodedResponse, 'longitude'),
            $this->hydrateAddresses()
        );
    }

    private function hydrateAddresses(): array
    {
        return collect($this->decodedResponse['addresses'])->transform(
            static fn (array $address): Address => new Address(array_values($address))
        )->toArray();
    }
}