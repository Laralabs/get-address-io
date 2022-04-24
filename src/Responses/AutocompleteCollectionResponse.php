<?php

namespace Laralabs\GetAddress\Responses;

use Illuminate\Http\JsonResponse;

class AutocompleteCollectionResponse
{
    protected ?array $suggestions;

    public function __construct(?array $suggestions)
    {
        $this->suggestions = $suggestions;
    }

    public function all(): array
    {
        return $this->getSuggestions();
    }

    public function getSuggestions(): array
    {
        return $this->suggestions;
    }

    public function toArray(): array
    {
        return [
            'suggestions' => $this->suggestions,
        ];
    }

    public function respond(): JsonResponse
    {
        return response()->json($this->toArray());
    }
}
