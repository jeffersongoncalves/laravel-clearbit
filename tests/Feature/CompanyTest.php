<?php

use Illuminate\Support\Facades\Http;
use JeffersonGoncalves\Clearbit\Facades\Clearbit;

it('finds a company by domain', function () {
    Http::fake([
        '*/v2/companies/find*' => Http::response(['domain' => 'example.com', 'name' => 'Example Inc.']),
    ]);

    $result = Clearbit::company()->find('example.com');

    expect($result['name'])->toBe('Example Inc.');

    Http::assertSent(fn ($request) => str_contains((string) $request->url(), 'company-stream.clearbit.com/v2/companies/find')
        && $request['domain'] === 'example.com');
});

it('requires a domain to find a company', function () {
    Clearbit::company()->find('');
})->throws(InvalidArgumentException::class);
