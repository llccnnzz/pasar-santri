<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Product extends Model implements HasMedia
{
    use HasUuid, SoftDeletes, InteractsWithMedia;

    protected $fillable = [
        'sku',
        'name',
        'slug',
        'shop_id',
        'description',
        'meta_description',
        'long_description',
        'tags',
        'specification',
        'price',
        'final_price',
        'has_variant',
        'stock',
        'is_featured',
        'is_popular',
        'status',
        'meta_title',
        'meta_keywords',
        'weight',
        'dimensions',
        'brand',
    ];

    protected $casts = [
        'tags' => 'array',
        'specification' => 'array',
        'dimensions' => 'array',
        'is_featured' => 'boolean',
        'is_popular' => 'boolean',
        'has_variant' => 'boolean',
    ];

    // Query Scopes for Performance
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopePopular($query)
    {
        return $query->where('is_popular', true);
    }

    public function scopeActive($query)
    {
        return $query->whereNull('deleted_at');
    }

    public function variants() {
        return $this->hasMany(ProductVariant::class);
    }

    public function categories() {
        return $this->belongsToMany(Category::class);
    }

    // Accessor to get the first category for display purposes
    public function getFirstCategoryAttribute() {
        return $this->categories->first();
    }

    // Helper method to get primary category name
    public function getPrimaryCategoryNameAttribute() {
        $firstCategory = $this->categories->first();
        return $firstCategory ? $firstCategory->name : 'N/A';
    }

    public function getFinalStockAttribute()
    {
        if ($this['has_variant']) {
            return $this->variants()->sum('stock');
        }

        return $this['stock'];
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function getBranxAttribute()
    {
        return $this->shop ? $this->shop->name : '??????';
    }

    public function defaultImage()
    {
        return $this->morphOne(config('media-library.media_model'), 'model')->where('collection_name', 'default-image');
    }

    public function hoverImage()
    {
        return $this->morphOne(config('media-library.media_model'), 'model')->where('collection_name', 'hover-image');
    }

    public function images()
    {
        return $this->morphMany(config('media-library.media_model'), 'model')->where('collection_name', 'image');
    }

    /**
     * Relationship with ProductAd
     */
    public function productAds()
    {
        return $this->hasMany(ProductAd::class);
    }

    /**
     * Get active product ads
     */
    public function activeProductAds()
    {
        return $this->hasMany(ProductAd::class)->where('is_active', true);
    }
}
