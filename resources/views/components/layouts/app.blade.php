<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @include('googletagmanager::head')

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-white">
    <button onclick="Livewire.dispatch('openModal')" class="bg-gray-200 p-y">Show Modal</button>

    {{ $slot }}

    @livewire('form-modal')

    @include('googletagmanager::body')
    @livewireScripts
</body>
</html>
