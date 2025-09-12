<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;

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
