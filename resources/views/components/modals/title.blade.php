@props([
    'title' => config('forms.modal.title'),
    'background' => config('forms.theme.modal_title.background'),
    'text' => config('forms.theme.modal_title.text'),
    'textSize' => config('forms.theme.modal_title.text_size'),
    'fontWeight' => config('forms.theme.modal_title.font_weight'),
    'closeButton' => config('forms.theme.modal_title.close_button'),
])

<div class="flex justify-between items-center {{ $background }} {{ $text }} {{ $textSize }} -mt-4 -mx-4 rounded-t-lg p-4">
    <h2 class="{{ $fontWeight }}">{{ $title }}</h2>
    <button @click="open = false" class="h-6 w-6 flex items-center justify-center mb-2 {{ $closeButton }}">
        &times;
    </button>
</div>
