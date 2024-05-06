@if(isset($step) && $step === 2)
    <form method="POST" action="{{ route('validate.form') }}">
        @csrf
        <div class="grid grid-cols-1 gap-x-6 gap-y-4 sm:grid-cols-2 py-6">
            @if (isset($title))
                <div class="col-span-2">
                    <h3 class="my-1 text-gray-900 lg:text-2xl font-extrabold">{{ $title }}</h3>
                </div>
            @endif
            <input type="text" name="isSpam" style="display:none"/>

            <div class="sm:col-span-1">
                @include('laravel-forms::components.modal.form.text-input', [
                    'label' => 'First Name:',
                    'type' => 'text',
                    'name' => 'firstName',
                    'id' => 'firstName',
                    'autocomplete' => 'given-name'
                ])
            </div>

            <div class="sm:col-span-1">
                @include('laravel-forms::components.modal.form.text-input', [
                    'label' => 'Last Name:',
                    'type' => 'text',
                    'name' => 'lastName',
                    'id' => 'lastName',
                    'autocomplete' => 'family-name'
                ])
            </div>

            <div class="sm:col-span-2">
                @include('laravel-forms::components.modal.form.text-input', [
                    'label' => 'Email Address:',
                    'type' => 'email',
                    'name' => 'email',
                    'id' => 'email',
                    'autocomplete' => 'email'
                ])
            </div>

            <div class="sm:col-span-1">
                @include('laravel-forms::components.modal.form.text-input', [
                    'label' => 'Phone:',
                    'type' => 'phone',
                    'name' => 'phone',
                    'id' => 'phone',
                    'autocomplete' => 'phone'
                ])
            </div>

            <div class="sm:col-span-1">
                @include('laravel-forms::components.modal.form.text-input', [
                    'label' => 'Zip Code:',
                    'type' => 'zipCode',
                    'name' => 'zipCode',
                    'id' => 'zipCode',
                    'autocomplete' => 'postal-code'
                ])
            </div>

            <div x-data="{ open: false }" class="sm:col-span-2">
                @include('laravel-forms::components.modal.form.collapsible-textarea', [
                    'toggleText' => 'Add additional project info (optional)',
                    'label' => 'Message:',
                    'id' => 'message',
                    'name' => 'message',
                    'rows' => '4',
                    'hint' => 'Max 255 characters'
                ])
            </div>
        </div>

        <input type="text" name="gotcha" style="display:none"/>
        @include('laravel-forms::components.meta')
        <input type="hidden" name="form_key" value="{{ LaravelForms::getModalFormKey() }}">

        @include('laravel-forms::components.modal.form.divider')

        <div class="flex justify-between items-center w-full">
            <div class="flex space-x-4 pr-4 md:pr-0">
                @include('laravel-forms::components.modal.buttons.fake-button', ['buttonText' => 'Submit'])
                @include('laravel-forms::components.modal.buttons.back-button', ['buttonText' => 'Back'])
                @include('laravel-forms::components.modal.buttons.submit-button', ['buttonText' => 'Submit'])
            </div>

            @include('laravel-forms::components.modal.optional-div')
        </div>
    </form>
@endif
