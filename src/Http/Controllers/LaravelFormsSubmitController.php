<?php

namespace Fuelviews\LaravelForms\Http\Controllers;

use Fuelviews\LaravelForms\Contracts\LaravelFormsHandlerService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Carbon;
use Spatie\GoogleTagManager\GoogleTagManager;

class LaravelFormsSubmitController extends Controller
{
    protected LaravelFormsHandlerService $formHandler;

    public function __construct(LaravelFormsHandlerService $formHandler)
    {
        $this->formHandler = $formHandler;
    }

    protected function validateStepData(Request $request, $step)
    {
        switch ($step) {
            case 1:
                return $request->validate([
                    'location' => 'required|in:inside,outside,cabinets',
                    'isSpam' => 'nullable|string',
                ]);
            case 2:
                return $request->validate([
                    'firstName' => 'required|min:2|max:24',
                    'lastName' => 'sometimes|min:2|max:24',
                    'email' => 'sometimes|email',
                    'phone' => 'sometimes|min:7|max:19',
                    'message' => 'sometimes|max:255',
                    'zipCode' => 'sometimes|min:4|max:9',
                    'gotcha' => 'nullable|string',
                    'isSpam' => 'nullable|string',
                    'gclid' => 'nullable|string',
                    'utmSource' => 'nullable|string',
                    'utmMedium' => 'nullable|string',
                    'utmCampaign' => 'nullable|string',
                    'utmTerm' => 'nullable|string',
                    'utmContent' => 'nullable|string',
                ]);
        }
    }

    public function showForm(Request $request)
    {
        $openModal = $request->session()->pull('modal_open', true);
        $step = $request->session()->get('form_step', 1);

        return view('laravel-forms::components.modals.modal', compact('step', 'openModal'));
    }

    public function handleStep(Request $request)
    {
        \Log::info(['Received location: ', $request->input('location')]);

        $request->session()->put('modal_open', true);
        $step = $request->session()->get('form_step', 1);
        $allData = $request->session()->get('form_data', []);

        $validatedData = $this->validateStepData($request, $step);
        $allData[$step] = $validatedData;

        // Store location in session if it's part of the current step's data
        if (isset($validatedData['location'])) {
            $request->session()->put('location', $validatedData['location']);
        }

        $request->session()->put('form_data', $allData);

        if ($this->isLastStep($step)) {
            $request->session()->forget(['form_data', 'form_step', 'modal_open']);
            return redirect()->route('thank-you')->with('status', 'success');
        } else {
            $request->session()->put('form_step', $step + 1);
            return redirect()->route('form.show');
        }
    }


    public function backStep(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->session()->put('modal_open', true);
        $step = $request->session()->get('form_step', 1);
        if ($step > 1) {
            $request->session()->put('form_step', $step - 1);
        }

        return redirect()->route('form.show');
    }

    protected function isLastStep($step)
    {
        return $step >= 2;
    }

    public function handle(Request $request): \Illuminate\Http\RedirectResponse
    {
        \Log::info("Location set in session", ['location' => $request->session()->get('location')]);
        $request->session()->put('modal_open', true);

        if ($this->isRateLimited($request)) {
            return back()->with('error', 'Please wait before submitting again.');
        }

        if ($this->isSpamRequest($request)) {
            return $this->redirectSpam();
        }

        $validatedData = $request->validate([
            'firstName' => 'required|min:2|max:24',
            'lastName' => 'sometimes|min:2|max:24',
            'email' => 'sometimes|email',
            'phone' => 'sometimes|min:7|max:19',
            'zipCode' => 'sometimes|min:4|max:9',
            'message' => 'sometimes|max:255',
            'location' => 'nullable|string',
            'gotcha' => 'nullable|string',
            'isSpam' => 'nullable|string',
            'gclid' => 'nullable|string',
            'utmSource' => 'nullable|string',
            'utmMedium' => 'nullable|string',
            'utmCampaign' => 'nullable|string',
            'utmTerm' => 'nullable|string',
            'utmContent' => 'nullable|string',
        ]);
        $validatedData['ip'] = $request->ip();
        $validatedData['location'] = $request->session()->get('location');

        $gclid = $request->input('gclid') ?? $request->cookie('gclid');
        $gtmEventGclid = config("forms.{$request->input('form_key')}.gtm_event_gclid");

        $gtmEventName = $gclid && $gtmEventGclid ? $gtmEventGclid : config("forms.{$request->input('form_key')}.gtm_event");

        $data = [
            'url' => $this->getApiUrl($request->input('form_key')),
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

    private function getApiUrl($formKey)
    {
        $environment = app()->isProduction() && ! config('app.debug') ? 'production_url' : 'development_url';

        return config("forms.{$formKey}.{$environment}", false);
    }

    protected function isSpamRequest(Request $request): bool
    {
        return ! is_null($request->input('gotcha')) ||
            ! is_null($request->input('isSpam')) ||
            $request->has('submitClicked');
    }

    protected function redirectSpam(): \Illuminate\Http\RedirectResponse
    {
        $redirects = config('forms.spam_redirects', []);
        $randomRedirect = array_rand($redirects);

        return redirect()->to($redirects[$randomRedirect]);
    }

    private function isRateLimited(Request $request): bool
    {
        if (! app()->isProduction() || config('app.debug')) {
            return false;
        }

        $lastSubmit = session('last_form_submit');
        if (! $lastSubmit) {
            return false;
        }

        return now()->diffInMinutes(Carbon::parse($lastSubmit)) < 60;
    }
}
