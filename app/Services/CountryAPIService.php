<?php

namespace App\Services;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

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
        $response = Http::get($this->baseUrl . '/all');

        if ($response->successful()) {
            return $response->json();
        }

        return [];
    }

    /**
     * Search for a country by name
     *
     * @param string $countryName
     * @return array
     */
    public function searchCountryByName(string $countryName): array
    {
        $response = Http::get($this->baseUrl . '/name/' . urlencode($countryName));

        if ($response->successful()) {
            return $response->json();
        }

        return [];
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