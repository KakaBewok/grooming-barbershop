<?php

namespace App\Filament\Resources\Barbershops\Pages;

use App\Filament\Resources\Barbershops\BarbershopResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditBarbershop extends EditRecord
{
    protected static string $resource = BarbershopResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
