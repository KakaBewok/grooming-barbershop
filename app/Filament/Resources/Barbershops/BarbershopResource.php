<?php

namespace App\Filament\Resources\Barbershops;

use App\Filament\Resources\Barbershops\Pages\CreateBarbershop;
use App\Filament\Resources\Barbershops\Pages\EditBarbershop;
use App\Filament\Resources\Barbershops\Pages\ListBarbershops;
use App\Filament\Resources\Barbershops\RelationManagers\ImagesRelationManager;
use App\Filament\Resources\Barbershops\RelationManagers\ProductsRelationManager;
use App\Filament\Resources\Barbershops\RelationManagers\ServicesRelationManager;
use App\Filament\Resources\Barbershops\Schemas\BarbershopForm;
use App\Filament\Resources\Barbershops\Tables\BarbershopsTable;
use App\Models\Barbershop;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class BarbershopResource extends Resource
{
    protected static ?string $model = Barbershop::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-building-storefront';

    protected static string|UnitEnum|null $navigationGroup = 'Master Data';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return BarbershopForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BarbershopsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
        
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBarbershops::route('/'),
            'create' => CreateBarbershop::route('/create'),
            'edit' => EditBarbershop::route('/{record}/edit'),
        ];
    }
}
