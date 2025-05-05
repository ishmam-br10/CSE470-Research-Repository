<?php

namespace App\Http\Controllers;

use App\Models\Borrow;
use App\Models\Paper;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BorrowController extends Controller
{
    public function index()
    {
        $borrows = Borrow::with(['paper','borrower'])->latest()->paginate(10);
        return view('borrows.index', compact('borrows'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'paper_id'=>'required|exists:papers,id',
            'due_at'=>'required|date|after:today'
        ]);

        Borrow::create([
            'paper_id'=>$validated['paper_id'],
            'borrower_id'=>$request->user()->id,
            'borrowed_at'=>Carbon::now(),
            'due_at'=>$validated['due_at'],
            'status'=>'borrowed'
        ]);

        return back()->with('success','Borrow request created');
    }

    public function return(Request $request, Borrow $borrow)
    {
        $borrow->update([
            'returned_at'=>Carbon::now(),
            'status'=>'returned'
        ]);

        return back()->with('success','Paper returned!');
    }
}
