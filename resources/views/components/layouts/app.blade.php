<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/alpine-plugins/plugins.js','resources/js/app.js'])
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('/images/favicon.png') }}">
    <title>Digital World University</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{asset('livewire-events/events.js')}}"></script>
    <script src="{{asset('js/alpine.js')}}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://player.vimeo.com/api/player.js"></script>
</head>

<body class="bg-white dark:bg-black">
    {{ $slot }}
</body>

</html>