<?php

namespace App;
use Illuminate\Http\Request;

use Illuminate\Database\Eloquent\Model;


class StaffTeacher extends Model
{


    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function assignedSubjects()
    {
        return $this->belongsTo('App\AssignedSubject','id','staff_teachers_id');
    }

}
