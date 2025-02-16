<?php

namespace Fuelviews\Forms;

class Forms
{
    /**
     * Get the form key for the modal.
     */
    public static function getModalFormKey(): string
    {
        return config('forms.modal.form_key');
    }

    public static function getModalTitle(): ?string
    {
        return config('forms.modal.title');
    }

    public static function getModalStepTitle($step)
    {
        return config("forms.modal.steps.{$step}.heading");
    }

    /**
     * Check if the modal terms of service are enabled.
     */
    public static function isModalTosEnabled(): bool
    {
        return config('forms.modal.tos.enabled', false);
    }

    /**
     * Get the content of the modal terms of service.
     */
    public static function getModalTosContent(): ?string
    {
        return config('forms.modal.tos.content');
    }

    /**
     * Check if the modal optional div is enabled.
     */
    public static function isModalOptionalDivEnabled(): bool
    {
        return config('forms.modal.optional_div.enabled', false);
    }

    /**
     * Get the title of the modal optional div.
     */
    public static function getModalOptionalDivTitle(): ?string
    {
        return config('forms.modal.optional_div.title');
    }

    /**
     * Get the link text of the modal optional div.
     */
    public static function getModalOptionalDivLinkText(): ?string
    {
        return config('forms.modal.optional_div.link_text');
    }

    /**
     * Get the link route of the modal optional div.
     */
    public static function getModalOptionalDivLinkRoute(): ?string
    {
        return config('forms.modal.optional_div.link_route');
    }

    public static function getAdditionalRulesForForm($formKey): ?array
    {
        $rules = config("forms.validation.{$formKey}");

        if (is_null($rules)) {
            $rules = config('forms.validation.default', []);
        }

        return $rules;
    }

    public static function getAdditionalRulesForDefault($formKey): ?array
    {
        return config('forms.validation.default', []);
    }

    public static function getAdditionalRulesForStep($step): ?array
    {
        return config("forms.validation.steps.{$step}", []);
    }

    public static function getLastStep(): ?int
    {
        $steps = config('forms.validation.steps');
        if (! $steps) {
            return null;
        }

        return max(array_keys($steps));
    }

    public static function getLayout(): ?string
    {
        return config('forms.layout');
    }

    /**
     * Get spam redirects configuration.
     */
    public static function getSpamRedirects(): array
    {
        return config('forms.spam_redirects', []);
    }
}
