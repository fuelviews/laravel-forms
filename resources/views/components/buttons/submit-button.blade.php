@props([
    'background' => config('forms.theme.submit_button.background'),
    'backgroundHover' => config('forms.theme.submit_button.background_hover'),
    'textColor' => config('forms.theme.submit_button.text'),
    'textSize' => config('forms.theme.buttons.text_size'),
    'fontWeight' => config('forms.theme.buttons.font_weight'),
    'paddingY' => config('forms.theme.buttons.padding_y'),
    'paddingX' => config('forms.theme.buttons.padding_x'),
    'rounded' => config('forms.theme.buttons.rounded'),
    'buttonText' => $slot ?? 'Submit'
])

<button type="submit"
        class="{{ $background }} {{ $backgroundHover }} {{ $textColor }} {{ $textSize }} {{ $fontWeight }} {{ $paddingY }} {{ $paddingX }} {{ $rounded }}">
    {{ $buttonText }}
</button>
