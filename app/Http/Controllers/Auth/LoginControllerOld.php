


<?php

namespace App\Http\Controllers\Auth;


use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Mail\twoFactorVerification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\StaffTeacher;

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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function applogin(Request $request)
    {
        $this->validateLogin($request);

        if ($this->attemptLogin($request)) {
            $user = $this->guard()->user();
            $user->generateToken();



            if ($user->user_role == 'parent') {
                if ($user->status != 'confirmed') {
                    $response = [
                        'success' => false,
                        'message' => 'Status Not Confirmed, Contact To Admin',
                    ];
                    return response()->json($response, 200);
                }
            } elseif ($user->user_role == 'teacher') {
                $teacher =  StaffTeacher::find($user->admin_or_teacher_id);
                if ($teacher->is_resigned == 1) {
                    $response = [
                        'success' => false,
                        'message' => 'Status Not Confirmed, Contact To Admin',
                    ];
                    return response()->json($response, 200);
                }


            }


//            $branches = \App\Branch::where('is_active',1)->get();
            $response = [
                'success' => true,
                'data' => $user,
                'message' => 'Logged in successfully',
            ];

            return response()->json($response, 200);


//            echo response()->json([
//                'status'=>200,
//                'data' => $user,
//            ]);
        }else{


            $response = [
                'success' => false,
                'message' => 'Invalid email/password',
            ];
            return response()->json($response, 200);

//            echo response()->json( json_encode([
//                'status'=>500,
//                'msg'=>'invalid user/password'
//            ]));
        }



    }

}

