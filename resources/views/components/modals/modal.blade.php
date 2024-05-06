@props([
    'backgroundModal' => config('forms.theme.modal.background'),
    'roundedModal' => config('forms.theme.modal.rounded'),
    'paddingModal' => config('forms.theme.modal.padding'),
    'backgroundDropModal' => config('forms.theme.modal.background_drop'),
    'backgroundDropOpacityModal' => config('forms.theme.modal.background_drop_opacity'),
])

@if(View::exists('components.layouts.app'))
    @extends('components.layouts.app' ?? 'laravel-forms::components.layouts.app')
@endif

@section('content')
    <div x-data="{ open: {{ $openModal ? 'true' : 'false' }} }">

        <div x-show="open"
             class="fixed inset-0 {{ $backgroundDropModal }} {{ $backgroundDropOpacityModal }} flex justify-center items-center flex-col"
             x-transition:enter="transition ease-out duration-3000"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-3000"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             x-cloak
             @click="open = false">

            <div class="{{ $backgroundModal }} {{ $roundedModal }} {{ $paddingModal }} shadow-lg max-w-lg w-full border" @click.stop>
                @include('laravel-forms::components.modals.title')
                @include('laravel-forms::components.steps.step-one')
                @include('laravel-forms::components.steps.step-two')
            </div>

            @include('laravel-forms::components.modals.tos')
        </div>
    </div>
@endsection
