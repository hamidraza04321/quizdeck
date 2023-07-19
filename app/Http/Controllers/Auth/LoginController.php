<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm(Request $request)
    {
        $show_reset_password_alert = false;
        if (isset($request->resetPassword)) {
            $show_reset_password_alert = true;
        }

        return view('admin.auth.login', compact('show_reset_password_alert'));
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $data = [
            'username' => $request->username,
            'password' => $request->password,
            'status'   => 'ACTIVE'
        ];

        if (auth()->attempt($data)) {
            if (auth()->user()->is_admin == 1){
                return response()->json([
                    'role' => 'admin'
                ]);
            } else {
                return response()->json([
                    'role' => 'user'
                ]);
            }
        } else {
            return response()->json([ 
                'error' => 'The Username or Password is Invalid !'
            ]);
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->to('/login')->with(['logout' => 'Logout Successfully!']);
    }
}
