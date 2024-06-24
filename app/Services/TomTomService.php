<?php

namespace App\Services;

use App\Location;
use Filament\Notifications\Notification;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

class TomTomService
{
    protected $client;
    protected $apiKey;
    protected $routingUrl;
    protected $trafficUrl;

    public function __construct()
    {
        $this->client = new Client(['base_uri' => 'https://api.tomtom.com/']);
        $this->apiKey = env('TOMTOM_API_KEY');
        $this->routingUrl = "routing/1/calculateRoute";
        $this->trafficUrl = "traffic/services/4/flowSegmentData/absolute/10/json";
    }

    public function search(string $query, float $lat, float $lon)
    {
        $response = $this->client->get('search/2/search.json', [
            'query' => [
                'key' => $this->apiKey,
                'query' => $query,
                'lat' => $lat,
                'lon' => $lon
            ]
        ]);

        return json_decode($response->getBody(), true);
    }

    public function getRoute($startLat, $startLong, $endLat, $endLong, $route_count = 1)
    {
        if ($route_count > 6) {
            $route_count = 6;
        }

        $url = "{$this->routingUrl}/$startLat,$startLong:$endLat,$endLong/json";
        $response = $this->client->get($url, [
            'query' => [
                'key' => $this->apiKey,
                'routeType' => 'fastest',
                'travelMode' => 'car',
                "maxAlternatives" => $route_count - 1
            ]
        ]);

        return json_decode($response->getBody(), true);
    }

    public function getTrafficData($lat, $long)
    {
        $url = $this->trafficUrl;
        $response = $this->client->get($url, [
            'query' => [
                'point' => "$lat,$long",
                'key' => $this->apiKey
            ]
        ]);

        return json_decode($response->getBody(), true);
    }

    public static function calculateRoute(Location $startingLocation, Location $endingLocation, $vehicleQueries)
    {
        $versionNumber = 1;
        $maxAlternatives = 5;
        $pathString = self::createPathString($startingLocation, $endingLocation);

        $response = Http::get(
            env("TOMTOM_API_URL") . "/routing/" . $versionNumber . "/calculateRoute/" . $pathString . "/json",
            [
                "key" => env("TOMTOM_API_KEY"),
                "language" => "en-EN",
                "maxAlternatives" => $maxAlternatives,
                "traffic" => "true",
                "travelMode" => "car",
                "sectionType" => "traffic",
                ...$vehicleQueries
            ]
        );

        if ($response->ok()) {
            return $response->json();
        } else {
            Notification::make()
                ->title('Error')
                ->body($response->body())
                ->danger()
                ->send();
            return null;
        }
    }

    public static function calculateReachableRange(Location $origionLocation)
    {
        $versionNumber = 1;
        $originLocationString = self::createLocationString($origionLocation);

        $response = Http::get(
            env("TOMTOM_API_URL") . "/routing/" . $versionNumber . "/calculateReachableRange/" . $originLocationString . "/json",
            [
                "key" => env("TOMTOM_API_KEY"),
            ]
        )->json();

        return $response;
    }

    public static function createPathString(Location $startingLocation, Location $endingLocation)
    {
        $startingLocationString = self::createLocationString($startingLocation);
        $endingLocationString = self::createLocationString($endingLocation);
        return $startingLocationString . ":" . $endingLocationString;
    }

    public static function createLocationString(Location $location)
    {
        return $location->latitude . "," . $location->longitude;
    }

    public static function createGeoJSONFile($path)
    {
        $data = [
            "type" => "FeatureCollection",
            "features" => collect()
        ];

        $data['features']->push([
            "type" => "Feature",
            "properties" => [
                "fillColor" => "yellow",
            ],
            "geometry" => [
                "coordinates" => collect($path["legs"][0]["points"])->map(function ($item) {
                    return [$item["longitude"], $item["latitude"]];
                }),
                "type" => "LineString"
            ]
        ]);

        return $data;
    }
}
