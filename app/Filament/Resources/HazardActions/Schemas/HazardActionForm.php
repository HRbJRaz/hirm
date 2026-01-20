<?php

namespace App\Filament\Resources\HazardActions\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;

class HazardActionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Recommended Actions')
                ->columnSpanFull()
                ->schema([
                    Select::make('hazard_id')
                        ->label('Hazard')
                        ->relationship('hazard', 'hazard_ref')
                        ->searchable()
                        ->preload()
                        ->required(),

                    Toggle::make('is_corrective_action')
                        ->label('Corrective Action')
                        ->default(false),

                    Toggle::make('is_mitigation_action')
                        ->label('Safety Risk Mitigation Action')
                        ->default(false),

                    TextInput::make('sra_sr_ref')
                        ->label('Register Safety Risk Assessment / Safety Review No.')
                        ->maxLength(255)
                        ->nullable(),

                    FileUpload::make('sra_sr_file_path')
                        ->label('Upload SRA / SR')
                        ->disk('public')
                        ->directory('sra-sr')
                        ->preserveFilenames()
                        ->maxSize(10240) // 10MB
                        ->nullable(),

                    Select::make('priority')
                        ->options([
                            'High' => 'High - 30 days',
                            'Medium' => 'Medium - 60 days',
                            'Low' => 'Low - 90 days',
                        ])
                        ->required()
                        ->live()
                        ->afterStateUpdated(function ($state, callable $set) {
                            $days = match ($state) {
                                'High' => 30,
                                'Medium' => 60,
                                'Low' => 90,
                                default => null,
                            };

                            if ($days) {
                                $set('due_date', now()->addDays($days)->toDateString());
                            }
                        }),

                    DatePicker::make('due_date')
                        ->label('Due Date')
                        ->required(),

                    Textarea::make('notes')
                        ->label('Recommended Action')
                        ->required()
                        ->rows(3),
                ]),
            ]);
    }
}
