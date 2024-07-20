<?php

namespace App;
use Illuminate\Http\Request;

use Illuminate\Database\Eloquent\Model;


class StudentAttendance extends Model
{


    public function student()
    {
        return $this->belongsTo('App\StudentAdmission','student_admissions_id');
    }
    public function parent()
    {
        return $this->belongsTo('App\User','admission_no','admission_no');
    }


}
