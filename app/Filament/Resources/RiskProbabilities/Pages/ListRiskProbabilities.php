<?php

namespace App\Filament\Resources\RiskProbabilities\Pages;

use App\Filament\Resources\RiskProbabilities\RiskProbabilityResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRiskProbabilities extends ListRecords
{
    protected static string $resource = RiskProbabilityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
