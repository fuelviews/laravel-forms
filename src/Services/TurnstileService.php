<?php

namespace FuelViews\Forms\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TurnstileService
{
    protected string $verifyUrl;
    protected ?string $secretKey;
    protected int $timeout;
    protected int $retryInterval;
    protected int $maxRetries;
    protected bool $enabled;

    public function __construct()
    {
        $this->verifyUrl = config('forms.turnstile.verify_url', 'https://challenges.cloudflare.com/turnstile/v0/siteverify');
        $this->secretKey = config('forms.turnstile.secret_key');
        $this->timeout = config('forms.turnstile.timeout', 30);
        $this->retryInterval = config('forms.turnstile.retry_interval', 5);
        $this->maxRetries = config('forms.turnstile.max_retries', 3);
        $this->enabled = config('forms.turnstile.enabled', false);
    }

    /**
     * Check if Turnstile is enabled
     */
    public function isEnabled(): bool
    {
        return $this->enabled && ! empty($this->secretKey);
    }

    /**
     * Verify a Turnstile response token
     */
    public function verify(?string $token, ?string $remoteIp = null): array
    {
        if (! $this->isEnabled()) {
            return [
                'success' => true,
                'skipped' => true,
                'message' => 'Turnstile verification is disabled',
            ];
        }

        if (empty($token)) {
            return [
                'success' => false,
                'error-codes' => ['missing-input-response'],
                'message' => 'Turnstile token is required',
            ];
        }

        $attempt = 0;
        $lastError = null;

        while ($attempt < $this->maxRetries) {
            try {
                $response = $this->makeVerificationRequest($token, $remoteIp);

                if ($response['success']) {
                    return $response;
                }

                // Don't retry on certain errors
                $nonRetryableErrors = ['invalid-input-secret', 'missing-input-secret', 'invalid-input-response'];
                if (! empty($response['error-codes']) && array_intersect($response['error-codes'], $nonRetryableErrors)) {
                    return $response;
                }

                $lastError = $response;
            } catch (\Exception $e) {
                $lastError = [
                    'success' => false,
                    'error-codes' => ['internal-error'],
                    'message' => $e->getMessage(),
                ];
            }

            $attempt++;
            if ($attempt < $this->maxRetries) {
                sleep($this->retryInterval);
            }
        }

        return $lastError ?? [
            'success' => false,
            'error-codes' => ['verification-failed'],
            'message' => 'Failed to verify Turnstile after maximum retries',
        ];
    }

    /**
     * Make the actual verification request to Cloudflare
     */
    protected function makeVerificationRequest(string $token, ?string $remoteIp = null): array
    {
        $payload = [
            'secret' => $this->secretKey,
            'response' => $token,
        ];

        if ($remoteIp) {
            $payload['remoteip'] = $remoteIp;
        }

        $response = Http::timeout($this->timeout)
            ->asForm()
            ->post($this->verifyUrl, $payload);

        if (! $response->successful()) {
            Log::error('Turnstile verification request failed', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return [
                'success' => false,
                'error-codes' => ['http-error'],
                'message' => 'Failed to contact Turnstile verification service',
            ];
        }

        $result = $response->json();

        // Log failures for debugging
        if (! $result['success']) {
            Log::warning('Turnstile verification failed', [
                'error-codes' => $result['error-codes'] ?? [],
                'ip' => $remoteIp,
            ]);
        }

        return $result;
    }

    /**
     * Get client-side configuration for Turnstile widget
     */
    public function getClientConfig(): array
    {
        if (! $this->isEnabled()) {
            return ['enabled' => false];
        }

        return [
            'enabled' => true,
            'siteKey' => config('forms.turnstile.site_key'),
            'theme' => config('forms.turnstile.theme', 'auto'),
            'size' => config('forms.turnstile.size', 'normal'),
            'appearance' => config('forms.turnstile.appearance', 'always'),
            'scriptUrl' => config('forms.turnstile.script_url'),
        ];
    }

    /**
     * Validate Turnstile token from request
     */
    public function validateRequest(\Illuminate\Http\Request $request): bool
    {
        if (! $this->isEnabled()) {
            return true;
        }

        $token = $request->input('cf-turnstile-response');
        $result = $this->verify($token, $request->ip());

        return $result['success'] ?? false;
    }

    /**
     * Get validation error message
     */
    public function getValidationMessage(): string
    {
        return 'Please complete the security verification.';
    }
}