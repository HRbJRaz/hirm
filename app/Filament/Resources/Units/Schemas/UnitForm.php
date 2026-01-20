<?php

namespace App\Filament\Resources\Units\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class UnitForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('designator')
                    ->required(),
                TextInput::make('name')
                    ->required(),
                Select::make('div_id')
                    ->label('Division')
                    ->relationship('division', 'name') // Unit::division()
                    ->searchable()
                    ->preload()
                    ->nullable(),
                Textarea::make('address')
                    ->columnSpanFull(),
                TextInput::make('phone')
                    ->tel(),
                TextInput::make('fax'),
                TextInput::make('afs'),
                Select::make('manager_id')
                ->label('Manager')
                ->relationship('manager', 'name') // Unit::manager()
                ->searchable()
                ->preload()
                ->nullable(),
                
            ]);
    }
}
