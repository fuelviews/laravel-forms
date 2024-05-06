@if(isset($step) && $step === 1)
    <form method="POST" action="{{ route('form.handle.step') }}">
        @csrf
        <div class="mb-4 pb-6">
            <h3 class="my-1 text-gray-900 lg:text-2xl font-extrabold py-6">{{ $title }}</h3>
            <div class="flex space-x-2">
                <div class="flex space-x-2 -ml-2">
                    <input type="text" name="gotcha" style="display:none"/>
                    <div>
                        @include('laravel-forms::components.modal.buttons.location-button', ['location' => 'inside'])
                    </div>
                    <div>
                        @include('laravel-forms::components.modal.buttons.location-button', ['location' => 'outside'])
                    </div>
                    <div>
                        @include('laravel-forms::components.modal.buttons.location-button', ['location' => 'cabinets'])
                    </div>
                </div>
            </div>
        </div>

        @include('laravel-forms::components.modal.form.error', ['errorKey' => 'location'])

        @include('laravel-forms::components.modal.form.divider')

        <div class="flex justify-between items-center text-center">
            @include('laravel-forms::components.modal.buttons.fake-button', ['buttonText' => 'Next'])
            @include('laravel-forms::components.modal.buttons.submit-button', ['buttonText' => 'Next'])
            @include('laravel-forms::components.modal.optional-div')
        </div>
    </form>
@endif
