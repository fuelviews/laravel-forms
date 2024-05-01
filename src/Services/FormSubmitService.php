<?php

namespace App\Services;

use App\Contracts\FormHandlerService;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Spatie\GoogleTagManager\GoogleTagManager;

class FormSubmitService implements FormHandlerService
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
        $response = Http::withOptions(['verify' => false])->asForm()->post($data['url'], $data['validatedData']);

        if ($response->successful()) {
            session(['last_form_submission' => now()]);

            //$this->gtm->flash('event', $data['gtmEventName']);

            return ['status' => 'success'];
        }

        return ['status' => 'failure'];
    }
}
