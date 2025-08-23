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
        'phone',
        'social_links',
        'is_open',
        'is_featured',
    ];

    protected $casts = [
        'social_links' => 'array',
        'is_open'      => 'boolean',
        'is_featured'  => 'boolean',
        'address'      => 'array',
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

    // Province
    public function getProvinceIdAttribute()
    {
        return $this->address['province_id'] ?? null;
    }
    public function getProvinceNameAttribute()
    {
        return $this->address['province_name'] ?? null;
    }

    // City
    public function getCityIdAttribute()
    {
        return $this->address['city_id'] ?? null;
    }
    public function getCityNameAttribute()
    {
        return $this->address['city_name'] ?? null;
    }

    // Subdistrict
    public function getSubdistrictIdAttribute()
    {
        return $this->address['subdistrict_id'] ?? null;
    }
    public function getSubdistrictNameAttribute()
    {
        return $this->address['subdistrict_name'] ?? null;
    }

    // Postal Code
    public function getPostalCodeIdAttribute()
    {
        return $this->address['postal_code_id'] ?? null;
    }
    public function getPostalCodeAttribute()
    {
        return $this->address['postal_code'] ?? null;
    }

    // Country
    public function getCountryNameAttribute()
    {
        return $this->address['country'] ?? null;
    }

    // Address Line
    public function getStreetAddressAttribute()
    {
        return $this->address['street_address'] ?? null;
    }

    public function getFullAddressAttribute()
    {
        return "{$this->address_line}, {$this->subdistrict_name}, {$this->city_name}, {$this->province_name}, {$this->postal_code}, {$this->country_name}";
    }
}
