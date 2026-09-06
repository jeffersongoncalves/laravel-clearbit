<?php

namespace JeffersonGoncalves\Clearbit;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class ClearbitServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('clearbit')
            ->hasConfigFile();
    }

    public function packageRegistered(): void
    {
        $this->app->singleton(Clearbit::class, function () {
            return new Clearbit((string) config('clearbit.api_key'));
        });
    }
}
