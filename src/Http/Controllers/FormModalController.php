<?php

namespace Fuelviews\LaravelForm\Http\Controllers;

use Fuelviews\LaravelForm\Contracts\FormHandlerService;
use Fuelviews\LaravelForm\Services\FormProcessingService;
use Fuelviews\LaravelForm\Services\FormValidationRuleService;
use Fuelviews\LaravelForm\Traits\FormApiUrlTrait;
use Fuelviews\LaravelForm\Traits\FormModalStepValidationTrait;
use Fuelviews\LaravelForm\Traits\FormRedirectSpamTrait;
use Fuelviews\LaravelForm\Traits\FormSpamDetectionTrait;
use Fuelviews\LaravelForm\Traits\FormSubmitLimitTrait;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class FormModalController extends Controller
{
    use FormApiUrlTrait, FormModalStepValidationTrait, FormRedirectSpamTrait, FormSpamDetectionTrait, FormSubmitLimitTrait;

    protected FormProcessingService $formService;

    protected FormHandlerService $formHandler;

    protected FormValidationRuleService $validationRuleService;

    public function __construct(
        FormHandlerService $formHandler,
        FormValidationRuleService $validationRuleService,
        FormProcessingService $formService
    ) {
        $this->formHandler = $formHandler;
        $this->validationRuleService = $validationRuleService;
        $this->formService = $formService;
    }

    public function showModalForm(Request $request): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $openModal = $request->session()->pull('modal_open', true);
        $step = $request->session()->get('form_step', 1);
        $formData = $request->session()->get('form_data', []);
        $oldData = $formData[$step] ?? [];

        return view('laravel-form::components.modal.modal', compact('step', 'openModal', 'oldData'));
    }

    public function handleModalStep(Request $request): ?\Illuminate\Http\RedirectResponse
    {
        $request->session()->put('modal_open', true);
        $step = $request->session()->get('form_step', 1);
        $allData = $request->session()->get('form_data', []);

        $validatedData = $this->validateStepData($request, $step);
        $allData[$step] = $validatedData;

        $validatedData['ip'] = $request->ip();

        $location = $request->session()->get('location', $request->input('location'));
        $validatedData['location'] = $location;

        if (isset($validatedData['location'])) {
            $request->session()->put('location', $validatedData['location']);
        }

        $request->session()->put('form_data', $allData);

        $request->session()->put('form_step', $step + 1);

        if ($this->isLastStep($step)) {

            $rules = $this->validationRuleService->getRulesForStep($step);

            $validatedData = $request->validate($rules);

            $result = $this->formService->processForm($request, $validatedData);

            if ($result instanceof \Illuminate\Http\RedirectResponse) {
                return $result;
            }

            if (is_array($result) && $result['status'] === 'failure') {
                return back()->withInput()->withErrors(['error' => $result['message']]);
            }

            if ($result['status'] === 'success') {
                return redirect()->route('thank-you')->with('status', 'success');
            }
        }

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
