<?php

namespace App\Http\Controllers;

use App\Group;
use App\Subject;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Redirector;
use Yajra\DataTables\DataTables;

class GroupController extends Controller
{
    //
    public function group(Request $request)
    {
        if ($request->ajax()) {
            $groups = Group::where('is_active',1);

            return DataTables::of($groups)
            ->addColumn('actions',function($row){
                return '<div class="list-icons">
                <div class="dropdown">
                    <a href="#" class="list-icons-item" data-toggle="dropdown">
                        <i class="icon-menu9"></i>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="'. url('admin/group/edit/'.$row->id) .'" class="dropdown-item"><i class="icon-pencil3"></i> Edit</a>
                    </div>
                </div>
            </div>';
            })
            ->rawColumns(['actions'])
            ->make(true);
         }

        $data['breadcrumbs'] = array(['name'=>'Home','active'=>true,'url'=>'']);
        return view('admin/group/main', compact('data'));

    }
    public function group_add(Request $request)
    {

        $data['breadcrumbs'] = array(['name'=>'Home','active'=>true,'url'=>'']);
        return view('admin/group/add', compact('data'));

    }

    public function group_submit(Request $request)
    {

        $group_add = new Group();
        $group_add->name = $request->group_name;
        $added = $group_add->save();
        $data['success_msg'] = 'Group Added Successfully!';
        if ($added) {
            $data['breadcrumbs'] = array(['name'=>'Home','active'=>true,'url'=>'']);

            return view('admin/group/add', compact('data'));


            return response()->json(['Success' => 'Successfully Added']);
        }else{
            $data['danger_msg'] = 'Group Not Added';
            $data['breadcrumbs'] = array(['name'=>'Home','active'=>true,'url'=>'']);

            return view('admin/group/add', compact('data'));

        }

    }


    public function edit_group($id,Request $request)
    {
        $group= Group::find($id);

        $data['group'] = $group;
        $data['breadcrumbs'] = array(['name'=>'Home','active'=>true,'url'=>'']);
        return view('admin/group/edit', compact('data'));

    }

    public function update_group(Request $request)
    {
//        dd($request);die;
        $group_update = Group::find($request->id);
        $group_update->name = $request->name;

        $added = $group_update->save();
        $data['success_msg'] = 'Group Edit Successfully!';
        if ($added) {
            $data['breadcrumbs'] = array(['name'=>'Home','active'=>true,'url'=>'']);

            return redirect('admin/group/')->with('status', 'Group Edit Successfully!');

         }else{
            $data['danger_msg'] = 'Subject Not Edit Successful!';
            $data['breadcrumbs'] = array(['name'=>'Home','active'=>true,'url'=>'']);
            return redirect('admin/group/')->with('status', 'Group Not Edit Successfully!');

//            return view('admin/student_admission/edit/', compact('data'));

        }

    }


}
