<?php

namespace App\Filament\Resources\RiskSeverities;

use App\Filament\Resources\RiskSeverities\Pages\CreateRiskSeverity;
use App\Filament\Resources\RiskSeverities\Pages\EditRiskSeverity;
use App\Filament\Resources\RiskSeverities\Pages\ListRiskSeverities;
use App\Filament\Resources\RiskSeverities\Schemas\RiskSeverityForm;
use App\Filament\Resources\RiskSeverities\Tables\RiskSeveritiesTable;
use App\Models\RiskSeverity;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class RiskSeverityResource extends Resource
{
    protected static ?string $model = RiskSeverity::class;

    protected static \UnitEnum|string|null $navigationGroup = 'Taxonomy Management';
    
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return RiskSeverityForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RiskSeveritiesTable::configure($table);
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
            'index' => ListRiskSeverities::route('/'),
            'create' => CreateRiskSeverity::route('/create'),
            'edit' => EditRiskSeverity::route('/{record}/edit'),
        ];
    }
}
