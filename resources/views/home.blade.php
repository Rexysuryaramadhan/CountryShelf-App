<x-app-layout>
    <div class="py-4">
        <div class="container">
            <!-- Header Section -->
            <div class="header-gradient text-center mb-5">
                <h1 class="display-4 fw-bold text-white">🌍 Country Shelf</h1>
                <p class="lead text-white opacity-75">Discover and collect your favorite countries around the world</p>
            </div>

            <!-- Search Section -->
            <div class="search-container mb-5">
                <form method="GET" action="{{ route('dashboard') }}" class="row g-3">
                    <div class="col-md-9">
                        <input
                            type="text"
                            name="search"
                            placeholder="🔍 Search for a country..."
                            value="{{ request('search') }}"
                            class="form-control form-control-lg"
                        >
                    </div>
                    <div class="col-md-3">
                        <button
                            type="submit"
                            class="btn btn-primary btn-lg w-100"
                        >
                            <i class="fas fa-search me-2"></i>Search
                        </button>
                    </div>
                </form>
            </div>

            <!-- Stats and Actions -->
            <div class="row mb-4">
                <div class="col-md-8">
                    <h2 class="h4 mb-0">
                        @if(request('search'))
                            <i class="fas fa-search me-2"></i>Search Results for "{{ request('search') }}"
                        @else
                            <i class="fas fa-globe-americas me-2"></i>All Countries
                        @endif
                    </h2>
                </div>

                <!-- Favorites Link - Only show if user is logged in -->
                @auth
                <div class="col-md-4 text-md-end">
                    <a href="{{ route('favorites.index') }}" class="btn btn-outline-primary favorites-badge" data-count="{{ Auth::user()->favorites->count() }}">
                        <i class="fas fa-heart me-2"></i>My Favorites
                    </a>
                </div>
                @endauth
            </div>

            <!-- Countries Grid -->
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                @forelse($formattedCountries as $country)
                    <div class="col">
                        <div class="card card-custom country-card h-100">
                            @if(isset($country['flag']) && $country['flag'])
                                <img src="{{ $country['flag'] }}" alt="{{ $country['name'] }} flag" class="card-img-top flag-img">
                            @else
                                <div class="card-img-top flag-img bg-light d-flex align-items-center justify-content-center">
                                    <i class="fas fa-flag fa-3x text-muted"></i>
                                </div>
                            @endif

                            <div class="card-body d-flex flex-column">
                                <h3 class="card-title h5 text-gradient">{{ $country['name'] }}</h3>

                                <div class="country-stats">
                                    @if($country['capital'])
                                        <p class="card-text mb-1"><i class="fas fa-city me-2 text-primary"></i><strong>Capital:</strong> {{ $country['capital'] }}</p>
                                    @endif

                                    @if($country['region'])
                                        <p class="card-text mb-1"><i class="fas fa-map-marker-alt me-2 text-success"></i><strong>Region:</strong> {{ $country['region'] }}</p>
                                    @endif

                                    @if($country['population'])
                                        <p class="card-text mb-0"><i class="fas fa-users me-2 text-info"></i><strong>Population:</strong> {{ number_format($country['population']) }}</p>
                                    @endif
                                </div>

                                <!-- Add to favorites form - conditionally show based on auth status -->
                                @auth
                                <form method="POST" action="{{ route('favorites.store') }}" class="mt-auto">
                                    @csrf
                                    <input type="hidden" name="country_name" value="{{ $country['name'] }}">
                                    <input type="hidden" name="capital" value="{{ $country['capital'] }}">
                                    <input type="hidden" name="region" value="{{ $country['region'] }}">
                                    <input type="hidden" name="population" value="{{ $country['population'] }}">

                                    <button
                                        type="submit"
                                        class="btn btn-primary w-100 btn-custom"
                                        onclick="event.preventDefault();
                                                 if(confirm('Are you sure you want to add {{ addslashes($country['name']) }} to your favorites?')) {
                                                     this.closest('form').submit();
                                                 }"
                                    >
                                        <i class="fas fa-heart me-2"></i>Add to Favorites
                                    </button>
                                </form>
                                @else
                                <div class="mt-auto">
                                    <a href="{{ route('login') }}" class="btn btn-primary w-100 btn-custom">
                                        <i class="fas fa-sign-in-alt me-2"></i>Login to Add to Favorites
                                    </a>
                                </div>
                                @endauth
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="text-center py-5">
                            <div class="mb-4">
                                <i class="fas fa-globe-americas fa-5x text-muted"></i>
                            </div>
                            <h3 class="h4 text-muted">No countries found</h3>
                            <p class="text-muted">Try a different search term or explore all countries</p>
                            <a href="{{ route('dashboard') }}" class="btn btn-primary">
                                <i class="fas fa-sync-alt me-2"></i>View All Countries
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>