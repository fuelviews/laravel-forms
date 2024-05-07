<div class="mt-2">
    <a href="#" @click="open = !open"
       class="text-blue-500 hover:text-blue-700 cursor-pointer hover:underline">
        {{ $toggleText }}
    </a>
    <div class="flex flex-col pt-2"
         x-show="open"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         style="display: none;">
        <div class="flex justify-between items-center">
            <label for="{{ $id }}" class="font-semibold text-gray-900">{{ $label }}</label>
            <p class="text-gray-400">{{ $hint }}</p>
        </div>
        <textarea
            id="{{ $id }}"
            name="{{ $name }}"
            rows="{{ $rows }}"
            aria-describedby="{{ $id }}-description"
            class="mt-2 block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-gray-600 sm:sm:leading-6">
            {{ old($name) }}
        </textarea>
        @include('laravel-form::components.modal.form.error', ['errorKey' => 'message'])
    </div>
</div>
