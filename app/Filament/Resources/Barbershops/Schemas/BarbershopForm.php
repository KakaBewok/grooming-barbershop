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
                Section::make('Info Dasar')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Barbershop')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (string $operation, $state, Set $set) => 
                                $operation === 'create' ? $set('slug', Str::slug($state)) : null
                            ),
                        Textarea::make('description')
                            ->label('Deskripsi')
                            ->rows(3)
                            ->placeholder('Contoh: Gaya Modern, Potongan Presisi. Karaktermu Dimulai di Sini.')
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),
                Section::make('Info Kontak')
                    ->schema([
                        Textarea::make('address')
                            ->label('Alamat')
                            ->rows(2)
                            ->columnSpanFull(),
                        TextInput::make('phone')
                            ->label('Nomor Telepon')
                            ->tel()
                            ->maxLength(20),

                        TextInput::make('google_maps_url')
                            ->label('Link Google Maps')
                            ->url()
                            ->placeholder('https://maps.google.com/?q=...'),

                        TextInput::make('instagram_url')
                            ->url()
                            ->label('Link Instagram')
                            ->placeholder('https://instagram.com/username'),

                        TextInput::make('tiktok_url')
                            ->url()
                            ->label('Link TikTok')
                            ->placeholder('https://tiktok.com/@username'),
                    ])
                    ->columns(2)
                    ->collapsible(),

                Section::make('Jam Operasional')
                    ->schema([
                        Repeater::make('opening_hours')
                            ->hiddenLabel()
                            ->schema([
                                Select::make('day')
                                    ->label('Hari')
                                    ->options([
                                        'Senin' => 'Senin',
                                        'Selasa' => 'Selasa',
                                        'Rabu' => 'Rabu',
                                        'Kamis' => 'Kamis',
                                        'Jumat' => 'Jumat',
                                        'Sabtu' => 'Sabtu',
                                        'Minggu' => 'Minggu',
                                    ])
                                    ->required()
                                    ->disableOptionsWhenSelectedInSiblingRepeaterItems(),

                                TimePicker::make('open')
                                    ->label('Buka')
                                    ->required()
                                    ->seconds(false),
                                TimePicker::make('close')
                                    ->label('Tutup')
                                    ->required()
                                    ->seconds(false),
                            ])
                            ->maxItems(7)
                            ->columns(3)
                            ->addActionLabel('Tambah Jadwal')
                            ->defaultItems(0)
                            ->collapsible()
                            ->columnSpanFull()
                            ->default([
                                ['day' => 'Senin', 'open' => '09:00', 'close' => '21:00'],
                                ['day' => 'Selasa', 'open' => '09:00', 'close' => '21:00'],
                                ['day' => 'Rabu', 'open' => '09:00', 'close' => '21:00'],
                                ['day' => 'Kamis', 'open' => '09:00', 'close' => '21:00'],
                                ['day' => 'Jumat', 'open' => '09:00', 'close' => '21:00'],
                                ['day' => 'Sabtu', 'open' => '09:00', 'close' => '21:00'],
                                ['day' => 'Minggu', 'open' => '09:00', 'close' => '21:00'],
                            ]),
                    ])
                    ->collapsible(),

                Section::make('Status')
                    ->schema([
                        Toggle::make('is_active')
                            ->label('Active')
                            ->default(true)
                            ->inline(false),
                    ])
                    ->collapsible(),
                Section::make('Gambar Barbershop')
                    ->description('Upload beberapa gambar barbershop untuk ditampilkan di halaman detail barbershop dan beranda.')
                    ->schema([
                        Repeater::make('barbershopImages')
                            ->relationship('images')
                            ->hiddenLabel()
                            ->schema([
                                FileUpload::make('image_path')
                                    ->label('Gambar')
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
                                    ->helperText('Tandai gambar ini untuk ditampilkan sebagai gambar utama barbershop.')
                                    ->inline(false)
                                    ->columnSpan(1),

                                TextInput::make('sort_order')
                                    ->label('Urutan Tampil')
                                    ->numeric()
                                    ->default(1)
                                    ->minValue(1)
                                    ->columnSpan(1),
                            ])
                            ->columns(2)
                            ->defaultItems(1)
                            ->addActionLabel('Tambah Gambar')
                            ->reorderable('sort_order')
                            ->collapsible()
                            ->itemLabel(fn (array $state): ?string => $state['caption'] ?? 'Image')
                            ->columnSpanFull(),
                    ])
                    ->collapsible()
                    ->collapsed(false),
            ]);
    }
}
