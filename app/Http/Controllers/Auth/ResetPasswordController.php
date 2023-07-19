<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Validator;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use DB;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    public function showResetForm($token)
    {
        $email = DB::table('password_resets')
                    ->select('password_resets.email')
                    ->where('token', $token)
                    ->first();

        return view('admin.auth.resetPassword')->with(
            ['token' => $token, 'email' => $email->email]
        );
    }

    public function reset(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email'         => 'required',
            'token'         => 'required|string',
            'password'      => 'required|string'
        ]);

        if ($validator->fails()) {
            $response = [
                'status' => false,
                'errors' => $validator->errors()
            ];
        } else {
            $user = User::where('email', $request->email)->first();
            $user->update([
                'password' => Hash::make($request->password)
            ]);

            $response = [
                'status' => true
            ];
        }

        return response()->json($response);
    }
}
