<?php

namespace App\Http\Controllers;

use App\Facades\GoogleMaps;
use App\Facades\Kml;
use App\Models\Graph;
use App\Models\Route;
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
        $routeId = 19;

        $speeds = Segment::where("route_id", $routeId)->pluck("speed");


        $lats = Segment::where("route_id", $routeId)->pluck("latitude");


        $longs = Segment::where("route_id", $routeId)->pluck("longitude");






        $command = '/bin/python3 main.py ' . $speeds . " " . $lats . " " . $longs;
        $result = Process::path(Storage::path("python"))->run($command);
        // $result = Process::path(Storage::path("python"))->run('/bin/python3 main.py [15,25,45] [41.25051,41.25111,41.25111] [29.54,29.54,29.541]');
        // $result = Process::path(Storage::path("python"))->run('/bin/python3 main.py /bin/python3 main.py [51,51,51] [40.95774,40.95781,40.95785] [29.13587,29.13582,29.13577] ');

        $output = json_decode($result->output());


        return $output;

        Graph::create([
            "route_id" => $routeId,
            "time" => $output->time,
            "distance" => $output->distance,
            "totalCellPowerEnergyConsumption" => $output->totalCellPowerEnergyConsumption,
            "drivingProfile" => $output->drivingProfile,
            "batteryPower" => $output->batteryPower,
            "soc" => $output->soc,
            "capacityRetention" => $output->capacityRetention,
        ]);



    }
}
