<?php

namespace App\Http\Controllers;

use App\Group;
use App\StudentAdmission;
use App\Subject;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Redirector;
use Yajra\DataTables\DataTables;

class StudentController extends Controller
{
    //
    public function student(Request $request)
    {
         
        if ($request->ajax()) {
            $student_register = StudentAdmission::with('group')->where('student_admissions.is_active',1);

            return DataTables::of($student_register)
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
            ->setRowAttr([
                'class' => function ($row) {
                    return (isset($row->is_update) && $row->is_update == 1) ? 'bg-warning' : '';
                }
            ])
            ->rawColumns(['actions','status_select'])
            ->make(true);
         }


        $data['breadcrumbs'] = array(['name'=>'Home','active'=>true,'url'=>'']);
        return view('admin/student/main', compact('data'));

    }

    public function student_add(Request $request)
    {
        $student_admissions = User::where('is_active',1)->get();
        $subjects = Subject::where('is_active',1)->get();
        $groups = Group::where('is_active',1)->get();
        $data['student_admissions'] = $student_admissions;
        $data['subjects'] = $subjects;
        $data['groups'] = $groups;

        $data['breadcrumbs'] = array(['name'=>'Home','active'=>true,'url'=>'']);
        return view('admin/student/add', compact('data'));

    }

      public function student_submit(Request $request)
    {
//        dd($request);die;
        $validatedData = $request->validate([
            'subject_id' => ['required' ],
            'student_name' => ['required' ],
            'school_name' => ['required'],
            'group_id' => ['required'],
             'agreed_fee_per_hr' => ['required'],
            'agreed_hrs' => ['required'],
            'status' => ['required'],
            'date' => ['required'],
//            'assessment_result' => ['required'],

        ]);

        $subject_id_array = array();
        $subject_name_array = array();
        foreach ($request->subject_id as $subject_id){
            $student_data = explode('/',$subject_id);

            $subject_id_array[] = $student_data[0];
            $subject_name_array[] = $student_data[1];
        }

        $json_arr_id = json_encode($subject_id_array);
        $json_arr_name = json_encode($subject_name_array);



        $student_registration = new StudentAdmission();
        $student_registration->admission_no = $request->admission_no;
        $student_registration->student_name = $request->student_name;
        $student_registration->school_name = $request->school_name;
        $student_registration->group_id = $request->group_id;
        $student_registration->package_type = $request->package_type;
        $student_registration->agreed_fee_per_hr = $request->agreed_fee_per_hr;
        $student_registration->agreed_hrs = $request->agreed_hrs;



        $student_registration->subject_id = $json_arr_id;
        $student_registration->subject_name = $json_arr_name;
        $student_registration->remarks = $request->remarks;
        $student_registration->address = '';
         $student_registration->status = $request->status;

         $student_registration->assessment_result = $request->assessment_result;
         $date = str_replace(',', ' ', $request->date);

        $student_registration->date = date('Y-m-d', strtotime($date));

        $added = $student_registration->save();
        $data['success_msg'] = 'Student Registred Successful!';
        if ($added) {
            $data['breadcrumbs'] = array(['name'=>'Home','active'=>true,'url'=>'']);

//            return view('admin/student/add', compact('data'));
//            return redirect('admin/student/')->with('success', 'Student Registered Successfully!');
            return redirect()->back()->with('success', 'Student Added Successfully!');

//            return response()->json(['Success' => 'Successfully Added']);
        }else{
            $data['danger_msg'] = 'Student Not Registered Successful!';
            $data['breadcrumbs'] = array(['name'=>'Home','active'=>true,'url'=>'']);

            return view('admin/student/add', compact('data'));

        }

    }


    public function change_status(Request $request){


        $student_register_update = StudentAdmission::find($request->student_id);
        $student_register_update->status = $request->status;
        $updated = $student_register_update->save();
        if ($updated){

            $data['msg']="Status Changed Successfully!";
            return response()->json(['data' => $data, ],200);

        }else{
            $data['msg']="Status Not Changed Successfully!";
            return response()->json(['data' => $data, ],500);

        }

    }

