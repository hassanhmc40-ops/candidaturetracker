<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;

class ArchiveController extends Controller
{
    /**
     * Display a listing of archived applications.
     * 
     * US7: Archives page
     * - Shows only soft-deleted applications
     * - Only shows authenticated user's archives
     * - Ordered by archive date (most recent first)
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Get only soft-deleted applications for authenticated user
        $archivedApplications = auth()->user()->applications()
                                     ->onlyTrashed() // Only soft-deleted
                                     ->with('interviews') // Prevent N+1
                                     ->orderBy('deleted_at', 'desc')
                                     ->get();

        return view('archives.index', compact('archivedApplications'));
    }

    /**
     * Restore an archived application.
     * 
     * US8: Restore an application
     * - Removes deleted_at timestamp (undeletes)
     * - Returns application to active list
     * - Policy ensures user can only restore their own applications
     * 
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore($id)
    {
        // Find soft-deleted application by ID
        $application = Application::onlyTrashed()->findOrFail($id);

        // Authorize: User can only restore their own applications
        $this->authorize('restore', $application);

        // Restore the application (sets deleted_at to null)
        $application->restore();

        // Redirect to application details with success message
        return redirect()
            ->route('applications.show', $application)
            ->with('success', 'Application restored successfully!');
    }

    /**
     * Permanently delete an archived application.
     * 
     * Optional: For complete deletion (not in requirements)
     * - Deletes application and all related data permanently
     * - Cannot be undone
     * 
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function forceDelete($id)
    {
        // Find soft-deleted application
        $application = Application::onlyTrashed()->findOrFail($id);

        // Authorize: User can only force delete their own applications
        $this->authorize('forceDelete', $application);

        // Permanently delete
        $application->forceDelete();

        // Redirect to archives with success message
        return redirect()
            ->route('archives.index')
            ->with('success', 'Application permanently deleted.');
    }
}