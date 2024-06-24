<?php

namespace App\Filament\Resources\RouteResource\Pages;

use App\Filament\Resources\RouteResource;
use App\Filament\Resources\RouteResource\Widgets\DrivingProfile;
use Carbon\Carbon;
use Cheesegrits\FilamentGoogleMaps\Infolists\MapEntry;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\KeyValueEntry;
use Filament\Infolists\Components\Fieldset;

use Filament\Infolists\Components\Actions\Action;
use Filament\Infolists\Components\Section;
use Filament\Support\Enums\FontWeight;
use Filament\Infolists\Components\Grid;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\HtmlString;
use Filament\Infolists\Components\ViewEntry;
use Illuminate\Database\Eloquent\Model;

use Filament\Infolists\Components\Tabs;

use Filament\Infolists\Components\View;












class ViewRoute extends ViewRecord
{
    protected static string $resource = RouteResource::class;
    protected static bool $isLazy = false;






    protected function getFooterWidgets(): array
    {
        return [
            RouteResource\Widgets\LineChart::make([
                "title" => "Aging Graph",
                "label" => "Capacity Retention (%)",
                "info" => "Shows the decrease in battery capacity over time",
                "data" => $this->record->graph?->capacityRetention ?? [],
                "labelData" => $this->record->graph?->time ?? [],
            ])
            ,
            RouteResource\Widgets\LineChart::make([
                "title" => "SoC Graph",
                "label" => "%",
                "info" => "Depicts the state of charge (SoC) of the battery decreasing over time.",
                "data" => $this->record->graph?->soc ?? [],
                "labelData" => $this->record->graph?->time ?? [],

            ]),
            RouteResource\Widgets\LineChart::make([
                "title" => "Battery Power",
                "label" => "kw",
                "info" => "Illustrates the power output of the battery over time.",
                "data" => $this->record->graph?->batteryPower ?? [],
                "labelData" => $this->record->graph?->time ?? [],
            ]),
            RouteResource\Widgets\LineChart::make([
                "title" => "Driving Profile",
                "label" => "km/h",
                "info" => "Displays the vehicle's speed variations over time.",
                "data" => $this->record->graph?->drivingProfile ?? [],
                "labelData" => $this->record->graph?->time ?? [],
            ]),
            RouteResource\Widgets\LineChart::make([
                "title" => "Total Energy Consumption",
                "label" => "kWh",
                "info" => "Represents the cumulative energy consumption over time.",
                "data" => $this->record->graph?->totalCellPowerEnergyConsumption ?? [],
                "labelData" => $this->record->graph?->time ?? [],
            ]),
            RouteResource\Widgets\LineChart::make([
                "title" => "Distance",
                "label" => "Covered Distance (m)",
                "info" => "Shows the distance covered by the vehicle over time.",
                "data" => $this->record->graph?->distance ?? [],
                "labelData" => $this->record->graph?->time ?? [],
            ]),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {

        return $infolist
            ->schema([

                // MapEntry::make('startingLocation')->defaultZoom(13),
                // MapEntry::make('endingLocation')->defaultZoom(13),


                MapEntry::make('path')
                    ->layers(fn($record) => [
                        "https://route.kaanatalay.net/api/kml/route/" . $record->id . "/" . Carbon::now()->getTimestampMs(),
                        // "https://developers.google.com/kml/documentation/KML_Samples.kml"
                    ])
                    ->height("400px")
                    ->columnSpan(2),




                TextEntry::make('created_at')
                    ->dateTime(),


            ]);


    }



}
