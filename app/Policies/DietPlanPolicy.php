<?php

namespace App\Policies;

use App\Models\DietPlan;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DietPlanPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasVerifiedEmail();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, DietPlan $dietPlan): bool
    {
        return $user->id === $dietPlan->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Limit users to 10 diet plans
        $planCount = $user->dietPlans()->count();
        return $user->hasVerifiedEmail() && $planCount < 10;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, DietPlan $dietPlan): bool
    {
        return $user->id === $dietPlan->user_id && 
               $dietPlan->status !== 'completed';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, DietPlan $dietPlan): bool
    {
        return $user->id === $dietPlan->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, DietPlan $dietPlan): bool
    {
        return $user->id === $dietPlan->user_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, DietPlan $dietPlan): bool
    {
        return $user->id === $dietPlan->user_id;
    }
}