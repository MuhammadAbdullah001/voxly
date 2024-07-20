<?php

namespace App\Http\Controllers;

use App\Notification;
use App\NotificationReceiver;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationGenerator extends Controller
{
    //
    public function notification_generator(Request $request)
    {
        $teachers_all = User::where('user_role', 'teacher')->where('is_active', 1)->get();
        $teachers = array();
        foreach ($teachers_all as $teacher) {
            if ($teacher->teacher->is_resigned == 0) {
                $teachers[] = $teacher;
            }
        }


        $users = User::where('user_role', 'parent')->where('status', 'confirmed')->where('is_active', 1)->get();
        $data['teachers'] = $teachers;
        $data['parents'] = $users;
        $data['breadcrumbs'] = array(['name' => 'Home', 'active' => true, 'url' => '']);
        return view('admin/notification_system/add', compact('data'));

    }

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

    public function notification_generator_submit(Request $request)
    {
//dd($request);
        $validatedData = $request->validate([
//            'title' => ['required','unique:users' ],
            'title' => ['required'],
            'description' => ['required'],
            'is_answerable' => ['required'],
//            'is_answerable' => ['required','unique:users','E-Mail'],
//            'contact_number' => ['contact_number' => 'digits_between:13,20', 'contact_number' => 'numeric'],

            //            'address' => ['required'],
//            'status' => ['required'],
//            'date' => ['required'],


        ]);

        $tokens = array();
        $notification = new \App\Notification();
        $notification->title = $request->title;
        $notification->description = $request->description;
        $notification->is_answerable = $request->is_answerable;
        $notification->created_by_user_id = Auth::user()->user_id;

        $notification->is_active = 1;
        if ($request->hasFile('notif_img')) {
            $image = $request->file('notif_img');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/notification_img');
            $image->move($destinationPath, $name);
            $notification->img = $name;


        }
        $added = $notification->save();
//        $added = 1;
        if ($added) {
            if (isset($request->teachers) && !empty(($request->teachers)) && count($request->teachers) > 0 || isset($request->parents) && count($request->parents) > 0) {
                if (isset($request->teachers) && !empty($request->teachers) && isset($request->parents) && !empty($request->parents)) {
                    $user_ids = array_merge($request->teachers, $request->parents);

                } else {
                    if (isset($request->teachers) && !empty($request->teachers)) {
                        $user_ids = $request->teachers;
                    } else {
                        $user_ids = $request->parents;

                    }
                }

                foreach ($user_ids as $user_id) {
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
//            dd($tokens);
                $notif = array();
                $notif['title'] = $request->title;
                $notif['body'] = $request->description;

                $data = array("navigate" => 0);
                $message_status = $this->send_notification_fcm($tokens, $data, $notif);
//            dd( $message_status);
                $data = array();
                $msg = 'Notification Generated Successfully';

                return redirect()->back()->with('success', $msg);
            } else {
                $msg = ' Select Teacher/Parent To Send Notification';
                return redirect()->back()
                    ->with('error', $msg)
                    ->withInput();

//                return redirect()->back()->with('error', $msg);

            }

        } else {
            $msg = 'Error occurred in sending notification';

            return redirect()->back()->with('error', $msg);


        }


    }


    public function notification_main(Request $request)
    {
        if (Auth::user()->type == 'super_admin') {
            $notifications = Notification::where('is_active', 1)->get();

        } else {
            $notifications = Notification::where('created_by_user_id', Auth::user()->user_id)->where('is_active', 1)->get();

        }
        $data['notifications'] = $notifications;
        $data['breadcrumbs'] = array(['name' => 'Home', 'active' => true, 'url' => '']);
        return view('admin/notification_system/notification_main', compact('data'));

    }

    public function specific_notification_users_list(Request $request)
    {
        $notification = Notification::where('id', $request->id)->where('is_active', 1)->first();
        $data['notification'] = $notification;
        $data['breadcrumbs'] = array(['name' => 'Home', 'active' => true, 'url' => '']);
        return view('admin/notification_system/specific_notification_user_list', compact('data'));

    }

    public function response_check(Request $request)
    {
//        dd($request->user_id. ' ' . $request->notif_id);
        $data = array();
        if (Auth::user()->type == "super_admin") {
            $notification = \App\Notification::where('id', $request->notif_id)->where('is_active', 1)->first();

            if (isset($notification) && !empty($notification)) {


                foreach ($notification->notification_receivers as $notification_receiver) {
//                    echo '<pre>';print_r($notification_receiver->notification_reply);
                    if ($request->user_id == $notification_receiver->users_id) {
                        $notification_data = new \stdClass();
                        $notification_data->id = $notification->id;
                        $notification_data->name = $notification->user->parent_name;
                        $notification_data->user_role = $notification->user_role;
                        $notification_data->title = $notification->title;
                        $notification_data->description = $notification->description;
                        $notification_data->created_at = ($notification->created_at);
                        $img_path = asset("images/notification_img/" . $notification->img);
                        $notification_data->img = $img_path;
                        if (isset($notification_receiver->notification_reply) && !empty($notification_receiver->notification_reply)) {

                            foreach ($notification_receiver->notification_reply as $notification_reply_single) {

                                if ($notification_reply_single->sender_users_id == $request->user_id) {
                                    $notification_reply_data = new \stdClass();
                                    $notification_reply_data->user_id = $notification_receiver->user->id;
                                    $notification_reply_data->name = $notification_receiver->user->parent_name;
                                    $notification_reply_data->user_role = $notification_receiver->user->user_role;
                                    $notification_reply_data->message = $notification_reply_single->message;
                                    $notification_reply_data->created_at = ($notification_receiver->created_at);
                                    $notification_data->notif_reply = $notification_reply_data;
                                }
                            }
                        }
                        $data['notification'] = $notification_data;


                    }

                }
            } else {
                return redirect('/admin/notification')->with('error', 'Select Valid Notification');
                $data = array();

            }
        }


        $data['breadcrumbs'] = array(['name' => 'Home', 'active' => true, 'url' => '']);
        return view('admin/notification_system/responseCheck', compact('data'));

    }

    public function communication(Request $request)
    {
        $teachers = User::where('user_role', 'teacher')->get();
//echo"<pre>";print_r($teachers);die;
        $data['teachers'] = $teachers;
        $data['breadcrumbs'] = array(['name' => 'Home', 'active' => true, 'url' => '']);
        return view('admin/notification_system/communication_main', compact('data'));

    }

    public function associated_parents(Request $request)
    {
        $teacher = User::where('id', $request->id)->first();
        $data = array();
        // $count = 0;
        $users = User::where('status', 'confirmed')->where('user_role', 'parent')->where('is_active', 1)->get();
        $matchedUser = array();
        // $matchedUser = array('users'=>array(), 'dates'=>array());
        $unsorted_array = array();
        $teacher_notifications = \App\Notification::where('created_by_user_id', $request->id)->where('is_active', 1)->get();
        foreach (json_decode($teacher->teacherAssignedSub->subjects_id) as $assignedSubjectId) {
            foreach ($users as $user1) {
                if (isset($user1->StudentAdmission) && !empty($user1->StudentAdmission)) {
                    foreach ($user1->StudentAdmission as $relatedChilds) {
                        foreach (json_decode($relatedChilds->subject_id) as $relatedChildSubId) {
                            if ($relatedChildSubId == $assignedSubjectId) {
                                foreach ($teacher_notifications as $teacher_notification) {
                                    foreach ($teacher_notification->notification_receivers as $notification_receiver) {
                                        if ($user1->id == $notification_receiver->users_id){
                                            $unsorted_array[$user1->id]['id'] = $user1->id;
                                            $unsorted_array[$user1->id]['date'][] = $teacher_notification->created_at->format('Y-m-d H:i:s');
                                            $unsorted_array[$user1->id]['date'][] = $teacher_notification->created_at->format('Y-m-d H:i:s');
                                            // $count++;
                                            // $userAtrr = new \stdClass();
                                            // $userAtrr->id = $user1->id;
                                            // $userAtrr->admission_no = $user1->admission_no;
                                            // $userAtrr->parent_name = $user1->parent_name;
                                            // $userAtrr->email = $user1->email;
                                            // $userAtrr->contact_number = $user1->contact_number;
                                            // $userAtrr->user_role = $user1->user_role;
                                            // $userAtrr->teacher_id = $teacher->id;
                                            // $userAtrr->api_token = $user1->api_token;
                                            // $matchedUser[] = $userAtrr;
                                        }
                                    }
                                }
                            }
                        }

                    }
                }
            }
        }

        $fast = array();
        foreach($unsorted_array as $key=>$val){
            $fast[$key]['id'] = $val['id'];
            $fast[$key]['date'] = max($val['date']);
        }
        usort($fast, function($a, $b) {
            $t1 = strtotime($a['date']);
            $t2 = strtotime($b['date']);
            // return $t1 - $t2;

            // if ($t1 == $t2) return 0;
            return ($t1 < $t2) ? 1 : -1;
        });

        $matchedUser = array();
        foreach($fast as $key=>$val){
            $user = User::find($val['id']);
            $userAtrr = new \stdClass();
            $userAtrr->id = $user->id;
            $userAtrr->admission_no = $user->admission_no;
            $userAtrr->parent_name = $user->parent_name;
            $userAtrr->email = $user->email;
            $userAtrr->contact_number = $user->contact_number;
            $userAtrr->user_role = $user->user_role;
            $userAtrr->teacher_id = $teacher->id;
            $userAtrr->api_token = $user->api_token;
            $matchedUser[] = $userAtrr;
        }



        $unique = array_map("unserialize", array_unique(array_map("serialize", $matchedUser)));
        $data['users'] = $unique;

        $data['breadcrumbs'] = array(['name' => 'Home', 'active' => true, 'url' => '']);
        return view('admin/notification_system/associated_parents', compact('data'));

    }

    public function associated_parent_communication(Request $request)
    {
        $selected_teacher = User::where('id', $request->teacher_id)->first();
        $selected_parent = User::where('id', $request->user_id_for_chat)->first();
        $teacher_name = $selected_teacher->parent_name;
        $parent_name = $selected_parent->parent_name;
        $data = array();


        $notifications = \App\Notification::where('created_by_user_id', $request->teacher_id)->where('is_active', 1)->get();
        foreach ($notifications as $notification) {

            foreach ($notification->notification_receivers as $notification_receiver) {

                if ($request->user_id_for_chat == $notification_receiver->users_id) {
                    $notification_data = new \stdClass();
                    $notification_data->name = $notification->user->parent_name;
                    $notification_data->teacher_id = $notification->user->id;
                    $notification_data->title = $notification->title;
                    $notification_data->description = $notification->description;
                    $notification_data->is_sender = 1;
                    $notification_data->created_at = ($notification->created_at);

                    if ($notification->img && !empty($notification->img)) {
                        $img_path = asset("images/notification_img/" . $notification->img);
                        $notification_data->img = $img_path;
                    }
                    if (isset($notification_receiver->notification_reply)) {
                        foreach ($notification_receiver->notification_reply as $notif_reply) {
                            if ($request->user_id_for_chat == $notification_receiver->users_id
                                && $notif_reply->sender_users_id == $request->user_id_for_chat) {


                                $notification_reply_data = new \stdClass();
                                $notification_reply_data->user_id = $notification_receiver->user->id;
                                $notification_reply_data->is_sender = 0;
                                $notification_reply_data->name = $notification_receiver->user->parent_name;
                                $notification_reply_data->message = $notif_reply->message;
                                $notification_reply_data->created_at = ($notification_receiver->created_at);
                                $notification_data->notif_reply = $notification_reply_data;
//                            $data['notifications'][] = $notification_data;

                            }
                        }
                    }
                    $data['notifications'][] = $notification_data;

                }


            }

        }
        $data['teacher_name'] = $teacher_name;
        $data['parent_name'] = $parent_name;

        $data['breadcrumbs'] = array(['name' => 'Home', 'active' => true, 'url' => '']);
        return view('admin/notification_system/communication_chat_specific_parent', compact('data'));

    }

    public function chat_history_main(Request $request)
    {
        $data = array();
        $notifications = \App\Notification::where('created_by_user_id', Auth::user()->user_id)->where('is_active', 1)->get();
//        dd($notifications);
        foreach ($notifications as $notification) {


            foreach ($notification->notification_receivers as $notification_receiver) {


                $data['users_list'][] = $notification_receiver->user;

            }

        }
        if (isset($data['users_list'])) {
            $data['users_list'] = array_map("unserialize", array_unique(array_map("serialize", $data['users_list'])));
        } else {
            $data['users_list'] = [];
        }
        $data['breadcrumbs'] = array(['name' => 'Home', 'active' => true, 'url' => '']);
        return view('admin/notification_system/history_main', compact('data'));

    }

    public function associated_chat_history(Request $request)
    {
        $selected_parent = User::where('id', $request->user_id_for_chat)->first();
        $super_admin = User::where('id', Auth::user()->user_id)->first();

        $super_admin_name = $super_admin->parent_name;
        $parent_name = $selected_parent->parent_name;
        $user_role = $selected_parent->user_role;
        $notifications = \App\Notification::where('created_by_user_id', Auth::user()->user_id)->where('is_active', 1)->get();
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

                if ($request->user_id_for_chat == $notification_receiver->users_id) {
                    $notification_data = new \stdClass();
                    $notification_data->name = $notification->user->parent_name;
                    $notification_data->teacher_id = $notification->user->id;
                    $notification_data->title = $notification->title;
                    $notification_data->description = $notification->description;
                    $notification_data->is_sender = 1;
                    $notification_data->created_at = ($notification->created_at);
                    if ($notification->img && !empty($notification->img)) {
                        $img_path = asset("images/notification_img/" . $notification->img);
                        $notification_data->img = $img_path;
                    }


                    if (isset($notification_receiver->notification_reply)) {
                        foreach ($notification_receiver->notification_reply as $notif_reply) {
                            if ($request->user_id_for_chat == $notification_receiver->users_id
                                && $notif_reply->sender_users_id == $request->user_id_for_chat) {


                                $notification_reply_data = new \stdClass();
                                $notification_reply_data->user_id = $notification_receiver->user->id;
                                $notification_reply_data->is_sender = 0;
                                $notification_reply_data->name = $notification_receiver->user->parent_name;
                                $notification_reply_data->message = $notif_reply->message;
                                $notification_reply_data->created_at = ($notification_receiver->created_at);
                                $notification_data->notif_reply = $notification_reply_data;
//                            $data['notifications'][] = $notification_data;

                            }
                        }
                    }
                    $data['notifications'][] = $notification_data;

                }


            }

        }
//        dd("fdf");
        $data['user_role'] = $user_role;
        $data['teacher_name'] = $super_admin_name;
        $data['parent_name'] = $parent_name;
        $data['breadcrumbs'] = array(['name' => 'Home', 'active' => true, 'url' => '']);
        return view('admin/notification_system/chat_history', compact('data'));

    }


}
