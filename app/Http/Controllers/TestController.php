<?php

namespace App\Http\Controllers;

use App\Facades\GoogleMaps;
use App\Facades\Kml;
use App\Helpers\ColorHelper;
use App\Models\Graph;
use App\Models\Route;
use App\Location;
use App\Models\Path;
use App\Models\Segment;
use App\Models\Vehicle;
use App\TomTom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Services\ElevationService;
use Illuminate\Support\Facades\Process;




class TestController extends Controller
{

    public function index()
    {

        return ColorHelper::hexToArgb(config('constants.colors')[1], "FF");
    }
}
