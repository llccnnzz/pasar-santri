<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'shop_id',
        'invoice',
        'status',
        'order_details',
        'payment_detail',
        'cancellation_reason',
        'shipment_ref_id',
        'tracking_details',
        'has_reviewed',
        'has_settlement',
        'biteship_order',
    ];

    protected $casts = [
        'id' => 'string',
        'order_details' => 'array',
        'payment_detail' => 'array',
        'tracking_details' => 'array',
        'has_reviewed' => 'boolean',
        'has_settlement' => 'boolean',
        'shipment_ref_id' => 'string',
        'biteship_order' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }

            if (empty($model->invoice)) {
                $model->invoice = static::generateInvoiceNumber();
            }
        });
    }

    public static function generateReferenceId($length = 6)
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        return substr(str_shuffle(str_repeat($characters, $length)), 0, $length);
    }

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(OrderPayment::class);
    }

    public function successfulPayment(): HasMany
    {
        return $this->hasMany(OrderPayment::class)->where('status', 'success');
    }

    public function latestPayment(): HasMany
    {
        return $this->hasMany(OrderPayment::class)->latest();
    }

    // Utility Methods
    public static function generateInvoiceNumber(): string
    {
        $date = Carbon::now()->format('Y-m-d');
        $randomChars = strtoupper(Str::random(4));

        // Ensure uniqueness
        do {
            $invoice = "INV/{$date}/{$randomChars}";
            $exists = static::where('invoice', $invoice)->exists();

            if ($exists) {
                $randomChars = strtoupper(Str::random(4));
            }
        } while ($exists);

        return $invoice;
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'pending' => 'warning',
            'paid' => 'info',
            'confirmed' => 'info',
            'processing' => 'primary',
            'shipped' => 'secondary',
            'delivered' => 'success',
            'finished' => 'success',
            'cancelled' => 'danger',
            'refunded' => 'dark',
            default => 'light'
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pending' => 'Pending',
            'paid' => 'Paid',
            'confirmed' => 'Confirmed',
            'processing' => 'Processing',
            'shipped' => 'Shipped',
            'delivered' => 'Delivered',
            'finished' => 'Finished',
            'cancelled' => 'Cancelled',
            'refunded' => 'Refunded',
            default => ucfirst($this->status)
        };
    }

    public function getTotalAmountAttribute(): float
    {
        return $this->payment_detail['total_amount'] ?? 0;
    }

    public function getSubtotalAttribute(): float
    {
        return $this->payment_detail['subtotal'] ?? 0;
    }

    public function getShippingCostAttribute(): float
    {
        return $this->payment_detail['shipping_cost'] ?? 0;
    }

    public function getTaxAmountAttribute(): float
    {
        return $this->payment_detail['tax_amount'] ?? 0;
    }

    public function getDiscountAmountAttribute(): float
    {
        return $this->payment_detail['discount_amount'] ?? 0;
    }

    public function getOrderItemsAttribute(): array
    {
        return $this->order_details['items'] ?? [];
    }

    public function getOrderItemsCountAttribute(): int
    {
        return count($this->order_items);
    }

    public function getOrderQuantityAttribute(): int
    {
        return collect($this->order_items)->sum('quantity');
    }

    // Status Check Methods
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isConfirmed(): bool
    {
        return $this->status === 'confirmed';
    }

    public function isProcessing(): bool
    {
        return $this->status === 'processing';
    }

    public function isShipped(): bool
    {
        return $this->status === 'shipped';
    }

    public function isDelivered(): bool
    {
        return $this->status === 'delivered';
    }

    public function isCancelled(): bool
    {
        return $this->status === 'cancelled';
    }

    public function isRefunded(): bool
    {
        return $this->status === 'refunded';
    }

    public function canBeCancelled(): bool
    {
        return in_array($this->status, ['pending', 'confirmed']);
    }

    public function canBeProcessed(): bool
    {
        return in_array($this->status, ['confirmed']);
    }

    public function canBeShipped(): bool
    {
        return in_array($this->status, ['processing']);
    }

    public function canBeDelivered(): bool
    {
        return in_array($this->status, ['shipped']);
    }

    public function hasSuccessfulPayment(): bool
    {
        return $this->payments()->where('status', 'success')->exists();
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function scopeProcessing($query)
    {
        return $query->where('status', 'processing');
    }

    public function scopeShipped($query)
    {
        return $query->where('status', 'shipped');
    }

    public function scopeDelivered($query)
    {
        return $query->where('status', 'delivered');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    public function scopeRefunded($query)
    {
        return $query->where('status', 'refunded');
    }

    public function scopeForShop($query, $shopId)
    {
        return $query->where('shop_id', $shopId);
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeWithSuccessfulPayment($query)
    {
        return $query->whereHas('payments', function ($q) {
            $q->where('status', 'success');
        });
    }

    public function scopeNeedsSettlement($query)
    {
        return $query->where('has_settlement', false)
                    ->whereIn('status', ['delivered'])
                    ->withSuccessfulPayment();
    }
}
