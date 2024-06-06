<?php

namespace Fuelviews\Forms\Services;

use Fuelviews\Forms\Contracts\FormsHandlerService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;

class FormsSubmitService implements FormsHandlerService
{
    public function handle(array $data): array
    {
        try {
            if (App::environment('production') && ! config('app.debug')) {
                $response = Http::asForm()->post($data['url'], $data['validatedData']);
            } else {
                $response = Http::withOptions(['verify' => false])->asForm()->post($data['url'], $data['validatedData']);
            }

            if ($response->successful()) {
                session(['last_form_submit' => now()]);
                session()->forget(['form_data', 'oldData', 'modal_open', 'form_step', 'location']);

                return ['status' => 'success'];
            }

            return ['status' => 'failure', 'error' => $response->body()];
        } catch (\Exception $exception) {
            return ['status' => 'error', 'message' => $exception->getMessage()];
        }
    }
}
