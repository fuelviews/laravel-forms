<?php

namespace Fuelviews\LaravelForm\Livewire;

use AllowDynamicProperties;
use Fuelviews\LaravelForm\Form;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Fuelviews\LaravelForm\Contracts\FormHandlerService;
use Fuelviews\LaravelForm\Services\FormProcessingService;
use Fuelviews\LaravelForm\Services\FormValidationRuleService;
use Illuminate\Support\Facades\App;
Use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Redirect;

#[AllowDynamicProperties] class FormModal extends Component
{
    public $isOpen = false;
    public $step = 1;
    public $totalSteps = 2;
    public $formData = [];
    private $formProcessingService;
    private $formHandler;
    private $validationRuleService;

    protected $listeners = ['openModal' => 'openModal'];

    public $isSpam, $gotcha, $submitClicked;

    public $gclid, $utmCampaign, $utmSource, $utmMedium, $utmTerm, $utmContent;

    public $firstName, $lastName, $email, $phone, $zipCode, $message, $location;

    public function boot(FormHandlerService $formHandler, FormProcessingService $formProcessingService, FormValidationRuleService $validationRuleService)
    {
        $this->formHandler = $formHandler;
        $this->validationRuleService = $validationRuleService;
        $this->formProcessingService = $formProcessingService;
    }

    public function mount()
    {
        $this->loadInitialData(['gclid', 'utm_source', 'utm_medium', 'utm_campaign', 'utm_term', 'utm_content']);
    }

    public function openModal()
    {
        $this->isOpen = true;
        $this->step = 1;
        $this->formData = session()->get('form_data', []);
    }

    /**
     * @throws \Exception
     */
    public function nextStep()
    {
        $validatedData = $this->validateStepData();
        $this->formData = array_merge($validatedData, $this->formData);

        if ($this->step < $this->totalSteps) {
            $this->step++;
            session()->put([
                'location' => $validatedData['location'] ?? null,
                'form_data' => $this->formData,
                'form_step' => $this->step
            ]);
        } else if ($this->isLastStep($this->step)) {
            session()->put([
                'form_data' => $this->formData,
                'form_step' => $this->step
            ]);
            $this->handleFormSubmission();
        }
    }


    public function backStep()
    {
        if ($this->step > 1) {
            $this->step--;
            session()->put('form_step', $this->step);
        }
    }

    private function validateStepData(): array
    {
        $rules = $this->validationRuleService->getRulesForStep($this->step);
        return $this->validate($rules);
    }


    private function isLastStep($step)
    {
        return $step >= $this->totalSteps;
    }

    private function handleFormSubmission()
    {
        $request = request();
        $validatedData = session()->get('form_data', []);

        if ($this->formSubmitLimitExceeded($request)) {
            $this->addError('form.submit.limit', 'Form submit limit exceeded');
            return;
        }

        $result = $this->formProcessingService->processForm($request, $validatedData);

        if (is_array($result) && $result['status'] === 'success') {
            return redirect()->route('thank-you')->with('status', 'success');
        } else {
            Log::error('Error processing form: ' . ($result['message'] ?? 'Unknown error'));
            return back()->withInput()->withErrors(['error' => $result['message'] ?? 'An unknown error occurred']);
        }
    }

    private function loadInitialData(array $keys)
    {
        foreach ($keys as $key) {
            $this->$key = request($key, request()->cookie($key));
        }
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    public function formSubmitLimitExceeded(Request $request): bool
    {
        if (App::environment('production') && ! config('app.debug')) {
            $lastSubmit = session('last_form_submit');

            return $lastSubmit && now()->diffInMinutes(Carbon::parse($lastSubmit)) < 60;
        }

        return false;
    }

    public function render()
    {
        return view('laravel-form::livewire.form-modal');
    }
}
