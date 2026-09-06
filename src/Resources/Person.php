<?php

namespace JeffersonGoncalves\Clearbit\Resources;

use InvalidArgumentException;
use JeffersonGoncalves\Clearbit\ClearbitClient;

class Person
{
    public function __construct(
        protected ClearbitClient $client,
    ) {}

    public function find(string $email): array
    {
        if ($email === '') {
            throw new InvalidArgumentException('The "email" argument must not be empty.');
        }

        return $this->client->get('https://person-stream.clearbit.com', '/v2/people/find', ['email' => $email]);
    }
}
