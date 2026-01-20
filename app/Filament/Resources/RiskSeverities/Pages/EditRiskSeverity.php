<?php

namespace App\Filament\Resources\RiskSeverities\Pages;

use App\Filament\Resources\RiskSeverities\RiskSeverityResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditRiskSeverity extends EditRecord
{
    protected static string $resource = RiskSeverityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
