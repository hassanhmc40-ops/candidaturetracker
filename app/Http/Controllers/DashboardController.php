<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the user's dashboard.
     * 
     * Shows overview of:
     * - Total active applications
     * - Recent applications
     * - Upcoming interviews
     * - Application statistics by status
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = auth()->user();

        // Get statistics
        $totalApplications = $user->applications()->count();
        $activeApplications = $user->applications()->whereNull('deleted_at')->count();
        $archivedApplications = $user->applications()->onlyTrashed()->count();

        // Get recent applications (last 5)
        $recentApplications = $user->applications()
                                   ->with('interviews')
                                   ->orderBy('created_at', 'desc')
                                   ->limit(5)
                                   ->get();

        // Get upcoming interviews across all applications
        $upcomingInterviews = \App\Models\Interview::whereHas('application', function($query) use ($user) {
                                    $query->where('user_id', $user->id)
                                          ->whereNull('deleted_at');
                                })
                                ->with('application')
                                ->where('scheduled_date', '>=', now()->toDateString())
                                ->orderBy('scheduled_date')
                                ->orderBy('scheduled_time')
                                ->limit(5)
                                ->get();

        // Get applications count by status
        $statusCounts = $user->applications()
                             ->selectRaw('status, COUNT(*) as count')
                             ->groupBy('status')
                             ->pluck('count', 'status');

        return view('dashboard', compact(
            'totalApplications',
            'activeApplications',
            'archivedApplications',
            'recentApplications',
            'upcomingInterviews',
            'statusCounts'
        ));
    }
}
