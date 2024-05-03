<?php

namespace Fuelviews\LaravelForms;

use Fuelviews\LaravelForms\Contracts\LaravelFormsHandlerService;
use Fuelviews\LaravelForms\Http\Controllers\LaravelFormsSubmitController;
use Illuminate\Support\Facades\Route;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Fuelviews\LaravelForms\Services\LaravelFormsSubmitService;

class LaravelFormsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-forms')
            ->hasConfigFile('forms')
            ->hasViews('laravel-forms');
    }

    public function PackageRegistered(): void
    {
        $this->app->bind(
            LaravelFormsHandlerService::class,
            LaravelFormsSubmitService::class,
        );

        Route::post('/validate-form', [LaravelFormsSubmitController::class, 'handle'])
            ->name('validate.form');

        Route::get('/thank-you', function () {
            return view('laravel-forms::thank-you');
        })->name('thank-you');
    }
}
