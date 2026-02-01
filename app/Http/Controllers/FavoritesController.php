<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Services\CountryAPIService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoritesController extends Controller
{
    protected CountryAPIService $countryService;

    public function __construct(CountryAPIService $countryService)
    {
        $this->middleware('auth');
        $this->countryService = $countryService;
    }

    /**
     * Display a listing of the user's favorites.
     */
    public function index()
    {
        $favorites = Auth::user()->favorites;
        return view('favorites.index', compact('favorites'));
    }

    /**
     * Store a newly created favorite in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'country_name' => 'required|string|max:255',
            'capital' => 'nullable|string|max:255',
            'region' => 'nullable|string|max:255',
            'population' => 'nullable|integer',
            'note' => 'nullable|string'
        ]);

        // Check if the favorite already exists for this user
        $existingFavorite = Auth::user()->favorites()
            ->where('country_name', $request->country_name)
            ->first();

        if (!$existingFavorite) {
            Auth::user()->favorites()->create([
                'country_name' => $request->country_name,
                'capital' => $request->capital,
                'region' => $request->region,
                'population' => $request->population,
                'note' => $request->note,
            ]);
        }

        return redirect()->back()->with('success', 'Country added to favorites successfully!');
    }

    /**
     * Update the specified favorite in storage.
     */
    public function update(Request $request, Favorite $favorite)
    {
        // Ensure the user owns this favorite
        if ($favorite->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'note' => 'nullable|string'
        ]);

        $favorite->update([
            'note' => $request->note,
        ]);

        return redirect()->route('favorites.index')->with('success', 'Favorite updated successfully!');
    }

    /**
     * Remove the specified favorite from storage.
     */
    public function destroy(Favorite $favorite)
    {
        // Ensure the user owns this favorite
        if ($favorite->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $favorite->delete();

        return redirect()->back()->with('success', 'Favorite removed successfully!');
    }
}
