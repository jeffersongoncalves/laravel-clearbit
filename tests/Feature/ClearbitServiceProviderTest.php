<?php

use JeffersonGoncalves\Clearbit\Clearbit as ClearbitManager;
use JeffersonGoncalves\Clearbit\Facades\Clearbit;

it('merges the default config', function () {
    expect(config('clearbit.api_key'))->toBe('test-api-key');
});

it('resolves the facade to the manager singleton', function () {
    expect(Clearbit::getFacadeRoot())->toBeInstanceOf(ClearbitManager::class);
});

it('always resolves the same manager instance', function () {
    expect(app(ClearbitManager::class))->toBe(app(ClearbitManager::class));
});
