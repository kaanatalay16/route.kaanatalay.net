<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GoogleMapsService
{
    protected $apiKey;
    protected $apiBaseUrl;

    public function __construct()
    {
        $this->apiKey = config('services.google_maps.api_key');
        $this->apiBaseUrl = 'https://maps.googleapis.com/maps/api/';
    }

    public function geocode($address)
    {
        $response = Http::get($this->apiBaseUrl . 'geocode/json', [
            'address' => $address,
            'key' => $this->apiKey
        ]);

        return $response->json();
    }

    public function directions($origin, $destination)
    {
        $response = Http::get($this->apiBaseUrl . 'directions/json', [
            'origin' => $origin,
            'destination' => $destination,
            'key' => $this->apiKey
        ]);

        return $response->json();
    }

    public function placeDetails($placeId)
    {
        $response = Http::get($this->apiBaseUrl . 'place/details/json', [
            'place_id' => $placeId,
            'key' => $this->apiKey
        ]);

        return $response->json();
    }

    public function nearbySearch($location, $radius, $type)
    {
        $response = Http::get($this->apiBaseUrl . 'place/nearbysearch/json', [
            'location' => $location,
            'radius' => $radius,
            'type' => $type,
            'key' => $this->apiKey
        ]);

        return $response->json();
    }

    public function elevation($locations)
    {
        $response = Http::get($this->apiBaseUrl . 'elevation/json', [
            'locations' => $locations,
            'key' => $this->apiKey
        ]);

        return $response->json();
    }

    public function slope($location1, $location2)
    {
        // İlk konumun yükseklik verilerini al
        $elevation1 = $this->elevation($location1);
        $elevation1 = $elevation1['results'][0]['elevation'];

        // İkinci konumun yükseklik verilerini al
        $elevation2 = $this->elevation($location2);
        $elevation2 = $elevation2['results'][0]['elevation'];

        // Enlem ve boylamları ayır
        list($lat1, $lng1) = explode(',', $location1);
        list($lat2, $lng2) = explode(',', $location2);

        // İki konum arasındaki yatay mesafeyi hesapla (metre cinsinden)
        $horizontalDistance = $this->haversineGreatCircleDistance($lat1, $lng1, $lat2, $lng2);

        // Yükseklik farkını hesapla
        $elevationDifference = $elevation2 - $elevation1;

        if ($horizontalDistance == 0) {
            return null;
        }
        // Eğim hesapla (yüzde cinsinden)
        $slope = ($elevationDifference / $horizontalDistance) * 100;

        return $slope;
    }

    private function haversineGreatCircleDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000)
    {
        // Dereceden radyana çevir
        $latFrom = deg2rad($latitudeFrom);
        $lonFrom = deg2rad($longitudeFrom);
        $latTo = deg2rad($latitudeTo);
        $lonTo = deg2rad($longitudeTo);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
            cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));

        return $angle * $earthRadius;
    }
}
