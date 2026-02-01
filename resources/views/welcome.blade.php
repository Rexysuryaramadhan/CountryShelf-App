<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-light">
        <div class="min-vh-100 d-flex align-items-center justify-content-center">
            <div class="text-center">
                <h1 class="display-4 fw-bold text-primary">Welcome to CountryShelf</h1>
                <p class="lead">Your favorite countries collection application</p>
                <a href="{{ route('login') }}" class="btn btn-primary btn-lg">Get Started</a>
            </div>
        </div>
    </body>
</html>