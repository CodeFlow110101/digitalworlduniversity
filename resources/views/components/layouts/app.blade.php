<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <title>{{ $title ?? 'Page Title' }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{asset('livewire-events/events.js')}}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body class="bg-[#b5c1c9]">
    {{ $slot }}
</body>

</html>