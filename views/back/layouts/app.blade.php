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
    <div id="app" x-data="{ sidebarOpen: false }" class="flex h-screen bg-gray-200 font-roboto">
        @include('base::back.layouts.partial.sidebar')

        <div class="flex-1 flex flex-col overflow-hidden">
            @include('base::back.layouts.partial.header')

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-200">
                <div class="container mx-auto px-6 py-8 relative">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
    <script src="{{ mix('/back.js') }}"></script>
    <?= Base::toast() ?>
</body>
</html>
