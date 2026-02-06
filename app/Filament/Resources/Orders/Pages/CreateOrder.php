<?php

namespace App\Filament\Resources\Orders\Pages;

use App\Filament\Resources\Orders\OrderResource;
use Filament\Resources\Pages\CreateRecord;

class CreateOrder extends CreateRecord
{
    protected static string $resource = OrderResource::class;

    protected function afterCreate(): void
    {
        if (config('printer.auto_print')) {
            $order = $this->record;
            $service = app(\App\Services\ReceiptPrinterService::class);
            
            if (!$service->printOrder($order)) {
                \Filament\Notifications\Notification::make()
                    ->danger()
                    ->title('Auto-printing failed')
                    ->body('Could not connect to the printer.')
                    ->send();
            }
        }
    }
}
