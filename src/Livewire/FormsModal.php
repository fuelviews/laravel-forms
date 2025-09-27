<?php

namespace Fuelviews\Forms\Livewire;

use AllowDynamicProperties;
use Fuelviews\Forms\Contracts\FormsHandlerService;
use Fuelviews\Forms\Services\FormsProcessingService;
use Fuelviews\Forms\Services\FormsValidationRuleService;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

#[AllowDynamicProperties] class FormsModal extends Component
{
    public $isOpen = false;

    public $step = 1;

    public $totalSteps = 2;

    public $formData = [];

    public $isLoading = false;

    private $formProcessingService;

    private $formHandler;

    private $validationRuleService;

    protected $listeners = ['openModal' => 'openModal'];

    public $isSpam;

    public $gotcha;

    public $submitClicked;

    public $gclid;
    public $fbclid;

    public $utmCampaign;

    public $utmSource;

    public $utmMedium;

    public $utmTerm;

    public $utmContent;

    public $firstName;

    public $lastName;

    public $email;

    public $phone;

    public $zipCode;

    public $message;

    public $location;

    public $turnstileToken = '';

    public function boot(FormsHandlerService $formHandler, FormsProcessingService $formProcessingService, FormsValidationRuleService $validationRuleService)
    {
        $this->formHandler = $formHandler;
        $this->validationRuleService = $validationRuleService;
        $this->formProcessingService = $formProcessingService;
    }

    public function mount()
    {
        $this->loadInitialData([
            'gclid',
            'fbclid',
            'utmSource' => 'utm_source',
            'utmMedium' => 'utm_medium',
            'utmCampaign' => 'utm_campaign',
            'utmTerm' => 'utm_term',
            'utmContent' => 'utm_content',
        ]);
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
        // Validate Turnstile on step 2 if enabled
        if ($this->step === 2 && config('forms.turnstile.enabled') && config('forms.turnstile.site_key')) {
            $this->validate([
                'turnstileToken' => ['required', 'turnstile'],
            ], [
                'turnstileToken.required' => 'Please complete the security challenge.',
                'turnstileToken.turnstile' => 'Security challenge validation failed. Please try again.',
            ]);
        }

        if ($this->isLastStep($this->step)) {
            $this->isLoading = true;
        }

        $validatedData = $this->validateStepData();

        // Remove turnstileToken from validated data so it's not stored
        unset($validatedData['turnstileToken']);

        $this->formData = array_merge($validatedData, $this->formData);

        if ($this->step < $this->totalSteps) {
            $this->step++;
            session()->put([
                'location' => $validatedData['location'] ?? null,
                'form_data' => $this->formData,
                'form_step' => $this->step,
            ]);
        } elseif ($this->isLastStep($this->step)) {
            session()->put([
                'form_data' => $this->formData,
                'form_step' => $this->step,
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

        $result = $this->formProcessingService->processForm($request, $validatedData);

        if ($result instanceof \Illuminate\Http\RedirectResponse) {
            $this->addError('form.submit.limit', 'Form submit limit exceeded');

            return;
        }

        if (is_array($result) && $result['status'] === 'success') {
            return redirect()->route('forms.thank-you')->with('status', 'success');
        } else {
            Log::error('Error processing form: '.($result['message'] ?? 'Unknown error'));

            return back()->withInput()->withErrors(['error' => $result['message'] ?? 'An unknown error occurred']);
        }
    }

    private function loadInitialData(array $keys)
    {
        foreach ($keys as $propertyName => $requestKey) {
            if (is_numeric($propertyName)) {
                $propertyName = $requestKey;
            }

            $this->$propertyName = request()->query($requestKey, request()->cookie($requestKey, session($requestKey)));
        }
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    public function render()
    {
        return view('forms::livewire.forms-modal');
    }
}
