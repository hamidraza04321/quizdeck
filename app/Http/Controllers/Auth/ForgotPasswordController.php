<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Mail;
use DB;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    public function sendResetLinkEmail(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email'          => 'required|string|exists:users,email'
        ]);

        if ($validator->fails()) {
            $response = [
                'status' => false,
                'error'  => $validator->errors()
            ];
        } else {
            $token = Str::random(64);
  
            DB::table('password_resets')->insert([
                'email' => $request->email, 
                'token' => $token, 
                'created_at' => Carbon::now()
            ]);

            Mail::send('auth.passwords.forgotPasswordEmail', ['token' => $token], function($message) use($request){
                $message->to($request->email);
                $message->subject('Reset Password');
            });

            $response = [
                'status'  => true,
                'message' => 'Mail Sent Successfully'
            ];
        }

        return response()->json($response);
    }
}
