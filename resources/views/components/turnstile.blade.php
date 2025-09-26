@props([
    'id' => 'cf-turnstile',
    'theme' => config('forms.turnstile.theme', 'auto'),
    'size' => config('forms.turnstile.size', 'normal'),
    'appearance' => config('forms.turnstile.appearance', 'always'),
    'retry' => 'auto',
    'refreshExpired' => 'auto',
    'responseFieldName' => 'cf-turnstile-response',
    'errorCallback' => null,
    'callback' => null,
    'expiredCallback' => null,
    'beforeInteractiveCallback' => null,
    'afterInteractiveCallback' => null,
    'unsupportedCallback' => null,
    'tabIndex' => 0,
    'language' => 'auto',
])

@if(config('forms.turnstile.enabled'))
    <x-forms::turnstile-scripts />

    <div class="border-2 border-blue-500 bg-blue-50 p-2 mb-2">
        <p class="text-blue-800 text-sm">DEBUG: Turnstile component rendering</p>
        <p class="text-xs text-blue-600">Site key: {{ config('forms.turnstile.site_key') }}</p>
    </div>

    <div
        id="{{ $id }}"
        class="cf-turnstile"
        data-sitekey="{{ config('forms.turnstile.site_key') }}"
        data-theme="{{ $theme }}"
        data-size="{{ $size }}"
        data-appearance="{{ $appearance }}"
        data-retry="{{ $retry }}"
        data-refresh-expired="{{ $refreshExpired }}"
        data-response-field-name="{{ $responseFieldName }}"
        @if($errorCallback) data-error-callback="{{ $errorCallback }}" @endif
        @if($callback) data-callback="{{ $callback }}" @endif
        @if($expiredCallback) data-expired-callback="{{ $expiredCallback }}" @endif
        @if($beforeInteractiveCallback) data-before-interactive-callback="{{ $beforeInteractiveCallback }}" @endif
        @if($afterInteractiveCallback) data-after-interactive-callback="{{ $afterInteractiveCallback }}" @endif
        @if($unsupportedCallback) data-unsupported-callback="{{ $unsupportedCallback }}" @endif
        data-tabindex="{{ $tabIndex }}"
        data-language="{{ $language }}"
        {{ $attributes->merge(['class' => 'turnstile-container']) }}
    ></div>
@endif
