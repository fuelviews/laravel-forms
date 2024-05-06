@props([
    'enabled' => config('forms.modal_optional_div.enabled'),
    'titleOptionalDiv' => config('forms.modal_optional_div.title'),
    'linkRoute' => config('forms.modal_optional_div.link_route'),
    'linkText' => config('forms.modal_optional_div.link_text'),
])

@if ($enabled)
    <div class="bg-gray-100 text-sm md:text-md p-2 rounded-tl-lg rounded-br-lg text-center -mb-4 -mr-4">
        <span class="block">{{ $titleOptionalDiv }}</span>
        <a href="{{ route($linkRoute) }}" class="text-blue-500 text-blue-700 hover:underline">{{ $linkText }}</a>
    </div>
@endif
