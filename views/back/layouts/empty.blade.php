<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token"   content="{{ csrf_token() }}">
    <meta name="Description" content="@yield('description')">
    <title> @yield('title', config('app.name'))</title>
    <link href="{{ mix('/back.css') }}" rel="stylesheet">
</head>
<body class="h-screen" style="background-size: cover;background-image: url({{asset('images/default-back.jpg')}})">
    @yield('content')
    <script src="{{ mix('/back.js') }}"></script>
</body>
</html>
