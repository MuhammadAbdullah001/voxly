<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Http\Controllers\Controller;
use App\Admin;
use App\Mail\twoFactorVerification;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AdminAuthController extends Controller
{

    use AuthenticatesUsers;

    protected $redirectTo = '/admin/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:admin');

    }


    //index to view login
    public function index()
    {
        return view('auth.admin.login');
    }

//    login method to get post data and login user
    public function login(Request $request)
    {
        // Validate the form data
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);
        // Attempt to log the user in
        $user = Admin::where('email', $request->email)->first();
        if ($user) {
            //            $pass = Hash::make("admin123");
            //            dd($pass); 
            $validCredentials = Hash::check($request['password'], $user->getAuthPassword());
            if ($validCredentials) {
                $user = Admin::where('email', $request->email)->first();
                if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password, 'status' => 1], $request->remember)) {
                    $admin = User::where('id', Auth::guard('admin')->user()->user_id)->first();
                    // if successful, then redirect to their intended location
                    if (isset($admin->id) && $admin->id > 0){
                        Auth::loginUsingId($admin->id, true);
                    }
                    // if successful, then redirect to their intended location
                    return redirect()->intended(route('admin.home'));
                }
                // if (isset($_COOKIE['obj_admin'])) {
                //     $data = $_COOKIE['obj_admin'];
                //     $data = json_decode($data);
                //     if (isset($data->id) && !empty($data->id)) {
                //         if ($data->id == $user->id) {
                //             if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password, 'status' => 1], $request->remember)) {
                //                 $admin = User::where('id', Auth::guard('admin')->user()->user_id)->first();
                //                 // if successful, then redirect to their intended location
                //                 if (isset($admin->id) && $admin->id > 0){
                //                     Auth::loginUsingId($admin->id, true);
                //                 }
                //                 // if successful, then redirect to their intended location
                //                 return redirect()->intended(route('admin.home'));
                //             }
                //         }else{
                //             $six_digit_random_number = mt_rand(100000, 999999);
                //             //                $user->two_factor_passcode = Hash::make($six_digit_random_number);
                //             $user->two_factor_passcode = $six_digit_random_number;
                //             $user->save();
                //             Mail::to($user->email)->send(new twoFactorVerification($user->id, $six_digit_random_number));
                //             return view('admin.twoFactorVerification', compact('user'));
                //         }
                //     }else{
                //         $six_digit_random_number = mt_rand(100000, 999999);
                //         //                $user->two_factor_passcode = Hash::make($six_digit_random_number);
                //         $user->two_factor_passcode = $six_digit_random_number;
                //         $user->save();
                //         Mail::to($user->email)->send(new twoFactorVerification($user->id, $six_digit_random_number));
                //         return view('admin.twoFactorVerification', compact('user'));
                //     }
                // }else{
                //     $six_digit_random_number = mt_rand(100000, 999999);
                //     //                $user->two_factor_passcode = Hash::make($six_digit_random_number);
                //     $user->two_factor_passcode = $six_digit_random_number;
                //     $user->save();
                //     Mail::to($user->email)->send(new twoFactorVerification($user->id, $six_digit_random_number));
                //     return view('admin.twoFactorVerification', compact('user'));
                //     //                return redirect('/twoFactorVerification');

                // }


            }else{

                return redirect()->back()->withInput($request->only('email', 'remember'))->withErrors(['email', 'email or password incorrect']);
            }
        }
        // if unsuccessful, then redirect back to the login with the form data
        return redirect()->back()->withInput($request->only('email', 'remember'))->withErrors(['email', 'email or password incorrect']);
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();
        $request->session()->invalidate();



        return $this->loggedOut($request) ?: redirect('/admin/login');
    }


}
