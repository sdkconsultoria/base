<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token"   content="{{ csrf_token() }}">
    <meta property="og:title" content="@yield('title', config('app.name'))" />
    <meta property="og:type"  content="@yield('og:type', 'website')" />
    <meta property="og:url"   content="@yield('og:url', URL::current())" />
    <meta property="og:image" content="@yield('og:image', asset('assets/img/logo/logo-1.svg'))" />
    <meta name="description"  content="@yield('description', '')">
    <meta name="author"       content="@yield('author', config('app.name'))">
    <title> @yield('title', config('app.name'))</title>
    <link href="{{ mix('/front.css') }}" rel="stylesheet">
</head>
<body>
    @yield('content')
    <script src="{{ mix('/front.js') }}"></script>
</body>
</html>
