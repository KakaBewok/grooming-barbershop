<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Produk')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Produk')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (string $operation, $state, Set $set) => 
                                $operation === 'create' ? $set('slug', Str::slug($state)) : null
                            ),
                        Textarea::make('description')
                            ->label('Deskripsi Produk')
                            ->rows(4)
                            ->columnSpanFull(),
                    ])->collapsible(),
                Section::make('Harga & Stok')
                    ->schema([
                        TextInput::make('price')
                            ->label('Harga')
                            ->required()
                            ->numeric()
                            ->prefix('Rp')
                            ->minValue(0)
                            ->step(1000),

                        TextInput::make('crossed_out_price')
                            ->label('Harga Coret')
                            ->numeric()
                            ->prefix('Rp')
                            ->minValue(0)
                            ->step(1000)
                            ->helperText('Opsional, untuk menampilkan harga diskon'),
                        TextInput::make('stock')
                            ->label('Stok Produk')
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->default(0)
                            ->step(1),
                    ])
                    ->columns(2)->collapsible(),

                Section::make('Status')
                    ->schema([
                        Toggle::make('is_active')
                            ->label('Active')
                            ->default(true)
                            ->inline(false),
                    ])->collapsible(),
                // ini
                    Section::make('Product Images')
                    ->description('Upload multiple images for this product')
                    ->schema([
                        Repeater::make('productImages')
                            ->relationship('images')
                            ->schema([
                                FileUpload::make('image_path')
                                    ->label('Image')
                                    ->image()
                                    ->directory('products')
                                    ->imageEditor()
                                    ->imageEditorAspectRatioOptions([
                                        '16:9',
                                        '4:3',
                                        '1:1',
                                    ])
                                    ->maxSize(2048)
                                    ->acceptedFileTypes(['image/jpeg', 'image/jpg', 'image/png', 'image/webp'])
                                    ->required()
                                    ->columnSpan(2),

                                Toggle::make('is_primary')
                                    ->label('Primary Image')
                                    ->helperText('Main product photo')
                                    ->inline(false)
                                    ->columnSpan(1),

                                TextInput::make('sort_order')
                                    ->label('Order')
                                    ->numeric()
                                    ->default(0)
                                    ->minValue(0)
                                    ->columnSpan(1),
                            ])
                            ->columns(2)
                            ->defaultItems(1)
                            ->addActionLabel('Add Image')
                            ->reorderable('sort_order')
                            ->collapsible()
                            ->itemLabel(fn (array $state): ?string => 
                                ($state['is_primary'] ?? false) ? '⭐ Primary Image' : 'Image'
                            )
                            ->columnSpanFull(),
                    ])
                    ->collapsible()
                    ->collapsed(false),
            ]);
    }
}
