@extends(View::exists('components.layouts.app') ? 'components.layouts.app' : 'laravel-form::components.layouts.app')

@section('content')
    <div x-data="{ open: {{ $openModal ? 'true' : 'false' }} }">

        <div x-show="open"
             class="fixed inset-0 bg-white bg-opacity-75 flex justify-center items-center flex-col"
             x-transition:enter="transition ease-out duration-3000"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-3000"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             x-cloak
             @click="open = false">

            <div class="bg-white rounded-lg p-4 shadow-lg max-w-lg w-full border" @click.stop>
                @include('laravel-form::components.modal.title', ['title' => 'Your Project Info'])
                @include('laravel-form::components.modal.steps.step-one', ['title' => 'Where do you need painting?'])
                @include('laravel-form::components.modal.steps.step-two')
            </div>

            @include('laravel-form::components.modal.tos')
        </div>
    </div>
@endsection
