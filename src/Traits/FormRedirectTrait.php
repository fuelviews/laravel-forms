<?php

namespace Fuelviews\LaravelForm\Traits;

trait FormRedirectTrait
{
    /**
     * Redirect to a randomly chosen URL specified in configuration to handle potential spam.
     */
    protected function formRedirectSpam(): \Illuminate\Http\RedirectResponse
    {
        $redirects = config('forms.spam_redirects', []);
        $randomRedirect = array_rand($redirects);

        return redirect()->to($redirects[$randomRedirect]);
    }
}
