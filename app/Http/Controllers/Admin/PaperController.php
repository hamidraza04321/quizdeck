<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\{
    PaperQuestionCorrectAnswers,   
    PaperQuestionOptions,
    PaperQuestions,
    Subject,
    Paper
};

class PaperController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $papers = Paper::get();
        return view('admin.paper.index')
            ->with(compact('papers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $subjects = Subject::get();
        return view('admin.paper.create')
            ->with(compact('subjects'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $paper =  Paper::create([
            'subject_id' => $request->get('subject_id'),
            'name' => $request->get('name'),
            'number_of_questions' => $request->get('number_of_questions'),
            'description' => $request->get('description'),
        ]);

        foreach ($request->questions as $key => $val) {
            $paper_question =  PaperQuestions::create([
                'paper_id' => $paper->id,
                'question' => $val,
                'type' => $request->question_type[$key],
                'explaination' => $request->correct_answer_explaination[$key]
            ]);
            foreach ($request->options[$key] as $val) {
                $option = PaperQuestionOptions::create([
                    'paper_id' => $paper->id,
                    'question_id' => $paper_question->id,
                    'option' => $val,
                ]);
            }

            foreach ($request->radio[$key] as $val) {
                $correct_option = PaperQuestionOptions::where(['option' => $val, 'question_id' => $paper_question->id])->first();
                $corretAnswer =  PaperQuestionCorrectAnswers::create([
                    'paper_id' => $paper->id,
                    'question_id'=> $paper_question->id,
                    'option_id' => $correct_option->id,
                    'correct_answer' => $val,
                ]);
            }
        }
        return redirect()->to('/admin/paper')->with('message', 'Paper Created Successfully!');
    }

    public function destroy(Request $request)
    {
        Paper::findOrFail($request->paper_id)->delete();
        return true;
    }

    public function reviewPaper($paper_id)
    {
        $paper = Paper::find($paper_id);
        $questions = PaperQuestions::where('paper_id' , $paper_id)->with('getOptions.correctAnswers')->orderBy('id', 'ASC')->get();
        return view('admin.paper.review_paper')
            ->with(compact('paper', 'questions'));
    }

    public function getExplaination(Request $request)
    {
        $exp = PaperQuestions::where('id', $request->question_id)->first('explaination');
        return $exp;
    }
}
