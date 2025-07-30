<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ShopBalance extends Model
{
    protected $fillable = [
        'shop_id',
        'balance',
        'pending_in',
        'pending_out',
    ];

    protected $casts = [
        'balance' => 'decimal:2',
        'pending_in' => 'decimal:2', 
        'pending_out' => 'decimal:2',
    ];

    /**
     * Get the shop that owns the balance.
     */
    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }

    /**
     * Get the balance logs for this shop.
     */
    public function logs(): HasMany
    {
        return $this->hasMany(ShopBalanceLog::class, 'shop_id', 'shop_id');
    }

    /**
     * Get available balance (already settled).
     */
    public function getAvailableBalanceAttribute(): float
    {
        return (float) $this->balance;
    }

    /**
     * Get pending balance (not yet settled).
     */
    public function getPendingBalanceAttribute(): float
    {
        return (float) $this->pending_in;
    }

    /**
     * Get total balance (available + pending).
     */
    public function getTotalBalanceAttribute(): float
    {
        return $this->available_balance + $this->pending_balance;
    }

    /**
     * Get formatted available balance.
     */
    public function getFormattedAvailableBalanceAttribute(): string
    {
        return 'Rp ' . number_format($this->available_balance, 0, ',', '.');
    }

    /**
     * Get formatted pending balance.
     */
    public function getFormattedPendingBalanceAttribute(): string
    {
        return 'Rp ' . number_format($this->pending_balance, 0, ',', '.');
    }

    /**
     * Get formatted total balance.
     */
    public function getFormattedTotalBalanceAttribute(): string
    {
        return 'Rp ' . number_format($this->total_balance, 0, ',', '.');
    }
}
