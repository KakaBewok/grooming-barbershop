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
                TextColumn::make('name')
                    ->label('Nama Jasa')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('price')
                    ->label('Harga')
                    ->money('IDR')
                    ->sortable(),

                TextColumn::make('crossed_out_price')
                    ->label('Harga Coret')
                    ->money('IDR')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('discount_percentage')
                    ->label('Diskon')
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
            ])
            ->filters([
               TernaryFilter::make('is_active')
                    ->label('Status')
                    ->placeholder('Semua jasa')
                    ->trueLabel('Hanya aktif')
                    ->falseLabel('Hanya non-aktif'),
               Filter::make('has_discount')
                    ->label('Jasa diskon')
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
