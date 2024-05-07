<?php

namespace Fuelviews\LaravelForm\Traits;

use Illuminate\Support\Facades\App;

trait FormApiUrlTrait
{
    /**
     * Retrieve the API URL based on the application environment and form key.
     */
    private function getFormApiUrl(string $formKey): false|string
    {
        $environment = App::environment('production') && ! config('app.debug') ? 'production_url' : 'development_url';

        return config("forms.{$formKey}.{$environment}", false);
    }
}
