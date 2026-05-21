<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Http\Requests\StoreApplicationRequest;
use App\Http\Requests\UpdateApplicationRequest;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the user's active applications.
     * 
     * US2: List of my applications
     * - Shows only authenticated user's applications
     * - Excludes archived (soft-deleted) applications
     * - Supports filtering by status and priority (US9)
     * - Eager loads relationships to prevent N+1 queries
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Start query for authenticated user's applications only
        $query = auth()->user()->applications()
                     ->with('interviews') // Eager load to prevent N+1
                     ->whereNull('deleted_at'); // Only active (non-archived)

        // Apply filters if present (US9)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        // Get applications ordered by most recent first
        $applications = $query->orderBy('application_date', 'desc')
                             ->orderBy('created_at', 'desc')
                             ->get();

        // Get filter options for dropdowns
        $statusOptions = Application::getStatusOptions();
        $priorityOptions = Application::getPriorityOptions();

        return view('applications.index', compact(
            'applications',
            'statusOptions',
            'priorityOptions'
        ));
    }

    /**
     * Show the form for creating a new application.
     * 
     * US3: Create an application
     * 
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Get options for dropdowns
        $statusOptions = Application::getStatusOptions();
        $priorityOptions = Application::getPriorityOptions();

        return view('applications.create', compact(
            'statusOptions',
            'priorityOptions'
        ));
    }

    /**
     * Store a newly created application in storage.
     * 
     * US3: Create an application
     * - Validation handled by StoreApplicationRequest
     * - Automatically associates application with authenticated user
     * 
     * @param \App\Http\Requests\StoreApplicationRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreApplicationRequest $request)
    {
        // Create application for authenticated user
        // $request->validated() returns only validated fields
        $application = auth()->user()->applications()->create(
            $request->validated()
        );

        // Redirect to application details with success message
        return redirect()
            ->route('applications.show', $application)
            ->with('success', 'Application created successfully!');
    }

    /**
     * Display the specified application.
     * 
     * US4: View application details
     * - Shows full application details
     * - Shows all associated interviews
     * - Policy ensures user can only view their own applications
     * 
     * @param \App\Models\Application $application
     * @return \Illuminate\View\View
     */
    public function show(Application $application)
    {
        // Authorize: User can only view their own applications
        $this->authorize('view', $application);

        // Eager load relationships to prevent N+1
        $application->load('interviews');

        return view('applications.show', compact('application'));
    }

    /**
     * Show the form for editing the specified application.
     * 
     * US5: Edit an application
     * 
     * @param \App\Models\Application $application
     * @return \Illuminate\View\View
     */
    public function edit(Application $application)
    {
        // Authorize: User can only edit their own applications
        $this->authorize('update', $application);

        // Get options for dropdowns
        $statusOptions = Application::getStatusOptions();
        $priorityOptions = Application::getPriorityOptions();

        return view('applications.edit', compact(
            'application',
            'statusOptions',
            'priorityOptions'
        ));
    }

    /**
     * Update the specified application in storage.
     * 
     * US5: Edit an application
     * - Validation handled by UpdateApplicationRequest
     * - Policy ensures user can only update their own applications
     * 
     * @param \App\Http\Requests\UpdateApplicationRequest $request
     * @param \App\Models\Application $application
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateApplicationRequest $request, Application $application)
    {
        // Authorize: User can only update their own applications
        $this->authorize('update', $application);

        // Update application with validated data
        $application->update($request->validated());

        // Redirect to application details with success message
        return redirect()
            ->route('applications.show', $application)
            ->with('success', 'Application updated successfully!');
    }

    /**
     * Archive (soft delete) the specified application.
     * 
     * US6: Archive an application
     * - Soft deletes (sets deleted_at timestamp)
     * - Does not permanently delete data
     * - Application can be restored later (US8)
     * 
     * @param \App\Models\Application $application
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Application $application)
    {
        // Authorize: User can only archive their own applications
        $this->authorize('delete', $application);

        // Soft delete (archive) the application
        $application->delete();

        // Redirect to applications list with success message
        return redirect()
            ->route('applications.index')
            ->with('success', 'Application archived successfully!');
    }
}
