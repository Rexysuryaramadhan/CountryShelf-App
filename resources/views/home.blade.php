<x-app-layout>
    <div class="py-4">
        <div class="container">
            <!-- Header Section -->
            <div class="header-gradient text-center mb-5">
                <h1 class="display-4 fw-bold text-white">🌍 Country Shelf</h1>
                <p class="lead text-white opacity-75">Temukan dan kumpulkan negara favoritmu di seluruh dunia</p>
            </div>

            <!-- Search Section -->
            <div class="search-container mb-5">
                <form method="GET" action="{{ route('dashboard') }}" class="row g-3">
                    <div class="col-md-9">
                        <input
                            type="text"
                            name="search"
                            placeholder="🔍 Cari negara..."
                            value="{{ request('search') }}"
                            class="form-control form-control-lg"
                        >
                    </div>
                    <div class="col-md-3">
                        <button
                            type="submit"
                            class="btn btn-primary btn-lg w-100"
                        >
                            <i class="fas fa-search me-2"></i>Cari
                        </button>
                    </div>
                </form>
            </div>

            <!-- Stats and Actions -->
            <div class="row mb-4">
                <div class="col-md-8">
                    <h2 class="h4 mb-0">
                        @if(request('search'))
                            <i class="fas fa-search me-2"></i>Hasil Pencarian untuk "{{ request('search') }}"
                        @else
                            <i class="fas fa-globe-americas me-2"></i>Semua Negara
                        @endif
                    </h2>
                </div>

                <!-- Favorites Link - Only show if user is logged in -->
                @auth
                <div class="col-md-4 text-md-end">
                    <a href="{{ route('favorites.index') }}" class="btn btn-outline-primary favorites-badge" data-count="{{ Auth::user()->favorites->count() }}">
                        <i class="fas fa-heart me-2"></i>Favoritku
                    </a>
                </div>
                @endauth
            </div>

            <!-- Countries Grid -->
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
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
                                        <p class="card-text mb-1"><i class="fas fa-city me-2 text-primary"></i><strong>Ibukota:</strong> {{ $country['capital'] }}</p>
                                    @endif

                                    @if($country['region'])
                                        <p class="card-text mb-1"><i class="fas fa-map-marker-alt me-2 text-success"></i><strong>Wilayah:</strong> {{ $country['region'] }}</p>
                                    @endif

                                    @if($country['population'])
                                        <p class="card-text mb-0"><i class="fas fa-users me-2 text-info"></i><strong>Penduduk:</strong> {{ number_format($country['population']) }}</p>
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
                                                 if(confirm('Apakah kamu yakin ingin menambahkan {{ addslashes($country['name']) }} ke favorit?')) {
                                                     this.closest('form').submit();
                                                 }"
                                    >
                                        <i class="fas fa-heart me-2"></i>Tambah ke Favorit
                                    </button>
                                </form>
                                @else
                                <div class="mt-auto">
                                    <a href="{{ route('login') }}" class="btn btn-primary w-100 btn-custom">
                                        <i class="fas fa-sign-in-alt me-2"></i>Masuk untuk Menambahkan ke Favorit
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
                            <h3 class="h4 text-muted">Negara tidak ditemukan</h3>
                            <p class="text-muted">Coba kata kunci pencarian yang berbeda atau jelajahi semua negara</p>
                            <a href="{{ route('dashboard') }}" class="btn btn-primary">
                                <i class="fas fa-sync-alt me-2"></i>Lihat Semua Negara
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if(!$searchQuery && $pagination)
            <div class="d-flex justify-content-center mt-5">
                <nav aria-label="Country pagination">
                    <ul class="pagination">
                        {{-- Previous Button --}}
                        <li class="page-item {{ $pagination['current_page'] <= 1 ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $pagination['current_page'] > 1 ? request()->fullUrlWithQuery(['page' => $pagination['current_page'] - 1]) : '#' }}">
                                <i class="fas fa-chevron-left me-1"></i>Sebelumnya
                            </a>
                        </li>

                        {{-- First Page --}}
                        @if($pagination['current_page'] > 3)
                            <li class="page-item">
                                <a class="page-link" href="{{ request()->fullUrlWithQuery(['page' => 1]) }}">1</a>
                            </li>
                            @if($pagination['current_page'] > 4)
                                <li class="page-item disabled">
                                    <span class="page-link">...</span>
                                </li>
                            @endif
                        @endif

                        {{-- Pages Around Current --}}
                        @for($i = max(1, $pagination['current_page'] - 2); $i <= min($pagination['last_page'], $pagination['current_page'] + 2); $i++)
                            <li class="page-item {{ $i == $pagination['current_page'] ? 'active' : '' }}">
                                <a class="page-link" href="{{ request()->fullUrlWithQuery(['page' => $i]) }}">{{ $i }}</a>
                            </li>
                        @endfor

                        {{-- Last Page --}}
                        @if($pagination['current_page'] < $pagination['last_page'] - 2)
                            @if($pagination['current_page'] < $pagination['last_page'] - 3)
                                <li class="page-item disabled">
                                    <span class="page-link">...</span>
                                </li>
                            @endif
                            <li class="page-item">
                                <a class="page-link" href="{{ request()->fullUrlWithQuery(['page' => $pagination['last_page']]) }}">{{ $pagination['last_page'] }}</a>
                            </li>
                        @endif

                        {{-- Next Button --}}
                        <li class="page-item {{ $pagination['current_page'] >= $pagination['last_page'] ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $pagination['current_page'] < $pagination['last_page'] ? request()->fullUrlWithQuery(['page' => $pagination['current_page'] + 1]) : '#' }}">
                                Selanjutnya<i class="fas fa-chevron-right ms-1"></i>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>

            <div class="text-center mt-3 text-muted">
                Menampilkan {{ $pagination['from'] }} - {{ $pagination['to'] }} dari {{ $pagination['total'] }} negara
            </div>
            @endif
        </div>
    </div>
</x-app-layout>