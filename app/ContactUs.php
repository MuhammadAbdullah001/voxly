<?php

namespace App;
use Illuminate\Http\Request;

use Illuminate\Database\Eloquent\Model;


class ContactUs extends Model
{

    public function studentAdmission()
    {
        return $this->hasMany('App\StudentAdmission');
    }



}
