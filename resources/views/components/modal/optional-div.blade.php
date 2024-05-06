@if ($modal_optional_div_enabled)
    <div class="bg-gray-100 text-sm md:text-md p-2 rounded-tl-lg rounded-br-lg text-center -mb-4 -mr-4">
        <span class="block text-gray-900">{{ $modal_optional_div_title }}</span>
        <a href="{{ route($modal_optional_div_link_route) }}" class="text-blue-500 text-blue-700 hover:underline">{{ $modal_optional_div_link_text }}</a>
    </div>
@endif
