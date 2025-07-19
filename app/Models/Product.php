<?php

namespace App\Models;

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
        'brand',
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
    ];

    protected $casts = [
        'tags' => 'array',
        'specification' => 'array',
        'is_featured' => 'boolean',
        'is_popular' => 'boolean',
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

    public function getFinalStockAttribute()
    {
        if ($this['has_variant']) {
            return $this->variants()->sum('stock');
        }

        return $this['stock'];
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
}
