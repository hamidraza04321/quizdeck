<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AssignPaperStudents;
use Auth;

class DashboardController extends Controller
{
    public function index()
    {
    	$in_progress_papers = AssignPaperStudents::where('user_id', Auth::id())
		                            ->where('status', '!=', 'Submitted')
		                            ->get();

        $submitted_papers  = AssignPaperStudents::where([
					    		'user_id' => Auth::id(),
					    		'status' => 'Submitted'
					    	])->get();

        $in_progress_papers_count = count($in_progress_papers);
        $submitted_papers_count   = count($submitted_papers);

    	return view('dashboard', compact('in_progress_papers_count', 'submitted_papers_count'));
    }
}
