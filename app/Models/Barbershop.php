<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Barbershop extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'address',
        'phone',
        'google_maps_url',
        'instagram_url',
        'tiktok_url',
        'opening_hours',
        'is_active',
    ];

    protected $casts = [
        'opening_hours' => 'array',
        'is_active' => 'boolean',
    ];

    // Auto-generate slug from name
    protected static function booted(): void
    {
        static::creating(function ($barbershop) {
            if (empty($barbershop->slug)) {
                $barbershop->slug = Str::slug($barbershop->name);
            }
        });
    }

    // Relationships
    public function images(): HasMany
    {
        return $this->hasMany(BarbershopImage::class)->orderBy('sort_order');
    }

    public function featuredImages(): HasMany
    {
        return $this->hasMany(BarbershopImage::class)
            ->where('is_featured', true)
            ->orderBy('sort_order');
    }

    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }

    public function activeServices(): HasMany
    {
        return $this->hasMany(Service::class)->where('is_active', true);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function activeProducts(): HasMany
    {
        return $this->hasMany(Product::class)->where('is_active', true);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Helper Methods
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}