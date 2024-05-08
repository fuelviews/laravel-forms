<form method="POST" action="{{ route('form.handle.step') }}">
    @csrf
    <div class="mb-6">
        <h3 class="my-1 text-gray-900 lg:text-2xl font-extrabold py-6">{{ $title }}</h3>
        <div class="flex space-x-2 space-y-2 pb-3">
            <div class="flex space-x-2 -ml-2">
                <input type="text" name="gotcha" style="display:none"/>
                <div>
                    <x-laravel-form::modal.buttons.location-button :location="'inside'" />
                </div>
                <div>
                    <x-laravel-form::modal.buttons.location-button :location="'outside'" />
                </div>
                <div>
                    <x-laravel-form::modal.buttons.location-button :location="'cabinets'" />
                </div>
            </div>
        </div>
        <div class="sm:col-span-2">
            <x-laravel-form::modal.form.error :errorKey="'location'" />
        </div>
    </div>
    @include('laravel-form::components.modal.form.divider')

    <div class="flex justify-between items-center text-center">
        <x-laravel-form::modal.buttons.submit-button :buttonText="'Next'" />
        <x-laravel-form::modal.optional-div />
    </div>
</form>
