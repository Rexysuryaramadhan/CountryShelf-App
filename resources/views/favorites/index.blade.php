<x-app-layout>
    <div class="py-4">
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h1 class="card-title h2">My Favorite Countries</h1>
                        <a href="{{ route('dashboard') }}" class="btn btn-primary">
                            Back to Dashboard
                        </a>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($favorites->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Country</th>
                                        <th>Capital</th>
                                        <th>Region</th>
                                        <th>Population</th>
                                        <th>Note</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($favorites as $favorite)
                                        <tr>
                                            <td>{{ $favorite->country_name }}</td>
                                            <td>{{ $favorite->capital ?: '-' }}</td>
                                            <td>{{ $favorite->region ?: '-' }}</td>
                                            <td>{{ $favorite->population ? number_format($favorite->population) : '-' }}</td>
                                            <td>
                                                <form method="POST" action="{{ route('favorites.update', $favorite) }}" class="d-flex">
                                                    @csrf
                                                    @method('PUT')
                                                    <textarea
                                                        name="note"
                                                        rows="2"
                                                        class="form-control me-2"
                                                        placeholder="Add a note..."
                                                    >{{ $favorite->note }}</textarea>
                                                    <button type="submit" class="btn btn-sm btn-outline-primary">
                                                        Save
                                                    </button>
                                                </form>
                                            </td>
                                            <td class="text-center">
                                                <form method="POST" action="{{ route('favorites.destroy', $favorite) }}" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button
                                                        type="submit"
                                                        class="btn btn-sm btn-outline-danger"
                                                        onclick="return confirm('Are you sure you want to remove {{ addslashes($favorite->country_name) }} from your favorites?')"
                                                    >
                                                        Remove
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <p class="lead">You haven't added any favorite countries yet.</p>
                            <a href="{{ route('dashboard') }}" class="btn btn-primary mt-3">
                                Browse Countries
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>