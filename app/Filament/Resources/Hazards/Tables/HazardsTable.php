<?php

namespace App\Filament\Resources\Hazards\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class HazardsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->searchable()
                    ->hidden(),
                TextColumn::make('hazard_ref')
                    ->searchable(),
                TextColumn::make('date_registered')
                    ->date()
                    ->sortable(),
                TextColumn::make('unit.name')
                    ->searchable(),
                TextColumn::make('fir')
                    ->label('FIR')
                    ->searchable(),
                TextColumn::make('hazardsource.name')
                    ->label('Source')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('hazardscope.name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('occurrence_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('initial_risk_index')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
