<?php

namespace App\Http\Controllers;

use App\Group;
use App\StaffSalary;
use App\StaffTeacher;
use App\StudentAdmission;
use App\StudentAttendance;
use App\StudentFee;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class StaffTeacherSalaryController extends Controller
{
    //

    public function salary_due(Request $request)
    {
        if ($request->ajax()) {
            $staff_salary = StaffSalary::with('teacher')->where('is_active', 1)->where('status', 'unpaid');
        
            return DataTables::of($staff_salary)
            ->addColumn('actions',function($row){
                return '<div class="list-icons">
                <div class="dropdown">
                    <a href="#" class="list-icons-item" data-toggle="dropdown">
                        <i class="icon-menu9"></i>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="'. url('admin/teacher-salary/edit/'.$row->id) .'" class="dropdown-item"><i class="icon-pencil3"></i> Edit</a>
                    </div>
                </div>
            </div>';
            })
            ->editColumn('description',function($row){
                return '<textarea>'.  $row->description .'</textarea>';
            })
            ->editColumn('payment_type',function($row){
               return strtoupper(str_replace('_',' ',$row->payment_type));
            })
            ->editColumn('expected_amount',function($row){
                return  number_format($row->expected_amount,0); 
 						 
            })
            
            ->editColumn('amount_taken',function($row){
               return number_format($row->amount_taken,0);
            })
            ->addColumn('fee_status',function($row){
                return '
                <select style="opacity: initial; height: auto;" name="fee_status" class="form-control form-control-select2" data-id= "'.$row->id.'" id="salary-status">
                <option '. ($row->status == "" ? "selected":"" ).' value="">Please Select</option>
                <option '.($row->status == "paid" ? "selected":"" ).' value="paid">Paid</option>
                <option '.($row->status == "unpaid" ? "selected":"").'  value="unpaid">Un-Paid</option>
            </select>';
            })
            ->setRowAttr([
                'class' => function ($row) {
                    return (isset($row->is_update) && $row->is_update == 1) ? 'bg-warning' : '';
                }
            ])
            ->rawColumns(['actions','fee_status','description'])
            ->make(true);
         }

        $data['breadcrumbs'] = array(['name' => 'Home', 'active' => true, 'url' => '']);
        return view('admin/staff_teacher_salary/main', compact('data'));

    }

    public function salary_paid(Request $request)
    {

        if ($request->ajax()) {
            $staff_salary_paid = StaffSalary::where('status', 'paid')->where('is_active', 1);
        
            return DataTables::of($staff_salary_paid)
            ->addColumn('actions',function($row){
                return '<div class="list-icons">
                <div class="dropdown">
                    <a href="#" class="list-icons-item" data-toggle="dropdown">
                        <i class="icon-menu9"></i>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="'. url('admin/teacher-salary/edit/'.$row->id) .'" class="dropdown-item"><i class="icon-pencil3"></i> Edit</a>
                    </div>
                </div>
            </div>';
            })
            ->editColumn('description',function($row){
                return '<textarea>'.  $row->description .'</textarea>';
            })
            ->editColumn('payment_type',function($row){
               return strtoupper(str_replace('_',' ',$row->payment_type));
            })
            ->editColumn('expected_amount',function($row){
                return  number_format($row->expected_amount,0); 
 						 
            })
            ->editColumn('amount_taken',function($row){
               return number_format($row->amount_taken,0);
            })
            ->editColumn('status',function($row){
                return '<div class="'.($row->status== 'paid' ? "badge badge-success" : "").'">'.$row->status.'</div>';
            })
            ->setRowAttr([
                'class' => function ($row) {
                    return (isset($row->is_update) && $row->is_update == 1) ? 'bg-warning' : '';
                }
            ])
            ->rawColumns(['actions','status','description'])
            ->make(true);
                    }
                            $data['breadcrumbs'] = array(['name' => 'Home', 'active' => true, 'url' => '']);
        return view('admin/staff_teacher_salary/teacher_salary_paid', compact('data'));

    }

    public function salary_expected_by_attendance(Request $request)
    {
        if ($request->ajax()) {
            $teachers = StaffTeacher::where('is_active', 1);
        
            return DataTables::of($teachers)
            ->addColumn('assigned_group',function($row){
                return $row->assignedSubjects['assigned_group'];
            })
            ->addColumn('subjects_name',function($row){
                return $row->assignedSubjects['subjects_name'];
            })
            ->editColumn('expected_salary',function($row){
                $fee_conflicted_last_pay_date = DB::select("select salary_to_date from staff_salaries  where staff_teachers_id = '$row->id'   order by id desc limit 1 ");
                if (isset($fee_conflicted_last_pay_date) && count($fee_conflicted_last_pay_date) > 0) {
                    $from_date = date('Y-m-d', (strtotime($fee_conflicted_last_pay_date[0]->salary_to_date) + (60 * 60 * 24))); //add 1 day to get st unpaid salary day from last pay date
                    $to_date = date('Y-m-d');
                    $teacher_attendance = DB::select("select count(*) as atttendance_count from staff_attendances  where staff_teacher_id = '$row->id' and  date(date) between '$from_date' and '$to_date'");
    
    
                } else {
                    $month = date('m', strtotime('-3 month'));
    
                    $from_date = date('Y-' . $month . '01');
                    $to_date = date('Y-m-d');
                    $teacher_attendance = DB::select("select count(*) as atttendance_count from staff_attendances  where staff_teacher_id = '$row->id' and  date(date) between '$from_date' and '$to_date'");
    
                }
    
                $expected_salary_duration = $teacher_attendance[0]->atttendance_count;
                $per_day_salary = $row->per_hour_rate * $row->daily_working_hours;
                $expected_salary = $per_day_salary * $teacher_attendance[0]->atttendance_count;
    
                $row->expected_salary = $expected_salary;
                $row->expected_salary_duration = $expected_salary_duration;
    
    
                if(isset($row->expected_salary) && $row->expected_salary >0)
                return '<div class="badge badge-success">'.$row->expected_salary.'</div>';
                else
                return '<div class="badge badge-success">0</div>';
                
            })
            ->editColumn('expected_salary_duration',function($row){
                $fee_conflicted_last_pay_date = DB::select("select salary_to_date from staff_salaries  where staff_teachers_id = '$row->id'   order by id desc limit 1 ");
                if (isset($fee_conflicted_last_pay_date) && count($fee_conflicted_last_pay_date) > 0) {
                    $from_date = date('Y-m-d', (strtotime($fee_conflicted_last_pay_date[0]->salary_to_date) + (60 * 60 * 24))); //add 1 day to get st unpaid salary day from last pay date
                    $to_date = date('Y-m-d');
                    $teacher_attendance = DB::select("select count(*) as atttendance_count from staff_attendances  where staff_teacher_id = '$row->id' and  date(date) between '$from_date' and '$to_date'");
    
    
                } else {
                    $month = date('m', strtotime('-3 month'));
    
                    $from_date = date('Y-' . $month . '01');
                    $to_date = date('Y-m-d');
                    $teacher_attendance = DB::select("select count(*) as atttendance_count from staff_attendances  where staff_teacher_id = '$row->id' and  date(date) between '$from_date' and '$to_date'");
    
                }
    
                $expected_salary_duration = $teacher_attendance[0]->atttendance_count;
                $per_day_salary = $row->per_hour_rate * $row->daily_working_hours;
                $expected_salary = $per_day_salary * $teacher_attendance[0]->atttendance_count;
    
                $row->expected_salary = $expected_salary;
                $row->expected_salary_duration = $expected_salary_duration;
    
    
                if(isset($row->expected_salary) && $row->expected_salary >0)
                return '<div class="badge badge-success">'.$row->expected_salary_duration.'</div>';
                else
                return '<div class="badge badge-success">No Attendance</div>';
                
            })
            ->editColumn('is_resigned',function($row){
                if ($row->is_resigned == 1){
                    return 'Resigned';
                }else{
                    return 'Active';
                }
             
            })
            ->setRowAttr([
                'class' => function ($row) {
                    return (isset($row->is_resigned) && $row->is_resigned == 1) ? 'bg-warning' : '';
                }
            ])
            ->rawColumns(['expected_salary','expected_salary_duration'])
            ->make(true);
                    }
        // $teachers = StaffTeacher::where('is_active', 1)->get();
        // foreach ($teachers as $key => $teacher) {
           
        // }
        // $data['teachers'] = $teachers;
        $data['breadcrumbs'] = array(['name' => 'Home', 'active' => true, 'url' => '']);

        return view('admin/staff_teacher_salary/expected_teacher_salary_by_attendance', compact('data'));


    }

//    public function getSelectedStudent(Request $request)
//    {
////        dd($request);
//
//        $fee_to_date = strtotime($request->fee_to_date); // or your date as well
//        $fee_from_date = strtotime($request->fee_from_date);
//        $datediff = $fee_to_date - $fee_from_date;
//
//        $num_of_days = round($datediff / (60 * 60 * 24));
//        $num_of_days += 1; //add one day to manage current day as its giving 27-1 out of 30 as 4 instead of five days
////        print_r($num_of_days);die;
//
//
//        $student = StudentAdmission::where('id', $request->student_id)->where('is_active', 1)->first();
//        $student_last_fee = StaffSalary::where('student_admissions_id', $request->student_id)->where('id', $request->student_id)->where('is_active', 1)->first();
//
//        $from_date = date('Y-m-d', strtotime($request->fee_from_date));
//        $to_date = date('Y-m-d', strtotime($request->fee_to_date));
//
////       $fee_conflicted_last_pay_date = DB::select("select to_date from student_fees  where student_admissions_id = '$request->student_id' and  date(to_date) between '$from_date' and '$to_date' order by id desc limit 1 ");
//        $fee_conflicted_last_pay_date = DB::select("select to_date from student_fees  where student_admissions_id = '$request->student_id'   order by id desc limit 1 ");
//
////       dd( ($fee_conflicted_last_pay_date));
//        if ($fee_conflicted_last_pay_date[0]->to_date < $from_date
//            && $to_date > $fee_conflicted_last_pay_date[0]->to_date) {
//            if (isset($student) && !empty($student) > 0) {
//
//
//                return response()->json(['data' => $student,], 200);
//
//            } else {
//                $data['msg'] = "No Student Found!";
//                return response()->json(['data' => $data,], 500);
//
//            }
//        } else {
//            $data['msg'] = "Fee Already Paid Till " . date('d-M-Y', strtotime($fee_conflicted_last_pay_date[0]->to_date));
//            return response()->json(['data' => $data,], 500);
//        }
//
//
////        if (count($fee_conflicted_last_pay_date) == 0){
////            if (isset($student) && !empty($student)>0){
////
////
////                return response()->json(['data' => $student, ],200);
////
////            }else{
////                $data['msg']="No Student Found!";
////                return response()->json(['data' => $data, ],500);
////
////            }
////        }else{
////            $data['msg']="Fee Already Paid Till ". date('d-M-Y',strtotime($fee_conflicted_last_pay_date[0]->to_date));
////            return response()->json(['data' => $data, ],500);
////        }
//
//
//    }

    public function get_selected_teachers_by_group(Request $request)
    {
        $teachers = StaffTeacher::where('is_resigned', 0)->where('is_active', 1)->get();
        $group_teachers = array();
        foreach ($teachers as $key => $teacher) {
            $teacher_group_id = json_decode($teacher->assignedSubjects['assigned_group_id']);
//            $student_attendance = StudentAttendance::where('date',date('Y-m-d',strtotime($request->date)))->where('student_admissions_id',$student->id)->where('is_active',1)->get();
// print_r($teacher_group_id);
            if (isset($teacher_group_id) && !empty($teacher_group_id)) {
                foreach ($teacher_group_id as $group_id) {
//                dd( ($request->group_id));

                    if ($group_id == $request->group_id) {

                        $group_teachers[] = $teacher;

                    }
                }
            }

        }


        if (isset($group_teachers) && count($group_teachers) > 0) {


            return response()->json(['data' => $group_teachers,], 200);

        } else {
            $data['msg'] = "No Teacher Found!";
            return response()->json(['data' => $data,], 500);

        }

    }

    public function getSelectedTeacher(Request $request)
    {

        $salary_to_date = strtotime($request->salary_to_date); // or your date as well
        $salary_from_date = strtotime($request->salary_from_date);
        $datediff = $salary_to_date - $salary_from_date;

        $num_of_days = round($datediff / (60 * 60 * 24));
        $num_of_days += 1; //add one day to manage current day as its giving 27-1 out of 30 as 4 instead of five days
//        print_r($num_of_days);die;


        $teacher = StaffTeacher::where('id', $request->teacher_id)->where('is_active', 1)->first();
//        $student_last_fee = StudentFee::where('student_admissions_id', $request->student_id)->where('id', $request->student_id)->where('is_active', 1)->first();

        $from_date = date('Y-m-d', strtotime($request->salary_from_date));
        $to_date = date('Y-m-d', strtotime($request->salary_to_date));

        $teacher_attendance = DB::select("select count(*) as atttendance_count from staff_attendances  where staff_teacher_id = '$request->teacher_id' and  date(date) between '$from_date' and '$to_date'");

//       $fee_conflicted_las t_pay_date = DB::select("select to_date from student_fees  where student_admissions_id = '$request->student_id' and  date(to_date) between '$from_date' and '$to_date' order by id desc limit 1 ");
        $fee_conflicted_last_pay_date = DB::select("select salary_to_date from staff_salaries  where staff_teachers_id = '$request->teacher_id'   order by id desc limit 1 ");

//       dd( ($fee_conflicted_last_pay_date));
        if (count($fee_conflicted_last_pay_date) == 0 || $fee_conflicted_last_pay_date[0]->salary_to_date < $from_date
            && $to_date > $fee_conflicted_last_pay_date[0]->salary_to_date) {
            if (isset($teacher) && !empty($teacher)) {
                $expected_salary_duration = $teacher_attendance[0]->atttendance_count;
                $per_day_salary = $teacher->per_hour_rate * $teacher->daily_working_hours;
                $expected_salary = $per_day_salary * $teacher_attendance[0]->atttendance_count;
                $salary_obj = new \stdClass();
                $salary_obj->expected_salary = $expected_salary;
                $salary_obj->expected_salary_duration = $expected_salary_duration;
                return response()->json(['data' => $salary_obj,], 200);

            } else {
                $data['msg'] = "No Teacher Found!";
                return response()->json(['data' => $data,], 500);

            }
        } else {
            $data['msg'] = "Salary Already Paid Till " . date('d-M-Y', strtotime($fee_conflicted_last_pay_date[0]->salary_to_date));
            return response()->json(['data' => $data,], 500);
        }


    }

    public function salary_add(Request $request)
    {
        $groups = Group::where('is_active', 1)->get();
        $teachers = StaffTeacher::where('is_resigned', 0)->where('is_active', 1)->get();
        $data['groups'] = $groups;
        $data['teachers'] = $teachers;
        $data['breadcrumbs'] = array(['name' => 'Home', 'active' => true, 'url' => '']);
        return view('admin/staff_teacher_salary/add', compact('data'));

    }


    public function salary_submit(Request $request)
    {


//                dd($request);die;

        $validatedData = $request->validate([
            'salary_from_date' => ['required'],
            'salary_to_date' => ['required'],
            'teacher_id' => ['required'],
            'date' => ['required'],
            'payment_type' => ['required','alpha_dash'],
            'amount' => ['required'],
            'salary_duration' => ['required'],

        ]);


//
//        $from_date = date('Y-m-d',strtotime($request->fee_from_date));
//        $to_date = date('Y-m-d',strtotime($request->fee_to_date));
//
//       $attendance_count = DB::select("select count(*) as total_attendance from student_attendances  where student_admissions_id = '$request->student_admissions_id' and  date(date) between '$from_date' and '$to_date'");
//
//
//
//dd($attendance_count[0]->total_attendance);
//
//
//
//
        if (strtotime($request->salary_to_date) >= strtotime($request->salary_from_date)) {

            $teacher = StaffTeacher::where('id', $request->teacher_id)->where('is_active', 1)->first();

            $agreed_fee_per_hour = $teacher->agreed_fee_per_hour;
            $agreed_hour = $teacher->agreed_hour;
            $fee_per_day = $agreed_fee_per_hour * $agreed_hour;
//        $expected_salary = $fee_per_day = $num_of_days;


            $salary_add = new StaffSalary();
            $salary_add->salary_from_date = date('Y-m-d', strtotime($request->salary_from_date));
            $salary_add->salary_to_date = date('Y-m-d', strtotime($request->salary_to_date));
            $salary_add->staff_teachers_id = $request->teacher_id;
            $salary_add->entry_date = date('Y-m-d', strtotime($request->date));
            $salary_add->payment_type = $request->payment_type;
            if (!empty($request->description)) {
                $salary_add->description = $request->description;

            } else {
                $salary_add->description = '';

            }
            $salary_add->amount_taken = $request->amount;
            $salary_add->expected_amount = $request->expected_salary_value;
            $salary_add->paid_duration = $request->salary_duration;
            $salary_add->per_hour_rate = $teacher->per_hour_rate;
            $salary_add->working_hours = $teacher->daily_working_hours;
            $salary_add->status = "unpaid";


            $added = $salary_add->save();
            $data['success_msg'] = 'Salary  Added Successfully!';
            if ($added) {
                $data['breadcrumbs'] = array(['name' => 'Home', 'active' => true, 'url' => '']);
//                return redirect('admin/teacher-salary-due')->with('success', 'Salary  Added Successfully!');
                return redirect()->back()->with('success', ' Salary  Added Successfully!');


            } else {
                $data['danger_msg'] = 'Salary Not Added';
                $data['breadcrumbs'] = array(['name' => 'Home', 'active' => true, 'url' => '']);
                return redirect()->back()->with('error', 'Salary Not Added');


            }
        } else {
            return redirect()->back()->with('error', ' Salary to date should be greater then salary from date');

        }

    }


    public function change_salary_status(Request $request)
    {


        $salary_status_update = StaffSalary::find($request->teacher_salary_id);
        $salary_status_update->status = $request->status;
        $updated = $salary_status_update->save();
        if ($updated) {


            $data['msg'] = "Salary Paid Successfully!";
            return response()->json(['data' => $data,], 200);

        } else {
            $data['msg'] = "Status Not Changed Successfully!";
            return response()->json(['data' => $data,], 500);

        }

    }


    public function edit_salary(Request $request)
    {

        $salary_edit = StaffSalary::find($request->id);

//        dd($expense);
        $data['salary_edit'] = $salary_edit;
        $data['breadcrumbs'] = array(['name' => 'Home', 'active' => true, 'url' => '']);
        return view('admin/staff_teacher_salary/edit', compact('data'));

    }

    public function update_salary(Request $request)
    {
//        dd($request);die;

        if (strtotime($request->salary_to_date) >= strtotime($request->salary_from_date)) {

        $fee_update = StaffSalary::find($request->id);
        $fee_update->salary_from_date = date('Y-m-d', strtotime($request->salary_from_date));
        $fee_update->salary_to_date = date('Y-m-d', strtotime($request->salary_to_date));
        $fee_update->entry_date = date('Y-m-d', strtotime($request->date));
        $fee_update->payment_type = $request->payment_type;
        $fee_update->description = $request->description;
        $fee_update->amount_taken = $request->amount;
        $fee_update->paid_duration = $request->salary_duration;

        $added = $fee_update->save();
        $data['success_msg'] = 'Fee Edit Successfully!';
        if ($added) {
            $data['breadcrumbs'] = array(['name' => 'Home', 'active' => true, 'url' => '']);

            return redirect('admin/teacher-salary-due/')->with('success', 'Salary Edit Successfully!');

        } else {
            $data['danger_msg'] = 'Salary Not Edit Successful!';
            $data['breadcrumbs'] = array(['name' => 'Home', 'active' => true, 'url' => '']);
            return redirect('admin/teacher-salary-due/')->with('status', 'Salary Not Edit Successfully!');

//            return view('admin/student_admission/edit/', compact('data'));

        }
        } else {
            return redirect()->back()->with('error', ' Salary to date should be greater then salary from date');

        }
    }


}
