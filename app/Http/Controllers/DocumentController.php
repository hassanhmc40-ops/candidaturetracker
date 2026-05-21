<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Application;
use App\Http\Requests\StoreDocumentRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DocumentController extends Controller
{
    /**
     * Show the form for uploading a new document.
     * 
     * @param \App\Models\Application $application
     * @return \Illuminate\View\View
     */
    public function create(Application $application)
    {
        // Authorize: User must own the application
        $this->authorize('update', $application);

        return view('documents.create', compact('application'));
    }

    /**
     * Store a newly uploaded document.
     * 
     * - Stores file in private storage
     * - Saves metadata to database
     * - User must own the parent application
     * 
     * @param \App\Http\Requests\StoreDocumentRequest $request
     * @param \App\Models\Application $application
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreDocumentRequest $request, Application $application)
    {
        // Authorize: User must own the application
        $this->authorize('update', $application);

        // Get uploaded file
        $file = $request->file('file');

        // Generate unique filename
        $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();

        // Store file in private storage
        // Path: storage/app/private/documents/user_{id}/application_{id}/
        $path = $file->storeAs(
            'documents/user_' . auth()->id() . '/application_' . $application->id,
            $filename,
            'private'
        );

        // Create document record
        $document = $application->documents()->create([
            'file_name' => $file->getClientOriginalName(),
            'file_path' => $path,
            'file_type' => $file->getMimeType(),
            'file_size' => $file->getSize(),
        ]);

        // Redirect to application with success message
        return redirect()
            ->route('applications.show', $application)
            ->with('success', 'Document uploaded successfully!');
    }

    /**
     * Download the specified document.
     * 
     * - User must own the parent application
     * - File served from private storage (not directly accessible)
     * 
     * @param \App\Models\Document $document
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function download(Document $document)
    {
        // Authorize: User must own the parent application
        $this->authorize('download', $document);

        // Check if file exists
        if (!Storage::disk('private')->exists($document->file_path)) {
            abort(404, 'File not found.');
        }

        // Download file with original filename
        return Storage::disk('private')->download(
            $document->file_path,
            $document->file_name
        );
    }

    /**
     * Remove the specified document.
     * 
     * - Deletes database record
     * - Deletes physical file (handled by model event)
     * 
     * @param \App\Models\Document $document
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Document $document)
    {
        // Authorize: User must own the parent application
        $this->authorize('delete', $document);

        // Get application before deleting document
        $application = $document->application;

        // Delete document (file deletion handled by model event)
        $document->delete();

        // Redirect to application with success message
        return redirect()
            ->route('applications.show', $application)
            ->with('success', 'Document deleted successfully!');
    }
}
