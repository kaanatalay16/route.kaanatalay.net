<?php

namespace App\Services;

use App\Helpers\ColorHelper;
use App\Models\Segment;

class KmlService
{



    public function create($data)
    {
        $kml = '<?xml version="1.0" encoding="UTF-8"?>';
        $kml .= '<kml xmlns="http://www.opengis.net/kml/2.2">';
        $kml .= '<Document>';

        // $kml .= '<Style id="transBluePoly">';
        // $kml .= '<LineStyle>';
        // $kml .= '<width>1.5</width>';
        // $kml .= '</LineStyle>';
        // $kml .= '<PolyStyle>';
        // $kml .= '<color>7dff0000</color>';
        // $kml .= '</PolyStyle>';
        // $kml .= '</Style>';

        $kml .= '<Placemark>';
        $kml .= '<Style>';
        $kml .= '<IconStyle>';
        $kml .= '<Icon>';
        $kml .= '<href>http://maps.google.com/mapfiles/kml/paddle/blue-circle.png</href>';
        $kml .= '</Icon>';
        $kml .= '</IconStyle>';
        $kml .= '</Style>';
        $kml .= '<name>' . htmlspecialchars("Starting Location") . '</name>';
        $kml .= '<Point>';
        $kml .= '<coordinates>' . $data[0]['longitude'] . ',' . $data[0]['latitude'] . '</coordinates>';
        $kml .= '</Point>';
        $kml .= '</Placemark>';

        foreach ($data as $index => $place) {

            if ($index === (count($data) - 1)) {
                continue;
            }



            $kml .= '<Placemark>';
            $kml .= '<Style>';
            $kml .= '<LineStyle>';
            $kml .= '<width>6</width>';
            $kml .= '<color>' . (($index % 2) ? "FF0000CC" : "ff00ff00") . '</color>';
            $kml .= '</LineStyle>';
            $kml .= '</Style>';
            $kml .= '<name>' . htmlspecialchars("Segment: " . $index + 1) . '</name>';
            $kml .= '<description>' . htmlspecialchars("Slope: " . $place["slope"] . " - " . "Speed: " . $place["speed"]) . '</description>';
            $kml .= '<LineString>';
            $kml .= '<coordinates>';
            $kml .= $data[$index]["longitude"] . "," . $data[$index]["latitude"] . ",0\n";
            $kml .= $data[$index + 1]["longitude"] . "," . $data[$index + 1]["latitude"] . ",0\n";
            $kml .= '</coordinates>';
            $kml .= '</LineString>';
            $kml .= '</Placemark>';

            $kml .= '<Placemark>';
            $kml .= '<Style>';
            $kml .= '<LineStyle>';
            $kml .= '<width>10</width>';
            $kml .= '<color>1AFF0000</color>';
            $kml .= '</LineStyle>';
            $kml .= '</Style>';
            $kml .= '<name>' . htmlspecialchars("Segment: " . $index) . '</name>';
            $kml .= '<description>' . htmlspecialchars("Slope: " . $place["slope"] . " - " . "Speed: " . $place["speed"]) . '</description>';
            $kml .= '<LineString>';
            $kml .= '<coordinates>';
            $kml .= $data[$index]["longitude"] . "," . $data[$index]["latitude"] . ",0\n";
            $kml .= $data[$index + 1]["longitude"] . "," . $data[$index + 1]["latitude"] . ",0\n";
            $kml .= '</coordinates>';
            $kml .= '</LineString>';
            $kml .= '</Placemark>';
        }

        $latest = $data[count($data) - 1];

        $kml .= '<Placemark>';
        $kml .= '<name>' . htmlspecialchars("Ending Location") . '</name>';
        $kml .= '<Style>';
        $kml .= '<IconStyle>';
        $kml .= '<Icon>';
        $kml .= '<href>http://maps.google.com/mapfiles/kml/paddle/red-circle.png</href>';
        $kml .= '</Icon>';
        $kml .= '</IconStyle>';
        $kml .= '</Style>';
        $kml .= '<Point>';
        $kml .= '<coordinates>' . $latest['longitude'] . ',' . $latest['latitude'] . '</coordinates>';
        $kml .= '</Point>';
        $kml .= '</Placemark>';

        $kml .= '</Document>';
        $kml .= '</kml>';

        return $kml;
    }
    public function navigation($routes)
    {

        $startingLocation = [
            "latitude" => $routes[0]["startingLatitude"],
            "longitude" => $routes[0]["startingLongitude"],
        ];

        $endingLocation = [
            "latitude" => $routes[0]["endingLatitude"],
            "longitude" => $routes[0]["endingLongitude"],
        ];

        $kml = '<?xml version="1.0" encoding="UTF-8"?>';
        $kml .= '<kml xmlns="http://www.opengis.net/kml/2.2">';
        $kml .= '<Document>';

        $kml .= '<Placemark>';
        $kml .= '<Style>';
        $kml .= '<IconStyle>';
        $kml .= '<Icon>';
        $kml .= '<href>http://maps.google.com/mapfiles/kml/paddle/blue-circle.png</href>';
        $kml .= '</Icon>';
        $kml .= '</IconStyle>';
        $kml .= '</Style>';
        $kml .= '<name>' . htmlspecialchars("Starting Location") . '</name>';
        $kml .= '<Point>';
        $kml .= '<coordinates>' . $startingLocation['longitude'] . ',' . $startingLocation['latitude'] . '</coordinates>';
        $kml .= '</Point>';
        $kml .= '</Placemark>';

        foreach ($routes as $index => $route) {



            $kml .= '<Placemark>';
            $kml .= '<Style>';
            $kml .= '<LineStyle>';
            $kml .= '<width>3</width>';
            $kml .= '<color>' . ColorHelper::hexToArgb(config('constants.colors')[$index], "FF") . '</color>';
            $kml .= '</LineStyle>';
            $kml .= '</Style>';
            $kml .= '<name>' . htmlspecialchars("Route: " . $index + 1) . '</name>';
            $kml .= '<LineString>';
            $kml .= '<coordinates>';

            $segments = Segment::where("route_id", $route->id)->get();

            $kml .= $startingLocation["longitude"] . "," . $startingLocation["latitude"] . ",0\n";

            foreach ($segments as $segment) {
                $kml .= $segment["longitude"] . "," . $segment["latitude"] . ",0\n";
            }

            $kml .= $endingLocation["longitude"] . "," . $endingLocation["latitude"] . ",0\n";


            $kml .= '</coordinates>';
            $kml .= '</LineString>';
            $kml .= '</Placemark>';

        }


        $kml .= '<Placemark>';
        $kml .= '<name>' . htmlspecialchars("Ending Location") . '</name>';
        $kml .= '<Style>';
        $kml .= '<IconStyle>';
        $kml .= '<Icon>';
        $kml .= '<href>http://maps.google.com/mapfiles/kml/paddle/red-circle.png</href>';
        $kml .= '</Icon>';
        $kml .= '</IconStyle>';
        $kml .= '</Style>';
        $kml .= '<Point>';
        $kml .= '<coordinates>' . $endingLocation['longitude'] . ',' . $endingLocation['latitude'] . '</coordinates>';
        $kml .= '</Point>';
        $kml .= '</Placemark>';

        $kml .= '</Document>';
        $kml .= '</kml>';

        return $kml;
    }





}
