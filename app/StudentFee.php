<?php

namespace App;
use Illuminate\Http\Request;

use Illuminate\Database\Eloquent\Model;


class StudentFee extends Model
{


    public function group()
    {
        return $this->belongsTo('App\Group');
    }
    public function student()
    {
        return $this->belongsTo('App\StudentAdmission','student_admissions_id');
    }
    public function parent()
    {
        return $this->belongsTo('App\User','admission_no','admission_no');
    }
    public function admin()
    {
        return $this->belongsTo('App\Admin','created_by');
    }

}
