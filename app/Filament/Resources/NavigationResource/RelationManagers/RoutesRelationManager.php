<?php

namespace App\Filament\Resources\NavigationResource\RelationManagers;

use App\Facades\Kml;
use App\Filament\Resources\RouteResource;
use App\Filament\Resources\RouteResource\Widgets\LineChart;
use Filament\Tables\Actions\Action;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RoutesRelationManager extends RelationManager
{
    protected static string $relationship = 'routes';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('id')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                ColorColumn::make('color'),
                Tables\Columns\TextColumn::make('segments_count')->counts("segments"),



            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(),
            ])->recordUrl(
                fn(Model $record): string => RouteResource::getUrl("view", ["record" => $record->id]),
                true
            )


            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])->paginated(false);
    }



}
