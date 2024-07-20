<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Announcement;
use App\Booking;
use App\Mail\twoFactorVerification;
use App\Team;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;

class TwoFactorVerificationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
//    public function index()
//    {c
//        $users=null;
//        $teams=Team::where('leader_id','=',Auth::id())->get()->all();
//
//        foreach($teams as $team)
//        {
//            $users=User::where('team_id','=',$team->id)->get()->all();
//        }
//
//        $announcements = Announcement::all()->where('status',1);
//        return view('home',compact('announcements','users'));
//    }

public function two_factor_verification_submit(Request $request){
    // echo "two";
    // exit;
    $number = $request->vdigit1 . $request->vdigit2 . $request->vdigit3 . $request->vdigit4 . $request->vdigit5 . $request->vdigit6;
    $number = (int) $number;
        $users = User::all();
        $code_status = 0;
        foreach ($users as $user){
            if(isset($user->two_factor_passcode) == $number){
              $code_status = 1;  
            }
        }


        $user = User::where('two_factor_passcode',$number)->first();

        if (isset($user) && !empty($user) && $code_status == 1){
            $expiry_time = time() + (60*60*24*15);
            setcookie("obj_user", $user, $expiry_time, "/");
            Auth::loginUsingId($user->id, true);

            return redirect('/home');
        }else{
            $request->session()->flash('Error', 'Wrong Code');
            $request->session()->flash('Success', '');

            $user = new \stdClass();

            $user->id = $request->user_id;
            return view('email.twoFactorVerification', compact('user'));
//            echo "Wrong Code";
        }
}


public function admin_two_factor_verification_submit(Request $request){

    $number = $request->vdigit1 . $request->vdigit2 . $request->vdigit3 . $request->vdigit4 . $request->vdigit5 . $request->vdigit6;
    $number = (int) $number;
//print_r($number);die;
       $users = Admin::all();
        $code_status = 0;
        foreach ($users as $user){
            if(isset($user->two_factor_passcode) == $number){
              $code_status = 1;  
            }
        }
        $user = Admin::where('two_factor_passcode',$number)->first();

        if (isset($user) && !empty($user) && $code_status == 1){
            $expiry_time = time() + (60*60*24*15);
            setcookie("obj_admin", $user, $expiry_time, "/");
            $admin_chat_user = User::where('id',$user->user_id)->first();
            if (isset($admin_chat_user) && $admin_chat_user->id > 0){
//                if (Auth::guard('admin')->attempt(['email' => $user->email, 'password' => Hash::check($user->password), 'status' => 1])) {
                    Auth::guard('admin')->loginUsingId($user->id, true);
                    Auth::loginUsingId($admin_chat_user->id, true);
                    return redirect('/admin/home');

//                }else{


            }else{
               echo "something went wrong, Try again later";
            }


        }else{
            $request->session()->flash('Error', 'Wrong Code');
            $request->session()->flash('Success', '');

            $user = new \stdClass();

            $user->id = $request->user_id;
            return view('admin.twoFactorVerification', compact('user'));
//            echo "Wrong Code";
        }


}


public function admin_resend_two_factor_verification_submit($id, Request $request){
    $user = Admin::where('id',$id)->first();

    $six_digit_random_number = mt_rand(100000, 999999);
//                $user->two_factor_passcode = Hash::make($six_digit_random_number);
    $user->two_factor_passcode = $six_digit_random_number;
    $user->save();
   

    Mail::to($user->email)->send(new twoFactorVerification($user->id, $six_digit_random_number));

    $request->session()->flash('Success', 'Code Resend To ' . $user->email . ' Please Check Your Email');
    $request->session()->flash('Error', '');


    return view('admin.twoFactorVerification', compact('user'));
}

    public function resend_two_factor_verification_submit($id, Request $request){
        $user = User::where('id',$id)->first();

        $six_digit_random_number = mt_rand(100000, 999999);
//                $user->two_factor_passcode = Hash::make($six_digit_random_number);
        $user->two_factor_passcode = $six_digit_random_number;
        $user->save();

        Mail::to($user->email)->send(new twoFactorVerification($user->id, $six_digit_random_number));

        $request->session()->flash('Success', 'Code Resend To ' . $user->email . ' Please Check Your Email');
        $request->session()->flash('Error', '');


        return view('email.twoFactorVerification', compact('user'));
    }



}
