<?php

namespace App\Filament\Resources\RouteResource\Pages;

use App\Facades\Route;
use App\Filament\Resources\RouteResource;
use App\Location;
use App\Models\Segment;
use App\TomTom;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;


class CreateRoute extends CreateRecord
{
    protected static string $resource = RouteResource::class;

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

    protected function beforeFill(): void
    {
        // Runs before the form fields are populated with their default values.
    }

    protected function afterFill(): void
    {
        // Runs after the form fields are populated with their default values.
    }

    protected function beforeValidate(): void
    {
        // Runs before the form fields are validated when the form is submitted.
    }

    protected function afterValidate(): void
    {
        // Runs after the form fields are validated when the form is submitted.
    }

    protected function beforeCreate(): void
    {
        Notification::make()
            ->title('API erişim hakkı kalmadı')
            ->danger()
            ->color("danger")
            ->body('Ücretsiz 2 adet rota oluşturma hakkı var, api erişim hakkı kalmadı.')
            ->send();

        $this->halt();
    }

    protected function afterCreate(): void
    {
        // Runs after the form fields are saved to the database.
    }
}
