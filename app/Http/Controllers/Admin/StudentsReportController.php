<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\{
	AssignPaperStudents,
	User
};

class StudentsReportController extends Controller
{
    public function index()
    {
    	$users = User::where('is_admin', null)->get();
    	return view('admin.student-report.index')
    		->with(compact('users'));
    }

    public function getReport(Request $request)
    {
    	$id = $request->user_id;
    	$record = [];
    	$last_ten_records = AssignPaperStudents::where(['user_id' => $id, 'status' => 'Submitted'])->orderBy('id', 'DESC')->limit(10)->with('paper')->get();
    	foreach ($last_ten_records as $key => $value) {
    		$record['time'][] = (int)$value->time;
    		$record['number_of_questions'][] = (int)$value->paper->number_of_questions;
    		$record['number_of_correct'][] = (int)$value->correct;
    	}
    	return response()->json($record);
    }
}
