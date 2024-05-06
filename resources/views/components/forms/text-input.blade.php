<div>
    <label for="{{ $id }}" class="block font-semibold text-lg leading-6 text-gray-900">
        {{ $label }}
    </label>
    <div class="mt-2">
        <input
            type="{{ $type }}"
            name="{{ $name }}"
            id="{{ $id }}"
            autocomplete="{{ $autocomplete }}"
            value="{{ old($name) }}"
            class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-gray-600 sm:sm:leading-6"
        />
        @include('laravel-forms::components.forms.error', ['errorKey' => $name])
    </div>
</div>
