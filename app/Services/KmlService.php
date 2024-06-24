<?php

namespace App\Services;

class KmlService
{

    public static $colors = [
        "ff0000ff", // Red
        "ff00ff00", // Green
        "ffff0000", // Blue
        "ffffff00", // Cyan
        "ffff00ff", // Magenta
        "ff00ffff", // Yellow
        "ff000000", // Black
        "ff888888", // Gray
        "ffffffff", // White
        "ff00aaff"  // Light Blue
    ];


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
    public function navigation($startingLocation, $endingLocation, $routes)
    {
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
            $kml .= '<width>2</width>';
            $kml .= '<color>' . self::$colors[$index] . '</color>';
            $kml .= '</LineStyle>';
            $kml .= '</Style>';
            $kml .= '<name>' . htmlspecialchars("Segment: " . $index + 1) . '</name>';
            $kml .= '<description>' . htmlspecialchars("Slope: " . $route["slope"] . " - " . "Speed: " . $route["speed"]) . '</description>';
            $kml .= '<LineString>';
            $kml .= '<coordinates>';
            $kml .= $route[$index]["longitude"] . "," . $route[$index]["latitude"] . ",0\n";
            $kml .= $route[$index + 1]["longitude"] . "," . $route[$index + 1]["latitude"] . ",0\n";
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
            $kml .= '<description>' . htmlspecialchars("Slope: " . $route["slope"] . " - " . "Speed: " . $route["speed"]) . '</description>';
            $kml .= '<LineString>';
            $kml .= '<coordinates>';
            $kml .= $route[$index]["longitude"] . "," . $route[$index]["latitude"] . ",0\n";
            $kml .= $route[$index + 1]["longitude"] . "," . $route[$index + 1]["latitude"] . ",0\n";
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
