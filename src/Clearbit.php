<?php

namespace JeffersonGoncalves\Clearbit;

use JeffersonGoncalves\Clearbit\Resources\Combined;
use JeffersonGoncalves\Clearbit\Resources\Company;
use JeffersonGoncalves\Clearbit\Resources\NameToDomain;
use JeffersonGoncalves\Clearbit\Resources\Person;
use JeffersonGoncalves\Clearbit\Resources\Prospector;
use JeffersonGoncalves\Clearbit\Resources\Reveal;

/**
 * Entry point exposing one resource per Clearbit API.
 */
class Clearbit
{
    protected ClearbitClient $client;

    public function __construct(string $apiKey)
    {
        $this->client = new ClearbitClient($apiKey);
    }

    public function person(): Person
    {
        return new Person($this->client);
    }

    public function company(): Company
    {
        return new Company($this->client);
    }

    public function combined(): Combined
    {
        return new Combined($this->client);
    }

    public function reveal(): Reveal
    {
        return new Reveal($this->client);
    }

    public function nameToDomain(): NameToDomain
    {
        return new NameToDomain($this->client);
    }

    public function prospector(): Prospector
    {
        return new Prospector($this->client);
    }
}
