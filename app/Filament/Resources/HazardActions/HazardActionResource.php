<?php

namespace App\Filament\Resources\HazardActions;

use BackedEnum;
use Filament\Tables\Table;
use App\Models\HazardAction;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use App\Filament\Resources\HazardActions\Pages\EditHazardAction;
use App\Filament\Resources\HazardActions\Pages\ListHazardActions;
use App\Filament\Resources\HazardActions\Pages\CreateHazardAction;
use App\Filament\Resources\HazardActions\Schemas\HazardActionForm;
use App\Filament\Resources\HazardActions\Tables\HazardActionsTable;
use App\Filament\Resources\HazardActions\RelationManagers\SrmRecordRelationManager;

class HazardActionResource extends Resource
{
    protected static ?string $model = HazardAction::class;

    protected static \UnitEnum|string|null $navigationGroup = 'HIRM';
    protected static ?int $navigationSort = 5;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return HazardActionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return HazardActionsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            SrmRecordRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListHazardActions::route('/'),
            'create' => CreateHazardAction::route('/create'),
            'edit' => EditHazardAction::route('/{record}/edit'),
        ];
    }
}
