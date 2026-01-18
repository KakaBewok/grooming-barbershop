<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'barbershop_id',
        'name',
        'slug',
        'description',
        'price',
        'crossed_out_price',
        'stock',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'crossed_out_price' => 'decimal:2',
        'stock' => 'integer',
        'is_active' => 'boolean',
    ];

    // Auto-generate slug from name
    protected static function booted(): void
    {
        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    // Relationships
    public function barbershop(): BelongsTo
    {
        return $this->belongsTo(Barbershop::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function primaryImage(): HasMany
    {
        return $this->hasMany(ProductImage::class)
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

    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
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

    public function getIsInStockAttribute(): bool
    {
        return $this->stock > 0;
    }

    // Helper Methods
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function decrementStock(int $quantity): bool
    {
        if ($this->stock < $quantity) {
            return false;
        }

        $this->decrement('stock', $quantity);
        return true;
    }

    public function incrementStock(int $quantity): void
    {
        $this->increment('stock', $quantity);
    }
}