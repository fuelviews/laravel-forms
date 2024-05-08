<?php

namespace Fuelviews\LaravelForm\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;

trait FormSubmitLimitTrait
{
    /**
     * Check if the form submission limit has been exceeded.
     */
    public function formSubmitLimitExceeded(Request $request): bool
    {
        if (App::environment('production') && ! config('app.debug')) {
            $lastSubmit = session('last_form_submit');

            return $lastSubmit && now()->diffInMinutes(Carbon::parse($lastSubmit)) < 60;
        }

        return false;
    }

    /**
     * Handle the response when form submission limit is exceeded.
     */
    public function handleExceededLimitResponse(): \Illuminate\Http\RedirectResponse
    {
        return back()->withInput()->withErrors(['form.submit.limit' => 'Form submit limit exceeded']);
    }
}
