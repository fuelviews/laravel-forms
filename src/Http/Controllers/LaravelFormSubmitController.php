<?php

namespace Fuelviews\LaravelForms\Http\Controllers;

use Illuminate\Http\Request;
use Fuelviews\LaravelForms\Contracts\LaravelFormsHandlerService;
use Illuminate\Routing\Controller;

class LaravelFormSubmitController extends Controller
{
    protected LaravelFormsHandlerService $formHandler;

    public function __construct(LaravelFormsHandlerService $formHandler)
    {
        $this->formHandler = $formHandler;
    }

    public function handle(Request $request)
    {
        // Check for UTM parameters and handle their absence
        $gclid = $request->input('gclid', 'gclid');  // Provide a default value or handle it differently

        \Log::info('Parameters', [
            'gclid' => $gclid,
        ]);

        /*if ($this->isSpamRequest($request)) {
            return redirect()->to('https://yelp.com');
        }*/

        $validatedData = $request->validate([
            'firstName' => 'required|min:2|max:24',
            'lastName' => 'sometimes|min:2|max:24',
            'email' => 'sometimes|email',
            'phone' => 'sometimes|min:7|max:19',
            'message' => 'sometimes|max:255',
            'location' => 'nullable|string',
            '_gotcha' => 'nullable|string',
            'is_spam' => 'nullable|string',
            'gclid' => 'nullable|string',
            'utm_source' => 'nullable|string',
            'utm_medium' => 'nullable|string',
            'utm_campaign' => 'nullable|string',
            'utm_term' => 'nullable|string',
            'utm_content' => 'nullable|string',
        ]);

        $validatedData['ip'] = $request->ip();

        $data = [
            'url' => $this->getApiUrl($request->input('form_key'), session('last_form_submission')),
            'validatedData' => $validatedData,
            'gtmEventName' => config("forms.{$request->input('form_key')}.gtm_event"),
        ];

        $result = $this->formHandler->handle($data);

        if ($result['status'] === 'success') {
            return redirect()->route('thank-you')->with('status', 'success');
        } else {
            return redirect()->route('thank-you')->with('status', 'failure')->with('error', $result['error'] ?? 'An unknown error occurred.');
        }
    }

    private function getApiUrl($formKey, $lastSubmission)
    {
        $environment = app()->isProduction() && ! config('app.debug') ? 'production_url' : 'development_url';
        $url = config("forms.{$formKey}.{$environment}");

        if (! $url) {
            \Log::error("No URL configured for form key: {$formKey}");

            return false;
        }

        /*if (app()->isProduction() && ! config('app.debug') ? 'production_url' : 'development_url' && $lastSubmission && now()->diffInMinutes($lastSubmission) < 60) {
            return redirect(route('home'));
        }*/

        return $url;
    }

    protected function isSpamRequest(Request $request)
    {
        return ! is_null($request->input('_gotcha')) ||
            ! is_null($request->input('is_spam')) ||
            $request->has('fakeSubmitClicked');
    }
}
