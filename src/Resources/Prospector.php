<?php

namespace JeffersonGoncalves\Clearbit\Resources;

use InvalidArgumentException;
use JeffersonGoncalves\Clearbit\ClearbitClient;

class Prospector
{
    public function __construct(
        protected ClearbitClient $client,
    ) {}

    /** @param array<string, mixed> $filters */
    public function search(string $domain, array $filters = []): array
    {
        if ($domain === '') {
            throw new InvalidArgumentException('The "domain" argument must not be empty.');
        }

        $query = array_filter([
            'domain' => $domain,
            'role' => $filters['role'] ?? null,
            'seniority' => $filters['seniority'] ?? null,
            'title' => $filters['title'] ?? null,
            'page' => $filters['page'] ?? null,
            'page_size' => $filters['page_size'] ?? null,
        ], fn (mixed $value) => $value !== null);

        return $this->client->get('https://prospector.clearbit.com', '/v1/people/search', $query);
    }
}
