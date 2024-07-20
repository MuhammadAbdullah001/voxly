<?php

namespace App\Http\Controllers;

use App\StudentAdmission;
use App\StudentAttendance;
use App\StudentFee;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Log;
use Yajra\DataTables\DataTables;

class StudentFeeController extends Controller
{
    //
    public function fee_due_temp(Request $request){
        dd("test123");
    }

    public function fee_due(Request $request)
    {
        $student_fees = StudentFee::where('is_active', 1)->where('status', 'unpaid')->get();
        if ($request->ajax()) {
            $student_fees = StudentFee::with('student','admin')->where('is_active', 1)->where('status', 'unpaid');

            return DataTables::of($student_fees)
            ->addColumn('actions',function($row){
                return '<div class="list-icons">
                <div class="dropdown">
                    <a href="#" class="list-icons-item" data-toggle="dropdown">
                        <i class="icon-menu9"></i>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="'. url('admin/student-fee/edit/'.$row->id) .'" class="dropdown-item"><i class="icon-pencil3"></i> Edit</a>
                    </div>
                </div>
            </div>';
            })
            ->editColumn('expected_amount',function($row){
                return  number_format($row->expected_amount,0);
            })   
            ->editColumn('amount_taken',function($row){
                return number_format($row->amount_taken,0);
            })
            ->editColumn('payment_type',function($row){
               return strtoupper(str_replace('_',' ',$row->payment_type));
            })
            ->addColumn('fee_status',function($row){
                return '
                <select style="opacity: initial; height: auto;" name="fee_status" class="form-control form-control-select2" data-id= "'.$row->id.'" id="fee-status">
                <option "'. ($row->status == "" ? "selected":"").' value="">Please Select</option>
                <option "'. ($row->status == "paid"? "selected":"") .'" value="paid">Paid</option>
                <option "'. ($row->status == "unpaid" ? "selected":"").'"  value="unpaid">Un-Paid</option>
            </select>';
            })
            ->setRowAttr([
                'class' => function ($row) {
                    return (isset($row->is_update) && $row->is_update == 1) ? 'bg-warning' : '';
                }
            ])
            ->rawColumns(['actions','fee_status'])
            ->make(true);
         }

        $total_outstanding = 0;
        foreach ($student_fees as $key => $student_fee) {
            $total_outstanding += $student_fee->amount_taken;
        }
        $data['total'] = $total_outstanding;
        $data['breadcrumbs'] = array(['name' => 'Home', 'active' => true, 'url' => '']);
        return view('admin/student_fee/main', compact('data'));

    }

    public function fee_paid(Request $request)
    {
        $students_name_id_combo= array();
        $students = StudentAdmission::get();
        foreach($students as $student){
            $students_name_id_combo[$student->id] = $student->student_name;
        }
        // dd($students_name_id_combo);
        if (isset($request->start_date) && isset($request->end_date) && !empty($request->end_date) && !empty($request->start_date)) {
            $start_date = explode(',', $request->start_date);
            $date = date('m-d', strtotime($start_date[0]));
            $date = $start_date[1] . '-' . $date;
            $start = strtotime($date);
            $end_date = explode(',', $request->end_date);
            $date_end = date('m-d', strtotime($end_date[0]));
            $date_end = $end_date[1] . '-' . $date_end;
            $end = strtotime($date_end);
            $start_time = date('Y-m-d 00:00:00', $start);
            $end_time = date('Y-m-d 23:59:59', $end);
        }
        if (isset($request->start_date) && isset($request->end_date) && !empty($request->end_date) && !empty($request->start_date)) {

        } else {
            $start_time = date('Y-m-1 00:00:00');
            $end_time = date('Y-m-31 23:59:59');
        }
        // print_r($start_time);
        // echo "<br>";
        // print_r($end_time);
        $student_fees = StudentFee::whereBetween('entry_date', [$start_time, $end_time])->where('status', 'paid')->get();
// dd($students);
//        $student_fees = DB::select("select * from student_fees where  date(created_at) between '$start_time' and '$end_time' and status = 'paid' order by id desc ");
//         $student_fees = StudentFee::where('status','paid')->where('is_active', 1)->get();
//        echo"<pre>";print_r($admission_registration);die;

        $data['student_fees'] = $student_fees;
        $data['students_name_id_combo'] = $students_name_id_combo;
        $total = 0;
        foreach ($student_fees as $key => $student_fee) {
            $total += $student_fee->amount_taken;
        }
        $data['total'] = $total;
        $data['start_date'] = $start_time;
        $data['end_date'] = $end_time;
        $data['breadcrumbs'] = array(['name' => 'Home', 'active' => true, 'url' => '']);
        return view('admin/student_fee/student_fee_paid', compact('data'));

    }

