<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'addresses',
        'phone',
        'profile_photo',
        'date_of_birth',
        'gender',
        'bio',
        'withdrawal_pin',
        'withdrawal_pin_verified_at',
        'pin_last_changed_at',
        'password_changed_at',
        'login_attempts',
        'last_login_at',
        'notification_preferences',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'withdrawal_pin',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'addresses' => 'array',
            'date_of_birth' => 'date',
            'withdrawal_pin_verified_at' => 'datetime',
            'pin_last_changed_at' => 'datetime',
            'password_changed_at' => 'datetime',
            'last_login_at' => 'datetime',
            'notification_preferences' => 'array',
        ];
    }

    /**
     * Get the primary address
     */
    public function getPrimaryAddressAttribute()
    {
        if (!$this->addresses) {
            return null;
        }

        foreach ($this->addresses as $address) {
            if (isset($address['is_primary']) && $address['is_primary']) {
                return $address;
            }
        }

        // Return first address if no primary set
        return $this->addresses[0] ?? null;
    }

    /**
     * Add a new address
     */
    public function addAddress(array $address)
    {
        $addresses = $this->addresses ?? [];
        
        // If this is set as primary, remove primary from others
        if (isset($address['is_primary']) && $address['is_primary']) {
            foreach ($addresses as &$existingAddress) {
                $existingAddress['is_primary'] = false;
            }
        }

        // Add unique ID to address
        $address['id'] = uniqid();
        $addresses[] = $address;
        
        $this->addresses = $addresses;
        $this->save();
    }

    /**
     * Update an address
     */
    public function updateAddress(string $addressId, array $updatedData)
    {
        $addresses = $this->addresses ?? [];
        
        foreach ($addresses as &$address) {
            if ($address['id'] === $addressId) {
                // If setting as primary, remove primary from others
                if (isset($updatedData['is_primary']) && $updatedData['is_primary']) {
                    foreach ($addresses as &$otherAddress) {
                        $otherAddress['is_primary'] = false;
                    }
                }
                
                $address = array_merge($address, $updatedData);
                break;
            }
        }
        
        $this->addresses = $addresses;
        $this->save();
    }

    /**
     * Remove an address
     */
    public function removeAddress(string $addressId)
    {
        $addresses = $this->addresses ?? [];
        $addresses = array_filter($addresses, fn($address) => $address['id'] !== $addressId);
        
        $this->addresses = array_values($addresses);
        $this->save();
    }

    public function cart()
    {
        return $this->hasOne(Cart::class);
    }

    public function wishlist()
    {
        return $this->hasOne(Wishlist::class);
    }

    public function shop()
    {
        return $this->hasOne(Shop::class);
    }

    /**
     * Set withdrawal PIN with hashing
     */
    public function setWithdrawalPin(string $pin)
    {
        // Validate PIN is 6 digits
        if (!preg_match('/^\d{6}$/', $pin)) {
            throw new \InvalidArgumentException('Withdrawal PIN must be 6 digits');
        }

        $this->withdrawal_pin = bcrypt($pin);
        $this->pin_last_changed_at = now();
        $this->save();
    }

    /**
     * Verify withdrawal PIN
     */
    public function verifyWithdrawalPin(string $pin): bool
    {
        if (!$this->withdrawal_pin) {
            return false;
        }

        return password_verify($pin, $this->withdrawal_pin);
    }

    /**
     * Check if withdrawal PIN is set
     */
    public function hasWithdrawalPin(): bool
    {
        return !empty($this->withdrawal_pin);
    }

    /**
     * Mark withdrawal PIN as verified
     */
    public function markPinAsVerified()
    {
        $this->withdrawal_pin_verified_at = now();
        $this->save();
    }

    /**
     * Check if PIN was recently verified (within 30 minutes)
     */
    public function isPinRecentlyVerified(): bool
    {
        if (!$this->withdrawal_pin_verified_at) {
            return false;
        }

        return $this->withdrawal_pin_verified_at->diffInMinutes(now()) <= 30;
    }

    /**
     * Get default notification preferences
     */
    public function getNotificationPreferences(): array
    {
        return $this->notification_preferences ?? [
            'email_orders' => true,
            'email_marketing' => false,
            'sms_orders' => false,
            'sms_security' => true,
            'push_orders' => true,
            'push_marketing' => false,
        ];
    }
}
