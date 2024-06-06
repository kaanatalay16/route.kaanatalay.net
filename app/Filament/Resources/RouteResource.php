<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RouteResource\Pages;
use App\Filament\Resources\RouteResource\RelationManagers;
use App\Models\Route;
use Cheesegrits\FilamentGoogleMaps\Fields\Map;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Cheesegrits\FilamentGoogleMaps\Columns\MapColumn;


class RouteResource extends Resource
{
    protected static ?string $model = Route::class;

    protected static ?string $navigationIcon = 'heroicon-o-paper-airplane';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('vehicle_id')
                    ->relationship('vehicle', 'name')
                    ->columnSpanFull()
                    ->searchable()
                    ->preload(),                // Forms\Components\TextInput::make('maxAlternatives')
                //     ->required()
                //     ->numeric(),
                // Forms\Components\TextInput::make('startingLatitude')
                //     ->required()
                //     ->numeric(),
                // Forms\Components\TextInput::make('startingLongitude')
                //     ->required()
                //     ->numeric(),
                // Forms\Components\TextInput::make('endingLatitude')
                //     ->required()
                //     ->numeric(),
                // Forms\Components\TextInput::make('endingLongitude')
                //     ->required()
                //     ->numeric(),


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
                ,
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('vehicle.image')->circular()->label("Photo"),
                Tables\Columns\TextColumn::make('vehicle.name')->placeholder("Undefined"),
                // Tables\Columns\TextColumn::make('maxAlternatives')
                //     ->numeric()
                //     ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()

            ])
            ->filters([
                //
            ])
            ->actions([

                Tables\Actions\DeleteAction::make(),
                // Tables\Actions\EditAction::make(),
                // Tables\Actions\ViewAction::make(),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
        ;
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\PathsRelationManager::class,
            // RelationManagers\VehicleRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRoutes::route('/'),
            'create' => Pages\CreateRoute::route('/create'),
            'view' => Pages\ViewRoute::route('/{record}'),
            'sort' => Pages\SortRoutes::route('/sort'),
            // 'edit' => Pages\EditRoute::route('/{record}/edit'),
        ];
    }


}
