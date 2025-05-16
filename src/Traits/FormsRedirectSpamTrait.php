<?php

namespace Fuelviews\Forms\Traits;

use Fuelviews\Forms\Forms;
use Illuminate\Http\RedirectResponse;

trait FormsRedirectSpamTrait
{
    /**
     * Redirect to a randomly chosen URL specified in configuration to handle potential spam.
     */
    protected function formRedirectSpam(): RedirectResponse
    {
        $redirects = Forms::getSpamRedirects();
        $randomRedirect = array_rand($redirects);

        return redirect()->to($redirects[$randomRedirect]);
    }
}
