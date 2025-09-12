<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductAd extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'category',
        'sort_order',
        'valid_until',
        'is_active',
        'submission_type',
        'admin_notes'
    ];

    protected $casts = [
        'valid_until' => 'datetime',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Category constants
    const CATEGORY_FLASH_SALE = 'flash_sale';
    const CATEGORY_HOT_PROMO = 'hot_promo';
    const CATEGORY_BIG_DISCOUNT = 'big_discount';
    const CATEGORY_NEW_PRODUCT = 'new_product';
    const CATEGORY_LESS_THAN_10K = 'less_than_10k';

    const CATEGORIES = [
        self::CATEGORY_FLASH_SALE => 'Flash Sale',
        self::CATEGORY_HOT_PROMO => 'Hot Promo',
        self::CATEGORY_BIG_DISCOUNT => 'Big Discount',
        self::CATEGORY_NEW_PRODUCT => 'New Product',
        self::CATEGORY_LESS_THAN_10K => 'Less Than Rp10K'
    ];

    const SUBMISSION_TYPE_MANUAL = 'manual';
    const SUBMISSION_TYPE_AUTO_SUGGEST = 'auto_suggest';

    /**
     * Relationship with Product
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Scope: Active ads
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope: By category
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope: Valid flash sale ads (not expired)
     */
    public function scopeValidFlashSale($query)
    {
        return $query->where('category', self::CATEGORY_FLASH_SALE)
                    ->where(function($q) {
                        $q->whereNull('valid_until')
                          ->orWhere('valid_until', '>', now());
                    });
    }

    /**
     * Scope: Ordered for display
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc')
                    ->orderBy('created_at', 'desc');
    }

    /**
     * Check if flash sale is still valid
     */
    public function isValidFlashSale(): bool
    {
        if ($this->category !== self::CATEGORY_FLASH_SALE) {
            return false;
        }

        return is_null($this->valid_until) || $this->valid_until > now();
    }

    /**
     * Get formatted category name
     */
    public function getCategoryNameAttribute(): string
    {
        return self::CATEGORIES[$this->category] ?? $this->category;
    }

    /**
     * Check if ad is expired (for flash sale)
     */
    public function getIsExpiredAttribute(): bool
    {
        if ($this->category === self::CATEGORY_FLASH_SALE && $this->valid_until) {
            return $this->valid_until < now();
        }
        return false;
    }

    /**
     * Auto-suggest products for each category
     */
    public static function getAutoSuggestProducts($category, $limit = 20)
    {
        $query = Product::query()->where('status', 'active');

        switch ($category) {
            case self::CATEGORY_BIG_DISCOUNT:
                // Products with discount more than 40%
                $query->whereHas('variants', function($q) {
                    $q->whereRaw('((price - final_price) / price * 100) > 40')
                      ->where('final_price', '>', 0);
                });
                break;

            case self::CATEGORY_NEW_PRODUCT:
                // Products created less than 7 days ago (expanded for demo data)
                $query->where('created_at', '>', now()->subDays(7));
                break;

            case self::CATEGORY_LESS_THAN_10K:
                // Products with price less than Rp50,000 (adjusted for demo data)
                $query->whereHas('variants', function($q) {
                    $q->where('final_price', '>', 0)
                      ->where('final_price', '<', 50000);
                });
                break;
        }

        // Exclude products already in this category
        $excludeIds = self::where('category', $category)
                         ->where('is_active', true)
                         ->pluck('product_id');

        if ($excludeIds->isNotEmpty()) {
            $query->whereNotIn('id', $excludeIds);
        }

        return $query->with(['variants', 'media'])
                    ->limit($limit)
                    ->get();
    }
}
