<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NewRouteResource\Pages;
use App\Filament\Resources\NewRouteResource\RelationManagers;
use App\Models\NewRoute;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Cheesegrits\FilamentGoogleMaps\Fields\Map;


class NewRouteResource extends Resource
{
    protected static ?string $model = NewRoute::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
                Tables\Columns\TextColumn::make('startingLatitude')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('startingLongitude')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('endingLatitude')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('endingLongitude')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
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
            'index' => Pages\ListNewRoutes::route('/'),
            'create' => Pages\CreateNewRoute::route('/create'),
            'view' => Pages\ViewNewRoute::route('/{record}'),
            // 'edit' => Pages\EditNewRoute::route('/{record}/edit'),
        ];
    }
}
