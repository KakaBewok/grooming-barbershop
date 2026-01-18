<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class ServiceImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'image_path',
        'is_primary',
        'sort_order',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
        'sort_order' => 'integer',
    ];

    // Relationships
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    // Accessors
    public function getImageUrlAttribute(): string
    {
        return Storage::url($this->image_path);
    }

    // Model Events
    protected static function booted(): void
    {
        // Ensure only one primary image per service
        static::saving(function ($image) {
            if ($image->is_primary) {
                static::where('service_id', $image->service_id)
                    ->where('id', '!=', $image->id)
                    ->update(['is_primary' => false]);
            }
        });

        static::deleting(function ($image) {
            // Delete the file when model is deleted
            if (Storage::exists($image->image_path)) {
                Storage::delete($image->image_path);
            }
        });
    }
}