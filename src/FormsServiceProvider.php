<?php

namespace Fuelviews\Forms;

use Fuelviews\Forms\Commands\FormsInstallCommand;
use Fuelviews\Forms\Contracts\FormsHandlerService;
use Fuelviews\Forms\Http\Controllers\FormsSubmitController;
use Fuelviews\Forms\Livewire\FormsModal;
use Fuelviews\Forms\Middleware\HandleFbclid;
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

        $this->app->singleton(FormsValidationRuleService::class, function ($app) {
            return new FormsValidationRuleService();
        });
    }

    public function packageBooted(): void
    {
        if (class_exists(Livewire::class)) {
            Livewire::component('forms-modal', FormsModal::class);
        }

        // Merge Turnstile configuration to services.turnstile for compatibility with ryangjchandler/laravel-cloudflare-turnstile
        $this->mergeTurnstileConfig();

        $this->app->extend(Application::class, function (Application $app) {
            if (method_exists($app, 'configureMiddleware')) {
                $app->configureMiddleware(function (Middleware $middleware) {
                    $middleware->appendToGroup('web', [
                        HandleGclid::class,
                        HandleFbclid::class,
                        HandleUtm::class,
                    ]);
                });
            } else {
                $this->app->booting(function () {
                    $kernel = $this->app->make(Kernel::class);

                    foreach ([
                        HandleGclid::class,
                        HandleFbclid::class,
                        HandleUtm::class,
                    ] as $middleware) {
                        $kernel->appendMiddlewareToGroup('web', $middleware);
                    }
                });
            }

            return $app;
        });
    }

    public function registeringPackage(): void
    {
        Route::middleware(['web'])->group(function () {
            Route::prefix('forms')->group(function () {
                Route::post('/submit', [FormsSubmitController::class, 'handleSubmit'])
                    ->name('forms.validate');
            });

            Route::get('/forms-thank-you', function () {
                return view('forms::components.thank-you');
            })->name('forms.thank-you');
        });
    }

    private function providerIsLoaded($app, $providerClass): bool
    {
        return collect($app->getLoadedProviders())->has($providerClass);
    }

    private function mergeTurnstileConfig(): void
    {
        // Merge Turnstile configuration from forms.turnstile to services.turnstile
        // This ensures compatibility with the ryangjchandler/laravel-cloudflare-turnstile package

        // Use the TURNSTILE_SITE_KEY and TURNSTILE_SECRET_KEY env vars directly
        // with fallback to the test keys if not set
        $siteKey = env('TURNSTILE_SITE_KEY', '1x00000000000000000000AA');
        $secretKey = env('TURNSTILE_SECRET_KEY',  '1x0000000000000000000000000000000AA');

        // Set the services.turnstile config that the Turnstile package expects
        config([
            'services.turnstile.key' => $siteKey,
            'services.turnstile.secret' => $secretKey,
        ]);
    }
}
