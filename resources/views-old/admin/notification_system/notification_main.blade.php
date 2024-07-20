@extends('layouts.admin.master')

@section('content')
    <!-- Main content -->
    <div class="content-wrapper">

        <!-- Page header -->
        <div class="page-header page-header-light">
            <div class="page-header-content header-elements-md-inline">
                <div class="page-title d-flex">
                    <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Response Check</span> - Main</h4>
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
{{--                        <span class="breadcrumb-item active">Support</span>--}}
{{--                    </div>--}}

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

        <div class="content">
            @if (\Session::has('error'))

                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-danger alert-styled-left alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                            <span class="font-weight-semibold">Oh snap!</span> {!! \Session::get('error') !!}
                        </div>

                    </div>
                </div>
        @endif
            <!-- Support tickets -->
            <div class="card">
                <div class="card-header header-elements-sm-inline">
                    <h6 class="card-title text-center">All Notifications</h6>
                    {{--<div class="header-elements">--}}
                    {{--<a class="text-default daterange-ranges font-weight-semibold cursor-pointer dropdown-toggle">--}}
                    {{--<i class="icon-calendar3 mr-2"></i>--}}
                    {{--<span></span>--}}
                    {{--</a>--}}
                    {{--</div>--}}
                </div>

                <div class="card-body d-md-flex align-items-md-center justify-content-md-between flex-md-wrap">
                    {{--<div class="d-flex align-items-center mb-3 mb-md-0">--}}
                    {{--<div id="tickets-status"></div>--}}
                    {{--<div class="ml-3">--}}
                    {{--<h5 class="font-weight-semibold mb-0">14,327 <span class="text-success font-size-sm font-weight-normal"><i class="icon-arrow-up12"></i> (+2.9%)</span></h5>--}}
                    {{--<span class="badge badge-mark border-success mr-1"></span> <span class="text-muted">Jun 16, 10:00 am</span>--}}
                    {{--</div>--}}
                    {{--</div>--}}

                    <div class="d-flex align-items-center mb-3 mb-md-0">
                        <a href="#" class="btn bg-transparent border-indigo-400 text-indigo-400 rounded-round border-2 btn-icon">
                            <i class="icon-alarm-add"></i>
                        </a>
                        <div class="ml-3" >
                            <h5 class="font-weight-semibold mb-0">

                                {{count($data['notifications'])}}
                            </h5>
                            <span class="text-muted">total notifications</span>
                        </div>
                    </div>

                </div>

                <div class="table-responsive">
                    <table class="table mb-5 table datatable-basic">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Title</th>
                            <th>Description</th>
                            {{--<th>Description</th>--}}

                            <th  style="width: 20px;"><i class="icon-arrow-down12"></i></th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(isset($data['notifications']))
                        @foreach($data['notifications'] as $notification)
                            <tr>
                                <td>
                                    {{ $notification->id }}
                                </td>
                                <td>
                                    {{date('d-m-Y',strtotime($notification->created_at))}}
                                </td>
                                <td>
                                    {{ $notification->title }}
                                 </td>
                                <td>
                                   <textarea rows="2" cols="30" class="form-control ">{{ $notification->description }}</textarea>
                                </td>

                                <td>
                                    <div class="list-icons">
                                        <div class="list-icons-item dropdown">
                                            <a href="#" class="list-icons-item dropdown-toggle caret-0" data-toggle="dropdown"><i class="icon-menu7"></i></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a href="{{url('admin/notification-user-list/'.$notification->id )}}" class="dropdown-item"><i class="icon-undo"></i> Notification Users List</a>
                                                <!--  <a href="#" class="dropdown-item"><i class="icon-history"></i> Full history</a> -->
                                                <div class="dropdown-divider"></div>

                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /support tickets -->

        </div>
    </div>

     <!-- /main content -->

@endsection
