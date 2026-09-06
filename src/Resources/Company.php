<?php

namespace JeffersonGoncalves\Clearbit\Resources;

use InvalidArgumentException;
use JeffersonGoncalves\Clearbit\ClearbitClient;

class Company
{
    public function __construct(
        protected ClearbitClient $client,
    ) {}

    public function find(string $domain): array
    {
        if ($domain === '') {
            throw new InvalidArgumentException('The "domain" argument must not be empty.');
        }

        return $this->client->get('https://company-stream.clearbit.com', '/v2/companies/find', ['domain' => $domain]);
    }
}
