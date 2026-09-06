<?php

use Illuminate\Support\Facades\Http;
use JeffersonGoncalves\Clearbit\Facades\Clearbit;

it('searches prospector with filters', function () {
    Http::fake([
        '*/v1/people/search*' => Http::response(['results' => [['name' => 'Jane Doe']]]),
    ]);

    $result = Clearbit::prospector()->search('example.com', [
        'role' => 'engineering',
        'seniority' => 'senior',
        'title' => 'Engineer',
        'page' => 2,
        'page_size' => 10,
    ]);

    expect($result['results'][0]['name'])->toBe('Jane Doe');

    Http::assertSent(function ($request) {
        return str_contains((string) $request->url(), 'prospector.clearbit.com/v1/people/search')
            && $request['domain'] === 'example.com'
            && $request['role'] === 'engineering'
            && $request['seniority'] === 'senior'
            && $request['title'] === 'Engineer'
            && $request['page'] === 2
            && $request['page_size'] === 10;
    });
});

it('searches prospector with only the domain', function () {
    Http::fake(['*/v1/people/search*' => Http::response(['results' => []])]);

    Clearbit::prospector()->search('example.com');

    Http::assertSent(fn ($request) => $request['domain'] === 'example.com' && ! isset($request['role']));
});

it('requires a domain to search prospector', function () {
    Clearbit::prospector()->search('');
})->throws(InvalidArgumentException::class);