    public function fee_expected_by_attendance(Request $request)
    {
        if ($request->ajax()) {
            $student_fees = StudentAdmission::where('is_active', 1)->where('status', 'confirmed');

            return DataTables::of($student_fees)
            ->addColumn('actions',function($row){
                return '<div class="list-icons">
                <div class="dropdown">
                    <a href="#" class="list-icons-item" data-toggle="dropdown">
                        <i class="icon-menu9"></i>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="'. url('admin/student-fee/edit/'.$row->id) .'" class="dropdown-item"><i class="icon-pencil3"></i> Edit</a>
                    </div>
                </div>
            </div>';
            })
            ->editColumn('expected_amount',function($row){
                return  number_format($row->expected_amount,0);
            })   
            ->editColumn('amount_taken',function($row){
                return number_format($row->amount_taken,0);
            })
            ->editColumn('payment_type',function($row){
               return strtoupper(str_replace('_',' ',$row->payment_type));
            })
            ->editColumn('status',function($row){
                return '<div class="badge badge-success">'.$row->status.'</div>';
            })
            ->addColumn('expected_fee',function($row){
                $fee_conflicted_last_pay_date = DB::select("select to_date from student_fees  where student_admissions_id = '$row->id' and status = 'paid'    order by id desc limit 1 ");
                if (isset($fee_conflicted_last_pay_date) && count($fee_conflicted_last_pay_date) > 0) {
                    $from_date = date('Y-m-d', (strtotime($fee_conflicted_last_pay_date[0]->to_date) + (60 * 60 * 24))); //add 1 day to get st unpaid salary day from last pay date
                    $to_date = date('Y-m-d');
                    $student_attendence = DB::select("select count(*) as atttendance_count from student_attendances  where student_admissions_id = '$row->id' and  date(date) between '$from_date' and '$to_date'");
    
    
                } else {
                    $month = date('m', strtotime('-3 month'));
    
                    $from_date = date('Y-' . $month . '01');
                    $to_date = date('Y-m-d');
                    $student_attendence = DB::select("select count(*) as atttendance_count from student_attendances  where student_admissions_id = '$row->id' and  date(date) between '$from_date' and '$to_date'");
    
                }
    
                $expected_fee_duration = $student_attendence[0]->atttendance_count;
                $per_day_fee = $row->agreed_fee_per_hr * $row->agreed_hrs;
                $expected_fee = $per_day_fee * $student_attendence[0]->atttendance_count;
                if ($student_attendence[0]->atttendance_count > 0) {
                    $row->expected_fee = $expected_fee;
                    if (isset($fee_conflicted_last_pay_date[0]->to_date)) {
                        $row->last_fee_paid = $fee_conflicted_last_pay_date[0]->to_date;
    
                    }
                    $row->expected_fee_duration = $expected_fee_duration;
                } else {
                    $row->expected_fee = 'No Fee Remaining';
                    $row->expected_fee_duration = 'No Attendance Found';
                }
                return $row->expected_fee;
            })
            ->addColumn('last_fee_paid',function($row){
                $fee_conflicted_last_pay_date = DB::select("select to_date from student_fees  where student_admissions_id = '$row->id' and status = 'paid'    order by id desc limit 1 ");
                if (isset($fee_conflicted_last_pay_date) && count($fee_conflicted_last_pay_date) > 0) {
                    $from_date = date('Y-m-d', (strtotime($fee_conflicted_last_pay_date[0]->to_date) + (60 * 60 * 24))); //add 1 day to get st unpaid salary day from last pay date
                    $to_date = date('Y-m-d');
                    $student_attendence = DB::select("select count(*) as atttendance_count from student_attendances  where student_admissions_id = '$row->id' and  date(date) between '$from_date' and '$to_date'");
    
    
                } else {
                    $month = date('m', strtotime('-3 month'));
    
                    $from_date = date('Y-' . $month . '01');
                    $to_date = date('Y-m-d');
                    $student_attendence = DB::select("select count(*) as atttendance_count from student_attendances  where student_admissions_id = '$row->id' and  date(date) between '$from_date' and '$to_date'");
    
                }
    
                $expected_fee_duration = $student_attendence[0]->atttendance_count;
                $per_day_fee = $row->agreed_fee_per_hr * $row->agreed_hrs;
                $expected_fee = $per_day_fee * $student_attendence[0]->atttendance_count;
                if ($student_attendence[0]->atttendance_count > 0) {
                    $row->expected_fee = $expected_fee;
                    if (isset($fee_conflicted_last_pay_date[0]->to_date)) {
                        $row->last_fee_paid = $fee_conflicted_last_pay_date[0]->to_date;
    
                    }
                    $row->expected_fee_duration = $expected_fee_duration;
                } else {
                    $row->expected_fee = 'No Fee Remaining';
                    $row->expected_fee_duration = 'No Attendance Found';
                }
                return $row->last_fee_paid;
            })
            ->addColumn('expected_fee_duration',function($row){
                $fee_conflicted_last_pay_date = DB::select("select to_date from student_fees  where student_admissions_id = '$row->id' and status = 'paid'    order by id desc limit 1 ");
                if (isset($fee_conflicted_last_pay_date) && count($fee_conflicted_last_pay_date) > 0) {
                    $from_date = date('Y-m-d', (strtotime($fee_conflicted_last_pay_date[0]->to_date) + (60 * 60 * 24))); //add 1 day to get st unpaid salary day from last pay date
                    $to_date = date('Y-m-d');
                    $student_attendence = DB::select("select count(*) as atttendance_count from student_attendances  where student_admissions_id = '$row->id' and  date(date) between '$from_date' and '$to_date'");
    
    
                } else {
                    $month = date('m', strtotime('-3 month'));
    
                    $from_date = date('Y-' . $month . '01');
                    $to_date = date('Y-m-d');
                    $student_attendence = DB::select("select count(*) as atttendance_count from student_attendances  where student_admissions_id = '$row->id' and  date(date) between '$from_date' and '$to_date'");
    
                }
    
                $expected_fee_duration = $student_attendence[0]->atttendance_count;
                $per_day_fee = $row->agreed_fee_per_hr * $row->agreed_hrs;
                $expected_fee = $per_day_fee * $student_attendence[0]->atttendance_count;
                if ($student_attendence[0]->atttendance_count > 0) {
                    $row->expected_fee = $expected_fee;
                    if (isset($fee_conflicted_last_pay_date[0]->to_date)) {
                        $row->last_fee_paid = $fee_conflicted_last_pay_date[0]->to_date;
    
                    }
                    $row->expected_fee_duration = $expected_fee_duration;
                } else {
                    $row->expected_fee = 'No Fee Remaining';
                    $row->expected_fee_duration = 'No Attendance Found';
                }
                return $row->expected_fee_duration;
            })
            ->setRowAttr([
                'class' => function ($row) {
                    return (isset($row->expected_fee) && is_numeric($row->expected_fee)) ? 'bg-warning' : '';
                }
            ])
            ->rawColumns(['actions','status'])
            ->make(true);
         }
        $students = StudentAdmission::where('is_active', 1)->where('status', 'confirmed')->get();
        foreach ($students as $key => $student) {

            $fee_conflicted_last_pay_date = DB::select("select to_date from student_fees  where student_admissions_id = '$student->id' and status = 'paid'    order by id desc limit 1 ");
            if (isset($fee_conflicted_last_pay_date) && count($fee_conflicted_last_pay_date) > 0) {
                $from_date = date('Y-m-d', (strtotime($fee_conflicted_last_pay_date[0]->to_date) + (60 * 60 * 24))); //add 1 day to get st unpaid salary day from last pay date
                $to_date = date('Y-m-d');
                $student_attendence = DB::select("select count(*) as atttendance_count from student_attendances  where student_admissions_id = '$student->id' and  date(date) between '$from_date' and '$to_date'");


            } else {
                $month = date('m', strtotime('-3 month'));

                $from_date = date('Y-' . $month . '01');
                $to_date = date('Y-m-d');
                $student_attendence = DB::select("select count(*) as atttendance_count from student_attendances  where student_admissions_id = '$student->id' and  date(date) between '$from_date' and '$to_date'");

            }

            $expected_fee_duration = $student_attendence[0]->atttendance_count;
            $per_day_fee = $student->agreed_fee_per_hr * $student->agreed_hrs;
            $expected_fee = $per_day_fee * $student_attendence[0]->atttendance_count;
            if ($student_attendence[0]->atttendance_count > 0) {
                $students[$key]->expected_fee = $expected_fee;
                if (isset($fee_conflicted_last_pay_date[0]->to_date)) {
                    $students[$key]->last_fee_paid = $fee_conflicted_last_pay_date[0]->to_date;

                }
                $students[$key]->expected_fee_duration = $expected_fee_duration;
            } else {
                $students[$key]->expected_fee = 'No Fee Remaining';
                $students[$key]->expected_fee_duration = 'No Attendance Found';
            }

            $total = 0;
            foreach ($students as $key => $student_fee) {
                if (isset($student_fee->expected_fee) && is_numeric($student_fee->expected_fee)) {
                    $total += $student_fee->expected_fee;

                }
            }
            $data['total'] = $total;

        }
        $data['student_fees'] = $students;

        return view('admin/student_fee/expected_student_fee_by_attendance', compact('data'));


    }


