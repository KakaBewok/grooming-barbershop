<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class BarbershopImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'barbershop_id',
        'image_path',
        'caption',
        'is_featured',
        'sort_order',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'sort_order' => 'integer',
    ];

    // Relationships
    public function barbershop(): BelongsTo
    {
        return $this->belongsTo(Barbershop::class);
    }

    // Accessors
    public function getImageUrlAttribute(): string
    {
        return Storage::url($this->image_path);
    }

    // Model Events
    protected static function booted(): void
    {
        static::deleting(function ($image) {
            // Delete the file when model is deleted
            if (Storage::exists($image->image_path)) {
                Storage::delete($image->image_path);
            }
        });
    }
}