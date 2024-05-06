<?php

namespace Fuelviews\LaravelForms\Services;

use Fuelviews\LaravelForms\Contracts\LaravelFormsHandlerService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;

class LaravelFormsSubmitService implements LaravelFormsHandlerService
{
    public function handle(array $data): array
    {
        try {
            if (App::environment('production') && !config('app.debug')) {
                $response = Http::asForm()->post($data['url'], $data['validatedData']);
            } else {
                $response = Http::withOptions(['verify' => false])->asForm()->post($data['url'], $data['validatedData']);
            }

            if ($response->successful()) {
                session(['last_form_submit' => now()]);
                session()->forget(['form_data', 'form_step', 'form_location']);

                return ['status' => 'success'];
            }

            return ['status' => 'failure', 'error' => $response->body()];
        } catch (\Exception $exception) {
            return ['status' => 'error', 'message' => $exception->getMessage()];
        }
    }
}
