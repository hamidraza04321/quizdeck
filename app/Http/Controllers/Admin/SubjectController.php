<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Subject;
use File;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subjects = Subject::get();
        return view('admin.subject.index')
            ->with(compact('subjects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.subject.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:subject',
            'image' => 'required'
        ], $messages = [
            'name.required' => 'The name field must be required*',
            'image.required' => 'The image must be required*',
        ]);

        $fileName = null;
        if (request()->File('image'))
        {
            $file = request()->File('image');
            $fileName = md5($file->getClientOriginalName()) . time() . "." . $file->getClientOriginalExtension();
            $file->move(public_path('/images'), $fileName);
        }

        Subject::create([
            'name' => $request->get('name'),
            'image' => $fileName,
        ]);

        return redirect('/admin/subject')->with('message', 'Subject created Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $subject = Subject::find($id);
        return view('admin.subject.edit')
            ->with(compact('subject'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $subject = Subject::find($id);

        $request->validate([
            'name' => 'required'
        ], $messages = [
            'name.required' => 'The name field must be required*'
        ]);

        $currentImage = $subject->image;

        $fileName = null;
        if (request()->File('image'))
        {
            unlink('./images/' . $currentImage);
            $file = request()->File('image');
            $fileName = md5($file->getClientOriginalName()) . time() . "." . $file->getClientOriginalExtension();
            $file->move(public_path('/images'), $fileName);
        }

        $subject = [
            'name'  =>  $request->get('name'),
            'image' => ($fileName) ? $fileName : $currentImage,
        ];

        Subject::whereId($id)->update($subject);
        return redirect('/admin/subject')->with('message', 'Subject Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function delete(Request $request)
    {
        $subject = Subject::find($request->subjectID);
        unlink('./images/' . $subject->image);
        $subject->delete();
        return true;
    }
}
