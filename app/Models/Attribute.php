<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUuid;

class Attribute extends Model
{
    use HasUuid;

    protected $fillable = [
        'name',
    ];

    public function AttributeValues() {
        return $this->hasMany(AttributeValue::class);
    }
}
