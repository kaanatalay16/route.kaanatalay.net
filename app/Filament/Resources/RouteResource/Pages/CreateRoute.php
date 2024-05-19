<?php

namespace App\Filament\Resources\RouteResource\Pages;

use App\Filament\Resources\RouteResource;
use App\Location;
use App\Models\Path;
use App\Models\Vehicle;
use App\TomTom;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Storage;



class CreateRoute extends CreateRecord
{
    protected static string $resource = RouteResource::class;


    protected function handleRecordCreation(array $data): Model
    {

        $startingLocation = new Location($data["startingLocation"]["lat"], $data["startingLocation"]["lng"]);
        $endingLocation = new Location($data["endingLocation"]["lat"], $data["endingLocation"]["lng"]);

        $vehicleQueries = collect([]);
        if ($data["vehicle_id"]) {
            $vehicleQueries = collect(Vehicle::find($data["vehicle_id"]))->except(["id", "name", "created_at", "updated_at", "image"]);
        }

        $response = TomTom::calculateRoute($startingLocation, $endingLocation, $vehicleQueries);
        if (!$response) {
            Notification::make()
                ->title('Error')
                ->danger()
                ->send();
            $this->halt();
        }
        $paths = $response["routes"];

        $result = static::getModel()::create($data);


        $pathData = collect();
        foreach ($paths as $index => $path) {
            $cost = ((($path["summary"]["lengthInMeters"] / 1000.0) / $path["summary"]["travelTimeInSeconds"] / 60.0) * (($path["summary"]["lengthInMeters"] / 1000.0) / $path["summary"]["travelTimeInSeconds"] / 60.0)) + ($path["summary"]["travelTimeInSeconds"] / 60.0);
            $pathData->push([
                "index" => $index + 1,
                "route_id" => $result["id"],
                "lengthInMeters" => $path["summary"]["lengthInMeters"],
                "travelTimeInSeconds" => $path["summary"]["travelTimeInSeconds"],
                "trafficDelayInSeconds" => $path["summary"]["trafficDelayInSeconds"],
                "trafficLengthInMeters" => $path["summary"]["trafficLengthInMeters"],
                "departureTime" => $path["summary"]["departureTime"],
                "arrivalTime" => $path["summary"]["arrivalTime"],
                "legs" => $path["legs"],
                "cost" => $cost,
                "tags" => collect()
            ]);
        }

        $pathData->where('travelTimeInSeconds', $pathData->min('travelTimeInSeconds'))->first()["tags"]->push("fastest");
        $pathData->where('lengthInMeters', $pathData->min('lengthInMeters'))->first()["tags"]->push("shortest");
        $pathData->where('cost', $pathData->min('cost'))->first()["tags"]->push("optimum");

        foreach ($pathData as $data) {
            $pathId = Path::create($data)->id;
            $json = json_encode(Tomtom::createGeoJSONFile(Path::find($pathId)));
            Storage::put("public/geojsons/" . $pathId . ".geojson", $json);
        }

        return $result;
    }
}