    public function getSelectedStudent(Request $request)
    {
//        dd($request);

        $fee_to_date = strtotime($request->fee_to_date); // or your date as well
        $fee_from_date = strtotime($request->fee_from_date);
        $datediff = $fee_to_date - $fee_from_date;

        $num_of_days = round($datediff / (60 * 60 * 24));
        $num_of_days += 1; //add one day to manage current day as its giving 27-1 out of 30 as 4 instead of five days
//        print_r($num_of_days);die;


        $student = StudentAdmission::where('id', $request->student_id)->where('is_active', 1)->first();
        $student_last_fee = StudentFee::where('student_admissions_id', $request->student_id)->where('id', $request->student_id)->where('is_active', 1)->first();

        $from_date = date('Y-m-d', strtotime($request->fee_from_date));
        $to_date = date('Y-m-d', strtotime($request->fee_to_date));

//       $fee_conflicted_last_pay_date = DB::select("select to_date from student_fees  where student_admissions_id = '$request->student_id' and  date(to_date) between '$from_date' and '$to_date' order by id desc limit 1 ");
        $fee_conflicted_last_pay_date = DB::select("select to_date from student_fees  where student_admissions_id = '$request->student_id'   order by id desc limit 1 ");

//       dd( ($fee_conflicted_last_pay_date));
        if (!isset($fee_conflicted_last_pay_date[0]) || $fee_conflicted_last_pay_date[0]->to_date < $from_date
            && $to_date > $fee_conflicted_last_pay_date[0]->to_date) {
            if (isset($student) && !empty($student) > 0) {


                return response()->json(['data' => $student,], 200);

            } else {
                $data['msg'] = "No Student Found!";
                return response()->json(['data' => $data,], 500);

            }
        } else {
            $data['msg'] = "Fee Already Paid Till " . date('d-M-Y', strtotime($fee_conflicted_last_pay_date[0]->to_date));
            return response()->json(['data' => $data,], 500);
        }


//        if (count($fee_conflicted_last_pay_date) == 0){
//            if (isset($student) && !empty($student)>0){
//
//
//                return response()->json(['data' => $student, ],200);
//
//            }else{
//                $data['msg']="No Student Found!";
//                return response()->json(['data' => $data, ],500);
//
//            }
//        }else{
//            $data['msg']="Fee Already Paid Till ". date('d-M-Y',strtotime($fee_conflicted_last_pay_date[0]->to_date));
//            return response()->json(['data' => $data, ],500);
//        }


    }


