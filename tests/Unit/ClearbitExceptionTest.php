<?php

use Illuminate\Http\Client\Response;
use Illuminate\Http\Client\Response as HttpResponse;
use JeffersonGoncalves\Clearbit\Exceptions\ClearbitException;

function fakeClearbitResponse(int $status, array $body): Response
{
    $psr = new GuzzleHttp\Psr7\Response($status, [], json_encode($body));

    return new HttpResponse($psr);
}

it('builds the exception message from the response "error.message" field', function () {
    $response = fakeClearbitResponse(422, ['error' => ['type' => 'unprocessable_entity', 'message' => 'Email is required']]);

    $exception = ClearbitException::fromResponse($response);

    expect($exception->getMessage())->toBe('Email is required')
        ->and($exception->getCode())->toBe(422)
        ->and($exception->errorBody())->toBe(['error' => ['type' => 'unprocessable_entity', 'message' => 'Email is required']]);
});

it('falls back to the "error.type" field when "error.message" is missing', function () {
    $response = fakeClearbitResponse(401, ['error' => ['type' => 'unauthorized']]);

    $exception = ClearbitException::fromResponse($response);

    expect($exception->getMessage())->toBe('unauthorized');
});

it('falls back to a generic message when the body has no known error keys', function () {
    $response = fakeClearbitResponse(500, []);

    $exception = ClearbitException::fromResponse($response);

    expect($exception->getMessage())->toBe('Clearbit API error (HTTP 500).');
});
