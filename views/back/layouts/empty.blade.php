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
<body class="h-screen">
    @yield('content')
    <style>
        body {
            background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
            height: 100vh;
        }

        @keyframes gradient {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }
        </style>
    <script src="{{ mix('/back.js') }}"></script>
</body>
</html>
