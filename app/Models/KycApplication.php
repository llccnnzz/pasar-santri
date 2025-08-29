<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class KycApplication extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia;

    protected $keyType   = 'string';
    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'date_of_birth',
        'gender',
        'nationality',
        'address',
        'province',
        'city',
        'subdistrict',
        'village',
        'postal_code',
        'country',
        'phone',
        'document_type',
        'document_number',
        'document_expiry_date',
        'document_issued_country',
        'document_front_photo',
        'selfie_photo',
        'additional_documents',
        'status',
        'rejection_reason',
        'admin_notes',
        'reviewed_by',
        'reviewed_at',
        'ip_address',
        'user_agent',
        'terms_accepted',
        'privacy_accepted',
    ];

    protected $casts = [
        'id'                   => 'string',
        'date_of_birth'        => 'date',
        'document_expiry_date' => 'date',
        'reviewed_at'          => 'datetime',
        'terms_accepted'       => 'boolean',
        'privacy_accepted'     => 'boolean',
        'document_front_photo' => 'array',
        'selfie_photo'         => 'array',
        'additional_documents' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    // Media Collections
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('document_front')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/jpg', 'image/webp']);

        $this->addMediaCollection('document_back')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/jpg', 'image/webp']);

        $this->addMediaCollection('selfie')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/jpg', 'image/webp']);

        $this->addMediaCollection('additional_docs')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/jpg', 'image/webp', 'application/pdf']);
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(300)
            ->height(300)
            ->sharpen(10);

        $this->addMediaConversion('preview')
            ->width(800)
            ->height(600)
            ->nonQueued();
    }

    // Status Methods
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isUnderReview(): bool
    {
        return $this->status === 'under_review';
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    // Utility Methods
    public function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'warning',
            'under_review'    => 'info',
            'approved'        => 'success',
            'rejected'        => 'danger',
            default           => 'secondary'
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending'         => 'Pending',
            'under_review'    => 'Under Review',
            'approved'        => 'Approved',
            'rejected'        => 'Rejected',
            default           => 'Unknown'
        };
    }

    public function getDocumentTypeLabel(): string
    {
        return match ($this->document_type) {
            'national_id'     => 'National ID',
            'passport'        => 'Passport',
            'driving_license' => 'Driving License',
            default           => ucfirst($this->document_type)
        };
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeUnderReview($query)
    {
        return $query->where('status', 'under_review');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}
