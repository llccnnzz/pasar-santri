<?php

namespace App\Policies;

use App\Models\KycApplication;
use App\Models\User;

class KycApplicationPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, KycApplication $kycApplication): bool
    {
        return $user->id === $kycApplication->user_id || $user->hasRole('admin');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // User can create if they don't have an approved KYC
        return !KycApplication::where('user_id', $user->id)
            ->where('status', 'approved')
            ->exists();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, KycApplication $kycApplication): bool
    {
        return false; // KYC applications cannot be updated once submitted
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, KycApplication $kycApplication): bool
    {
        return false; // KYC applications cannot be deleted
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, KycApplication $kycApplication): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, KycApplication $kycApplication): bool
    {
        return false;
    }

    /**
     * Determine whether the user can reapply for KYC.
     */
    public function reapply(User $user, KycApplication $kycApplication): bool
    {
        return $user->id === $kycApplication->user_id
            && $kycApplication->status === 'rejected';
    }
}
