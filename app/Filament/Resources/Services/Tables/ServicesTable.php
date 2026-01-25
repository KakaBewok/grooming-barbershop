<?php

namespace App\Filament\Resources\Services\Tables;

use App\Models\Service;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class ServicesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                 TextColumn::make('barbershop.name')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('price')
                    ->money('IDR')
                    ->sortable(),

                TextColumn::make('crossed_out_price')
                    ->label('Original Price')
                    ->money('IDR')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('discount_percentage')
                    ->label('Discount')
                    ->state(function (Service $record): ?string {
                        if ($record->has_discount) {
                            return round($record->discount_percentage, 0) . '%';
                        }
                        return null;
                    })
                    ->badge()
                    ->color('success'),

                IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->sortable(),

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

               TernaryFilter::make('is_active')
                    ->label('Active Status')
                    ->placeholder('All services')
                    ->trueLabel('Active only')
                    ->falseLabel('Inactive only'),

               Filter::make('has_discount')
                    ->label('Has Discount')
                    ->query(fn ($query) => $query->whereNotNull('crossed_out_price')
                        ->whereColumn('crossed_out_price', '>', 'price')),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
