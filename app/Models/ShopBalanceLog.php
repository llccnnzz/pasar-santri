<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShopBalanceLog extends Model
{
    protected $fillable = [
        'shop_id',
        'type',
        'amount',
        'details',
        'shop_bank_id',
        'reference',
        'status',
        'processed_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'details' => 'array',
        'processed_at' => 'datetime',
    ];

    /**
     * Get the shop that owns the balance log.
     */
    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }

    /**
     * Get the bank account associated with this log.
     */
    public function shopBank(): BelongsTo
    {
        return $this->belongsTo(ShopBank::class);
    }

    /**
     * Get formatted amount.
     */
    public function getFormattedAmountAttribute(): string
    {
        $prefix = $this->type === 'in' ? '+' : '-';
        return $prefix . 'Rp ' . number_format($this->amount, 0, ',', '.');
    }

    /**
     * Get status badge class.
     */
    public function getStatusBadgeClassAttribute(): string
    {
        return match($this->status) {
            'completed' => 'bg-success-transparent text-success',
            'pending' => 'bg-warning-transparent text-warning',
            'failed' => 'bg-danger-transparent text-danger',
            default => 'bg-secondary-transparent text-secondary',
        };
    }

    /**
     * Get type badge class.
     */
    public function getTypeBadgeClassAttribute(): string
    {
        return match($this->type) {
            'in' => 'bg-success-transparent text-success',
            'out' => 'bg-danger-transparent text-danger',
            default => 'bg-secondary-transparent text-secondary',
        };
    }

    /**
     * Get type label.
     */
    public function getTypeLabelAttribute(): string
    {
        return match($this->type) {
            'in' => 'Income',
            'out' => 'Withdrawal',
            default => 'Unknown',
        };
    }

    /**
     * Scope to get income transactions.
     */
    public function scopeIncome($query)
    {
        return $query->where('type', 'in');
    }

    /**
     * Scope to get withdrawal transactions.
     */
    public function scopeWithdrawals($query)
    {
        return $query->where('type', 'out');
    }

    /**
     * Scope to get completed transactions.
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope to get pending transactions.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}
