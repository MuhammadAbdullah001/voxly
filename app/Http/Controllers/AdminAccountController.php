<?php

namespace App\Http\Controllers;

use App\Admin;
use App\ContactUs;
use App\Group;
use App\StaffTeacher;
use App\StudentAdmission;
use App\Subject;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Redirector;
use Illuminate\Support\Facades\Hash;

class AdminAccountController extends Controller
{
    //
    public function account(Request $request)
    {
        $admin_accounts = Admin::where('is_active',1)->get();
         $data['admin_accounts'] = $admin_accounts;
        $data['breadcrumbs'] = array(['name'=>'Home','active'=>true,'url'=>'']);
        return view('admin/admin_account/main', compact('data'));

    }
    public function account_add(Request $request)
    {

        $data['breadcrumbs'] = array(['name'=>'Home','active'=>true,'url'=>'']);
        return view('admin/admin_account/add', compact('data'));

    }

    public function account_submit(Request $request)
    {
//        dd($request);die;

        $validatedData = $request->validate([
            'name' => ['required', 'max:255'],
            'email' => ['required','unique:admins', 'max:255'],
            'password' => ['required'],
//            'contact_number' => ['required'],
            'contact_number' => ['contact_number' => 'digits_between:13,20', 'contact_number' => 'numeric'],

            'address' => ['required'],
        ]);
        $is_duplicate_email=0;

        if (!empty($request->email)){
            $users = User::select('email')->get();
            $admins = Admin::select('email')->get();
            foreach ($users as $user){
                if ($user->email == $request->email){
                    $is_duplicate_email = 1;
                }
            }
            foreach ($admins as $admin){
                if ($admin->email == $request->email){
                    $is_duplicate_email = 1;
                }
            }
        }


        if ($is_duplicate_email == 0){

            $admin_account_add = new Admin();
            $admin_account_add->name = $request->name;
            $admin_account_add->email = $request->email;
            $admin_account_add->user_id = 0;
            $admin_account_add->password = Hash::make($request->password);
            $admin_account_add->type = $request->type;
            $admin_account_add->status = 1;
            $admin_account_add->two_factor_passcode = 0;
            $admin_account_add->avatar_url = '';
            $admin_account_add->address = $request->address;
            $admin_account_add->contact_number = $request->contact_number;

            if ( !empty($request->dob_month) && !empty($request->dob_day) && !empty($request->dob_year)){
                 $admin_account_add->dob_month = $request->dob_month;
                $admin_account_add->dob_day = $request->dob_day;
                $admin_account_add->dob_year = $request->dob_year;
            }else{
                 $admin_account_add->dob_month = '00';
                $admin_account_add->dob_day = '00';
                $admin_account_add->dob_year = '0000';
            }
            if ( !empty($request->cnic)  ){
                $admin_account_add->cnic = $request->cnic;

            }else{
                $admin_account_add->cnic = '';

            }

            $admin_account_add->is_active = 1;

            $added = $admin_account_add->save();
            $data['success_msg'] = 'Account Registered Successfully!';
            if ($added) {

//            create user account of Teacher for role checking in API's and for chat/notification

                $admin_user_account_add = new User();
                $admin_user_account_add->admission_no = '';
                $admin_user_account_add->admin_or_teacher_id = $admin_account_add->id;
                $admin_user_account_add->parent_name = $admin_account_add->name;
                $admin_user_account_add->email = $request->email;
                $admin_user_account_add->password = Hash::make($request->password);
                $admin_user_account_add->contact_number = $request->contact_number;
                $admin_user_account_add->remarks = 'User account of super-admin';
                $admin_user_account_add->address = $request->address;
                $admin_user_account_add->user_role = 'super_admin';
                $admin_user_account_add->projected_revenue = '';
                $admin_user_account_add->child_care = '';
                $admin_user_account_add->avatar_url = '';
                $admin_user_account_add->fcm_token = '';
                $admin_user_account_add->class_mode = '';
                $admin_user_account_add->status = 'confirmed';
                $admin_user_account_add->date = date('Y-m-d', strtotime(date('Y-m-d')));
                $added = $admin_user_account_add->save();

                $admin_account_add->user_id = $admin_user_account_add->id;
                $admin_account_add->save();
                $data['breadcrumbs'] = array(['name'=>'Home','active'=>true,'url'=>'']);
//            return redirect()->back()->with();
//                return redirect('admin/admin-accounts/')->with('success', 'Account Registered Successfully!');
                return redirect()->back()->with('success', 'Account Registered Successfully!');

//            return view('admin/admin_account/add', compact('data'));
//            return response()->json(['Success' => 'Successfully Added']);
            }else{
                $data['danger_msg'] = 'Account Not Registered Successfully!';
                $data['breadcrumbs'] = array(['name'=>'Home','active'=>true,'url'=>'']);

                return view('admin/admin_account/add', compact('data'));

            }

        }else{

            $data['danger_msg'] = 'Staff Not Registered Successful!';
            $data['breadcrumbs'] = array(['name'=>'Home','active'=>true,'url'=>'']);
            return redirect()->back()->with('error', ' Email Has Alreay Been Taken/Account Not Registered Successfully!');

//            return view('admin/staff/add', compact('data'));

        }

    }

