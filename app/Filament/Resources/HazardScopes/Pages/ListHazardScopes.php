<?php

namespace App\Filament\Resources\HazardScopes\Pages;

use App\Filament\Resources\HazardScopes\HazardScopeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListHazardScopes extends ListRecords
{
    protected static string $resource = HazardScopeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
