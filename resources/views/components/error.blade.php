@if ($errors->has($errorKey))
    @foreach ($errors->get($errorKey) as $error)
        <div class="flex text-sm text-red-600 pt-2">
            {{ $error }}
        </div>
    @endforeach
@endif
