<?php

namespace Fuelviews\LaravelForm;

use Fuelviews\LaravelForm\Contracts\FormHandlerService;
use Fuelviews\LaravelForm\Http\Controllers\FormSubmitController;
use Fuelviews\LaravelForm\Livewire\FormModal;
use Fuelviews\LaravelForm\Services\FormSubmitService;
use Fuelviews\LaravelForm\Services\FormValidationRuleService;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;
use Spatie\GoogleTagManager\GoogleTagManagerServiceProvider;
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
        $this->app->singleton(FormHandlerService::class, FormSubmitService::class);

        $this->app->singleton(FormValidationRuleService::class, function ($app) {
            return new FormValidationRuleService();
        });

        if (! $this->app->getProvider(GoogleTagManagerServiceProvider::class)) {
            $this->app->register(GoogleTagManagerServiceProvider::class);
        }

        if (! $this->app->bound('GoogleTagManager')) {
            $this->app->alias('GoogleTagManager', \Spatie\GoogleTagManager\GoogleTagManagerFacade::class);
        }
    }

    public function packageBooted()
    {
        Livewire::component('form-modal', FormModal::class);
    }

    public function registeringPackage(): void
    {
        Route::prefix('forms')->group(function () {
            Route::post('/submit', [FormSubmitController::class, 'handleSubmit'])->name('form.validate');
            Route::get('/thank-you', function () {
                $layoutsApp = Form::getLayout();

                return view('laravel-form::components.thank-you', compact('layoutsApp'));
            })->name('thank-you');
        });
    }
}
