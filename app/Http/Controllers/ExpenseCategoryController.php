<?php

namespace App\Http\Controllers;

use App\ExpenseCategory;
use App\Group;
use App\Subject;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Redirector;
use Yajra\DataTables\DataTables;

class ExpenseCategoryController extends Controller
{
    //
    public function expense_category(Request $request)
    {
            if ($request->ajax()) {
            $expense_categories = ExpenseCategory::where('is_active',1);

            return DataTables::of($expense_categories)
            ->addColumn('actions',function($row){
                return '<div class="list-icons">
                <div class="dropdown">
                    <a href="#" class="list-icons-item" data-toggle="dropdown">
                        <i class="icon-menu9"></i>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="'. url('admin/expense-categories/edit/'.$row->id) .'" class="dropdown-item"><i class="icon-pencil3"></i> Edit</a>
                    </div>
                </div>
            </div>';
            })
            ->editColumn('type',function($row){
                return ucfirst(str_replace('_',' ',$row->type));
                
            })
            ->editColumn('created_at',function($row){
                return date('Y-m-d',strtotime($row->created_at));
            })
            ->setRowAttr([
                'class' => function ($row) {
                    return (isset($row->is_update) && $row->is_update == 1) ? 'bg-warning' : '';
                }
            ])
            ->rawColumns(['actions'])
            ->make(true);
         }
        $data['breadcrumbs'] = array(['name'=>'Home','active'=>true,'url'=>'']);
        return view('admin/expense_categories/main', compact('data'));

    }
    public function expense_category_add(Request $request)
    {

        $data['breadcrumbs'] = array(['name'=>'Home','active'=>true,'url'=>'']);
        return view('admin/expense_categories/add', compact('data'));

    }

    public function expense_category_submit(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'max:255'],
            'type' => ['required'],

        ]);
        $expense_category_add = new ExpenseCategory();
        $expense_category_add->name = $request->name;
        $expense_category_add->type = $request->type;
        $expense_category_add->is_active = 1;
        $expense_category_add->account_head_id= 0;
        $added = $expense_category_add->save();
        $data['success_msg'] = 'Expense Category Added Successfully!';
        if ($added) {
            $data['breadcrumbs'] = array(['name'=>'Home','active'=>true,'url'=>'']);
            return redirect()->back()->with('success','Expense Category Added Successfully!');



            return response()->json(['Success' => 'Successfully Added']);
        }else{
            $data['danger_msg'] = 'Group Not Added';
            $data['breadcrumbs'] = array(['name'=>'Home','active'=>true,'url'=>'']);

            return view('admin/expense_categories/add', compact('data'));

        }

    }


    public function edit_expense_category($id,Request $request)
    {
        $expense_category= ExpenseCategory::find($id);

        $data['expense_category'] = $expense_category;
        $data['breadcrumbs'] = array(['name'=>'Home','active'=>true,'url'=>'']);
        return view('admin/expense_categories/edit', compact('data'));

    }

    public function update_expense_category(Request $request)
    {
//        dd($request);die;
        $expense_category_update = ExpenseCategory::find($request->id);
        $expense_category_update->name = $request->name;
        $expense_category_update->type = $request->type;

        $added = $expense_category_update->save();
        $data['success_msg'] = 'Group Edit Successfully!';
        if ($added) {
            $data['breadcrumbs'] = array(['name'=>'Home','active'=>true,'url'=>'']);

            return redirect('admin/expense-categories/')->with('success', 'Expense Category Edit Successfully!');

         }else{
            $data['danger_msg'] = 'Subject Not Edit Successful!';
            $data['breadcrumbs'] = array(['name'=>'Home','active'=>true,'url'=>'']);
            return redirect('admin/expense-categories/')->with('status', 'Group Not Edit Successfully!');

//            return view('admin/student_admission/edit/', compact('data'));

        }

    }


}
