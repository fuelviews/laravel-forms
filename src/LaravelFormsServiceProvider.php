<?php

namespace Fuelviews\LaravelForms;

use Fuelviews\LaravelForms\Commands\LaravelFormsCommand;
use Fuelviews\LaravelForms\Contracts\LaravelFormsHandlerService;
use Fuelviews\LaravelForms\Http\Controllers\LaravelFormSubmitController;
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
            ->hasConfigFile('forms')
            ->hasViews('laravel-forms')
            ->hasCommand(LaravelFormsCommand::class);
    }

    public function PackageRegistered(): void
    {
        $this->app->bind(
            'Fuelviews\LaravelForms\Contracts\LaravelFormsHandlerService',
            'Fuelviews\LaravelForms\Services\LaravelFormsSubmitService' // Replace with your actual implementation
        );

        Route::post('/validate-form', [LaravelFormSubmitController::class, 'handle'])
            ->name('validate.form');

        Route::get('/thank-you', function () {
            return view('laravel-forms::thank-you');
        })->name('thank-you');
    }
}
