<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RouteResource\Pages;
use App\Filament\Resources\RouteResource\RelationManagers;
use App\Filament\Resources\RouteResource\Widgets\LineChart;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Cheesegrits\FilamentGoogleMaps\Fields\Map;
use Cheesegrits\FilamentGoogleMaps\Columns\MapColumn;



class RouteResource extends Resource
{

    protected static ?string $navigationIcon = 'heroicon-o-paper-airplane';
    protected static ?int $navigationSort = 1;



    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Map::make('startingLocation')
                    ->hint("Click Anywhere or Drag the Marker to Change Location")
                    ->defaultLocation([40.95803163587476, 29.136638199160473])
                    ->mapControls([
                        'mapTypeControl' => false,
                        'scaleControl' => true,
                        'streetViewControl' => false,
                        'rotateControl' => true,
                        'fullscreenControl' => true,
                        'searchBoxControl' => false, // creates geocomplete field inside map
                        'zoomControl' => true,
                    ])
                    ->autocomplete('full_address') // field on form to use as Places geocompletion field
                    ->autocompleteReverse(true) // reverse geocode marker location to autocomplete field
                    ->reverseGeocode([
                        'street' => '%n %S',
                        'city' => '%L',
                        'state' => '%A1',
                        'zip' => '%z',
                    ]) // reverse geocode marker location to form fields, see notes below
                    ->defaultZoom(12) // default zoom level when opening form
                    ->draggable() // allow dragging to move marker
                    ->clickable(true) // allow clicking to move marker




                ,
                Map::make('endingLocation')
                    ->hint("Click Anywhere or Drag the Marker to Change Location")

                    ->defaultLocation([41.105550831013296, 29.023104827095462])

                    ->mapControls([
                        'mapTypeControl' => false,
                        'scaleControl' => true,
                        'streetViewControl' => false,
                        'rotateControl' => true,
                        'fullscreenControl' => true,
                        'searchBoxControl' => false, // creates geocomplete field inside map
                        'zoomControl' => true,
                    ])
                    ->autocomplete('full_address') // field on form to use as Places geocompletion field
                    ->autocompleteReverse(true) // reverse geocode marker location to autocomplete field
                    ->reverseGeocode([
                        'street' => '%n %S',
                        'city' => '%L',
                        'state' => '%A1',
                        'zip' => '%z',
                    ]) // reverse geocode marker location to form fields, see notes below
                    ->defaultZoom(12) // default zoom level when opening form
                    ->draggable() // allow dragging to move marker
                    ->clickable(true) // allow clicking to move marker
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Tables\Columns\TextColumn::make('startingLatitude')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('startingLongitude')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('endingLatitude')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('endingLongitude')
                //     ->numeric()
                //     ->sortable(),
                // MapColumn::make('startingLocation'),
                Tables\Columns\TextColumn::make('segments_count')
                    ->counts("segments")
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->since()
                    ->sortable()
                ,

            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\SegmentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRoutes::route('/'),
            'create' => Pages\CreateRoute::route('/create'),
            'view' => Pages\ViewRoute::route('/{record}'),
            // 'edit' => Pages\EditRoute::route('/{record}/edit'),
        ];
    }

    public static function getWidgets(): array
    {
        return [
            LineChart::class
        ];
    }
}
