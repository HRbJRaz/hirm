<?php

namespace App\Filament\Resources\Divisions\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class DivisionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                ->required()
                ->maxLength(255),

            TextInput::make('abbr')
                ->required()
                ->unique(ignoreRecord: true)
                ->maxLength(50),

            Select::make('director_id')
                ->label('Director')
                ->relationship('director', 'name') // Division::director()
                ->searchable()
                ->preload()
                ->nullable(),
            ]);
    }
}
