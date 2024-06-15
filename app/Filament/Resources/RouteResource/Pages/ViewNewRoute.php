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












class ViewNewRoute extends ViewRecord
{
    protected static string $resource = RouteResource::class;




    public function infolist(Infolist $infolist): Infolist
    {

        return $infolist
            ->schema([

                MapEntry::make('startingLocation')->defaultZoom(13),
                MapEntry::make('endingLocation')->defaultZoom(13),


                MapEntry::make('startingLocation')
                    ->geoJson(fn($record) => "https://route.kaanatalay.net/api/geojsons/route/" . $record->id)
                    ->defaultZoom(12)
                    ->height("400px")
                    ->label("Route")
                    ->columnSpan(2),


                TextEntry::make('created_at')
                    ->dateTime(),
            ]);
    }


}
