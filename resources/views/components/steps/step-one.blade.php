<form wire:submit.prevent="nextStep">
    @csrf
    <div class="grid grid-cols-1 gap-x-6 gap-y-4 grid-cols-2 py-6">
        <x-laravel-form::steps.title :title="$title" />

        <input type="text" name="gotcha" style="display:none"/>

        <div class="col-span-2">
            <div class="flex space-x-2 pt-4">
                @foreach (config('forms.modal.steps.1.locations') as $location)
                    <div>
                        <x-laravel-form::buttons.location-button :location="$location" />
                    </div>
                @endforeach
            </div>
        </div>

        <div class="col-span-2">
            <x-laravel-form::error :errorKey="'location'" />
        </div>
    </div>

    <x-laravel-form::divider />
</form>
