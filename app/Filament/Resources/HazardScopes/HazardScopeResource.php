<?php

namespace App\Filament\Resources\HazardScopes;

use App\Filament\Resources\HazardScopes\Pages\CreateHazardScope;
use App\Filament\Resources\HazardScopes\Pages\EditHazardScope;
use App\Filament\Resources\HazardScopes\Pages\ListHazardScopes;
use App\Filament\Resources\HazardScopes\Schemas\HazardScopeForm;
use App\Filament\Resources\HazardScopes\Tables\HazardScopesTable;
use App\Models\HazardScope;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class HazardScopeResource extends Resource
{
    protected static ?string $model = HazardScope::class;
    
    protected static \UnitEnum|string|null $navigationGroup = 'Taxonomy Management';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    
    // protected static string|BackedEnum|null $navigationGroup = 'Safety Management';

    public static function form(Schema $schema): Schema
    {
        return HazardScopeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return HazardScopesTable::configure($table);
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
            'index' => ListHazardScopes::route('/'),
            'create' => CreateHazardScope::route('/create'),
            'edit' => EditHazardScope::route('/{record}/edit'),
        ];
    }
}
