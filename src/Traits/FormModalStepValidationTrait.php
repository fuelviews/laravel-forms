<?php

namespace Fuelviews\LaravelForms\Traits;

use Illuminate\Http\Request;

trait FormModalStepValidationTrait
{
    /**
     * Validate the data for a specific step of a form.
     *
     * @param  int  $step  The current step number
     * @return array Validated data
     */
    public function validateStepData(Request $request, int $step): array
    {
        $rules = $this->validationRuleService->getRulesForStep($step);

        return $request->validate($rules);
    }
}
