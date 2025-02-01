<?php

namespace Fuelviews\Forms\Services;

use AllowDynamicProperties;
use Fuelviews\Forms\Contracts\FormsHandlerService;
use Fuelviews\Forms\Forms;
use Fuelviews\Forms\Traits\FormsApiUrlTrait;
use Fuelviews\Forms\Traits\FormsRedirectSpamTrait;
use Fuelviews\Forms\Traits\FormsSpamDetectionTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Spatie\GoogleTagManager\GoogleTagManager;

#[AllowDynamicProperties] class FormsProcessingService
{
    use FormsApiUrlTrait;
    use FormsRedirectSpamTrait;
    use FormsSpamDetectionTrait;

    protected FormsHandlerService $formHandlerService;

    protected FormsValidationRuleService $validationRuleService;

    public function __construct(FormsHandlerService $formHandlerService, FormsValidationRuleService $validationRuleService)
    {
        $this->formHandlerService = $formHandlerService;
        $this->validationRuleService = $validationRuleService;
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

        $validatedData['ip'] = $request->ip();

        $gclid = $request->input('gclid') ?? $request->cookie('gclid') ?? $request->session()->get('gclid');

        $gtmEventGclid = config("forms.forms.{$formKey}.gtm_event_gclid");
        $gtmEventName = $gclid && $gtmEventGclid ? $gtmEventGclid : config("forms.forms.{$formKey}.gtm_event");

        $result = $this->formHandlerService->handle([
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

    public function formSubmitLimitExceeded(Request $request): bool
    {
        if (App::environment('production') && ! config('app.debug')) {
            $lastSubmit = session('last_form_submit');

            return $lastSubmit && now()->diffInMinutes(Carbon::parse($lastSubmit)) < 60;
        }

        return false;
    }

    /**
     * Handle the response when form submission limit is exceeded.
     */
    public function handleExceededLimitResponse()
    {
        return back()->withInput()->withErrors(['form.submit.limit' => 'Form submit limit exceeded']);
    }
}
