<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CountryAPIService
{
    protected string $baseUrl = 'https://restcountries.com/v3.1';

    /**
     * Get all countries from the API
     *
     * @return array
     */
    public function getAllCountries(): array
    {
        try {
            $response = Http::timeout(30)->withHeaders([
                'User-Agent' => 'CountryShelf App (contact@countryshelf.com)'
            ])->get($this->baseUrl . '/all?fields=name,capital,region,population,flags');

            if ($response->successful()) {
                $data = $response->json();
                Log::info('Successfully fetched countries from API', ['count' => count($data)]);
                return $data;
            } else {
                Log::error('Failed to fetch countries from API', [
                    'status' => $response->status(),
                    'message' => $response->body()
                ]);
                return [];
            }
        } catch (\Exception $e) {
            Log::error('Exception occurred while fetching countries from API', [
                'error' => $e->getMessage()
            ]);
            return [];
        }
    }

    /**
     * Search for a country by name
     *
     * @param string $countryName
     * @return array
     */
    public function searchCountryByName(string $countryName): array
    {
        try {
            $response = Http::timeout(30)->withHeaders([
                'User-Agent' => 'CountryShelf App (contact@countryshelf.com)'
            ])->get($this->baseUrl . '/name/' . urlencode($countryName) . '?fields=name,capital,region,population,flags');

            if ($response->successful()) {
                return $response->json();
            } else {
                // If the country is not found, the API returns a 404
                if ($response->status() === 404) {
                    return [];
                }

                Log::error('Failed to search country from API', [
                    'status' => $response->status(),
                    'message' => $response->body(),
                    'country_name' => $countryName
                ]);
                return [];
            }
        } catch (\Exception $e) {
            Log::error('Exception occurred while searching country from API', [
                'error' => $e->getMessage(),
                'country_name' => $countryName
            ]);
            return [];
        }
    }

    /**
     * Get paginated countries from the API
     *
     * @param int $page
     * @param int $perPage
     * @return array
     */
    public function getPaginatedCountries(int $page = 1, int $perPage = 20): array
    {
        $allCountries = $this->getAllCountries();

        // Calculate offset
        $offset = ($page - 1) * $perPage;

        // Slice the array to get the countries for the current page
        $paginatedCountries = array_slice($allCountries, $offset, $perPage);

        // Calculate total pages
        $total = count($allCountries);
        $lastPage = ceil($total / $perPage);

        return [
            'data' => $paginatedCountries,
            'pagination' => [
                'current_page' => $page,
                'per_page' => $perPage,
                'total' => $total,
                'last_page' => $lastPage,
                'from' => $offset + 1,
                'to' => min($offset + $perPage, $total),
            ]
        ];
    }

    /**
     * Format country data for consistent use in the application
     *
     * @param array $countryData
     * @return array
     */
    public function formatCountryData(array $countryData): array
    {
        return [
            'name' => $this->extractCountryName($countryData),
            'flag' => $this->extractFlag($countryData),
            'capital' => $this->extractCapital($countryData),
            'region' => $this->extractRegion($countryData),
            'population' => $this->extractPopulation($countryData),
        ];
    }

    private function extractCountryName(array $data): string
    {
        if (isset($data['name']['common'])) {
            return $data['name']['common'];
        } elseif (isset($data['name'])) {
            return is_array($data['name']) ? ($data['name']['common'] ?? 'Unknown') : $data['name'];
        }
        return 'Unknown';
    }

    private function extractFlag(array $data): string
    {
        return $data['flags']['svg'] ?? $data['flags']['png'] ?? '';
    }

    private function extractCapital(array $data): string
    {
        if (isset($data['capital']) && is_array($data['capital']) && !empty($data['capital'])) {
            return $data['capital'][0];
        }
        return $data['capital'] ?? '';
    }

    private function extractRegion(array $data): string
    {
        return $data['region'] ?? '';
    }

    private function extractPopulation(array $data): int
    {
        return $data['population'] ?? 0;
    }
}