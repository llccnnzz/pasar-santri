<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use App\Traits\HasUuid;

class Shop extends Model implements HasMedia
{
    use InteractsWithMedia, HasUuid;
    protected $fillable = [
        'id',
        'name',
        'slug',
        'description',
        'address',
        'phone',
        'social_links',
        'is_open',
        'is_featured',
    ];

    protected $casts = [
        'social_links' => 'array',
        'is_open' => 'boolean',
        'is_featured' => 'boolean',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('logo')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);
    }

    public function getLogoAttribute()
    {
        return $this->getFirstMedia('logo');
    }
}
