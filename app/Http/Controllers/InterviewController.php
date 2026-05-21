<?php

namespace App\Http\Controllers;

use App\Models\Interview;
use App\Models\Application;
use App\Http\Requests\StoreInterviewRequest;
use App\Http\Requests\UpdateInterviewRequest;

class InterviewController extends Controller
{
    /**
     * Show the form for creating a new interview.
     * 
     * US10: Add an interview
     * - Creates interview for specific application
     * - User must own the parent application (checked by policy)
     * 
     * @param \App\Models\Application $application
     * @return \Illuminate\View\View
     */
    public function create(Application $application)
    {
        // Authorize: User must own the application
        $this->authorize('update', $application);

        // Get options for dropdowns
        $typeOptions = Interview::getTypeOptions();
        $resultOptions = Interview::getResultOptions();

        return view('interviews.create', compact(
            'application',
            'typeOptions',
            'resultOptions'
        ));
    }

    /**
     * Store a newly created interview in storage.
     * 
     * US10: Add an interview
     * - Validation handled by StoreInterviewRequest
     * - Associates interview with application
     * 
     * @param \App\Http\Requests\StoreInterviewRequest $request
     * @param \App\Models\Application $application
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreInterviewRequest $request, Application $application)
    {
        // Authorize: User must own the application
        $this->authorize('update', $application);

        // Create interview for the application
        $interview = $application->interviews()->create($request->validated());

        // Redirect to application details with success message
        return redirect()
            ->route('applications.show', $application)
            ->with('success', 'Interview added successfully!');
    }

    /**
     * Show the form for editing the specified interview.
     * 
     * US11: Edit an interview
     * 
     * @param \App\Models\Interview $interview
     * @return \Illuminate\View\View
     */
    public function edit(Interview $interview)
    {
        // Authorize: User must own the parent application
        $this->authorize('update', $interview);

        // Eager load application to prevent N+1
        $interview->load('application');

        // Get options for dropdowns
        $typeOptions = Interview::getTypeOptions();
        $resultOptions = Interview::getResultOptions();

        return view('interviews.edit', compact(
            'interview',
            'typeOptions',
            'resultOptions'
        ));
    }

    /**
     * Update the specified interview in storage.
     * 
     * US11: Edit an interview
     * - Validation handled by UpdateInterviewRequest
     * 
     * @param \App\Http\Requests\UpdateInterviewRequest $request
     * @param \App\Models\Interview $interview
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateInterviewRequest $request, Interview $interview)
    {
        // Authorize: User must own the parent application
        $this->authorize('update', $interview);

        // Update interview with validated data
        $interview->update($request->validated());

        // Redirect to application details with success message
        return redirect()
            ->route('applications.show', $interview->application)
            ->with('success', 'Interview updated successfully!');
    }

    /**
     * Remove the specified interview from storage.
     * 
     * US11: Delete an interview
     * - Permanently deletes interview (no soft delete)
     * 
     * @param \App\Models\Interview $interview
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Interview $interview)
    {
        // Authorize: User must own the parent application
        $this->authorize('delete', $interview);

        // Get application before deleting interview
        $application = $interview->application;

        // Delete interview
        $interview->delete();

        // Redirect to application details with success message
        return redirect()
            ->route('applications.show', $application)
            ->with('success', 'Interview deleted successfully!');
    }
}
