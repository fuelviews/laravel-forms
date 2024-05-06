@props([
    'titleStepTwo' => config('forms.modal_steps.step_two.title'),
    'textTitle' => config('forms.theme.modal_steps.step_two_title.text'),
    'textSizeTitle' => config('forms.theme.modal_steps.step_two_title.text_size'),
    'fontWeightTitle' => config('forms.theme.modal_steps.step_two_title.font_weight'),
    'paddingYTitle' => config('forms.theme.modal_steps.step_two_title.padding_y'),
])

@if(isset($step) && $step === 2)
    <form method="POST" action="{{ route('validate.form') }}">
        @csrf
        <div class="grid grid-cols-1 gap-x-6 gap-y-4 sm:grid-cols-2 py-6">
            <div class="col-span-2">
                @if (config('forms.modal_steps.step_two.title'))
                    <h3 class="my-1 {{ $textTitle }} {{ $textSizeTitle }} {{ $fontWeightTitle }} {{ $paddingYTitle }}">{{ $titleStepTwo }}</h3>
                @endif
            </div>
            <div>
                <label for="first-name" class="block font-semibold leading-6 text-gray-900">
                    First name:
                </label>
                <div class="mt-2">
                    <input
                        type="text"
                        name="firstName"
                        id="firstName"
                        autocomplete="given-name"
                        value="{{ old('firstName') }}"
                        class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-gray-600 sm:sm:leading-6"/>
                    @include('laravel-forms::components.error', ['errorKey' => 'firstName'])
                </div>
            </div>
            <div>
                <label for="last-name" class="block font-semibold leading-6 text-gray-900">
                    Last name:
                </label>
                <div class="mt-2">
                    <input
                        type="text"
                        name="lastName"
                        id="lastName"
                        autocomplete="family-name"
                        value="{{ old('lastName') }}"
                        class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-gray-600 sm:sm:leading-6"
                        />
                    @include('laravel-forms::components.error', ['errorKey' => 'lastName'])
                </div>
            </div>
            <div class="sm:col-span-2">
                <label for="email" class="block font-semibold leading-6 text-gray-900">
                    Email Address:
                </label>
                <div class="mt-2">
                    <input
                        id="email"
                        name="email"
                        type="email"
                        autocomplete="email"
                        value="{{ old('email') }}"
                        class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-gray-600 sm:sm:leading-6"/>
                    @include('laravel-forms::components.error', ['errorKey' => 'email'])
                </div>
            </div>
            <div class="sm:col-span-1">
                <div class="flex justify-between leading-6">
                    <label for="phone" class="block font-semibold text-gray-900">Phone:</label>
                </div>
                <div class="mt-2">
                    <input
                        type="tel"
                        name="phone"
                        id="phone"
                        value="{{ old('phone') }}"
                        autocomplete="tel"
                        aria-describedby="phone-description"
                        class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-gray-600 sm:sm:leading-6"
                        />
                    @include('laravel-forms::components.error', ['errorKey' => 'phone'])
                </div>
            </div>
            <div class="sm:col-span-1">
                <div class="flex justify-between leading-6">
                    <label for="zipCode" class="block font-semibold text-gray-900">Project Zip
                        Code:</label>
                </div>
                <div class="mt-2">
                    <input
                        type="text"
                        name="zipCode"
                        id="zipCode"
                        value="{{ old('zipCode') }}"
                        aria-describedby="zip-code-description"
                        class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-gray-600 sm:sm:leading-6"
                        />
                    @include('laravel-forms::components.error', ['errorKey' => 'zipCode'])
                </div>
            </div>
            <div x-data="{ open: false }" class="sm:col-span-2">
                <div class="mt-2">
                    <a href="#" @click="open = !open"
                       class="text-blue-500 hover:text-blue-700 cursor-pointer hover:underline">
                        Add additional project info (optional)
                    </a>
                    <div class="flex flex-col pt-2"
                         x-show="open"
                         x-transition:enter="transition ease-out duration-3000"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-3000"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         style="display: none;">
                        <div class="flex justify-between items-center">
                            <label for="message" class="font-semibold text-gray-900">Message</label>
                            <p class="text-gray-400">Max 255 characters</p>
                        </div>
                        <textarea
                            id="message"
                            name="message"
                            value="{{ old('message') }}"
                            rows="4"
                            aria-describedby="message-description"
                            class="mt-2 block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-gray-600 sm:sm:leading-6"
                        ></textarea>
                        @include('laravel-forms::components.error', ['errorKey' => 'message'])
                    </div>
                    <input type="text" name="gotcha" style="display:none"/>
                </div>
            </div>
        </div>

        @include('laravel-forms::components.meta')

        <hr class="h-px mb-6">

        <div class="flex justify-between items-center w-full">
            <div class="flex space-x-4 pr-4 md:pr-0">
                @include('laravel-forms::components.buttons.back-button', ['buttonText' => 'Back'])
                @include('laravel-forms::components.buttons.submit-button', ['buttonText' => 'Submit'])
            </div>

            @include('laravel-forms::components.modals.optional-div')
        </div>
    </form>
@endif
