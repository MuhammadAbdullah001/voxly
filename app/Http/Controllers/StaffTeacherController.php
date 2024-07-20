<?php

namespace App\Http\Controllers;

use App\AssignedSubject;
use App\Group;
use App\StaffAttendance;
use App\StaffTeacher;
use App\StudentAdmission;
use App\Subject;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Redirector;
use Illuminate\Support\Facades\Hash;
use Log;
use Yajra\DataTables\DataTables;

class StaffTeacherController extends Controller
{
    //
    public function staff(Request $request)
    {
        StaffTeacher::where('user_id', 0)->delete();

            if ($request->ajax()) {
                $staff_register = StaffTeacher::where('is_active', 1);
                 
                return DataTables::of($staff_register)
                ->addColumn('actions',function($row){
                    return '<div class="list-icons">
                    <div class="dropdown">
                        <a href="#" class="list-icons-item" data-toggle="dropdown">
                            <i class="icon-menu9"></i>
                        </a>
    
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="'. url('admin/staff/edit/'.$row->id) .'" class="dropdown-item"><i class="icon-pencil3"></i> Edit</a>
                            <a href="'. url('admin/staff/assign-subjects/'.$row->id) .'" class="dropdown-item"><i class="icon-book2"></i>Assign Subjects</a>
                            </div>
                    </div>
                </div>';
                })
                ->addColumn('assigned_group',function($row){
                    return $row->assignedSubjects['assigned_group'];
                })
                ->addColumn('subjects_name',function($row){
                    return $row->assignedSubjects['subjects_name'];
                })
                ->addColumn('status_select',function($row){
                    return '
                    <select style="opacity: initial; height: auto;" name="status" class="teacher-status form-control form-control-select2" data-placeholder="Select Status"  data-id= "'.$row->id.'"  >
                    <option '.($row->is_resigned == "0"? "selected":"").' value="0">Active</option>
                   <option '.($row->is_resigned == "1"? "selected":"").'  value="1">Resigned</option>

               </select>
    ';
                })
                ->addColumn('assigned_role',function ($row){
                    $html=''; 	
                    if ($row->is_resigned == 0){ 
                       $html.= '<select style="opacity: initial; height: auto;" name="status" class="form-control form-control-select2" data-user_id= "'. $row->user_id.'" id="teacher-roll-assigned">';
                           }
                           else{ 
                            
                            $html.='    <select style="opacity: initial; height: auto;" disabled name="status" class="form-control form-control-select2" data-user_id= "'. $row->user_id.'" id="teacher-roll-assigned">';

                                	} 

$html.='                            <option '. ($row->user->user_role == "teacher" ? "selected":'').' value="teacher">Teacher</option>
                            <option class="bg badge-primary" '.($row->user->user_role== "super_admin" ? "selected" : "" ) . '  value="super_admin">Super Admin</option>
                        </select>';
                })
                ->setRowAttr([
                    'class' => function ($row) {
                        return (isset($row->is_resigned) && $row->is_resigned == 1) ? 'bg bg-warning' : '';
                    }
                ])
                ->rawColumns(['actions','status_select'])
                ->make(true);
             }
        $data['breadcrumbs'] = array(['name' => 'Home', 'active' => true, 'url' => '']);
        return view('admin/staff/main', compact('data'));

    }

    public function staff_add(Request $request)
    {
        $subjects = Subject::where('is_active', 1)->get();

        $data['subjects'] = $subjects;
        $data['breadcrumbs'] = array(['name' => 'Home', 'active' => true, 'url' => '']);
        return view('admin/staff/add', compact('data'));

    }

