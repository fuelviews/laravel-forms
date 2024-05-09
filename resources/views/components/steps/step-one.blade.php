<form method="POST" action="{{ route('form.handle.step') }}">
    @csrf
    <div class="grid grid-cols-1 gap-x-6 gap-y-4 sm:grid-cols-2 py-6">
        <x-laravel-form::steps.title :title="$title" />

        <input type="text" name="gotcha" style="display:none"/>

        <div class="sm:col-span-1">
            <div class="flex space-x-2 pt-4">
                <div>
                    <x-laravel-form::buttons.location-button :location="'inside'" />
                </div>
                <div>
                    <x-laravel-form::buttons.location-button :location="'outside'" />
                </div>
                <div>
                    <x-laravel-form::buttons.location-button :location="'cabinets'" />
                </div>
            </div>
        </div>

        <div class="sm:col-span-2">
            <x-laravel-form::error :errorKey="'location'" />
        </div>
    </div>

    <x-laravel-form::divider />

    <div class="flex justify-between items-center text-center">
        <x-laravel-form::buttons.submit-button :buttonText="'Next'" />
        <x-laravel-form::modal.optional-div />
    </div>
</form>
