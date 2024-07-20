<?php

namespace App;
use Illuminate\Http\Request;

use Illuminate\Database\Eloquent\Model;


class Expense extends Model
{

    public function expenseCategory()
    {
        return $this->belongsTo('App\ExpenseCategory','expense_category_name','name');
    }

    public function admin()
    {
        return $this->belongsTo('App\Admin','created_by');
    }

}
