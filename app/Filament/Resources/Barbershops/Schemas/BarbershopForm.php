<?php

namespace App\Filament\Resources\Barbershops\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class BarbershopForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Basic Information')
                    ->schema([
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

                Section::make('Gallery Images')
                    ->description('Upload multiple images for this barbershop')
                    ->schema([
                        Repeater::make('barbershopImages')
                            ->relationship('images')
                            ->schema([
                                FileUpload::make('image_path')
                                    ->label('Image')
                                    ->image()
                                    ->directory('barbershops')
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

                                TextInput::make('caption')
                                    ->label('Caption')
                                    ->maxLength(255)
                                    ->columnSpan(2),

                                Toggle::make('is_featured')
                                    ->label('Featured')
                                    ->helperText('Show on homepage')
                                    ->inline(false)
                                    ->columnSpan(1),

                                TextInput::make('sort_order')
                                    ->label('Order')
                                    ->numeric()
                                    ->default(0)
                                    ->minValue(0)
                                    ->helperText('Display order')
                                    ->columnSpan(1),
                            ])
                            ->columns(4)
                            ->defaultItems(0)
                            ->addActionLabel('Add Image')
                            ->reorderable('sort_order')
                            ->reorderableWithButtons()
                            ->collapsible()
                            ->itemLabel(fn (array $state): ?string => $state['caption'] ?? 'Image')
                            ->columnSpanFull(),
                    ])
                    ->collapsible()
                    ->collapsed(false),

                Section::make('Contact Information')
                    ->schema([
                        Textarea::make('address')
                            ->rows(2)
                            ->columnSpanFull(),

                        TextInput::make('phone')
                            ->tel()
                            ->maxLength(20),

                        TextInput::make('google_maps_url')
                            ->url()
                            ->label('Google Maps URL')
                            ->placeholder('https://maps.google.com/?q=...'),

                        TextInput::make('instagram_url')
                            ->url()
                            ->label('Instagram URL')
                            ->placeholder('https://instagram.com/username'),

                        TextInput::make('tiktok_url')
                            ->url()
                            ->label('TikTok URL')
                            ->placeholder('https://tiktok.com/@username'),
                    ])
                    ->columns(2)
                    ->collapsible(),

                Section::make('Operating Hours')
                    ->schema([
                        Repeater::make('opening_hours')
                            ->schema([
                                Select::make('day')
                                    ->options([
                                        'monday' => 'Monday',
                                        'tuesday' => 'Tuesday',
                                        'wednesday' => 'Wednesday',
                                        'thursday' => 'Thursday',
                                        'friday' => 'Friday',
                                        'saturday' => 'Saturday',
                                        'sunday' => 'Sunday',
                                    ])
                                    ->required()
                                    ->disableOptionsWhenSelectedInSiblingRepeaterItems(),

                                TimePicker::make('open')
                                    ->required()
                                    ->seconds(false),

                                TimePicker::make('close')
                                    ->required()
                                    ->seconds(false),
                            ])
                            ->columns(3)
                            ->defaultItems(0)
                            ->collapsible()
                            ->columnSpanFull()
                            ->default([
                                ['day' => 'monday', 'open' => '09:00', 'close' => '21:00'],
                                ['day' => 'tuesday', 'open' => '09:00', 'close' => '21:00'],
                                ['day' => 'wednesday', 'open' => '09:00', 'close' => '21:00'],
                                ['day' => 'thursday', 'open' => '09:00', 'close' => '21:00'],
                                ['day' => 'friday', 'open' => '09:00', 'close' => '22:00'],
                                ['day' => 'saturday', 'open' => '09:00', 'close' => '22:00'],
                                ['day' => 'sunday', 'open' => '10:00', 'close' => '20:00'],
                            ]),
                    ])
                    ->collapsible(),

                Section::make('Status')
                    ->schema([
                        Toggle::make('is_active')
                            ->label('Active')
                            ->default(true)
                            ->inline(false),
                    ]),
            ]);
    }
}
