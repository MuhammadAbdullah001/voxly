<?php

namespace App;
use Illuminate\Http\Request;

use Illuminate\Database\Eloquent\Model;


class NotificationReceiver extends Model
{


    public function notification()
    {
        return $this->belongsTo('App\Notification');
    }

    public function notification_reply()
    {
        return $this->hasMany('App\NotificationReceiverReply','notifications_id','notifications_id');
    }
    public function notification_reply_response_check()
    {
        return $this->belongsTo('App\NotificationReceiverReply','notifications_id','notifications_id');
    }
    public function user()
    {
        return $this->belongsTo('App\User','users_id');
    }
}
