<?php

namespace Fuelviews\LaravelForms\Services;

class LaravelFormsValidationRuleService
{
    /**
     * Returns a combined array of default rules and configuration-based additional rules.
     *
     * @return array The merged rules
     */
    public static function getRulesForDefault(): array
    {
        $defaultRules = [
            'firstName' => 'required|min:2|max:24',
            'lastName' => 'required|min:2|max:24',
            'email' => 'required|email',
            'phone' => 'required|min:7|max:19',
            'message' => 'nullable|max:255',
            'location' => 'nullable|string',
            'gotcha' => 'nullable|string',
            'isSpam' => 'nullable|string',
            'gclid' => 'nullable|string',
            'utmSource' => 'nullable|string',
            'utmMedium' => 'nullable|string',
            'utmCampaign' => 'nullable|string',
            'utmTerm' => 'nullable|string',
            'utmContent' => 'nullable|string',
        ];

        $additionalRules = config('forms.validation.default', []);

        return array_merge($defaultRules, $additionalRules);
    }

    /**
     * Returns a combined array of default rules and configuration-based additional rules.
     *
     * @return array The merged rules
     */
    public function getRulesForStep($step): array
    {
        $defaultRules = [
            'isSpam' => 'nullable|string',
            'gotcha' => 'nullable|string',
        ];

        $additionalRules = config("forms.validation.steps.{$step}", []);

        return array_merge($additionalRules, $defaultRules);
    }
}
