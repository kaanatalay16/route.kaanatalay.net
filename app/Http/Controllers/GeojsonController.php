<?php

namespace App\Http\Controllers;

use App\Models\Segment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GeojsonController extends Controller
{
    public function newRoute($id)
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
                "coordinates" => collect(Segment::where("new_route_id", $id)->get())->map(function ($item) {
                    return [$item["longitude"], $item["latitude"]];
                }),
                "type" => "LineString"
            ]
        ]);

        return response($data);


    }
}
