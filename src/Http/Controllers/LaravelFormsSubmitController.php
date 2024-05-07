<?php

namespace Fuelviews\LaravelForms\Http\Controllers;

use AllowDynamicProperties;
use Fuelviews\LaravelForms\Contracts\LaravelFormsHandlerService;
use Fuelviews\LaravelForms\Services\LaravelFormsValidationRuleService;
use Fuelviews\LaravelForms\Traits\FormRedirectTrait;
use Fuelviews\LaravelForms\Traits\FormSpamDetectionTrait;
use Fuelviews\LaravelForms\Traits\FormModalStepValidationTrait;
use Fuelviews\LaravelForms\Traits\FormSubmitLimitTrait;
use Fuelviews\LaravelForms\Traits\FormApiUrlTrait;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\App;
use Spatie\GoogleTagManager\GoogleTagManager;

#[AllowDynamicProperties] class LaravelFormsSubmitController extends Controller
{
    use FormRedirectTrait, FormSpamDetectionTrait, FormModalStepValidationTrait, FormSubmitLimitTrait, FormApiUrlTrait;

    protected LaravelFormsHandlerService $formHandler;

    protected LaravelFormsValidationRuleService $validationRuleService;

    public function __construct(LaravelFormsHandlerService $formHandler, LaravelFormsValidationRuleService $validationRuleService)
    {
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

        $validatedData = $request->validate(LaravelFormsValidationRuleService::getRulesForDefault());
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

    public function showModalForm(Request $request)
    {
        $openModal = $request->session()->pull('modal_open', true);
        $step = $request->session()->get('form_step', 1);
        $formData = $request->session()->get('form_data', []);
        $oldData = $formData[$step] ?? [];

        return view('laravel-forms::components.modal.modal', compact('step', 'openModal', 'oldData'));
    }

    public function handleModalStep(Request $request): ?\Illuminate\Http\RedirectResponse
    {
        $request->session()->put('modal_open', true);
        $step = $request->session()->get('form_step', 1);
        $allData = $request->session()->get('form_data', []);

        $validatedData = $this->validateStepData($request, $step);
        $allData[$step] = $validatedData;

        if (isset($validatedData['location'])) {
            $request->session()->put('location', $validatedData['location']);
        }

        $request->session()->put('form_data', $allData);

        if ($this->isLastStep($step)) {
            $request->session()->forget(['form_data', 'form_step', 'modal_open']);

            return redirect()->route('thank-you')->with('status', 'success');
        }

        $request->session()->put('form_step', $step + 1);

        return redirect()->route('form.show');
    }

    public function backModalStep(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->session()->put('modal_open', true);
        $step = $request->session()->get('form_step', 1);
        if ($step > 1) {
            $request->session()->put('form_step', $step - 1);
        }

        $formData = $request->session()->get('form_data', []);

        return redirect()->route('form.show')->withInput($formData[$step - 1] ?? []);
    }

    protected function isLastStep($step): bool
    {
        return $step >= 2;
    }
}
