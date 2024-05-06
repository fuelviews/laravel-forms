<?php

namespace Fuelviews\LaravelForms\Services;
class ValidationRuleService
{
    public static function defaultRules()
    {
        return config("forms.validation.default", []);
    }

    public function getRulesForStep($step)
    {
        return config("forms.validation.steps.{$step}", []);
    }
}
