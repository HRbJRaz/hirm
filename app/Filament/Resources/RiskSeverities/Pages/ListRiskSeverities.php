<?php

namespace App\Filament\Resources\RiskSeverities\Pages;

use App\Filament\Resources\RiskSeverities\RiskSeverityResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRiskSeverities extends ListRecords
{
    protected static string $resource = RiskSeverityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
