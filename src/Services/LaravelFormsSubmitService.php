<?php

namespace Fuelviews\LaravelForms\Services;

use Fuelviews\LaravelForms\Contracts\LaravelFormsHandlerService;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Spatie\GoogleTagManager\GoogleTagManager;

class LaravelFormsSubmitService implements LaravelFormsHandlerService
{
    public function handle(array $data): array
    {
        try {
            $response = Http::withOptions(['verify' => false])->asForm()->post($data['url'], $data['validatedData']);

            if ($response->successful()) {
                session(['last_form_submission' => now()]);

                return ['status' => 'success'];
            }

            return ['status' => 'failure', 'error' => $response->body()];
        } catch (\Exception $exception) {
            return ['status' => 'error', 'message' => $exception->getMessage()];
        }
    }
}
