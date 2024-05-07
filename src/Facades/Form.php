<?php

namespace Fuelviews\LaravelForm\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Fuelviews\LaravelForm\Form
 */
class Form extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Fuelviews\LaravelForm\Form::class;
    }
}
