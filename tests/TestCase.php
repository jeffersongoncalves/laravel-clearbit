<?php

namespace JeffersonGoncalves\Clearbit\Tests;

use JeffersonGoncalves\Clearbit\ClearbitServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            ClearbitServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app): void
    {
        $app['config']->set('clearbit.api_key', 'test-api-key');
    }
}
