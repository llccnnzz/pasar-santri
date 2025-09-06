<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class ShippingMethod extends Model
{
    use HasUuids;

    protected $table    = 'shipping_methods';
    protected $fillable = [
        'courier_code',
        'courier_name',
        'service_code',
        'service_name',
        'description',
        'logo_url',
        'active',
    ];
}
