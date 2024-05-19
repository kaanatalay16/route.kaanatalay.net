<?php

namespace App;

use Illuminate\Support\Facades\Http;
use Filament\Notifications\Notification;


class TomTom
{


    /**
     * Create a new class instance.
     */
    public function __construct()
    {
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
        $pathString = $startingLocationString . ":" . $endingLocationString;
        return $pathString;
    }

    public static function createLocationString(Location $location)
    {
        $locationString = $location->latitude . "," . $location->longitude;
        return $locationString;
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
