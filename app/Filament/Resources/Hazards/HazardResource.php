<?php

namespace App\Filament\Resources\Hazards;

use BackedEnum;
use App\Models\Hazard;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use App\Filament\Resources\Hazards\Pages\EditHazard;
use App\Filament\Resources\Hazards\Pages\ListHazards;
use App\Filament\Resources\Hazards\Pages\CreateHazard;
use App\Filament\Resources\Hazards\Schemas\HazardForm;
use App\Filament\Resources\Hazards\Tables\HazardsTable;
use App\Filament\Resources\Hazards\RelationManagers\ActionsRelationManager;

class HazardResource extends Resource
{
    protected static ?string $model = Hazard::class;
    protected static \UnitEnum|string|null $navigationGroup = 'HIRM';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return HazardForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return HazardsTable::configure($table);
    }

    public static function getRelations(): array
{
    return [
        ActionsRelationManager::class,
    ];
}

    public static function getPages(): array
    {
        return [
            'index' => ListHazards::route('/'),
            'create' => CreateHazard::route('/create'),
            'edit' => EditHazard::route('/{record}/edit'),
        ];
    }
}
