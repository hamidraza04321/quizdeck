<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\{
	Paper,
	Group,
	User	
};

class DashboardController extends Controller
{
    public function index()
    {
    	// GET USERS COUNT
    	$users 		  = User::where('is_admin', null)->get();
    	$users_count  = count($users);
    	
    	// GET PAPERS COUNT
    	$papers 	  = Paper::get();
    	$papers_count = count($papers);

    	// GET GROUPS COUNT
    	$groups 	  = Group::get();
    	$groups_count = count($groups);

    	return view('admin.dashboard', compact('users_count', 'papers_count', 'groups_count'));
    }
}
