<?php

namespace App\Filament\Resources\NavigationResource\Pages;

use App\Filament\Resources\NavigationResource;
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

}
