<?php

namespace App\Http\Controllers;

use App\Models\Paper;
use App\Models\Project;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->input('q','');
        $papers = collect();
        $projects = collect();

        if($q){
            $papers = Paper::where('title','like',"%{$q}%")->orWhere('type','like',"%{$q}%")->get();
            $projects = Project::where('title','like',"%{$q}%")->orWhere('type','like',"%{$q}%")->get();
        }

        return view('search.index', compact('q','papers','projects'));
    }
}
