<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Paper;
use App\Models\Researcher;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Basic counts for dashboard
        $userCount = User::count();
        $researcherCount = User::where('role', 'researcher')->count();
        $nonResearcherCount = User::where('role', 'non-researcher')->count();
        $paperCount = Paper::count();

        return view('admin.index', compact('userCount', 'researcherCount', 'nonResearcherCount', 'paperCount'));
    }

    /**
     * Display a listing of users.
     *
     * @return \Illuminate\View\View
     */
    public function users()
    {
        $users = User::paginate(15);
        return view('admin.users', compact('users'));
    }

    /**
     * Display a listing of papers.
     *
     * @return \Illuminate\View\View
     */
    public function papers()
    {
        $papers = Paper::with('authors')->paginate(15);
        return view('admin.papers', compact('papers'));
    }

    /**
     * Show the form for editing the specified paper.
     *
     * @param  \App\Models\Paper  $paper
     * @return \Illuminate\View\View
     */
    public function editPaper(Paper $paper)
    {
        $researchers = Researcher::all();
        return view('admin.edit-paper', compact('paper', 'researchers'));
    }

    /**
     * Update the specified paper in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Paper  $paper
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePaper(Request $request, Paper $paper)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'abstract' => 'required|string',
            'type' => 'required|string',
            'year' => 'required|integer|min:1900|max:' . (date('Y')+1),
            'cited' => 'nullable|integer|min:0',
            'authors' => 'nullable|array',
        ]);

        $paper->update([
            'title' => $validated['title'],
            'abstract' => $validated['abstract'],
            'type' => $validated['type'],
            'year' => $validated['year'],
            'cited' => $validated['cited'] ?? 0,
        ]);

        if (isset($validated['authors'])) {
            $paper->authors()->sync($validated['authors']);
        }

        return redirect()->route('admin.papers')->with('success', 'Paper updated successfully');
    }

    /**
     * Remove the specified paper from storage.
     *
     * @param  \App\Models\Paper  $paper
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroyPaper(Paper $paper)
    {
        $paper->delete();
        return redirect()->route('admin.papers')->with('success', 'Paper deleted successfully');
    }
}