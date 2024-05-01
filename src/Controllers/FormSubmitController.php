<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contracts\FormHandlerService;

class FormSubmitController extends Controller
{
    protected $formHandler;

    public function __construct(FormHandlerService $formHandler)
    {
        $this->formHandler = $formHandler;
    }

    public function handleContactUs(Request $request)
    {
        $validatedData = $request->validate([
            // Validation rules here
        ]);

        $data = [
            'url' => $this->getApiUrl($request->input('form_key'), session('last_form_submission')),
            'validatedData' => $validatedData,
            'gtmEventName' => config("app.forms.{$request->input('form_key')}.gtm_event")
        ];

        $result = $this->formHandler->handle($data);

        return redirect()->route('thank-you')->with('status', $result['status']);
    }
}
