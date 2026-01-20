<?php

namespace App\Filament\Resources\HazardSources;

use App\Filament\Resources\HazardSources\Pages\CreateHazardSource;
use App\Filament\Resources\HazardSources\Pages\EditHazardSource;
use App\Filament\Resources\HazardSources\Pages\ListHazardSources;
use App\Filament\Resources\HazardSources\Schemas\HazardSourceForm;
use App\Filament\Resources\HazardSources\Tables\HazardSourcesTable;
use App\Models\HazardSource;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class HazardSourceResource extends Resource
{
    protected static ?string $model = HazardSource::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static \UnitEnum|string|null $navigationGroup = 'Taxonomy Management';

    public static function form(Schema $schema): Schema
    {
        return HazardSourceForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return HazardSourcesTable::configure($table);
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
            'index' => ListHazardSources::route('/'),
            'create' => CreateHazardSource::route('/create'),
            'edit' => EditHazardSource::route('/{record}/edit'),
        ];
    }
}
