<?php

namespace App\Filament\Resources\RiskProbabilities\Pages;

use App\Filament\Resources\RiskProbabilities\RiskProbabilityResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditRiskProbability extends EditRecord
{
    protected static string $resource = RiskProbabilityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
