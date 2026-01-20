<?php

namespace App\Filament\Resources\HazardActions\Pages;

use App\Filament\Resources\HazardActions\HazardActionResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditHazardAction extends EditRecord
{
    protected static string $resource = HazardActionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
