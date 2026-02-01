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

            // For search results, we don't paginate
            $formattedCountries = [];
            foreach ($countries as $country) {
                $formattedCountries[] = $this->countryService->formatCountryData($country);
            }

            // Set pagination to null for search results
            $pagination = null;
        } else {
            // Get all countries from the API
            $allCountries = $this->countryService->getAllCountries();

            // Format the country data
            $allFormattedCountries = [];
            foreach ($allCountries as $country) {
                $allFormattedCountries[] = $this->countryService->formatCountryData($country);
            }

            // Apply pagination to the formatted data
            $page = intval($request->get('page', 1));
            $perPage = 20; // Show 20 countries per page

            $result = paginateArray($allFormattedCountries, $perPage, $page);
            $formattedCountries = $result['data'];

            // Get pagination info
            $pagination = $result['pagination'];
        }

        // Get user's favorites if logged in
        $favorites = Auth::check() ? Auth::user()->favorites : collect([]);

        return view('home', compact('formattedCountries', 'favorites', 'searchQuery', 'pagination'));
    }
}
