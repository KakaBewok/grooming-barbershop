<?php

namespace App\Filament\Resources\Orders\Pages;

use App\Filament\Resources\Orders\OrderResource;
use Filament\Actions;
use Filament\Actions\EditAction;
use Filament\Infolists;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Components\Section;

class ViewOrder extends ViewRecord
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('print')
                ->label('Print Receipt')
                ->icon('heroicon-o-printer')
                ->color('info')
                ->action(function (\App\Services\ReceiptPrinterService $service) {
                    if ($service->printOrder($this->record)) {
                        \Filament\Notifications\Notification::make()
                            ->success()
                            ->title('Receipt sent to printer')
                            ->send();
                    } else {
                        \Filament\Notifications\Notification::make()
                            ->danger()
                            ->title('Printing failed')
                            ->body('Please check printer connection.')
                            ->send();
                    }
                }),
            EditAction::make()
                 ->visible(fn ($record) => $record->status->value === 'pending'),
        ];
    }

    // public function infolist(Infolist $infolist): Infolist
    // {
    //     return $infolist
    //         ->schema([
    //             Section::make('Order Information')
    //                 ->schema([
    //                     TextEntry::make('order_number')
    //                         ->label('Order Number')
    //                         ->weight('bold')
    //                         ->size('lg')
    //                         ->copyable(),

    //                     TextEntry::make('barbershop.name')
    //                         ->label('Barbershop'),

    //                     TextEntry::make('order_date')
    //                         ->label('Order Date')
    //                         ->dateTime('d M Y, H:i'),

    //                     TextEntry::make('status')
    //                         ->badge()
    //                         ->formatStateUsing(fn ($state) => $state->label())
    //                         ->color(fn ($state) => $state->color()),

    //                     TextEntry::make('payment_method')
    //                         ->label('Payment Method')
    //                         ->badge()
    //                         ->formatStateUsing(fn ($state) => $state->label()),

    //                     TextEntry::make('creator.name')
    //                         ->label('Created By'),

    //                     TextEntry::make('notes')
    //                         ->label('Notes')
    //                         ->columnSpanFull()
    //                         ->placeholder('No notes'),
    //                 ])
    //                 ->columns(3),

    //             Section::make('Order Items')
    //                 ->schema([
    //                     RepeatableEntry::make('items')
    //                         ->schema([
    //                             TextEntry::make('item_type')
    //                                 ->label('Type')
    //                                 ->badge()
    //                                 ->formatStateUsing(fn ($state) => $state->label()),

    //                             TextEntry::make('item_name')
    //                                 ->label('Item Name')
    //                                 ->weight('bold'),

    //                             TextEntry::make('price')
    //                                 ->label('Price')
    //                                 ->money('IDR'),

    //                             TextEntry::make('quantity')
    //                                 ->label('Qty'),

    //                             TextEntry::make('subtotal')
    //                                 ->label('Subtotal')
    //                                 ->money('IDR')
    //                                 ->weight('bold'),
    //                         ])
    //                         ->columns(5)
    //                         ->columnSpanFull(),
    //                 ]),

    //             Section::make('Payment Summary')
    //                 ->schema([
    //                     TextEntry::make('total_amount')
    //                         ->label('Subtotal')
    //                         ->money('IDR'),

    //                     TextEntry::make('discount')
    //                         ->label('Discount')
    //                         ->money('IDR'),

    //                     TextEntry::make('final_amount')
    //                         ->label('Final Amount')
    //                         ->state(fn ($record) => $record->final_amount)
    //                         ->money('IDR')
    //                         ->weight('bold')
    //                         ->size('lg')
    //                         ->color('success'),
    //                 ])
    //                 ->columns(3),
    //         ]);
    // }
}
