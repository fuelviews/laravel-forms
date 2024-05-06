<?php

namespace Fuelviews\LaravelForms;

use Fuelviews\LaravelForms\Contracts\LaravelFormsHandlerService;
use Fuelviews\LaravelForms\Http\Controllers\LaravelFormsSubmitController;
use Fuelviews\LaravelForms\Services\LaravelFormsSubmitService;
use Illuminate\Support\Facades\Route;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

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

        Route::post('/forms-submit', [LaravelFormsSubmitController::class, 'handle'])
            ->name('validate.form');
        Route::post('/forms-step', [LaravelFormsSubmitController::class, 'handleStep'])
            ->middleware('web')
            ->name('form.handle.step');
        Route::get('/forms-modal', [LaravelFormsSubmitController::class, 'showForm'])
            ->middleware('web')
            ->name('form.show');
        Route::get('/forms-back', [LaravelFormsSubmitController::class, 'backStep'])
            ->name('form.back');

        Route::get('/thank-you', function () {
            return view('laravel-forms::thank-you');
        })->name('thank-you');
    }
}
