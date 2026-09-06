<?php

namespace JeffersonGoncalves\Clearbit\Resources;

use InvalidArgumentException;
use JeffersonGoncalves\Clearbit\ClearbitClient;

class Reveal
{
    public function __construct(
        protected ClearbitClient $client,
    ) {}

    public function find(string $ip): array
    {
        if ($ip === '') {
            throw new InvalidArgumentException('The "ip" argument must not be empty.');
        }

        return $this->client->get('https://reveal.clearbit.com', '/v1/companies/find', ['ip' => $ip]);
    }
}
