<?php

namespace App\Http\Controllers;

use App\Services\CountryAPIService;
use Illuminate\Http\Request;

class TestController extends Controller
{
    protected CountryAPIService $countryService;

    public function __construct(CountryAPIService $countryService)
    {
        $this->countryService = $countryService;
    }

    public function testApi()
    {
        $countries = $this->countryService->getAllCountries();

        return response()->json([
            'total_countries' => count($countries),
            'sample_data' => array_slice($countries, 0, 5), // Ambil 5 data pertama sebagai contoh
            'has_data' => !empty($countries)
        ]);
    }
}