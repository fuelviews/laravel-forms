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
    public static function getRulesForDefault($formKey): array
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

        $additionalRules = Form::getAdditionalRulesForForm($formKey);

        return array_merge($additionalRules, $defaultRules);
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
            'gclid' => 'nullable',
            'utmSource' => 'nullable|string',
            'utmMedium' => 'nullable|string',
            'utmCampaign' => 'nullable|string',
            'utmTerm' => 'nullable|string',
            'utmContent' => 'nullable|string',
        ];

        $additionalRules = Form::getAdditionalRulesForStep($step);

        return array_merge($additionalRules, $defaultRules);
    }
}
