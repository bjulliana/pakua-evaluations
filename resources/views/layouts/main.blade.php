<!DOCTYPE html>
<html class="h-full bg-gray-100" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        @vite(['resources/css/app.css','resources/js/app.js'])

        <title>Itinerancy Evaluations - @yield('title')</title>
    </head>
    <body class="h-full">
        @include('partials.nav-bar')
        <div class="min-h-full">
            <header class="bg-white shadow">
                <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                    <h1 class="text-3xl font-bold tracking-tight text-gray-900">@yield('title')</h1>
                </div>
            </header>
            <main class="sm:p-6 lg:p-8">
                <div class="mx-auto w-full p-4 bg-white border border-gray-200 rounded-lg shadow max-w-7xl py-6 sm:px-6 lg:px-8">
                    @yield('content')
                </div>
            </main>
        </div>
    </body>
</html>
