<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @include('googletagmanager::head')

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-gray-400">
<a href="{{ route('welcome') }}" class="bg-gray-200 p-2">Welcome</a>
<a href="{{ route('form.modal.step.show') }}" class="bg-gray-200 p-2">Show Modal</a>
    @livewire('form-modal')
    <button onclick="Livewire.dispatch('openModal')" class="py-6">Open Modal</button>
    {{ $slot }}

    @include('googletagmanager::body')
    @livewireScripts
</body>
</html>
