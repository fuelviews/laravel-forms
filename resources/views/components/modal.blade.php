@extends('components.layouts.app')

@section('content')
    <div x-data="{ open: {{ $openModal ? 'true' : 'false' }} }" x-cloak >

        <!-- Modal Overlay -->
        <div x-show="open"
             class="fixed inset-0 bg-gray-900 bg-opacity-75 flex justify-center items-center"
             x-transition:enter="transition ease-out duration-2000"
             x-transition:enter-start="opacity-0 transform scale-100"
             x-transition:enter-end="opacity-100 transform scale-100"
             x-transition:leave="transition ease-in duration-2000"
             x-transition:leave-start="opacity-100 transform scale-100"
             x-transition:leave-end="opacity-0 transform scale-100"
             @click="open = false">
            <!-- Modal Content -->
            <div class="bg-white p-4 rounded-lg shadow-lg max-w-md w-full" @click.stop>
                <!-- Close button -->
                <div class="text-right">
                    <button @click="open = false" class="h-6 w-6">&times;</button>
                    <h2 class="text-left text-lg font-bold mb-4">Contact Form</h2>
                </div>

                <!-- Modal content -->

                @if(isset($step) && $step === 1)
                    <form method="POST" action="{{ route('form.handle.step') }}">
                        @csrf
                        <h3 class="my-1 text-left font-extrabold text-gray-900 lg:text-xl pb-2">Where do you need painting?</h3>
                        <div class="mb-4">
                            <div class="flex space-x-2">
                                <div class="flex space-x-2">
                                    <div>
                                    <input type="radio" id="inside" name="location" value="inside" class="sr-only peer" {{ old('location', isset($location) ? $location : null) === 'inside' ? 'checked' : '' }}>
                                    <label for="inside" class="bg-gray-500 text-white font-medium py-2 px-4 rounded cursor-pointer peer-checked:bg-blue-900">
                                        Inside
                                    </label>
                                    </div>

                                    <div>
                                    <input type="radio" id="outside" name="location" value="outside" class="sr-only peer" {{ old('location', isset($location) ? $location : null) === 'outside' ? 'checked' : '' }}>
                                    <label for="outside" class="bg-gray-500 text-white font-medium py-2 px-4 rounded cursor-pointer peer-checked:bg-blue-900">
                                        Outside
                                    </label>
                                    </div>

                                    <div>
                                    <input type="radio" id="cabinets" name="location" value="cabinets" class="sr-only peer" {{ old('location', isset($location) ? $location : null) === 'cabinets' ? 'checked' : '' }}>
                                    <label for="cabinets" class="bg-gray-500 text-white font-medium py-2 px-4 rounded cursor-pointer peer-checked:bg-blue-900">
                                        Cabinets
                                    </label>
                                    </div>
                                </div>

                            </div>


                            @error('location')
                            <span class="flex pl-1 pt-2 text-sm text-red-600">{{ $message }}</span>
                            @enderror
                        </div>
                        <button type="submit" name="action" value="next" class="bg-gray-200 p-2">Next Step</button>
                    </form>
                @endif

                @if(isset($step) && $step === 2)
                    <form method="POST" action="{{ route('validate.form') }}" class="mt-16">
                        @csrf
                        <div class="grid grid-cols-1 gap-x-6 gap-y-2 sm:grid-cols-2">
                            <div>
                                <label for="first-name" class="block text-sm font-semibold leading-6 text-gray-900">
                                    First name
                                </label>
                                <div class="mt-1">
                                    <input
                                        type="text"
                                        name="firstName"
                                        id="firstName"
                                        wire:model="firstName"
                                        autocomplete="given-name"
                                        value="{{ old('firstName') }}"
                                        class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                        pattern="[A-Za-z]{2,}"
                                        title="First name must be at least 2 letters and only contain letters." />
                                    @error('firstName')
                                    <span class="flex pl-1 pt-2 text-sm text-red-600">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div>
                                <label for="last-name" class="block text-sm font-semibold leading-6 text-gray-900">
                                    Last name
                                </label>
                                <div class="mt-1">
                                    <input
                                        type="text"
                                        name="lastName"
                                        id="lastName"
                                        wire:model="lastName"
                                        autocomplete="family-name"
                                        value="{{ old('lastName') }}"
                                        class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                        pattern=".{2,}"
                                        title="Last name must be at least 2 characters." />
                                    @error('lastName')
                                    <span class="flex pl-1 pt-2 text-sm text-red-600">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="sm:col-span-2">
                                <label for="email" class="block text-sm font-semibold leading-6 text-gray-900">
                                    Email
                                </label>
                                <div class="mt-1">
                                    <input
                                        id="email"
                                        name="email"
                                        type="email"
                                        wire:model="email"
                                        autocomplete="email"
                                        value="{{ old('email') }}"
                                        class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                                    @error('email')
                                    <span class="flex pl-1 pt-2 text-sm text-red-600">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="sm:col-span-2">
                                <div class="flex justify-between text-sm leading-6">
                                    <label for="phone" class="block font-semibold text-gray-900">Phone</label>
                                </div>
                                <div class="mt-1">
                                    <input
                                        type="tel"
                                        name="phone"
                                        id="phone"
                                        wire:model="phone"
                                        value="{{ old('phone') }}"
                                        autocomplete="tel"
                                        aria-describedby="phone-description"
                                        class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                        pattern="[\s\d\-\(\)]*?(\d[\s\d\-\(\)]*?){7,11}"
                                        title="Phone number must have 7 to 11 digits and may include parentheses, spaces, and hyphens." />
                                    @error('phone')
                                    <span class="flex pl-1 pt-2 text-sm text-red-600">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="sm:col-span-2">
                                <div class="flex justify-between text-sm leading-6">
                                    <label for="message" class="block text-sm font-semibold leading-6 text-gray-900">
                                        How can we help you?
                                    </label>
                                    <p id="message-description" class="text-gray-400">Max 255 characters</p>
                                </div>
                                <div class="mt-1">
                            <textarea
                                id="message"
                                name="message"
                                wire:model="message"
                                value="{{ old('message') }}"
                                rows="4"
                                aria-describedby="message-description"
                                class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"></textarea>
                                </div>
                            </div>
                        </div>

                        <input type="text" name="isSpam" style="display:none" />

                        <input type="hidden" name="form_key" value="contact_us">
                        <input type="hidden" name="gclid" value="{{ request()->cookie('gclid') }}">
                        <input type="hidden" name="utmSource" value="{{ request()->cookie('utm_source') }}">
                        <input type="hidden" name="utmMedium" value="{{ request()->cookie('utm_medium') }}">
                        <input type="hidden" name="utmCampaign" value="{{ request()->cookie('utm_campaign') }}">
                        <input type="hidden" name="utmTerm" value="{{ request()->cookie('utm_term') }}">
                        <input type="hidden" name="utmContent" value="{{ request()->cookie('utm_content') }}">

                        <div class="grid grid-cols-1 gap-x-6 gap-y-2 mt-2 sm:grid-cols-2">
                            <div>
                                <label for="first-name" class="block text-sm font-semibold leading-6 text-gray-900">
                                    Is Spam
                                </label>
                                <input type="text" name="isSpam" class="lock w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                            </div>
                            <div>
                                <label for="first-name" class="block text-sm font-semibold leading-6 text-gray-900">
                                    Gotcha
                                </label>
                                <input type="text" name="gotcha" class="lock w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                            </div>

                        </div>

                        <div class="mt-10 flex justify-end border-t border-gray-900/10 pt-8">
                            <a href="{{ route('form.back') }}" class="bg-gray-200 p-2">Back</a>
                            <div class="pr-4" aria-hidden="true">
                                <button name="fakeSubmitClicked" class="hidden rounded-md bg-blue-500 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-sm hover:bg-cta hover:text-black focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Fake Submit</button>
                            </div>
                            <button type="submit" name="action" value="next" class="bg-red-300 p-2">Submit</button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
@endsection
