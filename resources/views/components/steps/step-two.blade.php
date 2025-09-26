<form wire:submit.prevent="nextStep">
    @csrf
    <div class="grid grid-cols-1 gap-x-6 gap-y-4 sm:grid-cols-2 py-2">
        <x-forms::steps.title :title="$title" />

        <input type="text" name="isSpam" style="display:none" />

        <div class="sm:col-span-1">
            <x-forms::text-input
                label="First Name:"
                type="text"
                wire:model="firstName"
                name="firstName"
                id="firstName"
                autocomplete="given-name" />
        </div>

        <div class="sm:col-span-1">
            <x-forms::text-input
                label="Last Name:"
                type="text"
                wire:model="lastName"
                name="lastName"
                id="lastName"
                autocomplete="family-name" />
        </div>

        <div class="sm:col-span-2">
            <x-forms::text-input
                label="Email Address:"
                type="email"
                wire:model="email"
                name="email"
                id="email"
                autocomplete="email" />
        </div>

        <div class="sm:col-span-1">
            <x-forms::text-input
                label="Phone:"
                type="phone"
                wire:model="phone"
                name="phone"
                id="phone"
                autocomplete="phone" />
        </div>

        <div class="sm:col-span-1">
            <x-forms::text-input
                label="Zip Code:"
                type="zipCode"
                wire:model="zipCode"
                name="zipCode"
                id="zipCode"
                autocomplete="postal-code" />
        </div>

        <div x-data="{ open: false }" class="sm:col-span-2">
            <x-forms::collapsible-text-area
                toggleText="Add additional project info (optional)"
                label="Message:"
                id="message"
                wire:model="message"
                name="message"
                rows="4"
                hint="Max 255 characters" />
        </div>

        <div class="sm:col-span-2">
            <x-forms::error :errorKey="'form.submit.limit'" />
        </div>

        {{-- Turnstile widget - always visible when enabled --}}
        @if(config('forms.turnstile.enabled'))
            <div class="sm:col-span-2">
                <x-forms::turnstile
                    id="modal-turnstile"
                    wire:model="turnstileToken"
                    :callback="'window.turnstileCallbacks.onSuccess'"
                    :error-callback="'window.turnstileCallbacks.onError'"
                    :expired-callback="'window.turnstileCallbacks.onExpired'"
                />
            </div>
        @endif
    </div>

    <input type="text" name="gotcha" class="hidden" />
    <x-forms::meta />

    <x-forms::divider />
</form>
