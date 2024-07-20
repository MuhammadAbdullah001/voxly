<?php

namespace App\Http\Controllers;

use App\Group;
use App\Subject;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Redirector;
use Yajra\DataTables\DataTables;

class SubjectController extends Controller
{
    //
    public function subject(Request $request)
    {
        
        if ($request->ajax()) {
            $subjects = Subject::with('group')->where('is_active',1);

            return DataTables::of($subjects)
            ->addColumn('actions',function($row){
                return '<div class="list-icons">
                <div class="dropdown">
                    <a href="#" class="list-icons-item" data-toggle="dropdown">
                        <i class="icon-menu9"></i>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="'. url('admin/subject/edit/'.$row->id) .'" class="dropdown-item"><i class="icon-pencil3"></i> Edit</a>
                    </div>
                </div>
            </div>';
            })
            ->rawColumns(['actions'])
            ->make(true);
         }
        $data['breadcrumbs'] = array(['name'=>'Home','active'=>true,'url'=>'']);
        return view('admin/subject/main', compact('data'));

    }
    public function subject_add(Request $request)
    {
        $groups = Group::where('is_active',1)->get();
        $data['groups'] = $groups;

        $data['breadcrumbs'] = array(['name'=>'Home','active'=>true,'url'=>'']);
        return view('admin/subject/add', compact('data'));

    }

    public function subject_submit(Request $request)
    {
//        dd($request);die;
        $validatedData = $request->validate([
            'group_id' => ['required' ],
            'subject_name' => ['required' ],


        ]);
        $subjects = Subject::where('group_id',$request->group_id)->get();
        $is_duplicate = 0;
        foreach ($subjects as $subject){
            if (strtolower($subject->name) == strtolower($request->subject_name)){
                $is_duplicate = 1;
            }
        }

            if ($is_duplicate == 0){
                $subject_add = new Subject();
                $subject_add->group_id = $request->group_id;
                $subject_add->name = $request->subject_name;
                $added = $subject_add->save();
                $data['success_msg'] = 'Subject Added Successfully!';
                if ($added) {
                    $data['breadcrumbs'] = array(['name'=>'Home','active'=>true,'url'=>'']);
//            return redirect('admin/subject')->with('success', 'Subject Added Successfully!');
                    return redirect()->back()->with('success', 'Subject Added Successfully!');



                }else{
                    $data['danger_msg'] = 'Subject Not Added';
                    $data['breadcrumbs'] = array(['name'=>'Home','active'=>true,'url'=>'']);

                    return view('admin/subject/add', compact('data'));

                }
            }else{
                $data['danger_msg'] = 'Duplicate Subject Name';
                $data['breadcrumbs'] = array(['name'=>'Home','active'=>true,'url'=>'']);

                return redirect()->back()->with('error', 'Duplicate Subject Name');

//                return view('admin/subject/add', compact('data'));
            }




    }


    public function edit_subject($id,Request $request)
    {
        $groups = Group::where('is_active',1)->get();

        $subject = Subject::find($id);

        $data['groups'] = $groups;
        $data['subject'] = $subject;
        $data['breadcrumbs'] = array(['name'=>'Home','active'=>true,'url'=>'']);
        return view('admin/subject/edit', compact('data'));

    }

    public function update_subject(Request $request)
    {
//        dd($request);die;

        $subjects = Subject::where('group_id',$request->group_id)->get();
        $is_duplicate = 0;
        foreach ($subjects as $subject){
            if (strtolower($subject->name) == strtolower($request->name)){
                $is_duplicate = 1;
            }
        }

        if ($is_duplicate == 0){

            $subject_update = Subject::find($request->id);
        $subject_update->name = $request->name;
        $subject_update->group_id = $request->group_id;

        $added = $subject_update->save();
        $data['success_msg'] = 'Subject Edit Successfully!';
        if ($added) {
            $data['breadcrumbs'] = array(['name'=>'Home','active'=>true,'url'=>'']);

            return redirect('admin/subject/')->with('status', 'Subject Edit Successfully!');

         }else{
            $data['danger_msg'] = 'Subject Not Edit Successful!';
            $data['breadcrumbs'] = array(['name'=>'Home','active'=>true,'url'=>'']);
            return redirect('admin/subject/')->with('status', 'Subject Not Edit Successfully!');

//            return view('admin/student_admission/edit/', compact('data'));

        }
        }else{
            $data['danger_msg'] = 'Duplicate Subject Name';
            $data['breadcrumbs'] = array(['name'=>'Home','active'=>true,'url'=>'']);

            return redirect()->back()->with('error', ' Duplicate Subject Name, subject Not Edit Successfully!');

//                return view('admin/subject/add', compact('data'));
        }

    }


}
