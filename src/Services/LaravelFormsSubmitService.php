<?php

namespace Fuelviews\LaravelForms\Services;

use Fuelviews\LaravelForms\Contracts\LaravelFormsHandlerService;
use Illuminate\Support\Facades\Http;

class LaravelFormsSubmitService implements LaravelFormsHandlerService
{
    public function handle(array $data): array
    {
        try {
            $response = Http::withOptions(['verify' => false])->asForm()->post($data['url'], $data['validatedData']);

            if ($response->successful()) {
                session(['last_form_submit' => now()]);
                session()->forget(['form_data', 'form_step', 'location']);

                return ['status' => 'success'];
            }

            return ['status' => 'failure', 'error' => $response->body()];
        } catch (\Exception $exception) {
            return ['status' => 'error', 'message' => $exception->getMessage()];
        }
    }
}