    public function staff_submit(Request $request)
    {
        // dd($request);die;
        $validatedData = $request->validate([
            'name' => ['required'],
            'email' => ['required', 'unique:staff_teachers', 'E-Mail'],

            'subject_id' => ['required'],
            'contact_number' => ['contact_number' => 'digits_between:13,20', 'contact_number' => 'numeric'],

            'per_hour_rate' => ['required'],
            'daily_working_hours' => ['required'],
            'address' => ['required'],
            'joining_date' => ['required'],

        ]);
        $is_duplicate_email = 0;

        if (!empty($request->email)) {
            $users = User::select('email')->get();
            $teachers = StaffTeacher::select('email')->get();
            foreach ($users as $user) {
                if ($user->email == $request->email) {
                    $is_duplicate_email = 1;
                }
            }
            foreach ($teachers as $teacher) {
                if ($teacher->email == $request->email) {
                    $is_duplicate_email = 1;
                }
            }
        }


        if ($is_duplicate_email == 0) {
            $staff_registration = new StaffTeacher();
            $staff_registration->name = $request->name;
            $staff_registration->user_id = 0;

            $staff_registration->contact_number = $request->contact_number;
            $staff_registration->per_hour_rate = $request->per_hour_rate;
            $staff_registration->daily_working_hours = $request->daily_working_hours;
            $staff_registration->pay = ($request->daily_working_hours * $request->per_hour_rate);

            if (!empty($request->comments)) {
                $staff_registration->comments = $request->comments;

            } else {
                $staff_registration->comments = '';

            }
            if (!empty($request->type)) {
                $staff_registration->type = $request->type;

            } else {
                $staff_registration->type = '';

            }
            if (!empty($request->email)) {
                $staff_registration->email = $request->email;

            } else {
                $staff_registration->email = '';

            }

//        $staff_registration->resigning_date = '0000-00-00';
            $staff_registration->is_resigned = 0;
            $staff_registration->address = $request->address;
            $date = str_replace(',', ' ', $request->joining_date);
            $staff_registration->joining_date = date('Y-m-d', strtotime($date));
            $data['success_msg'] = 'Staff Registred Successful!';

            $staff_registration->save();


            if (!empty($request->subject_id) && count($request->subject_id) > 0) {


                $subject_id_array = array();
                $subject_name_array = array();
                $group_name_array = array();

                //  dd($request->subject_id);
                foreach ($request->subject_id as $subject_id) {
                    $student_data = explode('/', $subject_id);

                    $subject_id_array[] = $student_data[0];
                    $subject_name_array[] = $student_data[1];
                    $group_name_array[] = $student_data[2];
                    $group_id_array[] = $student_data[3];
                }
                // print"<pre>";
                // print_r($group_name_array);
                // print_r($group_id_array);
                // print_r(array_unique($group_name_array));
                // print_r(array_unique($group_id_array));
                
                // print_r(array_values(array_unique($group_name_array)));
                // print_r(array_values(array_unique($group_id_array)));
                // dd($request->subject_id);
                $json_arr_id = json_encode($subject_id_array);
                $json_arr_name = json_encode($subject_name_array);
                $json_arr_group = json_encode(array_values(array_unique($group_name_array)));
                $json_arr_group_id = json_encode(array_values(array_unique($group_id_array)));





            }

            // Log::error($json_arr_id);
            // Log::error($json_arr_name);
            // Log::error($json_arr_group_id);
            // Log::error($json_arr_group);
            $staff_assigned_sub = AssignedSubject::where('staff_teachers_id', $staff_registration->id)->get();
            // Log::error('zahid please'.$staff_assigned_sub);
            // Log::error('zahid id '.$request->id);
            if (isset($staff_assigned_sub) && count($staff_assigned_sub) > 0 && !empty($request->id)) {
                $staff_assigned_subjects = AssignedSubject::where('staff_teachers_id', $request->id)->first();
                $staff_assigned_subjects->subjects_id = $json_arr_id;
                $staff_assigned_subjects->subjects_name = $json_arr_name;
                $staff_assigned_subjects->assigned_group = $json_arr_group;
                $staff_assigned_subjects->assigned_group_id = $json_arr_group_id;

//            $staff_assigned_subjects->subjects_id = json_encode($request->subject_id);

            } else {
                $staff_assigned_subjects = new AssignedSubject();
                $staff_assigned_subjects->subjects_id = $json_arr_id;
                $staff_assigned_subjects->subjects_name = $json_arr_name;
                $staff_assigned_subjects->assigned_group = $json_arr_group;
                $staff_assigned_subjects->assigned_group_id = $json_arr_group_id;

//            $staff_assigned_subjects->subjects_id = json_encode($request->subject_id);
                $staff_assigned_subjects->staff_teachers_id = $staff_registration->id;
                $staff_assigned_subjects->is_active = 1;
            }


            $staff_user_account_add = new User();
            $staff_user_account_add->admission_no = '';
            $staff_user_account_add->admin_or_teacher_id = $staff_registration->id;
            $staff_user_account_add->parent_name = $staff_registration->name;
            $staff_user_account_add->email = $request->email;
            if (!empty($request->password)) {
                $staff_user_account_add->password = Hash::make($request->password);

            } else {
                $staff_user_account_add->password = Hash::make('abc123');

            }
            $staff_user_account_add->contact_number = $request->contact_number;
            $staff_user_account_add->remarks = 'User account of Teacher';
            $staff_user_account_add->address = $request->address;
            $staff_user_account_add->user_role = 'teacher';
            $staff_user_account_add->projected_revenue = '';
            $staff_user_account_add->fcm_token = '';
            $staff_user_account_add->class_mode = '';

            $staff_user_account_add->child_care = '';
            $staff_user_account_add->avatar_url = '';
            $staff_user_account_add->status = 'confirmed';
            $staff_user_account_add->date = date('Y-m-d', strtotime($date));

            $staff_user_account_add->save();

            $staff_registration->user_id = $staff_user_account_add->id;
            $staff_registration->save();
            $staff_assigned_subjects->save();

            $data['breadcrumbs'] = array(['name' => 'Home', 'active' => true, 'url' => '']);

//            return view('admin/staff/add', compact('data'));
//            return redirect('admin/staff/')->with('success', 'Account Registered Successfully!');
            return redirect()->back()->with('success', 'Account Registered Successfully!');

//            return response()->json(['Success' => 'Successfully Added']);
        } else {

            $data['danger_msg'] = 'Staff Not Registered Successful!';
            $data['breadcrumbs'] = array(['name' => 'Home', 'active' => true, 'url' => '']);
            return redirect()->back()->with('error', ' Email Has Alreay Been Taken/Account Not Registered Successfully!')->withInput();

//            return view('admin/staff/add', compact('data'));

        }

    }

