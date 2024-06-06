<?php

namespace Fuelviews\Forms\Traits;

use Illuminate\Http\Request;

trait FormsSpamDetectionTrait
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
