<?php

namespace Fuelviews\LaravelForm\Livewire;

use AllowDynamicProperties;
use Fuelviews\LaravelForm\Form;
use Illuminate\Http\Request;
use Livewire\Component;
use Fuelviews\LaravelForm\Contracts\FormHandlerService;
use Fuelviews\LaravelForm\Services\FormProcessingService;
use Fuelviews\LaravelForm\Services\FormValidationRuleService;
use Illuminate\Support\Facades\Redirect;

#[AllowDynamicProperties] class FormModal extends Component
{
    public $isOpen = false;
    public $step = 1;
    public $totalSteps = 2;
    public $formData = [];
    public $oldData = [];

    public $formKey;

    public $form_key;
    private $formProcessingService;
    private $formHandler;
    private $validationRuleService;

    protected $listeners = ['openModal' => 'openModal'];

    public $isSpam, $gotcha, $submitClicked;

    public $gclid, $utmCampaign, $utmSource, $utmMedium, $utmTerm, $utmContent;

    public $firstName, $lastName, $email, $phone, $zipCode, $message, $location;

    public function boot(FormHandlerService $formHandler, FormProcessingService $formProcessingService)
    {
        $this->formHandler = $formHandler;
        $this->validationRuleService = new \Fuelviews\LaravelForm\Services\FormValidationRuleService();
        $this->formProcessingService = $formProcessingService;
    }


    public function mount()
    {
        $this->gclid = request('gclid', request()->cookie('gclid'));
        $this->utmSource = request('utm_source', request()->cookie('utm_source'));
        $this->utmMedium = request('utm_medium', request()->cookie('utm_medium'));
        $this->utmCampaign = request('utm_campaign', request()->cookie('utm_campaign'));
        $this->utmTerm = request('utm_term', request()->cookie('utm_term'));
        $this->utmContent = request('utm_content', request()->cookie('utm_content'));
    }

    public function openModal()
    {
        $this->isOpen = true;
        $this->step = 1;
        $this->formData = session()->get('form_data', []);
        $this->oldData = $this->formData[$this->step] ?? [];
    }

    public function nextStep()
    {
        $validatedData = $this->validateStepData();
        // Ensure new data is merged into existing formData to preserve all step data.
        $this->formData = array_merge($validatedData, $this->formData);
        \Log::info('Step form data:', ['data' => $this->formData]);

        if ($this->step < $this->totalSteps) {
            $this->step++;
            // Update session data to include new step data and increment step count.
            session()->put([
                'location' => $validatedData['location'] ?? null,
                'form_data' => $this->formData,
                'form_step' => $this->step
            ]);
        } else if ($this->isLastStep($this->step)) {
            // Before final submission, ensure all form data is in session.
            session()->put([
                'form_data' => $this->formData,
                'form_step' => $this->step
            ]);
            \Log::info('Final step form data:', ['data' => $this->formData]);
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

    private function validateStepData()
    {
        $this->validationRuleService = new \Fuelviews\LaravelForm\Services\FormValidationRuleService();
        if (!$this->validationRuleService) {
            throw new \Exception("ValidationRuleService is not initialized");
        }
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
        $result = $this->formProcessingService->processForm($request, $validatedData);

        if ($result['status'] === 'success') {
            return redirect()->route('thank-you')->with('status', 'success');
        } else {
            return back()->withInput()->withErrors(['error' => $result['message']]);
        }
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    public function render()
    {
        return view('laravel-form::livewire.form-modal');
    }
}
