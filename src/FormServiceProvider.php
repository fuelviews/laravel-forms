<?php

namespace Fuelviews\LaravelForm;

use Fuelviews\LaravelForm\Livewire\FormModal;
use Fuelviews\LaravelForm\Contracts\FormHandlerService;
use Fuelviews\LaravelForm\Http\Controllers\FormModalController;
use Fuelviews\LaravelForm\Http\Controllers\FormSubmitController;
use Fuelviews\LaravelForm\Services\FormSubmitService;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;
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

        Livewire::component('form-modal', FormModal::class);
    }
    public function registeringPackage(): void
    {
        Route::prefix('forms')->middleware('web')->group(function () {
            Route::post('/submit', [FormSubmitController::class, 'handleSubmit'])
                ->name('form.validate');
            Route::post('/step', [FormModalController::class, 'handleModalStep'])
                ->name('form.modal.step.handle');
            Route::get('/modal', [FormModalController::class, 'showModalForm'])
                ->name('form.modal.step.show');
            Route::get('/back', [FormModalController::class, 'backModalStep'])
                ->name('form.modal.step.back');
        });

        Route::get('/thank-you', function () {
            return view('laravel-form::components.thank-you');
        })->name('thank-you');
    }
}
