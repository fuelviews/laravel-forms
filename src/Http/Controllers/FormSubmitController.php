<?php

namespace Fuelviews\LaravelForm\Http\Controllers;

use Fuelviews\LaravelForm\Contracts\FormHandlerService;
use Fuelviews\LaravelForm\Services\FormValidationRuleService;
use Fuelviews\LaravelForm\Traits\FormApiUrlTrait;
use Fuelviews\LaravelForm\Traits\FormRedirectSpamTrait;
use Fuelviews\LaravelForm\Traits\FormSpamDetectionTrait;
use Fuelviews\LaravelForm\Traits\FormSubmitLimitTrait;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Spatie\GoogleTagManager\GoogleTagManager;

class FormSubmitController extends Controller
{
    use FormApiUrlTrait, FormRedirectSpamTrait, FormSpamDetectionTrait, FormSubmitLimitTrait;

    protected FormHandlerService $formHandler;

    protected FormValidationRuleService $validationRuleService;

    public function __construct(
        FormHandlerService $formHandler,
        FormValidationRuleService $validationRuleService
    ) {
        $this->formHandler = $formHandler;
        $this->validationRuleService = $validationRuleService;
    }

    public function handleSubmit(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->session()->put('modal_open', true);

        if ($this->formSubmitLimitExceeded($request)) {
            return $this->handleExceededLimitResponse();
        }

        if ($this->isFormSpamRequest($request)) {
            return $this->formRedirectSpam();
        }

        $validatedData = $request->validate($this->validationRuleService::getRulesForDefault());
        $validatedData['ip'] = $request->ip();
        $validatedData['location'] = $request->session()->get('location');

        $gclid = $request->input('gclid') ?? $request->cookie('gclid');
        $gtmEventGclid = config("forms.{$request->input('form_key')}.gtm_event_gclid");

        $gtmEventName = $gclid && $gtmEventGclid ? $gtmEventGclid : config("forms.{$request->input('form_key')}.gtm_event");

        $data = [
            'url' => $this->getFormApiUrl($request->input('form_key')),
            'validatedData' => $validatedData,
            'gtmEventName' => $gtmEventName,
        ];

        $result = $this->formHandler->handle($data);

        if ($result['status'] === 'success') {
            app(GoogleTagManager::class)->flash('event', $data['gtmEventName'], [
                'event_label' => $data['gtmEventName'],
            ]);

            $request->session()->forget('modal_open');

            return redirect()->route('thank-you')->with('status', 'success');
        }

        return back()->withInput();
    }
}
