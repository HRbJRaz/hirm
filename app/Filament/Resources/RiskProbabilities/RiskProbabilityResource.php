<?php

namespace App\Filament\Resources\RiskProbabilities;

use App\Filament\Resources\RiskProbabilities\Pages\CreateRiskProbability;
use App\Filament\Resources\RiskProbabilities\Pages\EditRiskProbability;
use App\Filament\Resources\RiskProbabilities\Pages\ListRiskProbabilities;
use App\Filament\Resources\RiskProbabilities\Schemas\RiskProbabilityForm;
use App\Filament\Resources\RiskProbabilities\Tables\RiskProbabilitiesTable;
use App\Models\RiskProbability;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class RiskProbabilityResource extends Resource
{
    protected static ?string $model = RiskProbability::class;

    protected static \UnitEnum|string|null $navigationGroup = 'Taxonomy Management';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return RiskProbabilityForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RiskProbabilitiesTable::configure($table);
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
            'index' => ListRiskProbabilities::route('/'),
            'create' => CreateRiskProbability::route('/create'),
            'edit' => EditRiskProbability::route('/{record}/edit'),
        ];
    }
}
