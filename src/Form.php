<?php

namespace Fuelviews\LaravelForm;

class Form
{
    /**
     * Get the form key for the modal.
     */
    public static function getModalFormKey(): string
    {
        return config('forms.modal.form_key');
    }

    /**
     * Check if the modal terms of service are enabled.
     */
    public static function isModalTosEnabled(): bool
    {
        return config('forms.modal_tos.enabled', false);
    }

    /**
     * Get the content of the modal terms of service.
     */
    public static function getModalTosContent(): ?string
    {
        return config('forms.modal_tos.content');
    }

    /**
     * Check if the modal optional div is enabled.
     */
    public static function isModalOptionalDivEnabled(): bool
    {
        return config('forms.modal_optional_div.enabled', false);
    }

    /**
     * Get the title of the modal optional div.
     */
    public static function getModalOptionalDivTitle(): ?string
    {
        return config('forms.modal_optional_div.title');
    }

    /**
     * Get the link text of the modal optional div.
     */
    public static function getModalOptionalDivLinkText(): ?string
    {
        return config('forms.modal_optional_div.link_text');
    }

    /**
     * Get the link route of the modal optional div.
     */
    public static function getModalOptionalDivLinkRoute(): ?string
    {
        return config('forms.modal_optional_div.link_route');
    }
}
