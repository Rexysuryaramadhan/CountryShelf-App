<x-app-layout>
    <div class="py-4">
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <h1 class="card-title h2">Country Shelf - Your Favorite Countries Collection</h1>

                    <!-- Search Form -->
                    <form method="GET" action="{{ route('dashboard') }}" class="mb-4">
                        <div class="row">
                            <div class="col-md-8">
                                <input
                                    type="text"
                                    name="search"
                                    placeholder="Search for a country..."
                                    value="{{ request('search') }}"
                                    class="form-control"
                                >
                            </div>
                            <div class="col-md-4">
                                <button
                                    type="submit"
                                    class="btn btn-primary w-100"
                                >
                                    Search
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Favorites Link -->
                    <div class="mb-4">
                        <a href="{{ route('favorites.index') }}" class="btn btn-success">
                            View My Favorites ({{ Auth::user()->favorites->count() }})
                        </a>
                    </div>

                    <!-- Results Header -->
                    <h2 class="h4 mb-4">
                        @if(request('search'))
                            Search Results for "{{ request('search') }}"
                        @else
                            All Countries
                        @endif
                    </h2>

                    <!-- Countries Grid -->
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                        @forelse($formattedCountries as $country)
                            <div class="col">
                                <div class="card h-100">
                                    @if(isset($country['flag']) && $country['flag'])
                                        <img src="{{ $country['flag'] }}" alt="{{ $country['name'] }} flag" class="card-img-top" style="height: 200px; object-fit: cover;">
                                    @endif

                                    <div class="card-body d-flex flex-column">
                                        <h3 class="card-title h5">{{ $country['name'] }}</h3>

                                        @if($country['capital'])
                                            <p class="card-text"><strong>Capital:</strong> {{ $country['capital'] }}</p>
                                        @endif

                                        @if($country['region'])
                                            <p class="card-text"><strong>Region:</strong> {{ $country['region'] }}</p>
                                        @endif

                                        @if($country['population'])
                                            <p class="card-text"><strong>Population:</strong> {{ number_format($country['population']) }}</p>
                                        @endif

                                        <!-- Add to favorites form -->
                                        <form method="POST" action="{{ route('favorites.store') }}" class="mt-auto">
                                            @csrf
                                            <input type="hidden" name="country_name" value="{{ $country['name'] }}">
                                            <input type="hidden" name="capital" value="{{ $country['capital'] }}">
                                            <input type="hidden" name="region" value="{{ $country['region'] }}">
                                            <input type="hidden" name="population" value="{{ $country['population'] }}">

                                            <button
                                                type="submit"
                                                class="btn btn-primary w-100"
                                                onclick="event.preventDefault();
                                                         if(confirm('Are you sure you want to add {{ addslashes($country['name']) }} to your favorites?')) {
                                                             this.closest('form').submit();
                                                         }"
                                            >
                                                Add to Favorites
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="text-center py-5">
                                    <p class="lead text-muted">No countries found.</p>
                                    @if(request('search'))
                                        <p class="text-muted">Try a different search term.</p>
                                    @endif
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>