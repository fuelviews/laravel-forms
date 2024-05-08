<?php

namespace Fuelviews\LaravelForm;

use Fuelviews\LaravelForm\Contracts\FormHandlerService;
use Fuelviews\LaravelForm\Http\Controllers\FormModalController;
use Fuelviews\LaravelForm\Http\Controllers\FormSubmitController;
use Fuelviews\LaravelForm\Services\FormSubmitService;
use Illuminate\Support\Facades\Route;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FormServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-form')
            ->hasConfigFile('forms')
            ->hasViews('laravel-form');
    }

    public function bootingPackage(): void
    {
        $this->app->bind(
            FormHandlerService::class,
            FormSubmitService::class,
        );
    }

    public function registeringPackage(): void
    {
        Route::prefix('forms')->middleware('web')->group(function () {
            Route::post('/submit', [FormSubmitController::class, 'handleSubmit'])
                ->name('validate.form');
            Route::post('/step', [FormModalController::class, 'handleModalStep'])
                ->name('form.handle.step');
            Route::get('/modal', [FormModalController::class, 'showModalForm'])
                ->name('form.show');
            Route::get('/back', [FormModalController::class, 'backModalStep'])
                ->name('form.back');
        });

        Route::get('/thank-you', function () {
            return view('laravel-form::components.thank-you');
        })->name('thank-you');
    }
}
