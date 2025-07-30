<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShopBank extends Model
{
    protected $fillable = [
        'shop_id',
        'bank_code',
        'bank_name', 
        'custom_bank_name',
        'account_number',
        'is_default',
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    /**
     * Get the shop that owns the bank account.
     */
    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }

    /**
     * Set this bank account as default and unset others.
     */
    public function setAsDefault(): void
    {
        // Remove default status from all other bank accounts for this shop
        static::where('shop_id', $this->shop_id)
            ->where('id', '!=', $this->id)
            ->update(['is_default' => false]);

        // Set this account as default
        $this->update(['is_default' => true]);
    }

    /**
     * Scope to get default bank account for a shop.
     */
    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }

    /**
     * Get formatted account number (masked).
     */
    public function getFormattedAccountNumberAttribute(): string
    {
        if (strlen($this->account_number) > 4) {
            return str_repeat('*', strlen($this->account_number) - 4) . substr($this->account_number, -4);
        }
        return $this->account_number;
    }
}
