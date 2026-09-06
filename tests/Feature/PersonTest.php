<?php

use Illuminate\Support\Facades\Http;
use JeffersonGoncalves\Clearbit\Exceptions\ClearbitException;
use JeffersonGoncalves\Clearbit\Facades\Clearbit;

it('finds a person by email', function () {
    Http::fake([
        '*/v2/people/find*' => Http::response(['email' => 'jane@example.com', 'name' => ['fullName' => 'Jane Doe']]),
    ]);

    $result = Clearbit::person()->find('jane@example.com');

    expect($result['name']['fullName'])->toBe('Jane Doe');

    Http::assertSent(function ($request) {
        return str_contains((string) $request->url(), 'person-stream.clearbit.com/v2/people/find')
            && $request['email'] === 'jane@example.com'
            && $request->hasHeader('Authorization');
    });
});

it('requires an email to find a person', function () {
    Clearbit::person()->find('');
})->throws(InvalidArgumentException::class);

it('throws a ClearbitException on a failed find request', function () {
    Http::fake(['*/v2/people/find*' => Http::response(['error' => ['type' => 'not_found', 'message' => 'Person not found']], 404)]);

    Clearbit::person()->find('missing@example.com');
})->throws(ClearbitException::class, 'Person not found');
