<?php

namespace App\Filament\Resources\RouteResource\Pages;

use App\Filament\Resources\RouteResource;
use Filament\Resources\Pages\Page;

class NewRoute extends Page
{
    protected static string $resource = RouteResource::class;

    protected static string $view = 'filament.resources.route-resource.pages.new-route';
}
