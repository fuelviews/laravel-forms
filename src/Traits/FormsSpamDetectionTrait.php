<?php

namespace Fuelviews\Forms\Traits;

use FuelViews\Forms\Services\TurnstileService;
use Illuminate\Http\Request;

trait FormsSpamDetectionTrait
{
    /**
     * Check if the request is potentially spam.
     */
    protected function isFormSpamRequest(Request $request): bool
    {
        // Check honeypot fields first (backward compatibility)
        if ($this->isHoneypotTriggered($request)) {
            return true;
        }

        // Check Turnstile if enabled
        if ($this->isTurnstileValidationRequired()) {
            return ! $this->validateTurnstile($request);
        }

        return false;
    }

    /**
     * Check if honeypot fields were triggered.
     */
    protected function isHoneypotTriggered(Request $request): bool
    {
        return ! is_null($request->input('gotcha')) ||
            ! is_null($request->input('isSpam')) ||
            $request->has('submitClicked');
    }

    /**
     * Check if Turnstile validation is required.
     */
    protected function isTurnstileValidationRequired(): bool
    {
        $turnstileService = app(TurnstileService::class);

        return $turnstileService->isEnabled();
    }

    /**
     * Validate Turnstile response.
     */
    protected function validateTurnstile(Request $request): bool
    {
        $turnstileService = app(TurnstileService::class);

        return $turnstileService->validateRequest($request);
    }

    /**
     * Get spam detection error message.
     */
    protected function getSpamDetectionMessage(Request $request): string
    {
        if ($this->isHoneypotTriggered($request)) {
            return 'Invalid form submission detected.';
        }

        if ($this->isTurnstileValidationRequired()) {
            $turnstileService = app(TurnstileService::class);

            return $turnstileService->getValidationMessage();
        }

        return 'Form validation failed.';
    }
}
