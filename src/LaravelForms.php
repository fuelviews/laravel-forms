<?php

namespace Fuelviews\LaravelForms;

class LaravelForms
{
    /**
     * Get the form key for the modal.
     *
     * @return string
     */
    public static function getModalFormKey()
    {
        return config('forms.modal.form_key');
    }

    /**
     * Check if the modal terms of service are enabled.
     *
     * @return bool
     */
    public static function isModalTosEnabled()
    {
        return config('forms.modal_tos.enabled', false);
    }

    /**
     * Get the content of the modal terms of service.
     *
     * @return string|null
     */
    public static function getModalTosContent()
    {
        return config('forms.modal_tos.content');
    }

    /**
     * Check if the modal optional div is enabled.
     *
     * @return bool
     */
    public static function isModalOptionalDivEnabled()
    {
        return config('forms.modal_optional_div.enabled', false);
    }

    /**
     * Get the title of the modal optional div.
     *
     * @return string|null
     */
    public static function getModalOptionalDivTitle()
    {
        return config('forms.modal_optional_div.title');
    }

    /**
     * Get the link text of the modal optional div.
     *
     * @return string|null
     */
    public static function getModalOptionalDivLinkText()
    {
        return config('forms.modal_optional_div.link_text');
    }

    /**
     * Get the link route of the modal optional div.
     *
     * @return string|null
     */
    public static function getModalOptionalDivLinkRoute()
    {
        return config('forms.modal_optional_div.link_route');
    }
}
