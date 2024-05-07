@if (LaravelForm::isModalOptionalDivEnabled())
    <div class="bg-gray-100 text-sm md:text-md p-2 rounded-tl-lg rounded-br-lg text-center -mb-4 -mr-4">
        <span class="block text-gray-900">{{ LaravelForm::getModalOptionalDivTitle() }}</span>
        <a href="{{ route(LaravelForm::getModalOptionalDivLinkRoute()) }}" class="text-blue-500 text-blue-700 hover:underline">{{ LaravelForm::getModalOptionalDivLinkText() }}</a>
    </div>
@endif
