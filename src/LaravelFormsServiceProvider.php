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

        view()->composer('laravel-forms::*', function ($view) {
            $view->with([
                'modal_tos_enabled' => LaravelForms::isModalTosEnabled(),
                'modal_tos_content' => LaravelForms::getModalTosContent(),
                'modal_optional_div_enabled' => LaravelForms::isModalOptionalDivEnabled(),
                'modal_optional_div_title' => LaravelForms::getModalOptionalDivTitle(),
                'modal_optional_div_link_text' => LaravelForms::getModalOptionalDivLinkText(),
                'modal_optional_div_link_route' => LaravelForms::getModalOptionalDivLinkRoute(),
            ]);
        });

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
