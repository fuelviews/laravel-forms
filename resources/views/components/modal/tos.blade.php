@if (Form::isModalTosEnabled())
    <div class="mt-4 p-4 max-w-md rounded-lg text-xs">
        <p>{{ Form::getModalTosContent() }}</p>
    </div>
@endif
