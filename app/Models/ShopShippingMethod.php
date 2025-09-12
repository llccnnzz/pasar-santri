<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class ShopShippingMethod extends Model
{
    use HasUuids;

    protected $table    = 'shop_shipping_methods';
    protected $fillable = ['shop_id', 'shipping_method_id', 'enabled'];

    public function shippingMethod()
    {
        return $this->belongsTo(ShippingMethod::class);
    }
}
