<?php

namespace App\Filament\Resources\NavigationResource\Pages;

use App\Filament\Resources\NavigationResource;
use App\Location;
use App\Facades\Route;
use App\Models\Graph;
use App\Models\Segment;
use App\Models\Route as RouteModel;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Storage;

class CreateNavigation extends CreateRecord
{
    protected static string $resource = NavigationResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $startingLocation = new Location($data["startingLocation"]["lat"], $data["startingLocation"]["lng"]);
        $endingLocation = new Location($data["endingLocation"]["lat"], $data["endingLocation"]["lng"]);

        $result = static::getModel()::create($data);



        $routes = Route::createRoute(
            $startingLocation->latitude,
            $startingLocation->longitude,
            $endingLocation->latitude,
            $endingLocation->longitude,
            $data["route_count"]
        );

        $routeIds = [];

        foreach ($routes as $route) {

            $routeRow = RouteModel::create(
                [
                    "navigation_id" => $result->id,
                    "startingLatitude" => $data["startingLocation"]["lat"],
                    "startingLongitude" => $data["startingLocation"]["lng"],
                    "endingLatitude" => $data["endingLocation"]["lat"],
                    "endingLongitude" => $data["endingLocation"]["lng"],
                ]
            );

            array_push($routeIds, $routeRow->id);

            foreach ($route as $index => $segment) {

                if ($index == (count($route) - 1)) {
                    break;
                }

                Segment::create([
                    "route_id" => $routeRow->id,
                    "latitude" => $segment["lat"],
                    "longitude" => $segment["long"],
                    "speed" => $segment["speed"] ?? null,
                    "slope" => $segment["slope"] ?? null,
                ]);
            }

        }

        foreach ($routeIds as $routeId) {

            $speeds = Segment::where("route_id", $routeId)->pluck("speed");
            $lats = Segment::where("route_id", $routeId)->pluck("latitude");
            $longs = Segment::where("route_id", $routeId)->pluck("longitude");



            $command = '/bin/python3 main.py ' . $speeds . " " . $lats . " " . $longs;
            $result = Process::path(Storage::path("python"))->run($command);
            // $result = Process::path(Storage::path("python"))->run('/bin/python3 main.py [15,25,45] [41.25051,41.25111,41.25111] [29.54,29.54,29.541]');
            // $result = Process::path(Storage::path("python"))->run('/bin/python3 main.py /bin/python3 main.py [51,51,51] [40.95774,40.95781,40.95785] [29.13587,29.13582,29.13577] ');

            $output = json_decode($result->output());


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




        return $result;
    }

}
