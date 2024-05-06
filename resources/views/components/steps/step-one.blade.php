@props([
    'title' => config('forms.modal_steps.step_one.title'),
    'textTitle' => config('forms.theme.modal_steps.step_one_title.text'),
    'textSizeTitle' => config('forms.theme.modal_steps.step_one_title.text_size'),
    'fontWeightTitle' => config('forms.theme.modal_steps.step_one_title.font_weight'),
    'paddingYTitle' => config('forms.theme.modal_steps.step_one_title.padding_y'),
])

@if(isset($step) && $step === 1)
    <form method="POST" action="{{ route('form.handle.step') }}">
        @csrf
        <div class="mb-4">
            <h3 class="my-1 {{ $textTitle }} {{ $textSizeTitle }} {{ $fontWeightTitle }} {{ $paddingYTitle }}">{{ $title }}</h3>
            <div class="flex space-x-2">
                <div class="flex space-x-2 -ml-2">
                    <input type="text" name="isSpam" style="display:none"/>
                    <div>
                        @include('laravel-forms::components.buttons.location-button', ['name' => 'inside'])
                    </div>
                    <div>
                        @include('laravel-forms::components.buttons.location-button', ['name' => 'outside'])
                    </div>
                    <div>
                        @include('laravel-forms::components.buttons.location-button', ['name' => 'cabinets'])
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
