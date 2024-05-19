<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VehicleResource\Pages;
use App\Filament\Resources\VehicleResource\RelationManagers;
use App\Models\Vehicle;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VehicleResource extends Resource
{
    protected static ?string $model = Vehicle::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('image')
                    ->image()->columnSpanFull(),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('vehicleMaxSpeed')
                    ->required()
                    ->maxValue(250)
                    ->minValue(10)
                    ->numeric()
                    ->integer()
                ,
                Forms\Components\TextInput::make('vehicleWeight')
                    ->required()
                    ->integer()

                    ->numeric(),
                Forms\Components\TextInput::make('vehicleAxleWeight')
                    ->required()
                    ->integer()

                    ->numeric(),
                Forms\Components\TextInput::make('vehicleNumberOfAxles')
                    ->required()
                    ->integer()

                    ->numeric(),
                Forms\Components\TextInput::make('vehicleLength')

                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('vehicleWidth')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('vehicleHeight')
                    ->required()
                    ->numeric(),
                Forms\Components\Select::make('vehicleEngineType')
                    ->required()
                    ->options([
                        "electric" => "Electric",
                        "combustion" => "Combustion"
                    ])

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')->circular(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),

                Tables\Columns\TextColumn::make('vehicleMaxSpeed')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('vehicleWeight')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('vehicleAxleWeight')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('vehicleNumberOfAxles')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('vehicleLength')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('vehicleWidth')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('vehicleHeight')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('vehicleEngineType')
                    ->searchable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVehicles::route('/'),
            'create' => Pages\CreateVehicle::route('/create'),
            'edit' => Pages\EditVehicle::route('/{record}/edit'),
        ];
    }
}
