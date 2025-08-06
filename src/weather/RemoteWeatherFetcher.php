<?php

namespace App\weather;
use DateTime;

class RemoteWeatherFetcher implements WeatherFetcherInterface{
    private string $apiKey;
    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }


    public function fetch(string $city): ?WeatherInfo{
        $url = "http://api.weatherapi.com/v1/current.json?key={$this->apiKey}&q=" . urlencode($city);
        $response = @file_get_contents($url);
        if (!$response){
            echo "<p style='color:white; text-align:center;'>API call failed (no response). Generating random weather data.</p>";
            return null;
        }

        $data = json_decode($response, true);

        if (!isset($data['current'])) {
            echo "<p style='color:red;'>Invalid API response:</p>";
            echo "<pre>" . print_r($data, true) . "</pre>";
            return null;
        }

        $tempC = (int) $data['current']['temp_c'];
        $condition = strtolower($data['current']['condition']['text']);
        $localTimeRaw = $data['location']['localtime']; // Format: "2025-08-01 14:30"
        $date = DateTime::createFromFormat("Y-m-d H:i", $localTimeRaw);
        $localTime = $date->format("l, jS F. g:ia");
        $humidity = $data['current']['humidity'] ?? 0;
        $uvIndex = $data['current']['uv'] ?? 0.0;
        $weatherType = $this->mapConditionToType($condition);
        
        return new WeatherInfo($city, $tempC, $weatherType, $condition, $humidity, $uvIndex, $localTime);
    }

    //map api data condition to the 4 available types
    private function mapConditionToType(string $condition): string{
        return match (true) {
            str_contains($condition, 'snow'),
            str_contains($condition, 'ice'),
            str_contains($condition, 'freezing') => 'snowy',

            str_contains($condition, 'rain'),
            str_contains($condition, 'drizzle'),
            str_contains($condition, 'storm'),
            str_contains($condition, 'thunder'),
            str_contains($condition, 'shower'),
            str_contains($condition, 'blizzard'),
            str_contains($condition, 'sleet') => 'stormy',

            str_contains($condition, 'cloud'),
            str_contains($condition, 'fog'),
            str_contains($condition, 'mist'),
            str_contains($condition, 'overcast'),
            str_contains($condition, 'haze') => 'cloudy',

            default => 'sunny'
        };
    }
}
