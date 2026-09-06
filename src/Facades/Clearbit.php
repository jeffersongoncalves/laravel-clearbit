<?php

namespace JeffersonGoncalves\Clearbit\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \JeffersonGoncalves\Clearbit\Clearbit
 */
class Clearbit extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \JeffersonGoncalves\Clearbit\Clearbit::class;
    }
}
