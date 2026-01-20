<?php

namespace App\Filament\Resources\HazardActions\RelationManagers;

use App\Models\Unit;
use Filament\Tables;
use App\Models\Division;
use Filament\Tables\Table;

use Filament\Schemas\Schema;
use Filament\Actions\EditAction;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;

use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\RelationManagers\RelationManager;

class SrmRecordRelationManager extends RelationManager
{
    // Must match HazardAction::srmRecord()
    protected static string $relationship = 'srmRecord';

    public function form(Schema $schema): Schema
    {
        return $schema->schema([

                    // Mixed selector (Division + Unit) - not stored directly
                    Select::make('responsible_selector')
                        ->label('Responsible Division / Unit')
                        ->options(function () {
                            $divisions = Division::orderBy('name')
                                ->get()
                                ->mapWithKeys(fn ($d) => [
                                    "division:{$d->id}" => "DIV — {$d->name}",
                                ]);

                            $units = Unit::orderBy('name')
                                ->get()
                                ->mapWithKeys(fn ($u) => [
                                    "unit:{$u->id}" => "UNIT — {$u->designator} {$u->name}",
                                ]);

                            return $divisions->merge($units)->toArray();
                        })
                        ->searchable()
                        ->preload()
                        ->required()
                        ->dehydrated(false)
                        ->afterStateHydrated(function ($state, callable $set, $record) {
                            if ($record && $record->responsible_type && $record->responsible_id) {
                                $set('responsible_selector', "{$record->responsible_type}:{$record->responsible_id}");
                            }
                        })
                        ->afterStateUpdated(function ($state, callable $set) {
                            if (! $state) return;

                            [$type, $id] = explode(':', $state, 2);
                            $set('responsible_type', $type);
                            $set('responsible_id', $id);
                        }),

                    Hidden::make('responsible_type')->required(),
                    Hidden::make('responsible_id')->required(),

                    TextInput::make('action_item_display')
                        ->label('Action Item (Hazard Action)')
                        ->disabled()
                        ->dehydrated(false)
                        ->default(function () {
                            $action = $this->getOwnerRecord(); // HazardAction record
                            if (! $action) return null;

                            // Use notes as the action item text
                            if (! empty($action->notes)) {
                                return $action->notes;
                            }

                            // Fallback if notes is empty
                            $tags = collect([
                                $action->is_corrective_action ? 'Corrective' : null,
                                $action->is_mitigation_action ? 'Mitigation' : null,
                                $action->priority ? "Priority: {$action->priority}" : null,
                                $action->due_date ? "Due: {$action->due_date->format('Y-m-d')}" : null,
                            ])->filter()->implode(' | ');

                            return $tags ?: '—';
                        }),

                    DatePicker::make('estimated_implementation_date')
                        ->label('Estimated Implementation Date')
                        ->required(),

                    DatePicker::make('actual_completion_date')
                        ->label('Actual Completion Date')
                        ->nullable(),

                    Textarea::make('implementation_details')
                        ->label('Detail of Implementation')
                        ->rows(4)
                        ->required()
                        ->columnSpanFull(),

                    FileUpload::make('evidence_path')
                        ->label('Upload Evidence of Implementation')
                        ->disk('public')
                        ->directory('srm-evidence')
                        ->preserveFilenames()
                        ->maxSize(10240)
                        ->nullable()
                        ->columnSpanFull(),

                    Select::make('severity_id')
                        ->label('Hazard Severity')
                        ->relationship(
                            name: 'severity',
                            titleAttribute: 'name',
                            // modifyQueryUsing: fn ($q) => $q->where('is_active', true)->orderBy('sort_order')
                        )
                        // ->getOptionLabelFromRecordUsing(fn ($r) => "{$r->code} - {$r->name}")
                        ->preload()
                        ->searchable()
                        ->required(),

                    Select::make('probability_id')
                        ->label('Hazard Probability')
                        ->relationship(
                            name: 'probability',
                            titleAttribute: 'name',
                            // modifyQueryUsing: fn ($q) => $q->where('is_active', true)->orderBy('sort_order')
                        )
                        // ->getOptionLabelFromRecordUsing(fn ($r) => "{$r->value} - {$r->name}")
                        ->preload()
                        ->searchable()
                        ->required(),

                    // Display only - computed in model saving()
                    TextInput::make('risk_index')
                        ->label('Hazard Rating')
                        ->disabled()
                        ->dehydrated(true),

                    Select::make('status')
                        ->options([
                            'Active' => 'Active',
                            'Review' => 'Review',
                            'Approval' => 'Approval',
                            'Closed' => 'Closed',
                        ])
                        ->required()
                        ->default('Active')
                        ->live(),

                    Textarea::make('remarks')
                        ->label('Remarks')
                        ->rows(3)
                        ->nullable()
                        ->columnSpanFull(),
                ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('status')->badge()->sortable(),
                TextColumn::make('risk_index')->badge()->label('Rating')->sortable(),
                TextColumn::make('estimated_implementation_date')->date()->sortable(),
                TextColumn::make('actual_completion_date')->date()->sortable(),
                TextColumn::make('updated_at')->since()->sortable(),
            ])
            ->headerActions([
                // Enforce 1 SRM record per action
                CreateAction::make()
                    ->visible(fn () => $this->getRelationship()->count() === 0),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }
}