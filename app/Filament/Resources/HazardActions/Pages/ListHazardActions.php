<?php

namespace App\Filament\Resources\HazardActions\Pages;

use App\Filament\Resources\HazardActions\HazardActionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListHazardActions extends ListRecords
{
    protected static string $resource = HazardActionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