    public function change_status(Request $request){


        $admin_status_update = Admin::find($request->admin_id);
        $admin_status_update->status = $request->status;
         $updated = $admin_status_update->save();
        if ($updated){
            $admin_user_status_update = User::find($admin_status_update->user_id);
            $admin_user_status_update->is_active = $request->status;
            $admin_user_status_update->save();

            $data['msg']="Status Changed Successfully!";
            return response()->json(['data' => $data, ],200);

        }else{
            $data['msg']="Status Not Changed Successfully!";
            return response()->json(['data' => $data, ],500);

        }

    }

    public function edit_account($id,Request $request)
    {

        $admin_account = Admin::find($id);

        $data['admin_account'] = $admin_account;
        $data['breadcrumbs'] = array(['name'=>'Home','active'=>true,'url'=>'']);
        return view('admin/admin_account/edit', compact('data'));

    }

    public function update_account(Request $request)
    {
//        dd($request);die;
        $admin_update = Admin::find($request->id);


        $admin_update->name = $request->name;
        $admin_update->email = $request->email;
        if (!empty($request->password)){
            $admin_update->password = Hash::make($request->password);

        }

        $admin_update->contact_number = $request->contact_number;
        $admin_update->address = $request->address;
        $admin_update->cnic = $request->cnic;
        $admin_update->dob_month = $request->dob_month;
        $admin_update->dob_day = $request->dob_day;
        $admin_update->dob_year = $request->dob_year;
        $admin_update->type = $request->type;

        $added = $admin_update->save();

        $data['success_msg'] = 'Account Edit Successfully!';
        if ($added) {

            $is_duplicate_email=0;

            if (!empty($request->email)){
//                $users = User::select('email')->get();
                $users = User::where('id', '!=',$admin_update->user_id)->get();

//                $teachers = StaffTeacher::select('email')->get();
                $admins = Admin::where('id', '!=',$admin_update->id)->get();
                foreach ($users as $user){
                    if ($user->email == $request->email){
                        $is_duplicate_email = 1;
                    }
                }
                foreach ($admins as $admin){
                    if ($admin->email == $request->email){
                        $is_duplicate_email = 1;
                    }
                }
            }


            if ($is_duplicate_email == 0) {

                if (isset($admin_update->user_id) && !empty($admin_update->user_id)){
                $admin_user = User::where('id', $admin_update->user_id)->first();
                $admin_user->email =  $request->email;
                $admin_user->parent_name =  $request->name;
                $admin_user->save();
            }

            }else{
                return redirect()->back()->with('error', ' Email Has Alreay Been Taken/Account Not Registered Successfully!');


            }
            $data['breadcrumbs'] = array(['name'=>'Home','active'=>true,'url'=>'']);

            return redirect('admin/admin-accounts/')->with('status', 'Account Edit Successfully!');

         }else{
            $data['danger_msg'] = 'Account Not Edit Successful!';
            $data['breadcrumbs'] = array(['name'=>'Home','active'=>true,'url'=>'']);
            return redirect('admin/admin-accounts/')->with('status', 'Account Not Edit Successfully!');

//            return view('admin/student_admission/edit/', compact('data'));

        }

    }

    public function contactUs(Request $request)
    {
        $contactUs = ContactUs::where('is_active',1)->get();
        $data['contactUs'] = $contactUs;
        $data['breadcrumbs'] = array(['name'=>'Home','active'=>true,'url'=>'']);
        return view('admin/admin_account/contact_us', compact('data'));

    }

    public function changeStatusContactUs(Request $request){


        $admin_contact_us_status_update = ContactUs::find($request->id);
        $admin_contact_us_status_update->status = $request->status;
        $updated = $admin_contact_us_status_update->save();
        if ($updated){

            $data['msg']="Status Changed Successfully!";
            return response()->json(['data' => $data, ],200);

        }else{
            $data['msg']="Status Not Changed Successfully!";
            return response()->json(['data' => $data, ],500);

        }

    }


}
