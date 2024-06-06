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

    {{ $slot }}

    @livewire('forms-modal')

    @include('googletagmanager::body')
    @livewireScripts
</body>
</html>
