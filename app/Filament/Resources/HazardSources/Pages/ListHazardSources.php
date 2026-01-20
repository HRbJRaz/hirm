<?php

namespace App\Filament\Resources\HazardSources\Pages;

use App\Filament\Resources\HazardSources\HazardSourceResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListHazardSources extends ListRecords
{
    protected static string $resource = HazardSourceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
