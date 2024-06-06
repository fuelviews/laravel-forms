@if (Forms::isModalOptionalDivEnabled())
    <div class="bg-gray-100 text-sm md:text-md p-2 rounded-tl-lg rounded-br-lg text-center -mb-4 -mr-4">
        <span class="block text-gray-900">{{ Forms::getModalOptionalDivTitle() }}</span>
        <a href="{{ route(Forms::getModalOptionalDivLinkRoute()) }}" class="text-blue-500 text-blue-700 hover:underline">{{ Forms::getModalOptionalDivLinkText() }}</a>
    </div>
@endif
