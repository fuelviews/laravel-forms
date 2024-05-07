@if (LaravelForm::isModalTosEnabled())
    <div class="mt-4 p-4 max-w-md rounded-lg text-xs">
        <p>{{ LaravelForm::getModalTosContent() }}</p>
    </div>
@endif
