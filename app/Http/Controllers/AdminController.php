<?php

namespace App\Http\Controllers;


use App\Admin;
use App\Asset;

use App\Assetdetail;
use App\AssetsAssigned;
use App\AttendanceRecord;
use App\Booking;
use App\Branch;
use App\Events\ChatEvents;
use App\Expense;
use App\Invoice;
use App\InvoiceItem;
use App\Message;
use App\RecurringInvoice;
use App\RecurringInvoiceItem;
use App\RecurringInvoiceLog;
use App\Setting;
use App\StaffSalary;
use App\StaffTeacher;
use App\StudentAdmission;
use App\StudentFee;
use App\Task;
use App\Channel;
use App\ChannelMember;
use App\Group;
use App\GroupMember;
use App\Team;
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

use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\DataTables;

class AdminController extends Controller
{

    public function __construct()
    {
        date_default_timezone_set("Asia/Karachi");
//        session_start();
    }

    public function AddToLog($msg)
    {
        \LogActivity::addToLog($msg);
//        dd('log insert successfully.');
    }


    //index to view admin dashboard
    public function sendNotificationAdmin($id, $branch_id, $team_id)
    {
        //$ticket = Ticket::where('id',$id)->first();

//        $ago = $this->time_elapsed_string($ticket->ago);
        $branch = Branch::where('id', $branch_id)->first();
        $team = Team::where('id', $team_id)->first();
        $admins = Admin::where('id', "!=", auth()->id())->get();
        foreach ($admins as $admin) {
            $get_admin = Admin::find($admin->id);
            $details = [
                'message' => 'Transaction has been made in Branch ' . $branch->name . " of team " . $team->name,
                'id' => $id,
                'url' => "/invoices/",
                'class' => "icon-coins"
            ];
            Notification::send($get_admin, new Support($details));
        }
    }

    public function sendNotificationTeamLead($id, $branch_id, $team_id)
    {
        $branch = Branch::where('id', $branch_id)->first();
        $team = Team::where('id', $team_id)->first();
        $team_id = Transaction::where('id', $id)->first();
        $team_lead = Team::where('id', $team_id->team_id)->first();
//        dd($team_lead->id);
        $get_lead = User::find($team_lead->leader_id);
        $details = [
            'message' => 'Transaction has been made in Branch ' . $branch->name . " of team " . $team->name,
            'id' => $id,
            'url' => "/invoices/",
            'class' => "icon-coins"
        ];
        Notification::send($get_lead, new Support($details));
    }

    public function sendNotificationApprovedMember($id)
    {
//        dd($team_lead->id);
        $team_lead = Team::where('id', $id)->first();
        $get_lead = User::find($team_lead->leader_id);
        $branch = Branch::where('id', $get_lead->branch_id)->first();
//        dd($get_lead);
        $details = [
            'message' => $get_lead->name . ' Member has been approved in branch ' . $branch->name . " and in the team of " . $team_lead->name,
            'id' => $id,
            'url' => "/team/",
            'class' => "icon-user-plus"
        ];
        Notification::send($get_lead, new Support($details));
    }

    public function sendNotificationApprovedLead($id)
    {
        $team_lead = Team::where('id', $id)->first();

        $user = User::where('id', $team_lead->leader_id)->first();
        $branch = Branch::where('id', $user->branch_id)->first();
//        $get_lead = User::find($team_lead->leader_id);
//        dd($get_lead);


        $admins = Admin::where('id', "!=", auth()->id())->get();
        foreach ($admins as $admin) {
            $get_admin = Admin::find($admin->id);
            $details = [
                'message' => 'Team Lead has been approved in branch ' . $branch->name . " and in the team of " . $team_lead->name,
                'id' => $id,
                'url' => "/users/",
                'class' => "icon-users4"
            ];

            Notification::send($get_admin, new Support($details));
        }
//        Notification::send($get_lead, new Support($details));
    }

    public function sendNotificationBranchUsers($id)
    {
//        dd($team_lead->id);
//        $team_lead = Team::where('id',$id)->first();

        $users = User::where('branch_id', $id)->get();
        foreach ($users as $user) {
            $get_users = User::find($user->id);
            $details = [
                'message' => 'You have a new anouncement',
                'id' => $id,
                'url' => "/home",
                'class' => "icon-megaphone"
            ];
            Notification::send($get_users, new Support($details));

        }
    }

    public function sendNotificationBranchAdmin($id)
    {
//        dd($team_lead->id);
//        $team_lead = Team::where('id',$id)->first();

        $admins = Admin::where('branch_id', $id)->get();

        foreach ($admins as $admin) {
            $get_users = Admin::find($admin->id);

            $details = [
                'message' => 'You have a new anouncement',
                'id' => $id,
                'url' => "/anouncements/",
                'class' => "icon-megaphone"
            ];
            Notification::send($get_users, new Support($details));

        }
    }

    public function sendNotificationTeamLeadAsset($id, $name)
    {
        $get_lead = User::find($id);
//        dd($get_lead);
        $details = [
            'message' => 'New asset ' . $name . ' has been added in your current team assets',
            'id' => $id,
            'url' => "/team/",
            'class' => "icon-store2"
        ];
        Notification::send($get_lead, new Support($details));
    }

    public function sendNotificationAnnouncementSuperAdmin($id)
    {
//        dd($team_lead->id);
//        $team_lead = Team::where('id',$id)->first();

        $admins = Admin::where('type', 1)->get();

        foreach ($admins as $admin) {
            $get_users = Admin::find($admin->id);

            $details = [
                'message' => 'You have a new announcement',

                'id' => $id,
                'url' => "/admin/announcements",
                'class' => "icon-megaphone"
            ];
            Notification::send($get_users, new Support($details));

        }
    }

    public function sendNotificationTasksAdmin($id, $title)
    {
        $admin = Admin::where('id', $id)->first();

        $get_users = Admin::find($admin->id);

        $details = [
            'message' => 'A new task ' . $title . ' has been assign to you ',
            'id' => $id,
            'url' => "/admin/tasks",
            'class' => "icon-task"
        ];
        Notification::send($get_users, new Support($details));

    }

    public function sendNotificationTasksSuperAdmin($id)
    {
        $user = User::where('id', $id)->first();
        $admins = Admin::where('type', 1)->get();

        foreach ($admins as $admin) {
            $get_users = Admin::find($admin->id);

            $details = [
                'message' => 'A new task has been assigned to ' . $get_users->name,
                'id' => $id,
                'url' => "/admin/tasks",
                'class' => "icon-task"
            ];
            Notification::send($get_users, new Support($details));

        }
    }

    public function sendNotificationToAdminByBranch($id, $branch_id)
    {
        $user = User::where('id', $id)->first();
        $branch = Branch::where('id', $branch_id)->first();
        $admins = Admin::where('branch_id', $branch_id)->get();
        foreach ($admins as $admin) {
            $get_admin = Admin::find($admin->id);
            $details = [
                'message' => 'New User ' . $user->name . ' Has Been Created at ' . $branch->name,
                'id' => $id,
                'url' => "/admin/users",
                'class' => "icon-user-plus"
            ];
            Notification::send($get_admin, new Support($details));
        }
    }

    public function sendNotificationUserSuperAdmin($id, $branch_id)
    {
        $user = User::where('id', $id)->first();
        $branch = Branch::where('id', $branch_id)->first();
        $admins = Admin::where('type', 1)->get();

        foreach ($admins as $admin) {
            $get_users = Admin::find($admin->id);

            $details = [
                'message' => 'New User ' . $user->name . ' Has Been Created at ' . $branch->name,
                'id' => $id,
                'url' => "/admin/users",
                'class' => "icon-user-plus"
            ];
            Notification::send($get_users, new Support($details));

        }
    }


    public function sendNotificationReplyTicketToAdmins($id)
    {
        $ticket = Ticket::where('id', $id)->first();
//dd($ticket->title);
//        $ago = $this->time_elapsed_string($ticket->ago);
        $admins = Admin::all();
        $user = User::where('id', $ticket->user_id)->first();
        $branch = Branch::where('id', $ticket->branch_id)->first();
        foreach ($admins as $admin) {
            $get_admin = Admin::find($admin->id);
            $details = [
                'message' => 'Reply has been sent to ' . $user->name . ' at ' . $branch->name . ' of Ticket ' . $ticket->title,
                'id' => $id,
                'url' => "/admin/tickets/chat/" . $id,
                'class' => "icon-lifebuoy"
            ];
            Notification::send($get_admin, new Support($details));
        }
    }


    public function sendNotificationReplyTicketToUser($id)
    {
        $ticket = Ticket::where('id', $id)->first();
        $get_user = User::find($ticket->user_id);

        $details = [
            'message' => 'New Reply Ticket of ' . $ticket->title,
            'id' => $id,
            'url' => "/support/ticket/" . $id . "/message",
            'class' => "icon-lifebuoy"
        ];
        Notification::send($get_user, new Support($details));
    }

    public function sendNotificationReplyTicketStatusToAdmins($id, $status)
    {
        if ($status == 0) {
            $status_name = "Open";
        } elseif ($status == 1) {
            $status_name = "Active";
        } elseif ($status == 2) {
            $status_name = "Resolved";
        } elseif ($status == 3) {
            $status_name = "Closed";
        }
        $ticket = Ticket::where('id', $id)->first();
        $user = User::where('id', $ticket->user_id)->first();
        $branch = Branch::where('id', $ticket->branch_id)->first();
//dd($ticket->title);
//        $ago = $this->time_elapsed_string($ticket->ago);
        $admins = Admin::all();
        foreach ($admins as $admin) {
            $get_admin = Admin::find($admin->id);
            $details = [
                'message' => 'Ticket ' . $ticket->title . ' by ' . $user->name . ' of ' . $branch->name . ' has been ' . $status_name,
                'id' => $id,
                'url' => "/admin/support",
                'class' => "icon-lifebuoy"
            ];
            Notification::send($get_admin, new Support($details));
        }
    }

    public function sendNotificationReplyTicketStatusToUser($id, $status)
    {

        if ($status == 0) {
            $status_name = "Open";
        } elseif ($status == 1) {
            $status_name = "Active";
        } elseif ($status == 2) {
            $status_name = "Resolved";
        } elseif ($status == 3) {
            $status_name = "Closed";
        }
        $ticket = Ticket::where('id', $id)->first();
        $get_user = User::find($ticket->user_id);

        $details = [
            'message' => 'Your Ticket ' . $ticket->title . ' has been ' . $status_name,
            'id' => $id,
            'url' => "/support",
            'class' => "icon-lifebuoy"
        ];
        Notification::send($get_user, new Support($details));
    }

    public function index(Request $request)
    {
        
        $start_time = date('Y-m-1 00:00:00');
        $end_time = date('Y-m-31 23:59:59');
        if ($request->ajax()) {
            $student_fees= StudentFee::whereBetween('entry_date', [$start_time, $end_time])->where('status','paid');
            return DataTables::of($student_fees)
            ->editColumn('status',function($row){
               return '<td class="badge badge-success text-center">'.  $row->status .'</td>';
            })
            ->editColumn('payment_type',function($row){
                return strtoupper(str_replace('_',' ',$row->payment_type));
             })
             ->editColumn('expected_amount',function($row){
                return number_format($row->expected_amount,0);
             })
             ->editColumn('amount_taken',function($row){
                return number_format($row->amount_taken,0);
             })
            ->setRowAttr([
                'class' => function ($row) {
                    return (isset($row->is_update) && $row->is_update == 1) ? 'bg-warning' : '';
                }
            ])
            ->rawColumns(['status'])
            ->make(true);
         }
         $student_fees= StudentFee::whereBetween('entry_date', [$start_time, $end_time])->where('status','paid')->get();

        $fees= StudentFee::whereBetween('from_date', [$start_time, $end_time])->where('status','paid')->where('is_active',1)->sum('amount_taken');
        $expenses= Expense::whereBetween('date', [$start_time, $end_time])->where('is_active',1)->sum('amount');
        $salaries= StaffSalary::whereBetween('salary_from_date', [$start_time, $end_time])->where('is_active',1)->sum('amount_taken');
        $admissions_active = User::where('status','confirmed')->where('user_role','parent')->where('is_active',1)->count();
        $admissions_inactive = User::where('status','!=','confirmed')->where('user_role','parent')->where('is_active',1)->count();
        $teacher_active = StaffTeacher::where('is_resigned',0)->where('is_active',1)->count();
        $teacher_inactive = StaffTeacher::where('is_resigned',1)->where('is_active',1)->count();
        $student_active = StudentAdmission::where('status','confirmed')->where('is_active',1)->count();
        $student_inactive = StudentAdmission::where('status','!=','confirmed')->where('is_active',1)->count();




        $data['fees_paid_sum'] = $fees;
        $data['expenses_sum_monthly'] = $expenses;
        $data['salaries_sum_monthly'] = $salaries;
        $data['admissions_active'] = $admissions_active;
        $data['admissions_inactive'] = $admissions_inactive;
        $data['teacher_active'] = $teacher_active;
        $data['teacher_inactive'] = $teacher_inactive;
        $data['student_active'] = $student_active;
        $data['student_inactive'] = $student_inactive;
        $data['student_fees'] = $student_fees;
        $total  = 0;
        foreach ($student_fees as $key=>$student_fee) {
            $total+= $student_fee->amount_taken;
        }
        $data['total'] = $total;
        $data['breadcrumbs'] = array(['name'=>'Home','active'=>true,'url'=>'']);
        return view('admin.home', compact('data'));

    }

    public function profile_update(Request $request){
//        dd($request->cpassword);
        $validatedData = $request->validate([

            'name' => ['required'],
             'password' => ['required',
               'min:6',
//               'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/'
                  ]
        ]);

        $admin = Admin::find(auth()->id());
        $name = $request->name;
        $admin->name = $request->name;
        $password = $request->password;
        $cpassword = $request->cpassword;
        if(isset($password) && $password != ""){
            if($password != $cpassword){
                return back()->with('error','Password does not match');
            }
            $admin->password = Hash::make($password);
        }

        $user = User::find($admin->user_id);
        if (isset($user) && !empty($user)){
            $user->parent_name = $name;
        }
        if ($request->hasFile('avtar_url')) {
            $image = $request->file('avtar_url');
            $name = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/images/profile_pic');
            $image->move($destinationPath, $name);
            $admin->avatar_url=$name;


            $user->avatar_url = $name;



        }
        $admin->save();
        $user->save();

        return back()->with('success','Profile Updated successfully');
    }

    public function index_old()
    {
         if (Auth::user()->type == 1) {


            $approved = User::where('status', '=', 1)->where('is_active', 1)->where('type', '!=', 3)->count();
            $unapproved = User::where('status', '=', 0)->where('is_active', 1)->where('type', '!=', 3)->count();
            $branches = Branch::all()->count();
            $tickets = Ticket::where('status', 0)->get();
            $teams = Team::where('is_active', 1)->count();
            $all_teams = Team::all();
            $date = time();
            $current_date = date('Y-m-d', $date);

            $booking_date = date('Y-m-d');
            $book_from = date('H:i:s');
            $book_to = date('24:00:00');


//            $bookings = DB::select("select * from bookings  where  date(booking_date) between '$booking_date' and '$booking_date' and book_from between '$book_from' and '$book_to'");

            $bookings = Booking::where('booking_date', $current_date)
                ->whereBetween('book_from', [$book_from, $book_to])
                ->get();

            $all_branches = Branch::all();
        } else {
            $branch_id = Auth::user()->branch_id;
            $all_branches = Branch::where('id', '=', $branch_id)->get();

            $approved = User::where('status', '=', 1)->where('branch_id', $branch_id)->where('type', '!=', 3)->count();
            $unapproved = User::where('status', '=', 0)->where('branch_id', $branch_id)->count();
            $branches = Branch::all()->count();
            $tickets = Ticket::where('branch_id', '=', $branch_id)->get();
            $teams = Team::where('branch_id', '=', $branch_id)->count();
            $all_teams = Team::where('branch_id', '=', $branch_id)->count();
            $date = time();
            $current_date = date('Y-m-d', $date);
            $bookings = Booking::where('booking_date', $current_date)->where('branch_id', $branch_id)->get();
        }

//        $uri = request()->segment(1);
//
//        if($uri == "admin")
//        {
//            $admin=Admin::where('id',auth()->id())->first();
//            $groupmembers=GroupMember::where('user_id',$admin->user_id)->where('is_active',1)->get();
//        }else{
//            $groupmembers=GroupMember::where('user_id',auth()->id())->where('is_active',1)->get();
//        }
//
//        foreach ($groupmembers as $key => $groupmember){
//            $groups =Group::where('id',$groupmember->group_id)->first();
//            $ago = $this->time_elapsed_string($groups->created_at);
//            $groupmembers[$key]->group_name = $groups->name;
//            $groupmembers[$key]->group_id = $groups->id;
//            $groupmembers[$key]->ago = $ago;
//        }


        $uri = request()->segment(1);

        if ($uri == "admin") {
            $admin = Admin::where('id', auth()->id())->first();
            $groupmembers = GroupMember::where('user_id', $admin->user_id)->where('is_active', 1)->get();

        } else {
            $groupmembers = GroupMember::where('user_id', auth()->id())->where('is_active', 1)->get();
        }

        $groups = array();

        foreach ($groupmembers as $groupmember) {
            $groups[] = Group::where('id', $groupmember->group_id)->get();

            foreach ($groups as $key => $group) {
                foreach ($group as $key2 => $g) {

                    $unread = Message::where('receiver_id', $admin->user_id)->where('group_id', $g->id)->where('seen', 0)->count();
//                    dd($unread);
//                    dd("hi");
                    $ago = $this->time_elapsed_string($g->created_at);
                    $groups[$key]->ago = $ago;
                    $groups[$key]->unread = $unread;
                }
            }
        }

        $uri = request()->segment(1);

        if ($uri == "admin") {
            $user = User::find(auth()->user()->user_id);
        } else {
            $user = User::find(auth()->id());
        }

//        dd($user);
//dd($groups);

        return view('admin.home', compact('approved', 'unapproved', 'teams', 'tickets', 'all_teams', 'branches', 'all_branches', 'bookings', 'groups', 'user'));

    }


    public function showBookingHistory($team_id)
    {
        $teams = Team::where('id', '=', $team_id)->get()->all();
//        $bookings = Booking::query();
//        foreach ($teams as $team) {
//            $bookings->orWhere('team_id', '=', $team->id);
//        }
//        $reservations = $bookings->get();


        $book_from = date('Y-m-01');
        $book_to = date('Y-m-31');


        $reservations = Booking::where('is_reserve', 0)
            ->where('team_id', $team_id)
            ->whereBetween('booking_date', [$book_from, $book_to])
            ->orderBy('created_at', 'desc')
            ->get();


        foreach ($reservations as $key => $booking) {

            $asset = Asset::where('id', $booking->asset_id)->first();
            $branch = Branch::where('id', $booking->branch_id)->first();
            $booked_by_user = User::where('id', $booking->team->leader_id)->first();

            $reservations[$key]->asset_name = $asset->name;
            $reservations[$key]->booked_by = $booked_by_user->name;
            $reservations[$key]->branch_name = $branch->name;
            $reservations[$key]->total_price = $booking->asset->price * (abs(strtotime($booking->book_from) - strtotime($booking->book_to)) / 3600);
            $reservations[$key]->asset_rate = $booking->asset->price;
            $reservations[$key]->use_hours = (abs(strtotime($booking->book_from) - strtotime($booking->book_to)) / 3600);

        }


        return response()->json($reservations);
    }

    public function getTeamsOnTeamType(Request $request)
    {
        if ($request->teamType == 1) {
            $all_teams = Team::where('branch_id', $request->branch_id)->where('is_walking', $request->teamType)->where('is_active', 1)->get();
        } else {
            $all_teams = Team::where('branch_id', $request->branch_id)->where('is_walking', 0)->where('is_active', 1)->get();

        }
        return response()->json($all_teams);

    }

    //logout admin
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        Auth::guard('web')->logout();
        return redirect()->guest(route('admin.home'));
    }

