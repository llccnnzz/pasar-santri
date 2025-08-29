<?php
namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Shop extends Model implements HasMedia
{
    use InteractsWithMedia, HasUuid;
    protected $fillable = [
        'id',
        'user_id',
        'name',
        'slug',
        'description',
        'address',
        'province',
        'city',
        'subdistrict',
        'village',
        'postal_code',
        'phone',
        'social_links',
        'is_open',
        'is_featured',
    ];

    protected $casts = [
        'social_links' => 'array',
        'is_open'      => 'boolean',
        'is_featured'  => 'boolean',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
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

    public function banks()
    {
        return $this->hasMany(ShopBank::class);
    }

    public function defaultBank()
    {
        return $this->hasOne(ShopBank::class)->where('is_default', true);
    }

    public function getFullAddressAttribute()
    {
        return "{$this->address}, {$this->subdistrict}, {$this->city}, {$this->province}, {$this->village}, {$this->postal_code}, {$this->country}";
    }
}
