<?php

namespace User\WeatherApp;

use GuzzleHttp\Client;

class WeatherService
{
    private string $apiKey = 'd3211f958cd8a80453b211699c411800';
    private string $apiEndpoint = 'https://api.openweathermap.org/data/2.5/weather';
    private Client $client;

    public function __construct() {
        //$this->apiKey = $_ENV['OPENWEATHER_API_KEY'] ?? '';
        $this->client = new Client();
    }

    public function getWeather(string $city): array
    {
        $response = $this->client->get($this->apiEndpoint, [
            'query' => [
                'q' => $city,
                'appid' => $this->apiKey,
                'units' => 'metric'
            ],

            // ⛔ penting supaya 401/404 tidak lempar fatal error
            'http_errors' => false 
        ]);

        $data = json_decode($response->getBody()->getContents(), true);
        
        // API Error
        if(!isset($data['cod']) || (int)$data['cod'] !==200) {
          return [
               'error' => $data['message'] ?? 'Unknown API error'
          ];
        }

        return [
            'city' => $data['name'],
            'temperature' => $data['main']['temp'],
            'description' => $data['weather'][0]['description'],
            'humidity' => $data['main']['humidity']
        ];
        
    }  
}