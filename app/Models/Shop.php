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

}
