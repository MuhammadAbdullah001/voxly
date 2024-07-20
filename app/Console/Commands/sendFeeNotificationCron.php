<?php

namespace App\Console\Commands;


use App\Notification;
use App\NotificationReceiver;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Exception;


use App\StudentFee;



class sendFeeNotificationCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'feeNotification:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cron script to send fee notifications to parent after 1,3,10 days of fee due date if fee not paid';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    function send_notification_fcm($tokens, $data, $notif)
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
    public function handle()
    {
try{
        $student_fees = StudentFee::select(
            'student_fees.id', 'student_fees.admission_no', 'student_fees.from_date',
            'students.student_name', 'parents.parent_name', 'parents.fcm_token'
        )
            ->join('students', 'student_fees.students_id', '=', 'students.id')
            ->join('parents', 'students.parents_id', '=', 'parents.id')
            ->where('student_fees.is_active', 1)
            ->where('student_fees.status', 'unpaid')
            ->where(function ($query) {
                $query->where('student_fees.notification_sent_1_day', 0)
                      ->orWhere('student_fees.notification_sent_3_day', 0)
                      ->orWhere('student_fees.notification_sent_10_day', 0);
            })
            ->whereRaw('(DATE(student_fees.from_date) + INTERVAL 1 DAY) = ?', [date('Y-m-d')])
            ->orWhereRaw('(DATE(student_fees.from_date) + INTERVAL 3 DAY) = ?', [date('Y-m-d')])
            ->orWhereRaw('(DATE(student_fees.from_date) + INTERVAL 10 DAY) = ?', [date('Y-m-d')])
        ->orderBy('id')
        ->chunk(300, function ($fees) {
            foreach ($fees as $key => $student_fee) {

            if ($student_fee->notification_sent_1_day == 0) {
                $one_day_added = new \DateTime($student_fee->from_date . '+ 1 day');
                if ($one_day_added->format('Y-m-d') == date('Y-m-d')) {
                    $tokens = array();
                    $tokens[] = $student_fee->parent->fcm_token;


                    $msg = "Dear " . $student_fee->parent->parent_name . ", your fee is not paid against the Admission no: " . $student_fee->admission_no . " under Student Name: " . $student_fee->student->student_name . " Please clear your dues \n Thank you  \n Voxly Tuition";


                    $notification = new Notification();
                    $notification->title = "Fee Reminder";
                    $notification->description= $msg;
                    $notification->is_answerable= 0;
                    $notification->created_by_user_id =  149;
                    $notification->is_active= 1;

                    $added = $notification->save();
                    if ($added){
                        $notification_receiver = new NotificationReceiver();
                        $notification_receiver->notifications_id = $notification->id;
                        $notification_receiver->users_id = $student_fee->parent->id;
                        $notification_receiver->is_seen = 0;
                        $notification_receiver->save();
                    }



                    $notif = array();
                    $notif['title'] = "Fee Reminder";
                    $notif['body'] = $msg;
                    $navigate = array("navigate" => 0);

//                    $data = array("navigate" => 0);
                    $message_status = $this->send_notification_fcm($tokens, $navigate, $notif);
                    $data = array();
                    $student_fee->notification_sent_1_day = 1;
                    $student_fee->save();

                }


            } elseif ($student_fee->notification_sent_3_day == 0) {
                $three_day_added = new \DateTime($student_fee->from_date . '+ 3 day');
                if ($three_day_added->format('Y-m-d') == date('Y-m-d')) {
                    $tokens = array();
                    $tokens[] = $student_fee->parent->fcm_token;

                    $msg = "Dear " . $student_fee->parent->parent_name . ", your fee is not paid against the Admission no: " . $student_fee->admission_no . " under Student Name: " . $student_fee->student->student_name . " Please clear your dues \n Thank you  \n Voxly Tuition";

                    $notification = new Notification();
                    $notification->title = "Fee Reminder";
                    $notification->description= $msg;
                    $notification->is_answerable= 0;
                    $notification->created_by_user_id =  149;
                    $notification->is_active= 1;

                    $added = $notification->save();
                    if ($added){
                        $notification_receiver = new NotificationReceiver();
                        $notification_receiver->notifications_id = $notification->id;
                        $notification_receiver->users_id = $student_fee->parent->id;
                        $notification_receiver->is_seen = 0;
                        $notification_receiver->save();
                    }

                    $notif = array();
                    $notif['title'] = "Fee Reminder";
                    $notif['body'] = $msg;
                    $navigate = array("navigate" => 0);

//                    $data = array("navigate" => 0);
                    $message_status = $this->send_notification_fcm($tokens, $navigate, $notif);
                    $data = array();
                    $student_fee->notification_sent_3_day = 1;
                    $student_fee->save();
                }
            } elseif ($student_fee->notification_sent_10_day == 0) {
                $ten_day_added = new \DateTime($student_fee->from_date . '+ 10 day');
                if ($ten_day_added->format('Y-m-d') == date('Y-m-d')) {
                    $tokens = array();
                    $tokens[] = $student_fee->parent->fcm_token;


                    $msg = "Dear " . $student_fee->parent->parent_name . ", your fee is not paid against the Admission no: " . $student_fee->admission_no . " under Student Name: " . $student_fee->student->student_name . " Please clear your dues \n Thank you  \n Voxly Tuition";

                    $notification = new Notification();
                    $notification->title = "Fee Reminder";
                    $notification->description= $msg;
                    $notification->is_answerable= 0;
                    $notification->created_by_user_id =  149;
                    $notification->is_active= 1;

                    $added = $notification->save();
                    if ($added){
                        $notification_receiver = new NotificationReceiver();
                        $notification_receiver->notifications_id = $notification->id;
                        $notification_receiver->users_id = $student_fee->parent->id;
                        $notification_receiver->is_seen = 0;
                        $notification_receiver->save();
                    }

                    $notif = array();
                    $notif['title'] = "Fee Reminder";
                    $notif['body'] = $msg;
                    $navigate = array("navigate" => 0);

//                    $data = array("navigate" => 0);
                    $message_status = $this->send_notification_fcm($tokens, $navigate, $notif);
                    $data = array();
                    $student_fee->notification_sent_10_day = 1;
                    $student_fee->save();
                }
            }

        }
    });
}        catch(Exception $ex){

        }
        gc_collect_cycles();
    }
}
