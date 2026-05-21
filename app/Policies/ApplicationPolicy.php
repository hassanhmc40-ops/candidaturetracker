<?php

namespace App\Policies;

use App\Models\Application;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ApplicationPolicy
{
    /**
     * Determine whether the user can view any models.
     * 
     * Used for: Index page (list of applications)
     * Rule: Any authenticated user can see their own applications list
     */
    public function viewAny(User $user): bool
    {
        // All authenticated users can view their applications
        return true;
    }

    /**
     * Determine whether the user can view the model.
     * 
     * Used for: Show page (single application details)
     * Rule: User can only view their own applications
     */
    public function view(User $user, Application $application): bool
    {
        // User can only view applications they own
        return $user->id === $application->user_id;
    }

    /**
     * Determine whether the user can create models.
     * 
     * Used for: Create/Store actions
     * Rule: Any authenticated user can create applications
     */
    public function create(User $user): bool
    {
        // All authenticated users can create applications
        return true;
    }

    /**
     * Determine whether the user can update the model.
     * 
     * Used for: Edit/Update actions
     * Rule: User can only update their own applications
     */
    public function update(User $user, Application $application): bool
    {
        // User can only update applications they own
        return $user->id === $application->user_id;
    }

    /**
     * Determine whether the user can delete the model (soft delete/archive).
     * 
     * Used for: Archive action (US6)
     * Rule: User can only archive their own applications
     */
    public function delete(User $user, Application $application): bool
    {
        // User can only delete/archive applications they own
        return $user->id === $application->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     * 
     * Used for: Restore archived application (US8)
     * Rule: User can only restore their own archived applications
     */
    public function restore(User $user, Application $application): bool
    {
        // User can only restore applications they own
        return $user->id === $application->user_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     * 
     * Used for: Force delete (permanent deletion)
     * Rule: User can only permanently delete their own applications
     */
    public function forceDelete(User $user, Application $application): bool
    {
        // User can only force delete applications they own
        return $user->id === $application->user_id;
    }
}