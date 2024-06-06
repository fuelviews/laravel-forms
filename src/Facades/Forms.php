<?php

namespace Fuelviews\Forms\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Fuelviews\Forms\Forms
 */
class Forms extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Fuelviews\Forms\Forms::class;
    }
}
