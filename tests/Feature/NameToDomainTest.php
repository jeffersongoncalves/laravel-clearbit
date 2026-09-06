<?php

use Illuminate\Support\Facades\Http;
use JeffersonGoncalves\Clearbit\Facades\Clearbit;

it('finds a domain by company name', function () {
    Http::fake([
        '*/v1/domains/find*' => Http::response(['domain' => 'example.com', 'name' => 'Example Inc.']),
    ]);

    $result = Clearbit::nameToDomain()->find('Example Inc.');

    expect($result['domain'])->toBe('example.com');

    Http::assertSent(fn ($request) => str_contains((string) $request->url(), 'company.clearbit.com/v1/domains/find')
        && $request['name'] === 'Example Inc.');
});

it('requires a name to find a domain', function () {
    Clearbit::nameToDomain()->find('');
})->throws(InvalidArgumentException::class);
