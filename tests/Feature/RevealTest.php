<?php

use Illuminate\Support\Facades\Http;
use JeffersonGoncalves\Clearbit\Facades\Clearbit;

it('finds a company by ip', function () {
    Http::fake([
        '*/v1/companies/find*' => Http::response(['domain' => 'example.com']),
    ]);

    $result = Clearbit::reveal()->find('1.2.3.4');

    expect($result['domain'])->toBe('example.com');

    Http::assertSent(fn ($request) => str_contains((string) $request->url(), 'reveal.clearbit.com/v1/companies/find')
        && $request['ip'] === '1.2.3.4');
});

it('requires an ip to reveal a company', function () {
    Clearbit::reveal()->find('');
})->throws(InvalidArgumentException::class);