//user -> type = 0 => walking
//    1=>lead
//    2=>member
//    3=>admin user
    public function users()
    {
        if (Auth::user()->type == 1) {
            $users = User::where('type', '!=', 3)->get();

//            dd($users);
            $teams = Team::all();
        } else {
            $branch_id = Auth::user()->branch_id;
            $users = User::where('branch_id', '=', $branch_id)->where('type', '!=', 3)->get();
            $teams = Team::where('branch_id', '=', $branch_id)->get();

        }


        return view('admin.users', compact('users', 'teams'));

    }

    public function attendance()
    {
        return view('admin.attendance');
    }

    public function booking(Request $request)
    {
//        $request->session()->put('filter_branch', $request->branch);
//        $request->session()->put('filter_team', $request->team);
//        $data = $request->session()->all();

//        session(['filter_branch' => $request->branch]);
//        session(['filter_team' => $request->team]);
//        print_r(session(['filter_branch']));
//        $_SESSION['filter_branch'] = $request->branch;
//        $_SESSION['filter_team'] = $request->team;


//        if (!empty($request->branch) || !empty($request->team)) {
//            if (!empty($request->branch) && !empty($request->team)) {
//
////                $request->session()->flash('filter_branch', $request->branch);
////                $request->session()->flash('filter_team', $request->team);
//
//
//                $team = Team::find($request->team);
//                $booking = Booking::where('branch_id', '=', $team->branch_id)->get();
//                $branches = Branch::where('id', '=', $request->branch)->get();
//
//            } elseif (!empty($request->branch)) {
//
//                $_SESSION['filter_branch'] = $request->branch;
//
//                $booking = Booking::where('branch_id', '=', $request->branch)->get();
//                $branches = Branch::where('id', '=', $request->branch)->get();
//            }
//        } else {
        $branches = Branch::all();
//        }

        return view('admin.bookings', compact('branches'));
    }

    public function post_booking(Request $request)
    {
        $branches = Branch::all();

        return view('admin.booking_filter', compact('branches'));
    }


    public function getBookingFilter(Request $request)
    {

        $url = url()->previous();

        $host = explode('?', $url);
        $host1 = explode('&', $host[1]);

        $branch = $host1[0];
        $branch = explode('=', $branch);
        $branch_filter = $branch[1];

        $team = $host1[1];
        $team = explode('=', $team);
        $team_filter = $team[1];


        if (!empty($request)) {

            if (!empty($branch_filter) && $branch_filter > 0 || !empty($team_filter)) {

                if (!empty($branch_filter) && !empty($team_filter) && is_numeric($team_filter)) {
                    $booking = Booking::where('team_id', '=', $team_filter)->get();
                    $branches = Branch::where('id', '=', $branch_filter)->get();

                } elseif (!empty($branch_filter)) {
                    $booking = Booking::where('branch_id', '=', $branch_filter)->get();
                    $branches = Branch::where('id', '=', $branch_filter)->get();
                }
            } else {

                if ((Auth::user()->type == 1)) {
                    $booking = Booking::all();
                    $branches = Branch::all();
                } elseif ((Auth::user()->type == 2) || (Auth::user()->type == 4)) {

                    $booking = Booking::where('branch_id', '=', Auth::user()->branch_id)->get();
                    $branches = Branch::where('id', '=', Auth::user()->branch_id)->get();

                }
            }
        }

        $data = [count($booking)];
        $i = 0;
        foreach ($booking as $book) {
            $data[$i] = new \stdClass();
            $data[$i]->id = $book->id;
            $data[$i]->title = $book->asset->name;
            $data[$i]->team = $book->team->name;
            $data[$i]->book_to = $book->book_to;
            $data[$i]->status = $book->status;
            $data[$i]->booking_date = $book->booking_date;
            $data[$i]->color = $book->asset->color;
            $data[$i]->branch = $book->branch->name;

            //create start at time string for booking events
            $time_str = $book->booking_date . 'T' . $book->book_from;
            $data[$i]->start_at = $time_str;

            //create end at time string for booking events
            $time_str_to = $book->booking_date . 'T' . $book->book_to;
            $data[$i]->end_at = $time_str_to;


            $i++;
        }
//        session(['filter_branch' => $request->branch]);
//        session(['filter_branch' => $request->team]);
//        $sdata = $_SESSION['filter_branch'];
        return response()->json(['data' => $data, 'branch' => $branches]);
    }

    public function finance()
    {
        if (Auth::user()->type == 1) {
            $invoices = Invoice::where('is_active', 1)->get();

        } else {
            $branch_id = Auth::user()->branch_id;
            $users = User::where('branch_id', '=', $branch_id)->get();
            $invoices = Invoice::where('branch_id', '=', $branch_id)->where('is_active', 1)->get();

        }
        foreach ($invoices as $key => $invoice) {
            $branch = Branch::find($invoice->branch_id);
            if (isset($branch->name)) {
                $invoices[$key]->branch_name = $branch->name;
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


        }
        return view('admin.finance', compact('invoices'));
    }

    public function profile()
    {
        return view('admin.profile');
    }

    public function user_profile($id)
    {
        $user = User::find($id);
        if ($user->type == 0 && $user->package_type != 0 && $user->status == 0) {
//            user is not approved so no team available
        } else {
            if (isset($user->team_id) && !empty($user->team_id)) {
                $team = Team::where('id', $user->team_id)->first();
            } else {
                $team = Team::where('leader_id', $id)->first();
            }
            $team_assets = Assetdetail::where('team_id', $team->id)->get();

            foreach ($team_assets as $key => $team_asset) {
                $asset = Asset::find($team_asset->asset_id);

                $team_assets[$key]->name = $asset->name;
                $team_assets[$key]->price = $asset->price;
                $team_assets[$key]->free_booking = $asset->free_booking;
                $team_assets[$key]->free_printing = $asset->free_printing;
            }
            $branch = Branch::find($team->branch_id);
        }
        $url = $_SERVER['REQUEST_URI'];
        $path = preg_replace('/\d/', '', $url);
        if (isset($path) && $path == '/admin/user/profile/') {
            if ($user->type == 0 && $user->package_type != 0 && $user->status == 0) {
                return view('admin.userPrivateProfile', compact('user'));
            } else {
                return view('admin.userPrivateProfile', compact('user', 'team', 'team_assets', 'branch'));
            }

        } elseif (isset($path) && $path == '/user/profile/') {
            if (isset($path) && $path == '/admin/user/profile/') {
                return view('userPrivateProfile', compact('user'));
            } else {
                //breadcrumbs
                $data = array();
                $data['breadcrumbs'] = array(['name'=>'Profile','active'=>true,'url'=>'']);
                return view('userPrivateProfile', compact('user', 'team', 'team_assets', 'branch','data'));
            }
        }

    }

    public function user_profile_lead_view($id)
    {
        $user = User::find($id);
        if ($user->type == 0 && $user->package_type != 0 && $user->status == 0) {
//            user is not approved so no team available
        } else {
            if (isset($user->team_id) && !empty($user->team_id)) {
                $team = Team::where('id', $user->team_id)->first();
            } else {
                $team = Team::where('leader_id', $id)->first();
            }
            $team_assets = Assetdetail::where('team_id', $team->id)->get();

            foreach ($team_assets as $key => $team_asset) {
                $asset = Asset::find($team_asset->asset_id);

                $team_assets[$key]->name = $asset->name;
                $team_assets[$key]->price = $asset->price;
                $team_assets[$key]->free_booking = $asset->free_booking;
                $team_assets[$key]->free_printing = $asset->free_printing;
            }
            $branch = Branch::find($team->branch_id);
        }

        return view('userPrivateProfileLeadView', compact('user', 'team', 'team_assets', 'branch'));

    }

    public function purchase()
    {
        return view('admin.purchasing');
    }

    public function support()
    {
        if (Auth::user()->type == 1) {
            $tickets = Ticket::all();
        } else {
            $branch_id = Auth::user()->branch_id;
            $tickets = Ticket::where('branch_id', '=', $branch_id)->get();

        }


        foreach ($tickets as $key => $ticket) {
            $user = User::find($ticket->user_id);
            if (isset($user) && $user->type == 2) {
                $team_id = $user->team_id;
                $team = Team::find($team_id);
                $tickets[$key]->team_name = $team->name;
                $branch = Branch::find($team->branch_id);
                $tickets[$key]->team_branch = $branch->name;
                $tickets[$key]->user_role = "Member";
            } else {
                $team = Team::where('leader_id', '=', $user->id)->first();
                $tickets[$key]->team_name = $team->name;
                $branch = Branch::find($team->branch_id);
                $tickets[$key]->team_branch = $branch->name;
                $tickets[$key]->user_role = "Leader";
            }
        }

        return view('admin.support', compact('tickets'));

    }


    public function teams()
    {

        if (Auth::user()->type == 1) {
            $teams = Team::all();
        } else {
            $branch_id = Auth::user()->branch_id;
            $teams = Team::where('branch_id', '=', $branch_id)->get();

        }

        return view('admin.teams', compact('teams'));

    }

    public function tasks()
    {
        if (Auth::user()->type == 1) {
            $tasks = Task::all();

        } elseif (Auth::user()->type == 2) {
            $branch_id = Auth::user()->branch_id;
            $tasks = Task::where('branch_id', '=', $branch_id)->get();
        } elseif (Auth::user()->type == 4) {
            $branch_id = Auth::user()->branch_id;
            $user_id = Auth::user()->id;
            $tasks = Task::where('branch_id', '=', $branch_id)->where('assignee', $user_id)->get();
        }


        foreach ($tasks as $key => $task) {
            $admin = Admin::find($task->assignee);
            if (!empty($admin)) {
                $tasks[$key]->user_name = $admin->name;
            }
        }

        return view('admin.tasks', compact('tasks'));
    }

    public function announcements()
    {

        if (Auth::user()->type == 1) {
            $announcements = Announcement::all();
        } else {
            // $branch_id = Auth::user()->branch_id;
            $announcements = Auth::user()->branch->announcement()->get();
            // $announcements = Announcement::where('branch_id', '=', $branch_id)->get();

        }
        // dd(Auth::user()->branch);
        // dd(Auth::user()->branch->announcement);
        return view('admin.announcements', compact('announcements'));
    }


    public function getAdminChannelChat()
    {
        return view('admin.channel');
    }

    public function getAdminGroupChat()
    {
        return view('admin.group');
    }

    public function getAdminUserChat($id)
    {
        $user = User::find($id);
        return view('admin.userChat', compact('user'));
    }

    //user profile
    public function userProfile($id)
    {
        return view('admin.userProfile');
    }

    //create new invoice
    public function createInvoice($id)
    {

        $users = User::where('id', '=', $id)->get();
        return view('admin.createInvoice', compact('users'));
    }

    //create manual invoice for team
    public function createManualInvoice($id)
    {

        $users = User::where('id', '=', $id)->get();
        return view('admin.createInvoice', compact('users'));
    }

    //specific user data
    public function userDetail($id)
    {
        $user = User::find($id);
        return response()->json($user);
    }

    public function getTeamsOnBranch(Request $request)
    {

        $teams = Team::where('branch_id', '=', $request->branch)->get()->all();
        return response()->json($teams);
    }

    public function editRecInvoicePost(Request $request)
    {
        dd($request);
    }


    //create Invoice Post (for walking nomads)
    public function createInvoicePost(Request $request)
    {
        if (!empty($request)) {

            $team = Team::where('leader_id', '=', $request->new_invoice_user)->first();
            $invoice = new Invoice;
            $asset_price = 0;
            foreach ($request->item_price as $price) {
                $asset_price += $price;
            }
            $amount_without_charges = $asset_price;

            if (!($request->new_invoice_disount == 0)) {
                $invoice->discount_amount = ($request->new_invoice_disount / 100) * $asset_price;

                $asset_price = $asset_price - (($request->new_invoice_disount / 100) * $asset_price);
            } else {
                $invoice->discount_amount = 0;

            }
            if (!($request->new_invoice_tax == 0)) {
                $invoice->tax_amount = ($request->new_invoice_tax / 100) * $asset_price;

                $asset_price = $asset_price + (($request->new_invoice_tax / 100) * $asset_price);
            } else {
                $invoice->tax_amount = 0;

            }
            $a = $request->item_name;
            $b = $request->item_price;

            $new_assets = array();


            $assets = array_combine($a, $b);

//            print_r($assets);

//        print_r($asset_price);echo "without". $amount_without_charges;die;

            $invoice->amount = $asset_price;

            $invoice->branch_id = $team->branch_id;
            $invoice->is_walking = $team->is_walking;
            $invoice->bill_to_name = $request->new_invoice_user_name;
            $invoice->bill_to_address = $request->new_invoice_user_address;
            $invoice->team_id = $team->id;
            $invoice->tax = $request->new_invoice_tax;
            $invoice->wallet_type = 1;
            $invoice->discount = $request->new_invoice_disount;
            $invoice->description = $request->new_invoice_payment_note;
            $invoice->invoice_date = $request->new_invoice_date;
            $invoice->invoice_due_date = $request->new_invoice_due_date;
            $invoice->amount = $amount_without_charges;
            $invoice->total = $asset_price;
            if ($invoice->save()) {
                $this->AddToLog("Invoice for   $invoice->bill_to_name   created successfully");
                foreach ($assets as $key => $asset) {

                    $invoice_item = new InvoiceItem();
                    $invoice_item->team_id = $invoice->team_id;
                    $invoice_item->branch_id = $invoice->branch_id;
                    $invoice_item->invoice_id = $invoice->id;
                    $invoice_item->item = $key;
                    $invoice_item->qty = 1;
                    $invoice_item->price = $asset;
                    $invoice_item->total = $asset;
                    $invoice_item->is_active = 1;
                    $invoice_item->save();
                }
            }

            //                send invoice to user as email code
            $invoice_email = new ContractController();
            $invoice_email->sendInvoice($invoice->id);

            $this->assetAddMakePayment($invoice->team_id, $invoice->id);



//
            $request->session()->flash('Success', 'Invoice for ' . $invoice->bill_to_name . ' created successfully');
            return redirect('/admin/finance');
        }

    }

    //create manual Invoice Post (for team)
    public function createManualInvoicePost(Request $request)
    {
        if (!empty($request)) {

            $team = Team::where('leader_id', '=', $request->new_invoice_user)->first();
            $invoice = new Invoice;
            $asset_price = 0;
            foreach ($request->rec_item_price as $price) {
                $asset_price += $price;
            }
            $amount_without_charges = $asset_price;

            if (!($request->new_invoice_disount == 0)) {
                $invoice->discount_amount = ($request->new_invoice_disount / 100) * $asset_price;

                $asset_price = $asset_price - (($request->new_invoice_disount / 100) * $asset_price);
            } else {
                $invoice->discount_amount = 0;

            }
            if (!($request->new_invoice_tax == 0)) {
                $invoice->tax_amount = ($request->new_invoice_tax / 100) * $asset_price;

                $asset_price = $asset_price + (($request->new_invoice_tax / 100) * $asset_price);
            } else {
                $invoice->tax_amount = 0;

            }
            $a = $request->item_name;
            $b = $request->item_price;

            $new_assets = array();


            $assets = array_combine($a, $b);

//            print_r($assets);

//        print_r($asset_price);echo "without". $amount_without_charges;die;

            $invoice->amount = $asset_price;

            $invoice->branch_id = $team->branch_id;
            $invoice->is_walking = $request->is_walking;
            $invoice->bill_to_name = $request->bill_to_name;
            $invoice->bill_to_address = $request->bill_to_address;
            $invoice->team_id = $team->id;
            $invoice->tax = $request->tax;
            $invoice->wallet_type = 1;
            $invoice->discount = $request->discount;
            $invoice->description = $request->description;
            $invoice->invoice_date = $request->invoice_date;
            $invoice->invoice_due_date = $request->invoice_due_date;
            $invoice->amount = $amount_without_charges;
            $invoice->total = $asset_price;
            if ($invoice->save()) {
                $this->AddToLog("Invoice for  $invoice->bill_to_name  and invoice# $invoice->id and team# $invoice->team_id created successfully");

                foreach ($assets as $key => $asset) {

                    $invoice_item = new InvoiceItem();
                    $invoice_item->team_id = $invoice->team_id;
                    $invoice_item->branch_id = $invoice->branch_id;
                    $invoice_item->invoice_id = $invoice->id;
                    $invoice_item->item = $key;
                    $invoice_item->qty = 1;
                    $invoice_item->price = $asset;
                    $invoice_item->total = $asset;
                    $invoice_item->is_active = 1;
                    $invoice_item->save();
                }
            }

            //                send invoice to user as email code
            $invoice_email = new ContractController();
            $invoice_email->sendInvoice($invoice->id);

//

            $request->session()->flash('Success', 'Invoice for ' . $invoice->bill_to_name . ' created successfully');
            return redirect('/admin/finance');
        }

    }


    /***************************Anouncements Actions***************************/

    public function storeAnnouncement(Request $request)
    {
//        $announcement = new Announcement;
//        $announcement->title = $request->title;
//        $announcement->description = $request->description;
//        $announcement->status = 0;
//        $announcement->branch_id = $request->branch;
//        $announcement->admin_id = Auth::user()->id;

        $title = preg_replace('/[^-a-zA-Z0-9.]/', '_', $request->title);
        $final_image = $title . $request->image;
//        return response()->json(['Error' => $request->branch], 500);

        if (isset($request->branch) && count($request->branch) > 0) {
//            foreach ($request->branch as $branch) {

                $announcement = new Announcement;
                $announcement->title = $request->title;
                $announcement->description = $request->description;
                $announcement->type = $request->type;
                $announcement->status = 1;
//                $announcement->branch_id = $branch;
                $announcement->admin_id = Auth::user()->id;
                $announcement->image = strtolower($final_image);
                $announcement->save();
                $announcement->branch()->attach($request->branch);
                foreach ($request->branch as $branch){
                    $this->AddToLog("Announcement / Event $announcement->title for branch# $branch added successfully ");
                    $this->sendNotificationBranchAdmin($branch);
                    $this->sendNotificationAnnouncementSuperAdmin($branch);
                }


//            }
            return response()->json(['msg' => 'Announcement added successfully']);

        }
        return response()->json(['msg' => 'Select all fields'], 500);


    }

    public function statusChange($accountment_id, $status)
    {
        $announcement = Announcement::find($accountment_id);

        $announcement->status = $status;
        $statusupdate = $announcement->save();
        if ($statusupdate) {
            foreach ($announcement->branch as $branch){
                $this->AddToLog("Announcement / Event status of $announcement->title for branch# $branch->id updated successfully ");
                $this->sendNotificationBranchAdmin($branch);
                $this->sendNotificationBranchUsers($branch);
            }

            return response()->json(['status' => 'success']);
        }

    }

    public function editAnnouncement($id)
    {
        $announcement = Announcement::with('branch')->find($id);
        $branches = Branch::all();
        return response()->json(['announcement' => $announcement, 'branches' => $branches]);
    }

    public function updateAnnouncement(Request $request, $id)
    {
        $announcement = Announcement::find($id);
        $announcement->title = $request->title;
        $announcement->description = $request->description;
        $announcement->type = $request->type;
//        $announcement->branch_id = $request->branch;


        if (empty($request->image)) {

        } else {
            $title = preg_replace('/[^-a-zA-Z0-9.]/', '_', $request->title);
            $final_image = $title . $request->image;
            $announcement->image = strtolower($final_image);

        }


        $updated = $announcement->save();
        if ($updated) {
            //remove all
            $announcement->branch()->detach();
            $announcement->branch()->attach($request->branch);
//            $this->AddToLog("Announcement $announcement->title for branch# $announcement->branch_id updated successfully ");
            foreach ($request->branch as $branch){
                $this->AddToLog("Announcement / Event $announcement->title for branch# $branch updated successfully ");
            }

            return response()->json(['success' => 'Announcement / Event updated successfully']);
        }
        return response()->json(['error' => 'error']);
    }

    public function deleteAnnouncement($id)
    {

        $announcement = Announcement::find($id);
        $deleted = $announcement->delete();
        if ($deleted) {
            foreach ($announcement->branch as $branch) {
                $this->AddToLog("Announcement / Event $announcement->title for branch# $branch->id deleted successfully ");
            }

            return response()->json(['success' => 'Announcement / Event deleted successfully']);
        }
    }

    public function ticketStatusChange($ticket_id, $status, Request $request)
    {
        $ticket = Ticket::find($ticket_id);
        $ticket->status = $status;
        $ticket->resolved = $request->comment;
        $statusupdate = $ticket->save();
        if ($statusupdate) {

            $this->AddToLog("Ticket status of ticket# $ticket_id updated successfully ");
            $this->sendNotificationReplyTicketStatusToAdmins($ticket_id, $status);
            $this->sendNotificationReplyTicketStatusToUser($ticket_id, $status);
            return response()->json(['status' => 'success', 'msg' => 'Ticket status changed']);
            location . reload();
        }
        return response()->json(['msg' => 'Ticket status not changed'], 404);
        location . reload();
    }

    public function adminSupportChat($id)
    {
        $ticket = Ticket::find($id);
        $messages = $ticket->details()->get();
        return view('admin.supportchat', compact('ticket', 'messages'));
    }

    pubLic function adminSendMsg(Request $request, $id)
    {
        $request->merge(
            [
                'ticket_id' => $id,
                'sender_user' => false
            ]
        );
        $sent = TicketDetail::create($request->all());
        if ($sent) {
            $this->AddToLog("Reply sent to ticket# $id successfully");
            $this->sendNotificationReplyTicketToAdmins($id);
            $this->sendNotificationReplyTicketToUser($id);
            return response()->json(['status' => 'success', 'msg' => 'Message sent']);
        }
        return response()->json(['msg' => 'Message not created'], 404);
    }

    //////////////////////////Calender Booking///////////////////

    public function getBooking(Request $request)
    {


//        if (!empty($request->branch) || !empty($request->team)) {
//            if (!empty($request->branch) && !empty($request->team)){
//                $team = Team::find($request->team);
//                $booking = Booking::where('branch_id', '=', $team->branch_id)->get();
//                $branches = Branch::where('id', '=', $request->branch)->get();
//
//            }elseif (!empty($request->branch)){
//                $booking = Booking::where('branch_id', '=', $request->branch)->get();
//                $branches = Branch::where('id', '=', $request->branch)->get();
//            }
//        } else {

        $booking = array();
        $branches = array();
        if (!empty(session('filter_branch')) || !empty(session('filter_team'))) {


            if (!empty(session('filter_branch')) && !empty(session('filter_team'))) {
                $booking = Booking::where('team_id', '=', session('filter_team'))->get();
                $branches = Branch::where('id', '=', session('filter_branch'))->get();

            } elseif (!empty($_SESSION['filter_branch'])) {
                $booking = Booking::where('branch_id', '=', session('filter_branch'))->get();
                $branches = Branch::where('id', '=', session('filter_branch'))->get();
            }
        } else {

            if ((Auth::user()->type == 1)) {
                $booking = Booking::all();
                $branches = Branch::all();
            } elseif ((Auth::user()->type == 2) || (Auth::user()->type == 4)) {

                $booking = Booking::where('branch_id', '=', Auth::user()->branch_id)->get();
                $branches = Branch::where('id', '=', Auth::user()->branch_id)->get();

            }
        }


        $data = [count($booking)];
        $i = 0;
        foreach ($booking as $book) {
            $data[$i] = new \stdClass();
            $data[$i]->id = $book->id;
            $data[$i]->title = $book->asset->name;
            $data[$i]->team = $book->team->name;
            $data[$i]->book_to = $book->book_to;
            $data[$i]->status = $book->status;
            $data[$i]->booking_date = $book->booking_date;
            $data[$i]->color = $book->asset->color;
            $data[$i]->branch = $book->branch->name;

            //create start at time string for booking events
            $time_str = $book->booking_date . 'T' . $book->book_from;
            $data[$i]->start_at = $time_str;

            //create end at time string for booking events
            $time_str_to = $book->booking_date . 'T' . $book->book_to;
            $data[$i]->end_at = $time_str_to;


            $i++;
        }
//        session(['filter_branch' => $request->branch]);
//        session(['filter_branch' => $request->team]);
//        $sdata = $_SESSION['filter_branch'];
        return response()->json(['data' => $data, 'branch' => $branches]);
    }

    /*********************Groups Actions**************************/
//    public function addUserToGroup(Request $request)
//    {
//
//        $group = new Group;
//        $group->name = $request->groupname;
//        $groupadded = $group->save();
//
//        if ($groupadded) {
//            $groupid = $group->id;
//
//            foreach ($request->users as $user) {
//                $groupmember = new GroupMember();
//                $groupmember->user_id = $user;
//                $groupmember->group_id = $groupid;
//                $groupmember->save();
//
//
//            }
//        }
//        return response()->json($request);
//
//
//    }
//
//    public function usersGroupDropDown()
//    {
//        $users = User::all();
//        return response()->json($users);
//    }
//
//    public function getGroupsChannels()
//    {
//        $groups = Group::all();
//        $channels = Channel::all();
//        $users = User::all();
//        $admins = Admin::all();
//
//        return response()->json(['channels' => $channels, 'groups' => $groups, 'users' => $users, 'admins' => $admins]);
//    }
//
//    public function getGroupChat($id)
//    {
//        $groups = Group::all();
//        return ['status' => 'success'];
//    }

    /********************Channel Actions******************************/

    public function addChannelUser(Request $request)
    {

        $channel = new Channel;
        $channel->name = $request->channelname;
        $channeladded = $channel->save();
        if ($channeladded) {
            $channelid = $channel->id;

            foreach ($request->users as $user) {
                $channelmember = new ChannelMember();
                $channelmember->user_id = $user;
                $channelmember->channel_id = $channelid;
                $channelmember->save();


            }
        }
        return response()->json(['success' => 'Added Successfully channel with users']);
    }

    public function adminGroupDropDown()
    {

        if (Auth::user()->type == 1) {
            $branches = Branch::all();
        } else {
            $branch_id = Auth::user()->branch_id;
            $branches = Branch::where('id', '=', $branch_id)->get();
        }


        return response()->json(['branches' => $branches]);
    }

    public function adminTaskAssignee(Request $request)
    {


        $branch_id = $request->branch_id;
        $users = Admin::where('branch_id', '=', $branch_id)->get();
        if (count($users) == 0) {
            $error_msg = "No User Found!";
            return response()->json(['users' => $users, 'error_msg' => $error_msg]);

        }

        return response()->json(['users' => $users]);

    }

    public function adminTaskReAssignee(Request $request)
    {
        $task = Task::find($request->task_id);
        if (!empty($task)) {
            $branch_id = $task->branch_id;
            $users = Admin::where('branch_id', '=', $branch_id)->get();
            if (count($users) == 0) {
                $error_msg = "No User Found!";
                return response()->json(['users' => $users, 'error_msg' => $error_msg]);

            }
        }


        return response()->json(['users' => $users]);

    }

    public function createTask(Request $request) //updated
    {
        $task = new Task();
        $task->title = $request->admin_task_title;
        $task->description = $request->admin_task_description;
        $task->status = 0;
        $task->due = date('Y-m-d', strtotime($request->task_time_hours_due));
        $task->assignee = $request->admin_task_assign;
        $task->branch_id = $request->branch;
        $task->taskPriority = 0;
        $saved = $task->save();
        $this->AddToLog("Task $task->title created successfully");

        if ($saved) {
            $this->sendNotificationTasksAdmin($task->assignee, $task->title);
            $this->sendNotificationTasksSuperAdmin($task->assignee);
            return ['status' => 'success'];
        } else
            return response()->json(['msg' => 'Task not created'], 404);
    }

    public function reassignTask(Request $request)

    {
//        return ['status'=>'success'];

        $task = Task::find($request->task_id);
        $task->assignee = $request->assign_to;
        $updated = $task->save();
        if ($updated) {
            $this->AddToLog("Task $task->title updated successfully");

            return ['status' => 'success'];
        } else {
            return response()->json(['msg' => 'Task  not reassigned'], 404);
        }

    }


    /*******************Team Actions***********************/
    public function teamInsert(Request $request)
    {

        $user = User::find($request->teamLeader);
        $team = new Team;
        $team->name = $request->teamName;
        $team->leader_id = $request->teamLeader;
        $team->branch_id = $user->branch_id;

        $user->type = 1;
        $added = $team->save();
        $user->save();
        if ($added) {
            return response()->json(['success' => 'successfully Added']);
        }


    }

    public function getTeamLeaders()
    {

        $users = User::where('type', '=', null)->get()->all();
        return response()->json($users);
    }

    public function getAllTeams()
    {

        $teams = Team::all();
        return response()->json($teams);
    }

    public function getTeamMembers()
    {

        $users = User::where('type', '=', '2')->orWhere('type', '=', null)->get();
        return response()->json($users);
    }


    public function editTeamModal($id)
    {
        $user = User::all();
        $team = Team::find($id);
        $teamLeader = $team->user_leader;
        return response()->json(['users' => $user, 'team' => $team]);
    }

    public function updateAdminTeamModal(Request $request, $id)
    {
        $team_id = $id;
        $teamName = $request->teamName;
        $team_leader_id = $request->teamLeader;


        $users = User::where('team_id', '=', $team_id)->get()->all();


        $team = Team::find($team_id);
        $team->name = $teamName;
        $team->leader_id = $team_leader_id;
        $team->save();
        $this->AddToLog("Members Updated");
        return response()->json(['Success' => 'Members Successfully Updated']);
    }

    public function updateMembers(Request $request, $team_id)
    {

        $members = $request->members;

        $users = User::where('team_id', '=', $team_id)->get();
        foreach ($users as $user) {

            $user->team_id = null;

            $user->save();
        }

        $userWithNull = User::where('team_id', '=', null)->get()->all();
        if (isset($members)) {
            foreach ($members as $member) {

                $userWithNull = User::find($member);
                if ($userWithNull->type == null) {
                    $userWithNull->type = 2;
                }

                $userWithNull->team_id = $team_id;

                $userWithNull->save();

            }
        }
        return response()->json(['Success' => 'Updated Successfully']);


    }

    /*****************User Crud Modal Admin Side********************/

//package_type
// 0 =  Walking customer
// 1 =  Nomad
// 2 =  Resident

    public function insertUser(Request $request)
    {

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->type = 0;
        $user->avatar_url = '#';
        $user->contact_number = $request->contact_number;
        $user->address = $request->address;
        $user->branch_id = $request->branch;
        $user->cnic = $request->cnic;
        $user->dob_month = $request->dob_month;
        $user->dob_day = $request->dob_day;
        $user->dob_year = $request->dob_year;
        $user->city = $request->city;
        $age = date('Y') - $user->dob_year;

        $user->age = $age;

        if ($request->isWalking == 1) {
            $user->password = Hash::make("");
            $user->package_type = 0;
            $user->status = 1;

        } else {
            $user->password = Hash::make($request->password);
            $user->package_type = $request->packageType;
        }

        $find_user_by_email = User::where('email', '=', $request->email)->get();
        if (count($find_user_by_email) == 0) {
            if ($request->name == '') {
                $msg = "Enter Name";
                return response()->json(['msg' => $msg, 'data' => $find_user_by_email], 500);
            }
            if ($request->contact_number == '') {
                $msg = "Enter Contact Number";
                return response()->json(['msg' => $msg, 'data' => $find_user_by_email], 500);
            }

            if ($request->address == '') {
                $msg = "Enter address";
                return response()->json(['msg' => $msg, 'data' => $request->address], 500);
            }
            if ($request->email == '') {
                $msg = "Enter Email";
                return response()->json(['msg' => $msg, 'data' => $find_user_by_email], 500);
            }

            if ($request->city == '') {
                $msg = "Enter City";
                return response()->json(['msg' => $msg, 'data' => $find_user_by_email], 500);
            }
            if ($request->branch == 0) {
                $msg = "Select Branch";
                return response()->json(['msg' => $msg, 'data' => $find_user_by_email], 500);
            }
            if ($request->password == '') {
                $msg = "Enter password";
                return response()->json(['msg' => $msg, 'data' => $find_user_by_email], 500);
            }
            if ($request->cnic == '') {
                $msg = "Enter cnic";
                return response()->json(['msg' => $msg, 'data' => $find_user_by_email], 500);
            }

            if ($request->dob_day == '') {
                $msg = "Enter DOB Day";
                return response()->json(['msg' => $msg, 'data' => $find_user_by_email], 500);
            }
            if ($request->dob_month == '') {
                $msg = "Enter DOB Month";
                return response()->json(['msg' => $msg, 'data' => $find_user_by_email], 500);
            }
            if ($request->dob_year == '') {
                $msg = "Enter DOB Year";
                return response()->json(['msg' => $msg, 'data' => $find_user_by_email], 500);
            }
            if ($request->packageType == '') {
                $msg = "Enter Package Type";
                return response()->json(['msg' => $msg, 'data' => $request->packageType], 500);
            }

            $added = $user->save();

            if ($added) {
                $this->sendNotificationToAdminByBranch($user->id, $user->branch_id);
                $this->sendNotificationUserSuperAdmin($user->id, $user->branch_id);
                $this->AddToLog("User Added");
                if ($request->isWalking == 1) {
//            make team for walking customer
                    $team = new Team();
                    $team->name = $user->name;
                    $team->leader_id = $user->id;
                    $team->branch_id = $user->branch_id;
                    $team->is_walking = $request->isWalking;
                    $team->time_from = "00:00:00";
                    $team->time_to = '00:00:0';
                    $team->members_limit = 0;
                    $team->save();
                    $this->AddToLog("Nomad Team Added");

                }
                return response()->json(['success' => 'Successfully added']);

            }
        } else {
            $msg = "Duplicate Email";
            return response()->json(['msg' => $msg, 'data' => $find_user_by_email], 500);
        }


    }


    public function authUserStatus($id, $status)
    {
        $user = User::find($id);
        $user->status = $status;


        if ($user->save()) {
            $this->AddToLog("user status changed");

            if ($user->type == 1) {


                if ($status == 0) {


                    $team = Team::where('leader_id', $id)->first();
                    $team->is_active = 0;
                    $team->save();
                    $this->AddToLog("Team Inactivated");

                    $rec_invoice = RecurringInvoice::where('is_active', 1)->where('team_id', $team->id)->where('show_expired_section', 1)->first();
                    if (!empty($rec_invoice)) {
                        $rec_invoice->is_active = 0;
                        $rec_invoice->show_expired_section = 0;
                        $rec_invoice->save();
                        $this->AddToLog("Recurring Invoice Inactivated");

                    }

                    $team_users = User::where('team_id', $team->id)->get();
                    if (!empty($team_users)) {
                        foreach ($team_users as $team_user) {
                            $team_user->status = $status;
                            $team_user->save();
                            $this->AddToLog("Team member status changed");

                        }
                    }


                } elseif ($status == 1) {


                    $team = Team::where('leader_id', $id)->first();
                    $team->is_active = 1;
                    $team->save();
                    $this->AddToLog("Team Activated");

                    $rec_invoice = RecurringInvoice::where('is_active', 0)->where('team_id', $team->id)->where('show_expired_section', 0)->first();
                    if (!empty($rec_invoice)) {

                        $rec_inv_creation_month = date('m', strtotime($rec_invoice->created_at));
                        $total_month_rec_inv = $rec_inv_creation_month + $rec_invoice->month_cycles;
                        $current_month = date('m');

                        if ($current_month <= $total_month_rec_inv) {
                            $rec_invoice->is_active = 1;
                            $rec_invoice->show_expired_section = 1;

                        } else {
                            $rec_invoice->is_active = 0;
                            $rec_invoice->show_expired_section = 1;
                        }

                        $rec_invoice->save();
                        $this->AddToLog("Recurring Invoice Activated");

                    }

                    $team_users = User::where('team_id', $team->id)->get();
                    if (!empty($team_users)) {
                        foreach ($team_users as $team_user) {
                            $team_user->status = $status;
                            $team_user->save();
                            $this->AddToLog("Team member status changed");

                        }
                    }


                }


//                $team = Team::where('leader_id', $id)->first();
//
//                $team_users = User::where('team_id', $team->id)->get();
//                if (!empty($team_users)) {
//                    foreach ($team_users as $team_user) {
//                        $team_user->status = $status;
//                        $team_user->save();
//                        $this->AddToLog("Team member status changed");
//
//                    }
//                }

            }
        }


        return response()->json(['Success' => 'Successfully Updated']);

    }

    public function getBookingTeamsAndAssets($id)
    {
        $user = User::find($id);
        $teams = Team::all();
        return response()->json(['teams' => $teams, 'user' => $user]);
    }


//        public function getBookingTeamsAndAssets($id)
//        {
//            $user=User::find($id);
//            $teams=Team::all();
//            return response()->json(['teams'=>$teams,'user'=>$user]);
//        }

    public function calculateBillNomadCron()
    {
        $users = DB::select("select * from users where package_type = 1 and status =1 and is_active = 1");

        foreach ($users as $user) {
            $team = Team::where('leader_id', '=', $user->id)->first();
            $invoice_log = DB::select("select * from invoices where team_id = $team->id and wallet_type = 1 and is_active = 1 order by created_at  desc LIMIT 1 OFFSET 0");

            foreach ($invoice_log as $invoice_date) {
                $month_date = $invoice_date->created_at;
            }


            $now = date('Y-m-d');
            $nowstr = strtotime($now);
            $last_inv_date = strtotime($month_date);
            if ($nowstr > $last_inv_date) {
                $this->calculateBillNomad($user->id);
            }
        }

    }


    public function calculateBillNomad($user_id)
    {
//        $maxDays=date('t');
//        $month_days = $maxDays;
        $month_days = 30;
        $now = date('d');
        $bill_days = 0;
        $amount = 0;
        $user = User::find($user_id);
        $team = Team::where('leader_id', '=', $user->id)->first();
        $days_attended = AttendanceRecord::where('user_id', '=', $user->id)->count();


        $first_day_this_month = date('Y-m-01'); // hard-coded '01' for first day
        $last_day_this_month = date('Y-m-30');

        $first_day_this_month_str = strtotime($first_day_this_month);
        $last_day_this_month_str = strtotime($last_day_this_month);
        $current_month_days_attended = DB::select("select  count(*) as days from attendance_records where user_id = $user->id and date(created_at) between '$first_day_this_month' and '$last_day_this_month'");
        $current_month_days_attended_count = 0;
        foreach ($current_month_days_attended as $days) {
            $current_month_days_attended_count = $days->days;
        }

        if ($current_month_days_attended_count > 0 && $user->status = 1 && $user->is_active = 1) {
            $invoice = new Invoice();

            $teamAssets = Assetdetail::where('team_id', '=', $team->id)->get();
            foreach ($teamAssets as $key => $teamAsset) {

                $bill_days = $current_month_days_attended_count;
                $per_day_price = $teamAsset->asset->price;
                $total_price = $per_day_price * $bill_days;
                $amount = $amount + ($total_price * $teamAsset->quantity);

                $selected_asset_detail = Asset::find($teamAsset->asset_id);
                $teamAssets[$key]->name = $selected_asset_detail->name;
                $teamAssets[$key]->price = $selected_asset_detail->price;

            }
            $invoice->branch_id = $team->branch_id;
            $invoice->bill_to_name = $user->name;
            $invoice->bill_to_address = $user->address;
            $invoice->amount = $amount;
            $invoice->team_id = $team->id;
            $invoice->wallet_type = 1;
            $invoice->discount = 0;
            $invoice->description = "Auto invoice generation for nomad";
            $invoice->tax = 0;

            $nowDate = date('d-m-Y');;
            $invoice_date = date('d-m-Y', strtotime($nowDate));
            $due_date = strtotime($invoice_date) + (60 * 60 * 24) * (5);

            $invoice_due_date = date("d-m-y", $due_date);

            $invoice->invoice_date = $invoice_date;
            $invoice->invoice_due_date = $invoice_due_date;
            $invoice->total = $amount;
            $saved = $invoice->save();
            if ($saved) {
                foreach ($teamAssets as $asset) {
                    if (!($asset == null)) {
                        $invoice_item = new InvoiceItem();
                        $invoice_item->team_id = $team->id;
                        $invoice_item->invoice_id = $invoice->id;
                        $invoice_item->branch_id = $team->branch_id;
                        $invoice_item->item = $asset->name;
                        $invoice_item->qty = $asset->quantity;
                        $invoice_item->price = $asset->price;
                        $invoice_item->total = $amount;
                        $invoice_item->is_active = 1;
                        $invoice_item->save();

                    }

                }
            }
            print_r("Invoice generated successfully");
        }

        die;
        return response()->json(['success' => 'successfully updated']);

    }

    public function calculateBillResidentCron()
    {
        $rec_invoices = RecurringInvoice::where('is_active',1)->get();
        foreach ($rec_invoices as $key => $rec_invoice) {

            $rec_invoice_log_count = RecurringInvoiceLog::where('recurring_invoice_id', '=', $rec_invoice->id)->count();
            $rec_invoice_log = DB::select("select * from recurring_invoice_logs where recurring_invoice_id = $rec_invoice->id  order by monthDate  desc LIMIT 1 OFFSET 0");
            foreach ($rec_invoice_log as $rec_invoice_date) {
                $month_date = $rec_invoice_date->monthDate;
            }
            $now = date('m');
//            $nowstr = strtotime($now);
            $last_inv_date = date('m',strtotime($month_date));
//            print $now;echo"<br>";echo date('m',strtotime($month_date));die;
            if ($now > $last_inv_date) {

                if (isset($rec_invoice_log_count) && $rec_invoice_log_count > 0) {

                    if ($rec_invoice_log_count < $rec_invoice->month_cycles) {
                        $invoice = new Invoice();
                        $rec_invoice_id = $rec_invoice->id;
                        $rec_invoices[$key]->id = '';
                        unset($rec_invoices[$key]->invoice_id);
                        unset($rec_invoices[$key]->month_cycles);
                        unset($rec_invoices[$key]->created_at);
                        unset($rec_invoices[$key]->updated_at);

                        $now = date('d-m-Y');
                        $invoice_date = date('d-m-Y', strtotime($now));
                        $due_date = strtotime($invoice_date) + (60 * 60 * 24) * (5);

                        $invoice_due_date = date("d-m-y", $due_date);
                        $rec_invoices[$key]->invoice_date = $invoice_date;
                        $rec_invoices[$key]->invoice_due_date = $invoice_due_date;


                        $invoice->team_id = $rec_invoice->team_id;
                        $invoice->branch_id = $rec_invoice->branch_id;
                        $invoice->bill_to_name = $rec_invoice->bill_to_name;
                        $invoice->bill_to_address = $rec_invoice->bill_to_address;
                        $invoice->amount = $rec_invoice->amount;
                        $invoice->wallet_type = $rec_invoice->wallet_type;
                        $invoice->discount = $rec_invoice->discount;
                        $invoice->discount_amount = $rec_invoice->discount_amount;
                        $invoice->invoice_date = $rec_invoice->invoice_date;
                        $invoice->invoice_due_date = $rec_invoice->invoice_due_date;
                        $invoice->description = $rec_invoice->description;
                        $invoice->tax = $rec_invoice->tax;
                        $invoice->tax_amount = $rec_invoice->tax_amount;
                        $invoice->total = $rec_invoice->total;


                        $saved = $invoice->save();


                        if ($saved) {

                            $this->assetAddMakePayment($invoice->team_id, $invoice->id);


                            $teamAssets = Assetdetail::where('team_id', '=', $invoice->team_id)->get();
                            $amount = 0;
                            foreach ($teamAssets as $key => $teamAsset) {
                                $selected_asset_detail = Asset::find($teamAsset->asset_id);
                                $teamAssets[$key]->name = $selected_asset_detail->name;
                                $teamAssets[$key]->price = $selected_asset_detail->price;

                            }
                            foreach ($teamAssets as $asset) {
                                if (!($asset == null)) {
                                    $invoice_item = new InvoiceItem();
                                    $invoice_item->team_id = $invoice->team_id;
                                    $invoice_item->invoice_id = $invoice->id;
                                    $invoice_item->branch_id = $invoice->branch_id;
                                    $invoice_item->item = $asset->name;
                                    $invoice_item->qty = $asset->quantity;
                                    $invoice_item->price = $asset->price;
                                    $invoice_item->total = $asset->price * $asset->quantity;
                                    $invoice_item->is_active = 1;
                                    $invoice_item->save();

                                }

                            }

                            $month = Invoice::find($invoice->id);
                            $recurring_invoice_log = new RecurringInvoiceLog;
                            $recurring_invoice_log->recurring_invoice_id = $rec_invoice_id;
                            $recurring_invoice_log->branch_id = $rec_invoice->branch_id;
                            $recurring_invoice_log->monthDate = date('Y-m-d', strtotime($month->created_at));
                            $recurring_invoice_log->save();
                        }

                        print_r("invoice created");

                    } else {
                        if (isset($rec_invoice_log_count) && $rec_invoice_log_count > 0) {

                            if ($rec_invoice_log_count == $rec_invoice->month_cycles) {
                                $rec_invoice->is_active = 0;
                                $rec_invoice->save();

                            }
                        }
                    }


                }

            }

        }

    }

    public function updateApprovalNomad(Request $request, $id)
    {

        $user = User::find($id);
        $assetsNew = DB::select("select * from assets where is_nomad = 1 and branch_id = $user->branch_id");
        if (isset($assetsNew) && !empty($assetsNew)) {
            if (empty($request->team)) {
                $error = "Please Enter Team Name!";
                return response()->json(['error' => $error], 500);
            }
            $all_teams = Team::all();
            foreach ($all_teams as $team) {

                if ($team->name == $request->team && $team->branch_id == $user->branch_id) {
                    $error = "Team Already Exists!";
                    return response()->json(['error' => $error], 500);
                }
            }
            $team = new Team();

            $team->name = $request->team;
            $team->leader_id = $id;
            $team->branch_id = $user->branch_id;
            $team->time_from = date('H:i', strtotime($request->time_from));
            $team->time_to = date('H:i', strtotime($request->time_to));
            $team->members_limit = 1;
            $team->guests_per_day = $request->guests_per_day;

            $teamAdded = $team->save();
            if ($teamAdded) {


                foreach ($assetsNew as $key => $asset) {
                    if (!($asset == null)) {
                        $assigned = new Assetdetail();
                        $assigned->asset_id = $asset->id;
                        $assigned->quantity = 1;
                        $assigned->team_id = $team->id;
                        $assigned->save();
                    }

                }

                $user->type = $request->userType;
                $user->status = 1;
                $saved = $user->save();
                if ($saved) {
                    $this->AddToLog("Nomad User $user->name Added in branch $team->branch_id and have user id $user->id");

//                $fix_deposit_invoice_id = $this->autoGenerateInvoice($team->id, 1, 'Auto generated invoice for Nomad Fixed Deposit billing of non-bookable assets', 0, 0, 'Deposit', '0', '0', $team->branch_id);
//
//                if ($fix_deposit_invoice_id) {
//                    foreach ($assetsNew as $asset) {
//                        if (!($asset == null)) {
//                            $invoice_item = new InvoiceItem();
//                            $invoice_item->team_id = $team->id;
//                            $invoice_item->invoice_id = $fix_deposit_invoice_id;
//                            $invoice_item->branch_id = $team->branch_id;
//                            $invoice_item->item = $asset->name . " fix deposit";
//                            $invoice_item->qty = 1;
//                            $invoice_item->price = $asset->fixed_deposit;
//                            $invoice_item->total = $asset->fixed_deposit * 1;
//                            $invoice_item->is_active = 1;
//                            $invoice_item->save();
//
//                        }
//
//                    }
//                }

//                    $user->verifyToken = Str::random(40);
                    $user->verifyToken=null;
                    $user->contract=1;
                    $user->save();

//                    Mail::to($user->email)->send(new verifyContract($user));

                    return response()->json(['success' => 'successfully updated']);
                }


            }
        }
        return response()->json(['error' => 'Please register <b><u>Nomad Asset first</u></b> from store'], 500);

    }

    public function updateApprovalLead(Request $request, $id)
    {
        $fix_deposit_invoice_id = 0;
        $user = User::find($id);

        $assets = $request->assets;

        $result = json_decode($assets);

        $assetsNew = str_replace('/\/', '', $result);

        foreach ($assetsNew as $asset) {
            if (isset($asset) && isset($asset->quantity)) {
                if (isset($asset->asset_id) && !is_numeric($asset->asset_id) || isset($asset->quantity) && empty($asset->quantity)) {

                    $error = "Assign valid item/quantity!";
                    return response()->json(['error' => $error, 'data' => $assetsNew], 500);
                }
            }
        }

        if (isset($assetsNew) && !empty($assetsNew)) {

            if (empty($request->team)) {
                $error = "Please Enter Team Name!";
                return response()->json(['error' => $error], 500);
            }
            $all_teams = Team::all();
            foreach ($all_teams as $team) {
                if ($team->name == $request->team && $team->branch_id == $user->branch_id) {
                    $error = "Team Already Exists!";
                    return response()->json(['error' => $error], 500);
                }
            }

            $team = new Team();

            $team->name = $request->team;
            $team->leader_id = $id;
            $team->branch_id = $user->branch_id;
            $team->time_from = date('H:i', strtotime($request->team_time_limit_from));
            $team->time_to = date('H:i', strtotime($request->team_time_limit_to));
            $team->members_limit = $request->team_members_limit;
            $team->guests_per_day = $request->team_guests_limit;
            $team->membership_price = 0;

            $teamAdded = $team->save();
            if ($teamAdded) {
                $this->sendNotificationApprovedLead($team->id);

                foreach ($assetsNew as $key => $asset) {
                    if (!($asset == null)) {
                        $assigned = new Assetdetail();
                        $assigned->asset_id = $asset->asset_id;
                        $assigned->quantity = $asset->quantity;
                        $assigned->team_id = $team->id;
                        $assigned->save();

                        $selected_asset_detail = Asset::find($assigned->asset_id);
                        $assetsNew[$key]->name = $selected_asset_detail->name;
                        $assetsNew[$key]->price = $selected_asset_detail->price;
                        $assetsNew[$key]->fixed_deposit = $selected_asset_detail->fixed_deposit;


                    }

                }

                $user->type = $request->userType;
                $user->status = 1;
                $user->contract = 0;
                $saved = $user->save();
                if ($saved) {
                    $this->AddToLog("New Team $team->name in branch $team->branch_id having leader $user->name Added  and have user id $user->id");

                    $fix_deposit_invoice_id = $this->autoGenerateInvoice($team->id, 1, 'Auto generated invoice for Fixed Deposit billing of non-bookable assets', 0, 0, 'Deposit', '0', '0', $team->branch_id);

                    if ($fix_deposit_invoice_id) {
                        foreach ($assetsNew as $asset) {
                            if (!($asset == null)) {
                                $invoice_item = new InvoiceItem();
                                $invoice_item->team_id = $team->id;
                                $invoice_item->invoice_id = $fix_deposit_invoice_id;
                                $invoice_item->branch_id = $team->branch_id;
                                $invoice_item->item = $asset->name . " fix deposit";
                                $invoice_item->qty = $asset->quantity;
                                $invoice_item->price = $asset->fixed_deposit;
                                $invoice_item->total = $asset->fixed_deposit * $asset->quantity;
                                $invoice_item->is_active = 1;
                                $invoice_item->save();

                            }

                        }
                    }

                    $invoiceId = $this->autoGenerateInvoice($team->id, 1, 'Auto Invoice generate for billing non-bookable assets', $request->tax, $request->discount, 'Asset', 0, '0', $team->branch_id);
                    if ($invoiceId) {
                        foreach ($assetsNew as $asset) {
                            if (!($asset == null)) {
                                $invoice_item = new InvoiceItem();
                                $invoice_item->team_id = $team->id;
                                $invoice_item->invoice_id = $invoiceId;
                                $invoice_item->branch_id = $team->branch_id;
                                $invoice_item->item = $asset->name;
                                $invoice_item->qty = $asset->quantity;
                                $invoice_item->price = $asset->price;
                                $invoice_item->total = $asset->price * $asset->quantity;
                                $invoice_item->is_active = 1;
                                $invoice_item->save();

                            }

                        }
                    }


                    if ($request->recurringOption == 1) {

                        $recurring_invoice_id = $this->autoGenerateInvoice($team->id, 1, 'Auto Invoice generate for billing non-bookable assets', $request->tax, $request->discount, 'recurrAsset', $invoiceId, $request->recurringCycles, $team->branch_id);
                        if ($recurring_invoice_id) {
                            foreach ($assetsNew as $asset) {
                                if (!($asset == null)) {
                                    $invoice_item = new RecurringInvoiceItem();
                                    $invoice_item->team_id = $team->id;
                                    $invoice_item->invoice_id = $recurring_invoice_id;
                                    $invoice_item->branch_id = $team->branch_id;
                                    $invoice_item->item = $asset->name;
                                    $invoice_item->qty = $asset->quantity;
                                    $invoice_item->price = $asset->price;
                                    $invoice_item->total = $asset->price * $asset->quantity;
                                    $invoice_item->is_active = 1;
                                    $invoice_item->save();

                                }

                            }
                            $month = Invoice::find($invoiceId);
                            $recurring_invoice_log = new RecurringInvoiceLog;
                            $recurring_invoice_log->recurring_invoice_id = $recurring_invoice_id;
                            $recurring_invoice_log->branch_id = $team->branch_id;
                            $recurring_invoice_log->monthDate = date('Y-m-d', strtotime($month->created_at));
                            $recurring_invoice_log->save();

                        }

                    }


                    $transaction_booking = new Transaction;
                    $admin = Admin::find(Auth::id());
                    $transaction_date = date('Y-m-d');
                    $transaction_booking->transaction_date = $transaction_date;
                    $transaction_booking->admin_id = $admin->id;
                    $transaction_booking->type = 1;
                    $teamAssets = Assetdetail::where('team_id', '=', $team->id)->get();
                    $free_booking_price = 0;
                    foreach ($teamAssets as $asset) {
                        $free_booking_price = $free_booking_price + ($asset->asset->free_booking);
                    }
                    $transaction_booking->amount = $free_booking_price;
                    $transaction_booking->branch_id = $team->branch_id;
                    $transaction_booking->team_id = $team->id;
                    $transaction_booking->note = "Free monthly booking credit";
                    $transaction_booking->payment_type = 2;
                    $transaction_booking->wallet_type = 2;
                    $transaction_booking->save();

                    $transaction_printing = new Transaction;
                    $admin = Admin::find(Auth::id());
                    $transaction_date = date('Y-m-d');
                    $transaction_date = date('Y-m-d');
                    $transaction_printing->transaction_date = $transaction_date;
                    $transaction_printing->admin_id = $admin->id;
                    $transaction_printing->type = 1;
                    $teamAssets = Assetdetail::where('team_id', '=', $team->id)->get();
                    $free_printing_price = 0;
                    foreach ($teamAssets as $asset) {
                        $free_printing_price = $free_printing_price + ($asset->asset->free_printing);
                    }
                    $transaction_printing->amount = $free_printing_price;
                    $transaction_printing->branch_id = $team->branch_id;
                    $transaction_printing->team_id = $team->id;
                    $transaction_printing->note = "Free monthly printing credit";
                    $transaction_printing->payment_type = 2;
                    $transaction_printing->wallet_type = 3;
                    $transaction_printing->save();


                }


            }

            $user->verifyToken = Str::random(40);
            $user->save();

            $team = Team::where('leader_id',$user->id)->first();
            if (isset($team) && !empty($team)){
                $fix_deposit = Invoice::find($fix_deposit_invoice_id);

                $team->membership_price = $fix_deposit->total;
                $team->save();
            }

            $contract_email_email = new ContractController();
            $contract_email_email->verifyContract($user->id);

//            Mail::to($user->email)->send(new verifyContract($user));
            return response()->json(['success' => 'successfully updated']);
        }
        $error = "Error in assign item to team";
        return response()->json(['error' => $error, 'data' => $assetsNew], 500);

    }

    public function updateApprovalMember(Request $request, $id)
    {

        $team_members_count = User::where('team_id', $request->team_id)->where('is_active', 1)->where('status', 1)->count();
        $team = Team::find($request->team_id);
//        return response()->json(['Success' => $team->members_limit,'count'=>$team_members_count],500);

//dd( $team_members_count);
        $team_members_count += 2;
        if ($team_members_count <= $team->members_limit) {
            $user = User::find($id);
            $user->team_id = $request->team_id;
            $user->type = $request->userType;
            $user->status = 1;
            $user->contract = 1;
            $user->save();
            $this->AddToLog("New Team Member added in $team->name of branch $team->branch_id  Added with user id $user->id and user name $user->name");

            $this->sendNotificationApprovedMember($request->team_id);


            $contract_email_email = new ContractController();
            $contract_email_email->verifyContract($user->id);

            return response()->json(['Success' => 'Successfully update']);
        } else {
            return response()->json(['error' => 'Team members limit of ' . $team->name . '  exceeded, please contact to super admin'], 500);
        }


    }

    public function teamDropDown($id)
    {
        $user = User::find($id);
        $teams = Team::where('branch_id', $user->branch_id)->get();
        return response()->json($teams);
    }


    public function AuthstatusUpdateByTeam(Request $request, $id)
    {
        $user = User::find($id);
        $user->team_id = $request->team;
        $user->status = 1;
        $user->save();
        return response()->json(['success' => 'successfully updated']);


    }

    public function userEditBasic($id)
    {
        $user = User::find($id);
        return response()->json($user);
    }

    public function userEditBasicUpdate(Request $request, $id)
    {
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->contact_number = $request->contactNumber;
        $user->address = $request->address;
        if (!empty($request->password)) {
            $user->password = Hash::make($request->password);
        }
        $user->save();
        $this->AddToLog("User Updated");

        return response()->json(['Success' => 'Successfully Edited']);
    }

    /**********************End user Crud************************/


    public function editTask($id)
    {
        $task = Task::find($id);
        $branches = Branch::all();
        return response()->json(['task' => $task, 'branches' => $branches]);
    }

    public function updateTask(Request $request)
    {
        $task = Task::find($request->id);
        $task->title = $request->title;
        $task->description = $request->description;
        $updated = $request->updated_at;


        $task->due = date('Y-m-d', strtotime($updated));
        $updated = $task->save();
        if ($updated) {
            $this->AddToLog("Task $task->title updated successfully");

            return ['status' => 'success'];
        } else {
            return response()->json(['msg' => 'Task not updated'], 404);
        }

    }

    public function updateTaskStatus(Request $request)
    {

        $task = Task::find($request->taskid);
        $task->status = $request->status;
        $updated = $task->save();
        if ($updated) {
            $this->AddToLog("Task $task->title status successfully");

            return ['status' => 'success'];
        } else {
            return response()->json(['msg' => 'Task status not changed'], 404);
        }

    }

    public function updateTaskPriority(Request $request)
    {

        $task = Task::find($request->taskid);
        $task->taskPriority = $request->taskPriority;
        $updated = $task->save();
        if ($updated) {
            $this->AddToLog("Task $task->title Priority changed successfully");

            return ['status' => 'success'];
        } else {
            return response()->json(['msg' => 'Task Priority not changed'], 404);
        }

    }

    /*******************Assets*********************/
    public function getAssets($id)
    {
        $user = User::find($id);
        $assets = Asset::where('bookable', 0)->where('is_nomad', 0)->where('branch_id', $user->branch_id)->get();
//        $assets = Asset::where('bookable',0)->get();


        return response()->json($assets);
    }

    public function teamAssetDetail($id)
    {
        $team = Team::find($id);
        $assets = Assetdetail::where('team_id', '=', $id)->get()->all();
        $rec_invoice = RecurringInvoice::where('team_id', $id)->orderBy('created_at', 'desc')->first();

        // dd($assets);
        return view('admin.assetAssign', compact('assets', 'team', 'rec_invoice'));
    }


    /**************************Invoices Actions**********************************/
    public function generateInvoice(Request $request, $team_id)
    {

        $price = 0;
        $quantity = 0;
        $amount = 0;
        $tax = $request->tax;
        $discount = $request->discount;
        $total = 0;


        $walletType = $request->walletType;
        $description = $request->description;
        $dateFrom = date('d-m-Y', strtotime($request->dateFrom));
        $dateTo = date('d-m-Y', strtotime($request->dateTo));


        $invoice = new Invoice();
        $teamAssets = Assetdetail::where('team_id', '=', $team_id)->get()->all();
        $team = Team::find($team_id);
        if ($walletType == 1) {
            foreach ($teamAssets as $teamAsset) {
                $amount = $amount + (($teamAsset->asset->price) * ($teamAsset->quantity));
            }
            $invoice->amount = $amount;
            // $invoice->user_id=$team->leader_id;
            $invoice->team_id = $team_id;
            $invoice->wallet_type = $walletType;
            $invoice->discount = $discount;
            $invoice->description = $description;
            $invoice->tax = $tax;
        }
        if ($walletType == 2) {
            $hours = 0;

            $bookings = Booking::where('team_id', '=', $team_id)
                ->orWhere('booking_date', '<=', $dateFrom)
                ->orWhere('booking_date', '>=', $dateTo)
                ->get();
            foreach ($bookings as $booking) {
                $hours = abs(strtotime($booking->book_from) - strtotime($booking->book_to)) / 3600;

                $amount = $amount + ($booking->asset->price * $hours);
            }


            $invoice->amount = $amount;
            $invoice->branch_id = $team->branch_id;
            $invoice->discount = 0;
            $invoice->tax = 0;
            $invoice->description = $description;
            $invoice->wallet_type = $walletType;
            //  $invoice->user_id=$team->leader_id;
            $invoice->team_id = $team_id;
        }
        if ($walletType == 3) {

        }


        if (!($discount == 0)) {
            $amount = $amount - (($discount / 100) * $amount);
        }

        if (!($tax == 0)) {
            $amount = $amount + (($tax / 100) * $amount);
        }

        $total = $amount;
        $invoice->total = $total;


        $invoice->save();


        return response()->json(['success' => 'successfully generate invoice']);
        return redirect('/admin/finance');
    }

//    In Transaction table

//  wallet_type
//    1= billing
//    2= room
//    3= printing

//    Payment_type
//    1= cash/online
//    2= free
//    3= cheque
//    4= withholding challan
//
//    Type
//    1 = credit
//    2 = Debit


    public function makePayment($team_id, $credit_transaction_id, $transaction_date, $is_walking, $wallet_type, $payment_type)

    {
        $team = Team::find($team_id);
        $users_transaction_data = DB::select("select * from transactions where team_id = $team_id and is_active = 1");

        $users = array();
        $dues_billing = array();
        $dues_room = array();
        $dues_printing = array();
        $i = 0;
        $user_invoices_data = Array();
        foreach ($users_transaction_data as $data) {
            $user_invoices = DB::select("select  * from invoices where team_id = $data->team_id and is_active = 1 ");
            if (!Empty($user_invoices)) {
                $user_invoices_data = array_values($user_invoices);

            }
            $i++;
        }
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
                        if ($invoice->discount_amount > 0) {
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
            $count_billing_c = 0;
            $count_room_c = 0;
            $count_printing_c = 0;
            $single_user_billing_credit = 0;
            $single_user_room_credit = 0;
            $single_user_printing_credit = 0;
            $single_user_billing_debit = 0;
            $single_user_room_debit = 0;
            $single_user_printing_debit = 0;

            //         take single user_id according to wallet_type and calculate its all credit
            if (!empty($dues_billing)) {
                foreach ($dues_billing as $user_dues) {
                    if ($count_billing_c == 0) {
                        $user_transaction_billing_credit = DB::select("select  * from transactions where team_id = $user_dues->team_id and type = 1 and wallet_type = 1 and is_active = 1");
                        $count_billing_c++;
                    }
                }
                foreach ($user_transaction_billing_credit as $user_credit) {
                    $single_user_billing_credit += $user_credit->amount;

                }
//            credit end

//         take single user_id and calculate its all debit

                $count_billing_d = 0;
                foreach ($dues_billing as $user_dues) {
                    if ($count_billing_d == 0) {
                        $user_transaction_billing_debit = DB::select("select  * from transactions where team_id = $user_dues->team_id and is_active = 1
                           and type = 2 and wallet_type = 1");
                        $count_billing_d++;
                    }
                }

                foreach ($user_transaction_billing_debit as $user_debit) {
                    $single_user_billing_debit += $user_debit->amount;

                }

//            debit end

                $single_user_billing_balance = $single_user_billing_credit - $single_user_billing_debit;

            }


            if (!empty($dues_room)) {


                $get_team_all_free_booking_credit = DB::select("select * from transactions where team_id = $team_id and type = 1 and payment_type = 2 and wallet_type = 2 and is_active = 1");
                $get_team_all_free_booking_debit = DB::select("select * from transactions where  team_id = $team_id and type = 2 and payment_type = 2 and wallet_type = 2 and is_active = 1");
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
                $cash_room_credit_transaction_id = "";
                $cash_room_debit_sum = 0;
                $cash_room_balance = 0;
                foreach ($get_team_all_cash_booking_credit as $key => $cash_credit_all) {

                    $cash_room_credit_sum += $cash_credit_all->amount;
                }

                foreach ($get_team_all_cash_booking_debit as $cash_debit) {
                    $cash_room_debit_sum += $cash_debit->amount;
                }
                $cash_room_balance = $cash_room_credit_sum - $cash_room_debit_sum;
                $free_plus_cash_room_balance = $free_room_balance + $cash_room_balance;


                $single_user_room_balance = $free_plus_cash_room_balance;

            }


            if (!empty($dues_printing)) {

                $get_team_all_free_printing_credit = DB::select("select * from transactions where team_id = $team_id and type = 1 and payment_type = 2 and wallet_type = 3 and is_active = 1");
                $get_team_all_free_printing_debit = DB::select("select * from transactions where  team_id = $team_id and type = 2 and payment_type = 2 and wallet_type = 3 and is_active = 1");
                $free_printing_credit_sum = 0;
                $free_printing_debit_sum = 0;
                $free_printing_balance = 0;
                foreach ($get_team_all_free_printing_credit as $free_credit) {
                    $free_printing_credit_expiry_time = date('m', strtotime($free_credit->updated_at));
                    $now = time();
                    $now = date('m', $now);
                    if ($free_printing_credit_expiry_time >= $now) {
                        $free_printing_credit_sum += $free_credit->amount;
                    }
                }
                foreach ($get_team_all_free_printing_debit as $free_debit) {
                    $free_printing_debit_expiry_time = date('m', strtotime($free_debit->updated_at));
                    $now = time();
                    $now = date('m', $now);
                    if ($free_printing_debit_expiry_time >= $now) {
                        $free_printing_debit_sum += $free_debit->amount;
                    }
                }
                $free_printing_balance = $free_printing_credit_sum - $free_printing_debit_sum;
// calculate all cash paid balance of specific team_id
                $get_team_all_cash_printing_credit = DB::select("select * from transactions where team_id = $team_id and type = 1 and payment_type != 2 and wallet_type = 3 and is_active = 1");
                $get_team_all_cash_printing_debit = DB::select("select * from transactions where team_id = $team_id  and type = 2 and payment_type != 2 and wallet_type = 3 and is_active = 1");
                $cash_printing_credit_sum = 0;
                $cash_printing_debit_sum = 0;
                $cash_printing_balance = 0;
                foreach ($get_team_all_cash_printing_credit as $key => $cash_credit_all) {

                    $cash_printing_credit_sum += $cash_credit_all->amount;
                }

                foreach ($get_team_all_cash_printing_debit as $cash_debit) {
                    $cash_printing_debit_sum += $cash_debit->amount;
                }
                $cash_printing_balance = $cash_printing_credit_sum - $cash_printing_debit_sum;
                $free_plus_cash_printing_balance = $free_printing_balance + $cash_printing_balance;


                $single_user_printing_balance = $free_plus_cash_printing_balance;


            }

        }
//        add transaction in transaction table by taking invoices from dues dataset and deduct the amount from single_user_balance
        if (!empty($dues_billing && $wallet_type == 1)) {
            foreach ($dues_billing as $user_dues) {
                if ($single_user_billing_balance > 0) {

//            if Invoice is partially paid then check dues of it from dues field
                    if (isset($user_dues->dues)) {
                        if ($user_dues->dues <= $single_user_billing_balance) {
                            $insert_transaction = new Transaction();
                            if ($is_walking == 1) {
                                $insert_transaction->is_walking = 1;
                            } else {
                                $insert_transaction->is_walking = 0;
                            }
//                            $transaction_date = date('Y-m-d');
                            $insert_transaction->transaction_date = $transaction_date;
                            $insert_transaction->admin_id = 0;
                            $insert_transaction->type = 2;
                            $insert_transaction->branch_id = $team->branch_id;
                            $insert_transaction->amount = $user_dues->dues;
                            $insert_transaction->team_id = $user_dues->team_id;
                            $insert_transaction->invoice_id = $user_dues->id;
                            $insert_transaction->credit_transaction_id = $credit_transaction_id;
                            $insert_transaction->note = "Auto generated transaction for billing dues";
                            $insert_transaction->payment_type = $payment_type;
                            $insert_transaction->wallet_type = $user_dues->wallet_type;
                            $single_user_billing_balance -= $user_dues->dues;
                            $insert_transaction->save();
                            $this->AddToLog("Auto generated transaction for billing dues of team id $insert_transaction->team_id for invoice# $insert_transaction->invoice_id created successfully");

                        } else {
                            $insert_transaction = new Transaction();
                            if ($is_walking == 1) {
                                $insert_transaction->is_walking = 1;
                            } else {
                                $insert_transaction->is_walking = 0;
                            }
//                            $transaction_date = date('Y-m-d');
                            $insert_transaction->transaction_date = $transaction_date;
                            $insert_transaction->admin_id = 0;
                            $insert_transaction->type = 2;
                            $insert_transaction->branch_id = $team->branch_id;
                            $insert_transaction->amount = $single_user_billing_balance;
                            $insert_transaction->team_id = $user_dues->team_id;
                            $insert_transaction->invoice_id = $user_dues->id;
                            $insert_transaction->credit_transaction_id = $credit_transaction_id;
                            $insert_transaction->note = "Auto generated transaction for billing dues";
                            $insert_transaction->payment_type = $payment_type;
                            $insert_transaction->wallet_type = $user_dues->wallet_type;
                            $single_user_billing_balance -= $single_user_billing_balance;
                            $insert_transaction->save();
                            $this->AddToLog("Auto generated transaction for billing dues of team id $insert_transaction->team_id for invoice# $insert_transaction->invoice_id created successfully");

                        }
//                    else Invoice is'nt paid and due with its full amount

                    } else {
                        if ($user_dues->total <= $single_user_billing_balance) {
                            $insert_transaction = new Transaction();
                            if ($is_walking == 1) {
                                $insert_transaction->is_walking = 1;
                            } else {
                                $insert_transaction->is_walking = 0;
                            }
//                            $transaction_date = date('Y-m-d');
                            $insert_transaction->transaction_date = $transaction_date;
                            $insert_transaction->admin_id = 0;
                            $insert_transaction->type = 2;
                            $insert_transaction->branch_id = $team->branch_id;
                            $insert_transaction->amount = $user_dues->total;
                            $insert_transaction->team_id = $user_dues->team_id;
                            $insert_transaction->invoice_id = $user_dues->id;
                            $insert_transaction->credit_transaction_id = $credit_transaction_id;
                            $insert_transaction->note = "Auto generated transaction for billing dues";
                            $insert_transaction->payment_type = $payment_type;
                            $insert_transaction->wallet_type = $user_dues->wallet_type;
                            $single_user_billing_balance -= $user_dues->total;
                            $insert_transaction->save();
                            $this->AddToLog("Auto generated transaction for billing dues of team id $insert_transaction->team_id for invoice# $insert_transaction->invoice_id created successfully");


                        } else {
                            $insert_transaction = new Transaction();
                            if ($is_walking == 1) {
                                $insert_transaction->is_walking = 1;
                            } else {
                                $insert_transaction->is_walking = 0;
                            }
//                            $transaction_date = date('Y-m-d');
                            $insert_transaction->transaction_date = $transaction_date;
                            $insert_transaction->admin_id = 0;
                            $insert_transaction->type = 2;
                            $insert_transaction->branch_id = $team->branch_id;
                            $insert_transaction->amount = $single_user_billing_balance;
                            $insert_transaction->team_id = $user_dues->team_id;
                            $insert_transaction->invoice_id = $user_dues->id;
                            $insert_transaction->credit_transaction_id = $credit_transaction_id;
                            $insert_transaction->note = "Auto generated transaction for billing dues";
                            $insert_transaction->payment_type = $payment_type;
                            $insert_transaction->wallet_type = $user_dues->wallet_type;
                            $single_user_billing_balance -= $single_user_billing_balance;
                            $insert_transaction->save();
                            $this->AddToLog("Auto generated transaction for billing dues of team id $insert_transaction->team_id for invoice# $insert_transaction->invoice_id created successfully");

                        }
                    }
                }
            }
        }

        if (!empty($dues_room) && $wallet_type == 2) {
            foreach ($dues_room as $user_dues) {

                $invoice_month = date('m', strtotime($user_dues->updated_at));
                $now = time();
                $now = date('m', $now);
                if ($invoice_month == $now) {
                    if ($single_user_room_balance > 0) {

//            if Invoice is partially paid then check dues of it from dues field
                        if (isset($user_dues->dues)) {
                            if ($user_dues->dues <= $single_user_room_balance) {
                                $insert_transaction = new Transaction();
                                if ($is_walking == 1) {
                                    $insert_transaction->is_walking = 1;
                                } else {
                                    $insert_transaction->is_walking = 0;
                                }
//                            $transaction_date = date('Y-m-d');
                                $insert_transaction->transaction_date = $transaction_date;
                                $insert_transaction->admin_id = 0;
                                $insert_transaction->type = 2;
                                $insert_transaction->branch_id = $team->branch_id;
                                $insert_transaction->amount = $user_dues->dues;
                                $insert_transaction->team_id = $user_dues->team_id;
                                $insert_transaction->invoice_id = $user_dues->id;
                                $insert_transaction->credit_transaction_id = $credit_transaction_id;
                                $insert_transaction->note = "Auto generated transaction for room booking dues";
                                $insert_transaction->payment_type = $payment_type;
                                $insert_transaction->wallet_type = $user_dues->wallet_type;
                                $single_user_room_balance -= $user_dues->dues;
                                $insert_transaction->save();
                                $this->AddToLog("Auto generated transaction for room booking dues of team id $insert_transaction->team_id for invoice# $insert_transaction->invoice_id created successfully");

                                $reserve_booking = Booking::where('invoice_id', $insert_transaction->invoice_id)->first();
                                if (!empty($reserve_booking)) {
                                    if ($reserve_booking->is_reserve == 1) {
                                        $reserved_booking = Booking::find($reserve_booking->id);
                                        $reserved_booking->is_reserve = 0;
                                        $reserved_booking->save();
                                    }

                                }

                            } else {
                                $insert_transaction = new Transaction();
                                if ($is_walking == 1) {
                                    $insert_transaction->is_walking = 1;
                                } else {
                                    $insert_transaction->is_walking = 0;
                                }
//                            $transaction_date = date('Y-m-d');
                                $insert_transaction->transaction_date = $transaction_date;
                                $insert_transaction->admin_id = 0;
                                $insert_transaction->type = 2;
                                $insert_transaction->branch_id = $team->branch_id;
                                $insert_transaction->amount = $single_user_room_balance;
                                $insert_transaction->team_id = $user_dues->team_id;
                                $insert_transaction->invoice_id = $user_dues->id;
                                $insert_transaction->credit_transaction_id = $credit_transaction_id;
                                $insert_transaction->note = "Auto generated transaction for room booking dues";
                                $insert_transaction->payment_type = $payment_type;
                                $insert_transaction->wallet_type = $user_dues->wallet_type;
                                $single_user_room_balance -= $single_user_room_balance;
                                $insert_transaction->save();
                                $this->AddToLog("Auto generated transaction for room booking dues of team id $insert_transaction->team_id for invoice# $insert_transaction->invoice_id created successfully");

                            }
//                    else Invoice is'nt paid and due with its full amount

                        } else {
                            if ($user_dues->total <= $single_user_room_balance) {
                                $insert_transaction = new Transaction();
                                if ($is_walking == 1) {
                                    $insert_transaction->is_walking = 1;
                                } else {
                                    $insert_transaction->is_walking = 0;
                                }
//                            $transaction_date = date('Y-m-d');
                                $insert_transaction->transaction_date = $transaction_date;
                                $insert_transaction->admin_id = 0;
                                $insert_transaction->type = 2;
                                $insert_transaction->branch_id = $team->branch_id;
                                $insert_transaction->amount = $user_dues->total;
                                $insert_transaction->team_id = $user_dues->team_id;
                                $insert_transaction->invoice_id = $user_dues->id;
                                $insert_transaction->credit_transaction_id = $credit_transaction_id;
                                $insert_transaction->note = "Auto generated transaction for room booking dues";
                                $insert_transaction->payment_type = $payment_type;
                                $insert_transaction->wallet_type = $user_dues->wallet_type;
                                $single_user_room_balance -= $user_dues->total;
                                $insert_transaction->save();
                                $this->AddToLog("Auto generated transaction for room booking dues of team id $insert_transaction->team_id for invoice# $insert_transaction->invoice_id created successfully");

                                $reserve_booking = Booking::where('invoice_id', $insert_transaction->invoice_id)->first();
                                if (!empty($reserve_booking)) {
                                    if ($reserve_booking->is_reserve == 1) {
                                        $reserved_booking = Booking::find($reserve_booking->id);
                                        $reserved_booking->is_reserve = 0;
                                        $reserved_booking->save();
                                        $this->AddToLog("Reserve room booking dues paid of team id $insert_transaction->team_id for invoice# $insert_transaction->invoice_id created successfully");

                                    }

                                }


                            } else {
                                $insert_transaction = new Transaction();
                                if ($is_walking == 1) {
                                    $insert_transaction->is_walking = 1;
                                } else {
                                    $insert_transaction->is_walking = 0;
                                }
//                            $transaction_date = date('Y-m-d');
                                $insert_transaction->transaction_date = $transaction_date;
                                $insert_transaction->admin_id = 0;
                                $insert_transaction->type = 2;
                                $insert_transaction->branch_id = $team->branch_id;
                                $insert_transaction->amount = $single_user_room_balance;
                                $insert_transaction->team_id = $user_dues->team_id;
                                $insert_transaction->invoice_id = $user_dues->id;
                                $insert_transaction->credit_transaction_id = $credit_transaction_id;
                                $insert_transaction->note = "Auto generated transaction for dues";
                                $insert_transaction->payment_type = $payment_type;
                                $insert_transaction->wallet_type = $user_dues->wallet_type;
                                $single_user_room_balance -= $single_user_room_balance;
                                $insert_transaction->save();
                                $this->AddToLog("Auto generated transaction for room booking dues of team id $insert_transaction->team_id for invoice# $insert_transaction->invoice_id created successfully");

                            }
                        }
                    }

                } else {
                    if ($cash_room_balance > 0) {

//            if Invoice is partially paid then check dues of it from dues field
                        if (isset($user_dues->dues)) {
                            if ($user_dues->dues <= $cash_room_balance) {
                                $insert_transaction = new Transaction();
                                if ($is_walking == 1) {
                                    $insert_transaction->is_walking = 1;
                                } else {
                                    $insert_transaction->is_walking = 0;
                                }
//                            $transaction_date = date('Y-m-d');
                                $insert_transaction->transaction_date = $transaction_date;
                                $insert_transaction->admin_id = 0;
                                $insert_transaction->type = 2;
                                $insert_transaction->branch_id = $team->branch_id;
                                $insert_transaction->amount = $user_dues->dues;
                                $insert_transaction->team_id = $user_dues->team_id;
                                $insert_transaction->invoice_id = $user_dues->id;
                                $insert_transaction->credit_transaction_id = $credit_transaction_id;
                                $insert_transaction->note = "Auto generated transaction for room booking dues";
                                $insert_transaction->payment_type = $payment_type;
                                $insert_transaction->wallet_type = $user_dues->wallet_type;
                                $cash_room_balance -= $user_dues->dues;
                                $insert_transaction->save();
                                $this->AddToLog("Auto generated transaction for room booking dues of team id $insert_transaction->team_id for invoice# $insert_transaction->invoice_id created successfully");


                            } else {
                                $insert_transaction = new Transaction();
                                if ($is_walking == 1) {
                                    $insert_transaction->is_walking = 1;
                                } else {
                                    $insert_transaction->is_walking = 0;
                                }
//                            $transaction_date = date('Y-m-d');
                                $insert_transaction->transaction_date = $transaction_date;
                                $insert_transaction->admin_id = 0;
                                $insert_transaction->type = 2;
                                $insert_transaction->branch_id = $team->branch_id;
                                $insert_transaction->amount = $cash_room_balance;
                                $insert_transaction->team_id = $user_dues->team_id;
                                $insert_transaction->invoice_id = $user_dues->id;
                                $insert_transaction->credit_transaction_id = $credit_transaction_id;
                                $insert_transaction->note = "Auto generated transaction for room booking dues";
                                $insert_transaction->payment_type = $payment_type;
                                $insert_transaction->wallet_type = $user_dues->wallet_type;
                                $cash_room_balance -= $cash_room_balance;
                                $insert_transaction->save();
                                $this->AddToLog("Auto generated transaction for room booking dues of team id $insert_transaction->team_id for invoice# $insert_transaction->invoice_id created successfully");

                            }
//                    else Invoice is'nt paid and due with its full amount

                        } else {
                            if ($user_dues->total <= $cash_room_balance) {
                                $insert_transaction = new Transaction();
                                if ($is_walking == 1) {
                                    $insert_transaction->is_walking = 1;
                                } else {
                                    $insert_transaction->is_walking = 0;
                                }
//                            $transaction_date = date('Y-m-d');
                                $insert_transaction->transaction_date = $transaction_date;
                                $insert_transaction->admin_id = 0;
                                $insert_transaction->type = 2;
                                $insert_transaction->branch_id = $team->branch_id;
                                $insert_transaction->amount = $user_dues->total;
                                $insert_transaction->team_id = $user_dues->team_id;
                                $insert_transaction->invoice_id = $user_dues->id;
                                $insert_transaction->credit_transaction_id = $credit_transaction_id;
                                $insert_transaction->note = "Auto generated transaction for room booking dues";
                                $insert_transaction->payment_type = $payment_type;
                                $insert_transaction->wallet_type = $user_dues->wallet_type;
                                $cash_room_balance -= $user_dues->total;
                                $insert_transaction->save();
                                $this->AddToLog("Auto generated transaction for room booking dues of team id $insert_transaction->team_id for invoice# $insert_transaction->invoice_id created successfully");


                            } else {
                                $insert_transaction = new Transaction();
                                if ($is_walking == 1) {
                                    $insert_transaction->is_walking = 1;
                                } else {
                                    $insert_transaction->is_walking = 0;
                                }
//                            $transaction_date = date('Y-m-d');
                                $insert_transaction->transaction_date = $transaction_date;
                                $insert_transaction->admin_id = 0;
                                $insert_transaction->type = 2;
                                $insert_transaction->branch_id = $team->branch_id;
                                $insert_transaction->amount = $cash_room_balance;
                                $insert_transaction->team_id = $user_dues->team_id;
                                $insert_transaction->invoice_id = $user_dues->id;
                                $insert_transaction->credit_transaction_id = $credit_transaction_id;
                                $insert_transaction->note = "Auto generated transaction for dues";
                                $insert_transaction->payment_type = $payment_type;
                                $insert_transaction->wallet_type = $user_dues->wallet_type;
                                $cash_room_balance -= $cash_room_balance;
                                $insert_transaction->save();
                                $this->AddToLog("Auto generated transaction for room booking dues of team id $insert_transaction->team_id for invoice# $insert_transaction->invoice_id created successfully");

                            }
                        }
                    }
                }

            }
        }

        if (!empty($dues_printing) && $wallet_type == 3) {
            foreach ($dues_printing as $user_dues) {

                $invoice_month = date('m', strtotime($user_dues->updated_at));
                $now = time();
                $now = date('m', $now);
                if ($invoice_month == $now) {
                    if ($single_user_printing_balance > 0) {

//            if Invoice is partially paid then check dues of it from dues field
                        if (isset($user_dues->dues)) {
                            if ($user_dues->dues <= $single_user_printing_balance) {
                                $insert_transaction = new Transaction();
                                if ($is_walking == 1) {
                                    $insert_transaction->is_walking = 1;
                                } else {
                                    $insert_transaction->is_walking = 0;
                                }
//                            $transaction_date = date('Y-m-d');
                                $insert_transaction->transaction_date = $transaction_date;
                                $insert_transaction->admin_id = 0;
                                $insert_transaction->type = 2;
                                $insert_transaction->branch_id = $team->branch_id;
                                $insert_transaction->amount = $user_dues->dues;
                                $insert_transaction->team_id = $user_dues->team_id;
                                $insert_transaction->invoice_id = $user_dues->id;
                                $insert_transaction->credit_transaction_id = $credit_transaction_id;
                                $insert_transaction->note = "Auto generated transaction for printing dues";
                                $insert_transaction->payment_type = $payment_type;
                                $insert_transaction->wallet_type = $user_dues->wallet_type;
                                $single_user_printing_balance -= $user_dues->dues;
                                $insert_transaction->save();
                                $this->AddToLog("Auto generated transaction for printing dues of team id $insert_transaction->team_id for invoice# $insert_transaction->invoice_id created successfully");


                            } else {
                                $insert_transaction = new Transaction();
                                if ($is_walking == 1) {
                                    $insert_transaction->is_walking = 1;
                                } else {
                                    $insert_transaction->is_walking = 0;
                                }
//                            $transaction_date = date('Y-m-d');
                                $insert_transaction->transaction_date = $transaction_date;
                                $insert_transaction->admin_id = 0;
                                $insert_transaction->type = 2;
                                $insert_transaction->branch_id = $team->branch_id;
                                $insert_transaction->amount = $single_user_printing_balance;
                                $insert_transaction->team_id = $user_dues->team_id;
                                $insert_transaction->invoice_id = $user_dues->id;
                                $insert_transaction->credit_transaction_id = $credit_transaction_id;
                                $insert_transaction->note = "Auto generated transaction for printing dues";
                                $insert_transaction->payment_type = $payment_type;
                                $insert_transaction->wallet_type = $user_dues->wallet_type;
                                $single_user_printing_balance -= $single_user_printing_balance;
                                $insert_transaction->save();
                                $this->AddToLog("Auto generated transaction for printing dues of team id $insert_transaction->team_id for invoice# $insert_transaction->invoice_id created successfully");

                            }
//                    else Invoice is'nt paid and due with its full amount

                        } else {
                            if ($user_dues->total <= $single_user_printing_balance) {
                                $insert_transaction = new Transaction();
                                if ($is_walking == 1) {
                                    $insert_transaction->is_walking = 1;
                                } else {
                                    $insert_transaction->is_walking = 0;
                                }
//                            $transaction_date = date('Y-m-d');
                                $insert_transaction->transaction_date = $transaction_date;
                                $insert_transaction->admin_id = 0;
                                $insert_transaction->type = 2;
                                $insert_transaction->branch_id = $team->branch_id;
                                $insert_transaction->amount = $user_dues->total;
                                $insert_transaction->team_id = $user_dues->team_id;
                                $insert_transaction->invoice_id = $user_dues->id;
                                $insert_transaction->credit_transaction_id = $credit_transaction_id;
                                $insert_transaction->note = "Auto generated transaction for printing dues";
                                $insert_transaction->payment_type = $payment_type;
                                $insert_transaction->wallet_type = $user_dues->wallet_type;
                                $single_user_printing_balance -= $user_dues->total;
                                $insert_transaction->save();
                                $this->AddToLog("Auto generated transaction for printing dues of team id $insert_transaction->team_id for invoice# $insert_transaction->invoice_id created successfully");


                            } else {
                                $insert_transaction = new Transaction();
                                if ($is_walking == 1) {
                                    $insert_transaction->is_walking = 1;
                                } else {
                                    $insert_transaction->is_walking = 0;
                                }
//                            $transaction_date = date('Y-m-d');
                                $insert_transaction->transaction_date = $transaction_date;
                                $insert_transaction->admin_id = 0;
                                $insert_transaction->type = 2;
                                $insert_transaction->branch_id = $team->branch_id;
                                $insert_transaction->amount = $single_user_printing_balance;
                                $insert_transaction->team_id = $user_dues->team_id;
                                $insert_transaction->invoice_id = $user_dues->id;
                                $insert_transaction->credit_transaction_id = $credit_transaction_id;
                                $insert_transaction->note = "Auto generated transaction for printing dues";
                                $insert_transaction->payment_type = $payment_type;
                                $insert_transaction->wallet_type = $user_dues->wallet_type;
                                $single_user_printing_balance -= $single_user_printing_balance;
                                $insert_transaction->save();
                                $this->AddToLog("Auto generated transaction for printing dues of team id $insert_transaction->team_id for invoice# $insert_transaction->invoice_id created successfully");

                            }
                        }
                    }

                } else {
                    if ($cash_printing_balance > 0) {

//            if Invoice is partially paid then check dues of it from dues field
                        if (isset($user_dues->dues)) {
                            if ($user_dues->dues <= $cash_printing_balance) {
                                $insert_transaction = new Transaction();
                                if ($is_walking == 1) {
                                    $insert_transaction->is_walking = 1;
                                } else {
                                    $insert_transaction->is_walking = 0;
                                }
//                            $transaction_date = date('Y-m-d');
                                $insert_transaction->transaction_date = $transaction_date;
                                $insert_transaction->admin_id = 0;
                                $insert_transaction->type = 2;
                                $insert_transaction->branch_id = $team->branch_id;
                                $insert_transaction->amount = $user_dues->dues;
                                $insert_transaction->team_id = $user_dues->team_id;
                                $insert_transaction->invoice_id = $user_dues->id;
                                $insert_transaction->credit_transaction_id = $credit_transaction_id;
                                $insert_transaction->note = "Auto generated transaction for printing dues";
                                $insert_transaction->payment_type = $payment_type;
                                $insert_transaction->wallet_type = $user_dues->wallet_type;
                                $cash_printing_balance -= $user_dues->dues;
                                $insert_transaction->save();
                                $this->AddToLog("Auto generated transaction for printing dues of team id $insert_transaction->team_id for invoice# $insert_transaction->invoice_id created successfully");


                            } else {
                                $insert_transaction = new Transaction();
                                if ($is_walking == 1) {
                                    $insert_transaction->is_walking = 1;
                                } else {
                                    $insert_transaction->is_walking = 0;
                                }
//                            $transaction_date = date('Y-m-d');
                                $insert_transaction->transaction_date = $transaction_date;
                                $insert_transaction->admin_id = 0;
                                $insert_transaction->type = 2;
                                $insert_transaction->branch_id = $team->branch_id;
                                $insert_transaction->amount = $cash_printing_balance;
                                $insert_transaction->team_id = $user_dues->team_id;
                                $insert_transaction->invoice_id = $user_dues->id;
                                $insert_transaction->credit_transaction_id = $credit_transaction_id;
                                $insert_transaction->note = "Auto generated transaction for printing dues";
                                $insert_transaction->payment_type = $payment_type;
                                $insert_transaction->wallet_type = $user_dues->wallet_type;
                                $cash_printing_balance -= $cash_printing_balance;
                                $insert_transaction->save();
                                $this->AddToLog("Auto generated transaction for printing dues of team id $insert_transaction->team_id for invoice# $insert_transaction->invoice_id created successfully");

                            }
//                    else Invoice is'nt paid and due with its full amount

                        } else {
                            if ($user_dues->total <= $cash_printing_balance) {
                                $insert_transaction = new Transaction();
                                if ($is_walking == 1) {
                                    $insert_transaction->is_walking = 1;
                                } else {
                                    $insert_transaction->is_walking = 0;
                                }
//                            $transaction_date = date('Y-m-d');
                                $insert_transaction->transaction_date = $transaction_date;
                                $insert_transaction->admin_id = 0;
                                $insert_transaction->type = 2;
                                $insert_transaction->branch_id = $team->branch_id;
                                $insert_transaction->amount = $user_dues->total;
                                $insert_transaction->team_id = $user_dues->team_id;
                                $insert_transaction->invoice_id = $user_dues->id;
                                $insert_transaction->credit_transaction_id = $credit_transaction_id;
                                $insert_transaction->note = "Auto generated transaction for printing dues";
                                $insert_transaction->payment_type = $payment_type;
                                $insert_transaction->wallet_type = $user_dues->wallet_type;
                                $cash_printing_balance -= $user_dues->total;
                                $insert_transaction->save();
                                $this->AddToLog("Auto generated transaction for printing dues of team id $insert_transaction->team_id for invoice# $insert_transaction->invoice_id created successfully");


                            } else {
                                $insert_transaction = new Transaction();
                                if ($is_walking == 1) {
                                    $insert_transaction->is_walking = 1;
                                } else {
                                    $insert_transaction->is_walking = 0;
                                }
//                            $transaction_date = date('Y-m-d');
                                $insert_transaction->transaction_date = $transaction_date;
                                $insert_transaction->admin_id = 0;
                                $insert_transaction->type = 2;
                                $insert_transaction->branch_id = $team->branch_id;
                                $insert_transaction->amount = $cash_printing_balance;
                                $insert_transaction->team_id = $user_dues->team_id;
                                $insert_transaction->invoice_id = $user_dues->id;
                                $insert_transaction->credit_transaction_id = $credit_transaction_id;
                                $insert_transaction->note = "Auto generated transaction for printing dues";
                                $insert_transaction->payment_type = $payment_type;
                                $insert_transaction->wallet_type = $user_dues->wallet_type;
                                $cash_printing_balance -= $cash_printing_balance;
                                $insert_transaction->save();
                                $this->AddToLog("Auto generated transaction for printing dues of team id $insert_transaction->team_id for invoice# $insert_transaction->invoice_id created successfully");

                            }
                        }
                    }
                }

            }
        }


//        if (!empty($dues_billing)) {
//
//            echo "<pre>";
//            print_r($dues_billing);
//            echo "<br>";
//            echo "credit = " . $single_user_billing_credit;
//            echo "<br>";
//            echo "Debit = " . $single_user_billing_debit;
//            echo "<br>";
//            echo "Balance = " . $single_user_billing_balance;
//            return;
//        }else{
//            echo "no pending billing invoice";
//            return;
//        }
//
//        if (!empty($dues_room)) {
//
//            echo "<pre>";
//            print_r($dues_room);
//            echo "<br>";
//            echo "credit = " . $single_user_room_credit;
//            echo "<br>";
//            echo "Debit = " . $single_user_room_debit;
//            echo "<br>";
//            echo "Balance = " . $single_user_room_balance;
//            return;
//        }else{
//            echo "no pending room booking invoice";
//            return;
//        }
//
//        if (!empty($dues_printing)) {
//
//            echo "<pre>";
//            print_r($dues_printing);
//            echo "<br>";
//            echo "credit = " . $single_user_printing_credit;
//            echo "<br>";
//            echo "Debit = " . $single_user_printing_debit;
//            echo "<br>";
//            echo "Balance = " . $single_user_printing_balance;
//            return;
//        }else{
//            echo "no pending printing invoice";
//            return;
//        }


        return view('admin.make_payment', compact('invoice_data_value'));

    }


    public function void_payment(Request $request)
    {

        if ($request->trans_id) {

            $transaction = Transaction::find($request->trans_id);
            if (!empty($transaction)) {
                $transaction->is_active = 0;
                if ($transaction->save()) {
                    $payment_transactions = Transaction::where('credit_transaction_id', $request->trans_id)->where('is_active', 1)->get();
                    if (!empty($payment_transactions) && count($payment_transactions) > 0) {
                        foreach ($payment_transactions as $payment_transaction) {
                            $debit_transaction_to_void = Transaction::find($payment_transaction->id);
                            $debit_transaction_to_void->is_active = 0;
                            $debit_transaction_to_void->save();
                            $this->AddToLog("Transaction#  $debit_transaction_to_void->id for team id $debit_transaction_to_void->team_id voided successfully");

                        }
                    }
                }
                return response()->json(['success' => 'Payment void successfully']);
            }


        } else {
            return response()->json(['error' => 'payment not void']);

        }


    }

    public function void_invoice(Request $request)
    {

        if ($request->inv_id) {

            $invoice = Invoice::find($request->inv_id);
            if (!empty($invoice)) {
//                $invoice_items = InvoiceItem::where('invoice_id',$request->inv_id)->get();
//                if (!empty($invoice_items) && count($invoice_items) > 0) {
//                    foreach ($invoice_items as $invoice_item) {
//                        $invoice_item_to_void = InvoiceItem::where('invoice_id',$invoice_item->invoice_id);
//                        $invoice_item_to_void->is_active = 0;
//                        $invoice_item_to_void->save();
//
//                    }
//
//                    }
                $invoice->is_active = 0;
                if ($invoice->save()) {
                    $this->AddToLog("Invoice#  $invoice->id for team id $invoice->team_id voided successfully");
                    $payment_transactions = Transaction::where('invoice_id', $request->inv_id)->where('is_active', 1)->get();
                    if (!empty($payment_transactions) && count($payment_transactions) > 0) {
                        foreach ($payment_transactions as $payment_transaction) {
                            $debit_transaction_to_void = Transaction::find($payment_transaction->id);
                            $debit_transaction_to_void->is_active = 0;
                            $debit_transaction_to_void->save();
                        }
                    }
                }
                return response()->json(['success' => 'Invoice void successfully']);
            }


        } else {
            return response()->json(['error' => 'Invoice not void']);

        }


    }


    public function makeTransaction(Request $request)
    {
        $remaining_limit_amount = 0;
        $setting_name = "";
        $error_payment_type = "";
        if (Auth::user()->type != 1) {

            $user_role = Auth::user()->type;

            if ($user_role == 2) {

                if ($request->payment_type == 1) {

                    $setting_name = "admin_cash_limit";
                    $error_payment_type = "Cash";

                } elseif ($request->payment_type == 3) {

                    $setting_name = "admin_cheque_limit";
                    $error_payment_type = "Cheque";
                } elseif ($request->payment_type == 4) {

                    $setting_name = "admin_withholding_challan_limit";
                    $error_payment_type = "Withholding Challan";

                }

                $cash_limit = Setting::where('setting_key', $setting_name)->first();

                $current_date = date('Y-m-d');
                $get_str_date_start = strtotime($current_date) + (60 * 60 * 0);
                $get_str_date_end = strtotime($current_date) + (60 * 60 * 23.99);

                $start_time = date("Y-m-d H:i:s", $get_str_date_start); //get time in format 2018 07 12 12:00:00
                $end_time = date("Y-m-d H:i:s", $get_str_date_end); //get time in format 2018 07 12 12:00:00
                $end_time = date("Y-m-d H:i:s", $get_str_date_end); //get time in format 2018 07 12 12:00:00
                $admin = Admin::find(Auth::id());

                $today_cash = DB::select("SELECT b.id as branch_id,b.name as branch_name, a.name as admin_name ,tr.admin_id,a.type as admin_type,tr.is_transfer ,tr.payment_type,  SUM(tr.amount) as amount FROM transactions as tr INNER JOIN admins as a on tr.admin_id = a.id and tr.type = 1 and tr.payment_type = '$request->payment_type' and tr.admin_id = '$admin->id'  and is_transfer = 0 INNER JOIN branches as b on tr.branch_id = b.id and date (tr.created_at) between '$start_time' and '$end_time' group by tr.admin_id,tr.branch_id,tr.payment_type,b.id,b.name,a.name,a.type,is_transfer");


                if (isset($today_cash) && !empty($today_cash)) {
                    foreach ($today_cash as $cash) {
                        $cash_previous_total = $cash->amount;
                    }
                } else {
                    $cash_previous_total = 0;
                }

                $amount_total = $cash_previous_total + $request->amount;
                $remaining_limit_amount = $cash_limit->setting_value - $cash_previous_total;
                $collected_amount = $cash_previous_total;
                $admin = Admin::find(Auth::id());

                if ($amount_total <= $cash_limit->setting_value) {

                    $team = Team::find($request->team_id);
                    $admin = Admin::find(Auth::id());
                    $transaction = new Transaction;
                    $transaction_date = date('Y-m-d', strtotime($request->transaction_date));
                    $transaction->transaction_date = $transaction_date;
                    $transaction->admin_id = $admin->id;
                    $transaction->team_id = $request->team_id;
                    $transaction->branch_id = $team->branch_id;
                    $transaction->wallet_type = $request->wallet_type;

                    $transaction->amount = $request->amount;
                    $transaction->note = $request->note;
                    $transaction->type = 1;
                    $transaction->payment_type = $request->payment_type;
                    $transaction->image_url = $request->image_url;
                    $transaction->cheque_withholding_challan_no = $request->cheque_withholding_challan_no;
                    $transaction->is_active = 1;

                    $team_id = $transaction->team_id;
                    $is_walking = $team->is_walking;
                    if ($is_walking == 1) {
                        $transaction->is_walking = 1;
                    } else {
                        $transaction->is_walking = 0;
                    }

                    if (Auth::user()->type == 1) {
                        $transaction->is_transfer = 1;
                    } else {
                        $transaction->is_transfer = 0;
                    }

                    $store = $transaction->save();
                    $this->AddToLog("Transaction for team id $transaction->team_id and transaction# $transaction->id added successfully");

                    $credit_transaction_id = $transaction->id;
                    $wallet_type = $transaction->wallet_type;
                    $payment_type = $request->payment_type;

                    $this->sendNotificationTeamLead($transaction->id, $transaction->branch_id, $transaction->team_id);
                    $this->sendNotificationAdmin($transaction->id, $transaction->branch_id, $transaction->team_id);
                    if ($store) {
                        $transaction_email = new ContractController();
                        $transaction_email->sendTransactionEmail($team_id, $transaction->id);
                        $this->makePayment($team_id, $credit_transaction_id, $transaction_date, $is_walking, $wallet_type, $payment_type);

                        return response()->json(['Success' => 'Transaction added successfully']);

                    }

                } else {
                    $threshhold_email = new ContractController();
                    $threshhold_email->sendThreshholdEmail($admin->id, $collected_amount, $error_payment_type);
                    return response()->json(['error' => $error_payment_type . ' Limit Exceeded, You Can Collect ' . number_format($remaining_limit_amount, 0) . ' /PKR More as ' . $error_payment_type . ' Please Contact To Super Admin'], 500);
                }


            } elseif ($user_role == 4) {

                if ($request->payment_type == 1) {

                    $setting_name = "receptionist_cash_limit";
                    $error_payment_type = "Cash";


                } elseif ($request->payment_type == 3) {

                    $setting_name = "receptionist_cheque_limit";
                    $error_payment_type = "Cheque";


                } elseif ($request->payment_type == 4) {

                    $setting_name = "receptionist_withholding_challan_limit";
                    $error_payment_type = "Withholding Challan";

                }


                $cash_limit = Setting::where('setting_key', $setting_name)->first();

                $current_date = date('Y-m-d');
                $get_str_date_start = strtotime($current_date) + (60 * 60 * 0);
                $get_str_date_end = strtotime($current_date) + (60 * 60 * 23.99);

                $start_time = date("Y-m-d H:i:s", $get_str_date_start); //get time in format 2018 07 12 12:00:00
                $end_time = date("Y-m-d H:i:s", $get_str_date_end); //get time in format 2018 07 12 12:00:00
                $end_time = date("Y-m-d H:i:s", $get_str_date_end); //get time in format 2018 07 12 12:00:00
                $admin = Admin::find(Auth::id());

                $today_cash = DB::select("SELECT b.id as branch_id,b.name as branch_name, a.name as admin_name ,tr.admin_id,a.type as admin_type,tr.is_transfer ,tr.payment_type,  SUM(tr.amount) as amount FROM transactions as tr INNER JOIN admins as a on tr.admin_id = a.id and tr.type = 1 and tr.payment_type = '$request->payment_type' and tr.admin_id = '$admin->id'  and is_transfer = 0 INNER JOIN branches as b on tr.branch_id = b.id and date (tr.created_at) between '$start_time' and '$end_time' group by tr.admin_id,tr.branch_id,tr.payment_type,b.id,b.name,a.name,a.type,is_transfer");


                if (isset($today_cash) && !empty($today_cash)) {
                    foreach ($today_cash as $cash) {
                        $cash_previous_total = $cash->amount;
                    }
                } else {
                    $cash_previous_total = 0;
                }

                $amount_total = $cash_previous_total + $request->amount;
                $remaining_limit_amount = $cash_limit->setting_value - $cash_previous_total;
                $collected_amount = $cash_previous_total;
                $admin = Admin::find(Auth::id());
                if ($amount_total <= $cash_limit->setting_value) {

                    $team = Team::find($request->team_id);
                    $admin = Admin::find(Auth::id());
                    $transaction = new Transaction;
                    $transaction_date = date('Y-m-d', strtotime($request->transaction_date));
                    $transaction->transaction_date = $transaction_date;
                    $transaction->admin_id = $admin->id;
                    $transaction->team_id = $request->team_id;
                    $transaction->branch_id = $team->branch_id;
                    $transaction->wallet_type = $request->wallet_type;

                    $transaction->amount = $request->amount;
                    $transaction->note = $request->note;
                    $transaction->type = 1;
                    $transaction->payment_type = $request->payment_type;
                    $transaction->image_url = $request->image_url;
                    $transaction->cheque_withholding_challan_no = $request->cheque_withholding_challan_no;

                    $transaction->is_active = 1;

                    $team_id = $transaction->team_id;
                    $is_walking = $team->is_walking;
                    if ($is_walking == 1) {
                        $transaction->is_walking = 1;
                    } else {
                        $transaction->is_walking = 0;
                    }

                    if (Auth::user()->type == 1) {
                        $transaction->is_transfer = 1;
                    } else {
                        $transaction->is_transfer = 0;
                    }

                    $store = $transaction->save();
                    $credit_transaction_id = $transaction->id;
                    $wallet_type = $transaction->wallet_type;
                    $payment_type = $request->payment_type;
                    $this->sendNotificationTeamLead($transaction->id, $transaction->branch_id, $transaction->team_id);
                    $this->sendNotificationAdmin($transaction->id, $transaction->branch_id, $transaction->team_id);
                    $this->AddToLog("Transaction for team id $transaction->team_id and transaction# $transaction->id added successfully");


                    if ($store) {
                        $transaction_email = new ContractController();
                        $transaction_email->sendTransactionEmail($team_id, $transaction->id);


                        $this->makePayment($team_id, $credit_transaction_id, $transaction_date, $is_walking, $wallet_type, $payment_type);
                        return response()->json(['Success' => 'Transaction added successfully']);
                    }

                } else {
                    $threshhold_email = new ContractController();
                    $threshhold_email->sendThreshholdEmail($admin->id, $collected_amount, $error_payment_type);
                    return response()->json(['error' => $error_payment_type . ' Limit Exceeded, You Can Collect ' . number_format($remaining_limit_amount, 0) . ' /PKR More as ' . $error_payment_type . ' Please Contact To  Admin'], 500);
                }


            }

        } else {
            $team = Team::find($request->team_id);
            $admin = Admin::find(Auth::id());
            $transaction = new Transaction;
            $transaction_date = date('Y-m-d', strtotime($request->transaction_date));
            $transaction->transaction_date = $transaction_date;
            $transaction->admin_id = $admin->id;
            $transaction->team_id = $request->team_id;
            $transaction->branch_id = $team->branch_id;
            $transaction->wallet_type = $request->wallet_type;

            $transaction->amount = $request->amount;
            $transaction->note = $request->note;
            $transaction->type = 1;
            $transaction->payment_type = $request->payment_type;
            $transaction->image_url = $request->image_url;
            $transaction->cheque_withholding_challan_no = $request->cheque_withholding_challan_no;

            $transaction->is_active = 1;

            $team_id = $transaction->team_id;
            $is_walking = $team->is_walking;
            if ($is_walking == 1) {
                $transaction->is_walking = 1;
            } else {
                $transaction->is_walking = 0;
            }

            if (Auth::user()->type == 1) {
                $transaction->is_transfer = 1;
            } else {
                $transaction->is_transfer = 0;
            }

            $store = $transaction->save();
            $credit_transaction_id = $transaction->id;
            $wallet_type = $transaction->wallet_type;
            $payment_type = $request->payment_type;
            $this->sendNotificationTeamLead($transaction->id, $transaction->branch_id, $transaction->team_id);
            $this->sendNotificationAdmin($transaction->id, $transaction->branch_id, $transaction->team_id);
            $this->AddToLog("Transaction for team id $transaction->team_id and transaction# $transaction->id added successfully");


            if ($store) {
                $transaction_email = new ContractController();
                $transaction_email->sendTransactionEmail($team_id, $transaction->id);

                $this->makePayment($team_id, $credit_transaction_id, $transaction_date, $is_walking, $wallet_type, $payment_type);
                return response()->json(['Success' => 'Transaction added successfully']);
            }
        }


    }

//    Upload transaction type image
    public function upload_transaction_type_image()
    {
        if (isset($_FILES['file'])) {

            if ($_FILES['file']['error'] == 4) {
                echo("File missing");
                return;
            }

            $image = getimagesize($_FILES['file']['tmp_name']);

            if (!$image) {
                echo("Not a valid image");
                return;
            }

            if ($_FILES['file']['size'] > 5000000) {
                echo("max allowed file size is 500 MB");
                return;
            }

            $valid_types = array("image/jpeg", "image/png");

            if (!in_array($_FILES['file']['type'], $valid_types)) {
                echo("Only jpeg/png allowed");
                return;
            }

            if ($_FILES['file']['type'] != $image['mime']) {
                echo("Corrupt image");
                return;
            }

//            if (is_null($this->user_name)) {
//                throw new Exception("failed to generate file name");
//            }

//            $pathinfo = pathinfo($profile_image['name']);
//            extract($pathinfo);
//            $file_name = $this->user_name . "." . $extension;
//


//            if ($_FILES['file']['error'] > 0) {
//                echo 'Error: ' . $_FILES['file']['error'] . '<br>';
//            } else {
            if (move_uploaded_file($_FILES['file']['tmp_name'], base_path('public/images/transaction_images/image_') . $_FILES['file']['name'])) {
                echo("image_" . $_FILES['file']['name']);
                return;
//                }
            } else {
                echo("failed to upload file");
                return;
            }
        }
    }

//    Show transactions in finance module
    public function transaction()
    {
        if (Auth::user()->type == 1) {
            $transactions = Transaction::where('type', '=', 1)->where('is_active', 1)->get()->all();
        } else {
            $branch_id = Auth::user()->branch_id;
            $users = User::where('branch_id', '=', $branch_id)->get();
            $transactions = Transaction::where('branch_id', '=', $branch_id)->where('type', '=', 1)->where('is_active', 1)->get();

        }


//        $transactions = DB::select("select u.name as leader_name, t.name as team_name, t.leader_id ,trans.id,trans.type,trans.amount,
//                                         trans.team_id,trans.invoice_id,trans.note,trans.image_url,trans.payment_type,trans.wallet_type,trans.created_at,
//                                         trans.updated_at from teams as t
//                                         left join transactions as trans on t.id = trans.team_id
//                                         left join users as u on u.id = t.leader_id where trans.type = 1 ");


        return view('admin.transaction', compact('transactions'));
    }

    /*******************Team Asset Assign**********************/
    public function getNonBookableAsset(Request $request)
    {
        $team = Team::find($request->team_id);
        $assets = Asset::where('bookable', '=', 0)->where('is_nomad', 0)->where('branch_id', $team->branch_id)->get();
        return response()->json($assets);
    }

// Assign assets to team and make fix deposit/recuriing invoice updation/ pro rata rate invoice/free booking and free printing
    public function setTeamAsset(Request $request, $team_id)
    {
        if (!empty($request)) {

            $team = Team::where('id', '=', $team_id)->first();
            $invoice = RecurringInvoice::where('team_id', $team_id)->where('is_active', 1)->orderBy('created_at', 'desc')->first();

            $assetDetail = new Assetdetail();
            $assetDetail->asset_id = $request->asset;
            $assetDetail->quantity = $request->quantity;
            $assetDetail->team_id = $team_id;
            $asset = Asset::find($request->asset);

            if (!empty($invoice)) {
                $asset_total_after_discount = 0;
                $new_asset_discount_amount = 0;
                $new_asset_tax_amount = 0;
                if (isset($invoice->discount) && $invoice->discount > 0) {
                    $new_asset_discount_amount = ($invoice->discount / 100) * $asset->price;
                    $new_asset_discount_amount *= $request->quantity;
                    $invoice->discount_amount += $new_asset_discount_amount;

                    $asset_total_after_discount = ($asset->price * $request->quantity) - $new_asset_discount_amount;
//                    $invoice->total += $asset_total_after_discount;

                    $asset_amount_total = $asset->price * $request->quantity;

                    $invoice->amount += $asset_amount_total;
                } else {
                    $asset_total_after_discount = ($asset->price * $request->quantity);
                    $asset_amount_total = $asset->price * $request->quantity;

                    $invoice->amount += $asset_amount_total;
                }
                if (isset($invoice->tax) && $invoice->tax > 0) {
                    $new_asset_tax_amount = ($invoice->tax / 100) * $asset_total_after_discount;
//                    $new_asset_tax_amount *= $request->quantity;
                    $invoice->tax_amount += $new_asset_tax_amount;
                    $total = $asset_total_after_discount + $new_asset_tax_amount;
                    $invoice->total += $total;
                } else {
                    $total = $asset_total_after_discount;
                    $invoice->total += $total;
                }

                if ($invoice->save()) {
                    $this->AddToLog("Recurring Invoice created");
                    if (!($asset == null)) {
                        $invoice_item = new RecurringInvoiceItem();
                        $invoice_item->team_id = $invoice->team_id;
                        $invoice_item->invoice_id = $invoice->id;
                        $invoice_item->branch_id = $invoice->branch_id;
                        $invoice_item->item = $asset->name;
                        $invoice_item->qty = $request->quantity;
                        $invoice_item->price = $asset->price;
                        $invoice_item->total = $asset->price * $request->quantity;
                        $invoice_item->is_active = 1;
                        $invoice_item->save();


                    }

                    $now = date('d-m-Y');
                    $invoice_date = date('d-m-Y', strtotime($now));
                    $due_date = strtotime($invoice_date) + (60 * 60 * 24) * (5);

                    $invoice_due_date = date("d-m-y", $due_date);

                    $fixed_deposit = new Invoice();
                    $fixed_deposit->team_id = $invoice->team_id;
                    $fixed_deposit->is_walking = 0;
                    $fixed_deposit->branch_id = $invoice->branch_id;
                    $fixed_deposit->bill_to_name = $invoice->bill_to_name;
                    $fixed_deposit->bill_to_address = $invoice->bill_to_address;
                    $fixed_deposit->tax = 0;
                    $fixed_deposit->tax_amount = 0;
                    $fixed_deposit->wallet_type = 1;
                    $fixed_deposit->discount = 0;
                    $fixed_deposit->discount_amount = 0;
                    $fixed_deposit->description = "Auto generated invoice for " . $asset->name . "fixed deposit";
                    $fixed_deposit->invoice_date = $invoice_date;
                    $fixed_deposit->invoice_due_date = $invoice_due_date;
                    $fixed_deposit->amount = $asset->fixed_deposit;
                    $fixed_deposit->total = $asset->fixed_deposit * $request->quantity;
                    if ($fixed_deposit->save()) {

                        $this->assetAddMakePayment($fixed_deposit->team_id, $fixed_deposit->id);



                        $this->AddToLog("Fixed deposit invoice created");

                        if (!($asset == null)) {
                            $invoice_item = new InvoiceItem();
                            $invoice_item->team_id = $fixed_deposit->team_id;
                            $invoice_item->invoice_id = $fixed_deposit->id;
                            $invoice_item->branch_id = $fixed_deposit->branch_id;
                            $invoice_item->item = $asset->name . " fixed deposit";
                            $invoice_item->qty = $request->quantity;
                            $invoice_item->price = $asset->price;
                            $invoice_item->total = $asset->price * $request->quantity;
                            $invoice_item->is_active = 1;
                            $invoice_item->save();

                            //                send invoice to user as email code
//                            $invoice_email = new ContractController();
//                            $invoice_email->sendInvoice($fixed_deposit->id);

//

                        }


//                        $month_days = 30;
                        $maxDays = date('t');
                        $month_days = $maxDays;
                        $amount = 0;
                        $invoice_first_partial = new Invoice();
                        $now = date('d');
                        $bill_days = $month_days - $now;
                        $per_day_price = $asset->price / $month_days;
                        $total_price = $per_day_price * $bill_days;
                        $amount = ceil($amount + ($total_price * $request->quantity));

                        $invoice_first_partial->branch_id = $invoice->branch_id;
                        $invoice_first_partial->team_id = $invoice->team_id;
                        $invoice_first_partial->is_walking = 0;
                        $invoice_first_partial->bill_to_name = $invoice->bill_to_name;
                        $invoice_first_partial->bill_to_address = $invoice->bill_to_address;
                        $invoice_first_partial->amount = $amount;
                        $invoice_first_partial->wallet_type = $invoice->wallet_type;
                        $invoice_first_partial->discount = ceil($invoice->discount);
                        $invoice_first_partial->description = "Auto generated invoice for " . $asset->name . " of .$bill_days. days";
                        $invoice_first_partial->tax = ceil($invoice->tax);

                        $now = date('d-m-Y');;
                        $invoice_first_partial_date = date('d-m-Y', strtotime($now));
                        $due_date = strtotime($invoice_first_partial_date) + (60 * 60 * 24 * 5);

                        $invoice_first_partial_due_date = date("d-m-Y", $due_date);

                        $invoice_first_partial->invoice_date = $invoice_first_partial_date;
                        $invoice_first_partial->invoice_due_date = $invoice_first_partial_due_date;


                        $asset_total_after_discount = 0;
                        $new_asset_discount_amount = 0;
                        $new_asset_tax_amount = 0;
                        if (isset($invoice->discount) && $invoice->discount > 0) {
                            $new_asset_discount_amount = ($invoice->discount / 100) * $amount;
//                            $new_asset_discount_amount *= $request->quantity;
                            $invoice_first_partial->discount_amount = $new_asset_discount_amount;

                            $asset_total_after_discount = ($amount) - $new_asset_discount_amount;
                        }else{
                            $asset_total_after_discount = $amount;

                        }
                        if (isset($invoice->tax) && $invoice->tax > 0) {
                            $new_asset_tax_amount = ($invoice->tax / 100) * $asset_total_after_discount;
//                            $new_asset_tax_amount *= $request->quantity;
                            $invoice_first_partial->tax_amount = ceil($new_asset_tax_amount);
                        }else{
                            $new_asset_tax_amount = 0;

                        }
                        $invoice_first_partial->total = ceil($asset_total_after_discount + $new_asset_tax_amount);


                        if ($invoice_first_partial->save()) {
                            $this->assetAddMakePayment($invoice_first_partial->team_id, $invoice_first_partial->id);

                            $this->AddToLog("Invoice created for remaining days of new asset");
                            if (!($asset == null)) {
                                $invoice_item = new InvoiceItem();
                                $invoice_item->team_id = $invoice_first_partial->team_id;
                                $invoice_item->invoice_id = $invoice_first_partial->id;
                                $invoice_item->branch_id = $invoice_first_partial->branch_id;
                                $invoice_item->item = $asset->name;
                                $invoice_item->qty = $request->quantity;
                                $invoice_item->price = $asset->price;
                                $invoice_item->total = $asset->price * $request->quantity;
                                $invoice_item->is_active = 1;
                                $invoice_item->save();

                                //                send invoice to user as email code
//                                $invoice_email = new ContractController();
//                                $invoice_email->sendInvoice($invoice_first_partial->id);

//


                                $transaction_booking = new Transaction;
                                $admin = Admin::find(Auth::id());
                                $transaction_date = date('Y-m-d');
                                $transaction_booking->transaction_date = $transaction_date;
                                $transaction_booking->admin_id = $admin->id;
                                $transaction_booking->type = 1;
                                $free_booking_price = 0;
                                $free_booking_price = ($asset->free_booking * $request->quantity);

                                $transaction_booking->amount = $free_booking_price;
                                $transaction_booking->branch_id = $invoice_first_partial->branch_id;
                                $transaction_booking->team_id = $invoice_first_partial->team_id;
                                $transaction_booking->note = "Free monthly booking credit";
                                $transaction_booking->payment_type = 2;
                                $transaction_booking->wallet_type = 2;
                                $transaction_booking->save();
                                $is_walking = 1;
                                $this->makePayment($transaction_booking->team_id, $transaction_booking->id, $transaction_date, $is_walking, $transaction_booking->wallet_type, $transaction_booking->payment_type);


                                $this->AddToLog("Free monthly booking credit added for new asset");

                                $transaction_printing = new Transaction;
                                $admin = Admin::find(Auth::id());
                                $transaction_date = date('Y-m-d');
                                $transaction_printing->transaction_date = $transaction_date;
                                $transaction_printing->admin_id = $admin->id;
                                $transaction_printing->type = 1;
                                $free_printing_price = 0;
                                $free_printing_price = ($asset->free_printing * $request->quantity);

                                $transaction_printing->amount = $free_printing_price;
                                $transaction_printing->branch_id = $invoice_first_partial->branch_id;
                                $transaction_printing->team_id = $invoice_first_partial->team_id;
                                $transaction_printing->note = "Free monthly printing credit";
                                $transaction_printing->payment_type = 2;
                                $transaction_printing->wallet_type = 3;
                                $transaction_printing->save();

                                $this->makePayment($transaction_printing->team_id, $transaction_printing->id, $transaction_date, $is_walking, $transaction_printing->wallet_type, $transaction_printing->payment_type);


                                $this->AddToLog("Free monthly printing credit added for new asset");

                            }
                        }
                    }

                    $assetDetail->save();

                    $this->AddToLog("New asset added to team assets");

                    $this->sendNotificationTeamLeadAsset($team->leader_id, $asset->name);
                    return response()->json(['success' => 'Asset Successfully Assigned']);
                }


            }
            return response()->json(['msg' => 'Asset Not Added. Recurring invoice expired or not found'],500);
        }
    }


// algo for aseet add payment
    public function assetAddMakePayment($team_id, $invoice_id)
    {
        $invoice_booking = Invoice::find($invoice_id);
        $team = Team::find($team_id);
        $get_team_all_cash_booking_credit = DB::select("select * from transactions where team_id = $team_id and type = 1 and payment_type != 2 and wallet_type = 1 and is_active = 1");
        $get_team_all_cash_booking_debit = DB::select("select * from transactions where team_id = $team_id and type = 2 and payment_type != 2 and wallet_type = 1 and is_active = 1");
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

//            echo "<pre>";
//            print_r($cash_room_balance);
//            die;


        if ($cash_room_balance > 0 && $cash_room_balance >= $invoice_booking->total) {


            $asset_invoice_price_remaining = 0;
            foreach ($get_team_all_cash_booking_credit as $key => $remaining_balance_transaction) {


                if (!empty($remaining_balance_transaction->remaining_credit_trans) && $remaining_balance_transaction->remaining_credit_trans > 0) {
                    if (!empty($asset_invoice_price_remaining) && $asset_invoice_price_remaining > 0) {
                        if ($remaining_balance_transaction->remaining_credit_trans >= $asset_invoice_price_remaining) {
                            $transaction_booking = new Transaction();
                            $transaction_date = date('Y-m-d');
                            $transaction_booking->transaction_date = $transaction_date;
                            $transaction_booking->admin_id = 0;
                            $transaction_booking->team_id = $invoice_booking->team_id;
                            $transaction_booking->branch_id = $team->branch_id;
                            $transaction_booking->booking_id = 0;
                            $transaction_booking->invoice_id = $invoice_booking->id;
                            $transaction_booking->wallet_type = $invoice_booking->wallet_type;
                            $transaction_booking->amount = $asset_invoice_price_remaining;
                            $transaction_booking->credit_transaction_id = $remaining_balance_transaction->id;
                            $transaction_booking->note = "Auto generated transaction for billing invoice # $transaction_booking->invoice_id";
                            $transaction_booking->type = 2;
                            $transaction_booking->payment_type = 1;
                            $asset_invoice_price_remaining -= $asset_invoice_price_remaining;

                            $transaction_booking->save();
                            return response()->json(['success' => "billing invoice $invoice_booking->id paid successfully by transaction id $transaction_booking->id "]);

                        } else {
                            $asset_invoice_price_remaining -= $remaining_balance_transaction->remaining_credit_trans;
                            $transaction_booking = new Transaction();
                            $transaction_date = date('Y-m-d');
                            $transaction_booking->transaction_date = $transaction_date;
                            $transaction_booking->admin_id = 0;
                            $transaction_booking->team_id = $invoice_booking->team_id;
                            $transaction_booking->branch_id = $team->branch_id;
                            $transaction_booking->booking_id = 0;
                            $transaction_booking->invoice_id = $invoice_booking->id;
                            $transaction_booking->wallet_type = $invoice_booking->wallet_type;
                            $transaction_booking->amount = $remaining_balance_transaction->remaining_credit_trans;
                            $transaction_booking->credit_transaction_id = $remaining_balance_transaction->id;
                            $transaction_booking->note = "Auto generated transaction for billing invoice # $transaction_booking->invoice_id";
                            $transaction_booking->type = 2;
                            $transaction_booking->payment_type = 1;
                            $transaction_booking->save();
                            $this->AddToLog("Auto generated transaction for booking invoice#  $transaction_booking->invoice_id of  $team->name Created successfully");
                            return response()->json(['success' => "billing invoice $invoice_booking->id paid successfully by transaction id $remaining_balance_transaction->id "]);

                        }
                    }

                    if ($remaining_balance_transaction->remaining_credit_trans >= $invoice_booking->total) {
//                        print_r($remaining_balance_transaction);
//                        die;

                        $transaction_booking = new Transaction();
                        $transaction_date = date('Y-m-d');
                        $transaction_booking->transaction_date = $transaction_date;
                        $transaction_booking->admin_id = 0;
                        $transaction_booking->team_id = $team->id;
                        $transaction_booking->branch_id = $team->id;
                        $transaction_booking->booking_id = 0;
                        $transaction_booking->invoice_id = $invoice_booking->id;
                        $transaction_booking->wallet_type = $invoice_booking->wallet_type;
                        $transaction_booking->amount = $invoice_booking->total;
                        $transaction_booking->credit_transaction_id = $remaining_balance_transaction->id;
                        $transaction_booking->note = "Auto generated transaction for billing invoice # $transaction_booking->invoice_id";
                        $transaction_booking->type = 2;
                        $transaction_booking->payment_type = 1;
                        $get_team_all_cash_booking_credit[$key]->remaining_credit_trans = 0;
                        $get_team_all_cash_booking_credit[$key]->remaining_credit = 0;
                        $transaction_booking->save();
                        $this->AddToLog("Auto generated transaction for booking invoice#  $transaction_booking->invoice_id of  $team->name Created successfully");
                        return response()->json(['success' => "billing invoice $invoice_booking->id paid successfully by transaction id $transaction_booking->id "]);

                    } else {
                        $asset_invoice_price_remaining = $invoice_booking->total - $remaining_balance_transaction->remaining_credit_trans;
                        $transaction_booking = new Transaction();
                        $transaction_date = date('Y-m-d');
                        $transaction_booking->transaction_date = $transaction_date;
                        $transaction_booking->admin_id = 0;
                        $transaction_booking->team_id = $invoice_booking->team_id;
                        $transaction_booking->branch_id = $team->branch_id;
                        $transaction_booking->booking_id = 0;
                        $transaction_booking->invoice_id = $invoice_booking->id;
                        $transaction_booking->wallet_type = $invoice_booking->wallet_type;
                        $transaction_booking->amount = $remaining_balance_transaction->remaining_credit_trans;
                        $transaction_booking->credit_transaction_id = $remaining_balance_transaction->id;
                        $transaction_booking->note = "Auto generated transaction for billing invoice # $transaction_booking->invoice_id";
                        $transaction_booking->type = 2;
                        $transaction_booking->payment_type = 1;
                        $get_team_all_cash_booking_credit[$key]->remaining_credit_trans = 0;
                        $get_team_all_cash_booking_credit[$key]->remaining_credit = 0;
                        $transaction_booking->save();
                        $this->AddToLog("Auto generated transaction for booking invoice#  $transaction_booking->invoice_id of  $team->name Created successfully");


                    }

                } elseif (!empty($remaining_balance_transaction->amount) && !isset($remaining_balance_transaction->remaining_credit_trans) && !isset($remaining_balance_transaction->remaining_credit)) {

                    if (!empty($asset_invoice_price_remaining) && $asset_invoice_price_remaining > 0) {
                        if ($remaining_balance_transaction->amount >= $asset_invoice_price_remaining) {
                            $transaction_booking = new Transaction();
                            $transaction_date = date('Y-m-d');
                            $transaction_booking->transaction_date = $transaction_date;
                            $transaction_booking->admin_id = 0;
                            $transaction_booking->team_id = $invoice_booking->team_id;
                            $transaction_booking->branch_id = $team->branch_id;
                            $transaction_booking->booking_id = 0;
                            $transaction_booking->invoice_id = $invoice_booking->id;
                            $transaction_booking->wallet_type = $invoice_booking->wallet_type;
                            $transaction_booking->amount = $asset_invoice_price_remaining;
                            $transaction_booking->credit_transaction_id = $remaining_balance_transaction->id;
                            $transaction_booking->note = "Auto generated transaction for billing invoice # $transaction_booking->invoice_id";
                            $transaction_booking->type = 2;
                            $transaction_booking->payment_type = 1;
                            $asset_invoice_price_remaining -= $asset_invoice_price_remaining;

                            $transaction_booking->save();
                            return response()->json(['success' => "billing invoice $invoice_booking->id paid successfully by transaction id $transaction_booking->id "]);

                        } else {
                            $asset_invoice_price_remaining -= $remaining_balance_transaction->amount;
                            $transaction_booking = new Transaction();
                            $transaction_date = date('Y-m-d');
                            $transaction_booking->transaction_date = $transaction_date;
                            $transaction_booking->admin_id = 0;
                            $transaction_booking->team_id = $invoice_booking->team_id;
                            $transaction_booking->branch_id = $team->branch_id;
                            $transaction_booking->booking_id = 0;
                            $transaction_booking->invoice_id = $invoice_booking->id;
                            $transaction_booking->wallet_type = $invoice_booking->wallet_type;
                            $transaction_booking->amount = $remaining_balance_transaction->amount;
                            $transaction_booking->credit_transaction_id = $remaining_balance_transaction->id;
                            $transaction_booking->note = "Auto generated transaction for billing invoice # $transaction_booking->invoice_id";
                            $transaction_booking->type = 2;
                            $transaction_booking->payment_type = 1;
                            $transaction_booking->save();
                            $this->AddToLog("Auto generated transaction for booking invoice#  $transaction_booking->invoice_id of  $team->name Created successfully");
                            return response()->json(['success' => "billing invoice $invoice_booking->id paid successfully by transaction id $transaction_booking->id "]);

                        }
                    }


                    if ($remaining_balance_transaction->amount >= $invoice_booking->total) {
                        $transaction_booking = new Transaction();
                        $transaction_date = date('Y-m-d');
                        $transaction_booking->transaction_date = $transaction_date;
                        $transaction_booking->admin_id = 0;
                        $transaction_booking->team_id = $invoice_booking->team_id;
                        $transaction_booking->branch_id = $team->branch_id;
                        $transaction_booking->booking_id = 0;
                        $transaction_booking->invoice_id = $invoice_booking->id;
                        $transaction_booking->wallet_type = $invoice_booking->wallet_type;
                        $transaction_booking->amount = $invoice_booking->total;
                        $transaction_booking->credit_transaction_id = $remaining_balance_transaction->id;
                        $transaction_booking->note = "Auto generated transaction for billing invoice # $transaction_booking->invoice_id";
                        $transaction_booking->type = 2;
                        $transaction_booking->payment_type = 1;
                        $transaction_booking->save();
                        $this->AddToLog("Auto generated transaction for booking invoice#  $transaction_booking->invoice_id of  $team->name Created successfully");
                        return response()->json(['success' => "billing invoice $invoice_booking->id paid successfully by transaction id $transaction_booking->id "]);

                    } else {
                        $asset_invoice_price_remaining = $invoice_booking->total - $remaining_balance_transaction->amount;
                        $transaction_booking = new Transaction();
                        $transaction_date = date('Y-m-d');
                        $transaction_booking->transaction_date = $transaction_date;
                        $transaction_booking->admin_id = 0;
                        $transaction_booking->team_id = $invoice_booking->team_id;
                        $transaction_booking->branch_id = $team->branch_id;
                        $transaction_booking->booking_id = 0;
                        $transaction_booking->invoice_id = $invoice_booking->id;
                        $transaction_booking->wallet_type = $invoice_booking->wallet_type;
                        $transaction_booking->amount = $remaining_balance_transaction->amount;
                        $transaction_booking->credit_transaction_id = $remaining_balance_transaction->id;
                        $transaction_booking->note = "Auto generated transaction for billing invoice # $transaction_booking->invoice_id";
                        $transaction_booking->type = 2;
                        $transaction_booking->payment_type = 1;
                        $transaction_booking->save();
                        $this->AddToLog("Auto generated transaction for booking invoice#  $transaction_booking->invoice_id of  $team->name Created successfully");

                    }

                }


            }


        } elseif (isset($cash_room_balance) && $cash_room_balance > 0 && $cash_room_balance < $invoice_booking->total) {

            $asset_invoice_price_remaining = 0;
//           echo"<pre>"; print_r($cash_room_balance);
//            die;
            foreach ($get_team_all_cash_booking_credit as $key => $remaining_balance_transaction) {

                if (!empty($remaining_balance_transaction->remaining_credit_trans) && $remaining_balance_transaction->remaining_credit_trans > 0) {


                    if (!empty($asset_invoice_price_remaining) && $asset_invoice_price_remaining > 0) {

                        $asset_invoice_price_remaining -= $remaining_balance_transaction->remaining_credit_trans;
                        $transaction_booking = new Transaction();
                        $transaction_date = date('Y-m-d');
                        $transaction_booking->transaction_date = $transaction_date;
                        $transaction_booking->admin_id = 0;
                        $transaction_booking->team_id = $invoice_booking->team_id;
                        $transaction_booking->branch_id = $team->branch_id;
                        $transaction_booking->booking_id = 0;
                        $transaction_booking->invoice_id = $invoice_booking->id;
                        $transaction_booking->wallet_type = $invoice_booking->wallet_type;
                        $transaction_booking->amount = $remaining_balance_transaction->remaining_credit_trans;
                        $transaction_booking->credit_transaction_id = $remaining_balance_transaction->id;
                        $transaction_booking->note = "Auto generated transaction for billing invoice # $transaction_booking->invoice_id";
                        $transaction_booking->type = 2;
                        $transaction_booking->payment_type = 1;
                        $transaction_booking->save();
                        $this->AddToLog("Auto generated transaction for booking invoice#  $transaction_booking->invoice_id of  $team->name Created successfully");
//                        return response()->json(['success' => "billing invoice $invoice_booking->id paid successfully by transaction id $remaining_balance_transaction->id "]);


                    } else {
                        $asset_invoice_price_remaining -= $remaining_balance_transaction->remaining_credit_trans;
                        $transaction_booking = new Transaction();
                        $transaction_date = date('Y-m-d');
                        $transaction_booking->transaction_date = $transaction_date;
                        $transaction_booking->admin_id = 0;
                        $transaction_booking->team_id = $invoice_booking->team_id;
                        $transaction_booking->branch_id = $team->branch_id;
                        $transaction_booking->booking_id = 0;
                        $transaction_booking->invoice_id = $invoice_booking->id;
                        $transaction_booking->wallet_type = $invoice_booking->wallet_type;
                        $transaction_booking->amount = $remaining_balance_transaction->remaining_credit_trans;
                        $transaction_booking->credit_transaction_id = $remaining_balance_transaction->id;
                        $transaction_booking->note = "Auto generated transaction for billing invoice # $transaction_booking->invoice_id";
                        $transaction_booking->type = 2;
                        $transaction_booking->payment_type = 1;
                        $transaction_booking->save();

                        $this->AddToLog("Auto generated transaction for booking invoice#  $transaction_booking->invoice_id of  $team->name Created successfully");

                    }


                } elseif (!empty($remaining_balance_transaction->amount) && !isset($remaining_balance_transaction->remaining_credit_trans) && !isset($remaining_balance_transaction->remaining_credit)) {

                    if (!empty($asset_invoice_price_remaining) && $asset_invoice_price_remaining > 0) {

                        $asset_invoice_price_remaining -= $remaining_balance_transaction->amount;
                        $transaction_booking = new Transaction();
                        $transaction_date = date('Y-m-d');
                        $transaction_booking->transaction_date = $transaction_date;
                        $transaction_booking->admin_id = 0;
                        $transaction_booking->team_id = $invoice_booking->team_id;
                        $transaction_booking->branch_id = $team->branch_id;
                        $transaction_booking->booking_id = 0;
                        $transaction_booking->invoice_id = $invoice_booking->id;
                        $transaction_booking->wallet_type = $invoice_booking->wallet_type;
                        $transaction_booking->amount = $remaining_balance_transaction->amount;
                        $transaction_booking->credit_transaction_id = $remaining_balance_transaction->id;
                        $transaction_booking->note = "Auto generated transaction for billing invoice # $transaction_booking->invoice_id";
                        $transaction_booking->type = 2;
                        $transaction_booking->payment_type = 1;
                        $transaction_booking->save();
                        $this->AddToLog("Auto generated transaction for booking invoice#  $transaction_booking->invoice_id of  $team->name Created successfully");
//                        return response()->json(['success' => "billing invoice $invoice_booking->id paid successfully by transaction id $remaining_balance_transaction->id "]);


                    } else {
                        $asset_invoice_price_remaining -= $remaining_balance_transaction->amount;
                        $transaction_booking = new Transaction();
                        $transaction_date = date('Y-m-d');
                        $transaction_booking->transaction_date = $transaction_date;
                        $transaction_booking->admin_id = 0;
                        $transaction_booking->team_id = $invoice_booking->team_id;
                        $transaction_booking->branch_id = $team->branch_id;
                        $transaction_booking->booking_id = 0;
                        $transaction_booking->invoice_id = $invoice_booking->id;
                        $transaction_booking->wallet_type = $invoice_booking->wallet_type;
                        $transaction_booking->amount = $remaining_balance_transaction->amount;
                        $transaction_booking->credit_transaction_id = $remaining_balance_transaction->id;
                        $transaction_booking->note = "Auto generated transaction for billing invoice # $transaction_booking->invoice_id";
                        $transaction_booking->type = 2;
                        $transaction_booking->payment_type = 1;
                        $transaction_booking->save();

                        $this->AddToLog("Auto generated transaction for booking invoice#  $transaction_booking->invoice_id of  $team->name Created successfully");

                    }
                }


            }



                return response()->json(['success' => 'booking added successfully by partial amount']);



        }

    }







//test algo for payment1
//    public function makePaymentAssetAdd($team_id, $credit_transaction_id, $transaction_date, $is_walking, $wallet_type, $payment_type)
//
//    {
//        $team = Team::find($team_id);
//        $users_transaction_data = DB::select("select * from transactions where team_id = $team_id and is_active = 1");
//
//        $users = array();
//        $dues_billing = array();
//        $i = 0;
//        $user_invoices_data = Array();
//        foreach ($users_transaction_data as $data) {
//            $user_invoices = DB::select("select  * from invoices where team_id = $data->team_id and is_active = 1 ");
//            if (!Empty($user_invoices)) {
//                $user_invoices_data = array_values($user_invoices);
//
//            }
//            $i++;
//        }
//        $a = 0;
//        $invoice_transaction_remaining = 0;
//        foreach ($user_invoices_data as $key => $invoice) {
//
//            $transaction = DB::select("select  * from transactions where invoice_id = $invoice->id and wallet_type = $invoice->wallet_type and is_active = 1");
//            $invoice_transaction_billing_sum = 0;
//            $invoice_transaction_room_sum = 0;
//            $invoice_transaction_printing_sum = 0;
//
////          calculate all dues of one user according to wallet_type and add it to dues array
////            print_r($invoice->id);echo "<br>";
//            if (!empty($transaction)) {
//                $single_invoice_transaction = array_values($transaction);
//                foreach ($single_invoice_transaction as $invoice_transaction) {
//
//                    if ($invoice_transaction->invoice_id == $invoice->id && $invoice_transaction->wallet_type == $invoice->wallet_type) {
//                        if ($invoice->wallet_type == 1) {
//                            $invoice_transaction_billing_sum += $invoice_transaction->amount;
//
//                        }
//
//                    }
//
//                }
//
//                if ($invoice->wallet_type == 1) {
//                    if (!($invoice_transaction_billing_sum == $invoice->total)) {
//                        $invoice_transaction_billing_remaining = $invoice->total - $invoice_transaction_billing_sum;
//                        $user_invoices_data[$key]->dues = $invoice_transaction_billing_remaining;
//                        $dues_billing[] = $invoice;
//                    }
//
//                }
//
//            } else {
//
//                if ($invoice->wallet_type == 1) {
//                    $dues_billing[] = $invoice;
//
//                }
//
//            }
//            $count_billing_c = 0;
//            $count_room_c = 0;
//            $count_printing_c = 0;
//            $single_user_billing_credit = 0;
//            $single_user_room_credit = 0;
//            $single_user_printing_credit = 0;
//            $single_user_billing_debit = 0;
//            $single_user_room_debit = 0;
//            $single_user_printing_debit = 0;
//
//            //         take single user_id according to wallet_type and calculate its all credit
//            if (!empty($dues_billing)) {
//                foreach ($dues_billing as $user_dues) {
//                    if ($count_billing_c == 0) {
//                        $user_transaction_billing_credit = DB::select("select  * from transactions where team_id = $user_dues->team_id and type = 1 and wallet_type = 1 and is_active = 1");
//                        $count_billing_c++;
//                    }
//                }
//                foreach ($user_transaction_billing_credit as $user_credit) {
//                    $single_user_billing_credit += $user_credit->amount;
//
//                }
////            credit end
//
////         take single user_id and calculate its all debit
//
//                $count_billing_d = 0;
//                foreach ($dues_billing as $user_dues) {
//                    if ($count_billing_d == 0) {
//                        $user_transaction_billing_debit = DB::select("select  * from transactions where team_id = $user_dues->team_id and is_active = 1
//                           and type = 2 and wallet_type = 1");
//                        $count_billing_d++;
//                    }
//                }
//
//                foreach ($user_transaction_billing_debit as $user_debit) {
//                    $single_user_billing_debit += $user_debit->amount;
//
//                }
//
////            debit end
//
//                $single_user_billing_balance = $single_user_billing_credit - $single_user_billing_debit;
//
//            }
//        }
////        add transaction in transaction table by taking invoices from dues dataset and deduct the amount from single_user_balance
//        if (!empty($dues_billing && $wallet_type == 1)) {
//            foreach ($dues_billing as $user_dues) {
//                if ($single_user_billing_balance > 0) {
//
////            if Invoice is partially paid then check dues of it from dues field
//                    if (isset($user_dues->dues)) {
//                        if ($user_dues->dues <= $single_user_billing_balance) {
//                            $insert_transaction = new Transaction();
//                            if ($is_walking == 1) {
//                                $insert_transaction->is_walking = 1;
//                            } else {
//                                $insert_transaction->is_walking = 0;
//                            }
////                            $transaction_date = date('Y-m-d');
//                            $insert_transaction->transaction_date = $transaction_date;
//                            $insert_transaction->admin_id = 0;
//                            $insert_transaction->type = 2;
//                            $insert_transaction->branch_id = $team->branch_id;
//                            $insert_transaction->amount = $user_dues->dues;
//                            $insert_transaction->team_id = $user_dues->team_id;
//                            $insert_transaction->invoice_id = $user_dues->id;
//                            $insert_transaction->credit_transaction_id = $credit_transaction_id;
//                            $insert_transaction->note = "Auto generated transaction for billing dues";
//                            $insert_transaction->payment_type = $payment_type;
//                            $insert_transaction->wallet_type = $user_dues->wallet_type;
//                            $single_user_billing_balance -= $user_dues->dues;
//                            $insert_transaction->save();
//                            $this->AddToLog("Auto generated transaction for billing dues of team id $insert_transaction->team_id for invoice# $insert_transaction->invoice_id created successfully");
//
//                        } else {
//                            $insert_transaction = new Transaction();
//                            if ($is_walking == 1) {
//                                $insert_transaction->is_walking = 1;
//                            } else {
//                                $insert_transaction->is_walking = 0;
//                            }
////                            $transaction_date = date('Y-m-d');
//                            $insert_transaction->transaction_date = $transaction_date;
//                            $insert_transaction->admin_id = 0;
//                            $insert_transaction->type = 2;
//                            $insert_transaction->branch_id = $team->branch_id;
//                            $insert_transaction->amount = $single_user_billing_balance;
//                            $insert_transaction->team_id = $user_dues->team_id;
//                            $insert_transaction->invoice_id = $user_dues->id;
//                            $insert_transaction->credit_transaction_id = $credit_transaction_id;
//                            $insert_transaction->note = "Auto generated transaction for billing dues";
//                            $insert_transaction->payment_type = $payment_type;
//                            $insert_transaction->wallet_type = $user_dues->wallet_type;
//                            $single_user_billing_balance -= $single_user_billing_balance;
//                            $insert_transaction->save();
//                            $this->AddToLog("Auto generated transaction for billing dues of team id $insert_transaction->team_id for invoice# $insert_transaction->invoice_id created successfully");
//
//                        }
////                    else Invoice is'nt paid and due with its full amount
//
//                    } else {
//                        if ($user_dues->total <= $single_user_billing_balance) {
//                            $insert_transaction = new Transaction();
//                            if ($is_walking == 1) {
//                                $insert_transaction->is_walking = 1;
//                            } else {
//                                $insert_transaction->is_walking = 0;
//                            }
////                            $transaction_date = date('Y-m-d');
//                            $insert_transaction->transaction_date = $transaction_date;
//                            $insert_transaction->admin_id = 0;
//                            $insert_transaction->type = 2;
//                            $insert_transaction->branch_id = $team->branch_id;
//                            $insert_transaction->amount = $user_dues->total;
//                            $insert_transaction->team_id = $user_dues->team_id;
//                            $insert_transaction->invoice_id = $user_dues->id;
//                            $insert_transaction->credit_transaction_id = $credit_transaction_id;
//                            $insert_transaction->note = "Auto generated transaction for billing dues";
//                            $insert_transaction->payment_type = $payment_type;
//                            $insert_transaction->wallet_type = $user_dues->wallet_type;
//                            $single_user_billing_balance -= $user_dues->total;
//                            $insert_transaction->save();
//                            $this->AddToLog("Auto generated transaction for billing dues of team id $insert_transaction->team_id for invoice# $insert_transaction->invoice_id created successfully");
//
//
//                        } else {
//                            $insert_transaction = new Transaction();
//                            if ($is_walking == 1) {
//                                $insert_transaction->is_walking = 1;
//                            } else {
//                                $insert_transaction->is_walking = 0;
//                            }
////                            $transaction_date = date('Y-m-d');
//                            $insert_transaction->transaction_date = $transaction_date;
//                            $insert_transaction->admin_id = 0;
//                            $insert_transaction->type = 2;
//                            $insert_transaction->branch_id = $team->branch_id;
//                            $insert_transaction->amount = $single_user_billing_balance;
//                            $insert_transaction->team_id = $user_dues->team_id;
//                            $insert_transaction->invoice_id = $user_dues->id;
//                            $insert_transaction->credit_transaction_id = $credit_transaction_id;
//                            $insert_transaction->note = "Auto generated transaction for billing dues";
//                            $insert_transaction->payment_type = $payment_type;
//                            $insert_transaction->wallet_type = $user_dues->wallet_type;
//                            $single_user_billing_balance -= $single_user_billing_balance;
//                            $insert_transaction->save();
//                            $this->AddToLog("Auto generated transaction for billing dues of team id $insert_transaction->team_id for invoice# $insert_transaction->invoice_id created successfully");
//
//                        }
//                    }
//                }
//            }
//        }
////        if (!empty($dues_billing)) {
////
////            echo "<pre>";
////            print_r($dues_billing);
////            echo "<br>";
////            echo "credit = " . $single_user_billing_credit;
////            echo "<br>";
////            echo "Debit = " . $single_user_billing_debit;
////            echo "<br>";
////            echo "Balance = " . $single_user_billing_balance;
////            return;
////        }else{
////            echo "no pending billing invoice";
////            return;
////        }
////
////        if (!empty($dues_room)) {
////
////            echo "<pre>";
////            print_r($dues_room);
////            echo "<br>";
////            echo "credit = " . $single_user_room_credit;
////            echo "<br>";
////            echo "Debit = " . $single_user_room_debit;
////            echo "<br>";
////            echo "Balance = " . $single_user_room_balance;
////            return;
////        }else{
////            echo "no pending room booking invoice";
////            return;
////        }
////
////        if (!empty($dues_printing)) {
////
////            echo "<pre>";
////            print_r($dues_printing);
////            echo "<br>";
////            echo "credit = " . $single_user_printing_credit;
////            echo "<br>";
////            echo "Debit = " . $single_user_printing_debit;
////            echo "<br>";
////            echo "Balance = " . $single_user_printing_balance;
////            return;
////        }else{
////            echo "no pending printing invoice";
////            return;
////        }
//
//
//        return view('admin.make_payment', compact('invoice_data_value'));
//
//    }


    public function deleteTeamAsset(Request $request, $team_id)
    {

        if (!empty($request)) {
            $team_asset = Assetdetail::where('asset_id', $request->asset_id)->where('team_id', $team_id)->first();

            $asset = Asset::find($team_asset->asset_id);
            $team = Team::where('id', '=', $team_id)->first();
            $rec_invoice = RecurringInvoice::where('team_id', $team_id)->orderBy('created_at', 'desc')->first();
            $rec_invoice_item_to_del = RecurringInvoiceItem::where('team_id', $team_id)->where('invoice_id', $rec_invoice->id)->where('is_active', 1)->where('item', $asset->name)->first();
//            return response()->json(['Error' => $rec_invoice_item_to_del],500);
            if (!empty($rec_invoice_item_to_del)) {
                $item_deleted = DB::delete(" delete from recurring_invoice_item where id = $rec_invoice_item_to_del->id");
                if (($item_deleted)) {

                    if (!empty($rec_invoice)) {
                        $asset_total_after_discount = 0;
                        $new_asset_discount_amount = 0;
                        $new_asset_tax_amount = 0;
                        if (isset($rec_invoice->discount) && $rec_invoice->discount > 0) {
                            $new_asset_discount_amount = ($rec_invoice->discount / 100) * $asset->price;
                            $new_asset_discount_amount *= $request->asset_quantity;

                            $rec_invoice->discount_amount -= $new_asset_discount_amount;

                            $asset_total_after_discount = ($asset->price * $request->asset_quantity) - $new_asset_discount_amount;
//                            $rec_invoice->total -= $asset_total_after_discount;

                            $asset_amount_total = $asset->price * $request->asset_quantity;

                            $rec_invoice->amount -= $asset_amount_total;
                        } else {
                            $asset_total_after_discount = ($asset->price * $request->asset_quantity);
                            $asset_amount_total = $asset->price * $request->asset_quantity;

                            $rec_invoice->amount -= $asset_amount_total;
                        }
                        if (isset($rec_invoice->tax) && $rec_invoice->tax > 0) {
                            $new_asset_tax_amount = ($rec_invoice->tax / 100) * $asset_total_after_discount;
//                            $new_asset_tax_amount *= $request->asset_quantity;

                            $rec_invoice->tax_amount -= $new_asset_tax_amount;
                            $total = $new_asset_tax_amount + $asset_total_after_discount;
                            $rec_invoice->total -= $total;

                        } else {
                            $total = $asset_total_after_discount;
                            $rec_invoice->total -= $total;
                        }

                        if ($rec_invoice->save()) {
                            $this->AddToLog("Recurring Invoice Updated");
                            $deleted = $team_asset->delete();
                            if ($deleted) {
                                $this->AddToLog("Asset Deleted Successfully");

                                return response()->json(['success' => 'Asset deleted Successfully']);


                            }
                        }
                    }

                }
            } else {
                $deleted = $team_asset->delete();
                if ($deleted) {
                    $this->AddToLog("Asset Deleted Successfully");

                    return response()->json(['success' => 'Asset deleted Successfully']);


                }
            }

        }
    }

    /*******************Admin Cash Register***********************/
    public function cash_register_view()
    {


        $current_date = date('Y-m-d');
        $get_str_date_start = strtotime($current_date) + (60 * 60 * 0);
        $get_str_date_end = strtotime($current_date) + (60 * 60 * 23.99);

        $start_time = date("Y-m-d H:i:s", $get_str_date_start); //get time in format 2018 07 12 12:00:00
        $end_time = date("Y-m-d H:i:s", $get_str_date_end); //get time in format 2018 07 12 12:00:00
        $end_time = date("Y-m-d H:i:s", $get_str_date_end); //get time in format 2018 07 12 12:00:00


        $today_cash = DB::select("SELECT b.id as branch_id,b.name as branch_name, a.name as admin_name ,tr.admin_id,a.type as admin_type,tr.is_transfer ,tr.payment_type,  SUM(tr.amount) as amount FROM transactions as tr INNER JOIN admins as a on tr.admin_id = a.id and tr.type = 1 and tr.payment_type != 2  and is_transfer = 0 INNER JOIN branches as b on tr.branch_id = b.id and date (tr.created_at) between '$start_time' and '$end_time' group by tr.admin_id,tr.branch_id,tr.payment_type,b.id,b.name,a.name,a.type,is_transfer");


        return view('admin.cash_register_view', compact('today_cash'));

    }

    public function cash_register_view_report(Request $request)
    {


        if (!empty($request->start_date && $request->end_date)) {

            $start_date = date('Y-m-d', strtotime($request->start_date));
            $end_date = date('Y-m-d', strtotime($request->end_date));
            $get_str_date_start = strtotime($start_date) + (60 * 60 * 0);
            $get_str_date_end = strtotime($end_date) + (60 * 60 * 23.99);

            $start_time = date("Y-m-d H:i:s", $get_str_date_start); //get time in format 2018 07 12 12:00:00
            $end_time = date("Y-m-d H:i:s", $get_str_date_end); //get time in format 2018 07 12 12:00


            $today_cash = DB::select("SELECT b.id as branch_id,b.name as branch_name, a.name as admin_name ,tr.admin_id,a.type as admin_type,tr.is_transfer ,tr.payment_type,  SUM(tr.amount) as amount FROM transactions as tr INNER JOIN admins as a on tr.admin_id = a.id and tr.type = 1 and tr.payment_type != 2  and is_transfer = 0 INNER JOIN branches as b on tr.branch_id = b.id and date (tr.created_at) between '$start_time' and '$end_time' group by tr.admin_id,tr.branch_id,tr.payment_type,b.id,b.name,a.name,a.type,is_transfer");
        }

        return view('admin.cash_register_view', compact('today_cash', 'start_time', 'end_time'));

    }

    public function cash_register_history()
    {
        $current_date = date('Y-m-d');
        $get_str_date_start = strtotime($current_date) - (60 * 60 * 24);
        $get_str_date_end = strtotime($current_date) - (60 * 60 * 0.01);

        $start_time = date("Y-m-d H:i:s", $get_str_date_start); //get time in format 2018 07 12 12:00:00
        $end_time = date("Y-m-d H:i:s", $get_str_date_end); //get time in format 2018 07 12 12:00:00


        $cash_history = DB::select("SELECT b.id as branch_id,b.name as branch_name, a.name as admin_name ,tr.admin_id,a.type as admin_type,tr.created_at, tr.is_transfer,tr.payment_type, SUM(tr.amount) as amount FROM transactions as tr INNER JOIN admins as a on tr.admin_id = a.id and tr.type = 1 and tr.payment_type != 2 and is_transfer = 1 INNER JOIN branches as b on tr.branch_id = b.id and date (tr.created_at) between '$start_time' and '$end_time' group by tr.admin_id,tr.branch_id,tr.payment_type,b.id,b.name,a.name,a.type,is_transfer,tr.created_at");
        return view('admin.cash_register_history', compact('cash_history'));

    }


    public function cash_register_history_report(Request $request)
    {

        if (!empty($request->start_date && $request->end_date)) {

            $start_date = date('Y-m-d', strtotime($request->start_date));
            $end_date = date('Y-m-d', strtotime($request->end_date));
            $get_str_date_start = strtotime($start_date) + (60 * 60 * 0);
            $get_str_date_end = strtotime($end_date) + (60 * 60 * 23.99);

            $start_time = date("Y-m-d H:i:s", $get_str_date_start); //get time in format 2018 07 12 12:00:00
            $end_time = date("Y-m-d H:i:s", $get_str_date_end); //get time in format 2018 07 12 12:00

            $cash_history = DB::select("SELECT b.id as branch_id,b.name as branch_name, a.name as admin_name ,tr.admin_id,a.type as admin_type,tr.created_at, tr.is_transfer,tr.payment_type, SUM(tr.amount) as amount FROM transactions as tr INNER JOIN admins as a on tr.admin_id = a.id and tr.type = 1 and tr.payment_type != 2 and is_transfer = 1 INNER JOIN branches as b on tr.branch_id = b.id and date (tr.transaction_date) between '$start_time' and '$end_time' group by tr.admin_id,tr.branch_id,tr.payment_type,b.id,b.name,a.name,a.type,is_transfer,tr.created_at");

        }

        return view('admin.cash_register_history', compact('cash_history'));

    }


    public function cash_register_settings()
    {
        $settings = Setting::where('for', 'cash_register')->get();
        return view('admin.cash_register_settings', compact('settings'));

    }

    public function edit_cash_limit($id)
    {
        $settings = Setting::find($id);
        return response()->json(['settings' => $settings]);
    }

    public function update_cash_limit(Request $request)
    {
        //return response()->json($request);
        $setting = Setting::where('setting_key', $request->setting_name)->first();
        $setting->setting_value = $request->cash_limit;

        $updated = $setting->save();
        $this->AddToLog("Cash Limit Updated Successfully");
        if ($updated) {
            return response()->json(['Success' => 'Successfully Updated']);
        }
        return response()->json(['fail' => ' not updated']);


    }

    public function payment_transfer(Request $request)
    {
        //return response()->json($request);
        $value = array();
        $value = explode("_", $request->admin_id_and_payment_type);

        $admin_id = $value[0];
        $payment_type = $value[1];


        if (isset($request->start_time) && $request->end_time) {
            $start_time = $request->start_time;
            $end_time = $request->end_time;
        } else {
            $current_date = date('Y-m-d');
            $get_str_date_start = strtotime($current_date) + (60 * 60 * 0);
            $get_str_date_end = strtotime($current_date) + (60 * 60 * 23.99);
            $start_time = date("Y-m-d H:i:s", $get_str_date_start); //get time in format 2018 07 12 12:00:00
            $end_time = date("Y-m-d H:i:s", $get_str_date_end); //get time in format 2018 07 12 12:00:00
        }


        $payment_transfer = DB::select("update transactions set is_transfer = 1 where admin_id = $admin_id and payment_type = $payment_type and date (created_at) between '$start_time' and '$end_time'");
        if ($payment_transfer) {
            $this->AddToLog("Payment Transfer Successfully");

        }
    }


    /*******************Auto Invoice Generation After Approval***********************/

    public function autoGenerateInvoice($team_id, $wallet, $description, $tax_invoice, $discount_invoice, $for, $invoice_id_recurr_ref, $month_cycles, $branch_id)
    {
        $price = 0;
        $quantity = 0;
        $amount = 0;
        $tax = $tax_invoice;
        $discount = $discount_invoice;
        $total = 0;
        $walletType = $wallet;
        $description = $description;

//        $maxDays=date('t');
//        $currentDayOfMonth=date('j');
//
//        if($maxDays == $currentDayOfMonth){
//            //Last day of month
//        }else{
//            //Not last day of the month
//        }
//
        $maxDays = date('t');
        $month_days = $maxDays;
        $invoice = new Invoice();

        $teamAssets = Assetdetail::where('team_id', '=', $team_id)->get();
        $team = Team::find($team_id);
        $user = User::where('id', '=', $team->leader_id)->first();

        if ($walletType == 1 && $for == 'Asset') {
            foreach ($teamAssets as $teamAsset) {
                $now = date('d');
                $bill_days = $month_days - $now;
                $per_day_price = $teamAsset->asset->price / $month_days;
                $total_price = $per_day_price * $bill_days;
                $amount = $amount + ($total_price * $teamAsset->quantity);

            }
            $invoice->branch_id = $branch_id;
            $invoice->bill_to_name = $user->name;
            $invoice->bill_to_address = $user->address;
            $invoice->amount = ceil($amount);
            $invoice->team_id = $team_id;
            $invoice->wallet_type = $walletType;
            $invoice->discount = ceil($discount);
            $invoice->description = $description;
            $invoice->tax = ceil($tax);

            $now = date('d-m-Y');;
            $invoice_date = date('d-m-Y', strtotime($now));
            $due_date = strtotime($invoice_date) + (60 * 60 * 24) * (5);

            $invoice_due_date = date("d-m-Y", $due_date);

            $invoice->invoice_date = $invoice_date;
            $invoice->invoice_due_date = $invoice_due_date;

        } elseif ($walletType == 1 && $for == 'recurrAsset') {
            $invoice = new RecurringInvoice();
            foreach ($teamAssets as $teamAsset) {
                $amount = $amount + (($teamAsset->asset->price) * ($teamAsset->quantity));
            }
            $invoice->branch_id = $branch_id;
            $invoice->bill_to_name = $user->name;
            $invoice->bill_to_address = $user->address;
            $invoice->amount = ceil($amount);
            $invoice->invoice_id = $invoice_id_recurr_ref;
            $invoice->month_cycles = $month_cycles;
            $invoice->team_id = $team_id;
            $invoice->wallet_type = $walletType;
            $invoice->discount = ceil($discount);
            $invoice->description = $description;
            $invoice->tax = ceil($tax);

            $now = date('d-m-Y');;
            $invoice_date = date('d-m-Y', strtotime($now));
            $due_date = strtotime($invoice_date) + (60 * 60 * 24) * (5);

            $invoice_due_date = date("d-m-Y", $due_date);

            $invoice->invoice_date = $invoice_date;
            $invoice->invoice_due_date = $invoice_due_date;

            if (!($discount == 0)) {
                $invoice->discount_amount = ceil(($discount / 100) * $amount);

                $amount = $amount - (($discount / 100) * $amount);
            } else {
                $invoice->discount_amount = 0;

            }
            if (!($tax == 0)) {
                $invoice->tax_amount = ($tax / 100) * $amount;

                $amount = $amount + (($tax / 100) * $amount);
            } else {
                $invoice->tax_amount = 0;

            }


            $total = ceil($amount);
            $invoice->total = $total;


            $invoice->save();
            return $invoice->id;
        } elseif ($walletType == 1 && $for == 'Deposit') {
            foreach ($teamAssets as $teamAsset) {
                $amount = $amount + (($teamAsset->asset->fixed_deposit) * ($teamAsset->quantity));
            }
            $invoice->branch_id = $branch_id;
            $invoice->bill_to_name = $user->name;
            $invoice->bill_to_address = $user->address;
            $invoice->amount = ceil($amount);
            $invoice->team_id = $team_id;
            $invoice->wallet_type = $walletType;
            $invoice->discount = $discount;
            $invoice->description = $description;
            $invoice->tax = ceil($tax);

            $now = date('d-m-Y');;
            $invoice_date = date('d-m-Y', strtotime($now));
            $due_date = strtotime($invoice_date) + (60 * 60 * 24) * (5);

            $invoice_due_date = date("d-m-Y", $due_date);

            $invoice->invoice_date = $invoice_date;
            $invoice->invoice_due_date = $invoice_due_date;

        }


        if (!($discount == 0)) {
            $invoice->discount_amount = ceil(($discount / 100) * $amount);

            $amount = $amount - (($discount / 100) * $amount);
        } else {
            $invoice->discount_amount = 0;

        }
        if (!($tax == 0)) {
            $invoice->tax_amount = ($tax / 100) * $amount;

            $amount = $amount + (($tax / 100) * $amount);
        } else {
            $invoice->tax_amount = 0;

        }


        $total = ceil($amount);
        $invoice->total = $total;

        $invoice->save();
        $this->AddToLog("Auto invoice generated for team $team->name and user $user->name and invoice# $invoice->id first time after approvel");

        return $invoice->id;
    }





    /********************************************************************************/

    /*************User Delete****************/
    public function userDelete($user_id)
    {
        $user = User::find($user_id);
        $user->is_active = 0;
        if ($user->save()) {
            $this->AddToLog("User Deleted");
            if ($user->type == 1) {
                $team = Team::where('leader_id', $user_id)->first();
                $team->is_active = 0;
                $team->save();
                $this->AddToLog("Team Deleted");

                $rec_invoice = RecurringInvoice::where('is_active', 1)->where('team_id', $team->id)->orderby('id', 'desc')->first();
                if (!empty($rec_invoice)) {
                    $rec_invoice->is_active = 0;
                    $rec_invoice->show_expired_section = 0;
                    $rec_invoice->save();
                    $this->AddToLog("Recurring Invoice Deleted");

                }
                $team_users = User::where('team_id', $team->id)->get();
                if (!empty($team_users)) {
                    foreach ($team_users as $team_user) {
                        $team_user->is_active = 0;
                        $team_user->save();
                        $this->AddToLog("Team User Deleted");

                    }
                }

            }
        }
        return response()->json(['success' => 'successfully Deleted user']);
    }


    public function userContractApprove($user_id)
    {
        $user = User::find($user_id);
        $user->contract = 1;
        if ($user->save()) {
            $this->AddToLog("User Contract");
            if ($user->type == 1) {

                $this->AddToLog("Contract Approved for user".$user->name. 'successfully');

            }
        }
        return response()->json(['success' => 'Contract Approved for user '.$user->name. ' successfully']);
    }

    /********************Admin Crud*********************/
    public function indexAdmin()
    {
        $admins = Admin::all();
        return view('admin.admins', compact('admins'));
    }

    public function viewAdmin($id)
    {
        $admin = Admin::where('id', $id)->first();
        return view('admin.adminPrivateProfile', compact('admin'));
    }


    public function insertAdmin(Request $request)
    {
        $lower = strtolower($request->name);
        $string = str_replace(" ", "_", $lower);
        if ($request->avatar_url != "") {
            $final_image = $string . $request->avatar_url;
        } else {
            $final_image = "";
        }

//        dd($final_image);
        $admin = new Admin;
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->password = Hash::make($request->password);
        $admin->branch_id = $request->branch;
        $admin->type = $request->type;
        $admin->contact_number = $request->contact_number;
        $admin->address = $request->admin_address;
        $admin->cnic = $request->admin_cnic;
        $admin->dob_day = $request->admin_dob_day;
        $admin->dob_month = $request->admin_dob_month;
        $admin->dob_year = $request->admin_dob_year;
        $admin->user_id = 0;
        $admin->avatar_url = $final_image;
        $find_user_by_email = User::where('email', '=', $request->email)->get();
        if (count($find_user_by_email) == 0) {
            if ($request->name == '') {
                $msg = "Enter Name";
                return response()->json(['msg' => $msg, 'data' => $find_user_by_email], 500);
            }
            if ($request->email == '') {
                $msg = "Enter Email";
                return response()->json(['msg' => $msg, 'data' => $find_user_by_email], 500);
            }
            if ($request->password == '') {
                $msg = "Enter Your Password";
                return response()->json(['msg' => $msg, 'data' => $find_user_by_email], 500);
            }
            if ($request->branch == 0) {
                $msg = "Select Branch";
                return response()->json(['msg' => $msg, 'data' => $find_user_by_email], 500);
            }
            if ($request->contact_number == '') {
                $msg = "Enter Contact Number";
                return response()->json(['msg' => $msg, 'data' => $find_user_by_email], 500);
            }

            if ($request->admin_address == '') {
                $msg = "Enter address";
                return response()->json(['msg' => $msg, 'data' => $request->admin_address], 500);
            }
            if ($request->admin_cnic == '') {
                $msg = "Enter cnic";
                return response()->json(['msg' => $msg, 'data' => $find_user_by_email], 500);
            }

            if ($request->admin_dob_day == '') {
                $msg = "Enter DOB Day";
                return response()->json(['msg' => $msg, 'data' => $find_user_by_email], 500);
            }
            if ($request->admin_dob_month == '') {
                $msg = "Enter DOB Month";
                return response()->json(['msg' => $msg, 'data' => $find_user_by_email], 500);
            }
            if ($request->admin_dob_year == '') {
                $msg = "Enter DOB Year";
                return response()->json(['msg' => $msg, 'data' => $find_user_by_email], 500);
            }
            if ($request->type == '') {
                $msg = "Enter  Type";
                return response()->json(['msg' => $msg, 'data' => $request->type], 500);
            }

            $saved = $admin->save();


            if ($saved) {
                $this->AddToLog("Admin/Receptionist $admin->name and admin# $admin->id of branch# $admin->branch_id added successfully");
                $user = new User;
                $user->name = $request->name;
                $user->email = $request->email;
                $user->address = "";
                $user->contact_number = 0;
                $user->password = Hash::make($request->password);
                $user->avatar_url = $final_image;
                $user->type = 3;
                $user->package_type = 0;
                $user->branch_id = $request->branch;
                $user->is_active = 1;
                $user->status = 1;
                $user->cnic = 0;
                $user->contract = 0;
                $user->dob_month = 0;
                $user->dob_day = 0;
                $user->dob_year = 0;
                $user->city = '';
                $age = date('Y') - $user->dob_year;

                $user->age = $age;
                $user->remember_token = '';
                $user_saved = $user->save();


                if ($user_saved) {
                    $edit_admin = Admin::find($admin->id);
                    $edit_admin->user_id = $user->id;
                    $saved_edit_admin = $edit_admin->save();
                    if ($saved_edit_admin) {
                        return response()->json(['success' => 'successfully added admin']);
                    }

                }
            }
        } else {
            $msg = "Duplicate Email";
            return response()->json(['msg' => $msg, 'data' => $find_user_by_email], 500);
        }
    }


    public function save_notes(Request $request)
    {
        $admin = Admin::find($request->admin_id);
//        dd($request);
        $admin->notes = $request->notes;
        $added = $admin->save();
        if ($added) {
            $this->AddToLog("Notes Saved Successfully for Admin $admin->name with admin# $admin->id of branch# $admin->branch_id ");

            Session::flash('message', 'Notes Saved Successfully!');
            Session::flash('alert-class', 'alert-success');

        }
        return view('admin.adminPrivateProfile', compact('admin'));
    }

    public function save_notes_user(Request $request)
    {
        $user = User::find($request->user_id);
//        dd($request);
        $user->notes = $request->notes;
        $added = $user->save();
        if ($added) {
            $this->AddToLog("Notes Saved Successfully for user $user->name with user# $user->id of branch# $user->branch_id ");

            Session::flash('message', 'Notes Saved Successfully!');
            Session::flash('alert-class', 'alert-success');

        }
        return view('admin.userPrivateProfile', compact('user'));
    }

    public function moveAnouncementImage($name)
    {
        if (isset($_FILES['file'])) {

            if ($_FILES['file']['error'] == 4) {
                return response()->json(['msg' => "File missing"], 500);

            } elseif ($_FILES['file']['error'] == 1) {
                return response()->json(['msg' => "File is too large"], 500);

            }
            $image = getimagesize($_FILES['file']['tmp_name']);

            if (!$image) {

                return response()->json(['msg' => "Not a valid image"], 500);

            }

            if ($_FILES['file']['size'] > 5000000) {

                return response()->json(['msg' => "max allowed file size Exceeded"], 500);

            }

            $valid_types = array("image/jpeg", "image/png");

            if (!in_array($_FILES['file']['type'], $valid_types)) {

                return response()->json(['msg' => "Only jpeg/png allowed"], 500);

            }

            if ($_FILES['file']['type'] != $image['mime']) {
                return response()->json(['msg' => "Corrupt image"], 500);
            }
            $checkimage = str_replace(' ', '_', $_FILES['file']['name']);
            $make_final = $name . strtolower($checkimage);
//            dd(base_path('public/images/profile_pic'));
            try{
                if (move_uploaded_file($_FILES['file']['tmp_name'], base_path('public/images/announcements/') . $make_final)) {
                    echo("image_" . $_FILES['file']['name']);

                    return;

                } else {
                    return response()->json(['msg' => "failed to upload file"], 500);

                }

            }
            catch(\Exception $exception){
//                $user = Auth::user();
//                $this->AddToLog("Announcement upload image failed: $user->name with admin# $user->id of branch# $user->branch_id");
                return response()->json(['msg' => "failed to upload file"], 500);

            }

        }
    }


    public function moveAdminImage($name)
    {
        if (isset($_FILES['file'])) {

            if ($_FILES['file']['error'] == 4) {
                echo("File missing");
                return;
            }

            $image = getimagesize($_FILES['file']['tmp_name']);

            if (!$image) {
                echo("Not a valid image");
                return;
            }

            if ($_FILES['file']['size'] > 5000000) {
                echo("max allowed file size is 500 MB");
                return;
            }

            $valid_types = array("image/jpeg", "image/png");

            if (!in_array($_FILES['file']['type'], $valid_types)) {
                echo("Only jpeg/png allowed");
                return;
            }

            if ($_FILES['file']['type'] != $image['mime']) {
                echo("Corrupt image");
                return;
            }
            $make_final = $name . $_FILES['file']['name'];
//            dd(base_path('public/images/profile_pic'));
            if (move_uploaded_file($_FILES['file']['tmp_name'], base_path('public/images/profile_pic/') . $make_final)) {
                echo("image_" . $_FILES['file']['name']);

                return;

            } else {
                echo("failed to upload file");
                return;
            }
        }else{
            echo("File not found");
            return;
        }
    }

    public function delete_admin(Request $request)
    {

        $admin = Admin::find($request->id);
        if (isset($admin) && !empty ($admin)) {
            $user_delete = DB::select("delete from users where id  = $admin->user_id");
            $admin_delete = DB::select("delete from admins where id = $request->id");
            $this->AddToLog("admin $admin->name of branch# $admin->branch_id deleted successfully");
            return response()->json(['msg' => "Admin/Receptionist Deleted Successfully"]);
        }
        return response()->json(['msg' => "Admin not deleted"]);

    }

    public function editAdmin($id)
    {
        $admin = Admin::find($id);
        $branches = Branch::all();
        return response()->json(['admin' => $admin, 'branches' => $branches]);
    }

    public function updateAdminEdit(Request $request, $id)
    {
        //return response()->json($request);
        $admin = Admin::find($id);

        $admin->name = $request->name;
        $admin->email = $request->email;
        if (isset($request->type) && !empty($request->type)) {
            $admin->type = $request->type;
        }
        $admin->branch_id = $request->branch;

        if (!empty($request->password)) {
            $admin->password = Hash::make($request->password);
        } else {
            $admin->password = $admin->password;
        }
        $updated = $admin->save();
        if ($updated) {
            $this->AddToLog("Admin  $admin->name with admin# $admin->id of branch# $admin->branch_id updated successfully");

            return response()->json(['Success' => 'Successfully Updated']);
        }
        return response()->json(['fail' => ' not updated']);


    }

    public function approvalStatusChange($admin_id)
    {
        $admin = Admin::find($admin_id);

        if ($admin->status == 0) {
            $admin->status = 1;
        } else {
            $admin->status = 0;
        }
        $admin->save();
        $this->AddToLog("Admin status of  $admin->name with admin# $admin->id of branch# $admin->branch_id updated successfully");

        $admin_user_id = Admin::where('id', $admin_id)->first();
        $admin_user = User::find($admin_user_id->user_id);
//dd($admin_user_id->user_id);
//        if ($admin_user->status == 0) {
//            $admin_user->status = 1;
//        } else {
        $admin_user->status = $admin->status;
//        }
        $admin_user->save();


        return response()->json(['Success' => 'Successfully Updated']);


    }

    /***********************Branch Actions**************************/

    public function branchIndex()
    {
        $branches = Branch::where('is_active', 1)->get();
        return view('admin.branch', compact('branches'));
    }

    public function branchView($branch_id)
    {


        $approved = User::where('status', '=', 1)->where('branch_id', $branch_id)->count();
        $active_users = User::where('status', '=', 1)->where('branch_id', $branch_id)->get();
        $unapproved = User::where('status', '=', 0)->where('branch_id', $branch_id)->count();
        $all_users = User::where('branch_id', $branch_id)->get();
        $assets = Asset::where('branch_id', '=', $branch_id)->count();
        $teams = Team::where('branch_id', '=', $branch_id)->count();
        $all_teams = Team::where('branch_id', '=', $branch_id)->get();
        $date = time();
        $current_date = date('Y-m-d', $date);
        $bookings = Booking::where('booking_date', $current_date)->where('branch_id', $branch_id)->get();


        return view('admin.branchView', compact('approved', 'unapproved', 'all_users', 'active_users', 'teams', 'assets', 'all_teams', 'branches', 'all_branches', 'bookings'));

    }


    public function branchInsert(Request $request)
    {
        $branch = new Branch();
        $branch->name = $request->name;
        $branch->address = $request->address;
        $branch->save();
        $this->AddToLog("Branch $branch->name with id $branch->id Added successfully");

        return response()->json(['Success' => 'Successfully Added']);
    }

    public function getBranch()
    {
        $branches = Branch::all();
        return response()->json($branches);
    }

    public function getBranchAndBookingForChart()
    {
        $branches = Branch::all();
        $booking_date = date('Y-m-d');
        $book_from = date('H:i:s');
        $book_to = date('24:00:00');
//        $start_time = date('Y-m-d', $start);
//        $end_time = date('Y-m-d', $end);


        $bookings = DB::select("select count(*) as value, br.name as name from branches br inner join bookings b on br.id = b.branch_id   where  date(booking_date) between '$booking_date' and '$booking_date' and book_from between '$book_from' and '$book_to' group by br.id,br.name ");
        return response()->json($bookings);
    }

    public function editBranch($id)
    {
        $branch_data = Branch::find($id);
        return response()->json(['branch' => $branch_data]);
    }

    public function updateBranchEdit(Request $request, $id)
    {
        $branch_data = Branch::find($id);

        $branch_data->name = $request->name;
        $branch_data->address = $request->address;


        $updated = $branch_data->save();
        if ($updated) {
            $this->AddToLog("Branch $branch_data->name updated successfully");

            return response()->json(['Success' => 'Successfully Updated']);
        }
        return response()->json(['fail' => ' not updated']);


    }


    public function delete_Branch(Request $request)
    {

        $branch = Branch::find($request->id);
        $branch->is_active = 0;
        if ($branch->save()) {
            $this->AddToLog("Branch $branch_data->name Deleted successfully");

            return response()->json(['msg' => "Branch Deleted Successfully"]);

        }

        return response()->json(['msg' => "Admin not deleted"]);

    }


    public function getBranchRole()
    {
        if (Auth::user()->type == 1) {
            $branches = Branch::all();
        } elseif (Auth::user()->type == 2 || Auth::user()->type == 4) {
            $branches = Branch::where('id', '=', Auth::user()->branch_id)->get();
        }

        return response()->json($branches);
    }

    public function getBranchNomad()
    {
        $assets = Asset::all();
        $branchNomad = array();
        foreach ($assets as $asset) {
            if ($asset->is_nomad == 1) {
                $branchNomad[] = $asset->branch_id;
            }
        }
        $notNomadItemAssigned = array();
        $allBranches = DB::select("select id from branches");
        $comp = array();
        foreach ($allBranches as $branch) {
            $comp[] = $branch->id;

        }
        $array1 = $comp;
        $array2 = $branchNomad;
        $notNomadItemAssigned = array_diff($array1, $array2);

        $branches = Branch::select('id', 'name', 'address')->whereIn('id', $notNomadItemAssigned)->get();

        $array = array();
        foreach ($branches as $branch) {

            $array[] = $branch;

        }

        if (isset($array) && empty($array) && count($array) == 0) {
            return response()->json('empty', 200);
        } else {
            return response()->json($branches);

        }


    }

    /********************Chat Systems***************************/

    public function send(Request $request)
    {
        return $request->all();
        $user = Admin::find(Auth::id());
        event(new ChatEvents($request->message, $user));
    }


    /******************Admin Side Booking**********************/
    public function checkBookingTimeAndPrice(Request $request)
    {

//return response()->json(['msg'=>'sdasd'],300);
        $date = date('Y-m-d', strtotime($request->date));
        $asset = $request->asset;
        $assetDetail = Asset::find($asset);
        $bookings = Booking::where('booking_date', $date)->where('asset_id', $asset)->get();
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
                    while ($timeFrom[$kk] != $booking->book_to) {

                        $timeFrom[$kk] = 'Not Free';
                        if ($kk < $totalcount) {
                            $kk++;
                        } else {
                            break;
                        }

                    }

                    break;
                }
//                if ($k < $totalcount){
//                    $k++;
//                }else{
//                    break;
//                }
            }
//            }

//            foreach ($timeFrom as $key=>$time_f) {
//                if ($time_f == $booking->book_from) {
////
//                    $k = $key;
//                    while ($timeFrom[$k] != $booking->book_to) {
////                    if($timeFrom[$key] != $booking->book_to) {
//                        $timeFrom[$k] = 'Not Free';
//                        $k++;
//                    }
//                    break;
//
//
////                        $k++;
////                    }
//                }
//
//            }


//            while (true) {
//                if ($timeFrom[$k] == $booking->book_from) {
//                    while ($timeFrom[$k] != $booking->book_to) {
//
//                        $timeFrom[$k] = 'Not Free';
//                        $k++;
//                    }
//
//                    break;
//                }
//                $k++;
//            }
        }
        return response()->json(['timeFrom' => $timeFrom, 'asset' => $assetDetail]);
    }

    public function timeTo(Request $request)
    {

        $timeFrom_value = $request->timeFrom;
        $date = date('Y-m-d', strtotime($request->date));
        $asset = $request->asset;

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
//                    while ($timeFrom[$k] != $booking->book_to) {
                    if ($timeFrom[$k] != $booking->book_to) {
//
//                        $timeFrom[$k] = 'Not Free';
//                        $k++;
                    }
                    $timeFrom[$key] = 'Not Free';
//                        $k++;
//                    }
                }

            }


