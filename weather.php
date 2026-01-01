<?php
use User\WeatherApp\WeatherService;

require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

if ($argc < 2){
     echo "Usage: php weather.php <city>\n";
     echo "Example: php weather.php London\n";
     exit(1);
}

$weatherService = new WeatherService();
$city = $argv[1];

echo "Getting weather for $city...\n";

$weather = $weatherService->getWeather($city); 

if (isset($weather['error'])){
     echo "Error: " . $weather['error'] . "\n";
     exit(1);
}
var_dump($weather);

echo "\n";
echo "City: " . $weather['city'] . "\n";
echo "Temperatur:" . $weather['temperature'] . "°C\n";
echo "Description:" . $weather['description'] . "\n";
echo "Humidity:" . $weather['humidity'] . "%\n"; 