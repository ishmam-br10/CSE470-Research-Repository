<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectApplicationController extends Controller
{
    /**
     * Show the form for creating a new application.
     */
    public function create(Project $project)
    {
        // Check if user has already applied
        $hasApplied = $project->applications()
            ->where('user_id', Auth::id())
            ->exists();
            
        if ($hasApplied) {
            return redirect()->route('projects.show', $project)
                ->with('error', 'You have already applied to this project.');
        }
        
        // Check if user is the project owner (can't apply to own project)
        if ($project->isOwnedBy(Auth::user())) {
            return redirect()->route('projects.show', $project)
                ->with('error', 'You cannot apply to your own project.');
        }
        
        return view('projects.applications.create', compact('project'));
    }
    
    /**
     * Store a newly created application in storage.
     */
    public function store(Request $request, Project $project)
    {
        // Validate input
        $validated = $request->validate([
            'motivation' => 'required|string|min:10',
        ]);
        
        // Create application
        $application = new ProjectApplication([
            'project_id' => $project->id,
            'user_id' => Auth::id(),
            'motivation' => $validated['motivation'],
            'status' => 'pending',
        ]);
        
        $application->save();
        
        return redirect()->route('projects.show', $project)
            ->with('success', 'Your application has been submitted successfully.');
    }
    
        /**
     * Update the application status (approve/reject).
     */
    public function updateStatus(Request $request, ProjectApplication $application)
    {
        // Check if user is the project owner
        if (!$application->project->isOwnedBy(Auth::user())) {
            return redirect()->route('projects.show', $application->project)
                ->with('error', 'You are not authorized to update application status.');
        }
        
        // Validate status
        $validated = $request->validate([
            'status' => 'required|in:approved,rejected',
        ]);
        
        $application->status = $validated['status'];
        $application->save();
        
        // If approved, add the applicant as a collaborator (if they're a researcher)
        if ($validated['status'] === 'approved' && $application->user->researcher) {
            $application->project->researchers()->syncWithoutDetaching([
                $application->user->researcher->id => ['role' => 'collaborator']
            ]);
        }
        
        return redirect()->route('projects.applications.index', $application->project)
            ->with('success', 'Application ' . $validated['status'] . ' successfully.');
    }
    /**
     * Show all applications for a project (for project owner).
     */
    public function index(Project $project)
    {
        // Check if user is the project owner
        if (!$project->isOwnedBy(Auth::user())) {
            return redirect()->route('projects.show', $project)
                ->with('error', 'You are not authorized to view applications.');
        }
        
        $applications = $project->applications()->with('user')->get();
        
        return view('projects.applications.index', compact('project', 'applications'));
    }
}
