<?php

namespace App;
use Illuminate\Http\Request;

use Illuminate\Database\Eloquent\Model;


class NotificationReceiverReply extends Model
{

 protected $fillable = ['message','notifications_id', 'sender_users_id','receiver_users_id','sender_user'];

    public function group()
    {
        return $this->belongsTo('App\Group');
    }


}
