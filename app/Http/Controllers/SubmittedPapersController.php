<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{
    AssignPaperStudents,
    PaperQuestions
};
use Auth;

class SubmittedPapersController extends Controller
{
    public function index()
    {
    	$papers = AssignPaperStudents::where([
    		'user_id' => Auth::id(),
    		'status' => 'Submitted'
    	])->get();

    	return view('submitted-papers.index')
    		->with(compact('papers'));
    }

    public function reviewResult($id)
    {
        $result = AssignPaperStudents::whereId($id)
                    ->with('attemptQuestions.question.getOptions.correctAnswers', 'attemptQuestions.checkedOptions')
                    ->first();
        // dd($result);die();
    	return view('submitted-papers.review-result')
            ->with(compact('result'));
    }

    public function getExplaination(Request $request)
    {
        $exp = PaperQuestions::where('id', $request->question_id)->first('explaination');
        return $exp;
    }
}