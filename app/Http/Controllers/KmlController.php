<?php

namespace App\Http\Controllers;

use App\Facades\Kml;
use App\Models\Route;
use App\Models\Segment;
use Illuminate\Http\Request;

class KmlController extends Controller
{
    public function route($id)
    {
        return Kml::create(Segment::where("route_id", $id)->get());

    }

    public function navigation($id)
    {
        return Kml::navigation(Route::where("navigation_id", $id)->get());

    }
}
