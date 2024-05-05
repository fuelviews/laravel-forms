@props([
    'enabled' => config('forms.modal_optional_div.enabled'),
    'title' => config('forms.modal_optional_div.title'),
    'linkRoute' => config('forms.modal_optional_div.link_route'),
    'linkText' => config('forms.modal_optional_div.link_text'),
    'background' => config('forms.theme.modal_optional_div.background'),
    'text' => config('forms.theme.modal_optional_div.text'),
    'textSize' => config('forms.theme.modal_optional_div.text_size'),
    'textAlign' => config('forms.theme.modal_optional_div.text_align'),
    'link' => config('forms.theme.modal_optional_div.link'),
    'linkHover' => config('forms.theme.modal_optional_div.link_hover'),
    'rounded' => config('forms.theme.modal_optional_div.rounded'),
    'padding' => config('forms.theme.modal_optional_div.padding')
])

@if ($enabled)
    <div class="{{ $background }} {{ $textSize }} {{ $padding }} {{ $rounded }} {{ $textAlign }} -mb-4 -mr-4">
        <span class="block {{ $text }}">{{ $title }}</span>
        <a href="{{ route($linkRoute) }}" class=" {{ $link }} {{ $linkHover }}">{{ $linkText }}</a>
    </div>
@endif
