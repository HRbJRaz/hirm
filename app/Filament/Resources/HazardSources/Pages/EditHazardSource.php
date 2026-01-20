<?php

namespace App\Filament\Resources\HazardSources\Pages;

use App\Filament\Resources\HazardSources\HazardSourceResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditHazardSource extends EditRecord
{
    protected static string $resource = HazardSourceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
