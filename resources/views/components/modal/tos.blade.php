@if (Forms::isModalTosEnabled())
    <div class="hidden md:flex mt-4 p-1 max-w-lg text-white text-xs text-justify">
        <p>{{ Forms::getModalTosContent() }}</p>
    </div>
@endif
