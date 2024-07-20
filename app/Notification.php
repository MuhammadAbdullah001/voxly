<?php

namespace App;
use Illuminate\Http\Request;

use Illuminate\Database\Eloquent\Model;


class Notification extends Model
{


    public function notification_receivers()
    {
        return $this->hasMany('App\NotificationReceiver','notifications_id');
    }
    public function user()
    {
        return $this->belongsTo('App\User','created_by_user_id');
    }


}
