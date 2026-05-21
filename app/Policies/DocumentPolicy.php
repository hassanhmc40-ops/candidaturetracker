<?php

namespace App\Policies;

use App\Models\Document;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class DocumentPolicy
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
     * 
     * Used for: Viewing document details
     * Rule: User can only view documents for applications they own
     */
    public function view(User $user, Document $document): bool
    {
        // User must own the parent application
        return $user->id === $document->application->user_id;
    }

    /**
     * Determine whether the user can create models.
     * 
     * Used for: Uploading documents to an application
     * Rule: User can only upload documents to their own applications
     */
    public function create(User $user): bool
    {
        // All authenticated users can create documents
        // (ownership of parent application checked in controller)
        return true;
    }

    /**
     * Determine whether the user can update the model.
     * 
     * Note: Documents are typically not updated, only replaced
     */
    public function update(User $user, Document $document): bool
    {
        // User must own the parent application
        return $user->id === $document->application->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     * 
     * Used for: Deleting uploaded documents
     * Rule: User can only delete documents for applications they own
     */
    public function delete(User $user, Document $document): bool
    {
        // User must own the parent application
        return $user->id === $document->application->user_id;
    }

    /**
     * Determine whether the user can download the document.
     * 
     * Custom policy method for download authorization
     * Rule: User can only download documents for applications they own
     */
    public function download(User $user, Document $document): bool
    {
        // User must own the parent application
        return $user->id === $document->application->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Document $document): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Document $document): bool
    {
        return false;
    }
}