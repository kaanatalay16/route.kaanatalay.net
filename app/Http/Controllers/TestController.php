<?php

namespace App\Http\Controllers;

use App\Facades\GoogleMaps;
use App\Facades\Route;
use App\Location;
use App\Models\Path;
use App\Models\Segment;
use App\Models\Vehicle;
use App\TomTom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use App\Services\ElevationService;
use Illuminate\Support\Facades\Process;




class TestController extends Controller
{

    public function index()
    {

        $result = Process::path(Storage::path("python"))->run('python3 main.py ' . Segment::where("new_route_id", 6)->pluck("speed"));
        if ($result->errorOutput()) {
            return $result->errorOutput();
        }
        return Storage::response("python/distance.png");




    }
}
