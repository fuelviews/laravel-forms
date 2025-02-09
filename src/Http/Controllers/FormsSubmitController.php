<?php

namespace Fuelviews\Forms\Http\Controllers;

use AllowDynamicProperties;
use Fuelviews\Forms\Contracts\FormsHandlerService;
use Fuelviews\Forms\Services\FormsProcessingService;
use Fuelviews\Forms\Services\FormsValidationRuleService;
use Fuelviews\Forms\Traits\FormsApiUrlTrait;
use Fuelviews\Forms\Traits\FormsRedirectSpamTrait;
use Fuelviews\Forms\Traits\FormsSpamDetectionTrait;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

#[AllowDynamicProperties] class FormsSubmitController extends Controller
{
    use FormsApiUrlTrait;
    use FormsRedirectSpamTrait;
    use FormsSpamDetectionTrait;

    protected FormsProcessingService $formProcessingService;

    protected FormsHandlerService $formHandlerService;

    protected FormsValidationRuleService $validationRuleService;

    public function __construct(
        FormsHandlerService $formHandlerService,
        FormsValidationRuleService $validationRuleService,
        FormsProcessingService $formProcessingService
    ) {
        $this->formHandlerService = $formHandlerService;
        $this->validationRuleService = $validationRuleService;
        $this->formProcessingService = $formProcessingService;
    }

    public function handleSubmit(Request $request): \Illuminate\Http\RedirectResponse
    {
        $formKey = request()->input('form_key', 'default');
        $rules = FormsValidationRuleService::getRulesForDefault($formKey);
        $result = $this->formProcessingService->processForm($request, $request->validate($rules));

        if ($result instanceof \Illuminate\Http\RedirectResponse) {
            return $result;
        }

        if (is_array($result) && $result['status'] === 'failure') {
            return back()->withInput()->withErrors(['error' => $result['message']]);
        }

        if ($result['status'] === 'success') {
            return redirect()->route('forms.thank-you')->with('status', 'success');
        }

        return back()->withInput();
    }
}
