<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
               Section::make('User Information')
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('email')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),

                        TextInput::make('password')
                            ->password()
                            ->required(fn (string $operation): bool => $operation === 'create')
                            ->dehydrated(fn ($state) => filled($state))
                            ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                            ->maxLength(255)
                            ->helperText(fn (string $operation): string => 
                                $operation === 'edit' ? 'Leave blank to keep current password' : ''
                            ),

                        TextInput::make('password_confirmation')
                            ->password()
                            ->required(fn (string $operation): bool => $operation === 'create')
                            ->same('password')
                            ->dehydrated(false)
                            ->maxLength(255)
                            ->label('Confirm Password'),
                    ])
                    ->columns(2),

                Section::make('Role & Permissions')
                    ->schema([
                        Select::make('role')
                            ->options([
                                'admin' => 'Admin',
                                'cashier' => 'Cashier',
                            ])
                            ->default('cashier')
                            ->required()
                            ->native(false)
                            ->helperText('Admin has full access, Cashier can only create orders'),
                    ]),
            ]);
    }
}
