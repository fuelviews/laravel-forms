<?php

namespace Fuelviews\Forms\Http\Controllers;

use Fuelviews\Forms\Contracts\FormsHandlerService;
use Fuelviews\Forms\Services\FormsProcessingService;
use Fuelviews\Forms\Services\FormsValidationRuleService;
use Fuelviews\Forms\Traits\FormsApiUrlTrait;
use Fuelviews\Forms\Traits\FormsRedirectSpamTrait;
use Fuelviews\Forms\Traits\FormsSpamDetectionTrait;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class FormsSubmitController extends Controller
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

    public function handleSubmit(Request $request)
    {
        // Validate Turnstile if it's enabled
        if (config('forms.turnstile.enabled') && config('forms.turnstile.site_key')) {
            $request->validate([
                'cf-turnstile-response' => ['required', 'turnstile'],
            ], [
                'cf-turnstile-response.required' => 'Please complete the security challenge.',
                'cf-turnstile-response.turnstile' => 'Security challenge validation failed. Please try again.',
            ]);
        }

        $formKey = request()->input('form_key', 'default');
        $rules = FormsValidationRuleService::getRulesForDefault($formKey);
        $result = $this->formProcessingService->processForm($request, $request->validate($rules));

        if ($result instanceof \Illuminate\Http\RedirectResponse) {
            return $result;
        }

        if (is_array($result) && $result['status'] === 'failure') {
            session()->flash('status', 'failure');
            session()->flash('message', $result['message'] ?? 'There was an issue submitting the form.');

            return back()->withInput();
        }

        if ($result['status'] === 'success') {
            session()->flash('status', 'success');
            session()->flash('message', 'Form submitted successfully!');
            \Illuminate\Support\Facades\Log::info('Flashed session data:', [
                'status' => session('status'),
                'message' => session('message'),
            ]);

            return redirect()->route('forms.thank-you');
        }
    }
}
