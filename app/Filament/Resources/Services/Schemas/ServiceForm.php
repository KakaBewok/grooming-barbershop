<?php

namespace App\Filament\Resources\Services\Schemas;

use Filament\Forms;
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

class ServiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
               Section::make('Service Information')
                    ->schema([
                       Select::make('barbershop_id')
                            ->relationship('barbershop', 'name')
                            ->required()
                            ->searchable()
                            ->preload(),

                       TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (string $operation, $state, Set $set) => 
                                $operation === 'create' ? $set('slug', Str::slug($state)) : null
                            ),

                       TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->rules(['alpha_dash']),

                       Textarea::make('description')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

               Section::make('Service Images')
                    ->description('Upload multiple images for this service')
                    ->schema([
                       Repeater::make('serviceImages')
                            ->relationship('images')
                            ->schema([
                               FileUpload::make('image_path')
                                    ->label('Image')
                                    ->image()
                                    ->directory('services')
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
                                    ->helperText('Main service photo')
                                    ->inline(false)
                                    ->columnSpan(1),

                               TextInput::make('sort_order')
                                    ->label('Order')
                                    ->numeric()
                                    ->default(0)
                                    ->minValue(0)
                                    ->columnSpan(1),
                            ])
                            ->columns(4)
                            ->defaultItems(1)
                            ->addActionLabel('Add Image')
                            ->reorderable('sort_order')
                            ->reorderableWithButtons()
                            ->collapsible()
                            ->itemLabel(fn (array $state): ?string => 
                                ($state['is_primary'] ?? false) ? '⭐ Primary Image' : 'Image'
                            )
                            ->columnSpanFull(),
                    ])
                    ->collapsible()
                    ->collapsed(false),

               Section::make('Pricing')
                    ->schema([
                       TextInput::make('price')
                            ->required()
                            ->numeric()
                            ->prefix('Rp')
                            ->minValue(0)
                            ->step(1000),

                       TextInput::make('crossed_out_price')
                            ->label('Original Price (for discount)')
                            ->numeric()
                            ->prefix('Rp')
                            ->minValue(0)
                            ->step(1000)
                            ->helperText('Leave empty if no discount'),
                    ])
                    ->columns(2),

               Section::make('Status')
                    ->schema([
                        Forms\Components\Toggle::make('is_active')
                            ->label('Active')
                            ->default(true)
                            ->inline(false),
                    ]),
            ]);
    }
}
