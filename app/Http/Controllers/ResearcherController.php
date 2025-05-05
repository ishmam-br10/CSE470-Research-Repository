<?php

namespace App\Http\Controllers;

use App\Models\Researcher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
class ResearcherController extends Controller
{
    public function index()
    {
        $researchers = Researcher::with('user')->paginate(10);
        return view('researchers.index', compact('researchers'));
    }

    public function create()
    {
        return view('researchers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'=>'required|string|max:255',
            'department'=>'required|string|max:255',
            'contact'=>'nullable|string|max:255',
            'avatar'=>'nullable|image|max:5120',
        ]);

        if($request->hasFile('avatar')){
            $validated['avatar_path'] = $request->file('avatar')->store('avatars','public');
        }
        $validated['user_id'] = $request->user()->id;

        Researcher::create($validated);

        return redirect()->route('researchers.index')->with('success','Profile created');
    }
    public function show(Researcher $researcher)
    {
        return view('researchers.show', compact('researcher'));
    }
    public function edit(Researcher $researcher)
    {
        return view('researchers.edit', compact('researcher'));
    }

    public function update(Request $request, Researcher $researcher)
    {
        $validated = $request->validate([
            'name'=>'required|string|max:255',
            'department'=>'required|string|max:255',
            'contact'=>'nullable|string|max:255',
            'avatar'=>'nullable|image|max:5120',
        ]);

        if($request->hasFile('avatar')){
            if($researcher->avatar_path){
                Storage::disk('public')->delete($researcher->avatar_path);
            }
            $validated['avatar_path'] = $request->file('avatar')->store('avatars','public');
        }

        $researcher->update($validated);
        return redirect()->route('researchers.index')->with('success','Updated');
    }

    public function destroy(Researcher $researcher)
    {
        if($researcher->avatar_path){
            Storage::disk('public')->delete($researcher->avatar_path);
        }
        $researcher->delete();
        return back()->with('success','Deleted');
    }

    // add the profile page
    public function profile(Researcher $researcher, Request $request)
    {
        // Get sort parameter
        $sort = $request->input('sort', 'citations_desc'); // Default to most cited first
    
        // Calculate citation metrics
        $totalCitations = $researcher->papers->sum('cited');
        $paperCount = $researcher->papers->count();
        
        // Start query to get papers with authors
        $papersQuery = $researcher->papers()->with('researchers');
        
        // Apply sorting based on the sort parameter
        switch ($sort) {
            case 'citations_asc':
                $papersQuery->orderBy('cited', 'asc');
                break;
            case 'year_desc':
                $papersQuery->orderBy('year', 'desc');
                break;
            case 'year_asc':
                $papersQuery->orderBy('year', 'asc');
                break;
            case 'citations_desc':
            default:
                $papersQuery->orderBy('cited', 'desc');
                break;
        }
        
        // Execute the query
        $papers = $papersQuery->get();
        
        // Get collaborators (other researchers who have co-authored papers)
        $collaborators = collect();
        foreach ($papers as $paper) {
            if ($paper->researchers) {
                $collaborators = $collaborators->merge(
                    $paper->researchers->filter(function ($coauthor) use ($researcher) {
                        return $coauthor->id !== $researcher->id;
                    })
                );
            }
        }
        $collaborators = $collaborators->unique('id')->values();
        
        // Check if current user is the profile owner
        $isOwner = Auth::check() && Auth::user()->researcher && Auth::user()->researcher->id === $researcher->id;
        
        return view('researchers.profile', compact(
            'researcher', 
            'papers', 
            'totalCitations', 
            'paperCount', 
            'isOwner',
            'collaborators',
            'sort' // Pass the current sort to the view
        ));
    }

    /**
     * Show form to edit researcher's profile.
     */
    public function editProfile(Researcher $researcher)
    {
        // Check if user is authorized to edit this profile
        if (!Auth::check() || !Auth::user()->researcher || Auth::user()->researcher->id !== $researcher->id) {
            return redirect()->route('researchers.profile', $researcher)
                ->with('error', 'You are not authorized to edit this profile');
        }
        
        return view('researchers.edit-profile', compact('researcher'));
    }

    /**
     * Update the researcher's profile.
     */
    public function updateProfile(Request $request, Researcher $researcher)
    {
        // Check if user is authorized to edit this profile
        if (!Auth::check() || !Auth::user()->researcher || Auth::user()->researcher->id !== $researcher->id) {
            return redirect()->route('researchers.profile', $researcher)
                ->with('error', 'You are not authorized to edit this profile');
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'contact' => 'required|string|max:255',
            'bio' => 'nullable|string|max:1000',
            'avatar' => 'nullable|image|max:1024',
        ]);

        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($researcher->avatar_path) {
                Storage::disk('public')->delete($researcher->avatar_path);
            }
            
            $path = $request->file('avatar')->store('avatars', 'public');
            $validated['avatar_path'] = $path;
        }

        $researcher->update($validated);
        
        // Also update the user's name
        $researcher->user->update(['name' => $validated['name']]);

        return redirect()->route('researchers.profile', $researcher)
            ->with('success', 'Profile updated successfully');
    }
}
