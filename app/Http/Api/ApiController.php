<?php

namespace App\Http\Controllers\Api;

use App\ContactUs;
use App\Expense;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\Controller;


use App\Admin;
use App\Asset;
use Log;
use App\Assetdetail;
use App\AssetsAssigned;
use App\AttendanceRecord;
use App\Booking;
use App\Branch;
use App\Events\ChatEvents;
use App\Invoice;
use App\InvoiceItem;
use App\Message;
use App\NotificationReceiver;
use App\NotificationReceiverReply;
use App\RecurringInvoice;
use App\RecurringInvoiceItem;
use App\RecurringInvoiceLog;
use App\Setting;
use App\StaffAttendance;
use App\StaffSalary;
use App\StaffTeacher;
use App\StudentAdmission;
use App\StudentAttendance;
use App\StudentFee;
use App\Task;
use App\Channel;
use App\ChannelMember;
use App\Group;
use App\GroupMember;
use App\Team;
use App\TeamGuest;
use App\Ticket;
use App\TicketDetail;
use App\Transaction;
use App\User;
use App\Wallet;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Announcement as Announcement;
use Illuminate\Support\Facades\URL;
use phpDocumentor\Reflection\Types\Array_;
use tests\Mockery\Adapter\Phpunit\EmptyTestCase;
use App\Mail\verifyContract;
use Illuminate\Support\Str;
use Session;
use Notification;
use App\Notifications\Support;
use App\Http\Controllers\Api\ApiBaseController as APIBaseController;

use App\Post;
use Validator;

use Illuminate\Support\Facades\Mail;



class ApiController extends APIBaseController
{

    public function __construct()
    {
        date_default_timezone_set("Europe/London");

    }

    public function AddToLog($user_id, $msg)
    {
        \LogActivity::addToLogApi($user_id, $msg);
//        dd('log insert successfully.');
    }

    public function sendNotification($id, $team_id, $guest_name)

    {
        //$ticket = Ticket::where('id',$id)->first();

//        $ago = $this->time_elapsed_string($ticket->ago);
        $team = Team::where('id', $team_id)->first();
        $admins = Admin::all();
        foreach ($admins as $admin) {
            $get_admin = Admin::find($admin->id);
            $details = [
                'message' => 'New Visitor ' . $guest_name . 'is Coming of ' . $team->name,
                'id' => $id,
                'url' => "/admin/guests/view",
                'class' => "icon-profile"
            ];
            Notification::send($get_admin, new Support($details));
        }
    }

    public function sendNotificationTeamLead($id, $guest_name)
    {
        //$ticket = Ticket::where('id',$id)->first();

//        $ago = $this->time_elapsed_string($ticket->ago);
        $get_lead = User::find($id);
        $details = [
            'message' => 'Your Visitor ' . $guest_name . ' has been added',
            'id' => $id,
            'url' => "/guest/history/" . $id,
            'class' => "icon-profile"
        ];
        Notification::send($get_lead, new Support($details));
    }

    public function sendNotificationBooking($id, $branch_id, $team_id, $asset_id)
    {
        //$team = User::all();
        $get_lead = User::find($id);
        $asset = Asset::find($asset_id);
        $branch = Branch::where('id', $asset->branch_id)->first();
        $team = Team::where('id', $team_id)->first();
        $details = [
            'message' => 'New Booking has been made of ' . $asset->name . ' in branch ' . $branch->name . ' and team ' . $team->name,
            'id' => $id,
            'url' => "/booking",
            'class' => "icon-calendar52"
        ];

        Notification::send($get_lead, new Support($details));
    }

    public function sendNotificationBookingAdmin($id, $branch_id, $team_id, $asset_id)
    {
        $admins = Admin::all();
        $asset = Asset::find($asset_id);
        $branch = Branch::where('id', $asset->branch_id)->first();
        $team = Team::where('id', $team_id)->first();
        foreach ($admins as $admin) {
            $get_admin = Admin::find($admin->id);
            $details = [
                'message' => 'New Booking has been made of ' . $asset->name . ' in branch ' . $branch->name . ' and team ' . $team->name,
                'id' => $id,
                'url' => "/admin/booking",
                'class' => "icon-calendar52"
            ];
            Notification::send($get_admin, new Support($details));
        }
    }


    public function sendNotificationAdminReserved($id, $booking_id)
    {
        //$ticket = Ticket::where('id',$id)->first();

//        $ago = $this->time_elapsed_string($ticket->ago);
        $admins = Admin::all();
        foreach ($admins as $admin) {
            $get_admin = Admin::find($admin->id);
            $details = [
                'message' => 'Booking id ' . $booking_id . ' has been reserved ',
                'id' => $id,
                'url' => "/admin/booking",
                'class' => "icon-calendar52"
            ];
            Notification::send($get_admin, new Support($details));
        }
    }

    public function sendNotificationTeamLeadReserved($id, $booking_id)
    {
        $get_lead = User::find($id);
        $details = [
            'message' => 'Booking id ' . $booking_id . ' has been reserved ',
            'id' => $id,
            'url' => "/booking",
            'class' => "icon-calendar52"
        ];
        Notification::send($get_lead, new Support($details));
    }


    public function sendNotificationTicket($id)
    {
        $ticket = Ticket::where('id', $id)->first();
//dd($ticket->title);
//        $ago = $this->time_elapsed_string($ticket->ago);
        $admins = Admin::all();
        $user = User::where('id', $ticket->user_id)->first();
        foreach ($admins as $admin) {
            $get_admin = Admin::find($admin->id);
            $details = [
                'message' => 'New Ticket of ' . $ticket->title . ' has been created  by ' . $user->name,
                'id' => $id,
                'url' => "/admin/support",
                'class' => "icon-lifebuoy"
            ];
            Notification::send($get_admin, new Support($details));
        }
    }


    public function sendNotificationUserTicket($id)
    {
        $ticket = Ticket::where('id', $id)->first();

//        $ago = $this->time_elapsed_string($ticket->ago);
        $get_admin = User::find($ticket->user_id);
        $details = [
            'message' => 'New Ticket of ' . $ticket->title . ' has been created by ' . $get_admin->name,
            'id' => $id,
            'url' => "/support",
            'class' => "icon-lifebuoy"
        ];
        Notification::send($get_admin, new Support($details));
    }

    function send_notification_fcm($tokens, $data,$notif)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';
        $fields = array(
            'registration_ids' => $tokens,
            'data' => $data,
            'notification' => $notif
        );

        $headers = array(
            'Authorization:key = AAAAVQad6t4:APA91bHE4Gp-9AT3LdzXE_iP08Cl3bIc0ViXo2ceCXVvarBRSXnXDA7F1Kw_i2KXYlVNEb2WiTKWqzyhXjeXCjFI5OaLfo3H2EaX0aAzneJCupCTYDCj8v1HW58GPzDJlWBbrbRPtsVa',
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        curl_close($ch);
        return $result;
    }
    
     public function logout(Request $request)
    {

        $user = User::where('id', $request->id)->first();
        // if (isset($user) && !empty($user) && $user->api_token == $request->api_token) {
             if (isset($user) && !empty($user) ) {
            $user->fcm_token = '';
            $user->save();
            $data = array();



            return $this->sendResponse($data, 'Logout Successfully');

        }else{
                        return $this->sendError('User not found');

        }
        // else {
        //     $data = array();
        //     return $this->sendError('Login To View This Page');
 
        // }


    }


    public function profile(Request $request)
    {

        $user = User::where('id', $request->id)->first();
        if (isset($user) && !empty($user) && $user->api_token == $request->api_token) {

            $data = array();

            $students = StudentAdmission::where('admission_no', '=', $user->admission_no)->where('is_active', 1)->get();

            $data['user'] = $user;
            $data['students'] = $students;

            return $this->sendResponse($data, 'response successful');

        } else {
            $data = array();
            return $this->sendError('Login To View This Page');

//                    return $this->sendResponse($data, 'Login To View This Page');
//                    dd("Login To View This Page");
        }


    }


    public function contactUs(Request $request)
    {
        $user = User::where('id', $request->id)->first();
        if (isset($user) && !empty($user) && $user->api_token == $request->api_token) {

            $contact_us = new ContactUs();

            $contact_us->name = $request->name;
//            $contact_us->email = $request->email;
//            $contact_us->contact_number = $request->contact_number;
            $contact_us->subject = $request->subject;
            $contact_us->message = $request->message;
            $contact_us->is_active = 1;
            $contact_us->status = "active";



            if ($contact_us->save()) {

                $data = array();
                return $this->sendResponse($data, 'Query added successfully');

            }
            return $this->sendError('Error occurred in adding Query');

        } else {
            return $this->sendError('Wrong id/Api token');

        }
    }


    //main communication page
    public function AllTeachersList(Request $request)
    {
        // die("test");
        $user = User::where('id', $request->id)->first();
        if (isset($user) && !empty($user) && $user->api_token == $request->api_token && $user->user_role == "super_admin") {

            $data = array();

            $teachers_all = User::where('user_role', 'teacher')->where('is_active', 1)->get();
            $teachers = array();
            foreach($teachers_all as $teacher){
                if($teacher->teacher->is_resigned == 0){
                    // $notifcations = \App\Notification::where('created_by_user_id', $teacher->id)->where('is_active', 1)->first();
                    // if($notifcations){
                        $teachers[] = $teacher;
                    // }
                }
            }
            $data['users'] = $teachers;

            return $this->sendResponse($data, 'response successful');

        } else {
            $data = array();
            return $this->sendError('Login To View This Page');

//                    return $this->sendResponse($data, 'Login To View This Page');
//                    dd("Login To View This Page");
        }


    }

    public function AllUsersList(Request $request)
    {

        $user = User::where('id', $request->id)->first();
        if (isset($user) && !empty($user) && $user->api_token == $request->api_token && $user->user_role == "super_admin") {

            $data = array();
            $users = array();

            $Users = User::where('user_role', 'parent')->where('status','confirmed')->where('is_active', 1)->get();

            // foreach($Users as $user){
            //     $notifcations = \App\Notification::where('created_by_user_id', $user->id)->where('is_active', 1)->first();
            //     if($notifcations){
            //         $data['users'][]= $user;
            //     }
            // }

            $data['users'] = $Users;

            return $this->sendResponse($data, 'response successful');

        } else {
            $data = array();
            return $this->sendError('Login To View This Page with super admin account');

//                    return $this->sendResponse($data, 'Login To View This Page');
//                    dd("Login To View This Page");
        }


    }

