<?php

namespace App\Filament\Resources\Orders\Schemas;

use App\Enums\ItemType;
use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Models\Product;
use App\Models\Service;
use Filament\Actions\Action;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Order Information')
                    ->schema([
                        Select::make('barbershop_id')
                            ->relationship('barbershop', 'name')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->live()
                            ->afterStateUpdated(fn (Set $set) => $set('items', [])),

                        DateTimePicker::make('order_date')
                            ->default(now())
                            ->required()
                            ->seconds(false),

                        Select::make('payment_method')
                            ->options(PaymentMethod::options())
                            ->required()
                            ->default(PaymentMethod::CASH->value)
                            ->native(false),

                        Select::make('status')
                            ->options(OrderStatus::options())
                            ->required()
                            ->default(OrderStatus::PENDING->value)
                            ->native(false)
                            ->live(),

                        Textarea::make('notes')
                            ->rows(2)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Order Items')
                    ->schema([
                        Repeater::make('items')
                            ->relationship()
                            ->schema([
                                Select::make('item_type')
                                    ->options(ItemType::options())
                                    ->required()
                                    ->live()
                                    ->native(false)
                                    ->afterStateUpdated(function (Set $set) {
                                        $set('item_id', null);
                                        $set('price', 0);
                                        $set('quantity', 1);
                                    }),

                                Select::make('item_id')
                                    ->label('Item')
                                    ->options(function (Get $get) {
                                        $barbershopId = $get('../../barbershop_id');
                                        $itemType = $get('item_type');

                                        if (!$barbershopId || !$itemType) {
                                            return [];
                                        }

                                        if ($itemType === ItemType::SERVICE->value) {
                                            return Service::where('barbershop_id', $barbershopId)
                                                ->where('is_active', true)
                                                ->pluck('name', 'id')
                                                ->toArray();
                                        }

                                        if ($itemType === ItemType::PRODUCT->value) {
                                            return Product::where('barbershop_id', $barbershopId)
                                                ->where('is_active', true)
                                                ->where('stock', '>', 0)
                                                ->get()
                                                ->mapWithKeys(fn ($product) => [
                                                    $product->id => "{$product->name} (Stock: {$product->stock})"
                                                ])
                                                ->toArray();
                                        }

                                        return [];
                                    })
                                    ->required()
                                    ->searchable()
                                    ->live()
                                    ->afterStateUpdated(function (Get $get, Set $set, $state) {
                                        if (!$state) return;

                                        $itemType = $get('item_type');
                                        
                                        if ($itemType === ItemType::SERVICE->value) {
                                            $service = Service::find($state);
                                            if ($service) {
                                                $set('item_name', $service->name);
                                                $set('price', $service->price);
                                                $set('quantity', 1);
                                            }
                                        } elseif ($itemType === ItemType::PRODUCT->value) {
                                            $product = Product::find($state);
                                            if ($product) {
                                                $set('item_name', $product->name);
                                                $set('price', $product->price);
                                                $set('quantity', 1);
                                            }
                                        }
                                    }),

                                Hidden::make('item_name'),

                                TextInput::make('price')
                                    ->required()
                                    ->numeric()
                                    ->prefix('Rp')
                                    ->disabled()
                                    ->dehydrated(),

                                TextInput::make('quantity')
                                    ->required()
                                    ->numeric()
                                    ->default(1)
                                    ->minValue(1)
                                    ->live()
                                    ->disabled(fn (Get $get) => $get('item_type') === ItemType::SERVICE->value)
                                    ->afterStateUpdated(function (Get $get, Set $set, $state) {
                                        // Validate stock for products
                                        if ($get('item_type') === ItemType::PRODUCT->value && $get('item_id')) {
                                            $product = Product::find($get('item_id'));
                                            if ($product && $state > $product->stock) {
                                                Notification::make()
                                                    ->warning()
                                                    ->title('Insufficient stock')
                                                    ->body("Only {$product->stock} items available")
                                                    ->send();
                                                $set('quantity', $product->stock);
                                            }
                                        }
                                    }),

                                Placeholder::make('subtotal')
                                    ->content(function (Get $get): string {
                                        $price = (float) $get('price');
                                        $quantity = (int) $get('quantity') ?: 1;
                                        $subtotal = $price * $quantity;
                                        return 'Rp ' . number_format($subtotal, 0, ',', '.');
                                    }),
                            ])
                            ->columns(5)
                            ->defaultItems(0)
                            ->addActionLabel('Add Item')
                            ->live()
                            ->afterStateUpdated(function (Get $get, Set $set) {
                                self::updateTotals($get, $set);
                            })
                            ->deleteAction(
                                fn (Action $action) => $action->after(
                                    fn (Get $get, Set $set) => self::updateTotals($get, $set)
                                )
                            )
                            ->columnSpanFull()
                            ->minItems(1),
                    ]),

                Section::make('Totals')
                    ->schema([
                        TextInput::make('discount')
                            ->numeric()
                            ->prefix('Rp')
                            ->default(0)
                            ->minValue(0)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Get $get, Set $set) {
                                self::updateTotals($get, $set);
                            }),

                        Placeholder::make('total_amount_display')
                            ->label('Subtotal')
                            ->content(function (Get $get): string {
                                $total = (float) $get('total_amount') ?: 0;
                                return 'Rp ' . number_format($total, 0, ',', '.');
                            }),

                        Placeholder::make('final_amount')
                            ->label('Final Amount')
                            ->content(function (Get $get): string {
                                $total = (float) $get('total_amount') ?: 0;
                                $discount = (float) $get('discount') ?: 0;
                                $final = max(0, $total - $discount);
                                return 'Rp ' . number_format($final, 0, ',', '.');
                            })
                            ->extraAttributes(['class' => 'text-2xl font-bold text-success-600']),

                        Hidden::make('total_amount')
                            ->default(0)
                            ->dehydrated(),

                        Hidden::make('created_by')
                            ->dehydrated(),
                    ])
                    ->columns(3),
            ]);
    }

    protected static function updateTotals(Get $get, Set $set): void
    {
        $items = collect($get('items'));
        
        $total = $items->reduce(function ($carry, $item) {
            $price = (float) ($item['price'] ?? 0);
            $quantity = (int) ($item['quantity'] ?? 1);
            return $carry + ($price * $quantity);
        }, 0);

        $set('total_amount', $total);
    }
}
