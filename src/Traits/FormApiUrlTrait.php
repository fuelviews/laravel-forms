<?php

namespace Fuelviews\LaravelForms\Traits;

use Illuminate\Support\Facades\App;

trait FormApiUrlTrait
{
    /**
     * Retrieve the API URL based on the application environment and form key.
     *
     * @param string $formKey
     * @return string|false
     */
    private function getFormApiUrl($formKey)
    {
        $environment = App::environment('production') && ! config('app.debug') ? 'production_url' : 'development_url';
        return config("forms.{$formKey}.{$environment}", false);
    }
}
