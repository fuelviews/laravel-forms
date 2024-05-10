<?php

namespace Fuelviews\LaravelForm\Livewire;

use Livewire\Component;

class FormModal extends Component
{
    public $isOpen = false;
    public $step = 1;
    public $totalSteps = 2;

    protected $listeners = ['openModal' => 'openModal'];
    private $firstName;
    private $lastName;
    private $email;
    private $phone;
    private $zipCode;
    private $message;
    private $location;

    public function openModal()
    {
        $this->isOpen = true;
        $this->step = 1;
    }

    public function nextStep()
    {
        if ($this->step < $this->totalSteps) {
            $this->validateStep();
            $this->step++;
        }
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    public function backStep()
    {
        if ($this->step > 1) {
            $this->step--;
        }
    }

    public function submitForm()
    {
        $this->validateStep();

        $data = [
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'email' => $this->email,
            'phone' => $this->phone,
            'zipCode' => $this->zipCode,
            'message' => $this->message,
            'location' => $this->location,
        ];

        return redirect()->to(route('form.modal.step.handle', ['data' => $data]));
    }


    public function validateStep()
    {
    }

    public function render()
    {
        return view('laravel-form::livewire.form-modal');
    }
}
