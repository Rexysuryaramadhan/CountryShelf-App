<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Services\CountryAPIService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    protected CountryAPIService $countryService;

    public function __construct(CountryAPIService $countryService)
    {
        $this->middleware('auth');
        $this->countryService = $countryService;
    }

    /**
     * Show the application dashboard.
     */
    public function index(Request $request)
    {
        // Get search query if exists
        $searchQuery = $request->input('search');

        if ($searchQuery) {
            // Search for countries based on the query
            $countries = $this->countryService->searchCountryByName($searchQuery);
        } else {
            // Get all countries from the API
            $countries = $this->countryService->getAllCountries();
        }

        // Format the country data
        $formattedCountries = [];
        foreach ($countries as $country) {
            $formattedCountries[] = $this->countryService->formatCountryData($country);
        }

        // Get user's favorites
        $favorites = Auth::user()->favorites;

        return view('home', compact('formattedCountries', 'favorites', 'searchQuery'));
    }
}
