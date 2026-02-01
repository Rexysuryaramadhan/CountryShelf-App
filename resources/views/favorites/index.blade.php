<x-app-layout>
    <div class="py-4">
        <div class="container">
            <!-- Header Section -->
            <div class="header-gradient text-center mb-5">
                <h1 class="display-4 fw-bold text-white">❤️ My Favorites</h1>
                <p class="lead text-white opacity-75">Your collection of favorite countries</p>
            </div>

            <div class="row mb-4">
                <div class="col-md-8">
                    <h2 class="h4 mb-0">
                        <i class="fas fa-heart me-2"></i>Your Favorite Countries
                    </h2>
                </div>

                <div class="col-md-4 text-md-end">
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if($favorites->count() > 0)
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                    @foreach($favorites as $favorite)
                        <div class="col">
                            <div class="card card-custom country-card h-100">
                                <div class="card-body d-flex flex-column">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <h3 class="card-title h5 text-gradient mb-0">{{ $favorite->country_name }}</h3>
                                        <span class="badge bg-primary rounded-pill">
                                            <i class="fas fa-heart"></i>
                                        </span>
                                    </div>

                                    <div class="country-stats flex-grow-1">
                                        @if($favorite->capital)
                                            <p class="card-text mb-1"><i class="fas fa-city me-2 text-primary"></i><strong>Capital:</strong> {{ $favorite->capital }}</p>
                                        @endif

                                        @if($favorite->region)
                                            <p class="card-text mb-1"><i class="fas fa-map-marker-alt me-2 text-success"></i><strong>Region:</strong> {{ $favorite->region }}</p>
                                        @endif

                                        @if($favorite->population)
                                            <p class="card-text mb-0"><i class="fas fa-users me-2 text-info"></i><strong>Population:</strong> {{ number_format($favorite->population) }}</p>
                                        @endif
                                    </div>

                                    <!-- Note Section -->
                                    <div class="mt-3">
                                        <label class="form-label fw-bold"><i class="fas fa-sticky-note me-2"></i>Your Note:</label>
                                        <form method="POST" action="{{ route('favorites.update', $favorite) }}" class="mb-3">
                                            @csrf
                                            @method('PUT')
                                            <textarea
                                                name="note"
                                                rows="3"
                                                class="form-control"
                                                placeholder="Add your thoughts about this country..."
                                            >{{ $favorite->note }}</textarea>
                                            <button type="submit" class="btn btn-sm btn-primary mt-2">
                                                <i class="fas fa-save me-1"></i>Save Note
                                            </button>
                                        </form>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="mt-auto pt-2">
                                        <form method="POST" action="{{ route('favorites.destroy', $favorite) }}" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                type="submit"
                                                class="btn btn-danger w-100"
                                                onclick="return confirm('Are you sure you want to remove {{ addslashes($favorite->country_name) }} from your favorites?')"
                                            >
                                                <i class="fas fa-trash me-2"></i>Remove
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="text-center mt-4">
                    <p class="text-muted">
                        <i class="fas fa-heart me-2"></i>You have {{ $favorites->count() }} favorite country{{ $favorites->count() != 1 ? 's' : '' }}
                    </p>
                </div>
            @else
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-heart-broken fa-5x text-muted"></i>
                    </div>
                    <h3 class="h4 text-muted">No favorites yet</h3>
                    <p class="text-muted">Start collecting your favorite countries by exploring the world</p>
                    <a href="{{ route('dashboard') }}" class="btn btn-primary">
                        <i class="fas fa-globe-americas me-2"></i>Discover Countries
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>