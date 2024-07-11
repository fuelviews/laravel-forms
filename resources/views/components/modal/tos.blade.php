@if (Forms::isModalTosEnabled())
    <div class="mt-4 p-4 max-w-md rounded-lg text-white">
        <p>{{ Forms::getModalTosContent() }}</p>
    </div>
@endif