    public function change_status(Request $request)
    {


        $student_register_update = StaffTeacher::find($request->staff_id);
        $student_register_update->is_resigned = $request->status;
        $student_register_update->resigning_date = date('Y-m-d');
        $updated = $student_register_update->save();
        if ($updated) {

            $data['msg'] = "Status Changed Successfully!";
            return response()->json(['data' => $data,], 200);

        } else {
            $data['msg'] = "Status Not Changed Successfully!";
            return response()->json(['data' => $data,], 500);

        }

    }


    public function roll_assign(Request $request)
    {


        $staff_user_role_assign = User::find($request->user_id);
        $staff_user_role_assign->user_role = $request->roll_assigned;
        $updated = $staff_user_role_assign->save();
        if ($updated) {

            $data['msg'] = "Status Changed Successfully!";
            return response()->json(['data' => $data,], 200);

        } else {
            $data['msg'] = "Status Not Changed Successfully!";
            return response()->json(['data' => $data,], 500);

        }

    }


    public function edit_staff($id, Request $request)
    {

        $staff_edit = StaffTeacher::find($id);


        $data['staff_edit'] = $staff_edit;
        $data['breadcrumbs'] = array(['name' => 'Home', 'active' => true, 'url' => '']);
        return view('admin/staff/edit', compact('data'));

    }

