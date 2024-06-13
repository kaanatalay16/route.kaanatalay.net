<?php

namespace App\Filament\Resources\NewRouteResource\Pages;

use App\Filament\Resources\NewRouteResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListNewRoutes extends ListRecords
{
    protected static string $resource = NewRouteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
