<?php

namespace Fuelviews\LaravelForm\Services;

class FormValidationRuleService
{
    /**
     * Returns a combined array of default rules and configuration-based additional rules.
     *
     * @return array The merged rules
     */
    public static function getRulesForDefault(): array
    {
        $defaultRules = [
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
            'submitClicked' => 'nullable',
        ];

        $additionalRules = config("forms.validation.steps.{$step}", []);

        return array_merge($defaultRules, $additionalRules);
    }
}
