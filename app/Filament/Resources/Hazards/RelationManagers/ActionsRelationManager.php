<?php

namespace App\Filament\Resources\Hazards\RelationManagers;

use Filament\Tables;
use Filament\Tables\Table;

use Filament\Schemas\Schema;
use Filament\Actions\EditAction;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;

use Filament\Actions\DeleteBulkAction;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\RelationManagers\RelationManager;

class ActionsRelationManager extends RelationManager
{
    protected static string $relationship = 'actions'; // Hazard::actions()

    public function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('Recommended Action')
                ->columnSpanFull()
                ->schema([
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
                        ->maxSize(10240)
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
                        ->rows(3)
                        ->nullable(),
                ])
                ->columns(1),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                IconColumn::make('is_corrective_action')->label('Corrective')->boolean(),
                IconColumn::make('is_mitigation_action')->label('Mitigation')->boolean(),
                TextColumn::make('priority')->badge()->sortable(),
                TextColumn::make('due_date')->date()->sortable(),
                TextColumn::make('sra_sr_ref')->label('SRA/SR No.')->searchable(),
                TextColumn::make('created_at')->since()->label('Created')->sortable(),
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}