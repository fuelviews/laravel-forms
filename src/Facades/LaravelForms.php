<?php

namespace Fuelviews\LaravelForms\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Fuelviews\LaravelForms\LaravelForms
 */
class LaravelForms extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Fuelviews\LaravelForms\LaravelForms::class;
    }
}
