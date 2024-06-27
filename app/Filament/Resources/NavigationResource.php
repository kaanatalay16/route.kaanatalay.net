<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NavigationResource\Pages;
use App\Filament\Resources\NavigationResource\RelationManagers;
use App\Filament\Resources\NavigationResource\RelationManagers\RoutesRelationManager;
use App\Filament\Resources\RouteResource\Widgets\LineChart;
use App\Models\Navigation;
use Cheesegrits\FilamentGoogleMaps\Fields\Map;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;


class NavigationResource extends Resource
{
    protected static ?string $model = Navigation::class;

    protected static ?string $navigationIcon = 'heroicon-o-map';

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
                    ->defaultZoom(12) // default zoom level when opening form
                    ->draggable() // allow dragging to move marker
                    ->clickable(true) // allow clicking to move marker
                ,

                Select::make('route_count')
                    ->label("Route Count")
                    ->options([
                        '1' => '1',
                        '2' => '2',
                        '3' => '3',
                        '4' => '4',
                        '5' => '5',
                        '6' => '6',
                    ])->columnSpanFull()->default(3)
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
                    ->since()
                    ->sortable()

            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RoutesRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListNavigations::route('/'),
            'create' => Pages\CreateNavigation::route('/create'),
            'view' => Pages\ViewNavigation::route('/{record}'),

            // 'edit' => Pages\EditNavigation::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->orderByDesc("id");
    }

    public static function getWidgets(): array
    {
        return [
            LineChart::class
        ];
    }


}