    //comunication FIRST
    public function specificParentListCommunication(Request $request)
    {
        
        $check = true;
        $count = 0;
        $user = User::where('id', $request->id)->first();
        $teacher = User::where('id', $request->teacher_id)->first();

        if (isset($user) && !empty($user) && $user->api_token == $request->api_token && ( $user->user_role == "super_admin")) {
            if ($teacher->user_role == 'teacher'){
                $data = array();
                $count_ = 0;
                $users = User::where('status', 'confirmed')->where('user_role', 'parent')->where('is_active', 1)->get();
                $matchedUser = array('users'=>array(), 'dates'=>array());
                $unsorted_array = array();
                foreach (json_decode($teacher->teacherAssignedSub->subjects_id) as $assignedSubjectId) {
                    foreach ($users as $user1) {
                        if (isset($user1->StudentAdmission) && !empty($user1->StudentAdmission)) {
                            foreach ($user1->StudentAdmission as $relatedChilds) {
                                if (isset($user1->StudentAdmission) && !empty($user1->StudentAdmission)) {
                                    foreach (json_decode($relatedChilds->subject_id) as $relatedChildSubId) {
                                        if ($relatedChildSubId == $assignedSubjectId) {
                                            //  $teacher_notification = \App\Notification::where('created_by_user_id', $request->teacher_id)->where('is_active', 1)->count();
                                            // $user_notification = \App\Notification::where('created_by_user_id', $user->id)->where('is_active', 1)->count();
                                            // $user1_notification = \App\Notification::where('created_by_user_id', $user1->id)->where('is_active', 1)->count();
                                            //  $user1_notification_sender = NotificationReceiverReply::where('sender_users_id', $user1->id)->count();
                                            //  $user1_notification_reciver = NotificationReceiverReply::where('receiver_users_id', $user1->id)->count();

                                            //  $teacher_notification_sender = NotificationReceiverReply::where('sender_users_id', $request->teacher_id)->count();
                                            //   $teacher_notification_reciver = NotificationReceiverReply::where('receiver_users_id', $request->teacher_id)->count();
                                            //  $teacher_notification = \App\Notification::where('created_by_user_id', $request->teacher_id)->where('is_active', 1)->count();
                                            // >orderBy('created_at', 'DESC')
                                              $teacher_notifications = \App\Notification::where('created_by_user_id', $request->teacher_id)->where('is_active', 1)->get();
                                            //  $user1_notification = \App\Notification::where('created_by_user_id', $user1->id)->where('is_active', 1)->count();
                                             //  $teacher_notification = NotificationReceiver::where('users_id', $request->teacher_id)->where('is_active', 1)->count();
                                            // $user1_resever = NotificationReceiver::where('users_id', $user1->id)->where('is_active', 1)->count();
                                            // $teacher_resever = NotificationReceiver::where('users_id', $request->teacher_id)->where('is_active', 1)->count();

                                            //  $message = "teacher_id => ".$request->teacher_id.' ; user1_id => '.$user1->id ;
                                            // Log::error($message);
                                            // $message = ' ; user1_notification_sender => '.$user1_notification_sender.'; user1_notification_reciver => '.$user1_notification_reciver.' ; teacher_notification =>'.$teacher_notification.' ; teacher_notification_sender => '.$teacher_notification_sender.'; teacher_notification_reciver => '.$teacher_notification_reciver.' ; user1_resever => '.$user1_resever.' ; teacher_resever => '.$teacher_resever;
                                            // Log::error($message);
                                            foreach ($teacher_notifications as $teacher_notification) {

                                                foreach ($teacher_notification->notification_receivers as $notification_receiver) {
                                                    
                                                    if ($user1->id == $notification_receiver->users_id){
                                                        $matchedUser['users'][] = $user1->id;
                                                        $matchedUser['dates'][] = $teacher_notification->created_at->format('Y-m-d H:i:s');
                                                        $unsorted_array[$user1->id]['id'] = $user1->id;
                                                        $unsorted_array[$user1->id]['date'][] = $teacher_notification->created_at->format('Y-m-d H:i:s');
                                                        $unsorted_array[$user1->id]['date'][] = $teacher_notification->created_at->format('Y-m-d H:i:s');
                                                        $count_++;
    
                                                    }
    
                                                }
                                            }
                                            //  if(
                                            //       ( $user1_notification_sender > 0 || $user1_notification_reciver > 0 ) &&  $teacher_notification > 0 
                                            //     ){
                                            //         Log::error("in here but why");
                                            //  }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }

                    $fast = array();
                    // Log::error($unsorted_array);
                    foreach($unsorted_array as $key=>$val){
                        $fast[$key]['id'] = $val['id'];
                        $fast[$key]['date'] = max($val['date']);
                    }
                    // Log::error($fast);
                    usort($fast, function($a, $b) {
                        $t1 = strtotime($a['date']);
                        $t2 = strtotime($b['date']);
                        return $t1 - $t2;
                    });
                    $new_users = array();
                    foreach($fast as $key=>$val){
                        $new_users[] = $val['id'];

                    }
                    // Log::error($new_users);
                    // for($i=0;$i<sizeof($unsorted_array);$i++){

                    // }
                
                    // usort($unsorted_array, "compareByTimeStamp");
                    // $sorted_array = $this->array_sort_by_column($unsorted_array, 'date');

                    // usort($unsorted_array, function($a, $b) {
                    //     return new DateTime($a['datetime']) <=> new DateTime($b['datetime']);
                    //   });
                    // usort($fast, function($a, $b) {
                    //     $datetime1 = strtotime($a['date']); 
                    //     $datetime2 = strtotime($element2['date']); 
                    //     return $datetime1 - $datetime2; 
                    //    });
                    // $user_list =  $new_users;
                    $user_list =  $new_users;
                    // $user_list =  array_unique($matchedUser['users']);
                    foreach ($user_list as $user_id){
                        $data['users'][] = User::find($user_id);
                        // Log::error(User::find($user_id)->admission_no);
                        $count++;
                }
                // Log::error("My count is = ".$count);
                return $this->sendResponse($data, 'response successful');
            }else{
                return $this->sendError('Not A Valid Teacher ID');
            }
        } else {
            $data = array();
            return $this->sendError('Login To View This Page with Teacher account');
        }
    }

    function array_sort_by_column($array, $column, $direction = SORT_ASC) {
        $reference_array = array();
    
        foreach($array as $key => $row) {
            $reference_array[$key] = $row[$column];
        }
    
        array_multisort($reference_array, $direction, $array);
    }

    public function specificParentList(Request $request)
    {
        //  die('asdasd');

        $user = User::where('id', $request->id)->first();
        if (isset($user) && !empty($user) && $user->api_token == $request->api_token && ( $user->user_role == "teacher")) {
            $data = array();
            $users = User::where('status', 'confirmed')->where('user_role', 'parent')->where('is_active', 1)->get();
            $matchedUser = array();
            foreach (json_decode($user->teacherAssignedSub->subjects_id) as $assignedSubjectId) {

                foreach ($users as $user1) {
                    if (isset($user1->StudentAdmission) && !empty($user1->StudentAdmission)) {
                        foreach ($user1->StudentAdmission as $relatedChilds) {

                            if (isset($user1->StudentAdmission) && !empty($user1->StudentAdmission)) {
                                foreach (json_decode($relatedChilds->subject_id) as $relatedChildSubId) {
                                    if ($relatedChildSubId == $assignedSubjectId) {
                                        // $notifcations = \App\Notification::where('created_by_user_id', $user1->id)->where('is_active', 1)->first();
                                        // if($notifcations){
                                            $matchedUser[] = $user1->id;
                                        // }
                                    }
                                }
                            }

                        }
                    }
                }
            }

            $user_list =  array_unique($matchedUser);
            foreach ($user_list as $user_id){
                $data['users'][] = User::find($user_id);

            }

//            $data['users'] = $unique;

            return $this->sendResponse($data, 'response successful');

        } else {
            $data = array();
            return $this->sendError('Login To View This Page with Teacher account');

//                    return $this->sendResponse($data, 'Login To View This Page');
//                    dd("Login To View This Page");
        }


    }


    public function generateNotification(Request $request)
    {
// dd($request);
        $user = User::where('id', $request->id)->first();
        if (isset($user) && !empty($user) && $user->api_token == $request->api_token && ($user->user_role == "super_admin" || $user->user_role == "teacher")) {

            $notification = new \App\Notification();
            $notification->title = $request->title;
            $notification->description= $request->description;
            $notification->is_answerable= $request->is_answerable;
            $notification->created_by_user_id =  $user->id;

            $notification->is_active= 1;
            if ($request->hasFile('img')) {
                $image = $request->file('img');
                $name = time().'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('/images/notification_img');
                $image->move($destinationPath, $name);
                $notification->img=$name;


            }
            $added = $notification->save();
            if ($added){

                $user_ids = explode(',',$request->receivers_id);
                if(isset($user_ids) && !empty($user_ids) && is_array($user_ids)){
                    foreach ($user_ids as $user_id){
                        $token = User::select('fcm_token')->where('id', $user_id)->first();
                        if (isset($token) && !empty($token)) {
                            $tokens[] = $token['fcm_token'];
                        }

                        $notification_receiver = new NotificationReceiver();
                        $notification_receiver->notifications_id = $notification->id;
                        $notification_receiver->users_id = $user_id;
                        $notification_receiver->is_seen = 0;
                        $notification_receiver->save();
                    }
                }else{
                    return $this->sendError('Error In User Id');

                }

                $notif = array();
                $notif['title'] = $request->title;
                $notif['body'] = $request->description;

                $navigate = array("navigate" => 0);
                $message_status = $this->send_notification_fcm($tokens, $navigate,$notif);
                $data = array();


                return $this->sendResponse($data, 'Notification Generated Successfully');
            }else{
                return $this->sendError('Error occurred in adding booking');

            }


        } else {
            $data = array();
            return $this->sendError('Login To View This Page with super admin account');

//                    return $this->sendResponse($data, 'Login To View This Page');
//                    dd("Login To View This Page");
        }


    }

    public function notification_reply(Request $request){
        $user = User::where('id', $request->id)->first();
        if (isset($user) && !empty($user) && $user->api_token == ($request->api_token && $user->user_role == "parent" || $user->user_role == "teacher")) {

            $notification = \App\Notification::find($request->notifications_id);

            $request->merge(
                [
                    'sender_users_id'=>$request->id,
                    'receiver_users_id'=>$notification->created_by_user_id,
                    'sender_user'=>false
                ]
            );
            $sent = NotificationReceiverReply::create($request->all());
            if($sent){
                $token = User::select('fcm_token')->where('id', $notification->created_by_user_id)->first();
                if (isset($token) && !empty($token)) {
                    $tokens[] = $token['fcm_token'];
                }
                $notif = array();
                $notif['title'] = $notification->title;
                $notif['body'] = $request->message;

                $data = array("navigate" => 1);
                $message_status = $this->send_notification_fcm($tokens, $data,$notif);
                return response()->json(['status'=>'success','msg'=> 'Reply Sent Successfully']);
            }
            return response()->json(['msg'=>'Message not Sent'], 404);
        } else {
            $data = array();
            return $this->sendError('Login To View This Page with admin/parent account');

//                    return $this->sendResponse($data, 'Login To View This Page');
//                    dd("Login To View This Page");
        }

    }
    // Api to check all notif send by admin/super-admin but for now this API is not using in APP

    public function notification_sent_all(Request $request)
    {

        $user = User::where('id', $request->id)->first();
        if (isset($user) && !empty($user) && $user->api_token == $request->api_token && ($user->user_role == "super_admin" || $user->user_role == "teacher")) {

            $data = array();
            $notifications = \App\Notification::where('created_by_user_id', $request->id)->where('is_active', 1)->get();
            foreach ($notifications as $notification) {


                foreach ($notification->notification_receivers as $notification_receiver) {

                    $notification_data = new \stdClass();
                    $notification_data->sent_by = $user->parent_name;
                    $notification_data->sent_to = $notification_receiver->user->parent_name;
                    $notification_data->title = $notification->title;
                    $notification_data->description = $notification->description;
                    if($notification->img && !empty($notification->img)){
                        $img_path = asset("images/notification_img/" . $notification->img);

                    }else{
                        $img_path = '';

                    }
                    $notification_data->img = $img_path;


                    $data['notification'][] = $notification_data;

                }

            }


            return $this->sendResponse($data, 'response successful');

        } else {
            $data = array();
            return $this->sendError('Login To View This Page with super admin/admin account');

//                    return $this->sendResponse($data, 'Login To View This Page');
//                    dd("Login To View This Page");
        }


    }

    public function notification_all(Request $request)
    {

        $user = User::where('id', $request->id)->first();
        if (isset($user) && !empty($user) && $user->api_token == $request->api_token && ($user->user_role == "parent" || $user->user_role == "teacher")) {

            $data = array();
            $notifications = \App\Notification::where('is_active', 1)->get();
            foreach ($notifications as $notification) {


                foreach ($notification->notification_receivers as $notification_receiver) {
                    if ($notification_receiver->users_id == $request->id) {
                        $notification_data = new \stdClass();
                        $notification_data->notification_id = $notification->id;
                        $notification_data->is_answerable = $notification->is_answerable;
                        $notification_data->created_at = $this->time_elapsed_string($notification->created_at);

                        $notification_data->sent_by = $notification->user->parent_name;
                        $notification_data->title = $notification->title;
                        $notification_data->description = $notification->description;
                        $notification_data->is_seen = $notification_receiver->is_seen;
                        if($notification->img && !empty($notification->img)){
                            $img_path = asset("images/notification_img/" . $notification->img);

                        }else{
                            $img_path = '';

                        }
                         $notification_data->img = $img_path;


                        $data['notification'][] = $notification_data;

                    }
                }

            }


            return $this->sendResponse($data, 'response successful');

        } else {
            $data = array();
            return $this->sendError('Login To View This Page with parent/admin account');

//                    return $this->sendResponse($data, 'Login To View This Page');
//                    dd("Login To View This Page");
        }


    }


    public function responseCheck(Request $request)
    {

        $user = User::where('id', $request->id)->first();
        if (isset($user) && !empty($user) && ($user->api_token == $request->api_token) && ($user->user_role == "super_admin" || $user->user_role == "teacher")) {

            $data = array();
            $notifications = \App\Notification::where('created_by_user_id', $request->id)->where('is_active', 1)->get();
            foreach ($notifications as $notification) {



                foreach ($notification->notification_receivers as $notification_receiver) {
                    if (isset($notification_receiver->notification_reply)) {

                        foreach ($notification_receiver->notification_reply as $notif_reply) {

                            if (!empty($notif_reply)) {
                                if ($notification->id == $notif_reply->notifications_id
                                    && $notif_reply->sender_users_id == $notification_receiver->user->id) {
                                    $notification_data = new \stdClass();
                                    $notification_data->name = $user->parent_name;
                                    $notification_data->user_role = $user->user_role;
                                    $notification_data->title = $notification->title;
                                    $notification_data->description = $notification->description;
                                    $notification_data->created_at = strtotime($notification->created_at);
                                    if($notification->img && !empty($notification->img)){
                                        $img_path = asset("images/notification_img/" . $notification->img);

                                    }else{
                                        $img_path = '';

                                    }
                                     $notification_data->img = $img_path;
                                    $notification_reply_data = new \stdClass();
                                    $notification_reply_data->id = $notification_receiver->user->id;
                                    $notification_reply_data->admission_no = $notification_receiver->user->admission_no;
                                    $notification_reply_data->name = $notification_receiver->user->parent_name;
                                    $notification_reply_data->user_role = $notification_receiver->user->user_role;
                                    $notification_reply_data->message = $notif_reply->message;
                                    $notification_reply_data->created_at =  $this->time_elapsed_string($notification_receiver->created_at);
                                    $notification_data->notif_reply = $notification_reply_data;
                                    $data['notification'][] = $notification_data;
                                }
                            }
                        }
                    }
                }

            }


            return $this->sendResponse($data, 'response successful');

        } else {
            $data = array();
            return $this->sendError('Login To View This Page with super admin/admin account');

//                    return $this->sendResponse($data, 'Login To View This Page');
//                    dd("Login To View This Page");
        }


    }


    public function user_list_for_history(Request $request)
    {
        // die('test');

        $user = User::where('id', $request->id)->first();
        if (isset($user) && !empty($user) && $user->api_token == $request->api_token && ($user->user_role == "super_admin" || $user->user_role == "teacher") ) {

            $data = array();
            $user_list = array();
            $notifications = \App\Notification::where('created_by_user_id', $request->id)->where('is_active', 1)->get();
            if (isset($notifications) && !empty($notifications)){
                foreach ($notifications as $notification) {


                    foreach ($notification->notification_receivers as $notification_receiver) {
                        if(isset($notification_receiver->user->id)){
                            $user_list[] = $notification_receiver->user->id;

                        }

                    }

                }

                $user_list =  array_unique($user_list);
                foreach ($user_list as $user_id){
                    $data['user_list'][] = User::find($user_id);

                }
            }else{
                $data['user_list'][] = '';

                return $this->sendResponse($data, 'response successful');

            }

            return $this->sendResponse($data, 'response successful');

        } else {
            $data = array();
            return $this->sendError('Login To View This Page with super admin/admin account');

//                    return $this->sendResponse($data, 'Login To View This Page');
//                    dd("Login To View This Page");
        }


    }

    public function get_chat_by_id(Request $request)
    {
        // die('small');
        $user = User::where('id', $request->id)->first();

        $selected_teacher = User::where('id', $request->teacher_id)->first();
        if (isset($user) && !empty($user) && $user->api_token == $request->api_token && ($user->user_role == "super_admin" || $user->user_role == "teacher")) {

            $data = array();
            $notifications = \App\Notification::where('created_by_user_id', $request->teacher_id)->where('is_active', 1)->get();
            foreach ($notifications as $notification) {


                foreach ($notification->notification_receivers as $notification_receiver) {
                    if ($request->user_id_for_chat == $notification_receiver->users_id){
                        $notification_data = new \stdClass();
                        $notification_data->name = $notification->user->parent_name;
                        $notification_data->teacher_id = $notification->user  ->id;
                        $notification_data->title = $notification->title;
                        $notification_data->description = $notification->description;
                        $notification_data->is_sender = 1;
                        $notification_data->created_at = $this->time_elapsed_string($notification->created_at);
                        if($notification->img && !empty($notification->img)){
                            $img_path = asset("images/notification_img/" . $notification->img);

                        }else{
                            $img_path = '';

                        }
                        $notification_data->img = $img_path;
                        $teacher_name = $notification->user->parent_name;
                        $parent_name = $notification->user->parent_name;
                        if (isset($notification_receiver->notification_reply)) {
                            foreach ($notification_receiver->notification_reply as $notif_reply) {
                                if ($request->user_id_for_chat == $notification_receiver->users_id
                                    && $notif_reply->sender_users_id == $request->user_id_for_chat) {

                                    $notification_reply_user = User::find($request->user_id_for_chat);


                                    $notification_reply_data = new \stdClass();
                                    $notification_reply_data->user_id = $notification_receiver->user->id;
                                    $notification_reply_data->admission_no = $notification_reply_user->admission_no;
                                    $notification_reply_data->is_sender = 0;
                                    $notification_reply_data->name = $notification_receiver->user->parent_name;
                                    $notification_reply_data->message = $notif_reply->message;
                                    $notification_reply_data->created_at = $this->time_elapsed_string($notification_receiver->created_at);
                                    $notification_data->notif_reply = $notification_reply_data;
//                            $data['notifications'][] = $notification_data;

                                }
                            }
                        }
                        $data['notifications'][] = $notification_data;

                    }

//                    if (!empty($notification_receiver->notification_reply)) {
//                        foreach ($notification_receiver->notification_reply as $notif_reply) {
//                            if ($request->user_id_for_chat == $notification_receiver->users_id
//                                && $notif_reply->sender_users_id == $request->user_id_for_chat) {
//                                $notification_data = new \stdClass();
//                                $notification_data->name = $selected_teacher->parent_name;
//                                $notification_data->title = $notification->title;
//                                $notification_data->description = $notification->description;
//                                $notification_data->is_sender = 1;
//
//                                $notification_data->created_at = $this->time_elapsed_string($notification->created_at);
//                                if($notification->img && !empty($notification->img)){
//                                    $img_path = asset("images/notification_img/" . $notification->img);
//
//                                }else{
//                                    $img_path = '';
//
//                                }
//                                 $notification_data->img = $img_path;
//
//
//                                $notification_reply_data = new \stdClass();
//                                $notification_reply_data->user_id = $notification_receiver->user->id;
//                                $notification_reply_data->admission_no = $notification_receiver->user->admission_no;
//                                $notification_reply_data->is_sender = 0;
//                                $notification_reply_data->name = $notification_receiver->user->parent_name;
//                                $notification_reply_data->message = $notif_reply->message;
//                                $notification_reply_data->created_at = $this->time_elapsed_string($notification_receiver->created_at);
//                                $notification_data->notif_reply = $notification_reply_data;
//                                $data['notifications'][] = $notification_data;
//                            }
//                        }
//                    }


                }

            }


            return $this->sendResponse($data, 'response successful');

        } else {
            $data = array();
            return $this->sendError('Login To View This Page with super admin/admin account');

//                    return $this->sendResponse($data, 'Login To View This Page');
//                    dd("Login To View This Page");
        }


    }

    //comunication > SECONDS
    public function get_chat_by_id_communication(Request $request)
    {
        //  die('mast');
        // Log::error("zahid save me".$request->teacher_id);
        $user = User::where('id', $request->id)->first();
        $selected_teacher = User::where('id', $request->teacher_id)->first();
        if (isset($user) && !empty($user) && $user->api_token == $request->api_token && ($user->user_role == "super_admin" )) {
            
            $data = array();
            $notifications = \App\Notification::where('created_by_user_id', $request->teacher_id)->where('is_active', 1)->get();
            foreach ($notifications as $notification) {
                
                foreach ($notification->notification_receivers as $notification_receiver) {
//                print_r($notification_receiver->notifications_id);
//                if (isset($notification_receiver->notification_reply)) {
//                    echo "<pre>";
//                    print_r(($notification_receiver->notification_reply));
//
//                }
//
//                echo "$request->user_id_for_chat";
                    //                    if (!empty($notification_receiver->notification_reply)) {

                        // Log::error("zahid save me".$request->user_id_for_chat);
                        // Log::error("zahid save me".$notification_receiver->users_id);
                    if ($request->user_id_for_chat == $notification_receiver->users_id){
                        $notification_data = new \stdClass();
                        $notification_data->name = $notification->user->parent_name;
                        $notification_data->teacher_id = $notification->user  ->id;
                        $notification_data->title = $notification->title;
                        $notification_data->description = $notification->description;
                        $notification_data->is_sender = 1;
                        $notification_data->created_at = $this->time_elapsed_string($notification->created_at);
                        if($notification->img && !empty($notification->img)){
                            $img_path = asset("images/notification_img/" . $notification->img);

                        }else{
                            $img_path = '';

                        }
                         $notification_data->img = $img_path;
                         $teacher_name = $notification->user->parent_name;
                         $parent_name = $notification->user->parent_name;
                        if (isset($notification_receiver->notification_reply)) {
                            foreach ($notification_receiver->notification_reply as $notif_reply) {
                                if ($request->user_id_for_chat == $notification_receiver->users_id
                                && $notif_reply->sender_users_id == $request->user_id_for_chat) {
                                    
                                    $notification_reply_user = User::find($request->user_id_for_chat);
                                    

                                    $notification_reply_data = new \stdClass();
                                    $notification_reply_data->user_id = $notification_receiver->user->id;
                                    $notification_reply_data->admission_no = $notification_reply_user->admission_no;
                                    $notification_reply_data->is_sender = 0;
                                    $notification_reply_data->name = $notification_receiver->user->parent_name;
                                    $notification_reply_data->message = $notif_reply->message;
                                    $notification_reply_data->created_at = $this->time_elapsed_string($notification_receiver->created_at);
                                    $notification_data->notif_reply = $notification_reply_data;
//                            $data['notifications'][] = $notification_data;

                                }
                            }
                        }
                        $data['notifications'][] = $notification_data;

                    }
//                elseif ($request->user_id_for_chat == $notification_receiver->users_id) {
//                    print_r("sdfsdfsdfs");die;
//                    $notification_data = new \stdClass();
//                    $notification_data->name = $notification->user->parent_name;
//                    $notification_data->teacher_id = $notification->user->id;
//                    $notification_data->title = $notification->title;
//                    $notification_data->description = $notification->description;
//                    $notification_data->is_sender = 1;
//                    $notification_data->created_at = ($notification->created_at);
//                    $img_path = asset("images/notification_img/" . $notification->img);
//                    $notification_data->img = $img_path;
//                    $data['notifications'][] = $notification_data;
//                    $teacher_name = $notification->user->parent_name;
//                    $parent_name = $notification->user->parent_name;
//                }
//                    }

                }

            }


            return $this->sendResponse($data, 'response successful');

        } else {
            $data = array();
            return $this->sendError('Login To View This Page with super admin account');

//                    return $this->sendResponse($data, 'Login To View This Page');
//                    dd("Login To View This Page");
        }


    }


    public function notification_read(Request $request)
    {

        $user = User::where('id', $request->id)->first();
        if (isset($user) && !empty($user) && ($user->api_token == $request->api_token)) {

            $data = array();
            $notifications = \App\Notification::where('id', $request->notification_id)->where('is_active', 1)->get();

            foreach ($notifications as $notification) {


                foreach ($notification->notification_receivers as $notification_receiver) {
                    if (!empty($notification_receiver->notification_reply)) {
                        if ($notification->id == $notification_receiver->notifications_id
                            && $notification_receiver->users_id == $request->id) {
                            $notification_receiver = NotificationReceiver::find($notification_receiver->id);
                            $notification_receiver->is_seen = 1;
                            if($notification_receiver->save()){
                                $data['response'] = "status changed successfully!";
                            }


                        }
                    }


                }

            }


            return $this->sendResponse($data, 'response successful');

        } else {
            $data = array();
            return $this->sendError('Login To View This Page with super admin/admin account');

        }


    }
        public function dashboard(Request $request)
    {

        $user = User::where('id', $request->id)->first();
        if (isset($user) && !empty($user) && $user->api_token == $request->api_token ) {
                $user->fcm_token = $request->fcm_token;
                $user->save();
            if ($user->user_role == "super_admin"){


                $start_time = date('Y-m-1 00:00:00');
                $end_time = date('Y-m-31 23:59:59');

                $fees= StudentFee::whereBetween('from_date', [$start_time, $end_time])->where('status','paid')->where('is_active',1)->sum('amount_taken');
                $expenses= Expense::whereBetween('date', [$start_time, $end_time])->where('is_active',1)->sum('amount');
                $salaries= StaffSalary::whereBetween('salary_from_date', [$start_time, $end_time])->where('is_active',1)->sum('amount_taken');
                $admissions_active = User::where('status','confirmed')->where('user_role','parent')->where('is_active',1)->count();
                $admissions_inactive = User::where('status','!=','confirmed')->where('user_role','parent')->where('is_active',1)->count();

                $income =  0;
                $exp=$expenses;
                $expenses+=$salaries;
                if(isset($fees) && $fees > 0){
//                    its for percentage not using now
//                    $expense = ceil(($expenses/$fees)*100);
//
//                    $income = ceil(100 - $expense);
                    $income = $fees -  $expenses;
                    $incom_expense = new \stdClass();
                    $incom_expense->income = $income;
                    $incom_expense->expenses = (float)$exp;
                    $incom_expense->color = 1;
                    $incom_expense->unit = 'percent';
                    $data['income_expense'] = $incom_expense;
                }else{
                    $expense = $expenses;
                    $income = 0;

                    $incom_expense = new \stdClass();
                    $incom_expense->income = $income;
                    $incom_expense->expenses = $expense;
                    $incom_expense->color = 1;
                    $incom_expense->unit = 'number';
                    $data['income_expense'] = $incom_expense;
                }



                $fees_salaries = new \stdClass();
                $fees_salaries->fees = $fees;
                $fees_salaries->salaries = $salaries;
                $fees_salaries->color = 2;
                $fees_salaries->unit = 'number';
                $data['fees_salaries'] = $fees_salaries;

                $admissions = new \stdClass();
                $admissions->admissions_active = $admissions_active;
                $admissions->admissions_inactive = $admissions_inactive;
                $admissions->color = 3;
                $admissions->unit = 'number';
                $data['admissions'] = $admissions;

            }elseif ($user->user_role == "teacher"){

                $salary_conflicted_last_pay_date = DB::select("select salary_to_date from staff_salaries  where staff_teachers_id = '$user->admin_or_teacher_id' and status = 'paid'    order by id desc limit 1 ");
                if (isset($salary_conflicted_last_pay_date) && count($salary_conflicted_last_pay_date) > 0) {
                    $from_date = date('Y-m-d', (strtotime($salary_conflicted_last_pay_date[0]->salary_to_date) + (60 * 60 * 24))); //add 1 day to get st unpaid salary day from last pay date
                    $to_date = date('Y-m-d');
//                    $student_attendence = DB::select("select count(*) as atttendance_count from student_attendances  where student_admissions_id = '$student->id' and  date(date) between '$from_date' and '$to_date'");
                    $attendances= StaffAttendance::whereBetween('date', [$from_date, $to_date])->where('staff_teacher_id',$user->admin_or_teacher_id)->where('is_active',1)->get();


                } else {
                    $month = date('m', strtotime('-3 month'));

                    $from_date = date('Y-' . $month . '01');
                    $to_date = date('Y-m-d');
//                    $student_attendence = DB::select("select count(*) as atttendance_count from student_attendances  where student_admissions_id = '$student->id' and  date(date) between '$from_date' and '$to_date'");
                    $attendances= StaffAttendance::whereBetween('date', [$from_date, $to_date])->where('staff_teacher_id',$user->admin_or_teacher_id)->where('is_active',1)->get();

                }
                 $expected_salary_duration = count($attendances);
                $per_day_salary = $user->teacher->per_hour_rate * $user->teacher->daily_working_hours;
                $expected_salary = $per_day_salary * $expected_salary_duration;
                if ($expected_salary_duration > 0) {
                    $user->expected_salary = $expected_salary;
                    if (isset($salary_conflicted_last_pay_date[0]->to_date)) {
                        $user->last_fee_paid = $salary_conflicted_last_pay_date[0]->to_date;

                    }
                    $user->expected_salary_duration = $expected_salary_duration;
                } else {
                    $user->expected_salary = 0;
                    $user->expected_salary_duration = 0;
                }




                 $hrs = $user->expected_salary_duration*$user->teacher->daily_working_hours;


//                $start_time = date('Y-m-1 00:00:00');
//                $end_time = date('Y-m-31 23:59:59');
//
//                $attendances= StaffAttendance::whereBetween('date', [$start_time, $end_time])->where('staff_teacher_id',$user->admin_or_teacher_id)->where('is_active',1)->get();
//                $hrs = 0;
//                foreach ($attendances as $attendance) {
//                    $hrs += ceil(date('h',strtotime($attendance->end_time) - strtotime($attendance->start_time)));
//                }
//                $expected_salary = ceil($hrs*$user->teacher->per_hour_rate);
                $subjects = json_decode($user->teacherAssignedSub->subjects_name);
                $assigned_group = json_decode($user->teacherAssignedSub->assigned_group);
                $data['assigned_group'] = $assigned_group;
                $data['assigned_subjects'] = $subjects;

                $month_worked_hrs = new \stdClass();
                $month_worked_hrs->this_moth_worked_hrs = $hrs;
                $month_worked_hrs->color = 1;
                $month_worked_hrs->unit = 'number';
                $data['month_worked_hrs'] = $month_worked_hrs;

                $expected_salary_data = new \stdClass();
                $expected_salary_data->expected_salary = $user->expected_salary;
                $expected_salary_data->color = 2;
                $expected_salary_data->unit = 'number';
                $data['expected_salary'] = $expected_salary_data;

                $attendance_data = new \stdClass();
                $attendance_data->month_attendances = count($attendances);
                $attendance_data->color = 3;
                $attendance_data->unit = 'number';
                $data['attendances'] = $attendance_data;


            }elseif ($user->user_role == "parent"){

                foreach ($user->StudentAdmission as $student){





                    $fee_conflicted_last_pay_date = DB::select("select to_date from student_fees  where student_admissions_id = '$student->id' and status = 'paid'    order by id desc limit 1 ");
                    if (isset($fee_conflicted_last_pay_date) && count($fee_conflicted_last_pay_date) > 0) {
                        $from_date = date('Y-m-d', (strtotime($fee_conflicted_last_pay_date[0]->to_date) + (60 * 60 * 24))); //add 1 day to get st unpaid salary day from last pay date
                        $to_date = date('Y-m-d');
                        $student_attendence = DB::select("select count(*) as atttendance_count from student_attendances  where student_admissions_id = '$student->id' and  date(date) between '$from_date' and '$to_date'");


                    } else {
                        $month = date('m', strtotime('-3 month'));

                        $from_date = date('Y-' . $month . '01');
                        $to_date = date('Y-m-d');
                        $student_attendence = DB::select("select count(*) as atttendance_count from student_attendances  where student_admissions_id = '$student->id' and  date(date) between '$from_date' and '$to_date'");

                    }

                    $expected_fee_duration = $student_attendence[0]->atttendance_count;
                    $per_day_fee = $student->agreed_fee_per_hr * $student->agreed_hrs;
                    $expected_fee = $per_day_fee * $student_attendence[0]->atttendance_count;
                    if ($student_attendence[0]->atttendance_count > 0) {
                        $student->expected_fee = $expected_fee;
                        if (isset($fee_conflicted_last_pay_date[0]->to_date)) {
                            $student->last_fee_paid = $fee_conflicted_last_pay_date[0]->to_date;

                        }
                        $student->expected_fee_duration = $expected_fee_duration;
                    } else {
                        $student->expected_fee = 0;
                        $student->expected_fee_duration = 0;
                    }


//                    $start_time = date('Y-m-1 00:00:00');
//                    $end_time = date('Y-m-31 23:59:59');
//
//                    $attendances= StudentAttendance::whereBetween('date', [$start_time, $end_time])->where('student_admissions_id',$student->id)->where('is_active',1)->get();
//                    $hrs = 0;
//                    foreach ($attendances as $attendance) {
//                        $hrs += ceil(date('h',strtotime($attendance->end_time) - strtotime($attendance->start_time)));
//                    }
//                    $expected_fee = ceil($hrs*$student->agreed_fee_per_hr);
                    $subjects = json_decode($student->subject_name);
                    $assigned_group =  ($student->group->name);

                    $assigned_group_data = new \stdClass();
                    $assigned_group_data->student_id = $student->id;
                    $assigned_group_data->student_name = $student->student_name;
                    $assigned_group_data->assigned_group = $assigned_group;
                    $data['assigned_group'][] = $assigned_group_data;

                    $subjects_data = new \stdClass();
                    $subjects_data->student_id = $student->id;
                    $subjects_data->student_name = $student->student_name;
                    $subjects_data->subjects = json_decode($student->subject_name);

                    $data['assigned_subjects'][] = $subjects_data;

                    $month_hrs = new \stdClass();
                    $month_hrs->this_moth_hrs_taken = $student->agreed_hrs*$student->expected_fee_duration;
                    $month_hrs->student_id = $student->id;
                    $month_hrs->student_name = $student->student_name;
                    $month_hrs->color = 1;
                    $month_hrs->unit = 'number';
                    $data['month_hrs_taken'][] = $month_hrs;

                    $expected_fee_data = new \stdClass();
                    $expected_fee_data->expected_fee = ceil($student->expected_fee);
                    $expected_fee_data->student_id = $student->id;
                    $expected_fee_data->student_name = $student->student_name;
                    $expected_fee_data->color = 2;
                    $expected_fee_data->unit = 'number';
                    $data['expected_fee'][] = $expected_fee_data;

                    $attendance_data = new \stdClass();
                    $attendance_data->month_attendances = $student->expected_fee_duration;
                    $attendance_data->color = 3;
                    $attendance_data->student_id = $student->id;
                    $attendance_data->student_name = $student->student_name;
                    $attendance_data->unit = 'number';
                    $data['attendances'][] = $attendance_data;

                }


            }

            return $this->sendResponse($data, 'response successful');

        } else {
            $data = array();
            return $this->sendError('Login To View This Page with super admin/admin account');

//                    return $this->sendResponse($data, 'Login To View This Page');
//                    dd("Login To View This Page");
        }


    }


//     public function dashboard(Request $request)
//     {

//         $user = User::where('id', $request->id)->first();
//         if (isset($user) && !empty($user) && $user->api_token == $request->api_token ) {
//                 $user->fcm_token = $request->fcm_token;
//                 $user->save();
//             if ($user->user_role == "super_admin"){


//                 $start_time = date('Y-m-1 00:00:00');
//                 $end_time = date('Y-m-31 23:59:59');

//                 $fees= StudentFee::whereBetween('from_date', [$start_time, $end_time])->where('status','paid')->where('is_active',1)->sum('amount_taken');
//                 $expenses= Expense::whereBetween('date', [$start_time, $end_time])->where('is_active',1)->sum('amount');
//                 $salaries= StaffSalary::whereBetween('salary_from_date', [$start_time, $end_time])->where('is_active',1)->sum('amount_taken');
//                 $admissions_active = User::where('status','confirmed')->where('user_role','parent')->where('is_active',1)->count();
//                 $admissions_inactive = User::where('status','!=','confirmed')->where('user_role','parent')->where('is_active',1)->count();

//                 $income = 0;
//                 $expenses+=$salaries;
//                 if(isset($fees) && $fees > 0){
//                     $expense = ceil(($expenses/$fees)*100);

//                     $income = ceil(100 - $expense);

//                     $incom_expense = new \stdClass();
//                     $incom_expense->income = $income;
//                     $incom_expense->expenses = $expense;
//                     $incom_expense->color = 1;
//                     $incom_expense->unit = 'percent';
//                     $data['income_expense'] = $incom_expense;
//                 }else{
//                     $expense = $expenses;
//                     $income = 0;

//                     $incom_expense = new \stdClass();
//                     $incom_expense->income = $income;
//                     $incom_expense->expenses = $expense;
//                     $incom_expense->color = 1;
//                     $incom_expense->unit = 'number';
//                     $data['income_expense'] = $incom_expense;
//                 }



//                 $fees_salaries = new \stdClass();
//                 $fees_salaries->fees = $fees;
//                 $fees_salaries->salaries = $salaries;
//                 $fees_salaries->color = 2;
//                 $fees_salaries->unit = 'number';
//                 $data['fees_salaries'] = $fees_salaries;

//                 $admissions = new \stdClass();
//                 $admissions->admissions_active = $admissions_active;
//                 $admissions->admissions_inactive = $admissions_inactive;
//                 $admissions->color = 3;
//                 $admissions->unit = 'number';
//                 $data['admissions'] = $admissions;

//             }elseif ($user->user_role == "teacher"){

//                 $salary_conflicted_last_pay_date = DB::select("select salary_to_date from staff_salaries  where staff_teachers_id = '$user->admin_or_teacher_id' and status = 'paid'    order by id desc limit 1 ");
//                  if (isset($salary_conflicted_last_pay_date) && count($salary_conflicted_last_pay_date) > 0) {
//                     $from_date = date('Y-m-d', (strtotime($salary_conflicted_last_pay_date[0]->salary_to_date) + (60 * 60 * 24))); //add 1 day to get st unpaid salary day from last pay date
//                     $to_date = date('Y-m-d');
// //                    $student_attendence = DB::select("select count(*) as atttendance_count from student_attendances  where student_admissions_id = '$student->id' and  date(date) between '$from_date' and '$to_date'");
//                     $attendances= StaffAttendance::whereBetween('date', [$from_date, $to_date])->where('staff_teacher_id',$user->admin_or_teacher_id)->where('is_active',1)->get();


//                 } else {
//                     $month = date('m', strtotime('-3 month'));

//                     $from_date = date('Y-' . $month . '01');
//                     $to_date = date('Y-m-d');
// //                    $student_attendence = DB::select("select count(*) as atttendance_count from student_attendances  where student_admissions_id = '$student->id' and  date(date) between '$from_date' and '$to_date'");
//                     $attendances= StaffAttendance::whereBetween('date', [$from_date, $to_date])->where('staff_teacher_id',$user->admin_or_teacher_id)->where('is_active',1)->get();

//                 }
//                  $expected_salary_duration = count($attendances);
//                 $per_day_salary = $user->teacher->per_hour_rate * $user->teacher->daily_working_hours;
//                 $expected_salary = $per_day_salary * $expected_salary_duration;
//                 if ($expected_salary_duration > 0) {
//                     $user->expected_salary = $expected_salary;
//                     if (isset($salary_conflicted_last_pay_date[0]->to_date)) {
//                         $user->last_fee_paid = $salary_conflicted_last_pay_date[0]->to_date;

//                     }
//                     $user->expected_salary_duration = $expected_salary_duration;
//                 } else {
//                     $user->expected_salary = 0;
//                     $user->expected_salary_duration = 0;
//                 }




//                  $hrs = $user->expected_salary_duration*$user->teacher->daily_working_hours;


// //                $start_time = date('Y-m-1 00:00:00');
// //                $end_time = date('Y-m-31 23:59:59');
// //
// //                $attendances= StaffAttendance::whereBetween('date', [$start_time, $end_time])->where('staff_teacher_id',$user->admin_or_teacher_id)->where('is_active',1)->get();
// //                $hrs = 0;
// //                foreach ($attendances as $attendance) {
// //                    $hrs += ceil(date('h',strtotime($attendance->end_time) - strtotime($attendance->start_time)));
// //                }
// //                $expected_salary = ceil($hrs*$user->teacher->per_hour_rate);
//                 $subjects = json_decode($user->teacherAssignedSub->subjects_name);
//                 $assigned_group = json_decode($user->teacherAssignedSub->assigned_group);
//                 $data['assigned_group'] = $assigned_group;
//                 $data['assigned_subjects'] = $subjects;

//                 $month_worked_hrs = new \stdClass();
//                 $month_worked_hrs->this_moth_worked_hrs = $hrs;
//                 $month_worked_hrs->color = 1;
//                 $month_worked_hrs->unit = 'number';
//                 $data['month_worked_hrs'] = $month_worked_hrs;

//                 $expected_salary_data = new \stdClass();
//                 $expected_salary_data->expected_salary = $user->expected_salary;
//                 $expected_salary_data->color = 2;
//                 $expected_salary_data->unit = 'number';
//                 $data['expected_salary'] = $expected_salary_data;

//                 $attendance_data = new \stdClass();
//                 $attendance_data->month_attendances = count($attendances);
//                 $attendance_data->color = 3;
//                 $attendance_data->unit = 'number';
//                 $data['attendances'] = $attendance_data;


//             }elseif ($user->user_role == "parent"){

//                 foreach ($user->StudentAdmission as $student){





//                     $fee_conflicted_last_pay_date = DB::select("select to_date from student_fees  where student_admissions_id = '$student->id' and status = 'paid'    order by id desc limit 1 ");
//                     if (isset($fee_conflicted_last_pay_date) && count($fee_conflicted_last_pay_date) > 0) {
//                         $from_date = date('Y-m-d', (strtotime($fee_conflicted_last_pay_date[0]->to_date) + (60 * 60 * 24))); //add 1 day to get st unpaid salary day from last pay date
//                         $to_date = date('Y-m-d');
//                         $student_attendence = DB::select("select count(*) as atttendance_count from student_attendances  where student_admissions_id = '$student->id' and  date(date) between '$from_date' and '$to_date'");


//                     } else {
//                         $month = date('m', strtotime('-3 month'));

//                         $from_date = date('Y-' . $month . '01');
//                         $to_date = date('Y-m-d');
//                         $student_attendence = DB::select("select count(*) as atttendance_count from student_attendances  where student_admissions_id = '$student->id' and  date(date) between '$from_date' and '$to_date'");

//                     }

//                     $expected_fee_duration = $student_attendence[0]->atttendance_count;
//                     $per_day_fee = $student->agreed_fee_per_hr * $student->agreed_hrs;
//                     $expected_fee = $per_day_fee * $student_attendence[0]->atttendance_count;
//                     if ($student_attendence[0]->atttendance_count > 0) {
//                         $student->expected_fee = $expected_fee;
//                         if (isset($fee_conflicted_last_pay_date[0]->to_date)) {
//                             $student->last_fee_paid = $fee_conflicted_last_pay_date[0]->to_date;

//                         }
//                         $student->expected_fee_duration = $expected_fee_duration;
//                     } else {
//                         $student->expected_fee = 0;
//                         $student->expected_fee_duration = 0;
//                     }


// //                    $start_time = date('Y-m-1 00:00:00');
// //                    $end_time = date('Y-m-31 23:59:59');
// //
// //                    $attendances= StudentAttendance::whereBetween('date', [$start_time, $end_time])->where('student_admissions_id',$student->id)->where('is_active',1)->get();
// //                    $hrs = 0;
// //                    foreach ($attendances as $attendance) {
// //                        $hrs += ceil(date('h',strtotime($attendance->end_time) - strtotime($attendance->start_time)));
// //                    }
// //                    $expected_fee = ceil($hrs*$student->agreed_fee_per_hr);
//                     $subjects = json_decode($student->subject_name);
//                     $assigned_group =  ($student->group->name);

//                     $assigned_group_data = new \stdClass();
//                     $assigned_group_data->student_id = $student->id;
//                     $assigned_group_data->student_name = $student->student_name;
//                     $assigned_group_data->assigned_group = $assigned_group;
//                     $data['assigned_group'][] = $assigned_group_data;

//                     $subjects_data = new \stdClass();
//                     $subjects_data->student_id = $student->id;
//                     $subjects_data->student_name = $student->student_name;
//                     $subjects_data->subjects = json_decode($student->subject_name);

//                     $data['assigned_subjects'][] = $subjects_data;

//                     $month_hrs = new \stdClass();
//                     $month_hrs->this_moth_hrs_taken = $student->agreed_hrs*$student->expected_fee_duration;
//                     $month_hrs->student_id = $student->id;
//                     $month_hrs->student_name = $student->student_name;
//                     $month_hrs->color = 1;
//                     $month_hrs->unit = 'number';
//                     $data['month_hrs_taken'][] = $month_hrs;

//                     $expected_fee_data = new \stdClass();
//                     $expected_fee_data->expected_fee = ceil($student->expected_fee);
//                     $expected_fee_data->student_id = $student->id;
//                     $expected_fee_data->student_name = $student->student_name;
//                     $expected_fee_data->color = 2;
//                     $expected_fee_data->unit = 'number';
//                     $data['expected_fee'][] = $expected_fee_data;

//                     $attendance_data = new \stdClass();
//                     $attendance_data->month_attendances = $student->expected_fee_duration;
//                     $attendance_data->color = 3;
//                     $attendance_data->student_id = $student->id;
//                     $attendance_data->student_name = $student->student_name;
//                     $attendance_data->unit = 'number';
//                     $data['attendances'][] = $attendance_data;

//                 }


//             }

//             return $this->sendResponse($data, 'response successful');

//         } else {
//             $data = array();
//             return $this->sendError('Login To View This Page with super admin/admin account');

// //                    return $this->sendResponse($data, 'Login To View This Page');
// //                    dd("Login To View This Page");
//         }


//     }


//    Voxly API's End

    public function index(Request $request)
    {

        $user = User::where('id', $request->id)->first();
        if (isset($user) && !empty($user) && $user->api_token == $request->api_token) {

            $data = array();

            $students = StudentAdmission::where('admission_no', '=', $user->admission_no)->where('is_active', 1)->get();

            $data['user'] = $user;
            $data['students'] = $students;

            return $this->sendResponse($data, 'response successful');

        } else {
            $data = array();
            return $this->sendError('Login To View This Page');

//                    return $this->sendResponse($data, 'Login To View This Page');
//                    dd("Login To View This Page");
        }


    }

    public function changePassword(Request $request)
    {


        $user = User::where('id', $request->id)->first();
        if (isset($user) && !empty($user) && $user->api_token == $request->api_token) {

            $user->password = Hash::make($request->password);
            $user->email =  $request->email;
            $user->is_changed_first_password =  1;
            $user->save();

            if($user->user_role == 'teacher'){
                $teacher = StaffTeacher::where('id', $user->admin_or_teacher_id)->first();
                $teacher->email =  $request->email;
                $teacher->save();

            }elseif($user->user_role == 'super_admin'){
                $admin = Admin::where('id', $user->admin_or_teacher_id)->first();
                $admin->email =  $request->email;
                $admin->save();

            }

            $data = array();



            return $this->sendResponse($data, 'Details changed successfully!');

        } else {
            $data = array();
            return $this->sendError('Login To View This Page');


        }


    }


    public function invoiceBillingLimitActivityView($user_id)
    {
        $teams = Team::where('leader_id', '=', $user_id)->get();
        if (($teams->isEmpty())) {
            dd("You are not leader");
        } else {
//            Billing transactions and billing balance
            foreach ($teams as $team) {
                $id = $team->id;
            }


            $invoice_billing = DB::select("select ia.item,ia.price,ia.qty, i.* from invoices as i inner join invoice_items as ia on i.id = ia.invoice_id where i.team_id = $id and i.wallet_type = 1 and i.is_active = 1 order by i.id desc limit 1 offset 0");


            return array($invoice_billing);

        }

    }


    public function invoiceBookingLimitActivityView($user_id)
    {
        $teams = Team::where('leader_id', '=', $user_id)->get();
        if (($teams->isEmpty())) {
            dd("You are not leader");
        } else {
//            Billing transactions and billing balance
            foreach ($teams as $team) {
                $id = $team->id;
            }

            $invoice_booking = DB::select("select ia.item,ia.price,ia.qty, i.* from invoices as i inner join invoice_items as ia on i.id = ia.invoice_id where i.team_id = $id and i.wallet_type = 2 and i.is_active = 1 order by i.id desc limit 2 offset 0");

            return array($invoice_booking);

        }

    }

    public function invoicePrintingLimitActivityView($user_id)
    {
        $teams = Team::where('leader_id', '=', $user_id)->get();
        if (($teams->isEmpty())) {
            dd("You are not leader");
        } else {
//            Billing transactions and billing balance
            foreach ($teams as $team) {
                $id = $team->id;
            }
            $invoice_printing = DB::select("select ia.item,ia.price,ia.qty, i.* from invoices as i inner join invoice_items as ia on i.id = ia.invoice_id where i.team_id = $id and i.wallet_type = 3 and i.is_active = 1 order by i.id desc limit 1 offset 0");

            return array($invoice_printing);
        }

    }

    public function wallet_balance_team_total($team_id)
    {
        $team = Team::where('id', '=', $team_id)->first();


//            Billing transactions and billing balance


        $transactions_billing = DB::select("select * from transactions where team_id = $team_id  and wallet_type = 1 and is_active = 1");

        $transaction_billing_credit = 0;
        $transaction_billing_free_credit = 0;
        $transaction_billing_debit = 0;
        $transaction_billing_free_debit = 0;
        foreach ($transactions_billing as $transaction_billing) {

            if ($transaction_billing->type == 1) {
                $transaction_billing_credit += $transaction_billing->amount;
            } elseif ($transaction_billing->type == 2) {
                $transaction_billing_debit += $transaction_billing->amount;
            }

        }
        $billing_balance = $transaction_billing_credit - $transaction_billing_debit;


//          Room booking balance and transactions
        $maxDays = date('t');
        $first_day_this_month = date('Y-m-01'); // hard-coded '01' for first day
        $last_day_this_month = date('Y-m-' . $maxDays);

        $transactions_booking_free = DB::select("select * from transactions where team_id = $team_id and payment_type = 2  and wallet_type = 2 and is_active = 1 and date(created_at) between '$first_day_this_month' and '$last_day_this_month'");
        $transactions_booking_cash = DB::select("select * from transactions where team_id = $team_id and payment_type != 2 and wallet_type = 2 and is_active = 1");

        $transaction_booking_credit = 0;
        $transaction_booking_free_credit = 0;
        $transaction_booking_debit = 0;
        $transaction_booking_free_debit = 0;
        foreach ($transactions_booking_free as $transaction_booking) {

            if ($transaction_booking->payment_type == 2 && $transaction_booking->type == 1) {
                $transaction_booking_free_credit += $transaction_booking->amount;
            } elseif ($transaction_booking->payment_type == 2 && $transaction_booking->type == 2) {
                $transaction_booking_free_debit += $transaction_booking->amount;
            }

        }
        foreach ($transactions_booking_cash as $transaction_booking) {

            if ($transaction_booking->type == 1) {
                $transaction_booking_credit += $transaction_booking->amount;
            } elseif ($transaction_booking->type == 2) {
                $transaction_booking_debit += $transaction_booking->amount;
            }

        }

        $booking_balance = $transaction_booking_credit - $transaction_booking_debit;
        $booking_free_balance = $transaction_booking_free_credit - $transaction_booking_free_debit;


        // Printing balance and transactions

        $transactions_printing_free = DB::select("select * from transactions where team_id = $team_id and payment_type = 2  and wallet_type = 3 and is_active = 1 and date(created_at) between '$first_day_this_month' and '$last_day_this_month'");
        $transactions_printing_cash = DB::select("select * from transactions where team_id = $team_id and payment_type != 2 and wallet_type = 3 and is_active = 1");
        $transaction_printing_credit = 0;
        $transaction_printing_free_credit = 0;
        $transaction_printing_debit = 0;
        $transaction_printing_free_debit = 0;

        foreach ($transactions_printing_free as $transaction_printing) {

            if ($transaction_printing->payment_type == 2 && $transaction_printing->type == 1) {
                $transaction_printing_free_credit += $transaction_printing->amount;
            } elseif ($transaction_printing->payment_type == 2 && $transaction_printing->type == 2) {
                $transaction_printing_free_debit += $transaction_printing->amount;
            }

        }
        foreach ($transactions_printing_cash as $transaction_printing) {

            if ($transaction_printing->type == 1) {
                $transaction_printing_credit += $transaction_printing->amount;
            } elseif ($transaction_printing->type == 2) {
                $transaction_printing_debit += $transaction_printing->amount;
            }

        }


        $printing_balance = $transaction_printing_credit - $transaction_printing_debit;
        $printing_free_balance = $transaction_printing_free_credit - $transaction_printing_free_debit;


//            $uri = $request->path();
//            if ($uri == "walletBilling") {
//                return view('wallet_billing', compact('transactions_billing', 'billing_balance', 'booking_balance', 'printing_balance','booking_free_balance','printing_free_balance'));
//

        return array($billing_balance, $booking_balance, $booking_free_balance, $printing_balance, $printing_free_balance);


    }


    public function calculate_all_dues_single_team($team_id)
    {


        $team = Team::find($team_id);
//        $users_transaction_data = DB::select("select * from transactions where team_id = $team_id and is_active = 1");

        $users = array();
        $dues_billing = array();
        $dues_room = array();
        $dues_printing = array();
        $i = 0;
        $user_invoices_data = Array();
//        foreach ($users_transaction_data as $data) {
        $user_invoices = DB::select("select  * from invoices where team_id = $team_id  and is_active = 1");
        if (!Empty($user_invoices)) {
            $user_invoices_data = array_values($user_invoices);

        }
        $i++;
//        }
        $a = 0;
        $invoice_transaction_remaining = 0;
        foreach ($user_invoices_data as $key => $invoice) {

            $transaction = DB::select("select  * from transactions where invoice_id = $invoice->id and wallet_type = $invoice->wallet_type and is_active = 1");
            $invoice_transaction_billing_sum = 0;
            $invoice_transaction_room_sum = 0;
            $invoice_transaction_printing_sum = 0;

//          calculate all dues of one user according to wallet_type and add it to dues array
//            print_r($invoice->id);echo "<br>";
            if (!empty($transaction)) {
                $single_invoice_transaction = array_values($transaction);
                foreach ($single_invoice_transaction as $invoice_transaction) {

                    if ($invoice_transaction->invoice_id == $invoice->id && $invoice_transaction->wallet_type == $invoice->wallet_type) {
                        if ($invoice->wallet_type == 1) {
                            $invoice_transaction_billing_sum += $invoice_transaction->amount;

                        } elseif ($invoice->wallet_type == 2) {
                            $invoice_transaction_room_sum += $invoice_transaction->amount;


                        } elseif ($invoice->wallet_type == 3) {
                            $invoice_transaction_printing_sum += $invoice_transaction->amount;

                        }

                    }

                }

                if ($invoice->wallet_type == 1) {
                    if (!($invoice_transaction_billing_sum == $invoice->total)) {
                        $invoice_transaction_billing_remaining = $invoice->total - $invoice_transaction_billing_sum;
                        $user_invoices_data[$key]->dues = $invoice_transaction_billing_remaining;
                        $dues_billing[] = $invoice;
                    }

                } elseif ($invoice->wallet_type == 2) {
                    if (!($invoice_transaction_room_sum == $invoice->total)) {
// check if discount >0 (invoice generate against free credit for room booking then do nothing because invoice is auto paid for booking from monthly free printing credit
//its different scenario from billing because room booking and printing has monthly free credit for residents
                        if ($invoice->discount_amount > 0) {

                        } // else add remaining dues in dues array
                        else {
                            $invoice_transaction_room_remaining = $invoice->total - $invoice_transaction_room_sum;
                            $user_invoices_data[$key]->dues = $invoice_transaction_room_remaining;
                            $dues_room[] = $invoice;
                        }
                    }

                } elseif ($invoice->wallet_type == 3) {

                    if (!($invoice_transaction_printing_sum == $invoice->total)) {
// check if discount >0 (invoice generate against free credit for printing then do nothing because invoice is auto paid for printing from monthly free printing credit
                        if ($invoice->discount > 0) {
                        } // else add remaining dues in dues array
                        else {
                            $invoice_transaction_printing_remaining = $invoice->total - $invoice_transaction_printing_sum;
                            $user_invoices_data[$key]->dues = $invoice_transaction_printing_remaining;
                            $dues_printing[] = $invoice;
                        }


                    }

                }

            } else {

                if ($invoice->wallet_type == 1) {
                    $dues_billing[] = $invoice;

                } elseif ($invoice->wallet_type == 2) {
                    $dues_room[] = $invoice;

                } elseif ($invoice->wallet_type == 3) {
                    $dues_printing[] = $invoice;

                }

            }
        }
        $billing_dues_total_amount = 0;
        $booking_dues_total_amount = 0;
        $printing_dues_total_amount = 0;

        if (isset($dues_billing) && !empty($dues_billing)) {
            foreach ($dues_billing as $billing) {
                if (isset($billing->dues) && $billing->dues > 0) {
                    $billing_dues_total_amount += $billing->dues;
                } elseif (isset($billing->total) && !empty($billing->total)) {
                    $billing_dues_total_amount += $billing->total;

                }

            }

        }

        if (isset($dues_room) && !empty($dues_room)) {
            foreach ($dues_room as $booking) {
                if (isset($booking->dues) && $booking->dues > 0) {
                    $booking_dues_total_amount += $booking->dues;
                } elseif (isset($booking->total) && !empty($booking->total)) {
                    $booking_dues_total_amount += $booking->total;

                }

            }

        }


        if (isset($dues_printing) && !empty($dues_printing)) {
            foreach ($dues_printing as $printing) {
                if (isset($printing->dues) && $printing->dues > 0) {
                    $printing_dues_total_amount += $printing->dues;
                } elseif (isset($printing->total) && !empty($printing->total)) {
                    $printing_dues_total_amount += $printing->total;

                }

            }

        }


        return array($billing_dues_total_amount, $booking_dues_total_amount, $printing_dues_total_amount);


    }


    public function TeamMemberById()
    {
        $user = User::where('id', $_GET['id'])->first();
        if (isset($user) && !empty($user) && $user->api_token == $_GET['api_token']) {
            $selected_team_member = User::where('id', $_GET['member_id'])->first();


            if ($selected_team_member->type == 1) {
                $selected_team_member->designation = 'Team Lead';
            } else {
                $selected_team_member->designation = 'Member';
            }

            if ($selected_team_member->status == 1 && $selected_team_member->is_active == 1) {
                $selected_team_member->member_status = 'Active';

            } elseif ($selected_team_member->status == 0 && $selected_team_member->is_active == 1) {
                $selected_team_member->member_status = 'Not Active';

            } elseif ($selected_team_member->status == 1 && $selected_team_member->is_active == 0) {
                $selected_team_member->member_status = 'Deleted';

            }

            $data = array();

            $data['team_member'] = $selected_team_member;

            return $this->sendResponse($data, 'response successful');


        } else {
            return $this->sendError('Wrong id/Api token');

        }
    }


    public function team_view_for_leader(Request $request)
    {

        $user = User::where('id', $request->id)->first();
        if (isset($user) && !empty($user) && $user->api_token == $request->api_token) {
            $team = Team::where('leader_id', $request->id)->first();
            if (!empty($team)) {
                $team_members = User::where('team_id', $team->id)->get();
                $team_members[] = $user;
                foreach ($team_members as $key => $team_member) {
                    if ($team_member->type == 1) {
                        $team_members[$key]->designation = 'Team Lead';
                    } else {
                        $team_members[$key]->designation = 'Member';
                    }

                    if ($team_member->status == 1 && $team_member->is_active == 1) {
                        $team_members[$key]->member_status = 'Active';

                    } elseif ($team_member->status == 0 && $team_member->is_active == 1) {
                        $team_members[$key]->member_status = 'Not Active';

                    } elseif ($team_member->status == 1 && $team_member->is_active == 0) {
                        $team_members[$key]->member_status = 'Deleted';

                    }
                }

                $data = array();
                $data['team'] = $team;
                $data['team_members'] = $team_members;

                return $this->sendResponse($data, 'response successful');

            } else {
                return $this->sendError('Access Denied, You are not team lead');

            }
        } else {
            return $this->sendError('Wrong id/Api token');

        }


    }

    public function BookingDetailById()
    {
        $user = User::where('id', $_GET['id'])->first();
        if (isset($user) && !empty($user) && $user->api_token == $_GET['api_token']) {


            $booking_detail = Booking::where('id', $_GET['booking_id'])->first();
            $asset = Asset::where('id', $booking_detail->asset_id)->first();


            $branch = Branch::where('id', $booking_detail->branch_id)->first();
            $booking_detail->branch_name = $branch->name;
            $booking_detail->asset_name = $asset->name;
            $booking_detail->booking_date = date('d M Y', strtotime($booking_detail->booking_date));


            return $this->sendResponse($booking_detail, 'response successful');
        } else {
            return $this->sendError('Wrong id/Api token');

        }
    }

    public function getBookingAssetsByBranch()
    {

        $user = User::where('id', $_GET['id'])->first();
        if (isset($user) && !empty($user) && $user->api_token == $_GET['api_token']) {
            $assets = Asset::where('bookable', '=', 1)->where('branch_id', $_GET['branch_id'])->get()->all();

            $team = Team::where('leader_id', $_GET['id'])->first();
            if (isset($team) && !empty($team)) {
                $team_id = $team->id;
            } else {
                $team_id = Team::where('id', $user->team_id)->first();
                $team_id = $team_id->id;

            }


            $maxDays = date('t');
            $first_day_this_month = date('Y-m-01'); // hard-coded '01' for first day
            $last_day_this_month = date('Y-m-' . $maxDays);

            $get_team_all_free_booking_credit = DB::select("select * from transactions where team_id = $team_id and type = 1 and payment_type = 2 and wallet_type = 2 and is_active = 1 and date(created_at) between '$first_day_this_month' and '$last_day_this_month'");
            $get_team_all_free_booking_debit = DB::select("select * from transactions where team_id = $team_id and type = 2 and payment_type = 2 and wallet_type = 2 and is_active = 1 and date(created_at) between '$first_day_this_month' and '$last_day_this_month'");

            $free_room_credit_sum = 0;
            $free_room_debit_sum = 0;
            $free_room_balance = 0;
            foreach ($get_team_all_free_booking_credit as $free_credit) {
                $free_booking_credit_expiry_time = date('m', strtotime($free_credit->updated_at));
                $now = time();
                $now = date('m', $now);
                if ($free_booking_credit_expiry_time >= $now) {
                    $free_room_credit_sum += $free_credit->amount;
                }
            }
            foreach ($get_team_all_free_booking_debit as $free_debit) {
                $free_booking_debit_expiry_time = date('m', strtotime($free_debit->updated_at));
                $now = time();
                $now = date('m', $now);
                if ($free_booking_debit_expiry_time >= $now) {
                    $free_room_debit_sum += $free_debit->amount;
                }
            }
            $free_room_balance = $free_room_credit_sum - $free_room_debit_sum;
// calculate all cash paid balance of specific team_id

            $get_team_all_cash_booking_credit = DB::select("select * from transactions where team_id = $team_id and type = 1 and payment_type != 2 and wallet_type = 2 and is_active = 1");
            $get_team_all_cash_booking_debit = DB::select("select * from transactions where team_id = $team_id and type = 2 and payment_type != 2 and wallet_type = 2 and is_active = 1");

            $cash_room_credit_sum = 0;
            $cash_room_debit_sum = 0;
            $cash_room_balance = 0;
            foreach ($get_team_all_cash_booking_credit as $cash_credit) {
                $cash_room_credit_sum += $cash_credit->amount;
            }
            foreach ($get_team_all_cash_booking_debit as $cash_debit) {
                $cash_room_debit_sum += $cash_debit->amount;
            }
            $cash_room_balance = $cash_room_credit_sum - $cash_room_debit_sum;


            $balance = $free_room_balance + $cash_room_balance;


            $date = date('Y-m-d', strtotime($_GET['date']));
            $asset_final = array();
            foreach ($assets as $key => $asset) {
                $bookings = Booking::where('booking_date', $date)->where('asset_id', $asset->id)->get();
                //   return response()->json(['bookings'=>$booking,'assetDetail'=>$assetDetail],500);


                $current_date = date('Y-m-d');
                $get_str_date = date("d-m-Y", strtotime($current_date)); //convert db date in 'y m d' format
                $current_time = strtotime($get_str_date) + (60 * 60 * 9); //(add 39 = 24+15)current day 15pm because when start bidding of car it adds 15 hrs automatically in it.
                $current_time = date("H:i:s", $current_time); //get time in format 2018 07 12 12:00:00
                $start_time = $current_time;
                $timeFrom = array();
                $i = 0;
                $j = 0;
                while (true) {
                    $timeFrom[$i] = date("H:i:s", strtotime($start_time) + (60 * 60 * $j / 2));
                    if ($timeFrom[$i] == "19:30:00") {
                        break;
                    }
                    ++$i;
                    $j++;

                }

                $k = 0;
                $totalcount = count($timeFrom);
                $totalcount = $totalcount - 1;
//        print_r($totalcount);die;
                foreach ($bookings as $booking) {

                    foreach ($timeFrom as $key => $time_f) {
                        if ($time_f == $booking->book_from) {
                            $kk = $key;
                            while ($timeFrom[$kk] != $booking->book_to && $timeFrom[$kk] != 'Not Free') {

                                $timeFrom[$kk] = 'Not Free';
                                if ($kk < $totalcount) {
                                    $kk++;
                                } else {
                                    break;
                                }

                            }

                            break;
                        }
                    }

                }

                $asset_object = new \stdClass();
                $asset_object->id = $asset->id;
                $asset_object->name = $asset->name;
                $asset_object->price = $asset->price;
                $asset_object->branch_id = $asset->branch_id;
                $asset_object->time_from = $timeFrom;
                $asset_final[] = $asset_object;
//    $assets[$key]->time_from = $timeFrom;


            }


            return response()->json(['assets' => $asset_final, 'team_balance' => $balance]);
        } else {
            return $this->sendError('Wrong id/Api token');

        }


    }


    public function timeTo()
    {
        $user = User::where('id', $_GET['id'])->first();
        if (isset($user) && !empty($user) && $user->api_token == $_GET['api_token']) {

            $timeFrom_value = $_GET['timeFrom'];
            $date = date('Y-m-d', strtotime($_GET['date']));
            $asset = $_GET['asset_id'];

            $bookings = Booking::where('booking_date', $date)->where('asset_id', $asset)->get();
            $current_date = date('Y-m-d');
            $get_str_date = date("d-m-Y", strtotime($current_date)); //convert db date in 'y m d' format
            $current_time = strtotime($get_str_date) + (60 * 60 * 9); //(add 39 = 24+15)current day 15pm because when start bidding of car it adds 15 hrs automatically in it.
            $current_time = date("H:i:s", $current_time); //get time in format 2018 07 12 12:00:00
            $start_time = $current_time;
            $timeFrom = array();
            $i = 0;
            $j = 0;
            while (true) {
                $timeFrom[$i] = date("H:i:s", strtotime($start_time) + (60 * 60 * $j / 2));
                if ($timeFrom[$i] == "19:30:00") {
                    break;
                }
                ++$i;
                $j++;

            }
            $k = 0;
            foreach ($bookings as $booking) {

                foreach ($timeFrom as $key => $time_f) {
                    if ($time_f == $booking->book_from) {
                        if ($timeFrom[$k] != $booking->book_to) {

                        }
                        $timeFrom[$key] = 'Not Free';

                    }

                }

            }

            $timeTo = array();
            $i = 0;
            $j = 0;
            $l = 0;
            $l = array_search($timeFrom_value, $timeFrom);
            $stop = sizeof($timeFrom);
//        print_r($l);echo"br";print_r($stop);die;
            while (true) {

                if ($l > $stop || $timeFrom_value == 'Not Free') {
                    break;
                } else {
                    $timeTo[$i] = date("H:i:s", strtotime($timeFrom_value) + (60 * 60 * $j / 2));

                }
                if (isset($timeFrom[$l]) && $timeFrom[$l] == "Not Free" || $l > $stop) {
                    break;
                } else {
                    $timeTo[$i] = date("H:i:s", strtotime($timeFrom_value) + (60 * 60 * $j / 2));

                }

                $i++;
                $j++;
                $l++;

            }

            $date = array();
            $data['timeTo'][] = $timeTo;
            $data['reserveMessage'] = "Sorry You cannot perform booking please top up your booking wallet.Note: Reserved booking will valid within current day till before 1 hour of booking time in case of no payment.";

            return $this->sendResponse($data, 'response successful');
        } else {
            return $this->sendError('Wrong id/Api token');

        }
    }


    public function addBooking(Request $request)
    {
        $user = User::where('id', $request->id)->first();
        if (isset($user) && !empty($user) && $user->api_token == $request->api_token) {
            $team = Team::where('leader_id', $user->id)->first();
            if (!empty($team)) {

            } else {
                $team = Team::where('id', $user->team_id)->first();

            }
            $asset_detail = Asset::find($request->asset);
            $user = User::find($request->id);
            $booking = new Booking;
            $booking->asset_id = $request->asset;
            $booking->book_from = $request->book_from;
            $booking->book_to = $request->book_to;
            $booking->status = 0;
            $booking->team_id = $team->id;
            $booking->branch_id = $asset_detail->branch_id;
            $booking->booking_date = date('Y-m-d', strtotime($request->booking_date));
            $booking->invoice_id = 0;
            $booking->is_reserve = 0;


            if ($booking->save()) {
                $this->sendNotificationBooking($user->id, $booking->branch_id, $booking->team_id, $booking->asset_id);
                $this->sendNotificationBookingAdmin($user->id, $booking->branch_id, $booking->team_id, $booking->asset_id);
                $user_id = $request->id;
                $this->AddToLog($user_id, "Booking for team $booking->team_id and branch $booking->branch_id with booking id $booking->id successful");

                $this->confirm_room_booking($user_id, $team->id, $request->totalPrice, $request->asset, $booking->id);
                $data = array();
                return $this->sendResponse($data, 'booking added successfully');

            }
            return $this->sendError('Error occurred in adding booking');

        } else {
            return $this->sendError('Wrong id/Api token');

        }
    }


    public function confirm_room_booking($user_id, $team_id, $selected_asset_price, $asset_id, $booking_id)
    {
// calculate all free balance of specific team_id
        $team = Team::find($team_id);
        $get_team_all_free_booking_credit = DB::select("select * from transactions where team_id = $team_id and type = 1 and payment_type = 2 and wallet_type = 2 and is_active = 1");
        $get_team_all_free_booking_debit = DB::select("select * from transactions where team_id = $team_id and type = 2 and payment_type = 2 and wallet_type = 2 and is_active = 1");
        $free_room_credit_sum = 0;
        $free_room_credit_transaction_id = 0;
        $free_room_debit_sum = 0;
        $free_room_balance = 0;
        foreach ($get_team_all_free_booking_credit as $free_credit) {

            $free_booking_credit_expiry_time = date('m', strtotime($free_credit->updated_at));

            $now = time();
            $now = date('m', $now);
            if ($free_booking_credit_expiry_time == $now) {
                $free_room_credit_sum += $free_credit->amount;
                $free_room_credit_transaction_id = $free_credit->id;
            }
        }
        foreach ($get_team_all_free_booking_debit as $free_debit) {

            $free_booking_debit_expiry_time = date('m', strtotime($free_debit->updated_at));
            $now = time();
            $now = date('m', $now);
            if ($free_booking_debit_expiry_time == $now) {
                $free_room_debit_sum += $free_debit->amount;
            }
        }
        $free_room_balance = $free_room_credit_sum - $free_room_debit_sum;
// calculate all cash paid balance of specific team_id
        $get_team_all_cash_booking_credit = DB::select("select * from transactions where team_id = $team_id and type = 1 and payment_type != 2 and wallet_type = 2 and is_active = 1");
        $get_team_all_cash_booking_debit = DB::select("select * from transactions where team_id = $team_id and type = 2 and payment_type != 2 and wallet_type = 2 and is_active = 1");
        $cash_room_credit_sum = 0;
        $cash_room_credit_transaction_id = "";
        $cash_room_debit_sum = 0;
        $cash_room_balance = 0;
        foreach ($get_team_all_cash_booking_credit as $key => $cash_credit_all) {
            $get_team_single_cash_booking_debit = DB::select("select * from transactions where credit_transaction_id = $cash_credit_all->id and is_active = 1");
            $cash_debit_sum_single = 0;
            $cash_remaining_single = 0;
            if ($get_team_single_cash_booking_debit) {
                foreach ($get_team_single_cash_booking_debit as $single_cash_debit) {
                    $cash_debit_sum_single += $single_cash_debit->amount;
                }
                if ($cash_credit_all->amount > $cash_debit_sum_single) {
                    $cash_remaining_single = $cash_credit_all->amount - $cash_debit_sum_single;
                }

                $get_team_all_cash_booking_credit[$key]->remaining_credit = $cash_remaining_single;
            }

            $cash_room_credit_sum += $cash_credit_all->amount;
        }

        foreach ($get_team_all_cash_booking_debit as $cash_debit) {
            $cash_room_debit_sum += $cash_debit->amount;
        }
        $cash_room_balance = $cash_room_credit_sum - $cash_room_debit_sum;
        if ($free_room_balance > 0) {
            if ($free_room_balance >= $selected_asset_price) {
                $invoice_booking = new Invoice();

                $nowDate = date('d-m-Y');
                $invoice_date = date('d-m-Y', strtotime($nowDate));
                $due_date = strtotime($invoice_date) + (60 * 60 * 24) * (5);

                $invoice_due_date = date("d-m-Y", $due_date);

                $invoice_booking->invoice_date = $invoice_date;
                $invoice_booking->invoice_due_date = $invoice_due_date;

                $invoice_booking->amount = $selected_asset_price;
                $invoice_booking->branch_id = $team->branch_id;
                $invoice_booking->booking_id = $booking_id;

                $invoice_booking->bill_to_name = $team->user_leader->name;
                $invoice_booking->bill_to_address = $team->user_leader->address;
                $invoice_booking->team_id = $team_id;
                $invoice_booking->tax = 0;
                $invoice_booking->wallet_type = 2;
                $invoice_booking->discount_amount = $selected_asset_price;
                $invoice_booking->discount = 0;
                $invoice_booking->description = "Auto generated invoice for booking";
                $invoice_booking->total = 0;
                if ($invoice_booking->save()) {
                    $this->AddToLog($user_id, "Auto generated invoice# $invoice_booking->id for booking of  $team->name Created successfully");


                    $asset = Asset::find($asset_id);

                    $invoice_item = new InvoiceItem();
                    $invoice_item->team_id = $invoice_booking->team_id;
                    $invoice_item->branch_id = $team->branch_id;
                    $invoice_item->invoice_id = $invoice_booking->id;
                    $invoice_item->item = $asset->name;
                    $invoice_item->qty = 1;
                    $invoice_item->price = $asset->price;
                    $invoice_item->total = $asset->price;
                    $invoice_item->is_active = 1;
                    $invoice_item->save();

                    $booking = Booking::find($booking_id);
                    $booking->invoice_id = $invoice_booking->id;
                    $booking->save();


                    //                send invoice to user as email code
                    $invoice_email = new ContractController();
                    $invoice_email->sendInvoice($invoice_booking->id);

//


                    $transaction_booking = new Transaction();
                    $transaction_date = date('Y-m-d');
                    $transaction_booking->transaction_date = $transaction_date;
                    $transaction_booking->admin_id = 0;
                    $transaction_booking->team_id = $invoice_booking->team_id;
                    $transaction_booking->branch_id = $team->branch_id;
                    $transaction_booking->booking_id = $booking_id;
                    $transaction_booking->invoice_id = $invoice_booking->id;
                    $transaction_booking->wallet_type = $invoice_booking->wallet_type;
                    $transaction_booking->amount = $invoice_booking->discount_amount;
                    $transaction_booking->credit_transaction_id = $free_room_credit_transaction_id;
                    $transaction_booking->note = "Auto generated transaction for booking";
                    $transaction_booking->type = 2;
                    $transaction_booking->payment_type = 2;
                    $transaction_booking->save();
                    $this->AddToLog($user_id, "Auto generated transaction for invoice# $transaction_booking->invoice_id for booking of  $team->name Created successfully");

                }
            } elseif ($free_room_balance < $selected_asset_price) {
                $asset_invoice_price = $selected_asset_price - $free_room_balance;
                if ($cash_room_balance > 0 && $cash_room_balance >= $asset_invoice_price) {
                    $invoice_booking = new Invoice();

                    $nowDate = date('d-m-Y');
                    $invoice_date = date('d-m-Y', strtotime($nowDate));
                    $due_date = strtotime($invoice_date) + (60 * 60 * 24) * (5);

                    $invoice_due_date = date("d-m-Y", $due_date);

                    $invoice_booking->invoice_date = $invoice_date;
                    $invoice_booking->invoice_due_date = $invoice_due_date;

                    $invoice_booking->amount = $free_room_balance;
                    $invoice_booking->branch_id = $team->branch_id;
                    $invoice_booking->booking_id = $booking_id;
                    $invoice_booking->team_id = $team_id;
                    $invoice_booking->bill_to_name = $team->user_leader->name;
                    $invoice_booking->bill_to_address = $team->user_leader->address;
                    $invoice_booking->tax = 0;
                    $invoice_booking->wallet_type = 2;
                    $invoice_booking->discount_amount = $free_room_balance;
                    $invoice_booking->discount = 0;
                    $invoice_booking->description = "Auto generated invoice for booking";
                    $invoice_booking->total = 0;
                    if ($invoice_booking->save()) {
                        $this->AddToLog($user_id, "Auto generated invoice# $invoice_booking->id for booking of  $team->name Created successfully");


                        $asset = Asset::find($asset_id);

                        $invoice_item = new InvoiceItem();
                        $invoice_item->team_id = $invoice_booking->team_id;
                        $invoice_item->branch_id = $team->branch_id;
                        $invoice_item->invoice_id = $invoice_booking->id;
                        $invoice_item->item = $asset->name;
                        $invoice_item->qty = 1;
                        $invoice_item->price = $asset->price;
                        $invoice_item->total = $free_room_balance;
                        $invoice_item->is_active = 1;
                        $invoice_item->save();

                        //                send invoice to user as email code
                        $invoice_email = new ContractController();
                        $invoice_email->sendInvoice($invoice_booking->id);

//

                        $transaction_booking = new Transaction();
                        $transaction_date = date('Y-m-d');
                        $transaction_booking->transaction_date = $transaction_date;
                        $transaction_booking->admin_id = 0;
                        $transaction_booking->team_id = $invoice_booking->team_id;
                        $transaction_booking->branch_id = $team->branch_id;
                        $transaction_booking->booking_id = $booking_id;
                        $transaction_booking->invoice_id = $invoice_booking->id;
                        $transaction_booking->wallet_type = $invoice_booking->wallet_type;
                        $transaction_booking->amount = $invoice_booking->discount_amount;
                        $transaction_booking->credit_transaction_id = $free_room_credit_transaction_id;
                        $transaction_booking->note = "Auto generated transaction for booking";
                        $transaction_booking->type = 2;
                        $transaction_booking->payment_type = 2;
                        $transaction_booking->save();
                        $this->AddToLog($user_id, "Auto generated transaction for invoice# $transaction_booking->invoice_id for booking of  $team->name Created successfully");

                        $invoice_booking_partial = new Invoice();

                        $nowDate = date('d-m-Y');
                        $invoice_date = date('d-m-Y', strtotime($nowDate));
                        $due_date = strtotime($invoice_date) + (60 * 60 * 24) * (5);

                        $invoice_due_date = date("d-m-Y", $due_date);

                        $invoice_booking_partial->invoice_date = $invoice_date;
                        $invoice_booking_partial->invoice_due_date = $invoice_due_date;

                        $invoice_booking_partial->bill_to_name = $team->user_leader->name;
                        $invoice_booking_partial->bill_to_address = $team->user_leader->address;
                        $invoice_booking_partial->amount = $asset_invoice_price;
                        $invoice_booking_partial->branch_id = $team->branch_id;
                        $invoice_booking_partial->booking_id = $booking_id;
                        $invoice_booking_partial->team_id = $team_id;
                        $invoice_booking_partial->tax = 0;
                        $invoice_booking_partial->wallet_type = 2;
                        $invoice_booking_partial->discount = 0;
                        $invoice_booking_partial->description = "Auto generated invoice for booking";
                        $invoice_booking_partial->total = $asset_invoice_price;
                        if ($invoice_booking_partial->save()) {
                            $this->AddToLog($user_id, "Auto generated invoice# $invoice_booking_partial->id for booking of  $team->name Created successfully");

                            $asset = Asset::find($asset_id);

                            $invoice_partial_booking_item = new InvoiceItem();
                            $invoice_partial_booking_item->team_id = $invoice_booking_partial->team_id;
                            $invoice_partial_booking_item->branch_id = $team->branch_id;
                            $invoice_partial_booking_item->invoice_id = $invoice_booking_partial->id;
                            $invoice_partial_booking_item->item = $asset->name;
                            $invoice_partial_booking_item->qty = 1;
                            $invoice_partial_booking_item->price = $asset->price;
                            $invoice_partial_booking_item->total = $asset_invoice_price;
                            $invoice_partial_booking_item->is_active = 1;
                            $invoice_partial_booking_item->save();

                            //                send invoice to user as email code
                            $invoice_email = new ContractController();
                            $invoice_email->sendInvoice($invoice_booking_partial->id);

//


                            $asset_invoice_price_remaining = 0;
                            foreach ($get_team_all_cash_booking_credit as $remaining_balance_transaction) {
                                if (!empty($remaining_balance_transaction->remaining_credit) && $remaining_balance_transaction->remaining_credit > 0) {
                                    if ($remaining_balance_transaction->remaining_credit >= $asset_invoice_price) {
                                        $full_transaction_booking = new Transaction();
                                        $transaction_date = date('Y-m-d');
                                        $full_transaction_booking->transaction_date = $transaction_date;
                                        $full_transaction_booking->admin_id = 0;
                                        $full_transaction_booking->team_id = $invoice_booking_partial->team_id;
                                        $full_transaction_booking->branch_id = $team->branch_id;
                                        $full_transaction_booking->booking_id = $booking_id;
                                        $full_transaction_booking->invoice_id = $invoice_booking_partial->id;
                                        $full_transaction_booking->wallet_type = $invoice_booking_partial->wallet_type;
                                        $full_transaction_booking->amount = $asset_invoice_price;
                                        $full_transaction_booking->credit_transaction_id = $remaining_balance_transaction->id;
                                        $full_transaction_booking->note = "Auto generated transaction for booking";
                                        $full_transaction_booking->type = 2;
                                        $full_transaction_booking->payment_type = 1;
                                        unset($get_team_all_cash_booking_credit[$key]->remaining_credit);
                                        $full_transaction_booking->save();
                                        $this->AddToLog($user_id, "Auto generated transaction for invoice# $full_transaction_booking->invoice_id for booking of  $team->name Created successfully");

                                    } else {
                                        $asset_invoice_price_remaining = $asset_invoice_price - $remaining_balance_transaction->remaining_credit;
                                        $partial_transaction_booking = new Transaction();
                                        $transaction_date = date('Y-m-d');
                                        $partial_transaction_booking->transaction_date = $transaction_date;
                                        $partial_transaction_booking->admin_id = 0;
                                        $partial_transaction_booking->team_id = $invoice_booking_partial->team_id;
                                        $partial_transaction_booking->branch_id = $team->branch_id;
                                        $partial_transaction_booking->booking_id = $booking_id;
                                        $partial_transaction_booking->invoice_id = $invoice_booking_partial->id;
                                        $partial_transaction_booking->wallet_type = $invoice_booking_partial->wallet_type;
                                        $partial_transaction_booking->amount = $remaining_balance_transaction->remaining_credit;
                                        $partial_transaction_booking->credit_transaction_id = $remaining_balance_transaction->id;
                                        $partial_transaction_booking->note = "Auto generated transaction for booking";
                                        $partial_transaction_booking->type = 2;
                                        $partial_transaction_booking->payment_type = 1;
                                        unset($get_team_all_cash_booking_credit[$key]->remaining_credit);
                                        $partial_transaction_booking->save();
                                        $this->AddToLog($user_id, "Auto generated transaction for invoice# $partial_transaction_booking->invoice_id for booking of  $team->name Created successfully");

                                    }

                                } elseif (!empty($asset_invoice_price_remaining) && $asset_invoice_price_remaining > 0) {

                                    if ($remaining_balance_transaction->amount >= $asset_invoice_price_remaining) {
                                        $transaction_booking1 = new Transaction();
                                        $transaction_date = date('Y-m-d');
                                        $transaction_booking1->transaction_date = $transaction_date;
                                        $transaction_booking1->admin_id = 0;
                                        $transaction_booking1->team_id = $invoice_booking_partial->team_id;
                                        $transaction_booking1->branch_id = $team->branch_id;
                                        $transaction_booking1->booking_id = $booking_id;
                                        $transaction_booking1->invoice_id = $invoice_booking_partial->id;
                                        $transaction_booking1->wallet_type = $invoice_booking_partial->wallet_type;
                                        $transaction_booking1->amount = $asset_invoice_price_remaining;
                                        $transaction_booking1->credit_transaction_id = $remaining_balance_transaction->id;
                                        $transaction_booking1->note = "Auto generated transaction for booking";
                                        $transaction_booking1->type = 2;
                                        $transaction_booking1->payment_type = 1;
                                        $transaction_booking1->save();
                                        $this->AddToLog($user_id, "Auto generated transaction for invoice# $transaction_booking1->invoice_id for booking of  $team->name Created successfully");

                                    }


                                } elseif (!empty($remaining_balance_transaction->amount) && $remaining_balance_transaction->amount > 0 && !isset($remaining_balance_transaction->remaining_credit)) {

                                    if ($remaining_balance_transaction->amount >= $asset_invoice_price) {
                                        $transaction_booking2 = new Transaction();
                                        $transaction_date = date('Y-m-d');
                                        $transaction_booking2->transaction_date = $transaction_date;
                                        $transaction_booking2->admin_id = 0;
                                        $transaction_booking2->team_id = $invoice_booking->team_id;
                                        $transaction_booking2->branch_id = $team->branch_id;
                                        $transaction_booking2->booking_id = $booking_id;
                                        $transaction_booking2->invoice_id = $invoice_booking_partial->id;
                                        $transaction_booking2->wallet_type = $invoice_booking_partial->wallet_type;
                                        $transaction_booking2->amount = $asset_invoice_price;
                                        $transaction_booking2->credit_transaction_id = $remaining_balance_transaction->id;
                                        $transaction_booking2->note = "Auto generated transaction for booking";
                                        $transaction_booking2->type = 2;
                                        $transaction_booking2->payment_type = 1;
                                        $transaction_booking2->save();
                                        $this->AddToLog($user_id, "Auto generated transaction for invoice# $transaction_booking2->invoice_id for booking of  $team->name Created successfully");

                                    } else {
                                        $asset_invoice_price_remaining = $asset_invoice_price - $remaining_balance_transaction->amount;

                                        $transaction_booking3 = new Transaction();
                                        $transaction_date = date('Y-m-d');
                                        $transaction_booking3->transaction_date = $transaction_date;
                                        $transaction_booking3->admin_id = 0;
                                        $transaction_booking3->team_id = $invoice_booking_partial->team_id;
                                        $transaction_booking3->branch_id = $team->branch_id;
                                        $transaction_booking3->booking_id = $booking_id;
                                        $transaction_booking3->invoice_id = $invoice_booking_partial->id;
                                        $transaction_booking3->wallet_type = $invoice_booking_partial->wallet_type;
                                        $transaction_booking3->amount = $remaining_balance_transaction->amount;
                                        $transaction_booking3->credit_transaction_id = $remaining_balance_transaction->id;
                                        $transaction_booking3->note = "Auto generated transaction for booking";
                                        $transaction_booking3->type = 2;
                                        $transaction_booking3->payment_type = 1;
                                        $transaction_booking3->save();
                                        $this->AddToLog($user_id, "Auto generated transaction for invoice# $transaction_booking3->invoice_id for booking of  $team->name Created successfully");

                                    }
                                }


                            }

                        }
                    }
                } else {
                    $error = "Not Enough Balance! Top up first";
                    echo $error;
                }
            }
        } elseif ($cash_room_balance > 0 && $cash_room_balance >= $selected_asset_price) {

            foreach ($get_team_all_cash_booking_credit as $key => $cash_credit_trans) {
                $get_team_single_cash_booking_debit = DB::select("select * from transactions where credit_transaction_id = $cash_credit_trans->id and is_active = 1");
                $cash_debit_sum_single = 0;
                $cash_remaining_single_trans = 0;
                if ($get_team_single_cash_booking_debit) {
                    foreach ($get_team_single_cash_booking_debit as $single_cash_debit) {
                        $cash_debit_sum_single += $single_cash_debit->amount;
                    }
                    if ($cash_credit_trans->amount > $cash_debit_sum_single) {
                        $cash_remaining_single_trans = $cash_credit_trans->amount - $cash_debit_sum_single;
                    }
                    $get_team_all_cash_booking_credit[$key]->remaining_credit_trans = $cash_remaining_single_trans;
                }

            }

//echo"<pre>";print_r($get_team_all_cash_booking_credit);die;

            $invoice_booking = new Invoice();


            $nowDate = date('d-m-Y');
            $invoice_date = date('d-m-Y', strtotime($nowDate));
            $due_date = strtotime($invoice_date) + (60 * 60 * 24) * (5);

            $invoice_due_date = date("d-m-Y", $due_date);

            $invoice_booking->invoice_date = $invoice_date;
            $invoice_booking->invoice_due_date = $invoice_due_date;

            $invoice_booking->amount = $selected_asset_price;
            $invoice_booking->branch_id = $team->branch_id;
            $invoice_booking->booking_id = $booking_id;
            $invoice_booking->team_id = $team_id;
            $invoice_booking->bill_to_name = $team->user_leader->name;
            $invoice_booking->bill_to_address = $team->user_leader->address;
            $invoice_booking->tax = 0;
            $invoice_booking->wallet_type = 2;
            $invoice_booking->discount = 0;
            $invoice_booking->description = "Auto generated invoice for booking";
            $invoice_booking->total = $selected_asset_price;
            if ($invoice_booking->save()) {
                $this->AddToLog($user_id, "Auto generated invoice# $invoice_booking->id for booking of  $team->name Created successfully");

                $asset = Asset::find($asset_id);

                $invoice_item = new InvoiceItem();
                $invoice_item->team_id = $invoice_booking->team_id;
                $invoice_item->branch_id = $team->branch_id;
                $invoice_item->invoice_id = $invoice_booking->id;
                $invoice_item->item = $asset->name;
                $invoice_item->qty = 1;
                $invoice_item->price = $asset->price;
                $invoice_item->total = $asset->price;
                $invoice_item->is_active = 1;
                $invoice_item->save();

                //                send invoice to user as email code
                $invoice_email = new ContractController();
                $invoice_email->sendInvoice($invoice_booking->id);

//

                $asset_invoice_price_remaining = 0;
                foreach ($get_team_all_cash_booking_credit as $key => $remaining_balance_transaction) {
                    if (!empty($remaining_balance_transaction->remaining_credit_trans) && $remaining_balance_transaction->remaining_credit_trans > 0) {
                        if ($remaining_balance_transaction->remaining_credit_trans >= $selected_asset_price) {
                            $transaction_booking4 = new Transaction();
                            $transaction_date = date('Y-m-d');
                            $transaction_booking4->transaction_date = $transaction_date;
                            $transaction_booking4->admin_id = 0;
                            $transaction_booking4->team_id = $invoice_booking->team_id;
                            $transaction_booking4->branch_id = $team->branch_id;
                            $transaction_booking4->booking_id = $booking_id;
                            $transaction_booking4->invoice_id = $invoice_booking->id;
                            $transaction_booking4->wallet_type = $invoice_booking->wallet_type;
                            $transaction_booking4->amount = $selected_asset_price;
                            $transaction_booking4->credit_transaction_id = $remaining_balance_transaction->id;
                            $transaction_booking4->note = "Auto generated transaction for booking";
                            $transaction_booking4->type = 2;
                            $transaction_booking4->payment_type = 1;
                            $get_team_all_cash_booking_credit[$key]->remaining_credit_trans = 0;
                            $get_team_all_cash_booking_credit[$key]->remaining_credit = 0;
                            $transaction_booking4->save();
                            $this->AddToLog($user_id, "Auto generated transaction for invoice# $transaction_booking4->invoice_id for booking of  $team->name Created successfully");

                        } else {
                            $asset_invoice_price_remaining = $selected_asset_price - $remaining_balance_transaction->remaining_credit_trans;
                            $transaction_booking5 = new Transaction();
                            $transaction_date = date('Y-m-d');
                            $transaction_booking5->transaction_date = $transaction_date;
                            $transaction_booking5->admin_id = 0;
                            $transaction_booking5->team_id = $invoice_booking->team_id;
                            $transaction_booking5->branch_id = $team->branch_id;
                            $transaction_booking5->booking_id = $booking_id;
                            $transaction_booking5->invoice_id = $invoice_booking->id;
                            $transaction_booking5->wallet_type = $invoice_booking->wallet_type;
                            $transaction_booking5->amount = $remaining_balance_transaction->remaining_credit_trans;
                            $transaction_booking5->credit_transaction_id = $remaining_balance_transaction->id;
                            $transaction_booking5->note = "Auto generated transaction for booking";
                            $transaction_booking5->type = 2;
                            $transaction_booking5->payment_type = 1;
                            $get_team_all_cash_booking_credit[$key]->remaining_credit_trans = 0;
                            $get_team_all_cash_booking_credit[$key]->remaining_credit = 0;
                            $transaction_booking5->save();
                            $this->AddToLog($user_id, "Auto generated transaction for invoice# $transaction_booking5->invoice_id for booking of  $team->name Created successfully");


                        }

                    } elseif (!empty($asset_invoice_price_remaining) && !isset($remaining_balance_transaction->remaining_credit_trans) && !isset($remaining_balance_transaction->remaining_credit)) {

                        if ($remaining_balance_transaction->amount >= $asset_invoice_price_remaining) {
                            $transaction_booking6 = new Transaction();
                            $transaction_date = date('Y-m-d');
                            $transaction_booking6->transaction_date = $transaction_date;
                            $transaction_booking6->admin_id = 0;
                            $transaction_booking6->team_id = $invoice_booking->team_id;
                            $transaction_booking6->branch_id = $team->branch_id;
                            $transaction_booking6->booking_id = $booking_id;
                            $transaction_booking6->invoice_id = $invoice_booking->id;
                            $transaction_booking6->wallet_type = $invoice_booking->wallet_type;
                            $transaction_booking6->amount = $asset_invoice_price_remaining;
                            $transaction_booking6->credit_transaction_id = $remaining_balance_transaction->id;
                            $transaction_booking6->note = "Auto generated transaction for booking";
                            $transaction_booking6->type = 2;
                            $transaction_booking6->payment_type = 1;
                            $asset_invoice_price_remaining -= $asset_invoice_price_remaining;

                            $transaction_booking6->save();
                            $this->AddToLog($user_id, "Auto generated transaction for invoice# $transaction_booking6->invoice_id for booking of  $team->name Created successfully");

                        } else {
                            $asset_invoice_price_remaining -= $remaining_balance_transaction->amount;
                            $transaction_booking7 = new Transaction();
                            $transaction_date = date('Y-m-d');
                            $transaction_booking7->transaction_date = $transaction_date;
                            $transaction_booking7->admin_id = 0;
                            $transaction_booking7->team_id = $invoice_booking->team_id;
                            $transaction_booking7->branch_id = $team->branch_id;
                            $transaction_booking7->booking_id = $booking_id;
                            $transaction_booking7->invoice_id = $invoice_booking->id;
                            $transaction_booking7->wallet_type = $invoice_booking->wallet_type;
                            $transaction_booking7->amount = $remaining_balance_transaction->amount;
                            $transaction_booking7->credit_transaction_id = $remaining_balance_transaction->id;
                            $transaction_booking7->note = "Auto generated transaction for booking";
                            $transaction_booking7->type = 2;
                            $transaction_booking7->payment_type = 1;
                            $transaction_booking7->save();
                            $this->AddToLog($user_id, "Auto generated transaction for invoice# $transaction_booking7->invoice_id for booking of  $team->name Created successfully");

                        }


                    } elseif (!empty($remaining_balance_transaction->amount) && !isset($remaining_balance_transaction->remaining_credit_trans) && !isset($remaining_balance_transaction->remaining_credit)) {

                        if ($remaining_balance_transaction->amount >= $selected_asset_price) {
                            $transaction_booking8 = new Transaction();
                            $transaction_date = date('Y-m-d');
                            $transaction_booking8->transaction_date = $transaction_date;
                            $transaction_booking8->admin_id = 0;
                            $transaction_booking8->team_id = $invoice_booking->team_id;
                            $transaction_booking8->branch_id = $team->branch_id;
                            $transaction_booking8->booking_id = $booking_id;
                            $transaction_booking8->invoice_id = $invoice_booking->id;
                            $transaction_booking8->wallet_type = $invoice_booking->wallet_type;
                            $transaction_booking8->amount = $selected_asset_price;
                            $transaction_booking8->credit_transaction_id = $remaining_balance_transaction->id;
                            $transaction_booking8->note = "Auto generated transaction for booking";
                            $transaction_booking8->type = 2;
                            $transaction_booking8->payment_type = 1;
                            $transaction_booking8->save();
                            $this->AddToLog($user_id, "Auto generated transaction for invoice# $transaction_booking8->invoice_id for booking of  $team->name Created successfully");

                        } else {
                            $asset_invoice_price_remaining = $selected_asset_price - $remaining_balance_transaction->amount;
                            $transaction_booking9 = new Transaction();
                            $transaction_date = date('Y-m-d');
                            $transaction_booking9->transaction_date = $transaction_date;
                            $transaction_booking9->admin_id = 0;
                            $transaction_booking9->team_id = $invoice_booking->team_id;
                            $transaction_booking9->branch_id = $team->branch_id;
                            $transaction_booking9->booking_id = $booking_id;
                            $transaction_booking9->invoice_id = $invoice_booking->id;
                            $transaction_booking9->wallet_type = $invoice_booking->wallet_type;
                            $transaction_booking9->amount = $remaining_balance_transaction->amount;
                            $transaction_booking9->credit_transaction_id = $remaining_balance_transaction->id;
                            $transaction_booking9->note = "Auto generated transaction for booking";
                            $transaction_booking9->type = 2;
                            $transaction_booking9->payment_type = 1;
                            $transaction_booking9->save();
                            $this->AddToLog($user_id, "Auto generated transaction for invoice# $transaction_booking9->invoice_id for booking of  $team->name Created successfully");

                        }

                    }


                }

            }
        } else {
            $error = "Not Enough Balance! Top up first";
            echo $error;
        }
//        echo "<pre> free ";
//        print_r($free_room_balance);
//        echo "<br>";
//        echo "<pre> cash ";
//        print_r($cash_room_balance);
//        echo "<br>";
//        die;
//        echo "<pre> transaction";
//        print_r($transaction_booking);
//        echo "<br>";
//        die;
    }

    //reserve booking
    public function reserveBooking(Request $request)
    {
        $user = User::where('id', $request->id)->first();
        $team = Team::where('leader_id', $request->id)->first();
        if (!empty($team)) {

        } else {
            $team = Team::where('id', $user->team_id)->first();

        }
        if (isset($user) && !empty($user) && $user->api_token == $request->api_token) {
            $targetted_time_str = strtotime($request->book_from) - (60 * 60 * 1);
            $time_limit = date("h:i:s:A", $targetted_time_str); //get time in format 2018 07 12 12:00:00


            $current_time = date('H:i:s');
            $current_time_str = strtotime($current_time);

//        dd($id);
            if ($targetted_time_str > $current_time_str) {
                $booking = new Booking;
                $booking->asset_id = $request->asset;
                $booking->book_from = $request->book_from;
                $booking->book_to = $request->book_to;
                $booking->status = 0;
                $booking->team_id = $team->id;
                $booking->branch_id = $user->branch_id;
                $booking->booking_date = date('Y-m-d', strtotime($request->booking_date));
                $booking->is_reserve = 1;
                $invoice_booking = new Invoice();

                $nowDate = date('d-m-Y');
                $invoice_date = date('d-m-Y', strtotime($nowDate));
                $due_date = strtotime($invoice_date) + (60 * 60 * 24) * (5);

                $invoice_due_date = date("d-m-Y", $due_date);

                $invoice_booking->invoice_date = $invoice_date;
                $invoice_booking->invoice_due_date = $invoice_due_date;

                $invoice_booking->amount = $request->totalPrice;
                $invoice_booking->branch_id = $team->branch_id;

                $invoice_booking->bill_to_name = $team->user_leader->name;
                $invoice_booking->bill_to_address = $team->user_leader->address;
                $invoice_booking->team_id = $team->id;
                $invoice_booking->tax = 0;
                $invoice_booking->wallet_type = 2;
                $invoice_booking->discount_amount = 0;
                $invoice_booking->discount = 0;
                $invoice_booking->description = "Auto generated invoice for reserve booking and will valid before . $time_limit.  if not paid ";
                $invoice_booking->total = $request->totalPrice;
                if ($invoice_booking->save()) {
                    $booking->invoice_id = $invoice_booking->id;
                    $booking->save();

                    $this->sendNotificationAdminReserved($team->leader_id, $booking->id);
                    $this->sendNotificationTeamLeadReserved($team->leader_id, $booking->id);
                    $this->AddToLog($user->id, "Booking id $booking->id for team id $booking->team_id of branch $booking->branch_id reserved successfully");


                    $invoice_booking->booking_id = $booking->id;
                    $invoice_booking->save();
                    $asset = Asset::find($request->asset);

                    $invoice_item = new InvoiceItem();
                    $invoice_item->team_id = $invoice_booking->team_id;
                    $invoice_item->branch_id = $team->branch_id;
                    $invoice_item->invoice_id = $invoice_booking->id;
                    $invoice_item->item = $asset->name;
                    $invoice_item->qty = 1;
                    $invoice_item->price = $asset->price;
                    $invoice_item->total = $asset->price;
                    $invoice_item->is_active = 1;
                    $invoice_item->save();


                    //                send invoice to user as email code
                    $invoice_email = new ContractController();
                    $invoice_email->sendInvoice($invoice_booking->id);

                    // send notification

                }

//                $this->confirm_room_booking($request->team, $request->totalPrice, $request->asset);
                $data = array();
                return $this->sendResponse($data, 'booking reserved successfully');


            } else {
                return $this->sendError('Booking can be reserved only before 65 minutes or more of booking time');

            }

            return $this->sendResponse($data, 'response successful');
        } else {
            return $this->sendError('Wrong id/Api token');

        }

    }

    //show booking group leader
    public function showBookings()
    {
        $user = User::where('id', $_GET['id'])->first();
        if (isset($user) && !empty($user) && $user->api_token == $_GET['api_token']) {
            $team = Team::where('leader_id', '=', $_GET['id'])->first();
            if (isset($team) && !empty($team)) {
                $date = time();
                $current_date = date('Y-m-d', $date);
                $bookings = Booking::where('team_id', $team->id)
                    ->orderBy('id', 'desc')->take(5)->get();
                foreach ($bookings as $key => $booking) {
                    $bookings[$key]->month = date('M', strtotime($booking->booking_date));
                    $bookings[$key]->montDate = date('d', strtotime($booking->booking_date));

                    $asset = Asset::find($booking->asset_id);
                    $branch = Branch::find($asset->branch_id);
                    if (isset($branch) && !empty($branch)) {
                        $bookings[$key]->booking_branch_name = $branch->name;
                    }
                    if (isset($asset) && !empty($asset)) {
                        $bookings[$key]->asset_name = $asset->name;
                        $bookings[$key]->asset_price = $asset->price;

                    }
                }

            } else {
                $user = User::where('id', $_GET['id'])->where('use_leader_wallet', 1)->first();
                $team = Team::where('id', '=', $user->team_id)->first();

                $date = time();
                $current_date = date('Y-m-d', $date);
                $bookings = Booking::where('team_id', $team->id)
                    ->orderBy('id', 'desc')->take(5)->get();
                foreach ($bookings as $key => $booking) {
                    $bookings[$key]->month = date('M', strtotime($booking->booking_date));
                    $bookings[$key]->montDate = date('d', strtotime($booking->booking_date));


                    $asset = Asset::find($booking->asset_id);
                    $branch = Branch::find($asset->branch_id);
                    if (isset($branch) && !empty($branch)) {
                        $bookings[$key]->booking_branch_name = $branch->name;
                    }
                    if (isset($asset) && !empty($asset)) {
                        $bookings[$key]->asset_name = $asset->name;
                        $bookings[$key]->asset_price = $asset->price;

                    }
                }
            }


            return $this->sendResponse($bookings, 'response successful');
        } else {
            return $this->sendError('Wrong id/Api token');

        }
    }

    public function showBookingMore()
    {

        $user = User::where('id', $_GET['id'])->first();
        if (isset($user) && !empty($user) && $user->api_token == $_GET['api_token']) {
            $team = Team::where('leader_id', '=', $_GET['id'])->first();
            if (isset($team) && !empty($team)) {
                $date = time();
                $current_date = date('Y-m-d', $date);

                if (isset($_GET['offset']) && $_GET['offset'] > 0) {
                    $skip = $_GET['offset'];

                } else {
                    $skip = 0;
                }

                $bookings = Booking::where('team_id', $team->id)
                    ->orderBy('id', 'desc')->skip($skip)->take(5)->get();
                foreach ($bookings as $key => $booking) {

                    $bookings[$key]->month = date('M', strtotime($booking->booking_date));
                    $bookings[$key]->montDate = date('d', strtotime($booking->booking_date));

                    $asset = Asset::find($booking->asset_id);
                    $branch = Branch::find($asset->branch_id);
                    if (isset($branch) && !empty($branch)) {
                        $bookings[$key]->booking_branch_name = $branch->name;
                    }
                    if (isset($asset) && !empty($asset)) {
                        $bookings[$key]->asset_name = $asset->name;
                        $bookings[$key]->asset_price = $asset->price;

                    }
                }

            } else {
                $user = User::where('id', $_GET['id'])->where('use_leader_wallet', 1)->first();
                $team = Team::where('id', '=', $user->team_id)->first();

                $date = time();
                $current_date = date('Y-m-d', $date);
                if (isset($_GET['offset']) && $_GET['offset'] > 0) {
                    $skip = $_GET['offset'];

                } else {
                    $skip = 0;
                }


                $bookings = Booking::where('team_id', $team->id)
                    ->orderBy('id', 'desc')->skip($skip)->take(5)->get();
                foreach ($bookings as $key => $booking) {

                    $bookings[$key]->month = date('M', strtotime($booking->booking_date));
                    $bookings[$key]->montDate = date('d', strtotime($booking->booking_date));

                    $asset = Asset::find($booking->asset_id);
                    $branch = Branch::find($asset->branch_id);
                    if (isset($branch) && !empty($branch)) {
                        $bookings[$key]->booking_branch_name = $branch->name;
                    }
                    if (isset($asset) && !empty($asset)) {
                        $bookings[$key]->asset_name = $asset->name;
                        $bookings[$key]->asset_price = $asset->price;

                    }
                }
            }

            $data = array();
            $data['bookings'] = $bookings;
            if ($skip == 0) {
                $data['offset'] = 5;

            } else {
                $data['offset'] = $skip + 5;

            }
            return $this->sendResponse($data, 'response successful');
        } else {
            return $this->sendError('Wrong id/Api token');

        }
    }

/////////////////////////////Guests Start//////////////////////////////////////////////////////////////////////

    public function showGuests()
    {
        $user = User::where('id', $_GET['id'])->first();
        if (isset($user) && !empty($user) && $user->api_token == $_GET['api_token']) {
            $team = Team::where('leader_id', '=', $_GET['id'])->first();
            if (isset($team) && !empty($team)) {
                $date = time();
                $current_date = date('Y-m-d', $date);
                $guests = TeamGuest::where('team_id', $team->id)
                    ->orderBy('id', 'desc')->take(5)->get();
                foreach ($guests as $key => $guest) {

                    $guests[$key]->month = date('M', strtotime($guest->arrival_date));
                    $guests[$key]->montDate = date('d', strtotime($guest->arrival_date));

                    if ($guest->guest_pass == 1) {
                        $guests[$key]->guest_status = 'Arrived';
                    } elseif ($guest->guest_pass == 0) {
                        $guests[$key]->guest_status = 'Not Arrived';

                    }

                }

            } else {
                $user = User::where('id', $_GET['id'])->where('use_leader_wallet', 1)->first();
                $team = Team::where('id', '=', $user->team_id)->first();

                $date = time();
                $current_date = date('Y-m-d', $date);
                $guests = TeamGuest::where('team_id', $team->id)
                    ->orderBy('id', 'desc')->take(5)->get();

                foreach ($guests as $key => $guest) {

                    $guests[$key]->month = date('M', strtotime($guest->arrival_date));
                    $guests[$key]->montDate = date('d', strtotime($guest->arrival_date));

                    if ($guest->guest_pass == 1) {
                        $guests[$key]->guest_status = 'Arrived';
                    } elseif ($guest->guest_pass == 0) {
                        $guests[$key]->guest_status = 'Not Arrived';

                    }

                }


            }


            $current_date = date('Y-m-d');
            $get_str_date = date("d-m-Y", strtotime($current_date)); //convert db date in 'y m d' format
            $current_time = strtotime($get_str_date) + (60 * 60 * 9); //(add 39 = 24+15)current day 15pm because when start bidding of car it adds 15 hrs automatically in it.
            $current_time = date("H:i:s", $current_time); //get time in format 2018 07 12 12:00:00
            $start_time = $current_time;
            $timeFrom = array();
            $i = 0;
            $j = 0;
            while (true) {
                $timeFrom[$i] = date("H:i:s", strtotime($start_time) + (60 * 60 * $j / 2));
                if ($timeFrom[$i] == "20:30:00") {
                    break;
                }
                ++$i;
                $j++;

            }

            $data = array();
            $data['guests'] = [$guests];
            $data['timeFrom'] = [$timeFrom];

            return $this->sendResponse($data, 'response successful');
        } else {
            return $this->sendError('Wrong id/Api token');

        }
    }

    public function showGuestMore()
    {
        $user = User::where('id', $_GET['id'])->first();
        if (isset($user) && !empty($user) && $user->api_token == $_GET['api_token']) {
            $team = Team::where('leader_id', '=', $_GET['id'])->first();
            if (isset($team) && !empty($team)) {
                $date = time();
                $current_date = date('Y-m-d', $date);
                if (isset($_GET['offset']) && $_GET['offset'] > 0) {
                    $skip = $_GET['offset'];

                } else {
                    $skip = 0;
                }

                $guests = TeamGuest::where('team_id', $team->id)
                    ->orderBy('id', 'desc')->skip($skip)->take(5)->get();
                foreach ($guests as $key => $guest) {

                    $guests[$key]->month = date('M', strtotime($guest->arrival_date));
                    $guests[$key]->montDate = date('d', strtotime($guest->arrival_date));

                    if ($guest->guest_pass == 1) {
                        $guests[$key]->guest_status = 'Arrived';
                    } elseif ($guest->guest_pass == 0) {
                        $guests[$key]->guest_status = 'Not Arrived';

                    }

                }

            } else {
                $user = User::where('id', $_GET['id'])->where('use_leader_wallet', 1)->first();
                $team = Team::where('id', '=', $user->team_id)->first();

                $date = time();
                $current_date = date('Y-m-d', $date);
                if (isset($_GET['offset']) && $_GET['offset'] > 0) {
                    $skip = $_GET['offset'];

                } else {
                    $skip = 0;
                }

                $guests = TeamGuest::where('team_id', $team->id)
                    ->orderBy('id', 'desc')->skip($skip)->take(5)->get();
                foreach ($guests as $key => $guest) {

                    $guests[$key]->month = date('M', strtotime($guest->arrival_date));
                    $guests[$key]->montDate = date('d', strtotime($guest->arrival_date));

                    if ($guest->guest_pass == 1) {
                        $guests[$key]->guest_status = 'Arrived';
                    } elseif ($guest->guest_pass == 0) {
                        $guests[$key]->guest_status = 'Not Arrived';

                    }

                }

            }
            $data = array();
            if ($skip == 0) {
                $data['offset'] = 5;

            } else {
                $data['offset'] = $skip + 5;

            }
            $data['guests'] = $guests;
            return $this->sendResponse($data, 'response successful');
        } else {

            return $this->sendError('Wrong id/Api token');

        }
    }

    public function guestTimeTo(Request $request)
    {

        $user = User::where('id', $_GET['id'])->first();
        if (isset($user) && !empty($user) && $user->api_token == $_GET['api_token']) {
            $timeFrom_value = $request->timeFrom;
            $date = date('Y-m-d', strtotime($request->date));
//            print_r($timeFrom_value);die;

            $current_date = date('Y-m-d');
            $get_str_date = date("d-m-Y", strtotime($current_date)); //convert db date in 'y m d' format
            $current_time = strtotime($get_str_date) + (60 * 60 * 9); //(add 39 = 24+15)current day 15pm because when start bidding of car it adds 15 hrs automatically in it.
            $current_time = date("H:i:s", $current_time); //get time in format 2018 07 12 12:00:00
            $start_time = $current_time;
            $timeFrom = array();
            $i = 0;
            $j = 0;
            while (true) {
                $timeFrom[$i] = date("H:i:s", strtotime($start_time) + (60 * 60 * $j / 2));
                if ($timeFrom[$i] == "20:30:00") {
                    break;
                }
                ++$i;
                $j++;

            }


            $timeTo = array();
            $i = 0;
            $j = 0;
            $l = 0;
            $l = array_search($timeFrom_value, $timeFrom);
            $stop = sizeof($timeFrom);
            //return response()->json($stop);

            while (true) {

                $timeTo[$i] = date("H:i:s", strtotime($timeFrom_value) + (60 * 60 * $j / 2));
                if ($l == $stop) {
                    break;
                }
                if ($timeFrom[$l] == "Not Free") {
                    break;
                }

                $i++;
                $j++;
                $l++;

            }

            $data['timeTo'] = $timeTo;

            return $this->sendResponse($data, 'response successful');
        } else {
            return $this->sendError('Wrong id/Api token');

        }


    }

    public function insert_guest(Request $request)
    {
//        $team_id = User::where('id', $request->team_id)->first();

        $team = Team::where('id', $request->team_id)->first();
        $user = User::where('id', $request->id)->first();
        if (isset($user) && !empty($user) && $user->api_token == $request->api_token) {

            $current_date = date('Y-m-d');
            $get_str_date_start = strtotime($current_date) + (60 * 60 * 0);
            $get_str_date_end = strtotime($current_date) + (60 * 60 * 23.99);

            $start_time = date("Y-m-d H:i:s", $get_str_date_start); //get time in format 2018 07 12 12:00:00
            $end_time = date("Y-m-d H:i:s", $get_str_date_end); //get time in format 2018 07 12 12:00:00

            $team_guests_count = DB::select("select  count(*) as guests_count from team_guests where team_id = $team->id and date(created_at) between '$start_time' and '$end_time'");

            $guests_count = 0;
            foreach ($team_guests_count as $count) {
                $guests_count = $count->guests_count;
            }

            if (isset($guests_count) && !empty($guests_count)) {

                $guests_count = $guests_count + 1;
                if ($guests_count <= $team->guests_per_day) {
                    $guest = new TeamGuest();

                    $guest->guest_name = $request->name;
                    $guest->email = $request->email;
                    $guest->team_id = $team->id;
                    $guest->branch_id = $team->branch_id;
                    $guest->time_from = date('H:i:s', strtotime($request->time_from));
                    $guest->time_to = date('H:i:s', strtotime($request->time_to));
                    $guest->contact_number = $request->contact_number;
                    $guest->arrival_date = date('Y-m-d', strtotime($request->visitor_date));

                    if ($guest->save()) {
                        $this->sendNotification($user->id, $guest->team_id, $guest->guest_name);

                        $this->AddToLog($user->id, "Guest $guest->guest_name for team id $guest->team_id created successfully");

                        $this->sendNotificationTeamLead($user->id, $guest->guest_name);
                        $data['msg'] = "Guest Added Successfully";
                        return $this->sendResponse($data, 'response successful');

                    } else {
                        $data['response'] = false;
                        return $this->sendResponse($data, "Guest Not Added");

                    }
                } else {
                    $data['response'] = false;
                    return $this->sendResponse($data, "Guests per  day limit exceeded, Please contact to admin");

                }
            } else {
                $team_guests = 0;
                $guest = new TeamGuest();
                $guest->guest_name = $request->name;
                $guest->email = $request->email;
                $guest->team_id = $team->id;
                $guest->branch_id = $team->branch_id;
                $guest->time_from = date('h:i:s', strtotime($request->time_from));
                $guest->time_to = date('h:i:s', strtotime($request->time_to));
                $guest->arrival_date = date('Y-m-d', strtotime($request->visitor_date));
                $guest->contact_number = $request->contact_number;
                if ($guest->save()) {

                    $this->sendNotification($user->id, $guest->team_id, $guest->guest_name);
                    $this->sendNotificationTeamLead($user->id, $guest->guest_name);
                    $this->AddToLog($user->id, "Guest $guest->guest_name for team id $guest->team_id created successfully");

                    $data['msg'] = "Guest Added Successfully";
                    return $this->sendResponse($data, 'response successful');

                } else {
                    $data['response'] = false;
                    return $this->sendResponse($data, "Guest Not Added");

                }
            }

        } else {
            return $this->sendError('Wrong id/Api token');

        }


    }

    public function editGuest()
    {


        $user = User::where('id', $_GET['id'])->first();
        if (isset($user) && !empty($user) && $user->api_token == $_GET['api_token']) {


            $guest = TeamGuest::find($_GET['guest_id']);

//            if($user->type == 1){
//                $branches = Branch::all();
//
//            }else{
//                $branches = Branch::where('id', '=', $user->branch_id)->get();
//
//            }

//            $teams = Team::where('branch_id',$guest->branch_id)->get();

            $current_date = date('Y-m-d');
            $get_str_date = date("d-m-Y", strtotime($current_date)); //convert db date in 'y m d' format
            $current_time = strtotime($get_str_date) + (60 * 60 * 9); //(add 39 = 24+15)current day 15pm because when start bidding of car it adds 15 hrs automatically in it.
            $current_time = date("H:i:s", $current_time); //get time in format 2018 07 12 12:00:00
            $start_time = $current_time;
            $timeFrom = array();
            $i = 0;
            $j = 0;
            while (true) {
                $timeFrom[$i] = date("H:i:s", strtotime($start_time) + (60 * 60 * $j / 2));
                if ($timeFrom[$i] == "20:30:00") {
                    break;
                }
                ++$i;
                $j++;

            }
            $data = array();
            $data['guest'] = $guest;
//            $data['branches'] = $branches;
//            $data['teams'] = $teams;
            $data['timeFrom'] = $timeFrom;

            return $this->sendResponse($data, 'response successful');
        } else {
            return $this->sendError('Wrong id/Api token');

        }

    }

    public function updateGuest(Request $request)
    {

        $user = User::where('id', $_POST['id'])->first();
        if (isset($user) && !empty($user) && $user->api_token == $_POST['api_token']) {

            $guest = TeamGuest::find($_POST['guest_id']);
            if (isset($guest) && $guest->guest_pass == 0) {
                $guest->guest_name = $request->name;
                $guest->time_from = date('H:i:s', strtotime($request->time_from));
                $guest->time_to = date('H:i:s', strtotime($request->time_to));
                $guest->contact_number = $request->contact_number;

                $guest->arrival_date = date('Y-m-d', strtotime($request->visitor_date));
                if ($guest->save()) {
                    $this->AddToLog($user->id, "Guest $guest->guest_name for team id $guest->team_id updated successfully");
                    $data['msg'] = 'Guest Updated Successfully';
                    return $this->sendResponse($data, 'response successful');


                } else {
                    $data['msg'] = 'Guest Not Updated';
                    return $this->sendResponse($data, 'response successful');
                }
            } else {
                $data['msg'] = 'Guest Cant Edit After Arrival';
                return $this->sendResponse($data, 'response successful');
            }


        } else {
            return $this->sendError('Wrong id/Api token');

        }


    }
/////////////////////////////Guests End//////////////////////////////////////////////////////////////////////

/////////////////////////////Support End//////////////////////////////////////////////////////////////////////


    public function showTicketById()
    {
        $user = User::where('id', $_GET['id'])->first();
        if (isset($user) && !empty($user) && $user->api_token == $_GET['api_token']) {


            $ticket = Ticket::where('id', $_GET['ticket_id'])->first();

            if ($ticket->status == 0) {
                $ticket->ticket_status = 'Open';
            } elseif ($ticket->status == 1) {
                $ticket->ticket_status = 'Active';

            } elseif ($ticket->status == 2) {
                $ticket->ticket_status = 'Resolved';

            } elseif ($ticket->status == 3) {
                $ticket->ticket_status = 'Closed';

            }

            $branch = Branch::where('id', $ticket->branch_id)->first();
            $ticket->branch_name = $branch->name;


            return $this->sendResponse($ticket, 'response successful');
        } else {
            return $this->sendError('Wrong id/Api token');

        }
    }

    public function showTickets()
    {
        $user = User::where('id', $_GET['id'])->first();
        if (isset($user) && !empty($user) && $user->api_token == $_GET['api_token']) {


            $tickets = Ticket::where('user_id', $user->id)
                ->orderBy('id', 'desc')->take(5)->get();
            foreach ($tickets as $key => $ticket) {
                if ($ticket->status == 0) {
                    $tickets[$key]->ticket_status = 'Open';
                } elseif ($ticket->status == 1) {
                    $tickets[$key]->ticket_status = 'Active';

                } elseif ($ticket->status == 2) {
                    $tickets[$key]->ticket_status = 'Resolved';

                } elseif ($ticket->status == 3) {
                    $tickets[$key]->ticket_status = 'Closed';

                }
                $ago = $this->time_elapsed_string($ticket->created_at);
                $tickets[$key]->ago = $ago;
                $branch = Branch::where('id', $ticket->branch_id)->first();
                $tickets[$key]->branch_name = $branch->name;

            }


            return $this->sendResponse($tickets, 'response successful');
        } else {
            return $this->sendError('Wrong id/Api token');

        }
    }

    function time_elapsed_string($datetime, $full = false)
    {
        $now = new \DateTime;
        $ago = new \DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }

    public function showTicketMore()
    {
        $user = User::where('id', $_GET['id'])->first();
        if (isset($user) && !empty($user) && $user->api_token == $_GET['api_token']) {

            if (isset($_GET['offset']) && $_GET['offset'] > 0) {
                $skip = $_GET['offset'];

            } else {
                $skip = 0;
            }

            $tickets = Ticket::where('user_id', $user->id)
                ->orderBy('id', 'desc')->skip($skip)->take(5)->get();
            foreach ($tickets as $key => $ticket) {
                if ($ticket->status == 0) {
                    $tickets[$key]->ticket_status = 'Open';
                } elseif ($ticket->status == 1) {
                    $tickets[$key]->ticket_status = 'Active';

                } elseif ($ticket->status == 2) {
                    $tickets[$key]->ticket_status = 'Resolved';

                } elseif ($ticket->status == 3) {
                    $tickets[$key]->ticket_status = 'Closed';

                }
                $ago = $this->time_elapsed_string($ticket->created_at);
                $tickets[$key]->ago = $ago;
                $branch = Branch::where('id', $ticket->branch_id)->first();
                $tickets[$key]->branch_name = $branch->name;

            }


            $data = array();
            if ($skip == 0) {
                $data['offset'] = 5;

            } else {
                $data['offset'] = $skip + 5;

            }
            $data['tickets'] = $tickets;


            return $this->sendResponse($data, 'response successful');
        } else {
            return $this->sendError('Wrong id/Api token');

        }
    }


/////////////////////////////Support End//////////////////////////////////////////////////////////////////////


/////////////////////////////Billing Start//////////////////////////////////////////////////////////////////////

    public function Billing()
    {
        $user = User::where('id', $_GET['id'])->first();
        if (isset($user) && !empty($user) && $user->api_token == $_GET['api_token']) {

            $team = Team::where('leader_id', '=', $user->id)->first();
            if (empty($team)) {
                dd("You are not leader");
            } else {
                $id = $team->id;

                list($transactions_wallet_billing) = $this->walletBillingLimitBillingView($user->id);

                list($transactions_wallet_booking) = $this->walletBookingLimitBillingView($user->id);

                list($transactions_wallet_printing) = $this->walletprintingLimitBillingView($user->id);

                $merge_billing_booking_printing = array_merge_recursive($transactions_wallet_billing, $transactions_wallet_printing, $transactions_wallet_booking);

                $data = array();

                $data['merge_billing_booking_printing'] = $merge_billing_booking_printing;


                list($billing_balance, $booking_balance, $booking_free_balance, $printing_balance, $printing_free_balance) = $this->wallet_balance_team_total($id);

                $team_balance = new \stdClass();
                $team_balance->billing_balance = $billing_balance;
                $team_balance->booking_free_balance = $booking_free_balance;
                $team_balance->booking_balance = $booking_balance;
                $team_balance->booking_balance_total = $booking_balance + $booking_free_balance;
                $team_balance->printing_balance = $printing_balance;
                $team_balance->printing_free_balance = $printing_free_balance;
                $team_balance->printing_balance_total = $printing_free_balance + $printing_balance;
                $data['team_balance'] = $team_balance;

//        get billing,printing,booking dues of single team

                list($billing_dues_total_amount, $booking_dues_total_amount, $printing_dues_total_amount) = $this->calculate_all_dues_single_team($id);

                $team_dues = new \stdClass();
                $team_dues->billing_dues_total_amount = $billing_dues_total_amount;
                $team_dues->booking_dues_total_amount = $booking_dues_total_amount;
                $team_dues->printing_dues_total_amount = $printing_dues_total_amount;

                $data['team_dues'] = $team_dues;


                list($invoices, $transactions_array) = $this->team_invoices($id);
                $data['invoices'] = $invoices;
//            $data['transactions_array'] = $transactions_array;

//      Get all transactions and invoices paid by it for single team

//            list($transaction_invoices_billing_array, $transactions_billing_credit) = $this->team_transactions($id, $request);
//            $data['transactions_billing_credit'] = $transactions_billing_credit;
//            $data['transaction_invoices_billing_array'] = $transaction_invoices_billing_array;
//
//
//
//            list($transaction_invoices_wallet_billing_array, $transactions_wallet_billing_credit) = $this->walletBillingLimit();
//            $data['transaction_invoices_wallet_billing_array'] = $transaction_invoices_wallet_billing_array;
//            $data['transactions_wallet_billing_credit'] = $transactions_wallet_billing_credit;
//
//
//            list($transactions_wallet_booking_credit, $transaction_invoices_wallet_booking_array) = $this->walletBoookingLimit();
//            $data['transaction_invoices_wallet_booking_array'] = $transaction_invoices_wallet_booking_array;
//            $data['transactions_wallet_booking_credit'] = $transactions_wallet_booking_credit;
//
//
//            list($transactions_wallet_printing_credit, $transaction_invoices_wallet_printing_array) = $this->walletPrintingLimit();
//            $data['transaction_invoices_wallet_printing_array'] = $transaction_invoices_wallet_printing_array;
//            $data['transactions_wallet_printing_credit'] = $transactions_wallet_printing_credit;

                $data['print_setting'] = Setting::where('for', 'printing')->where('setting_key', 'printing_page_price')->first();


//            echo"<pre>";print_r($transactions_array);die;print_r($data['result'] );die;
//            return view('finance', compact('', 'data', 'transactions_array'));

            }

            return $this->sendResponse($data, 'response successful');
        } else {
            return $this->sendError('Wrong id/Api token');

        }

    }


    public function walletBillingLimitBillingView($user_id)
    {
        $teams = Team::where('leader_id', '=', $user_id)->get();
        if (($teams->isEmpty())) {
            dd("You are not leader");
        } else {
//            Billing transactions and billing balance
            foreach ($teams as $team) {
                $id = $team->id;
            }


            $transactions_wallet_billing_credit = DB::select("select * from transactions where team_id = $id  and wallet_type = 1 and type = 1 and is_active = 1  order by id desc limit 1 offset 0");
            $transactions_wallet_billing_debit = DB::select("select * from transactions where team_id = $id  and wallet_type = 1 and type = 2 and is_active = 1  order by id desc limit 1 offset 0");
            $transactions_wallet_billing = array_merge($transactions_wallet_billing_credit, $transactions_wallet_billing_debit);

            foreach ($transactions_wallet_billing as $data => $transaction_billing) {

                if ($transaction_billing->payment_type == 1) {
                    $transaction_billing->payment_type = 'Cash';
                } elseif ($transaction_billing->payment_type == 2) {
                    $transaction_billing->payment_type = 'Free';

                } elseif ($transaction_billing->payment_type == 3) {
                    $transaction_billing->payment_type = 'Cheque';

                } elseif ($transaction_billing->payment_type == 4) {
                    $transaction_billing->payment_type = 'Withholding Challan';

                }


                if ($transaction_billing->wallet_type == 1) {
                    $transaction_billing->payment_for = 'Billing';
                    if ($transaction_billing->type == 1) {
                        $transaction_billing->parsed_id = 'PB-' . sprintf('%04d', $transaction_billing->id);

                    } elseif ($transaction_billing->type == 2) {
                        $transaction_billing->parsed_id = 'INV-B-' . sprintf('%04d', $transaction_billing->id);

                    }


                }

            }


            return array($transactions_wallet_billing);

        }

    }


    public function walletBookingLimitBillingView($user_id)
    {
        $teams = Team::where('leader_id', '=', $user_id)->get();
        if (($teams->isEmpty())) {
            dd("You are not leader");
        } else {
//            Billing transactions and billing balance
            foreach ($teams as $team) {
                $id = $team->id;
            }

            $transactions_wallet_booking_credit = DB::select("select * from transactions where team_id = $id  and wallet_type = 2 and type = 1 and is_active = 1  order by id desc limit 1 offset 0");
            $transactions_wallet_booking_debit = DB::select("select * from transactions where team_id = $id  and wallet_type = 2 and type = 2 and is_active = 1  order by id desc limit 1 offset 0");
            $transactions_wallet_booking = array_merge($transactions_wallet_booking_credit, $transactions_wallet_booking_debit);

            foreach ($transactions_wallet_booking as $data => $transaction_booking) {

                if ($transaction_booking->payment_type == 1) {
                    $transaction_booking->payment_type = 'Cash';
                } elseif ($transaction_booking->payment_type == 2) {
                    $transaction_booking->payment_type = 'Free';

                } elseif ($transaction_booking->payment_type == 3) {
                    $transaction_booking->payment_type = 'Cheque';

                } elseif ($transaction_booking->payment_type == 4) {
                    $transaction_booking->payment_type = 'Withholding Challan';

                }


                if ($transaction_booking->wallet_type == 2) {
                    $transaction_booking->payment_for = 'Booking';

                    if ($transaction_booking->type == 1) {
                        $transaction_booking->parsed_id = 'PR-' . sprintf('%04d', $transaction_booking->id);

                    } elseif ($transaction_booking->type == 2) {
                        $transaction_booking->parsed_id = 'INV-R-' . sprintf('%04d', $transaction_booking->id);

                    }

                }


            }


            return array($transactions_wallet_booking);

        }

    }

    public function walletPrintingLimitBillingView($user_id)
    {
        $teams = Team::where('leader_id', '=', $user_id)->get();
        if (($teams->isEmpty())) {
            dd("You are not leader");
        } else {
//            Billing transactions and billing balance
            foreach ($teams as $team) {
                $id = $team->id;
            }

            $transactions_wallet_printing_credit = DB::select("select * from transactions where team_id = $id  and wallet_type = 3 and type = 1 and is_active = 1  order by id desc limit 1 offset 0");
            $transactions_wallet_printing_debit = DB::select("select * from transactions where team_id = $id  and wallet_type = 3 and type = 2 and is_active = 1  order by id desc limit 1 offset 0");
            $transactions_wallet_printing = array_merge($transactions_wallet_printing_credit, $transactions_wallet_printing_debit);

            foreach ($transactions_wallet_printing as $data => $transaction_printing) {


                if ($transaction_printing->payment_type == 1) {
                    $transaction_printing->payment_type = 'Cash';
                } elseif ($transaction_printing->payment_type == 2) {
                    $transaction_printing->payment_type = 'Free';

                } elseif ($transaction_printing->payment_type == 3) {
                    $transaction_printing->payment_type = 'Cheque';

                } elseif ($transaction_printing->payment_type == 4) {
                    $transaction_printing->payment_type = 'Withholding Challan';

                }

                $transaction_printing->payment_for = 'Printing';

                if ($transaction_printing->wallet_type == 3) {
                    if ($transaction_printing->type == 1) {
                        $transaction_printing->parsed_id = 'PP-' . sprintf('%04d', $transaction_printing->id);

                    } elseif ($transaction_printing->type == 2) {
                        $transaction_printing->parsed_id = 'INV-P-' . sprintf('%04d', $transaction_printing->id);

                    }

                }


            }


            return array($transactions_wallet_printing);
        }

    }

    public function team_invoices($team_id)
    {

        $invoices = DB::select("select * from invoices where team_id = $team_id and is_active = 1 order by id desc limit 3 offset 0 ");


        $transactions_array = array();
        $transactions_data = array();
        $data = array();
        foreach ($invoices as $key => $invoice) {

            if ($invoice->wallet_type == 1) {

                $invoice->parsed_id = 'INV-B-' . sprintf('%04d', $invoice->id);

            } elseif ($invoice->wallet_type == 2) {

                $invoice->parsed_id = 'INV-R-' . sprintf('%04d', $invoice->id);

            } elseif ($invoice->wallet_type == 3) {

                $invoice->parsed_id = 'INV-P-' . sprintf('%04d', $invoice->id);

            }

            $transactions = DB::select("select * from transactions where invoice_id = $invoice->id and is_active = 1  limit 3 offset 0 ");

            $transaction_sum = 0;
            $transaction_sum_log = 0;
            $amount_due = 0;
            $x = 0;


            if (!empty($transactions)) {
                if (!empty($invoice->total)) {
                    foreach ($transactions as $transaction) {
                        $transaction_sum += $transaction->amount;
                    }
                    if ($transaction_sum == $invoice->total) {
                        $invoices[$key]->status = "paid";
                    } else {
                        $invoices[$key]->status = "outstanding";
                        $outstanding_amount = $invoice->total - $transaction_sum;
                        $invoices[$key]->outstanding_amount = $outstanding_amount;

                    }

                } elseif (!empty($invoice->discount_amount) && $invoice->total == 0) {
                    foreach ($transactions as $transaction) {
                        $transaction_sum += $transaction->amount;
                    }
                    if ($transaction_sum == $invoice->amount) {
                        $invoices[$key]->status = "paid";
                    } else {
                        $invoices[$key]->status = "Invalid Invoice";

                    }
                }
            } else {
                $invoices[$key]->status = "due";
                $due_amount = $invoice->total;
                $invoices[$key]->due_amount = $due_amount;

            }


            foreach ($transactions as $key => $transaction) {
                if ($invoice->total > 0) {
                    $transaction_sum_log += $transaction->amount;
                    $transactions[$key]->amount_remaining = $invoice->total - $transaction_sum_log;
                    if ($x >= 0) {
                        $transactions[$key]->amount_due = $invoice->total - $amount_due;
                    }
                    $x++;
                    $amount_due += $transaction->amount;
                } else {
                    $transaction_sum_log += $transaction->amount;

                    $transactions[$key]->amount_remaining = $invoice->amount - $transaction_sum_log;
                    if ($x >= 0) {
                        $transactions[$key]->amount_due = $invoice->amount - $amount_due;
                    }
                    $x++;
                    $amount_due += $transaction->amount;
                }
                $transactions_data = $transaction;
                $transactions_array[] = $transactions_data;


            }
            $data['invoices'] = $invoices;
            $data['result'] = $transactions_array;

        }


//            echo"<pre>";print_r($transactions_array);die;print_r($data['result'] );die;
        return array($invoices, $transactions_array);


    }

//used in all invoice report
    public function walletBillingLimit($team_id)
    {

        $id = $team_id;


        $transactions_wallet_billing_credit = DB::select("select * from transactions where team_id = $id  and wallet_type = 1 and type = 1 and is_active = 1  order by id desc limit 3 offset 0");

        $transaction_invoices = array();
        $transaction_invoices_wallet_billing_array = array();
        foreach ($transactions_wallet_billing_credit as $key => $transaction_printing) {

            if ($transaction_printing->wallet_type == 1) {

                $transaction_printing->parsed_id = 'PB-' . sprintf('%04d', $transaction_printing->id);

            }
            if ($transaction_printing->type == 1) {
                $transaction_printing->transaction_type = 'Payment';
            } elseif ($transaction_printing->type == 2) {
                $transaction_printing->transaction_type = 'Invoice #' . $transaction_printing->invoice_id;
            }

            $transactions = DB::select("select * from transactions where credit_transaction_id = $transaction_printing->id and is_active = 1");
            $transaction_sum = 0;
            $transaction_sum_log = 0;
            $amount_due = 0;
            $x = 0;
            $transaction_invoices = $transactions;
            $transaction_invoices_wallet_billing_array[] = $transaction_invoices;

        }
        if (!is_array($transaction_invoices_wallet_billing_array)) {
            return FALSE;
        }
        $result = array();
        foreach ($transaction_invoices_wallet_billing_array as $key => $value) {


            if (is_array($value)) {

                $result = array_merge($result, array_flatten($value));
            } else {

                $result[$key] = $value;
            }
        }


        $transaction_invoices_wallet_billing_array = $result;

        foreach ($transaction_invoices_wallet_billing_array as $key => $value) {
            if (!empty($value) && $value->wallet_type == 1) {

                $value->parsed_id = 'INV-B-' . sprintf('%04d', $value->invoice_id);

            }
            if (!empty($value->payment_type)) {
                if ($value->payment_type == 1) {

                    $value->payment_mode = 'Cash';

                } elseif ($value->payment_type == 2) {
                    $value->payment_mode = 'Free';

                } elseif ($value->payment_type == 3) {
                    $value->payment_mode = 'Cheque';

                } elseif ($value->payment_type == 4) {
                    $value->payment_mode = 'Withholding Challan';

                }
            }
        }


        return array($transaction_invoices_wallet_billing_array, $transactions_wallet_billing_credit);

    }

    public function walletBoookingLimit($team_id)
    {
        $id = $team_id;


        $transactions_wallet_booking_credit = DB::select("select * from transactions where team_id = $id  and wallet_type = 2 and type = 1 and is_active = 1 order by id desc limit 3 offset 0");

        $transaction_invoices = array();
        $transaction_invoices_wallet_booking_array = array();
        foreach ($transactions_wallet_booking_credit as $key => $transaction_booking) {

            if ($transaction_booking->wallet_type == 2) {

                $transaction_booking->parsed_id = 'PR-' . sprintf('%04d', $transaction_booking->id);

            }
            if ($transaction_booking->type == 1) {
                $transaction_booking->transaction_type = 'Payment';
            } elseif ($transaction_booking->type == 2) {
                $transaction_booking->transaction_type = 'Invoice #' . $transaction_booking->invoice_id;
            }

            $transactions = DB::select("select * from transactions where credit_transaction_id = $transaction_booking->id and is_active = 1");
            $transaction_sum = 0;
            $transaction_sum_log = 0;
            $amount_due = 0;
            $x = 0;
            $transaction_invoices = $transactions;
            $transaction_invoices_wallet_booking_array[] = $transaction_invoices;

        }
        if (!is_array($transaction_invoices_wallet_booking_array)) {
            return FALSE;
        }
        $result = array();
        foreach ($transaction_invoices_wallet_booking_array as $key => $value) {
            if (is_array($value)) {
                $result = array_merge($result, array_flatten($value));
            } else {

                $result[$key] = $value;
            }
        }


        $transaction_invoices_wallet_booking_array = $result;

        foreach ($transaction_invoices_wallet_booking_array as $key => $value) {
            if (!empty($value) && $value->wallet_type == 2) {

                $value->parsed_id = 'INV-R-' . sprintf('%04d', $value->invoice_id);

            }
            if (!empty($value->payment_type)) {
                if ($value->payment_type == 1) {

                    $value->payment_mode = 'Cash';

                } elseif ($value->payment_type == 2) {
                    $value->payment_mode = 'Free';

                } elseif ($value->payment_type == 3) {
                    $value->payment_mode = 'Cheque';

                } elseif ($value->payment_type == 4) {
                    $value->payment_mode = 'Withholding Challan';

                }
            }
        }


        return array($transactions_wallet_booking_credit, $transaction_invoices_wallet_booking_array);


    }


    public function walletPrintingLimit($team_id)
    {

        $id = $team_id;


        $transactions_wallet_printing_credit = DB::select("select * from transactions where team_id = $id  and wallet_type = 3 and type = 1 and is_active = 1 order by id desc limit 3 offset 0");

        $transaction_invoices = array();
        $transaction_invoices_wallet_printing_array = array();
        foreach ($transactions_wallet_printing_credit as $key => $transaction_printing) {

            if ($transaction_printing->wallet_type == 3) {

                $transaction_printing->parsed_id = 'PP-' . sprintf('%04d', $transaction_printing->id);

            }
            if ($transaction_printing->type == 1) {
                $transaction_printing->transaction_type = 'Payment';
            } elseif ($transaction_printing->type == 2) {
                $transaction_printing->transaction_type = 'Invoice #' . $transaction_printing->invoice_id;
            }

            $transactions = DB::select("select * from transactions where credit_transaction_id = $transaction_printing->id and is_active = 1 ");
            $transaction_sum = 0;
            $transaction_sum_log = 0;
            $amount_due = 0;
            $x = 0;
            $transaction_invoices = $transactions;
            $transaction_invoices_wallet_printing_array[] = $transaction_invoices;

        }
        if (!is_array($transaction_invoices_wallet_printing_array)) {
            return FALSE;
        }
        $result = array();
        foreach ($transaction_invoices_wallet_printing_array as $key => $value) {
            if (is_array($value)) {

                $result = array_merge($result, array_flatten($value));
            } else {
                $result[$key] = $value;
            }
        }


        $transaction_invoices_wallet_printing_array = $result;

        foreach ($transaction_invoices_wallet_printing_array as $key => $value) {
            if (!empty($value) && $value->wallet_type == 3) {

                $value->parsed_id = 'INV-P-' . sprintf('%04d', $value->invoice_id);

            }
            if (!empty($value->payment_type)) {
                if ($value->payment_type == 1) {

                    $value->payment_mode = 'Cash';

                } elseif ($value->payment_type == 2) {
                    $value->payment_mode = 'Free';

                } elseif ($value->payment_type == 3) {
                    $value->payment_mode = 'Cheque';

                } elseif ($value->payment_type == 4) {
                    $value->payment_mode = 'Withholding Challan';

                }
            }
        }


        return array($transactions_wallet_printing_credit, $transaction_invoices_wallet_printing_array);

    }


    public function allInvoicesReport()
    {
        $user = User::where('id', $_GET['id'])->first();
        if (isset($user) && !empty($user) && $user->api_token == $_GET['api_token']) {
            $teams = Team::where('leader_id', '=', $user->id)->get();
            if (($teams->isEmpty())) {
                dd("You are not leader");
            } else {
                foreach ($teams as $team) {
                    $id = $team->id;
                }


                $data = array();

                list($billing_balance, $booking_balance, $booking_free_balance, $printing_balance, $printing_free_balance) = $this->wallet_balance_team_total($id);

                $team_balance = new \stdClass();
                $team_balance->billing_balance = $billing_balance;
                $team_balance->booking_free_balance = $booking_free_balance;
                $team_balance->booking_balance = $booking_balance;
                $team_balance->booking_balance_total = $booking_balance + $booking_free_balance;
                $team_balance->printing_balance = $printing_balance;
                $team_balance->printing_free_balance = $printing_free_balance;
                $team_balance->printing_balance_total = $printing_free_balance + $printing_balance;


                $data['team_balance'] = $team_balance;

//        get billing,printing,booking dues of single team

                list($billing_dues_total_amount, $booking_dues_total_amount, $printing_dues_total_amount) = $this->calculate_all_dues_single_team($id);

                $team_dues = new \stdClass();
                $team_dues->billing_dues_total_amount = $billing_dues_total_amount;
                $team_dues->booking_dues_total_amount = $booking_dues_total_amount;
                $team_dues->printing_dues_total_amount = $printing_dues_total_amount;

                $data['team_dues'] = $team_dues;


//      Get all transactions and invoices paid by it for single team

//                list($transaction_invoices_billing_array, $transactions_billing_credit) = $this->team_transactions($id, $request);
//                $data['transactions_billing_credit'] = $transactions_billing_credit;
//                $data['transaction_invoices_billing_array'] = $transaction_invoices_billing_array;
//


                list($transaction_invoices_wallet_billing_array, $transactions_wallet_billing_credit) = $this->walletBillingLimit($id);
                $data['transaction_invoices_wallet_billing_array'] = $transaction_invoices_wallet_billing_array;
                $data['transactions_wallet_billing_credit'] = $transactions_wallet_billing_credit;


                list($transactions_wallet_booking_credit, $transaction_invoices_wallet_booking_array) = $this->walletBoookingLimit($id);
                $data['transaction_invoices_wallet_booking_array'] = $transaction_invoices_wallet_booking_array;
                $data['transactions_wallet_booking_credit'] = $transactions_wallet_booking_credit;


                list($transactions_wallet_printing_credit, $transaction_invoices_wallet_printing_array) = $this->walletPrintingLimit($id);
                $data['transaction_invoices_wallet_printing_array'] = $transaction_invoices_wallet_printing_array;
                $data['transactions_wallet_printing_credit'] = $transactions_wallet_printing_credit;
                $data['print_setting'] = Setting::where('for', 'printing')->where('setting_key', 'printing_page_price')->first();

            }

            return $this->sendResponse($data, 'response successful');
        } else {
            return $this->sendError('Wrong id/Api token');

        }


    }


    public function show()
    {

        $user = User::where('id', $_GET['id'])->first();
        if (isset($user) && !empty($user) && $user->api_token == $_GET['api_token']) {
            $data = array();
            $invoice = Invoice::where('id', $_GET['invoice_id'])->where('is_active', 1)->first();
            $invoice->amount_parsed = number_format($invoice->amount, 0);
            $invoice->tax_amount_parsed = number_format($invoice->tax_amount, 0);
            $invoice->total_parsed = number_format($invoice->total, 0);
            if ($invoice->wallet_type == 1) {

                $invoice->parsed_id = 'INV-B-' . sprintf('%04d', $invoice->id);

            } elseif ($invoice->wallet_type == 2) {

                $invoice->parsed_id = 'INV-R-' . sprintf('%04d', $invoice->id);

            } elseif ($invoice->wallet_type == 3) {

                $invoice->parsed_id = 'INV-P-' . sprintf('%04d', $invoice->id);

            }

            $invoice_items = InvoiceItem::where('invoice_id', $invoice->id)->where('is_active', 1)->get();
            foreach ($invoice_items as $invoice_item) {
                $invoice_item->price_parsed = number_format($invoice_item->price, 0);
                $invoice_item->total_parsed = number_format($invoice_item->total, 0);
            }
//        echo"<pre>";print_r($invoice_items);die;
            $team = Team::find($invoice->team_id);
            $team_leader = User::where('id', '=', $team->leader_id)->first();
            $transactions = Transaction::where('invoice_id', '=', $_GET['invoice_id'])->where('is_active', 1)->get();
            $transaction_sum = 0;
            $amount_due = 0;
            $x = 0;
            foreach ($transactions as $key => $transaction) {
                if ($transaction->wallet_type == 1) {

                    $transaction->parsed_id = 'PB-' . sprintf('%04d', $transaction->id);

                } elseif ($transaction->wallet_type == 2) {

                    $transaction->parsed_id = 'PR-' . sprintf('%04d', $transaction->id);

                } elseif ($transaction->wallet_type == 3) {

                    $transaction->parsed_id = 'PP-' . sprintf('%04d', $transaction->id);

                }

                if ($invoice->total > 0) {
                    $transaction_sum += $transaction->amount;
                    $transactions[$key]->amount_remaining = $invoice->total - $transaction_sum;
                    if ($x >= 0) {
                        $transactions[$key]->amount_due = $invoice->total - $amount_due;
                    }
                    $x++;
                    $amount_due += $transaction->amount;
                } else {
                    $transaction_sum += $transaction->amount;

                    $transactions[$key]->amount_remaining = $invoice->amount - $transaction_sum;
                    if ($x >= 0) {
                        $transactions[$key]->amount_due = $invoice->amount - $amount_due;
                    }
                    $x++;
                    $amount_due += $transaction->amount;
                }

                $transaction->amount_parsed = number_format($transaction->amount, 0);
                $transaction->amount_remaining_parsed = number_format($transaction->amount_remaining, 0);
                $transaction->amount_due_parsed = number_format($transaction->amount_due, 0);

            }

            $data['invoice'] = $invoice;
            $data['invoice_items'] = $invoice_items;
            $data['team'] = $team;
            $data['team_leader'] = $team_leader;
            $data['transactions'] = $transactions;

            return $this->sendResponse($data, 'response successful');
        } else {
            return $this->sendError('Wrong id/Api token');

        }


    }


    public function walletBillingMore()
    {

        $user = User::where('id', $_GET['id'])->first();
        if (isset($user) && !empty($user) && $user->api_token == $_GET['api_token']) {


            $teams = Team::where('leader_id', '=', $user->id)->get();
            if (($teams->isEmpty())) {
                dd("You are not leader");
            } else {
//            Billing transactions and billing balance
                foreach ($teams as $team) {
                    $id = $team->id;
                }

                if (isset($_GET['offset']) && $_GET['offset'] > 0) {
                    $skip = $_GET['offset'];

                } else {
                    $skip = 0;
                }
                $transactions_billing_credit = Transaction::where('team_id', $id)->where('wallet_type', 1)->where('type', 1)->where('is_active', 1)
                    ->orderBy('id', 'desc')->skip($skip)->take(5)->get();

//                $transactions_billing_credit = DB::select("select * from transactions where team_id = $id  and wallet_type = 1 and type = 1 and is_active = 1  order by id desc");

                $transaction_invoices = array();
                $transaction_invoices_billing_array = array();
                foreach ($transactions_billing_credit as $key => $transaction_printing) {

                    if ($transaction_printing->wallet_type == 1) {

                        $transaction_printing->parsed_id = 'PB-' . sprintf('%04d', $transaction_printing->id);

                    }
                    if ($transaction_printing->type == 1) {
                        $transaction_printing->transaction_type = 'Payment';
                    } elseif ($transaction_printing->type == 2) {
                        $transaction_printing->transaction_type = 'Invoice #' . $transaction_printing->invoice_id;
                    }


                    $transactions = DB::select("select * from transactions where credit_transaction_id = $transaction_printing->id and is_active = 1");
                    $transaction_sum = 0;
                    $transaction_sum_log = 0;
                    $amount_due = 0;
                    $x = 0;
                    $transaction_invoices = $transactions;
                    $transaction_invoices_billing_array[] = $transaction_invoices;

                }
                if (!is_array($transaction_invoices_billing_array)) {
                    return FALSE;
                }
                $result = array();
                foreach ($transaction_invoices_billing_array as $key => $value) {
                    if (is_array($value)) {
                        $result = array_merge($result, array_flatten($value));
                    } else {
                        $result[$key] = $value;
                    }
                }
                $transaction_invoices_billing_array = $result;

                foreach ($transaction_invoices_billing_array as $key => $value) {
                    if (!empty($value) && $value->wallet_type == 1) {

                        $value->parsed_id = 'INV-B-' . sprintf('%04d', $value->invoice_id);

                    }
                    if (!empty($value->payment_type)) {
                        if ($value->payment_type == 1) {

                            $value->payment_mode = 'Cash';

                        } elseif ($value->payment_type == 2) {
                            $value->payment_mode = 'Free';

                        } elseif ($value->payment_type == 3) {
                            $value->payment_mode = 'Cheque';

                        } elseif ($value->payment_type == 4) {
                            $value->payment_mode = 'Withholding Challan';

                        }
                    }
                }


                list($billing_balance, $booking_balance, $booking_free_balance, $printing_balance, $printing_free_balance) = $this->wallet_balance_team_total($id);

                $data = array();
                $data['billing_balance'] = $billing_balance;
                $data['booking_balance'] = $booking_balance;
                $data['printing_balance'] = $printing_balance;
                $data['booking_free_balance'] = $booking_free_balance;
                $data['printing_free_balance'] = $printing_free_balance;
                $data['transaction_invoices_billing_array'] = $transaction_invoices_billing_array;
                $data['transactions_billing_credit'] = $transactions_billing_credit;
                if ($skip == 0) {
                    $data['offset'] = 5;

                } else {
                    $data['offset'] = $skip + 5;

                }

            }


            return $this->sendResponse($data, 'response successful');
        } else {
            return $this->sendError('Wrong id/Api token');

        }


    }


    public function walletBookingMore()
    {

        $user = User::where('id', $_GET['id'])->first();
        if (isset($user) && !empty($user) && $user->api_token == $_GET['api_token']) {


            $teams = Team::where('leader_id', '=', $user->id)->get();
            if (($teams->isEmpty())) {
                dd("You are not leader");
            } else {
//            Billing transactions and billing balance
                foreach ($teams as $team) {
                    $id = $team->id;
                }

                if (isset($_GET['offset']) && $_GET['offset'] > 0) {
                    $skip = $_GET['offset'];

                } else {
                    $skip = 0;
                }

                $transactions_booking_credit = Transaction::where('team_id', $id)->where('wallet_type', 2)->where('type', 1)->where('is_active', 1)
                    ->orderBy('id', 'desc')->skip($skip)->take(5)->get();


//                $transactions_booking_credit = DB::select("select * from transactions where team_id = $id  and wallet_type = 2 and type = 1 and is_active = 1 order by id desc");

                $transaction_invoices = array();
                $transaction_invoices_booking_array = array();
                foreach ($transactions_booking_credit as $key => $transaction_booking) {

                    if ($transaction_booking->wallet_type == 2) {

                        $transaction_booking->parsed_id = 'PR-' . sprintf('%04d', $transaction_booking->id);

                    }
                    if ($transaction_booking->type == 1) {
                        $transaction_booking->transaction_type = 'Payment';
                    } elseif ($transaction_booking->type == 2) {
                        $transaction_booking->transaction_type = 'Invoice #' . $transaction_booking->invoice_id;
                    }

                    $transactions = DB::select("select * from transactions where credit_transaction_id = $transaction_booking->id and is_active = 1");
                    $transaction_sum = 0;
                    $transaction_sum_log = 0;
                    $amount_due = 0;
                    $x = 0;
                    $transaction_invoices = $transactions;
                    $transaction_invoices_booking_array[] = $transaction_invoices;

                }
                if (!is_array($transaction_invoices_booking_array)) {
                    return FALSE;
                }
                $result = array();
                foreach ($transaction_invoices_booking_array as $key => $value) {
                    if (is_array($value)) {
                        $result = array_merge($result, array_flatten($value));
                    } else {
                        $result[$key] = $value;
                    }
                }

                list($billing_balance, $booking_balance, $booking_free_balance, $printing_balance, $printing_free_balance) = $this->wallet_balance_team_total($id);

                $transaction_invoices_booking_array = $result;

                foreach ($transaction_invoices_booking_array as $key => $value) {
                    if (!empty($value) && $value->wallet_type == 2) {

                        $value->parsed_id = 'INV-R-' . sprintf('%04d', $value->invoice_id);

                    }
                    if (!empty($value->payment_type)) {
                        if ($value->payment_type == 1) {

                            $value->payment_mode = 'Cash';

                        } elseif ($value->payment_type == 2) {
                            $value->payment_mode = 'Free';

                        } elseif ($value->payment_type == 3) {
                            $value->payment_mode = 'Cheque';

                        } elseif ($value->payment_type == 4) {
                            $value->payment_mode = 'Withholding Challan';

                        }
                    }
                }


                $data = array();
                $data['billing_balance'] = $billing_balance;
                $data['booking_balance'] = $booking_balance;
                $data['printing_balance'] = $printing_balance;
                $data['booking_free_balance'] = $booking_free_balance;
                $data['printing_free_balance'] = $printing_free_balance;
                $data['transaction_invoices_booking_array'] = $transaction_invoices_booking_array;
                $data['transactions_booking_credit'] = $transactions_booking_credit;
                if ($skip == 0) {
                    $data['offset'] = 5;

                } else {
                    $data['offset'] = $skip + 5;

                }


            }


            return $this->sendResponse($data, 'response successful');
        } else {
            return $this->sendError('Wrong id/Api token');

        }


    }

    public function walletPrintingMore()
    {

        $user = User::where('id', $_GET['id'])->first();
        if (isset($user) && !empty($user) && $user->api_token == $_GET['api_token']) {


            $teams = Team::where('leader_id', '=', $user->id)->get();
            if (($teams->isEmpty())) {
                dd("You are not leader");
            } else {
//            Billing transactions and billing balance
                foreach ($teams as $team) {
                    $id = $team->id;
                }

                if (isset($_GET['offset']) && $_GET['offset'] > 0) {
                    $skip = $_GET['offset'];

                } else {
                    $skip = 0;
                }
                $transactions_printing_credit = Transaction::where('team_id', $id)->where('wallet_type', 3)->where('type', 1)->where('is_active', 1)
                    ->orderBy('id', 'desc')->skip($skip)->take(5)->get();


//                $transactions_printing_credit = DB::select("select * from transactions where team_id = $id  and wallet_type = 3 and type = 1 and is_active = 1 order by id desc");

                $transaction_invoices = array();
                $transaction_invoices_printing_array = array();
                foreach ($transactions_printing_credit as $key => $transaction_printing) {

                    if ($transaction_printing->wallet_type == 3) {

                        $transaction_printing->parsed_id = 'PP-' . sprintf('%04d', $transaction_printing->id);

                    }
                    if ($transaction_printing->type == 1) {
                        $transaction_printing->transaction_type = 'Payment';
                    } elseif ($transaction_printing->type == 2) {
                        $transaction_printing->transaction_type = 'Invoice #' . $transaction_printing->invoice_id;
                    }

                    $transactions = DB::select("select * from transactions where credit_transaction_id = $transaction_printing->id and is_active = 1 ");
                    $transaction_sum = 0;
                    $transaction_sum_log = 0;
                    $amount_due = 0;
                    $x = 0;
                    $transaction_invoices = $transactions;
                    $transaction_invoices_printing_array[] = $transaction_invoices;

                }
                if (!is_array($transaction_invoices_printing_array)) {
                    return FALSE;
                }
                $result = array();
                foreach ($transaction_invoices_printing_array as $key => $value) {
                    if (is_array($value)) {
                        $result = array_merge($result, array_flatten($value));
                    } else {
                        $result[$key] = $value;
                    }
                }

                list($billing_balance, $booking_balance, $booking_free_balance, $printing_balance, $printing_free_balance) = $this->wallet_balance_team_total($id);

                $transaction_invoices_printing_array = $result;

                foreach ($transaction_invoices_printing_array as $key => $value) {
                    if (!empty($value) && $value->wallet_type == 3) {

                        $value->parsed_id = 'INV-P-' . sprintf('%04d', $value->invoice_id);

                    }
                    if (!empty($value->payment_type)) {
                        if ($value->payment_type == 1) {

                            $value->payment_mode = 'Cash';

                        } elseif ($value->payment_type == 2) {
                            $value->payment_mode = 'Free';

                        } elseif ($value->payment_type == 3) {
                            $value->payment_mode = 'Cheque';

                        } elseif ($value->payment_type == 4) {
                            $value->payment_mode = 'Withholding Challan';

                        }
                    }
                }


                $data = array();
                $data['billing_balance'] = $billing_balance;
                $data['booking_balance'] = $booking_balance;
                $data['printing_balance'] = $printing_balance;
                $data['booking_free_balance'] = $booking_free_balance;
                $data['printing_free_balance'] = $printing_free_balance;
                $data['transaction_invoices_printing_array'] = $transaction_invoices_printing_array;
                $data['transactions_printing_credit'] = $transactions_printing_credit;
                if ($skip == 0) {
                    $data['offset'] = 5;

                } else {
                    $data['offset'] = $skip + 5;

                }


            }

            return $this->sendResponse($data, 'response successful');
        } else {
            return $this->sendError('Wrong id/Api token');

        }


    }

    public function allInvoicesMore()
    {
        $user = User::where('id', $_GET['id'])->first();
        if (isset($user) && !empty($user) && $user->api_token == $_GET['api_token']) {

            $teams = Team::where('leader_id', '=', $user->id)->get();
            if (($teams->isEmpty())) {
                dd("You are not leader");
            } else {
                foreach ($teams as $team) {
                    $id = $team->id;
                }

                if (isset($_GET['offset']) && $_GET['offset'] > 0) {
                    $skip = $_GET['offset'];

                } else {
                    $skip = 0;
                }

                $all_invoices = Invoice::where('team_id', $id)->where('is_active', 1)
                    ->orderBy('id', 'desc')->skip($skip)->take(5)->get();

//                $all_invoices = DB::select("select * from invoices where team_id = $id and is_active = 1 order by id desc ");
                $transactions_array = array();
                $transactions_data = array();
                $data = array();
                foreach ($all_invoices as $key => $invoice) {

                    if ($invoice->wallet_type == 1) {

                        $invoice->parsed_id = 'INV-B-' . sprintf('%04d', $invoice->id);

                    } elseif ($invoice->wallet_type == 2) {

                        $invoice->parsed_id = 'INV-R-' . sprintf('%04d', $invoice->id);

                    } elseif ($invoice->wallet_type == 3) {

                        $invoice->parsed_id = 'INV-P-' . sprintf('%04d', $invoice->id);

                    }


                    $transactions = DB::select("select * from transactions where invoice_id = $invoice->id and is_active = 1");
                    $transaction_sum = 0;
                    $transaction_sum_log = 0;
                    $amount_due = 0;
                    $x = 0;


                    if (!empty($transactions)) {
                        if (!empty($invoice->total)) {
                            foreach ($transactions as $transaction) {
                                $transaction_sum += $transaction->amount;
                            }
                            if ($transaction_sum == $invoice->total) {
                                $all_invoices[$key]->status = "paid";
                            } else {
                                $all_invoices[$key]->status = "outstanding";
                                $outstanding_amount = $invoice->total - $transaction_sum;
                                $all_invoices[$key]->outstanding_amount = $outstanding_amount;

                            }

                        } elseif (!empty($invoice->discount_amount) && $invoice->total == 0) {
                            foreach ($transactions as $transaction) {
                                $transaction_sum += $transaction->amount;
                            }
                            if ($transaction_sum == ceil($invoice->amount)) {
                                $all_invoices[$key]->status = "paid";
                            } else {
                                $all_invoices[$key]->status = "Invalid Invoice";

                            }
                        }
                    } else {
                        $all_invoices[$key]->status = "due";
                        $due_amount = $invoice->total;
                        $all_invoices[$key]->due_amount = $due_amount;

                    }


                    foreach ($transactions as $key => $transaction) {


                        if ($transaction->wallet_type == 1) {

                            $transaction->parsed_id = 'PB-' . sprintf('%04d', $transaction->id);

                        } else if ($transaction->wallet_type == 2) {

                            $transaction->parsed_id = 'PR-' . sprintf('%04d', $transaction->id);

                        } else if ($transaction->wallet_type == 3) {

                            $transaction->parsed_id = 'PP-' . sprintf('%04d', $transaction->id);

                        }

                        if (!empty($transaction->payment_type)) {
                            if ($transaction->payment_type == 1) {

                                $transaction->payment_mode = 'Cash';

                            } elseif ($transaction->payment_type == 2) {
                                $transaction->payment_mode = 'Free';

                            } elseif ($transaction->payment_type == 3) {
                                $transaction->payment_mode = 'Cheque';

                            } elseif ($transaction->payment_type == 4) {
                                $transaction->payment_mode = 'Withholding Challan';

                            }
                        }


                        if ($invoice->total > 0) {
                            $transaction_sum_log += $transaction->amount;
                            $transactions[$key]->amount_remaining = $invoice->total - $transaction_sum_log;
                            if ($x >= 0) {
                                $transactions[$key]->amount_due = $invoice->total - $amount_due;
                            }
                            $x++;
                            $amount_due += $transaction->amount;
                        } else {
                            $transaction_sum_log += $transaction->amount;

                            $transactions[$key]->amount_remaining = $invoice->amount - $transaction_sum_log;
                            if ($x >= 0) {
                                $transactions[$key]->amount_due = $invoice->amount - $amount_due;
                            }
                            $x++;
                            $amount_due += $transaction->amount;
                        }
                        $transactions_data = $transaction;
                        $transactions_array[] = $transactions_data;


                    }
                    $data['all_invoices'] = $all_invoices;
                    $data['result'] = $transactions_array;

                }
                if ($skip == 0) {
                    $data['offset'] = 5;

                } else {
                    $data['offset'] = $skip + 5;

                }

            }

            return $this->sendResponse($data, 'response successful');
        } else {
            return $this->sendError('Wrong id/Api token');

        }

    }



////////////////////////////////////////Billing End////////////////////////////////////////////////////////////////////////
////////////////////////////////////////Ticket Start////////////////////////////////////////////////////////////////////////
    //create ticket post route method
    public function createTicket(Request $request)
    {

        $user = User::where('id', $request->id)->first();
        if (isset($user) && !empty($user) && $user->api_token == $request->api_token) {


            $ticket = new Ticket();
            $ticket->title = $request->title;
            $ticket->description = $request->description;
            $ticket->user_id = $user->id;
            $ticket->branch_id = $request->branch_id;
            $ticket->subject = $request->subject;
            $ticket->status = 0;
            $ticket->resolved = "";

            $saved = $ticket->save();
            $this->AddToLog($user->id, "Ticket  $ticket->title for user id  $ticket->user_id of branch  $ticket->branch_id created successfully");
            $this->sendNotificationTicket($ticket->id);
            $this->sendNotificationUserTicket($ticket->id);

            if ($saved) {
                $data = array();
                $data['status'] = 'success';
                return $this->sendResponse($data, 'Ticket created successfully');
            }


        } else {
            return $this->sendError('Wrong id/Api token');

        }
    }


////////////////////////////////////////Ticket End////////////////////////////////////////////////////////////////////////


    public function pattern()
    {
        $user = User::where('id', $_GET['id'])->first();
        if (isset($user) && !empty($user) && $user->api_token == $_GET['api_token']) {


            return $this->sendResponse($data, 'response successful');
        } else {
            return $this->sendError('Wrong id/Api token');

        }
    }
}
