<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Researcher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    /**
     * Display a listing of the projects.
     */
    public function index()
    {
        // $projects = Project::with('owner')->latest()->get();
        // return view('projects.index', compact('projects'));
        $projects = Project::with(['owner', 'applications'])->latest()->get();
        return view('projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new project.
     */
    public function create()
    {
        // Check if user is a researcher
        if (!Auth::user()->researcher) {
            return redirect()->route('projects.index')
                ->with('error', 'You need to be registered as a researcher to create projects.');
        }

        return view('projects.create');
    }

    /**
     * Store a newly created project in storage.
     */
    public function store(Request $request)
    {
        // Validate user is a researcher
        if (!Auth::user()->researcher) {
            return redirect()->route('projects.index')
                ->with('error', 'You need to be registered as a researcher to create projects.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'nullable|in:ongoing,completed,cancelled',
        ]);

        // Create project
        $project = new Project($validated);
        $project->researcher_id = Auth::user()->researcher->id;
        $project->save();

        // Add owner to project_researcher pivot with role 'owner'
        $project->researchers()->attach(Auth::user()->researcher->id, ['role' => 'owner']);

        return redirect()->route('projects.show', $project)
            ->with('success', 'Project created successfully.');
    }

        /**
     * Display the specified project.
     */
    public function show(Project $project)
    {
        // Load relationships
        $project->load('owner', 'researchers', 'applications.user');
        
        // Check application status for current user
        $application = null;
        $hasApplied = false;
        $applicationStatus = null;
        
        if (Auth::check()) {
            $application = $project->applications()
                ->where('user_id', Auth::id())
                ->first();
                
            $hasApplied = (bool) $application;
            $applicationStatus = $application ? $application->status : null;
        }
        
        // Check if user is owner
        $isOwner = Auth::check() && $project->isOwnedBy(Auth::user());
        
        // Check if user is a collaborator
        $isCollaborator = false;
        if (Auth::check() && Auth::user()->researcher) {
            $isCollaborator = $project->researchers()
                ->where('researchers.id', Auth::user()->researcher->id)
                ->exists();
        }
        
        return view('projects.show', compact(
            'project', 
            'hasApplied', 
            'applicationStatus', 
            'isOwner',
            'isCollaborator'
        ));
    }

    /**
     * Show the form for editing the specified project.
     */
    public function edit(Project $project)
    {
        // Check if user is owner
        if (!$project->isOwnedBy(Auth::user())) {
            return redirect()->route('projects.show', $project)
                ->with('error', 'You are not authorized to edit this project.');
        }

        return view('projects.edit', compact('project'));
    }

    /**
     * Update the specified project in storage.
     */
    public function update(Request $request, Project $project)
    {
        // Check if user is owner
        if (!$project->isOwnedBy(Auth::user())) {
            return redirect()->route('projects.show', $project)
                ->with('error', 'You are not authorized to update this project.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:ongoing,completed,cancelled',
        ]);

        $project->update($validated);

        return redirect()->route('projects.show', $project)
            ->with('success', 'Project updated successfully.');
    }

    /**
     * Remove the specified project from storage.
     */
    public function destroy(Project $project)
    {
        // Check if user is owner
        if (!$project->isOwnedBy(Auth::user())) {
            return redirect()->route('projects.show', $project)
                ->with('error', 'You are not authorized to delete this project.');
        }
        
        $project->delete();

        return redirect()->route('projects.index')
            ->with('success', 'Project deleted successfully.');
    }
}