<?php

namespace App\Mail;

use App\Admin;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class twoFactorVerification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $user;
    public $code;

       public function __construct($id,$code)
    {
       $url = $_SERVER['REQUEST_URI'];
        $path = preg_replace('/\d/', '', $url );
        if (isset($path) && $path == '/admin/resend/twoFactorVerification/'){
             $user = Admin::find($id);
          

        }elseif (isset($path) && $path == '/resend/twoFactorVerification/'){
        
            $user = User::find($id);

        }
 
        if (isset($path) && $path == '/admin/login'){
             $user = Admin::find($id);
          

        }elseif (isset($path) && $path == '/login'){
        
            $user = User::find($id);

        }
          $this->user = $user;
          $this->code = $code;
    }



    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        $user= $this->user;
        $code= $this->code;

        return $this->view('email.twoFactorEmailCode',compact('user','code'));
    }
}
