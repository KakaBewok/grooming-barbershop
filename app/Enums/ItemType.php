<?php

namespace App\Enums;

enum ItemType: string
{
    case PRODUCT = 'product';
    case SERVICE = 'service';

    public function label(): string
    {
        return match($this) {
            self::PRODUCT => 'Product',
            self::SERVICE => 'Service',
        };
    }

    public function modelClass(): string
    {
        return match($this) {
            self::PRODUCT => \App\Models\Product::class,
            self::SERVICE => \App\Models\Service::class,
        };
    }

    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn($case) => [$case->value => $case->label()])
            ->toArray();
    }
}