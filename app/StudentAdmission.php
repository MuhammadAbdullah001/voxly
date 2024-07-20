<?php

namespace App;
use Illuminate\Http\Request;

use Illuminate\Database\Eloquent\Model;


class StudentAdmission extends Model
{


    public function group()
    {
        return $this->belongsTo('App\Group');
    }


}
