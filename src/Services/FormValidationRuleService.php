<?php

namespace Fuelviews\LaravelForm\Services;

use Fuelviews\LaravelForm\Form;

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
            'isSpam' => 'nullable|string',
            'gotcha' => 'nullable|string',
            'submitClicked' => 'nullable',
            'gclid' => 'nullable|string',
            'utmSource' => 'nullable|string',
            'utmMedium' => 'nullable|string',
            'utmCampaign' => 'nullable|string',
            'utmTerm' => 'nullable|string',
            'utmContent' => 'nullable|string',
        ];

        $additionalRules = Form::getAdditionalRulesForDefault();

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

        $additionalRules = Form::getAdditionalRulesForStep($step);

        return array_merge($defaultRules, $additionalRules);
    }
}
