<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class ProductVariant extends Model implements HasMedia
{
    use HasUuid, InteractsWithMedia;

    protected $fillable = [
        'product_id',
        'sku',
        'price',
        'final_price',
        'stock',
    ];

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function attributeValues() {
        return $this->belongsToMany(AttributeValue::class)->with('attribute');
    }

    public function image()
    {
        return $this->morphOne(config('media-library.media_model'), 'model')->where('collection_name', 'image');
    }
}
