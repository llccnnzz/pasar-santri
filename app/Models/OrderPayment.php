<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'payment_method_id',
        'channel',
        'reference_id',
        'status',
        'value',
        'payment_fee',
        'json_callback',
        'expired_at',
        'paid_at',
    ];

    protected $casts = [
        'value'             => 'decimal:2',
        'payment_fee'       => 'decimal:2',
        'json_callback'     => 'array',
        'payment_method_id' => 'integer',
        'expired_at'        => 'datetime',
        'paid_at'           => 'datetime',
    ];

    // Relationships
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    // Utility Methods
    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'warning',
            'processing' => 'info',
            'success' => 'success',
            'failed' => 'danger',
            'cancelled' => 'secondary',
            'expired' => 'dark',
            default => 'light'
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'Pending',
            'processing' => 'Processing',
            'success' => 'Success',
            'failed' => 'Failed',
            'cancelled' => 'Cancelled',
            'expired' => 'Expired',
            default => ucfirst($this->status)
        };
    }

    public function getChannelLabelAttribute(): string
    {
        return match ($this->channel) {
            'xendit' => 'Xendit',
            'midtrans' => 'Midtrans',
            'bank_transfer' => 'Bank Transfer',
            'bank' => 'Bank Transfer',
            'ewallet' => 'E-Wallet',
            'credit_card' => 'Credit Card',
            'debit_card' => 'Debit Card',
            'qris' => 'QRIS',
            'virtual_account' => 'Virtual Account',
            'emaal' => 'E-Maal',
            default => ucfirst(str_replace('_', ' ', $this->channel))
        };
    }

    public function getTotalAmountAttribute(): float
    {
        return $this->value + $this->payment_fee;
    }

    public function getNetAmountAttribute(): float
    {
        return $this->value - $this->payment_fee;
    }

    // Status Check Methods
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isProcessing(): bool
    {
        return $this->status === 'processing';
    }

    public function isSuccess(): bool
    {
        return $this->status === 'success';
    }

    public function isFailed(): bool
    {
        return $this->status === 'failed';
    }

    public function isCancelled(): bool
    {
        return $this->status === 'cancelled';
    }

    public function isExpired(): bool
    {
        return $this->status === 'expired';
    }

    public function isCompleted(): bool
    {
        return in_array($this->status, ['success', 'failed', 'cancelled', 'expired']);
    }

    public function canBeRetried(): bool
    {
        return in_array($this->status, ['failed', 'expired']);
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeProcessing($query)
    {
        return $query->where('status', 'processing');
    }

    public function scopeSuccess($query)
    {
        return $query->where('status', 'success');
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    public function scopeExpired($query)
    {
        return $query->where('status', 'expired');
    }

    public function scopeCompleted($query)
    {
        return $query->whereIn('status', ['success', 'failed', 'cancelled', 'expired']);
    }

    public function scopeForChannel($query, $channel)
    {
        return $query->where('channel', $channel);
    }

    public function scopeForOrder($query, $orderId)
    {
        return $query->where('order_id', $orderId);
    }
}
