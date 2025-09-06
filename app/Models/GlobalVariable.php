<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GlobalVariable extends Model
{
    protected $fillable = [
        'key',
        'type',
        'value',
    ];

    /**
     * Get a global variable value by key
     */
    public static function getValue(string $key, $default = null)
    {
        $variable = self::where('key', $key)->first();
        
        if (!$variable) {
            return $default;
        }

        // Cast value based on type
        return match($variable->type) {
            'float' => $variable->value ? (float) $variable->value : null,
            'int', 'integer' => $variable->value ? (int) $variable->value : null,
            'bool', 'boolean' => $variable->value ? (bool) $variable->value : null,
            'json' => $variable->value ? json_decode($variable->value, true) : null,
            default => $variable->value,
        };
    }

    /**
     * Set a global variable value
     */
    public static function setValue(string $key, $value, string $type = 'string'): bool
    {
        // Convert value to string for storage
        $stringValue = match($type) {
            'json' => json_encode($value),
            'bool', 'boolean' => $value ? '1' : '0',
            default => (string) $value,
        };

        return self::updateOrCreate(
            ['key' => $key],
            [
                'value' => $stringValue,
                'type' => $type,
            ]
        ) ? true : false;
    }

    /**
     * Get all payment fee related variables
     */
    public static function getPaymentFees(): array
    {
        $fees = self::where('key', 'LIKE', 'payment_fee%')->get();
        
        $result = [];
        foreach ($fees as $fee) {
            $result[$fee->key] = self::getValue($fee->key);
        }
        
        return $result;
    }
}
