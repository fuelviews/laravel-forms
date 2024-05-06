@props([
    'enabled' => config('forms.modal_tos.enabled'),
    'content' => config('forms.modal_tos.content')
])

@if ($enabled)
    <div class="mt-4 p-4 max-w-md rounded-lg text-xs">
        <p>{{ $content }}</p>
    </div>
@endif
