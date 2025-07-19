<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    protected $fillable = [
        'id',
        'name',
        'slug',
        'description',
        'address',
        'phone',
        'social_links',
        'is_open',
    ];

    protected $casts = [
        'social_links' => 'array',
        'is_open' => 'boolean',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
