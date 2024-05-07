<?php

namespace Fuelviews\LaravelForm\Http\Controllers;

use Fuelviews\LaravelForm\Services\FormValidationRuleService;
use Fuelviews\LaravelForm\Traits\FormModalStepValidationTrait;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class FormModalController extends Controller
{
    use FormModalStepValidationTrait;

    protected FormValidationRuleService $validationRuleService;

    public function __construct(
        FormValidationRuleService $validationRuleService
    ) {
        $this->validationRuleService = $validationRuleService;
    }

    public function showModalForm(Request $request): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $openModal = $request->session()->pull('modal_open', true);
        $step = $request->session()->get('form_step', 1);
        $formData = $request->session()->get('form_data', []);
        $oldData = $formData[$step] ?? [];

        return view('laravel-form::components.modal.modal', compact('step', 'openModal', 'oldData'));
    }

    public function handleModalStep(Request $request): ?\Illuminate\Http\RedirectResponse
    {
        $request->session()->put('modal_open', true);
        $step = $request->session()->get('form_step', 1);
        $allData = $request->session()->get('form_data', []);

        $validatedData = $this->validateStepData($request, $step);
        $allData[$step] = $validatedData;

        if (isset($validatedData['location'])) {
            $request->session()->put('location', $validatedData['location']);
        }

        $request->session()->put('form_data', $allData);

        if ($this->isLastStep($step)) {
            $request->session()->forget(['form_data', 'form_step', 'modal_open']);

            return redirect()->route('thank-you')->with('status', 'success');
        }

        $request->session()->put('form_step', $step + 1);

        return redirect()->route('form.show');
    }

    public function backModalStep(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->session()->put('modal_open', true);
        $step = $request->session()->get('form_step', 1);
        if ($step > 1) {
            $request->session()->put('form_step', $step - 1);
        }

        $formData = $request->session()->get('form_data', []);

        return redirect()->route('form.show')->withInput($formData[$step - 1] ?? []);
    }

    protected function isLastStep($step): bool
    {
        return $step >= 2;
    }
}
