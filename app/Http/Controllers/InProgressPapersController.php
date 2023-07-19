<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{
    PaperQuestionCorrectAnswers,
    AssignPaperStudents,
    UserStoreQuestion,
    UserStoreOption,
    PaperQuestions
};
use Auth;
use DB;

class InProgressPapersController extends Controller
{
    public function index()
    {
    	$id = Auth::id();
	    $assign_papers = AssignPaperStudents::where('user_id', $id)
                            ->where('status', '!=', 'Submitted')
                            ->get();

    	return view('in-progress-papers.index')
    		->with(compact('assign_papers'));
    }

    public function changeStatus(Request $request)
    {
    	$assign_paper = AssignPaperStudents::whereId($request->paperID)->first();
    	$assign_paper->update([ 'status' => 'In Progress' ]);

    	return true;
    }

    public function attemptPaper($id)
    {
        $assign_paper = AssignPaperStudents::whereId($id)->first();

        // Getting total questions ids
        $question_numbers = PaperQuestions::where('paper_id', $assign_paper->paper_id)->get('id');

    	return view('in-progress-papers.attempt-paper')
            ->with(compact('assign_paper', 'question_numbers', 'id'));
    }

    public function getQuestion(Request $request)
    {
        $id = $request->questionID;

        // Get Question
        $question = PaperQuestions::where('id', $id)->first();

        // Get Options with Checked
        $options = DB::select("
            SELECT pqo.id option_id, pqo.option, '' AS checked
            FROM paper_question_options pqo
            WHERE pqo.question_id = ".$id."
            AND pqo.id NOT IN(SELECT uso.option_id
                FROM user_store_options uso, user_store_questions usq
                WHERE uso.assign_paper_student_id = ".$request->assign_paper_id."
                AND uso.question_id = ".$id.")
            UNION
            SELECT uso.option_id, pqo.option, 'checked' AS checked
            FROM user_store_options uso, paper_question_options pqo
            WHERE uso.assign_paper_student_id = ".$request->assign_paper_id."
            AND uso.question_id = ".$id."
            AND uso.option_id = pqo.id
            ORDER BY option_id ASC
        ");

        //  Question Numbers
        $question_numbers = DB::select("
        	SELECT pq.id question_id, '' AS completed 
        	FROM paper_questions pq
        	WHERE pq.paper_id = ".$question->paper_id."
        	AND pq.id NOT IN(SELECT usq.question_id 
        	FROM user_store_questions usq
        	WHERE usq.assign_paper_student_id = ".$request->assign_paper_id."
        	AND usq.paper_id = ".$question->paper_id.")
        	UNION
        	SELECT usq.question_id, 'completed' AS completed
        	FROM user_store_questions usq
        	WHERE usq.assign_paper_student_id = ".$request->assign_paper_id."
        	AND usq.paper_id = ".$question->paper_id."
        	ORDER BY question_id ASC
        ");

        return response()->json([ 
        	'question' => $question,
            'options' => $options,
        	'question_numbers' => $question_numbers
        ]);
    }

    public function storeAnswers(Request $request)
    {
    	// Check If Record Exists or Not
    	$check_question = UserStoreQuestion::where([ 
            'assign_paper_student_id' => $request->assign_paper_id,
            'question_id' => $request->question_id
        ])->first();

        // FOR RADIO BUTTON
        if ($request->radio) {
        	$option = explode('_', $request->radio);
			$correct_option = PaperQuestionCorrectAnswers::where('question_id', $request->question_id)->first();

            if ($check_question == null) {            	
            	$store_question = UserStoreQuestion::create([
                    'assign_paper_student_id' => $request->assign_paper_id,
                    'paper_id' => $request->paper_id,
                    'question_id' => $request->question_id,
                    'un_answered' => 0
                ]);

                UserStoreOption::create([
                	'store_question_id' => $store_question->id,
                    'assign_paper_student_id' => $request->assign_paper_id,
                    'question_id' => $request->question_id,
                    'option_id' => $option[1],
                    'is_true' => ($correct_option->option_id == $option[1]) ? 1 : 0
                ]);
            } 
            else 
            {
                $store_option = UserStoreOption::where('store_question_id', $check_question->id)->first();
                $store_option->update([
                    'option_id' => $option[1],
                    'is_true' => ($correct_option->option_id == $option[1]) ? 1 : 0,
                ]);
            }
        }

        // FOR CHECKBOX
        if ($request->checkbox) {
        	if ($check_question == null) {
        		$store_question = UserStoreQuestion::create([
                    'assign_paper_student_id' => $request->assign_paper_id,
                    'question_id' => $request->question_id,
                    'paper_id' => $request->paper_id,
                    'un_answered' => 0
                ]);

        		foreach ($request->checkbox as $key => $value) {		
					$option = explode('_', $value);
					$correct_option = PaperQuestionCorrectAnswers::where('option_id', $option[1])->first();

					UserStoreOption::create([
	                	'store_question_id' => $store_question->id,
                        'assign_paper_student_id' => $request->assign_paper_id,
                        'question_id' => $request->question_id,
	                    'option_id' => $option[1],
	                    'is_true' => ($correct_option == null) ? 0 : 1
	                ]);
        		}
        	}
            else 
            {
        		// DELETE PREVIOS OPTIONS
        		$delete_options = UserStoreOption::where('store_question_id', $check_question->id)->get();
        		foreach ($delete_options as $key => $delete_option) {
        			$delete_option->delete();
        		}

        		// CREATE ALL OPTIONS WITH NEW
        		foreach ($request->checkbox as $key => $value) {		
					$option = explode('_', $value);
					$correct_option = PaperQuestionCorrectAnswers::where('option_id', $option[1])->first();

					UserStoreOption::create([
	                	'store_question_id' => $check_question->id,
                        'assign_paper_student_id' => $request->assign_paper_id,
                        'question_id' => $request->question_id,
	                    'option_id' => $option[1],
	                    'is_true' => ($correct_option == null) ? 0 : 1
	                ]);
        		}
        	}
        }

        // UPDATE TIME
        $assign_paper = AssignPaperStudents::where('id', $request->assign_paper_id)->first();
        $assign_paper->update([
        	'time' => $request->time
        ]);
    }

    public function savePaper(Request $request)
    {
        // UPDATE TIME
        $assign_paper = AssignPaperStudents::where('id', $request->assign_paper_id)->first();
        $assign_paper->update([
            'time' => $request->time
        ]);
    }

    public function submitPaper(Request $request)
    {
        $assign_paper = AssignPaperStudents::whereId($request->assign_paper_id)->first();
        
        // Storing Un Answered Questions
        $answered_questions = UserStoreQuestion::where('assign_paper_student_id', $request->assign_paper_id)->get('question_id');
        $un_answered_questions = PaperQuestions::select('id')
            ->where('paper_id', $assign_paper->paper_id)
            ->whereNotIn('id', $answered_questions)->get();
        
        if ($un_answered_questions) {
            foreach ($un_answered_questions as $key => $value) {
                UserStoreQuestion::create([
                    'assign_paper_student_id' => $request->assign_paper_id,
                    'question_id' => $value->id,
                    'paper_id' => $assign_paper->paper_id,
                    'un_answered' => 1
                ]);
            }
        }

        // Count In Correct Question...
        $incorrect = UserStoreOption::select('question_id')
            ->where('assign_paper_student_id', $assign_paper->id)
            ->where('is_true', 0)
            ->groupBy('question_id') // get one when question_id is mutiple...
            ->get();

        // Get Correct Number Of Questions...
        $correct = $assign_paper->assignPaper->number_of_questions - count($incorrect) - count($un_answered_questions);

        $assign_paper->update([
            'time' => $request->time,
            'status' => 'Submitted',
            'correct' => $correct,
            'incorrect' => count($incorrect),
            'un_answered' => count($un_answered_questions)
        ]);
    }
}
