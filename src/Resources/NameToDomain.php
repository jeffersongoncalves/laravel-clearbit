<?php

namespace JeffersonGoncalves\Clearbit\Resources;

use InvalidArgumentException;
use JeffersonGoncalves\Clearbit\ClearbitClient;

class NameToDomain
{
    public function __construct(
        protected ClearbitClient $client,
    ) {}

    public function find(string $name): array
    {
        if ($name === '') {
            throw new InvalidArgumentException('The "name" argument must not be empty.');
        }

        return $this->client->get('https://company.clearbit.com', '/v1/domains/find', ['name' => $name]);
    }
}
