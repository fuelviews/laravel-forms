<?php

namespace Fuelviews\LaravelForm\Services;

use Fuelviews\LaravelForm\Contracts\FormHandlerService;
use Fuelviews\LaravelForm\Traits\FormApiUrlTrait;
use Fuelviews\LaravelForm\Traits\FormRedirectSpamTrait;
use Fuelviews\LaravelForm\Traits\FormSpamDetectionTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Spatie\GoogleTagManager\GoogleTagManager;

class FormProcessingService
{
    use FormApiUrlTrait, FormRedirectSpamTrait, FormSpamDetectionTrait;

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

    public function formSubmitLimitExceeded(Request $request): bool
    {
        if (App::environment('production') || ! config('app.debug')) {
            $lastSubmit = session('last_form_submit');

            return $lastSubmit && now()->diffInMinutes(Carbon::parse($lastSubmit)) < 60;
        }

        return false;
    }

    /**
     * Handle the response when form submission limit is exceeded.
     */
    public function handleExceededLimitResponse(): \Illuminate\Http\RedirectResponse
    {
        return back()->withInput()->withErrors(['form.submit.limit' => 'Form submit limit exceeded']);
    }
}
