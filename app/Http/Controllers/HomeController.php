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
            // Get paginated countries from the API
            $page = $request->get('page', 1);
            $perPage = 20; // Show 20 countries per page

            $result = $this->countryService->getPaginatedCountries($page, $perPage);
            $countries = $result['data'];

            // Format the country data
            $formattedCountries = [];
            foreach ($countries as $country) {
                $formattedCountries[] = $this->countryService->formatCountryData($country);
            }

            // Get pagination info
            $pagination = $result['pagination'];
        }

        // Get user's favorites if logged in
        $favorites = Auth::check() ? Auth::user()->favorites : collect([]);

        return view('home', compact('formattedCountries', 'favorites', 'searchQuery', 'pagination'));
    }
}
