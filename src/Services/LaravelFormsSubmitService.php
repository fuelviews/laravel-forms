<?php

namespace Fuelviews\LaravelForms\Services;

use Fuelviews\LaravelForms\Contracts\LaravelFormsHandlerService;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Spatie\GoogleTagManager\GoogleTagManager;

class LaravelFormsSubmitService implements LaravelFormsHandlerService
{
    /*protected $gtm;

    public function __construct(GoogleTagManager $gtm)
    {
        $this->gtm = $gtm;
    }*/

    /**
     * @throws ConnectionException
     */
    public function handle(array $data): array
    {
        // Debugging the URL
        \Log::info("Attempting to post to URL: ", ['url' => $data['url']]);

        try {
            $response = Http::withOptions(['verify' => false])->asForm()->post($data['url'], $data['validatedData']);

            if ($response->successful()) {
                session(['last_form_submission' => now()]);

                return ['status' => 'success'];
            }

            \Log::info("Status ", ['status' => $data['status']]);

            return ['status' => 'failure', 'error' => $response->body()];
        } catch (\Exception $exception) {
            return ['status' => 'error', 'message' => $exception->getMessage()];
        }
    }
}
