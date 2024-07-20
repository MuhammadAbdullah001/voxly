<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Announcement;
use App\Booking;
use App\Group;
use App\Mail\twoFactorVerification;
use App\Mail\verifyContract;
use App\Message;
use App\Setting;
use App\Team;
use App\Ticket;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Notification;
use App\Notifications\Support;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */



    public function test($id){

//    return view('error.error');


        $user = User::find($id);
        $contract_email_email = new ContractController();
        $contract_email_email->verifyContract($id);

//    Mail::to($user->email)->send(new verifyContract($user));
//    $collected_amount = '100000';
//    $error_payment_type = 'cash';
//    $threshhold_email = new ContractController();
//    $threshhold_email->sendThreshholdEmail(6, $collected_amount, $error_payment_type);

    }

    public function AddToLog($msg)
    {
        \LogActivity::addToLog($msg);
//        dd('log insert successfully.');
    }

    public function logActivity()
    {
        $logs = \LogActivity::logActivityLists();
        return view('admin.logActivity',compact('logs'));
    }



    public function two_factor_verification_submit(Request $request)
    {

        $number = $request->vdigit1 . $request->vdigit2 . $request->vdigit3 . $request->vdigit4 . $request->vdigit5 . $request->vdigit6;
        $number = (int)$number;


        $user = User::where('two_factor_passcode', $number)->first();

        if (isset($user) && !empty($user)) {
            $expiry_time = time() + (60 * 60 * 24 * 15);
            setcookie("obj_user", $user, $expiry_time, "/");
            return redirect('/home');
        } else {
            echo "Wrong Code";
        }
    }


    public function admin_two_factor_verification_submit(Request $request)
    {

        $number = $request->vdigit1 . $request->vdigit2 . $request->vdigit3 . $request->vdigit4 . $request->vdigit5 . $request->vdigit6;
        $number = (int)$number;


        $user = Admin::where('two_factor_passcode', $number)->first();

        if (isset($user) && !empty($user)) {
            $expiry_time = time() + (60 * 60 * 24 * 15);
            setcookie("obj_admin", $user, $expiry_time, "/");
            return redirect('/admin/home');
        } else {
            echo "Wrong Code";
        }


    }

// Voxly Tuition Functions Start

    public function index(Request $request)
    {

        $data['breadcrumbs'] = array(['name'=>'Home','active'=>true,'url'=>'']);
        return view('home', compact('data'));

    }
    public function student_admission(Request $request)
    {

        $data['breadcrumbs'] = array(['name'=>'Home','active'=>true,'url'=>'']);
        return view('student_admission/main', compact('data'));

    }
    public function password_reset_message(Request $request)
    {

        $data['breadcrumbs'] = array(['name'=>'Home','active'=>true,'url'=>'']);
        return view('reset_msg', compact('data'));

    }

// Voxly Tuition Functions End





    public function invoiceBillingLimitActivityView()
    {
        $teams = Team::where('leader_id', '=', Auth::id())->get();
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


    public function invoiceBookingLimitActivityView()
    {
        $teams = Team::where('leader_id', '=', Auth::id())->get();
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

    public function invoicePrintingLimitActivityView()
    {
        $teams = Team::where('leader_id', '=', Auth::id())->get();
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








    public function email_template(){

        return view('email/email');
    }

    public function all_announcement(){

        $announcements = Announcement::where('branch_id',Auth::user()->branch_id)->where('status',1)->get();
        if(isset(Auth::user()->team_id) && Auth::user()->team_id != ""){
            $team = Team::where('id',Auth::user()->team_id)->first();
            $team_name = $team->name;
        }
        return view('allAnnouncement', compact('announcements','team_name'));

    }


    // Get all invoices and its transactions of single team

    public function team_all_invoices_list($team_id, Request $request)
    {

        list($invoices, $transactions_array) = $this->team_invoices($team_id, $request);
        $data['invoices'] = $invoices;
        $data['transactions_array'] = $transactions_array;
        return view('admin.allInvoicesList', compact('data'));

    }

// Get all transactions and its usage of single team
    public function team_all_transactions_list($team_id, Request $request)
    {

        list($transaction_invoices_billing_array, $transactions_billing_credit) = $this->team_transactions($team_id, $request);
        $data['transaction_invoices_billing_array'] = $transaction_invoices_billing_array;
        $data['transactions_billing_credit'] = $transactions_billing_credit;
        return view('admin.allTransactionsList', compact('data'));

    }


    public function two_factor_verification()
    {

        return view('email.twoFactorVerification', compact('assets', 'team', 'rec_invoice'));

    }


    public function team_invoices($team_id, $request)
    {
        $uri = $request->path();
        $uri = preg_replace('/[0-9]+/', '', $uri);
        if ($uri == "admin/invoices/team/") {
            $invoices = DB::select("select * from invoices where team_id = $team_id and is_active = 1 order by id desc ");
        } else {
            $invoices = DB::select("select * from invoices where team_id = $team_id and is_active = 1 order by id desc limit 3 offset 0 ");
        }

        $transactions_array = array();
        $transactions_data = array();
        $data = array();
        foreach ($invoices as $key => $invoice) {
            if ($uri == "admin/invoices/team/") {
                $transactions = DB::select("select * from transactions where invoice_id = $invoice->id and is_active = 1");
            } else {
                $transactions = DB::select("select * from transactions where invoice_id = $invoice->id and is_active = 1  limit 3 offset 0 ");
            }
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


    public function team_transactions($team_id, $request)
    {
//            Billing transactions and billing balance
        $uri = $request->path();
        $uri = preg_replace('/[0-9]+/', '', $uri);
        if ($uri == "admin/transactions/team/") {
            $transactions_billing_credit = DB::select("select * from transactions where team_id = $team_id  and type = 1 and is_active = 1 order by id desc");
        } else {
            $transactions_billing_credit = DB::select("select * from transactions where team_id = $team_id  and type = 1 and is_active = 1 order by id desc limit 3 offset 0");
        }


        $transaction_invoices = array();
        $transaction_invoices_billing_array = array();
        foreach ($transactions_billing_credit as $key => $transaction_printing) {
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
        return array($transaction_invoices_billing_array, $transactions_billing_credit);


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


    function time_elapsed_string($datetime, $full = false) {
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

    public function load_notification(){


        $notifications = auth()->user()->notifications;
        $unread_notifications = count(auth()->user()->unreadNotifications);
        foreach ($notifications as $key =>  $notification){
            $ago = $this->time_elapsed_string($notification->created_at);
            $notifications[$key]->ago = $ago;
        }

        $final_array = array();
        $final_array['notifications'] = $notifications;
        $final_array['unread'] = $unread_notifications;
        return response()->json($final_array);
    }

    public function read_notification(){
        $unreads = auth()->user()->unreadNotifications;
        foreach ($unreads as $notification) {
            $notification->markAsRead();
        }
        $count = count(auth()->user()->unreadNotifications);
        return response()->json($count);
    }

    public function privacy(){
        return view("pages.privacy");
    }

    public function community(){
        return view("pages.community");
    }

}
