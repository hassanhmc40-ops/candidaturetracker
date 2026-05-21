<?php

namespace App\Policies;

use App\Models\Interview;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class InterviewPolicy
{
    /**
     * Determine whether the user can view any models.
     * 
     * Note: Interviews are always viewed in context of an application,
     * so this method is less commonly used.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     * 
     * Used for: Viewing interview details
     * Rule: User can only view interviews for applications they own
     */
    public function view(User $user, Interview $interview): bool
    {
        // User must own the parent application
        return $user->id === $interview->application->user_id;
    }

    /**
     * Determine whether the user can create models.
     * 
     * Used for: Adding interview to an application (US10)
     * Rule: User can only add interviews to their own applications
     * 
     * Note: This checks if user can create interviews in general.
     * The application ownership is checked in the controller.
     */
    public function create(User $user): bool
    {
        // All authenticated users can create interviews
        // (ownership of parent application checked in controller)
        return true;
    }

    /**
     * Determine whether the user can update the model.
     * 
     * Used for: Editing interview (US11)
     * Rule: User can only edit interviews for applications they own
     */
    public function update(User $user, Interview $interview): bool
    {
        // User must own the parent application
        return $user->id === $interview->application->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     * 
     * Used for: Deleting interview (US11)
     * Rule: User can only delete interviews for applications they own
     */
    public function delete(User $user, Interview $interview): bool
    {
        // User must own the parent application
        return $user->id === $interview->application->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     * 
     * Not used (interviews don't use soft deletes)
     */
    public function restore(User $user, Interview $interview): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     * 
     * Not used (interviews are hard deleted directly)
     */
    public function forceDelete(User $user, Interview $interview): bool
    {
        return false;
    }
}