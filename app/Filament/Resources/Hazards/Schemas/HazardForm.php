<?php

namespace App\Filament\Resources\Hazards\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;

class HazardForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('hazard_ref')
                    ->required(),
                DatePicker::make('date_registered')
                    ->required(),
                Select::make('unit_id')
                    ->relationship('unit', 'name') // or whatever column your units table uses
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('fir')
                    ->options([
                        'KL FIR' => 'Lumpur FIR',
                        'KK FIR' => 'Kinabalu FIR',
                    ])
                    ->required(),
                Select::make('source_id')
                    ->label('Hazard Identification Source')
                    ->relationship(
                        name: 'hazardsource', // <-- must match Hazard::source()
                        titleAttribute: 'name',
                        modifyQueryUsing: fn ($query) => $query->where('is_active', true)->orderBy('sort_order'),
                    )
                    ->searchable()
                    ->preload()
                    ->required(),

                Select::make('scope_id')
                    ->label('Hazard Scope')
                    ->relationship(
                        name: 'hazardscope', // <-- must match Hazard::scope()
                        titleAttribute: 'name',
                        modifyQueryUsing: fn ($query) => $query->where('is_active', true)->orderBy('sort_order'),
                    )
                    ->searchable()
                    ->preload()
                    ->required(),
                Textarea::make('generic_hazard')
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('specific_hazard')
                    ->required()
                    ->columnSpanFull(),
                DatePicker::make('occurrence_date'),
                Textarea::make('description')
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('consequence')
                    ->required()
                    ->columnSpanFull(),
                Select::make('initial_severity_id')
                    ->label('Initial Severity')
                    ->relationship(
                        name: 'initialSeverity',
                        titleAttribute: 'name',
                        modifyQueryUsing: fn ($query) => $query->where('is_active', true)->orderBy('sort_order')
                    )
                    ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->code} - {$record->name}")
                    ->searchable()
                    ->preload()
                    ->required(),

                Select::make('initial_probability_id')
                    ->label('Initial Probability')
                    ->relationship(
                        name: 'initialProbability',
                        titleAttribute: 'name',
                        modifyQueryUsing: fn ($query) => $query->where('is_active', true)->orderBy('sort_order')
                    )
                    ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->value} - {$record->name}")
                    ->searchable()
                    ->preload()
                    ->required()
            ]);
    }
}
