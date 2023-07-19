<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Group;
use App\User;

class GroupController extends Controller
{
    public function index()
    {
        $groups = Group::get();
        $users = User::where([ 'is_admin' => null, 'group_id' => 0])->get();
    	return view('admin.group.index')
            ->with(compact('groups', 'users'));
    }

    public function store(Request $request)
    {
    	$group = Group::where('name', $request->group_name)->first();
    	if ($group) {
    		return 'false';
    	}

    	$group = Group::create([
    		'name' => $request->group_name
    	]);
    	return response()->json(['status' => 'true', 'group' => $group]);
    }

    public function addUserInGroup(Request $request)
    {
        $user = User::find($request->user_id);
        $user->update([
            'group_id' => $request->group_id
        ]);
        return $user;
    }

    public function deleteGroup(Request $request)
    {
        $users = User::where('group_id', $request->group_id)->get();
        foreach ($users as $key => $user) {
            $user->update([
                'group_id' => 0
            ]);
        }

        Group::find($request->group_id)->delete();
        
        return response()->json($users);
    }

    public function groupUsers(Request $request)
    {
        $users = User::where('group_id', $request->group_id)->get();
        return response()->json($users);
    }

    public function removeUser(Request $request)
    {
        $user = User::find($request->user_id);
        $user->update([
            'group_id' => 0
        ]);
        return response()->json($user);
    }
}
