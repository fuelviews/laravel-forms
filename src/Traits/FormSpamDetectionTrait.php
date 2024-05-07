<?php

namespace Fuelviews\LaravelForms\Traits;

use Illuminate\Http\Request;

trait FormSpamDetectionTrait
{
    /**
     * Check if the request is potentially spam.
     */
    protected function isFormSpamRequest(Request $request): bool
    {
        return ! is_null($request->input('gotcha')) ||
            ! is_null($request->input('isSpam')) ||
            $request->has('submitClicked');
    }
}
