<?php

namespace Fuelviews\Forms\Services;

use AllowDynamicProperties;
use Fuelviews\Forms\Contracts\FormsHandlerService;
use Fuelviews\Forms\Forms;
use Fuelviews\Forms\Traits\FormsApiUrlTrait;
use Fuelviews\Forms\Traits\FormsRedirectSpamTrait;
use Fuelviews\Forms\Traits\FormsSpamDetectionTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;

#[AllowDynamicProperties] class FormsProcessingService
{
    use FormsApiUrlTrait;
    use FormsRedirectSpamTrait;
    use FormsSpamDetectionTrait;

    protected FormsHandlerService $formHandlerService;

    protected FormsValidationRuleService $validationRuleService;

    public function __construct(FormsHandlerService $formsHandlerService, FormsValidationRuleService $formsValidationRuleService)
    {
        $this->formHandlerService = $formsHandlerService;
        $this->validationRuleService = $formsValidationRuleService;
    }

    public function processForm(Request $request, array $validatedData): array|\Illuminate\Http\RedirectResponse
    {
        if ($this->formSubmitLimitExceeded($request)) {
            return $this->handleExceededLimitResponse();
        }

        if ($this->isFormSpamRequest($request)) {
            return $this->formRedirectSpam();
        }

        $formKey = $request->input('form_key') ?? Forms::getModalFormKey();

        return $this->formHandlerService->handle([
            'url' => $this->getFormApiUrl($formKey),
            'validatedData' => $validatedData,
        ]);
    }

    public function formSubmitLimitExceeded(Request $request): bool
    {
        if (App::environment('production') && ! config('app.debug')) {
            $lastSubmit = session('last_form_submit');

            return $lastSubmit && now()->diffInMinutes(Carbon::parse($lastSubmit)) < 60;
        }

        return false;
    }

    /**
     * Handle the response when the form submission limit is exceeded.
     */
    public function handleExceededLimitResponse(): RedirectResponse
    {
        return back()->withInput()->withErrors(['form.submit.limit' => 'Form submit limit exceeded']);
    }
}
