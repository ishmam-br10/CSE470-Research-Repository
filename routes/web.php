<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PaperController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\ResearcherController;
use App\Http\Controllers\SearchController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Route::get('/', function () {
//     return view('dashboard');
// });
Route::get('/', function () {
    return redirect()->route('dashboard');
});
// Add these routes to your web.php file
use App\Http\Controllers\AdminController;

// Admin routes
Route::middleware(['auth:sanctum', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/papers', [AdminController::class, 'papers'])->name('papers');
    Route::get('/papers/{paper}/edit', [AdminController::class, 'editPaper'])->name('papers.edit');
    Route::put('/papers/{paper}', [AdminController::class, 'updatePaper'])->name('papers.update');
    Route::delete('/papers/{paper}', [AdminController::class, 'destroyPaper'])->name('papers.destroy');
});
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/about', function() {return view('about');})->name('about');

    Route::resource('papers', PaperController::class);
    Route::resource('projects', ProjectController::class);
    Route::resource('researchers', ResearcherController::class);
    Route::get('borrows', [BorrowController::class, 'index'])->name('borrows.index');
    Route::post('borrows', [BorrowController::class, 'store'])->name('borrows.store');
    Route::patch('borrows/{borrow}/return', [BorrowController::class, 'return'])->name('borrows.return');
    // Paper citation route// Paper citation route
    Route::post('/papers/{paper}/cite', [App\Http\Controllers\PaperController::class, 'cite'])->name('papers.cite');
    Route::get('/papers/{paper}', [App\Http\Controllers\PaperController::class, 'show'])->name('papers.show');
    Route::get('search', [SearchController::class, 'index'])->name('search.index');
    // Add these routes inside your middleware group
    Route::get('/researchers/{researcher}/profile', [ResearcherController::class, 'profile'])->name('researchers.profile');
    Route::get('/researchers/{researcher}/profile/edit', [ResearcherController::class, 'editProfile'])->name('researchers.editProfile');
    Route::put('/researchers/{researcher}/profile', [ResearcherController::class, 'updateProfile'])->name('researchers.updateProfile');
        // Add these inside your middleware group, after the projects resource routes
    
    // Project Applications
    Route::get('/projects/{project}/apply', [App\Http\Controllers\ProjectApplicationController::class, 'create'])
        ->name('projects.applications.create');
    Route::post('/projects/{project}/apply', [App\Http\Controllers\ProjectApplicationController::class, 'store'])
        ->name('projects.applications.store');
    Route::get('/projects/{project}/applications', [App\Http\Controllers\ProjectApplicationController::class, 'index'])
        ->name('projects.applications.index');
    Route::patch('/applications/{application}/status', [App\Http\Controllers\ProjectApplicationController::class, 'updateStatus'])
        ->name('applications.updateStatus');
});

require __DIR__.'/auth.php';
