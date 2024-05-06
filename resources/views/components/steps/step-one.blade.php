@if(isset($step) && $step === 1)
    <form method="POST" action="{{ route('form.handle.step') }}">
        @csrf
        <div class="mb-4">
            <h3 class="my-1 text-gray-900 lg:text-2xl font-extrabold py-6">{{ $title }}</h3>
            <div class="flex space-x-2">
                <div class="flex space-x-2 -ml-2">
                    <input type="text" name="isSpam" style="display:none"/>
                    <div>
                        @include('laravel-forms::components.buttons.location-button', ['location' => 'inside'])
                    </div>
                    <div>
                        @include('laravel-forms::components.buttons.location-button', ['location' => 'outside'])
                    </div>
                    <div>
                        @include('laravel-forms::components.buttons.location-button', ['location' => 'cabinets'])
                    </div>
                </div>
            </div>
        </div>

        @include('laravel-forms::components.error', ['errorKey' => 'location'])

        <hr class="h-px mt-8 mb-6">

        <div class="flex justify-between items-center text-center">
            @include('laravel-forms::components.buttons.submit-button', ['buttonText' => 'Next'])
            @include('laravel-forms::components.modals.optional-div')
        </div>
    </form>
@endif
