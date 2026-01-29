<?php

namespace App\Filament\Resources\Barbershops\Pages;

use App\Filament\Resources\Barbershops\BarbershopResource;
use App\Models\Barbershop;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListBarbershops extends ListRecords
{
    protected static string $resource = BarbershopResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->visible(fn() => Barbershop::count() === 0),
        ];
    }
}
