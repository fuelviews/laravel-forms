<?php

namespace Fuelviews\Forms\Tests;

use Fuelviews\Forms\FormsServiceProvider;
use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [
            LivewireServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
    }
}