    public function update_staff(Request $request)
    {
//        dd($request);die;
        $staff_registration_update = StaffTeacher::find($request->id);


        $staff_registration_update->name = $request->name;
        $staff_registration_update->email = $request->email;
        $staff_registration_update->contact_number = $request->contact_number;
        $staff_registration_update->per_hour_rate = $request->per_hour_rate;
        $staff_registration_update->daily_working_hours = $request->daily_working_hours;
        $staff_registration_update->pay = $request->daily_working_hours * $request->per_hour_rate;


//        $staff_registration->resigning_date = '0000-00-00';
        if (isset($request->comments) && !empty($request->comments)) {
            $staff_registration_update->comments = $request->comments;
        } else {
            $staff_registration_update->comments = ' ';
        }
        if (isset($request->type) && !empty($request->type)) {
            $staff_registration_update->type = $request->type;
        } else {
            $staff_registration_update->type = ' ';
        }
        $staff_registration_update->address = $request->address;

        $staff_registration_update->joining_date = date('Y-m-d', strtotime($request->joining_date));
        $added = $staff_registration_update->save();
        $data['success_msg'] = 'Staff Edit Successfully!';
        if ($added) {
            $is_duplicate_email = 0;

            if (!empty($request->email)) {
//                $users = User::select('email')->get();
                $users = User::where('id', '!=', $staff_registration_update->user_id)->get();

//                $teachers = StaffTeacher::select('email')->get();
                $teachers = StaffTeacher::where('id', '!=', $staff_registration_update->id)->get();
                foreach ($users as $user) {
                    if ($user->email == $request->email) {
                        $is_duplicate_email = 1;
                    }
                }
                foreach ($teachers as $teacher) {
                    if ($teacher->email == $request->email) {
                        $is_duplicate_email = 1;
                    }
                }
            }


            if ($is_duplicate_email == 0) {


                if (isset($staff_registration_update->user_id) && !empty($staff_registration_update->user_id)) {
                    $staff_teacher__user = User::where('id', $staff_registration_update->user_id)->first();
                    $staff_teacher__user->email = $request->email;
                    $staff_teacher__user->parent_name = $request->name;
                    $staff_teacher__user->save();
                }
            } else {
                return redirect()->back()->with('error', ' Email Has Alreay Been Taken/Account Not Registered Successfully!');


            }
            $data['breadcrumbs'] = array(['name' => 'Home', 'active' => true, 'url' => '']);

            return redirect('admin/staff/')->with('status', 'Staff Edit Successfully!');

        } else {
            $data['danger_msg'] = 'Staff Not Edit Successful!';
            $data['breadcrumbs'] = array(['name' => 'Home', 'active' => true, 'url' => '']);
            return redirect('admin/staff/')->with('status', 'Staff Not Edit Successfully!');

//            return view('admin/student_admission/edit/', compact('data'));

        }

    }


//    Staff/Teacher Attendance Module Start

    public function attendance(Request $request)
    {
        if ($request->ajax()) {
            $attendances = StaffAttendance::with('teacher')->where('staff_attendances.is_active', 1);

            return DataTables::of($attendances)
            ->addColumn('actions',function($row){
                return '<div class="list-icons">
                <div class="dropdown">
                    <a href="#" class="list-icons-item" data-toggle="dropdown">
                        <i class="icon-menu9"></i>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="'. url('admin/teacher-attendance/edit/'.$row->id) .'" class="dropdown-item"><i class="icon-pencil3"></i> Edit</a>
                    </div>
                </div>
            </div>';
            })
            ->setRowAttr([
                'class' => function ($row) {
                    return (isset($row->updated_by) && !empty($row->updated_by)) ? 'bg-warning' : '';
                }
            ])
            ->rawColumns(['actions'])
            ->make(true);
         }
        $data['breadcrumbs'] = array(['name' => 'Home', 'active' => true, 'url' => '']);
        return view('admin/teacher_attendance/main', compact('data'));

    }

    public function attendance_add(Request $request)
    {

        $teachers = StaffTeacher::where('is_resigned', 0)->where('is_active', 1)->get();

        foreach ($teachers as $key => $teacher) {
//            dd( ($teacher->id));
            $date = date('Y-m-d');
//            $date = '2020-04-26';
            $teacher_attendance = StaffAttendance::where('date', $date)->where('staff_teacher_id', $teacher->id)->where('is_active', 1)->get();
//             dd(count($teacher_attendance));
            if (count($teacher_attendance) > 0) {

                unset($teachers[$key]);

            }
        }

        $data['teachers'] = $teachers;
        $data['breadcrumbs'] = array(['name' => 'Home', 'active' => true, 'url' => '']);
        return view('admin/teacher_attendance/add', compact('data'));

    }

