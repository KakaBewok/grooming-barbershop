<?php

namespace App\Filament\Resources\Orders\Tables;

use App\Enums\ItemType;
use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Models\Order;
use App\Models\Product;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('order_number')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->copyable()
                    ->copyMessage('Order number copied'),

                TextColumn::make('barbershop.name')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('order_date')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),

                TextColumn::make('total_amount')
                    ->label('Total')
                    ->money('IDR')
                    ->sortable(),

                TextColumn::make('discount')
                    ->money('IDR')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('final_amount')
                    ->label('Final Amount')
                    ->state(fn (Order $record) => $record->final_amount)
                    ->money('IDR')
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('payment_method')
                    ->badge()
                    ->formatStateUsing(fn ($state) => $state->label())
                    ->colors([
                        'success' => PaymentMethod::CASH->value,
                        'info' => PaymentMethod::TRANSFER->value,
                        'warning' => PaymentMethod::QRIS->value,
                    ]),

                TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn ($state) => $state->label())
                    ->colors([
                        'warning' => OrderStatus::PENDING->value,
                        'info' => OrderStatus::PAID->value,
                        'success' => OrderStatus::COMPLETED->value,
                        'danger' => OrderStatus::CANCELLED->value,
                    ]),

                TextColumn::make('creator.name')
                    ->label('Created By')
                    ->toggleable()
                    ->searchable(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('barbershop')
                    ->relationship('barbershop', 'name')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('status')
                    ->options(OrderStatus::options())
                    ->native(false),

                SelectFilter::make('payment_method')
                    ->options(PaymentMethod::options())
                    ->native(false),

                Filter::make('order_date')
                    ->form([
                        DatePicker::make('from')
                            ->label('From Date'),
                        DatePicker::make('until')
                            ->label('Until Date'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['from'], fn ($q, $date) => $q->whereDate('order_date', '>=', $date))
                            ->when($data['until'], fn ($q, $date) => $q->whereDate('order_date', '<=', $date));
                    }),
            ])
            ->recordActions([
               ViewAction::make(),
                EditAction::make()
                    ->visible(fn (Order $record) => $record->status === OrderStatus::PENDING),
                
                Action::make('markAsPaid')
                    ->label('Mark as Paid')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn (Order $record) => $record->status === OrderStatus::PENDING)
                    ->action(function (Order $record) {
                        // Reduce stock for products
                        foreach ($record->items as $item) {
                            if ($item->item_type === ItemType::PRODUCT && $item->item_id) {
                                $product = Product::find($item->item_id);
                                if ($product) {
                                    if (!$product->decrementStock($item->quantity)) {
                                        Notification::make()
                                            ->danger()
                                            ->title('Insufficient stock')
                                            ->body("Not enough stock for {$product->name}")
                                            ->send();
                                        return;
                                    }
                                }
                            }
                        }

                        $record->markAsPaid();

                        Notification::make()
                            ->success()
                            ->title('Order marked as paid')
                            ->send();
                    }),

                Action::make('complete')
                    ->label('Complete')
                    ->icon('heroicon-o-check-badge')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn (Order $record) => $record->status === OrderStatus::PAID)
                    ->action(function (Order $record) {
                        $record->markAsCompleted();

                        Notification::make()
                            ->success()
                            ->title('Order completed')
                            ->send();
                    }),

                Action::make('cancel')
                    ->label('Cancel')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalDescription('Are you sure? This will restore product stock.')
                    ->visible(fn (Order $record) => in_array($record->status, [OrderStatus::PENDING, OrderStatus::PAID]))
                    ->action(function (Order $record) {
                        $record->cancel();

                        Notification::make()
                            ->success()
                            ->title('Order cancelled')
                            ->body('Product stock has been restored')
                            ->send();
                    }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
