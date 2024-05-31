<?php

namespace App\Http\Controllers;

use App\Facades\GoogleMaps;
use App\Facades\Route;
use App\Location;
use App\Models\Path;
use App\Models\Vehicle;
use App\TomTom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use App\Services\ElevationService;



class TestController extends Controller
{

    public function index()
    {

        $routeSegments = Route::createRoute("40.958031635875", "29.13663819916", "41.105550831013", "29.023104827095");

        return response()->json($routeSegments);


    }
}
