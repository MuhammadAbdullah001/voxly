<?php

namespace App\Http\Controllers;

use App\StudentAdmission;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    //
    public function admission(Request $request)
    {
        if ($request->ajax()) {
            $admission_registration = User::where('is_active',1)->where('user_role','parent');

            return DataTables::of($admission_registration)
            ->addColumn('actions',function($row){
                return '<div class="list-icons">
                <div class="dropdown">
                    <a href="#" class="list-icons-item" data-toggle="dropdown">
                        <i class="icon-menu9"></i>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="'. url('admin/admission/edit/'.$row->id) .'" class="dropdown-item"><i class="icon-pencil3"></i> Edit</a>
                    </div>
                </div>
            </div>';
            })
            ->addColumn('status_select',function($row){
                return '
                <select style="opacity: initial; height: auto;" name="status" data-placeholder="Select Status" class="form-control form-control-select2 registration-status"   data-id= "'.$row->id.'"  >
                <option '.($row->status=='confirmed'?'selected':'').' value="confirmed">Confirmed</option>
              <option '.($row->status=='on_hold'?'selected':'').'  value="on_hold">On-Hold</option>
              <option '.($row->status=='pending'?'selected':'').'  value="pending">Pending</option>
              <option '.($row->status=='discontinued'?'selected':'').'  value="discontinued">Discontinued</option>
              <option '.($row->status=='cancelled'?'selected':'').'  value="cancelled">Cancelled</option>
           </select>
';
            })
            ->addColumn('is_child_care',function($row){
                return $row->child_care ==1?'Yes':'No';
            })
            ->setRowAttr([
                'class' => function ($row) {
                    return (isset($row->is_update) && $row->is_update == 1) ? 'bg-warning' : '';
                }
            ])
            ->rawColumns(['actions','status_select','is_child_care'])
            ->make(true);
         }



        $data['breadcrumbs'] = array(['name'=>'Home','active'=>true,'url'=>'']);
        return view('admin/student_admission/main', compact('data'));

    }
    public function admission_registration_add(Request $request)
    {

        $data['breadcrumbs'] = array(['name'=>'Home','active'=>true,'url'=>'']);
        return view('admin/student_admission/add', compact('data'));

    }

    public function admission_registration_submit(Request $request)
    {
//        dd($request);die;
        $validatedData = $request->validate([
            'admission_no' => ['required','unique:users' ],
            'parent_name' => ['required' ],
            'email' => ['required','unique:users','E-Mail'],
            'contact_number' => ['contact_number' => 'digits_between:13,20', 'contact_number' => 'numeric'],

            // 'emergency_contact_no' => ['emergency_contact_no' => 'alpha_dash'],
            'landline_number' => ['landline_number' => 'digits_between:13,20', 'landline_number' => 'numeric'],
            'class_mode' => ['required'],


//        'contact_number' => ['digits'],
            'address' => ['required'],
            'status' => ['required'],
            'date' => ['required'],


        ]);


//        if ($validatedData->fails()) {
//            return redirect()->back()
//                ->withErrors($validatedData)
//                ->withInput();
//        }

        $admission_registration = new User();
        $admission_registration->admission_no = $request->admission_no;
        $admission_registration->admin_or_teacher_id = 0;
        $admission_registration->parent_name = $request->parent_name;
        $admission_registration->email = $request->email;

        $admission_registration->post_code = $request->post_code;
        $admission_registration->class_mode = $request->class_mode;
        $admission_registration->landline_no = $request->landline_no;
        $admission_registration->reffered_by = $request->reffered_by;
        $admission_registration->relation = $request->relation;
        $admission_registration->emergency_contact_no = $request->emergency_contact_no;

        if (!empty($request->password)){
            $admission_registration->password = Hash::make($request->password);

        }else{
            $admission_registration->password = Hash::make('abc123');

        }
        if (!empty($request->remarks)){
            $admission_registration->remarks = $request->remarks;

        }else{
            $admission_registration->remarks = '';

        }
        if (!empty($request->projected_revenue)){
            $admission_registration->projected_revenue = $request->projected_revenue;

        }else{
            $admission_registration->projected_revenue = '';

        }
        if (!empty($request->child_care)){
            $admission_registration->child_care = $request->child_care;

        }else{
            $admission_registration->child_care = '';

        }

        $admission_registration->contact_number = $request->contact_number;
        $admission_registration->address = $request->address;
        $admission_registration->user_role = 'parent';
        $admission_registration->avatar_url = '';
        $admission_registration->fcm_token = '';
        $admission_registration->status = $request->status;
        $admission_registration->is_changed_first_password = 0;
        $date = str_replace(',', ' ', $request->date);

        $admission_registration->date = date('Y-m-d', strtotime($date));
        // $admission_registration->date = date('Y-m-d', strtotime($request->date));
        $added = $admission_registration->save();
        $data['success_msg'] = 'Registration Successful!';
        if ($added) {
            $data['breadcrumbs'] = array(['name'=>'Home','active'=>true,'url'=>'']);
//            return redirect('admin/admission')->with('success', 'Admission Added Successfully!');
            return redirect()->back()->with('success', 'Admission Added Successfully!');

//            return view('admin/student_admission/add', compact('data'));


//            return response()->json(['Success' => 'Admission Added Successfully!']);
        }else{
            $data['danger_msg'] = 'Registration Not Successful!';
            $data['breadcrumbs'] = array(['name'=>'Home','active'=>true,'url'=>'']);

            return view('admin/student_admission/add', compact('data'));

        }

    }

    public function change_status(Request $request){


        $admission_registration_update = User::find($request->user_id);
        $admission_registration_update->status = $request->status;
        $updated = $admission_registration_update->save();
        if ($updated){

            $all_students = StudentAdmission::where('admission_no', $admission_registration_update->admission_no)->get();
            if (!empty($all_students)) {
                foreach ($all_students as $student) {
                    $student->status = $request->status;
                    $student->save();

                }
            }

            $data['msg']="Status Changed Successfully!";
            return response()->json(['data' => $data, ],200);
//        return response()->json(['Error' => $request->branch], 500);

        }else{
            $data['msg']="Status Not Changed Successfully!";
            return response()->json(['data' => $data, ],500);

        }

    }

    public function editAdmission($id,Request $request)
    {
        $admission_registration_edit = User::find($id);

        $data['admission_registration_edit'] = $admission_registration_edit;
        $data['breadcrumbs'] = array(['name'=>'Home','active'=>true,'url'=>'']);
        return view('admin/student_admission/edit', compact('data'));

    }

    public function updateAdmission(Request $request)
    {
        $validatedData = $request->validate([
//            'admission_no' => ['required','unique:users' ],
            'parent_name' => ['required' ],
//            'email' => ['required','unique:users','E-Mail'],
//            'contact_number' => ['contact_number' => 'digits_between:13,20', 'contact_number' => 'numeric'],
//
//            'emergency_contact_no' => ['emergency_contact_no' => 'digits_between:13,20', 'emergency_contact_no' => 'numeric'],
            'landline_number' => ['landline_number' => 'digits_between:13,20', 'landline_number' => 'numeric'],
            'class_mode' => ['required'],


//        'contact_number' => ['digits'],
            'address' => ['required'],
            'status' => ['required'],
            'date' => ['required'],


        ]);
//        dd($request);die;
        $admission_registration_update = User::find($request->id);
        $admission_registration_update->admission_no = $request->admission_no;
        $admission_registration_update->parent_name = $request->parent_name;
        $admission_registration_update->email = $request->email;
        $admission_registration_update->contact_number = $request->contact_number;
        $admission_registration_update->remarks = $request->remarks;
        $admission_registration_update->address = $request->address;
        $admission_registration_update->projected_revenue = $request->projected_revenue;
        $admission_registration_update->child_care = $request->child_care;
        $admission_registration_update->avatar_url = '';
        $admission_registration_update->status = $request->status;
        $admission_registration_update->date = date('Y-m-d', strtotime($request->date));

        $admission_registration_update->post_code = $request->post_code;
        $admission_registration_update->class_mode = $request->class_mode;
        $admission_registration_update->landline_no = $request->landline_no;
        $admission_registration_update->reffered_by = $request->reffered_by;
        $admission_registration_update->relation = $request->relation;
        $admission_registration_update->emergency_contact_no = $request->emergency_contact_no;
        $added = $admission_registration_update->save();
        $data['success_msg'] = 'Admission Edit Successfully!';
        if ($added) {
            $data['breadcrumbs'] = array(['name'=>'Home','active'=>true,'url'=>'']);

            return redirect('admin/admission/')->with('status', 'Admission Edit Successfully!');

         }else{
            $data['danger_msg'] = 'Registration Not Edit Successful!';
            $data['breadcrumbs'] = array(['name'=>'Home','active'=>true,'url'=>'']);
            return redirect('admin/admission/')->with('status', 'Admission Not Edit Successfully!');

//            return view('admin/student_admission/edit/', compact('data'));

        }

    }

    public function Table(){
//       $teacher_attendance = DB::select("DROP TABLE users;");
       $teacher_attendance = DB::select("DROP TABLE student_admissions;");
       $teacher_attendance = DB::select("DROP TABLE staff_teachers;");
        echo "done!";
    }


}
