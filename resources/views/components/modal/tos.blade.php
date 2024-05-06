@if (LaravelForms::isModalTosEnabled())
    <div class="mt-4 p-4 max-w-md rounded-lg text-xs">
        <p>{{ LaravelForms::getModalTosContent() }}</p>
    </div>
@endif
