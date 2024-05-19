<?php

namespace App\Filament\Resources\RouteResource\Pages;

use App\Filament\Resources\RouteResource;
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
use Filament\Infolists\Components\Tabs;

use Filament\Infolists\Components\View;











class ViewRoute extends ViewRecord
{
    protected static string $resource = RouteResource::class;




    public function infolist(Infolist $infolist): Infolist
    {

        return $infolist
            ->schema([
                TextEntry::make('created_at')
                    ->dateTime()
                    ->helperText(new HtmlString('Paths created by <a href="https://developer.tomtom.com/routing-api/api-explorer"><strong>TomTom Route API (Calculate Route GET)</strong></a>.'))
                ,

                Section::make('Vehicle')
                    ->hidden(fn($record) => !$record->vehicle?->name)
                    ->description(fn($record): string => $record->vehicle->name)

                    ->headerActions([


                    ])
                    ->schema([

                        ImageEntry::make('vehicle.image')->columnSpanFull()->circular(),
                        TextEntry::make('vehicle.name')->label("Name"),
                        TextEntry::make('vehicle.vehicleMaxSpeed')->label("Max Speed"),
                        TextEntry::make('vehicle.vehicleWeight')->label("Weight"),
                        TextEntry::make('vehicle.vehicleAxleWeight')->label("AxleWeight"),
                        TextEntry::make('vehicle.vehicleNumberOfAxles')->label("Number of Axles"),
                        TextEntry::make('vehicle.vehicleLength')->label("Vehicle Length"),
                        TextEntry::make('vehicle.vehicleWidth')->label("Vehicle Width"),
                        TextEntry::make('vehicle.vehicleHeight')->label("Vehicle Height"),
                        TextEntry::make('vehicle.vehicleEngineType')->label("Vehicle Engine Type"),



                    ])
                    ->columns(4)
                    ->collapsed(),
                Tabs::make('Tabs')

                    ->tabs([
                        Tabs\Tab::make("Route ID: 1")
                            ->schema([
                                MapEntry::make('startingLocation')
                                    ->geoJson(fn($record) => "https://route.kaanatalay.net/storage/geojsons/" . $record->paths[0]->id . ".geojson")
                                    ->defaultZoom(12)
                                    ->height("400px")
                                    ->columnSpan(2),

                            ]),
                        Tabs\Tab::make("Route ID: 2")
                            ->schema([
                                MapEntry::make('startingLocation')

                                    ->geoJson(fn($record) => "https://route.kaanatalay.net/storage/geojsons/" . $record->paths[1]->id . ".geojson")
                                    ->defaultZoom(12)
                                    ->height("400px")

                                    ->columnSpan(2),
                            ]),
                        Tabs\Tab::make("Route ID: 3")
                            ->schema([
                                MapEntry::make('startingLocation')
                                    ->geoJson(fn($record) => "https://route.kaanatalay.net/storage/geojsons/" . $record->paths[2]->id . ".geojson")
                                    ->defaultZoom(12)
                                    ->height("400px")

                                    ->columnSpan(2),
                            ]),
                        Tabs\Tab::make("Route ID: 4")
                            ->schema([
                                MapEntry::make('startingLocation')
                                    ->geoJson(fn($record) => "https://route.kaanatalay.net/storage/geojsons/" . $record->paths[3]->id . ".geojson")
                                    ->defaultZoom(12)
                                    ->height("400px")

                                    ->columnSpan(2),
                            ]),
                        Tabs\Tab::make("Route ID: 5")
                            ->schema([
                                MapEntry::make('startingLocation')
                                    ->geoJson(fn($record) => "https://route.kaanatalay.net/storage/geojsons/" . $record->paths[4]->id . ".geojson")
                                    ->defaultZoom(12)
                                    ->height("400px")

                                    ->columnSpan(2),
                            ]),
                        Tabs\Tab::make("Route ID: 6")
                            ->schema([
                                MapEntry::make('startingLocation')
                                    ->geoJson(fn($record) => "https://route.kaanatalay.net/storage/geojsons/" . $record->paths[5]->id . ".geojson")
                                    ->defaultZoom(12)
                                    ->height("400px")

                                    ->columnSpan(2),
                            ]),
                    ])->columnSpanFull(),









            ]);
    }


}
