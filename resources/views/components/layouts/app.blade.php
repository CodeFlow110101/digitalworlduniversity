<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/alpine-plugins/plugins.js'])
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('/images/favicon.png') }}">
    <title>Digital World University</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{asset('livewire-events/events.js')}}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body class="bg-[#b5c1c9] dark:bg-black">
    {{ $slot }}
</body>

</html>