<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUuid;

class AttributeValue extends Model
{
    use HasUuid;

    protected $fillable = [
        'attribute_id',
        'value'
    ];

    public function attribute() {
        return $this->belongsTo(Attribute::class);
    }

    public function variants() {
        return $this->belongsToMany(ProductVariant::class);
    }
}