    public function edit_student($id,Request $request)
    {
        $student_admissions = User::where('is_active',1)->get();
//        $subjects = Subject::where('is_active',1)->get();
        $groups = Group::where('is_active',1)->get();
        $student_edit = StudentAdmission::find($id);

        $student_group_all_subjects = Subject::where('group_id',$student_edit->group_id)->where('is_active',1)->get();

        if (isset($student_group_all_subjects) && count($student_group_all_subjects)>0) {
            foreach ($student_group_all_subjects as $key => $group_subject) {
                $student_enrolled_subjects = json_decode($student_edit->subject_id);

                foreach ($student_enrolled_subjects as $stu_sub){

                    if ($group_subject->id == $stu_sub){

                        $student_group_all_subjects[$key]->selected = "selected";

                    }

                }
            }
        }
//        dd($student_group_all_subjects);
         $data['student_admissions'] = $student_admissions;
        $data['subjects'] = $student_group_all_subjects;
        $data['groups'] = $groups;
        $data['student_edit'] = $student_edit;
        $data['breadcrumbs'] = array(['name'=>'Home','active'=>true,'url'=>'']);
        return view('admin/student/edit', compact('data'));

    }

    public function update_student(Request $request)
    {
    //    dd($request);die;

        $validatedData = $request->validate([
            'subject_id' => ['required' ],
            'student_name' => ['required' ],
            'school_name' => ['required'],
            'group_id' => ['required'],
             'agreed_fee_per_hr' => ['required'],
            'agreed_hrs' => ['required'],
            'status' => ['required'],
            'date' => ['required'],
//            'assessment_result' => ['required'],

        ]);

        $studentregistration_update = StudentAdmission::find($request->id);

        if (!empty($request->subject_id) && count($request->subject_id)>0){



        $subject_id_array = array();
        $subject_name_array = array();

        foreach ($request->subject_id as $subject_id){
            $student_data = explode('/',$subject_id);

            $subject_id_array[] = $student_data[0];
            $subject_name_array[] = $student_data[1];
        }

        $json_arr_id = json_encode($subject_id_array);
        $json_arr_name = json_encode($subject_name_array);

         $studentregistration_update->subject_id = $json_arr_id;
        $studentregistration_update->subject_name = $json_arr_name;
        }

        $studentregistration_update->admission_no = $request->admission_no;
        $studentregistration_update->student_name = $request->student_name;
        $studentregistration_update->school_name = $request->school_name;
        $studentregistration_update->remarks = $request->remarks;
        $studentregistration_update->address = $request->address;
        $studentregistration_update->status = $request->status;
        $studentregistration_update->package_type = $request->package_type;
        $studentregistration_update->agreed_fee_per_hr = $request->agreed_fee_per_hr;
        $studentregistration_update->agreed_hrs = $request->agreed_hrs;
        $studentregistration_update->assessment_result = $request->assessment_result;
        $studentregistration_update->date = date('Y-m-d', strtotime($request->date));
        $studentregistration_update->group_id = $request->group_id;
        $added = $studentregistration_update->save();
        $data['success_msg'] = 'Student Edit Successfully!';
        if ($added) {
            $data['breadcrumbs'] = array(['name'=>'Home','active'=>true,'url'=>'']);

            return redirect('admin/student/')->with('status', 'Student Edit Successfully!');

         }else{
            $data['danger_msg'] = 'Student Not Edit Successful!';
            $data['breadcrumbs'] = array(['name'=>'Home','active'=>true,'url'=>'']);
            return redirect('admin/student/')->with('status', 'Student Not Edit Successfully!');

//            return view('admin/student_admission/edit/', compact('data'));

        }

    }
    public function get_subjects(Request $request)
    {
        $subjects = Subject::where('group_id',$request->group_id)->where('is_active',1)->get();
        $result = array();
        if (isset($subjects) && count($subjects)>0){
            foreach ($subjects as $subject){
                $data = new \stdClass();
                $data->id = $subject->id . '/' . $subject->name ;
                $data->text =  $subject->name;
                $result[] = $data;
            }
            $result = json_encode($result);
            return $result;
//                response()->json(['data' => $result, ],200);

        }else{
            $data['msg']="No Data Found!";
            return response()->json(['data' => $data, ],500);
        }

    }



}
