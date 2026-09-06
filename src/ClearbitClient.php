<?php

namespace JeffersonGoncalves\Clearbit;

use Illuminate\Support\Facades\Http;
use JeffersonGoncalves\Clearbit\Exceptions\ClearbitException;

/**
 * Thin wrapper around Laravel's Http client for the Clearbit REST APIs.
 *
 * Clearbit authenticates via HTTP Basic Auth (API key as username, empty
 * password) and spreads its resources across several subdomains, so every
 * call takes its own base URL.
 *
 * ponytail: Http::retry() already covers transient-failure retries if ever
 * needed later — no custom retry/backoff layer built here speculatively.
 */
class ClearbitClient
{
    public function __construct(
        protected string $apiKey,
    ) {}

    /** @param array<string, mixed> $query */
    public function get(string $baseUrl, string $path, array $query = []): array
    {
        $query = array_filter($query, fn (mixed $value) => $value !== null);

        $response = Http::withBasicAuth($this->apiKey, '')
            ->acceptJson()
            ->baseUrl($baseUrl)
            ->get($path, $query);

        if ($response->failed()) {
            throw ClearbitException::fromResponse($response);
        }

        return (array) ($response->json() ?? []);
    }
}
