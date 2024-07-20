<?php

namespace App;
use Illuminate\Http\Request;

use Illuminate\Database\Eloquent\Model;
use Iatstuti\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\CanResetPassword;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $guard = 'web';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [

        'name', 'email', 'password','package_type', 'avatar_url','address','contact_number','branch_id','contract','city','age','cnic','dob_month','dob_day','dob_year','type','verifyToken'
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function generateToken()
    {
        $this->api_token = str_random(60);
        $this->save();

        return $this->api_token;
    }
    public function teacherAssignedSub()
    {

        return $this->belongsTo('App\AssignedSubject','admin_or_teacher_id','staff_teachers_id');

    }
    public function teacher()
    {

        return $this->belongsTo('App\StaffTeacher','admin_or_teacher_id');

    }




    public function StudentAdmission()
    {

        return $this->hasMany('App\StudentAdmission','admission_no','admission_no');

    }


}
