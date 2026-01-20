<?php

namespace App\Filament\Resources\HazardScopes\Pages;

use App\Filament\Resources\HazardScopes\HazardScopeResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditHazardScope extends EditRecord
{
    protected static string $resource = HazardScopeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
