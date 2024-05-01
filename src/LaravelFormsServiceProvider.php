<?php

namespace Fuelviews\LaravelForms;

use App\Http\Controllers\FormSubmitController;
use Fuelviews\LaravelForms\Commands\LaravelFormsCommand;
use Fuelviews\Sitemap\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;
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
            ->hasCommand(LaravelFormsCommand::class);
    }

    public function PackageRegistered(): void
    {
        Route::get('/validate-form', [FormSubmitController::class, 'handle'])
            ->name('validate.form');
    }
}
