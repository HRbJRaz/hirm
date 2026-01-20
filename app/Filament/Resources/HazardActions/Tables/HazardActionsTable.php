<?php

namespace App\Filament\Resources\HazardActions\Tables;

use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;

class HazardActionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('hazard.hazard_ref')
                    ->label('Hazard Ref')
                    ->searchable()
                    ->sortable(),

                IconColumn::make('is_corrective_action')
                    ->label('Corrective')
                    ->boolean(),

                IconColumn::make('is_mitigation_action')
                    ->label('Mitigation')
                    ->boolean(),

                TextColumn::make('priority')->badge()->sortable(),
                TextColumn::make('due_date')->date()->sortable(),
                TextColumn::make('sra_sr_ref')->label('SRA/SR Ref')->searchable(),
                TextColumn::make('updated_at')->since()->sortable(),
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
