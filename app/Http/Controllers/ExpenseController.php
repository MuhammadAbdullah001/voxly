<?php

namespace App\Http\Controllers;

use App\Expense;
use App\ExpenseCategory;
use App\Group;
use App\Subject;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Redirector;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class ExpenseController extends Controller
{
    //
    public function expense(Request $request)
    {
        $expenses = Expense::where('is_active',1)->get();
        if ($request->ajax()) {
         $expenses = Expense::with('expenseCategory','admin')->where('is_active',1);

            return DataTables::of($expenses)
            ->addColumn('actions',function($row){
                return '<div class="list-icons">
                <div class="dropdown">
                    <a href="#" class="list-icons-item" data-toggle="dropdown">
                        <i class="icon-menu9"></i>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="'. url('admin/expenses/edit/'.$row->id) .'" class="dropdown-item"><i class="icon-pencil3"></i> Edit</a>
                    </div>
                </div>
            </div>';
            })
            ->editColumn('amount',function($row){
                return ucfirst(str_replace('_',' ',$row->amount));
                
            })
            ->addColumn('type',function($row){
return ucfirst(str_replace('_',' ',$row->expenseCategory->type));
            })
            ->editColumn('date',function($row){
                return date('Y-m-d',strtotime($row->date));
            })
            ->setRowAttr([
                'class' => function ($row) {
                    return (isset($row->is_update) && $row->is_update == 1) ? 'bg-warning' : '';
                }
            ])
            ->rawColumns(['actions'])
            ->make(true);
         }
        $total  = 0;
        foreach ($expenses as $key=>$expense) {
            $total+= $expense->amount;
        }
        $data['total'] = $total;
        $data['breadcrumbs'] = array(['name'=>'Home','active'=>true,'url'=>'']);
        return view('admin/expense/main', compact('data'));

    }


    public function expense_add(Request $request)
    {

        $data['breadcrumbs'] = array(['name'=>'Home','active'=>true,'url'=>'']);
        return view('admin/expense/add', compact('data'));

    }

    public function expense_submit(Request $request)
    {
        $validatedData = $request->validate([
            'expense_category_name' => ['required', 'max:255'],
            'date' => ['required'],
            'amount' => ['required'],

        ]);
        $expense_category_add = new Expense();
         $expense_category_add->expense_category_name = $request->expense_category_name;
        $expense_category_add->is_active = 1;
        $date = str_replace(',', ' ', $request->date);
        $expense_category_add->date= date('Y-m-d',strtotime($date));
        $expense_category_add->description= $request->description;
        $expense_category_add->amount= $request->amount;
        $expense_category_add->created_by= Auth::User()->id;
        $added = $expense_category_add->save();
        $data['success_msg'] = 'Expense  Added Successfully!';
        if ($added) {
            $data['breadcrumbs'] = array(['name'=>'Home','active'=>true,'url'=>'']);
            return redirect()->back()->with('success','Expense  Added Successfully!');



            return response()->json(['Success' => 'Successfully Added']);
        }else{
            $data['danger_msg'] = 'Expense Not Added';
            $data['breadcrumbs'] = array(['name'=>'Home','active'=>true,'url'=>'']);

            return view('admin/expense/add', compact('data'));

        }

    }


    public function getExpenseCategory(Request $request)
    {
        $expense_categories = ExpenseCategory::where('is_active',1)->where('type',$request->expense_category)->get();



        if (isset($expense_categories) && count($expense_categories)>0){


            return response()->json(['data' => $expense_categories, ],200);

        }else{
            $data['msg']="No Student Found!";
            return response()->json(['data' => $data, ],500);

        }

    }
    public function edit_expense($id,Request $request)
    {

        $expense= Expense::find($id);
        $expense_categories = ExpenseCategory::where('is_active',1)->get();

        foreach ($expense_categories as $key=>$expense_category){
            if ($expense_category->type = $expense->expense_category_name){
                $expense->type = $expense_category->name;

            }
        }
//        dd($expense);
         $data['expense'] = $expense;
        $data['breadcrumbs'] = array(['name'=>'Home','active'=>true,'url'=>'']);
        return view('admin/expense/edit', compact('data'));

    }

    public function update_expense(Request $request)
    {
//        dd($request);die;




        $expense_category_update = Expense::find($request->id);
        $expense_category_update->expense_category_name = $request->expense_category_name;
        $expense_category_update->date= date('Y-m-d',strtotime($request->date));
        $expense_category_update->description= $request->description;
        $expense_category_update->amount= $request->amount;

        $added = $expense_category_update->save();
        $data['success_msg'] = 'Expense Edit Successfully!';
        if ($added) {
            $data['breadcrumbs'] = array(['name'=>'Home','active'=>true,'url'=>'']);

            return redirect('admin/expenses/')->with('success', 'Expense Edit Successfully!');

         }else{
            $data['danger_msg'] = 'Subject Not Edit Successful!';
            $data['breadcrumbs'] = array(['name'=>'Home','active'=>true,'url'=>'']);
            return redirect('admin/expense/')->with('status', 'Expense Not Edit Successfully!');

//            return view('admin/student_admission/edit/', compact('data'));

        }

    }


}
