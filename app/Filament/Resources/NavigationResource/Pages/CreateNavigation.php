<?php

namespace App\Filament\Resources\NavigationResource\Pages;

use App\Filament\Resources\NavigationResource;
use App\Location;
use App\Facades\Route;
use App\Models\Segment;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateNavigation extends CreateRecord
{
    protected static string $resource = NavigationResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $startingLocation = new Location($data["startingLocation"]["lat"], $data["startingLocation"]["lng"]);
        $endingLocation = new Location($data["endingLocation"]["lat"], $data["endingLocation"]["lng"]);



        $result = static::getModel()::create($data);



        $segments = Route::createRoute(
            $startingLocation->latitude,
            $startingLocation->longitude,
            $endingLocation->latitude,
            $endingLocation->longitude,
            $data["route_count"]
        );


        foreach ($segments as $segment) {
            Segment::create([
                "route_id" => $result["id"],
                "latitude" => $segment["lat"],
                "longitude" => $segment["long"],
                "speed" => $segment["speed"] ?? null,
                "slope" => $segment["slope"] ?? null,
            ]);
        }




        return $result;
    }

}
