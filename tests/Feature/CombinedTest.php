<?php

use Illuminate\Support\Facades\Http;
use JeffersonGoncalves\Clearbit\Facades\Clearbit;

it('finds combined person and company data by email', function () {
    Http::fake([
        '*/v2/combined/find*' => Http::response(['person' => ['email' => 'jane@example.com'], 'company' => ['name' => 'Example Inc.']]),
    ]);

    $result = Clearbit::combined()->find('jane@example.com');

    expect($result['company']['name'])->toBe('Example Inc.');

    Http::assertSent(fn ($request) => str_contains((string) $request->url(), 'person-stream.clearbit.com/v2/combined/find')
        && $request['email'] === 'jane@example.com');
});

it('requires an email for combined find', function () {
    Clearbit::combined()->find('');
})->throws(InvalidArgumentException::class);
