<?php

namespace App\Http\Controllers;

use App\StudentAdmission;
use App\StudentAttendance;
use App\User;
use Illuminate\Http\Request;
use DataTables;
use Yajra\DataTables\DataTables as DataTablesDataTables;

class AttendanceController extends Controller
{

    public function attendance(Request $request)
    {
        if ($request->ajax()) {
            $attendances = StudentAttendance::with('student')->where('student_attendances.is_active',1);
            return DataTablesDataTables::of($attendances)
            ->addColumn('actions',function($row){
                return '<div class="list-icons">
                <div class="dropdown">
                    <a href="#" class="list-icons-item" data-toggle="dropdown">
                        <i class="icon-menu9"></i>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="'. url('admin/attendance/edit/'.$row->id) .'" class="dropdown-item"><i class="icon-pencil3"></i> Edit</a>
                    </div>
                </div>
            </div>';
            })
            ->rawColumns(['actions'])
            ->make(true);
         }
       
        $data['breadcrumbs'] = array(['name'=>'Home','active'=>true,'url'=>'']);
        return view('admin/attendance/main', compact('data'));

    }
    public function attendance_add(Request $request)
    {

        $admissions = User::where('status','confirmed')->where('user_role','parent')->where('is_active',1)->get();
         $data['admissions'] = $admissions;
        $data['breadcrumbs'] = array(['name'=>'Home','active'=>true,'url'=>'']);
        return view('admin/attendance/add', compact('data'));

    }

    public function get_students(Request $request)
    {
        $date = str_replace(',', ' ', $request->date);
        $date =   date('Y-m-d', strtotime($date));
         $students = StudentAdmission::where('admission_no',$request->admission_no)->where('status','confirmed')->where('is_active',1)->get();

         foreach ($students as $key=> $student){
             $student_attendance = StudentAttendance::where('date',date('Y-m-d',strtotime($date)))->where('student_admissions_id',$student->id)->where('is_active',1)->get();
//             dd(count($student_attendance));
             if (count($student_attendance) >0){

                 unset($students[$key]);

             }
         }


        if (isset($students) && count($students)>0){


             return response()->json(['data' => $students, ],200);

        }else{
            $data['msg']="No Student Found!";
            return response()->json(['data' => $data, ],500);

        }

    }

    public function attendance_submit(Request $request)
    {
//        dd($request);die;
        $validatedData = $request->validate([
            'student_admissions_id' => ['required' ],
             'admission_no' => ['required'],
             'date' => ['required'],

        ]);

        $student_attendance_add = new StudentAttendance();
        $student_attendance_add->student_admissions_id = $request->student_admissions_id;
        $student_attendance_add->admission_no = $request->admission_no;
        $date = str_replace(',', ' ', $request->date);

        $student_attendance_add->date = date('Y-m-d',strtotime($date));

        if (!empty($request->start_time)){
            $student_attendance_add->start_time =  $request->start_time.':00';

        }else{
            $student_attendance_add->start_time =  '00:00:00';

        }
        if (!empty($request->end_time)){
            $student_attendance_add->end_time = $request->end_time.':00';

        }else{
            $student_attendance_add->end_time =  '00:00:00';

        }
        if (!empty($request->description)){
            $student_attendance_add->description = $request->description;

        }else{
            $student_attendance_add->description = '';

        }

        $student_attendance_add->updated_by ='';
        $student_attendance_add->is_active = 1;
         $added = $student_attendance_add->save();
        $data['success_msg'] = 'Attendance Added Successfully!';
        if ($added) {
             unset($request->description);
             unset($request->end_time);
             unset($request->start_time);
             unset($request->admission_no);
             unset($request->student_admissions_id);
            $data['breadcrumbs'] = array(['name'=>'Home','active'=>true,'url'=>'']);
//            return redirect('admin/student-attendance')->with('success','Attendance Added Successfully!');
            return redirect()->back()->with('success', 'Attendance Added Successfully!');

//            return view('admin/attendance/add', compact('data'));
//            return response()->json(['Success' => 'Successfully Added']);
        }else{
            $data['danger_msg'] = 'Account Not Registered Successfully!';
            $data['breadcrumbs'] = array(['name'=>'Home','active'=>true,'url'=>'']);

            return view('admin/attendance/add', compact('data'));

        }

    }

    public function edit_attendance($id,Request $request)
    {

        $attendance = StudentAttendance::find($id);

        $data['attendance'] = $attendance;
        $data['breadcrumbs'] = array(['name'=>'Home','active'=>true,'url'=>'']);
        return view('admin/attendance/edit', compact('data'));

    }

    public function update_attendance(Request $request)
    {
//        dd($request);die;
        $attendance_update = StudentAttendance::find($request->id);


        if (!empty($request->start_time)){
            $attendance_update->start_time =  $request->start_time.':00';

        }else{
            $attendance_update->start_time =  '00:00:00';

        }
        if (!empty($request->end_time)){
            $attendance_update->end_time = $request->end_time.':00';

        }else{
            $attendance_update->end_time =  '00:00:00';

        }
//        $attendance_update->start_time =  $request->start_time.':00';
//        $attendance_update->end_time =  $request->end_time.':00';

        $attendance_update->description = $request->description;
        $attendance_update->updated_by =  auth()->user()->name;

        $added = $attendance_update->save();
        $data['success_msg'] = 'Attendance Edit Successfully!';
        if ($added) {
            $data['breadcrumbs'] = array(['name'=>'Home','active'=>true,'url'=>'']);

            return redirect('admin/student-attendance/')->with('status', 'Account Edit Successfully!');

        }else{
            $data['danger_msg'] = 'Attendance Not Edit Successful!';
            $data['breadcrumbs'] = array(['name'=>'Home','active'=>true,'url'=>'']);
            return redirect('admin/student-attendance/')->with('status', 'Account Not Edit Successfully!');

//            return view('admin/student_admission/edit/', compact('data'));

        }

    }

}
