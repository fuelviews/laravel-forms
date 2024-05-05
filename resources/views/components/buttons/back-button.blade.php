@props([
    'background' => config('forms.theme.back_button.background'),
    'backgroundHover' => config('forms.theme.back_button.background_hover'),
    'textColor' => config('forms.theme.back_button.text'),
    'textSize' => config('forms.theme.buttons.text_size'),
    'fontWeight' => config('forms.theme.buttons.font_weight'),
    'paddingY' => config('forms.theme.buttons.padding_y'),
    'paddingX' => config('forms.theme.buttons.padding_x'),
    'rounded' => config('forms.theme.buttons.rounded'),
    'buttonText' => $slot ?? 'Submit'
])

<a href="{{ route('form.back') }}"
   class="{{ $background }} {{ $backgroundHover }} {{ $textColor }} {{ $textSize }} {{ $fontWeight }} {{ $paddingY }} {{ $paddingX }} {{ $rounded }}">
    {{ $buttonText }}</a>
