<?php

namespace App;
use Illuminate\Http\Request;

use Illuminate\Database\Eloquent\Model;


class StaffSalary extends Model
{


    public function teacher()
    {
        return $this->belongsTo('App\StaffTeacher','staff_teachers_id');
    }
    public function parent()
    {
        return $this->belongsTo('App\User','admission_no','admission_no');
    }


}
