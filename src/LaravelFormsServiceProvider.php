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

    public function bootingPackage(): void
    {
        $this->app->bind(
            LaravelFormsHandlerService::class,
            LaravelFormsSubmitService::class,
        );
    }

    public function registeringPackage(): void
    {
        Route::prefix('forms')->middleware('web')->group(function () {
            Route::post('/submit', [LaravelFormsSubmitController::class, 'handleSubmit'])
                ->name('validate.form');
            Route::post('/step', [LaravelFormsSubmitController::class, 'handleModalStep'])
                ->name('form.handle.step');
            Route::get('/modal', [LaravelFormsSubmitController::class, 'showModalForm'])
                ->name('form.show');
            Route::get('/back', [LaravelFormsSubmitController::class, 'backModalStep'])
                ->name('form.back');
        });

        Route::get('/thank-you', function () {
            return view('laravel-forms::thank-you');
        })->name('thank-you');
    }
}
