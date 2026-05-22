<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\InterviewController;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\DocumentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return auth()->check() 
        ? redirect()->route('dashboard') 
        : view('welcome');
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Applications (Full CRUD)
    Route::resource('applications', ApplicationController::class);
    
    // Archives
    Route::get('/archives', [ArchiveController::class, 'index'])->name('archives.index');
    Route::post('/archives/{id}/restore', [ArchiveController::class, 'restore'])->name('archives.restore');
    Route::delete('/archives/{id}/force', [ArchiveController::class, 'forceDelete'])->name('archives.forceDelete');
    
    // Interviews
    Route::get('/applications/{application}/interviews/create', [InterviewController::class, 'create'])->name('interviews.create');
    Route::post('/applications/{application}/interviews', [InterviewController::class, 'store'])->name('interviews.store');
    Route::get('/interviews/{interview}/edit', [InterviewController::class, 'edit'])->name('interviews.edit');
    Route::put('/interviews/{interview}', [InterviewController::class, 'update'])->name('interviews.update');
    Route::delete('/interviews/{interview}', [InterviewController::class, 'destroy'])->name('interviews.destroy');
    
    // Documents (BONUS)
    Route::get('/applications/{application}/documents/create', [DocumentController::class, 'create'])->name('documents.create');
    Route::post('/applications/{application}/documents', [DocumentController::class, 'store'])->name('documents.store');
    Route::get('/documents/{document}/download', [DocumentController::class, 'download'])->name('documents.download');
    Route::delete('/documents/{document}', [DocumentController::class, 'destroy'])->name('documents.destroy');
    
    // Profile (Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Authentication Routes (Breeze)
require __DIR__.'/auth.php';