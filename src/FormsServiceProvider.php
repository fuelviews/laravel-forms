<?php

namespace Fuelviews\Forms;

use Fuelviews\Forms\Commands\FormsInstallCommand;
use Fuelviews\Forms\Contracts\FormsHandlerService;
use Fuelviews\Forms\Http\Controllers\FormsSubmitController;
use Fuelviews\Forms\Livewire\FormsModal;
use Fuelviews\Forms\Services\FormsSubmitService;
use Fuelviews\Forms\Services\FormsValidationRuleService;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;
use Spatie\GoogleTagManager\GoogleTagManagerFacade;
use Spatie\GoogleTagManager\GoogleTagManagerServiceProvider;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FormsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('forms')
            ->hasConfigFile('forms')
            ->hasViews('forms')
            ->hasCommand(FormsInstallCommand::class);
    }

    public function bootingPackage(): void
    {
        $this->app->singleton(FormsHandlerService::class, FormsSubmitService::class);

        $this->app->singleton(FormsValidationRuleService::class, function ($app) {
            return new FormsValidationRuleService();
        });

        if (! function_exists('providerIsLoaded')) {
            function providerIsLoaded($app, $providerClass)
            {
                return collect($app->getLoadedProviders())->has($providerClass);
            }
        }

        if (class_exists(GoogleTagManagerServiceProvider::class)) {
            if (! providerIsLoaded($this->app, GoogleTagManagerServiceProvider::class)) {
                $this->app->register(GoogleTagManagerServiceProvider::class);
            }

            if (! $this->app->bound('GoogleTagManager')) {
                $this->app->alias('GoogleTagManager', GoogleTagManagerFacade::class);
            }
        }
    }

    public function packageBooted(): void
    {
        if (class_exists(\Livewire\Livewire::class)) {
            Livewire::component('forms-modal', FormsModal::class);
        }
    }

    public function registeringPackage(): void
    {
        Route::prefix('forms')->group(function () {
            Route::post('/submit', [FormsSubmitController::class, 'handleSubmit'])->name('form.validate');
            Route::get('/thank-you', function () {
                $layoutsApp = Forms::getLayout();

                return view('forms::components.thank-you', compact('layoutsApp'));
            })->name('thank-you');
        });
    }
}
