<?php

namespace App\Models;

use App\Enums\ItemType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'item_type',
        'item_id',
        'item_name',
        'price',
        'quantity',
        'subtotal',
    ];

    protected $casts = [
        'item_type' => ItemType::class,
        'price' => 'decimal:2',
        'quantity' => 'integer',
        'subtotal' => 'decimal:2',
    ];

    // Auto-calculate subtotal
    protected static function booted(): void
    {
        static::saving(function ($orderItem) {
            $orderItem->subtotal = $orderItem->price * $orderItem->quantity;
        });

        static::saved(function ($orderItem) {
            // Recalculate order total
            $orderItem->order->calculateTotal();
        });

        static::deleted(function ($orderItem) {
            // Recalculate order total
            $orderItem->order->calculateTotal();
        });
    }

    // Relationships
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function item(): MorphTo
    {
        return $this->morphTo('item', 'item_type', 'item_id');
    }

    // Helper method to get the actual item (Product or Service)
    public function getItemModel()
    {
        $modelClass = $this->item_type->modelClass();
        return $modelClass::find($this->item_id);
    }
}