    public function fee_add(Request $request)
    {
        $admissions = User::where('status', 'confirmed')->where('user_role', 'parent')->where('is_active', 1)->get();
        $data['admissions'] = $admissions;
        $data['breadcrumbs'] = array(['name' => 'Home', 'active' => true, 'url' => '']);
        return view('admin/student_fee/add', compact('data'));

    }


    public function fee_submit(Request $request)
    {

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

        $validatedData = $request->validate([
            'fee_from_date' => ['required'],
            'fee_to_date' => ['required'],
            'date' => ['required'],
            'admission_no' => ['required'],
            'student_admissions_id' => ['required'],
            'payment_type' => ['required', 'alpha_dash'],
            'amount' => ['required'],
            'fee_duration' => ['required'],

        ]);

        $student_admission = StudentAdmission::where('id', $request->student_admissions_id)->where('is_active', 1)->first();

        $agreed_fee_per_hour = $student_admission->agreed_fee_per_hr;
        $agreed_hour = $student_admission->agreed_hrs;
        $fee_per_day = $agreed_fee_per_hour * $agreed_hour;
//        $expected_salary = $fee_per_day = $num_of_days;

        if (strtotime($request->fee_to_date) >= strtotime($request->fee_from_date)) {


            $fee_add = new StudentFee();
            $fee_add->from_date = date('Y-m-d', strtotime($request->fee_from_date));
            $fee_add->to_date = date('Y-m-d', strtotime($request->fee_to_date));
            $fee_add->admission_no = $request->admission_no;
            $fee_add->entry_date = date('Y-m-d', strtotime($request->date));
            $fee_add->student_admissions_id = $request->student_admissions_id;
            $fee_add->payment_type = $request->payment_type;
            if (!empty($request->description)) {
                $fee_add->description = $request->description;

            } else {
                $fee_add->description = '';

            }
            $fee_add->amount_taken = $request->amount;
            $fee_add->expected_amount = $request->expected_fee_value;
            $fee_add->paid_duration = $request->fee_duration;
            $fee_add->agreed_fee_per_hr = $student_admission->agreed_fee_per_hr;
            $fee_add->agreed_hrs = $student_admission->agreed_hrs;
            $fee_add->created_by = Auth::User()->id;


            $fee_to_date = strtotime($request->fee_to_date); // or your date as well
            $fee_from_date = strtotime($request->fee_from_date);
            $datediff = $fee_to_date - $fee_from_date;

            $num_of_days = round($datediff / (60 * 60 * 24));
            $num_of_days += 1; //add one day to manage current day as its giving 27-1 out of 30 as 4 instead of five days
//print_r($num_of_days);die;
            $fee_add->paid_duration = $num_of_days;

            $added = $fee_add->save();
            $data['success_msg'] = 'Fee  Added Successfully!';
            if ($added) {
                $data['breadcrumbs'] = array(['name' => 'Home', 'active' => true, 'url' => '']);
                return redirect()->back()->with('success', 'Fee  Added Successfully!');


            } else {
                $data['danger_msg'] = 'Expense Not Added';
                $data['breadcrumbs'] = array(['name' => 'Home', 'active' => true, 'url' => '']);

                return view('admin/student_fee/add', compact('data'));

            }
        } else {
            return redirect()->back()->with('error', 'Fee to date should be greater then fee from date');

        }

    }

