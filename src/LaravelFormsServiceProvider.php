<?php

namespace Fuelviews\LaravelForms;

use Fuelviews\LaravelForms\Commands\LaravelFormsCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelFormsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-forms')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel-forms_table')
            ->hasCommand(LaravelFormsCommand::class);
    }
}