    public function attendance_submit(Request $request)
    {
//        dd($request);die;
        $validatedData = $request->validate([
            'staff_teacher_id' => ['required', 'numeric'],
            'date' => ['required'],

        ]);

        $teacher_attendance_add = new StaffAttendance();
        $teacher_attendance_add->staff_teacher_id = $request->staff_teacher_id;
        $date = str_replace(',', ' ', $request->date);

        $teacher_attendance_add->date = date('Y-m-d', strtotime($date));


        if (!empty($request->start_time)) {
            $teacher_attendance_add->start_time = $request->start_time . ':00';

        } else {
            $teacher_attendance_add->start_time = '00:00:00';

        }
        if (!empty($request->end_time)) {
            $teacher_attendance_add->end_time = $request->end_time . ':00';

        } else {
            $teacher_attendance_add->end_time = '00:00:00';

        }
        if (!empty($request->description)) {
            $teacher_attendance_add->description = $request->description;

        } else {
            $teacher_attendance_add->description = '';

        }


        $teacher_attendance_add->updated_by = '';
        $teacher_attendance_add->is_active = 1;
        $added = $teacher_attendance_add->save();
        $data['success_msg'] = 'Attendance Added Successfully!';
        if ($added) {

            $data['breadcrumbs'] = array(['name' => 'Home', 'active' => true, 'url' => '']);
//            return redirect('admin/teacher-attendance')->with('success','Attendance Added Successfully!');
            return redirect()->back()->with('success', 'Attendance Added Successfully!');

//            return view('admin/attendance/add', compact('data'));
//            return response()->json(['Success' => 'Successfully Added']);
        } else {
            $data['danger_msg'] = 'Attendance Not Added Successfully!';
            $data['breadcrumbs'] = array(['name' => 'Home', 'active' => true, 'url' => '']);

            return view('admin/teacher_attendance/add', compact('data'));

        }

    }

    public function get_students(Request $request)
    {
        $teachers = StaffTeacher::where('is_resigned', 0)->where('is_active', 1)->get();
        $date = str_replace(',', ' ', $request->date);
         $date =   date('Y-m-d', strtotime($date));
         foreach ($teachers as $key => $teacher) {

//            $student_attendance = StudentAttendance::where('date',date('Y-m-d',strtotime($request->date)))->where('student_admissions_id',$student->id)->where('is_active',1)->get();
            $teacher_attendance = StaffAttendance::where('date', $date)->where('staff_teacher_id', $teacher->id)->where('is_active', 1)->get();
//             dd(count($teacher_attendance));
            if (count($teacher_attendance) > 0) {

                unset($teachers[$key]);

            }
        }


        if (isset($teachers) && count($teachers) > 0) {


            return response()->json(['data' => $teachers,], 200);

        } else {
            $data['msg'] = "No Student Found!";
            return response()->json(['data' => $data,], 500);

        }

    }

    public function edit_attendance($id, Request $request)
    {

        $attendance = StaffAttendance::find($id);

        $data['attendance'] = $attendance;
        $data['breadcrumbs'] = array(['name' => 'Home', 'active' => true, 'url' => '']);
        return view('admin/teacher_attendance/edit', compact('data'));

    }

    public function update_attendance(Request $request)
    {
//        dd($request);die;
        $attendance_update = StaffAttendance::find($request->id);

        if (!empty($request->start_time)) {
            $attendance_update->start_time = $request->start_time . ':00';

        } else {
            $attendance_update->start_time = '00:00:00';

        }
        if (!empty($request->end_time)) {
            $attendance_update->end_time = $request->end_time . ':00';

        } else {
            $attendance_update->end_time = '00:00:00';

        }


        $attendance_update->description = $request->description;
        $attendance_update->updated_by = auth()->user()->name;

        $added = $attendance_update->save();
        $data['success_msg'] = 'Attendance Edit Successfully!';
        if ($added) {
            $data['breadcrumbs'] = array(['name' => 'Home', 'active' => true, 'url' => '']);

            return redirect('admin/teacher-attendance/')->with('success', 'Attendance Edit Successfully!');

        } else {
            $data['danger_msg'] = 'Attendance Not Edit Successful!';
            $data['breadcrumbs'] = array(['name' => 'Home', 'active' => true, 'url' => '']);
            return redirect('admin/student-attendance/')->with('success', 'Attendance Not Edit Successfully!');

//            return view('admin/student_admission/edit/', compact('data'));

        }

    }


//    Staff/Teacher Attendance Module End

//    Assign subjects to teacher start

    public function assign_subjects(Request $request)
    {


        $staff = StaffTeacher::find($request->id);
        $subjects = Subject::where('is_active', 1)->get();

        $staff_assigned_sub = AssignedSubject::where('staff_teachers_id', $request->id)->first();

        if (isset($subjects) && isset($staff_assigned_sub) && !empty($staff_assigned_sub) && count($subjects) > 0) {
            foreach ($subjects as $key => $group_subject) {
                $staff_assigned_subjects = json_decode($staff_assigned_sub->subjects_id);
                if (isset($staff_assigned_subjects) && !empty($staff_assigned_subjects)){


                foreach ($staff_assigned_subjects as $staff_sub) {
                    if ($group_subject->id == $staff_sub) {

                        $subjects[$key]->selected = "selected";

                    }

                }
                }
            }
        }


        $data['staff'] = $staff;
        $data['subjects'] = $subjects;

        $data['breadcrumbs'] = array(['name' => 'Home', 'active' => true, 'url' => '']);
        return view('admin/staff/assign_subjects', compact('data'));

    }

