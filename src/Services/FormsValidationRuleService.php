<?php

namespace Fuelviews\Forms\Services;

use Fuelviews\Forms\Forms;

class FormsValidationRuleService
{
    /**
     * Returns a combined array of default rules and configuration-based additional rules.
     *
     * @return array The merged rules
     */
    public static function getRulesForDefault(string $formKey): array
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

        $additionalRules = Forms::getAdditionalRulesForForm($formKey);

        return array_merge($additionalRules, $defaultRules);
    }

    /**
     * Returns a combined array of default rules and configuration-based additional rules.
     *
     * @return array The merged rules
     */
    public function getRulesForStep(string $step): array
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

        $additionalRules = Forms::getAdditionalRulesForStep($step);

        return array_merge($additionalRules, $defaultRules);
    }
}
