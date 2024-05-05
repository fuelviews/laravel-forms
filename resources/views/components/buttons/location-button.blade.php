@props([
    'background' => config('forms.theme.location_button.background'),
    'backgroundHover' => config('forms.theme.location_button.background_hover'),
    'backgroundSelected' => config('forms.theme.location_button.background_selected'),
    'textColor' => config('forms.theme.location_button.text'),
    'padding' => config('forms.theme.location_button.padding'),
    'textSize' => config('forms.theme.buttons.text_size'),
    'fontWeight' => config('forms.theme.buttons.font_weight'),
    'rounded' => config('forms.theme.buttons.rounded'),
])

<input type="radio" id="{{ $name }}" name="location" value="{{ $name }}"
       class="sr-only peer" {{ old('location', $location ?? '') === $name ? 'checked' : '' }}>

<label for="{{ $name }}"
       class="{{ $background }} {{ $textColor }} {{ $fontWeight }} {{ $textSize }} {{ $padding }} {{ $rounded }} cursor-pointer {{ $backgroundSelected }} {{ $backgroundHover }}">
    {{ ucfirst($name) }}
</label>

