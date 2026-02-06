<?php

namespace App\Models;

use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'order_date',
        'total_amount',
        'discount',
        'payment_method',
        'status',
        'notes',
        'created_by',
        'total_paid',
        'change_amount',
    ];

    protected $casts = [
        'order_date' => 'datetime',
        'total_amount' => 'decimal:2',
        'total_paid' => 'decimal:2',
        'change_amount' => 'decimal:2',
        'discount' => 'decimal:2',
        'payment_method' => PaymentMethod::class,
        'status' => OrderStatus::class,
    ];

    // Auto-generate order number
    protected static function booted(): void
    {
        static::creating(function ($order) {
            if (empty($order->order_number)) {
                $order->order_number = static::generateOrderNumber();
            }

            if (empty($order->order_date)) {
                $order->order_date = now();
            }

            if (empty($order->created_by) && auth()->check()) {
                $order->created_by = auth()->id();
            }
        });
    }

    // Relationships

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', OrderStatus::PENDING);
    }

    public function scopePaid($query)
    {
        return $query->where('status', OrderStatus::PAID);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', OrderStatus::COMPLETED);
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', OrderStatus::CANCELLED);
    }

    // Accessors
    public function getFinalAmountAttribute(): float
    {
        return max(0, $this->total_amount - $this->discount);
    }

    // Helper Methods
    public static function generateOrderNumber(): string
    {
        $date = now()->format('Ymd');
        $random = strtoupper(substr(uniqid(), -6));
        
        return "ORD-{$date}-{$random}";
    }

    public function calculateTotal(): void
    {
        $this->total_amount = $this->items->sum('subtotal');
        $this->save();
    }

    public function markAsPaid(): void
    {
        $this->update(['status' => OrderStatus::PAID]);
    }

    public function markAsCompleted(): void
    {
        $this->update(['status' => OrderStatus::COMPLETED]);
    }

    public function cancel(): void
    {
        $this->update(['status' => OrderStatus::CANCELLED]);
        
        // Restore product stock
        foreach ($this->items as $item) {
            if ($item->item_type === 'product' && $item->item) {
                $item->item->incrementStock($item->quantity);
            }
        }
    }
}