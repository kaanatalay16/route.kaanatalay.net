<?php

namespace App\Filament\Resources\NavigationResource\Pages;

use App\Filament\Resources\NavigationResource;
use App\Filament\Resources\RouteResource;
use Carbon\Carbon;
use Cheesegrits\FilamentGoogleMaps\Infolists\MapEntry;
use Filament\Actions;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Infolist;


class ViewNavigation extends ViewRecord
{
    protected static string $resource = NavigationResource::class;

    public function infolist(Infolist $infolist): Infolist
    {



        return $infolist
            ->schema([
                MapEntry::make('path')
                    ->layers([
                        "https://route.kaanatalay.net/api/kml/navigation/" . $this->record->id . "/" . Carbon::now()->getTimestampMs()
                    ])
                    ->height("400px")
                    ->columnSpan(2),
            ]);
    }

    protected function getFooterWidgets(): array
    {

        $biggestTimeIndex = 0;
        $biggestTime = 0;


        foreach ($this->record->routes as $index => $route) {

            $timeArray = [...$route->graph->time];
            $end = end($timeArray);
            if ($end > $biggestTime) {
                $biggestTime = $end;
                $biggestTimeIndex = $index;
            }
        }


        $agingDatasets = [];
        $batteryPower = [];
        $drivingProfile = [];
        $totalCellPowerEnergyConsumption = [];
        $soc = [];
        $distance = [];
        $time = $this->record->routes[$biggestTimeIndex]->graph->time;


        foreach ($this->record->routes as $index => $route) {
            array_push(
                $agingDatasets,
                [
                    "label" => "Route: " . $index + 1,
                    "data" => $route->graph->capacityRetention,
                    "borderColor" => $route->color,
                    "tension" => 0,
                    "pointRadius" => 0,
                    "borderWidth" => 1.5
                ]
            );

            array_push(
                $batteryPower,
                [
                    "label" => "Route: " . $index + 1,
                    "data" => $route->graph->batteryPower,
                    "borderColor" => $route->color,

                    "tension" => 0,
                    "pointRadius" => 0,
                    "borderWidth" => 1.5
                ]
            );

            array_push(
                $soc,
                [
                    "label" => "Route: " . $index + 1,
                    "data" => $route->graph->soc,
                    "borderColor" => $route->color,

                    "tension" => 0,
                    "pointRadius" => 0,
                    "borderWidth" => 1.5
                ]
            );

            array_push(
                $drivingProfile,
                [
                    "label" => "Route: " . $index + 1,
                    "data" => $route->graph->drivingProfile,
                    "borderColor" => $route->color,
                    "tension" => 0,
                    "pointRadius" => 0,
                    "borderWidth" => 1.5
                ]
            );

            array_push(
                $totalCellPowerEnergyConsumption,
                [
                    "label" => "Route: " . $index + 1,
                    "data" => $route->graph->totalCellPowerEnergyConsumption,
                    "borderColor" => $route->color,
                    "tension" => 0,
                    "pointRadius" => 0,
                    "borderWidth" => 1.5
                ]
            );

            array_push(
                $distance,
                [
                    "label" => "Route: " . $index + 1,
                    "data" => $route->graph->distance,
                    "borderColor" => $route->color,
                    "tension" => 0,
                    "pointRadius" => 0,
                    "borderWidth" => 1.5
                ]
            );



        }

        return [
            RouteResource\Widgets\LineChart::make([
                "title" => "Aging Graph",
                "label" => "Capacity Retention (%)",
                "info" => "Shows the decrease in battery capacity over time",
                "datasets" => $agingDatasets,
                "labelData" => $time,
            ])
            ,
            RouteResource\Widgets\LineChart::make([
                "title" => "SoC Graph",
                "label" => "%",
                "info" => "Depicts the state of charge (SoC) of the battery decreasing over time.",
                "datasets" => $soc,
                "labelData" => $time,
            ]),
            RouteResource\Widgets\LineChart::make([
                "title" => "Battery Power",
                "label" => "kw",
                "info" => "Illustrates the power output of the battery over time.",
                "datasets" => $batteryPower,
                "labelData" => $time,
            ]),
            RouteResource\Widgets\LineChart::make([
                "title" => "Driving Profile",
                "label" => "km/h",
                "info" => "Displays the vehicle's speed variations over time.",
                "datasets" => $drivingProfile,
                "labelData" => $time,
            ]),
            RouteResource\Widgets\LineChart::make([
                "title" => "Total Energy Consumption",
                "label" => "kWh",
                "info" => "Represents the cumulative energy consumption over time.",
                "datasets" => $totalCellPowerEnergyConsumption,
                "labelData" => $time,
            ]),
            RouteResource\Widgets\LineChart::make([
                "title" => "Distance",
                "label" => "Covered Distance (m)",
                "info" => "Shows the distance covered by the vehicle over time.",
                "datasets" => $distance,
                "labelData" => $time,
            ]),
        ];
    }

}
