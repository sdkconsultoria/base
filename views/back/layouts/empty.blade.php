<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token"   content="{{ csrf_token() }}">
    <meta name="Description" content="@yield('description')">
    <title> @yield('title', config('app.name'))</title>
    @vite(['resources/back/css/app.css', 'resources/back/js/app.js'])
</head>
<body class="h-screen" data-theme="dark">
    @yield('content')
</body>
</html>
