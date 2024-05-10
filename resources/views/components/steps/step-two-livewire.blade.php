<form wire:submit.prevent="nextStep">
    @csrf
    <div class="grid grid-cols-1 gap-x-6 gap-y-4 sm:grid-cols-2 pt-6 pb-4">
        <x-laravel-form::steps.title :title="$title" />

        <input type="text" name="isSpam" style="display:none"/>

        <div class="sm:col-span-1">
            <x-laravel-form::text-input
                label="First Name:"
                type="text"
                wire:model="firstName"
                name="firstName"
                id="firstName"
                autocomplete="given-name" />
        </div>

        <div class="sm:col-span-1">
            <x-laravel-form::text-input
                label="Last Name:"
                type="text"
                wire:model="lastName"
                name="lastName"
                id="lastName"
                autocomplete="family-name" />
        </div>

        <div class="sm:col-span-2">
            <x-laravel-form::text-input
                label="Email Address:"
                type="email"
                wire:model="email"
                name="email"
                id="email"
                autocomplete="email" />
        </div>

        <div class="sm:col-span-1">
            <x-laravel-form::text-input
                label="Phone:"
                type="phone"
                wire:model="phone"
                name="phone"
                id="phone"
                autocomplete="phone" />
        </div>

        <div class="sm:col-span-1">
            <x-laravel-form::text-input
                label="Zip Code:"
                type="zipCode"
                wire:model="zipCode"
                name="zipCode"
                id="zipCode"
                autocomplete="postal-code" />
        </div>

        <div x-data="{ open: false }" class="sm:col-span-2">
            <x-laravel-form::collapsible-text-area
                toggleText="Add additional project info (optional)"
                label="Message:"
                id="message"
                wire:model="message"
                name="message"
                rows="4"
                hint="Max 255 characters" />
        </div>
        <div class="sm:col-span-2">
            <x-laravel-form::error :errorKey="'form.submit.limit'" />
        </div>
    </div>

    <input type="text" name="gotcha" style="display:none"/>
    <x-laravel-form::meta />
    <input type="hidden" name="form_key" wire:model="{{ Form::getModalFormKey() }}" value="{{ Form::getModalFormKey() }}">
    <input type="hidden" name="gclid" wire:model="gclid" value="{{ request()->cookie('gclid') }}">
    <input type="hidden" name="utmSource" wire:model="utmSource" value="{{ request()->cookie('utm_source') }}">
    <input type="hidden" name="utmMedium" wire:model="utmMedium" value="{{ request()->cookie('utm_medium') }}">
    <input type="hidden" name="utmCampaign" wire:model="utmCampaign" value="{{ request()->cookie('utm_campaign') }}">
    <input type="hidden" name="utmTerm" wire:model="utmTerm" value="{{ request()->cookie('utm_term') }}">
    <input type="hidden" name="utmContent" wire:model="utmContent" value="{{ request()->cookie('utm_content') }}">

    <x-laravel-form::divider />
</form>
