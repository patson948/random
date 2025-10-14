<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'subtotal',
        'tax',
        'shipping',
        'total',
        'status',
        'payment_status',
        'payment_method',
        'payment_reference',
        'shipping_address',
        'notes',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'tax' => 'decimal:2',
        'shipping' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    // ==================== Relationships ====================

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    // ==================== Query Scopes ====================

    /**
     * Scope for orders by status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope for pending orders
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for processing orders
     */
    public function scopeProcessing($query)
    {
        return $query->where('status', 'processing');
    }

    /**
     * Scope for completed orders
     */
    public function scopeCompleted($query)
    {
        return $query->whereIn('status', ['delivered', 'completed']);
    }

    /**
     * Scope for paid orders
     */
    public function scopePaid($query)
    {
        return $query->where('payment_status', 'paid');
    }

    /**
     * Scope for unpaid orders
     */
    public function scopeUnpaid($query)
    {
        return $query->where('payment_status', 'pending');
    }

    /**
     * Scope for orders by user
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope with common relations (optimized for listing)
     */
    public function scopeWithCommonRelations($query)
    {
        return $query->with([
            'user:id,name,email',
            'items' => function ($query) {
                $query->select('id', 'order_id', 'product_id', 'vendor_id', 'quantity', 'price', 'total')
                      ->with('product:id,name,slug,images');
            }
        ])->withCount('items');
    }

    /**
     * Scope for date range
     */
    public function scopeDateRange($query, $startDate, $endDate = null)
    {
        if ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        }
        if ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }
        return $query;
    }

    // ==================== Helper Methods ====================

    public static function generateOrderNumber(): string
    {
        return 'ORD-' . strtoupper(uniqid());
    }

    /**
     * Get order status badge color
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'pending' => 'yellow',
            'processing' => 'blue',
            'shipped' => 'indigo',
            'delivered' => 'green',
            'cancelled' => 'red',
            default => 'gray'
        };
    }

    /**
     * Get payment status badge color
     */
    public function getPaymentStatusColorAttribute(): string
    {
        return match($this->payment_status) {
            'paid' => 'green',
            'pending' => 'yellow',
            'failed' => 'red',
            'refunded' => 'orange',
            default => 'gray'
        };
    }

    /**
     * Check if order can be cancelled
     */
    public function canBeCancelled(): bool
    {
        return in_array($this->status, ['pending', 'processing']);
    }

    /**
     * Check if order can be refunded
     */
    public function canBeRefunded(): bool
    {
        return $this->payment_status === 'paid' && 
               in_array($this->status, ['pending', 'processing', 'shipped']);
    }
}



