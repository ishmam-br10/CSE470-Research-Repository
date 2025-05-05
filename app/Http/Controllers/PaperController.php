<?php

namespace App\Http\Controllers;

use App\Models\Paper;
use App\Models\Researcher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaperController extends Controller
{
    public function index()
    {
        $papers = Paper::with('authors')->latest()->paginate(10);
        return view('papers.index', compact('papers'));
    }

    public function create()
    {
        $researchers = Researcher::all();
        return view('papers.create', compact('researchers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type'  => 'required|string|max:100',
            'year'  => 'required|integer|min:1900',
            'file'  => 'required|mimes:pdf|max:20480',
            'authors'=> 'array|required'
        ]);

        $path = $request->file('file')->store('papers', 'public');

        $paper = Paper::create([
            'title'=>$validated['title'],
            'type'=>$validated['type'],
            'year'=>$validated['year'],
            'file_path'=>$path,
            'cited'=>0
        ]);

        $paper->authors()->sync($validated['authors']);

        return redirect()->route('papers.index')->with('success','Paper added!');
    }

    public function edit(Paper $paper)
    {
        $researchers = Researcher::all();
        return view('papers.edit', compact('paper','researchers'));
    }

    public function update(Request $request, Paper $paper)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type'  => 'required|string|max:100',
            'year'  => 'required|integer|min:1900',
            'file'  => 'nullable|mimes:pdf|max:20480',
            'authors'=> 'array|required'
        ]);

        if($request->hasFile('file')) {
            Storage::disk('public')->delete($paper->file_path);
            $validated['file_path'] = $request->file('file')->store('papers','public');
        }

        $paper->update($validated);
        $paper->authors()->sync($validated['authors']);

        return redirect()->route('papers.index')->with('success','Paper updated!');
    }

    public function destroy(Paper $paper)
    {
        Storage::disk('public')->delete($paper->file_path);
        $paper->delete();
        return back()->with('success','Deleted');
    }

    public function cite(Paper $paper)
    {
    // Increment the citation count
    $paper->cited = ($paper->cited ?? 0) + 1;
    $paper->save();
    
    // Redirect back with a success message
    return back()->with('success', 'Paper cited successfully!');
    }
    public function show(Paper $paper)
    {
    // Check if the file exists in storage
    if (Storage::disk('public')->exists($paper->file_path)) {
        // Return file for download
        return Storage::disk('public')->download($paper->file_path, $paper->title . '.pdf');
    }
    
    // If file doesn't exist, redirect back with error
    return back()->with('error', 'Paper file not found.');
    }

}