    public function change_fee_status(Request $request)
    {


        $fee_status_update = StudentFee::find($request->student_fee_id);
        $fee_status_update->status = $request->status;
        $updated = $fee_status_update->save();
        if ($updated) {


            $data['msg'] = "Fee Paid Successfully!";
            return response()->json(['data' => $data,], 200);

        } else {
            $data['msg'] = "Status Not Changed Successfully!";
            return response()->json(['data' => $data,], 500);

        }

    }


    public function edit_fee(Request $request)
    {

        $student_fee_edit = StudentFee::find($request->id);

//        dd($expense);
        $data['student_fee_edit'] = $student_fee_edit;
        $data['breadcrumbs'] = array(['name' => 'Home', 'active' => true, 'url' => '']);
        return view('admin/student_fee/edit', compact('data'));

    }

    public function update_fee(Request $request)
    {
//        dd($request);die;

        if (strtotime($request->fee_to_date) >= strtotime($request->fee_from_date)) {

            $fee_update = StudentFee::find($request->id);
            $fee_update->from_date = date('Y-m-d', strtotime($request->fee_from_date));
            $fee_update->to_date = date('Y-m-d', strtotime($request->fee_to_date));
            $fee_update->entry_date = date('Y-m-d', strtotime($request->date));
            $fee_update->payment_type = $request->payment_type;
            $fee_update->description = $request->description;
            $fee_update->amount_taken = $request->amount;
            $fee_update->paid_duration = $request->fee_duration;

            $added = $fee_update->save();
            $data['success_msg'] = 'Fee Edit Successfully!';
            if ($added) {
                $data['breadcrumbs'] = array(['name' => 'Home', 'active' => true, 'url' => '']);

                return redirect('admin/student-fee-due/')->with('success', 'Fee Edit Successfully!');

            } else {
                $data['danger_msg'] = 'Subject Not Edit Successful!';
                $data['breadcrumbs'] = array(['name' => 'Home', 'active' => true, 'url' => '']);
                return redirect('admin/student-fee-due/')->with('status', 'Expense Not Edit Successfully!');

//            return view('admin/student_admission/edit/', compact('data'));

            }
        } else {
            return redirect()->back()->with('error', 'Fee to date should be greater then fee from date');

        }

    }


}
