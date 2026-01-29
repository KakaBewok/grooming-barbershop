<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Str;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'crossed_out_price',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'crossed_out_price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    // Auto-generate slug from name
    protected static function booted(): void
    {
        static::creating(function ($service) {
            if (empty($service->slug)) {
                $service->slug = Str::slug($service->name);
            }
        });
    }

    // Relationships
    public function images(): HasMany
    {
        return $this->hasMany(ServiceImage::class)->orderBy('sort_order');
    }

    public function primaryImage(): HasMany
    {
        return $this->hasMany(ServiceImage::class)
            ->where('is_primary', true)
            ->limit(1);
    }

    public function orderItems(): MorphMany
    {
        return $this->morphMany(OrderItem::class, 'item');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Accessors
    public function getHasDiscountAttribute(): bool
    {
        return $this->crossed_out_price && $this->crossed_out_price > $this->price;
    }

    public function getDiscountPercentageAttribute(): ?float
    {
        if (!$this->has_discount) {
            return null;
        }

        return round((($this->crossed_out_price - $this->price) / $this->crossed_out_price) * 100, 2);
    }

    // Helper Methods
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}