    public function submit_subjects(Request $request)
    {
        $subject_id_array = array();
        $subject_name_array = array();
        $group_name_array = array();
        $group_id_array = array();
        if (!empty($request->subject_id) && count($request->subject_id) > 0) {




            foreach ($request->subject_id as $subject_id) {
                $student_data = explode('/', $subject_id);

                $subject_id_array[] = $student_data[0];
                $subject_name_array[] = $student_data[1];
                $group_name_array[] = $student_data[2];
                $group_id_array[] = $student_data[3];
            }

            $group_name_array = array_unique($group_name_array);
            $group_id_array = array_unique($group_id_array);
            $group_name_array = array_values($group_name_array);
            $group_id_array = array_values($group_id_array);


            $json_arr_id = json_encode($subject_id_array);
            $json_arr_name = json_encode($subject_name_array);
            $json_arr_group = json_encode($group_name_array);
            $json_arr_group_id = json_encode($group_id_array);

        }
        $is_empty = 0;

        if (count($subject_id_array) <= 0 || count($subject_name_array) <= 0 || count($group_name_array) <= 0 || count($group_id_array) <= 0 ) {
            $is_empty = 1;

        }
        $staff_assigned_sub = AssignedSubject::where('staff_teachers_id', $request->id)->get();
        if ($is_empty == 0) {
            if (isset($staff_assigned_sub) && count($staff_assigned_sub) > 0) {
                $staff_assigned_subjects = AssignedSubject::where('staff_teachers_id', $request->id)->first();
                if (isset($json_arr_id) && !empty($json_arr_id)) {
                    $staff_assigned_subjects->subjects_id = $json_arr_id;

                } else {
                    $staff_assigned_subjects->subjects_id = '';

                }
                if (isset($json_arr_name) && !empty($json_arr_name)) {
                    $staff_assigned_subjects->subjects_name = $json_arr_name;

                } else {
                    $staff_assigned_subjects->subjects_name = '';

                }
                if (isset($json_arr_group) && !empty($assigned_group)) {
                    $staff_assigned_subjects->assigned_group = $json_arr_group;

                } else {
                    $staff_assigned_subjects->assigned_group = '';

                }
                if (isset($json_arr_id) && !empty($json_arr_name)) {
                    $staff_assigned_subjects->assigned_group_id = $json_arr_group_id;

                } else {
                    $staff_assigned_subjects->assigned_group_id = '';

                }
                //            $staff_assigned_subjects->subjects_id = json_encode($request->subject_id);
                $added = $staff_assigned_subjects->save();

            } else {
                $staff_assigned_subjects = new AssignedSubject();
                $staff_assigned_subjects->subjects_id = $json_arr_id;
                $staff_assigned_subjects->subjects_name = $json_arr_name;
                $staff_assigned_subjects->assigned_group = $json_arr_group;
                $staff_assigned_subjects->assigned_group_id = $json_arr_group_id;

//            $staff_assigned_subjects->subjects_id = json_encode($request->subject_id);
                $staff_assigned_subjects->staff_teachers_id = $request->id;
                $staff_assigned_subjects->is_active = 1;
                $added = $staff_assigned_subjects->save();
            }


            $data['success_msg'] = 'Subject Assigned To Teacher Successful!';
            if ($added) {

                $data['breadcrumbs'] = array(['name' => 'Home', 'active' => true, 'url' => '']);
                return redirect('admin/staff')->with('success', 'Subject Assigned Successfully!');

            } else {
                $data['danger_msg'] = 'Staff Not Registered Successful!';
                $data['breadcrumbs'] = array(['name' => 'Home', 'active' => true, 'url' => '']);

                return redirect()->back('error', 'Subject Not Assigned Successfully!');

            }
        } else {
            $data['danger_msg'] = 'Staff Not Registered Successful!';
            $data['breadcrumbs'] = array(['name' => 'Home', 'active' => true, 'url' => '']);

            return redirect()->back()->with('error', 'Subjects Can Not Be Empty');
        }

    }
}
