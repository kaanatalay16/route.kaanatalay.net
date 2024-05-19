<?php

namespace App\Filament\Resources\RouteResource\RelationManagers;

use Carbon\CarbonInterval;
use Cheesegrits\FilamentGoogleMaps\Actions\StaticMapAction;
use Cheesegrits\FilamentGoogleMaps\Columns\MapColumn;
use Cheesegrits\FilamentGoogleMaps\Fields\Map;
use Cheesegrits\FilamentGoogleMaps\Infolists\MapEntry;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;



class PathsRelationManager extends RelationManager
{
    protected static string $relationship = 'paths';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('lengthInMeters')
                    ->required()
                    ->maxLength(255)
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([

                Tables\Columns\TextColumn::make('index'),
                Tables\Columns\TextColumn::make('cost')->sortable()->formatStateUsing(fn($state): string => number_format($state, 2) . " (C)")->label("Cost"),
                Tables\Columns\TextColumn::make('lengthInMeters')->sortable()->formatStateUsing(fn($state): string => number_format($state / 1000, 2) . " km")->label("Distance"),
                Tables\Columns\TextColumn::make('travelTimeInSeconds')->sortable()->formatStateUsing(fn($state): string => CarbonInterval::seconds($state)->cascade()->forHumans(short: true))->label("Travel Time"),
                Tables\Columns\TextColumn::make('trafficDelayInSeconds')->sortable()->formatStateUsing(fn($state): string => "+" . CarbonInterval::seconds($state)->cascade()->forHumans(short: true))->color("danger")->label("Travel Delay"),
                Tables\Columns\TextColumn::make('trafficLengthInMeters')->sortable()->formatStateUsing(fn($state): string => "+" . number_format($state / 1000, 2) . " km")->color("danger")->label("Traffic Length"),
                Tables\Columns\TextColumn::make('averageSpeed')->label("Average Speed ")->formatStateUsing(fn($state): string => number_format($state, 2) . " km/h")->color("primary"),


                // Tables\Columns\TextColumn::make('arrivalTime')->sortable()->datetime()->label("Arrival Time"),
                TextColumn::make('tags')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'fastest' => 'primary',
                        'shortest' => 'warning',
                        "optimum" => "success",
                        default => "gray"
                    })
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ])->paginated(false)->description("Optimum path is selecting by cost value.");
    }
}
