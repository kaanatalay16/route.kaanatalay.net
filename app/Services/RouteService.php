<?php

namespace App\Services;

use App\Facades\GoogleMaps;
use App\Facades\TomTom;

class RouteService
{
    public function createRoute($startLat, $startLong, $endLat, $endLong)
    {
        // TomTom facadesini kullanarak rota oluşturma
        $route = TomTom::getRoute($startLat, $startLong, $endLat, $endLong);

        // Rotayı parçalara bölelim (20 metre aralıklarla)
        $segments = $this->segmentRoute($route);

        // Segmentlere hız ve eğim bilgisi ekleyelim
        $segmentsWithInfo = $this->addSpeedAndSlopeInfo($segments);

        return $segmentsWithInfo;
    }

    protected function segmentRoute($route)
    {
        // Rotayı 20 metre parçalara bölecek şekilde segmentlere ayıralım
        $segments = [];
        $coordinates = $route['routes'][0]['legs'][0]['points'];

        foreach ($coordinates as $coordinate) {
            $segments[] = [
                'lat' => $coordinate['latitude'],
                'long' => $coordinate['longitude']
            ];
        }

        return $segments;
    }

    protected function addSpeedAndSlopeInfo($segments)
    {
        for ($i = 0; $i < count($segments) - 1; $i++) {
            $segment = &$segments[$i];
            $nextSegment = $segments[$i + 1];

            // TomTom facadesini kullanarak trafik verisi alalım
            $trafficData = TomTom::getTrafficData($segment['lat'], $segment['long']);

            if (isset($trafficData['flowSegmentData'])) {
                $segment['speed'] = $trafficData['flowSegmentData']['currentSpeed']; // km/s
            } else {
                $segment['speed'] = null; // Hız bilgisi bulunamadı
            }

            // Google Maps servisini kullanarak eğim bilgisi alalım
            $location1 = "{$segment['lat']},{$segment['long']}";
            $location2 = "{$nextSegment['lat']},{$nextSegment['long']}";
            $segment['slope'] = GoogleMaps::slope($location1, $location2);
        }

        return $segments;
    }
}
