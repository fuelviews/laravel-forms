<?php

namespace Fuelviews\Forms;

use Fuelviews\Forms\Commands\FormsInstallCommand;
use Fuelviews\Forms\Contracts\FormsHandlerService;
use Fuelviews\Forms\Http\Controllers\FormsSubmitController;
use Fuelviews\Forms\Livewire\FormsModal;
use Fuelviews\Forms\Middleware\HandleGclid;
use Fuelviews\Forms\Middleware\HandleUtm;
use Fuelviews\Forms\Services\FormsSubmitService;
use Fuelviews\Forms\Services\FormsValidationRuleService;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;
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

        $this->app->singleton(\Fuelviews\Forms\Services\FormsValidationRuleService::class, function ($app): \Fuelviews\Forms\Services\FormsValidationRuleService {
            return new FormsValidationRuleService();
        });
    }

    public function packageBooted(): void
    {
        if (class_exists(Livewire::class)) {
            Livewire::component('forms-modal', FormsModal::class);
        }

        $this->app->extend(Application::class, function (Application $application): \Illuminate\Foundation\Application {
            if (method_exists($application, 'configureMiddleware')) {
                $application->configureMiddleware(function (Middleware $middleware): void {
                    $middleware->appendToGroup('web', [
                        HandleGclid::class,
                        HandleUtm::class,
                    ]);
                });
            } else {
                $this->app->booting(function (): void {
                    $kernel = $this->app->make(Kernel::class);

                    foreach ([
                        HandleGclid::class,
                        HandleUtm::class,
                    ] as $middleware) {
                        $kernel->appendMiddlewareToGroup('web', $middleware);
                    }
                });
            }

            return $application;
        });
    }

    public function registeringPackage(): void
    {
        Route::middleware(['web'])->group(function (): void {
            Route::prefix('forms')->group(function (): void {
                Route::post('/submit', [FormsSubmitController::class, 'handleSubmit'])
                    ->name('forms.validate');
            });

            Route::get('/forms-thank-you', function () {
                return view('forms::components.thank-you');
            })->name('forms.thank-you');
        });
    }
}
