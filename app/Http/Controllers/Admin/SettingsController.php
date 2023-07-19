<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Settings;

class SettingsController extends Controller
{
    public function index()
    {
    	return view('admin.settings');
    }

    public function store(Request $request)
    {
    	$request->validate([
            'app_name'          => 'required|min:3|max:255',
            'logo'          	=> 'required',
            'user_registration' => 'required|in:0,1'
        ]);

    	$data = [
    		'app_name' 			=> $request->app_name,
    		'logo' 	   			=> $request->logo,
    		'user_registration' => $request->user_registration
    	];

	    $settings = Settings::find(1);

	    if ($settings) {
	    	$saveSettings = $settings->update($data);
	    } else {
	    	// TURNCATE SETTINGS TABLE
	    	Settings::truncate();

	    	// STORE AS ID 1
	    	$saveSettings = Settings::create($data);
	    }

	    return redirect()->back()->with('message', 'Settings Updated Successfully!');
    }
}
