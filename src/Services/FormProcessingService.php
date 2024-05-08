<?php

namespace Fuelviews\LaravelForm\Services;

use Fuelviews\LaravelForm\Contracts\FormHandlerService;
use Fuelviews\LaravelForm\Traits\FormApiUrlTrait;
use Fuelviews\LaravelForm\Traits\FormRedirectSpamTrait;
use Fuelviews\LaravelForm\Traits\FormSpamDetectionTrait;
use Fuelviews\LaravelForm\Traits\FormSubmitLimitTrait;
use Illuminate\Http\Request;
use Spatie\GoogleTagManager\GoogleTagManager;

class FormProcessingService
{
    use FormApiUrlTrait, FormRedirectSpamTrait, FormSpamDetectionTrait, FormSubmitLimitTrait;

    protected FormHandlerService $formHandler;

    protected FormValidationRuleService $validationRuleService;

    public function __construct(FormHandlerService $formHandler, FormValidationRuleService $validationRuleService)
    {
        $this->formHandler = $formHandler;
        $this->validationRuleService = $validationRuleService;
    }

    public function processForm(Request $request, array $validatedData)
    {
        if ($this->formSubmitLimitExceeded($request)) {
            return $this->handleExceededLimitResponse();
        }

        if ($this->isFormSpamRequest($request)) {
            return $this->formRedirectSpam();
        }

        $formKey = $request->input('form_key');

        $validatedData['ip'] = $request->ip();
        $validatedData['location'] = $request->session()->get('location', '');

        $gclid = $request->input('gclid') ?? $request->cookie('gclid');

        $gtmEventGclid = config("forms.{$formKey}.gtm_event_gclid");
        $gtmEventName = $gclid && $gtmEventGclid ? $gtmEventGclid : config("forms.{$formKey}.gtm_event");

        $result = $this->formHandler->handle([
            'url' => $this->getFormApiUrl($formKey),
            'validatedData' => $validatedData,
            'gtmEventName' => $gtmEventName,
        ]);

        if ($result['status'] === 'success') {
            app(GoogleTagManager::class)->flash('event', $gtmEventName, [
                'event_label' => $gtmEventName,
            ]);
        }

        return $result;
    }
}
