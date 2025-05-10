@if (Forms::isModalOptionalDivEnabled())
    <div class="bg-gray-100 text-xs md:text-sm md:text-md p-2 rounded-tl-lg rounded-br-lg text-center -mb-4 -mr-4">
        <span class="block text-gray-900">{{ Forms::getModalOptionalDivTitle() }}</span>
        @php
            $routeName = Forms::getModalOptionalDivLinkRoute();
            $routeExists = Route::has($routeName);
        @endphp
        <a href="{{ $routeExists ? route($routeName) : '#' }}" class="text-blue-500 text-blue-700 hover:underline text-sm">{{ Forms::getModalOptionalDivLinkText() }}</a>
    </div>
@endif
