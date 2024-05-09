<?php

namespace Fuelviews\LaravelForm\Traits;

use Fuelviews\LaravelForm\Form;

trait FormRedirectSpamTrait
{
    /**
     * Redirect to a randomly chosen URL specified in configuration to handle potential spam.
     */
    protected function formRedirectSpam(): \Illuminate\Http\RedirectResponse
    {
        $redirects = Form::getSpamRedirects();
        $randomRedirect = array_rand($redirects);

        return redirect()->to($redirects[$randomRedirect]);
    }
}
