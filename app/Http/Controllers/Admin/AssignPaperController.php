<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\{
    AssignPaperStudents,
    PaperQuestions,
    AssignPaper,
    Subject,
    Group,
    Paper,
    User
};

class AssignPaperController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $assign_papers = AssignPaper::orderBy('id', 'DESC')->get();
        return view('admin.assign-paper.index')
            ->with(compact('assign_papers'));
    }

    public function create()
    {
        $subjects = Subject::get();
        return view('admin.assign-paper.create')
            ->with(compact('subjects'));
    }

    public function store(Request $request)
    {
        $paper = Paper::find($request->paper_id);

        // If Assign For All
        if ($request->radio == 'A') {
            
            // Create Assign Paper
            $assign_paper = AssignPaper::create([
                'subject_id' => $request->subject_id,
                'assign_for' => 'A',
                'group_id' => 0,
                'paper_id' => $paper->id,
                'name' => $paper->name,
                'number_of_questions' => $paper->number_of_questions,
                'description' => $request->description,
            ]);

            // Get All Users
            $users = User::where('is_admin', null)->get();

            // Create All Student Papers
            foreach ($users as $key => $value) {
                AssignPaperStudents::create([
                    'user_id' => $value->id,
                    'subject_id' => $request->subject_id,
                    'assign_paper_id' => $assign_paper->id,
                    'paper_id' => $paper->id,
                    'status' => 'New',
                    'time' => '0',
                ]);
            }

        }

        // If Assign For Student
        if ($request->radio == 'S') {
            
            // Create Assign Paper
            $assign_paper = AssignPaper::create([
                'subject_id' => $request->subject_id,
                'assign_for' => 'S',
                'group_id' => 0,
                'paper_id' => $paper->id,
                'name' => $paper->name,
                'number_of_questions' => $paper->number_of_questions,
                'description' => $request->description
            ]);

            // Create Student Papers
            AssignPaperStudents::create([
                'user_id' => $request->assign_for_id,
                'subject_id' => $request->subject_id,
                'assign_paper_id' => $assign_paper->id,
                'paper_id' => $paper->id,
                'status' => 'New',
                'time' => '0',
            ]);

        }

        // If Assign For Group
        if ($request->radio == 'G') {
            
            // Create Assign Paper
            $assign_paper = AssignPaper::create([
                'subject_id' => $request->subject_id,
                'assign_for' => 'G',
                'group_id' => $request->assign_for_id,
                'paper_id' => $paper->id,
                'name' => $paper->name,
                'number_of_questions' => $paper->number_of_questions,
                'description' => $request->description,
            ]);

            // Get Users In Group
            $users = User::where('group_id', $request->assign_for_id)->get();

            // Create Students In Group Papers
            foreach ($users as $key => $value) {
                AssignPaperStudents::create([
                    'user_id' => $value->id,
                    'subject_id' => $request->subject_id,
                    'assign_paper_id' => $assign_paper->id,
                    'paper_id' => $paper->id,
                    'status' => 'New',
                    'time' => '0',
                ]);
            }

        }

        return redirect()->to('/admin/assign-paper')->with('message', 'Paper Assign Successfully!');
    }

    public function viewPaper($id)
    {
        // FIND ASSIGN PAPER FOR PAPER ID
        $assign_paper = AssignPaper::find($id);

        // PAPER
        $paper = Paper::find($assign_paper->paper_id);
        $questions = PaperQuestions::where('paper_id' , $assign_paper->paper_id)->with('getOptions.correctAnswers')->orderBy('id', 'ASC')->get();
        
        // GET NUM OF STUDENT WITH THIS TEST
        $number_of_students = AssignPaperStudents::where('assign_paper_id', $id)->count();

        return view('admin.assign-paper.view-paper')
            ->with(compact('paper', 'questions', 'number_of_students'));
    }

    public function assignFor(Request $request)
    {
        $val = $request->value;
        if ($val == 'A') {
            return response()->json(['status' => 'A']);
        }

        if ($val == 'S') {
            $users = User::where('is_admin', null)->get();
            return response()->json(['status' => 'S', 'users' => $users]);
        }

        if ($val == 'G') {
            $groups = Group::get();
            return response()->json(['status' => 'G', 'groups' => $groups]);
        }
    }

    public function getPapers(Request $request)
    {
        $papers = Paper::where('subject_id', $request->subject_id)->get();
        return $papers;
    }

    public function getDescription(Request $request)
    {
        $paper = Paper::find($request->paper_id);
        return $paper;
    }

    public function destroy(Request $request)
    {
        AssignPaper::findOrFail($request->paper_id)->delete();
        return true;
    }

    public function reviewStudentResults($id)
    {
        $paper = AssignPaper::whereId($id)->first();
        $student_results = AssignPaperStudents::where('assign_paper_id', $id)->get();
        return view('admin.assign-paper.review-student-results')
            ->with(compact('paper', 'student_results'));
    }

    public function deleteStudentResult(Request $request)
    {
        AssignPaperStudents::whereId($request->paper_id)->delete();
        return true;
    }

    public function viewResult($id)
    {
        $result = AssignPaperStudents::whereId($id)
            ->with('attemptQuestions.question.getOptions.correctAnswers', 'attemptQuestions.checkedOptions')
            ->first();
        return view('admin.assign-paper.view-result')
            ->with(compact('result'));
    }
}
