<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Session;
// use Illuminate\Foundation\Auth\AuthenticatesUsers;
// use Illuminate\Support\Facades\Hash;
//use Illuminate\Support\Facades\Mail;
//use Illuminate\Support\Str;

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

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }


    public function appSendResetLinkEmail(Request $request)
    {
        $this->validateEmail($request);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $response = $this->broker()->sendResetLink(
            $this->credentials($request)
        );
        if ($response == Password::RESET_LINK_SENT){
            Auth::logout();
            $response = [
                'success' => true,

                'message' => 'Reset Password Email Sent successfully On Your Email Address',
            ];

            return response()->json($response, 200);
        }else{
            $response = [
                'success' => false,
                'message' => 'Invalid Email, Reset Password Email Not Sent',
            ];
            return response()->json($response, 200);
        }

//        return $response == Password::RESET_LINK_SENT
//            ? $this->sendResetLinkResponse($request, $response)
//            : $this->sendResetLinkFailedResponse($request, $response);
    }



}
