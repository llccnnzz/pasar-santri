<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'description',
        'discount_type',
        'discount_value',
        'minimum_order_amount',
        'usage_limit',
        'used_count',
        'starts_at',
        'expires_at',
        'is_active',
    ];

    protected $casts = [
        'discount_value' => 'decimal:0',
        'minimum_order_amount' => 'decimal:0',
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
        'usage_limit' => 'integer',
        'used_count' => 'integer',
    ];

    /**
     * Check if promotion is currently valid
     */
    public function isValid(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        $now = Carbon::now();
        if ($now->lt($this->starts_at) || $now->gt($this->expires_at)) {
            return false;
        }

        if ($this->usage_limit && $this->used_count >= $this->usage_limit) {
            return false;
        }

        return true;
    }

    /**
     * Check if promotion can be used
     */
    public function canBeUsed(float $orderAmount = 0): bool
    {
        if (!$this->isValid()) {
            return false;
        }

        if ($orderAmount < $this->minimum_order_amount) {
            return false;
        }

        return true;
    }

    /**
     * Calculate discount amount for given order amount
     */
    public function calculateDiscount(float $orderAmount): float
    {
        if (!$this->canBeUsed($orderAmount)) {
            return 0;
        }

        // Only fixed discount type is supported
        return $this->discount_value;
    }

    /**
     * Increment usage count
     */
    public function incrementUsage(): void
    {
        $this->increment('used_count');
    }

    /**
     * Scope for active promotions
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for valid promotions (active and within date range)
     */
    public function scopeValid($query)
    {
        $now = Carbon::now();
        return $query->active()
            ->where('starts_at', '<=', $now)
            ->where('expires_at', '>=', $now);
    }

    /**
     * Scope for available promotions (valid and not exceeded usage limit)
     */
    public function scopeAvailable($query)
    {
        return $query->valid()
            ->where(function ($q) {
                $q->whereNull('usage_limit')
                  ->orWhereRaw('used_count < usage_limit');
            });
    }

    /**
     * Get status attribute
     */
    public function getStatusAttribute(): string
    {
        if (!$this->is_active) {
            return 'inactive';
        }

        $now = Carbon::now();
        if ($now->lt($this->starts_at)) {
            return 'scheduled';
        }

        if ($now->gt($this->expires_at)) {
            return 'expired';
        }

        if ($this->usage_limit && $this->used_count >= $this->usage_limit) {
            return 'limit_reached';
        }

        return 'active';
    }

    /**
     * Get status label
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'active' => 'Active',
            'inactive' => 'Inactive',
            'scheduled' => 'Scheduled',
            'expired' => 'Expired',
            'limit_reached' => 'Limit Reached',
            default => 'Unknown'
        };
    }

    /**
     * Get status color for display
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'active' => 'success',
            'inactive' => 'secondary',
            'scheduled' => 'info',
            'expired' => 'danger',
            'limit_reached' => 'warning',
            default => 'secondary'
        };
    }
}
