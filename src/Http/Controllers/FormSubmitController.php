<?php

namespace Fuelviews\LaravelForm\Http\Controllers;

use AllowDynamicProperties;
use Fuelviews\LaravelForm\Contracts\FormHandlerService;
use Fuelviews\LaravelForm\Services\FormProcessingService;
use Fuelviews\LaravelForm\Services\FormValidationRuleService;
use Fuelviews\LaravelForm\Traits\FormApiUrlTrait;
use Fuelviews\LaravelForm\Traits\FormRedirectSpamTrait;
use Fuelviews\LaravelForm\Traits\FormSpamDetectionTrait;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

#[AllowDynamicProperties] class FormSubmitController extends Controller
{
    use FormApiUrlTrait, FormRedirectSpamTrait, FormSpamDetectionTrait;

    protected FormProcessingService $formService;

    protected FormHandlerService $formHandler;

    protected FormValidationRuleService $validationRuleService;

    public function __construct(
        FormHandlerService $formHandler,
        FormValidationRuleService $validationRuleService,
        FormProcessingService $formProcessingService
    ) {
        $this->formHandler = $formHandler;
        $this->validationRuleService = $validationRuleService;
        $this->formProcessingService = $formProcessingService;
    }

    public function handleSubmit(Request $request): \Illuminate\Http\RedirectResponse
    {
        $formKey = request()->input('form_key', 'default');
        $rules = FormValidationRuleService::getRulesForDefault($formKey);
        $result = $this->formProcessingService->processForm($request, $request->validate($rules));

        if ($result instanceof \Illuminate\Http\RedirectResponse) {
            return $result;
        }

        if (is_array($result) && $result['status'] === 'failure') {
            return back()->withInput()->withErrors(['error' => $result['message']]);
        }

        if ($result['status'] === 'success') {
            return redirect()->route('thank-you')->with('status', 'success');
        }

        return back()->withInput();
    }
}
