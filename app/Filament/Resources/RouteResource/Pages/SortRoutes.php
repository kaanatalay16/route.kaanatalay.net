<?php

namespace App\Filament\Resources\RouteResource\Pages;

use App\Filament\Resources\RouteResource;
use Filament\Resources\Pages\Page;

class SortRoutes extends Page
{
    protected static string $resource = RouteResource::class;
    protected static ?string $navigationLabel = 'Custom Navigation Label';




    protected static ?string $cluster = Create::class;







    protected static string $view = 'filament.resources.route-resource.pages.sort-routes';
}