//            while (true) {
//                if ($timeFrom[$k] == $booking->book_from) {
//                    while ($timeFrom[$k] != $booking->book_to) {
//
//                        $timeFrom[$k] = 'Not Free';
//                        $k++;
//                    }
//
//                    break;
//                }
//                $k++;
//            }
        }

        $timeTo = array();
        $i = 0;
        $j = 0;
        $l = 0;
        $l = array_search($timeFrom_value, $timeFrom);
        $stop = sizeof($timeFrom);
//        print_r($timeFrom_value);
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


        return response()->json($timeTo);


    }

    public function getBranchAssetsAndTeam($id)
    {
        $assets = Asset::where('bookable', 1)->where('branch_id', $id)->get();
//        $teams = Team::where('branch_id', $id)->where('is_walking', 0)->get();
        $teams = Team::where('branch_id', $id)->where('is_active', 1)->get();
        return response()->json(['assets' => $assets, 'teams' => $teams]);
    }

    public function getBranchAllAssetsAndTeam($id)
    {

        $assets = Asset::where('bookable', 1)->get();
        foreach ($assets as $key => $asset) {
            $branch = Branch::where('id', $asset->branch_id)->first();
            $assets[$key]->asset_with_branch = $asset->name .
                " - " . $branch->name;
        }
//        $teams = Team::where('branch_id', $id)->where('is_walking', 0)->get();
        $teams = Team::where('branch_id', $id)->where('is_active', 1)->get();
        return response()->json(['assets' => $assets, 'teams' => $teams]);
    }


    public function addBookingAdmin(Request $request)
    {
        $booking = new Booking;
        $booking->asset_id = $request->asset;
        $booking->book_from = $request->from;
        $booking->book_to = $request->to;
        $booking->status = 0;
        $booking->team_id = $request->team;
        $booking->branch_id = $request->branch;
        $booking->booking_date = date('Y-m-d', strtotime($request->date));
        $added = $booking->save();

        if ($added) {
            return response()->json(['Success' => 'Successfully Added']);
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

    public function settings()
    {
//        $notice = Setting::where('for', 'notice')->first();
//        $print = Setting::where('for', 'printing')->first();
        $settings = Setting::where('for', '!=', 'cash_register')->get();

        return view('admin.adminsettings', compact('settings'));
    }

    public function setting_show_value($id)
    {
        $setting = Setting::find($id);
        return response()->json($setting);
    }

    public function setting_update(Request $request)
    {
        $setting = Setting::find($request->id);
        $setting->setting_value = $request->setting_value;
        $setting->save();
        return response()->json(['Success' => 'Setting Updated successfully']);
    }

    public function contract_view($id)
    {
        $user = User::where('id', $id)->first();
        return view('contract_view', compact('user'));
    }

}
