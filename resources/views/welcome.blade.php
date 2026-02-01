<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'CountryShelf') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-gradient">
        <div class="min-vh-100 d-flex align-items-center justify-content-center">
            <div class="text-center">
                <div class="mb-4">
                    <i class="fas fa-globe-americas fa-5x text-gradient"></i>
                </div>
                <h1 class="display-3 fw-bold text-gradient">CountryShelf</h1>
                <p class="lead fs-4 mb-4">Discover and collect your favorite countries around the world</p>

                <div class="d-flex justify-content-center gap-3">
                    <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg px-4 py-3">
                        <i class="fas fa-compass me-2"></i>Explore Countries
                    </a>
                    @auth
                        <a href="{{ route('favorites.index') }}" class="btn btn-outline-primary btn-lg px-4 py-3">
                            <i class="fas fa-heart me-2"></i>My Favorites
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-primary btn-lg px-4 py-3">
                            <i class="fas fa-sign-in-alt me-2"></i>Sign In
                        </a>
                    @endauth
                </div>

                <div class="mt-5">
                    <p class="text-muted">Join thousands of travelers exploring the world</p>
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="row text-center">
                                <div class="col-4">
                                    <div class="fs-2 fw-bold text-primary">195+</div>
                                    <div class="text-muted">Countries</div>
                                </div>
                                <div class="col-4">
                                    <div class="fs-2 fw-bold text-primary">24</div>
                                    <div class="text-muted">Regions</div>
                                </div>
                                <div class="col-4">
                                    <div class="fs-2 fw-bold text-primary">8B+</div>
                                    <div class="text-muted">People</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>