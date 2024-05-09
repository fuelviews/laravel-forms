<?php

namespace Fuelviews\LaravelForm\Traits;

use Illuminate\Support\Facades\App;

trait FormApiUrlTrait
{
    /**
     * Retrieve the API URL based on the application environment and form key.
     *
     * @param  string  $formKey  The key identifying the specific form.
     * @return string|null The API URL or null if not configured.
     */
    protected function getFormApiUrl(string $formKey): ?string
    {
        $environment = $this->determineEnvironment();

        return config("forms.forms.{$formKey}.{$environment}", null);
    }

    /**
     * Determine which environment configuration to use based on application settings.
     *
     * @return string The environment key ('production_url' or 'development_url').
     */
    protected function determineEnvironment(): string
    {
        return App::environment('production') && ! config('app.debug') ? 'production_url' : 'development_url';
    }
}
