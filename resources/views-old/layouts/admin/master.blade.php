<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
{{--<script>--}}
{{--window.auth = {!!auth()->user()!!}--}}
{{--</script>--}}
<!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Voxly Tuition') }}</title>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet"
          type="text/css">
    <!-- /global stylesheets -->


    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet"
          type="text/css">
    <link href="{{ asset('theme_assets/css/icons/icomoon/styles.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('template_assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('template_assets/css/bootstrap_limitless.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('template_assets/css/layout.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('template_assets/css/components.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('template_assets/css/colors.min.css')}}" rel="stylesheet" type="text/css">
    {{--<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>--}}
    {{--<script src="//js.pusher.com/3.1/pusher.min.js"></script>--}}
    {{--<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>--}}
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}">

    <style>
        .loading-bar {
            display: none;
            position: fixed;
            z-index: 1;

            top: 50%;
            left: 50%;

            width: 100%;
            height: 100%;

            transform: translate(-50%, -50%);

            background-image: url("{{asset('cube_loader.gif')}}");

            background-position: center;
            background-color: rgba(255, 255, 255, 0.8);

            background-repeat: no-repeat;

        }
        @font-face {
            font-family: 'proxima-nova';
            font-style: normal;
            font-weight: 900;
            src: url('{{ asset('/fonts/Proxima-Nova/ProximaNova-Light_0.ttf') }}');
        }

    </style>
    <!-- /global stylesheets -->

</head>

<body class="sidebar-secondary-hidden">






<!-- Main navbar -->
<div class="navbar navbar-expand-md navbar-dark custom-dk-bg-color navbar-static" style="padding-left: 0px;" id="nav">


    <div class="navbar-brand" style="padding: 0 !important;">
        <a href="{{route('admin.home')}}" class="d-inline-block">
            {{--            <img src="{{asset('images/logo_white.png')}}"  style="width: 269px;height: 48px;" alt="">--}}
            <img src="{{asset('images/logo_white.jpeg')}}"  style="width: 269px;height: 48px;" alt="">
        </a>
    </div>

    <div class="d-md-none">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-mobile">
            <i class="icon-tree5"></i>
        </button>
        <button class="navbar-toggler sidebar-mobile-main-toggle" type="button">
            <i class="icon-paragraph-justify3"></i>
        </button>
        {{--<button class="navbar-toggler sidebar-mobile-secondary-toggle" type="button">--}}
            {{--<i class="icon-more"></i>--}}
        {{--</button>--}}
    </div>



    <div class="collapse navbar-collapse" id="navbar-mobile">

        <ul class="navbar-nav">
            <li class="nav-item">
                <a href="#" class="navbar-nav-link sidebar-control sidebar-main-toggle d-none d-md-block">
                    <i class="icon-paragraph-justify3"></i>
                </a>
            </li>

            &nbsp;

            <li class="nav-item">
                <span style="margin-top: 13%;" class=" text-center d-md-block">
                  Hey,
                    {{auth()->user()->name}}!
                </span>
            </li>
        </ul>


        <ul class="navbar-nav ml-auto" style="margin-right: 1%;">
            {{--<li class="nav-item">--}}
            {{--<a href="#"--}}
            {{--class="navbar-nav-link sidebar-control sidebar-secondary-toggle d-none d-md-block btn-user-group-menu">--}}
            {{--<i class="icon-bubbles3"></i>--}}
            {{--<span id="unreadload"></span>--}}
            {{--</a>--}}
            {{--</li>--}}





            <li class="nav-item dropdown" id="">
                <form id="logoutForm" class="hidden" action="{{route('admin.logout')}}" method="post">
                    @csrf
                    <a href="#" onclick="document.getElementById('logoutForm').submit();"
                       class="navbar-nav-link  d-md-block btn-user-group-menu"><i
                                class="icon-switch2"></i> </a>
                </form>
            </li>


        </ul>
    </div>
</div>
<!-- /main navbar -->












<!-- Page content -->
<div class="page-content" id="app">


    <div class="sidebar sidebar-light sidebar-main sidebar-expand-md">

        <!-- Sidebar mobile toggler -->
        <div class="sidebar-mobile-toggler text-center">
            <a href="#" class="sidebar-mobile-main-toggle">
                <i class="icon-arrow-left8"></i>
            </a>
            <span class="font-weight-semibold">Navigation</span>
            <a href="#" class="sidebar-mobile-expand">
                <i class="icon-screen-full"></i>
                <i class="icon-screen-normal"></i>
            </a>
        </div>
        <!-- /sidebar mobile toggler -->


        <!-- Sidebar content -->


        <div class="sidebar-content">
            <!-- User menu -->
            <div class="sidebar-user-material">

                <div class="sidebar-user-material-body" style="background: url({{asset('theme_assets/images/backgrounds/user_bg3.jpg')}})
                        center center no-repeat;
                        background-size: cover;"  >
                    <div class="card-body text-center">
                        <a href="{{url('admin/profile/settings'.'/')}}">
                            @if( !empty(Auth::user()->avatar_url) && !(Auth::user()->avatar_url == '#'))
                                <img src="{{ asset('images/profile_pic/'.Auth::user()->avatar_url) }}" class=" rounded-circle shadow-1 mb-3"
                                     width="100" height="100" alt="">
                            @else
                                <img src="{{asset('theme_assets/images/placeholders/placeholder.jpg')}}"
                                     class="img-fluid rounded-circle shadow-1 mb-3" width="80" height="80" alt="">
                            @endif
                        </a>
                        <h6 class="mb-0 text-white text-shadow-dark">{{Auth::user()->name}}</h6>
                    </div>

                    <div class="sidebar-user-material-footer">
                        <a href="#user-nav" class="d-flex justify-content-between align-items-center text-shadow-dark dropdown-toggle" data-toggle="collapse"><span>My account</span></a>
                    </div>
                </div>

                <div class="collapse" id="user-nav">
                    <ul class="nav nav-sidebar">
                        <li class="nav-item">
                            <a href="{{url('admin/profile/settings')}}" class="nav-link">
                                <i class="icon-user-plus"></i>
                                <span>My profile</span>
                            </a>
                        </li>

                        <form id="logoutForm2" class="" action="{{route('admin.logout')}}" method="post">
                            @csrf
                        </form>


                        <li class="nav-item">
                            <a href="#" onclick="document.getElementById('logoutForm2').submit();" class="nav-link">
                                <i class="icon-switch2"></i>
                                <span>Logout</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- /user menu -->




            <!-- Main navigation -->
            <div class="card card-sidebar-mobile">
                <ul class="nav nav-sidebar" data-nav-type="accordion">

                    <!-- Main -->
                    <li class="nav-item-header">
                        <div class="text-uppercase font-size-xs line-height-xs">Main</div>
                        <i class="icon-menu" title="Main"></i></li>
                    <li class="nav-item">
                        <a href="{{url('admin/home')}}" class="nav-link">
                            <i class="icon-home4"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    @if(isset(Auth::user()->type) && !(Auth::user()->type==4))

                        <li class="nav-item-header">
                            <div class="text-uppercase font-size-xs line-height-xs">ADMISSION</div>
                            <i class="icon-menu" title="Main"></i></li>

                        <li class="nav-item nav-item-submenu">


                            <a href="#" class="nav-link"><i class="icon-cash3 "></i> <span>ADMISSION</span></a>
                            <ul class="nav nav-group-sub" data-submenu-title="Finance">
                                <li class="nav-item">
                                    <a href="{{url('admin/admission')}}" class="nav-link">
                                        <i class="icon-task"></i>
                                        <span>Admission</span>
                                    </a>
                                </li>

                                <li class="nav-item">

                                    <a href="{{url('/admin/subject')}}" class="nav-link">

                                        <i class="icon-books"></i>
                                        <span>Subjects</span>
                                    </a>
                                </li>
                                <li class="nav-item">

                                    <a href="{{url('/admin/group')}}" class="nav-link">

                                        <i class="icon-notebook"></i>
                                        <span>Classes/Groups</span>
                                    </a>
                                </li>
                            </ul>


                        </li>







                    @endif

                    <li class="nav-item">
                        <a href="{{url('admin/student')}}" class="nav-link">
                            <i class="icon-task"></i>
                            <span>Students</span>
                        </a>
                    </li>

                    <li class="nav-item-header">
                        <div class="text-uppercase font-size-xs line-height-xs">TEACHER</div>
                        <i class="icon-menu" title="Main"></i></li>
                    <li class="nav-item">
                        <a href="{{url('admin/staff')}}" class="nav-link">
                            <i class="icon-users2"></i>
                            <span>Staff Members</span>
                        </a>
                    </li>


                    <li class="nav-item-header">
                        <div class="text-uppercase font-size-xs line-height-xs">HUMEN RESOURCE</div>
                        <i class="icon-menu" title="Main"></i></li>
                    <li class="nav-item nav-item-submenu">


                        <a href="#" class="nav-link"><i class="icon-cash3 "></i> <span>Attendance</span></a>
                        <ul class="nav nav-group-sub" data-submenu-title="Finance">
                            <li class="nav-item">

                                <a href="{{url('/admin/student-attendance')}}" class="nav-link">

                                    <i class="icon-calendar52"></i>
                                    <span>Student Attendance</span>
                                </a>
                            </li>

                            <li class="nav-item">

                                <a href="{{url('/admin/teacher-attendance')}}" class="nav-link">

                                    <i class="icon-calendar52"></i>
                                    <span>Teacher Attendance</span>
                                </a>
                            </li>

                        </ul>


                    </li>
                    <li class="nav-item nav-item-submenu">


                        <a href="#" class="nav-link"><i class="icon-cash4 "></i> <span>Staff Salary</span></a>
                        <ul class="nav nav-group-sub" data-submenu-title="Finance">
                            <li class="nav-item"><a href="{{url('admin/teacher-salary-due')}}" class="nav-link "><i
                                            class="icon-drawer"></i>Salary Outstanding</a></li>
                            <li class="nav-item"><a href="{{url('admin/teacher-salary-paid')}}" class="nav-link"><i
                                            class="icon-coins"></i>Salary Paid</a></li>
                            <li class="nav-item"><a href="{{url('admin/teacher-salary-expected')}}" class="nav-link"><i
                                            class="icon-coins"></i>Expected Salary By Attendance</a></li>
                            {{--@if(isset(Auth::user()->type) &&  (Auth::user()->type==1))--}}
                            {{--<li class="nav-item"><a href="{{url('admin/reporting')}}" class="nav-link"><i--}}
                            {{--class="icon-bars-alt"></i>Finance reporting</a></li>--}}
                            {{--@endif--}}
                            {{--<li class="nav-item nav-item-submenu">--}}
                            {{--<a href="#" class="nav-link"><i class="icon-loop"></i>--}}
                            {{--<span>Recurring Invoices</span></a>--}}
                            {{--<ul class="nav nav-group-sub" data-submenu-title="Finance">--}}
                            {{--<li class="nav-item"><a href="{{url('admin/recurringInvoices')}}" class="nav-link "><i--}}
                            {{--class="icon-checkmark-circle"></i>Active Recurring Invoices</a></li>--}}
                            {{--<li class="nav-item"><a href="{{url('admin/recurringInvoices/expired')}}" class="nav-link "><i--}}
                            {{--class="icon-close2"></i>Expired Recurring Invoices</a></li>--}}
                            {{--</ul>--}}

                            {{--</li>--}}
                            {{-- b      --}}

                        </ul>


                    </li>

                    <li class="nav-item nav-item-submenu">


                        <a href="#" class="nav-link"><i class="icon-cash3 "></i> <span>Fees</span></a>
                        <ul class="nav nav-group-sub" data-submenu-title="Finance">
                            <li class="nav-item"><a href="{{url('admin/student-fee-due')}}" class="nav-link "><i
                                            class="icon-drawer"></i>Fee Outstanding</a></li>
                            <li class="nav-item"><a href="{{url('admin/student-fee-paid')}}" class="nav-link"><i
                                        class="icon-coins"></i>Fee Paid</a></li>
                            <li class="nav-item"><a href="{{url('admin/student-fee-defaulter')}}" class="nav-link"><i
                                            class="icon-coin-pound"></i>Fee Defaulters</a></li>

                            {{--@if(isset(Auth::user()->type) &&  (Auth::user()->type==1))--}}
                            {{--<li class="nav-item"><a href="{{url('admin/reporting')}}" class="nav-link"><i--}}
                            {{--class="icon-bars-alt"></i>Finance reporting</a></li>--}}
                            {{--@endif--}}
                            {{--<li class="nav-item nav-item-submenu">--}}
                            {{--<a href="#" class="nav-link"><i class="icon-loop"></i>--}}
                            {{--<span>Recurring Invoices</span></a>--}}
                            {{--<ul class="nav nav-group-sub" data-submenu-title="Finance">--}}
                            {{--<li class="nav-item"><a href="{{url('admin/recurringInvoices')}}" class="nav-link "><i--}}
                            {{--class="icon-checkmark-circle"></i>Active Recurring Invoices</a></li>--}}
                            {{--<li class="nav-item"><a href="{{url('admin/recurringInvoices/expired')}}" class="nav-link "><i--}}
                            {{--class="icon-close2"></i>Expired Recurring Invoices</a></li>--}}
                            {{--</ul>--}}

                            {{--</li>--}}
                            {{-- b      --}}

                        </ul>


                    </li>
                    <li class="nav-item">
                        <a href="{{url('admin/expenses')}}" class="nav-link">
                            <i class="icon-office"></i>
                            <span>Expenses</span>
                        </a>
                    </li>


                    <li class="nav-item-header">
                        <div class="text-uppercase font-size-xs line-height-xs">COMMUNICATION</div>
                        <i class="icon-menu" title="Main"></i></li>

                    <li class="nav-item nav-item-submenu">
                        {{--<a href="{{url('finance')}}" class="nav-link">--}}

                        <a href="#" class="nav-link"><i class="icon-users4"></i> <span class="text-violet-800">Notification System</span></a>

                        <ul class="nav nav-group-sub" data-submenu-title="Guests">
                            <li class="nav-item"><a href="{{url('admin/notification-generator/')}}" class="nav-link"><i
                                            class="icon-megaphone"></i>Notification Generator</a></li>
                            <li class="nav-item"><a href="{{url('admin/notification/')}}" class="nav-link"><i
                                            class="icon-notification2"></i>Response Check</a></li>

                            <li class="nav-item"><a href="{{url('admin/communication/')}}" class="nav-link"><i
                                            class="icon-users2"></i>Communication</a></li>
                            <li class="nav-item">
                                <a href="{{url('admin/contact-us')}}" class="nav-link">
                                    <i class="icon-mail5"></i>
                                    <span>Contact Us</span>
                                </a>
                            </li>

                            <li class="nav-item"><a href="{{url('admin/chat-history-main/')}}" class="nav-link"><i
                                            class="icon-calendar"></i>History</a></li>





                            {{--<li class="nav-item nav-item-submenu">--}}
                            {{--<a href="{{url('finance')}}" class="nav-link">--}}

                            {{--<a href="#" class="nav-link"><i class="icon-users4"></i> <span>Notification Generator</span></a>--}}

                            {{--<ul class="nav nav-group-sub" data-submenu-title="Guests">--}}

                            {{--<li class="nav-item"><a href="{{url('admin/guests/view/')}}" class="nav-link"><i--}}
                            {{--class="icon-check"></i>Confirmational</a></li>--}}
                            {{--<li class="nav-item"><a href="{{url('admin/notification-occasional/')}}" class="nav-link"><i--}}
                            {{--class="icon-coffee"></i>Occasional</a></li>--}}

                            {{--</ul>--}}

                            {{--</li>--}}

                        </ul>

                        {{--<i class="icon-coin-dollar"></i>--}}
                        {{--<span>Finance</span>--}}
                        {{--</a>--}}
                    </li>
                    {{--<li class="nav-item nav-item-submenu">--}}
                    {{--<a href="{{url('finance')}}" class="nav-link">--}}

                    {{--<a href="#" class="nav-link"><i class="icon-users4"></i> <span>Communication</span></a>--}}

                    {{--<ul class="nav nav-group-sub" data-submenu-title="Guests">--}}

                    {{--<li class="nav-item"><a href="{{url('admin/guests/view/')}}" class="nav-link"><i--}}
                    {{--class="icon-coins"></i>Upcoming Guests</a></li>--}}
                    {{--<li class="nav-item"><a href="{{url('admin/guests/arrived/')}}" class="nav-link"><i--}}
                    {{--class="icon-coins"></i>Today's Arrived Guests</a></li>--}}
                    {{--<li class="nav-item"><a href="{{url('admin/guest/history/')}}" class="nav-link"><i--}}
                    {{--class="icon-coins"></i>Guests History</a></li>--}}
                    {{--</ul>--}}

                    {{--<i class="icon-coin-dollar"></i>--}}
                    {{--<span>Finance</span>--}}
                    {{--</a>--}}
                    {{--</li>--}}



                    {{--<li class="nav-item">--}}
                    {{--<a href="{{url('admin/notification-generator')}}" class="nav-link">--}}
                    {{--<i class="icon-megaphone"></i>--}}
                    {{--<span>Notification Generator</span>--}}
                    {{--</a>--}}
                    {{--</li>--}}

                    {{--<li class="nav-item">--}}
                    {{--<a href="{{url('admin/contact-us')}}" class="nav-link">--}}
                    {{--<i class="icon-mail5"></i>--}}
                    {{--<span>Contact Us</span>--}}
                    {{--</a>--}}
                    {{--</li>--}}


                    <li class="nav-item-header">
                        <div class="text-uppercase font-size-xs line-height-xs">SETTINGS</div>
                        <i class="icon-menu" title="Main"></i></li>
                    <li class="nav-item">
                        <a href="{{url('admin/expense-categories')}}" class="nav-link">
                            <i class="icon-user-lock"></i>
                            <span>Expense Categories</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{url('admin/admin-accounts')}}" class="nav-link">
                            <i class="icon-user-plus"></i>
                            <span>Super Admin Accounts</span>
                        </a>
                    </li>


                    <!-- /main -->

                </ul>
            </div>
            <!-- /main navigation -->

        </div>
        <!-- /sidebar content -->

    </div>
    <!-- /main sidebar -->





{{--main page content--}}
{{--    @include('layouts.admin.modal')--}}
@yield('content')

{{--/main page content--}}

<!-- Secondary sidebar -->
    {{--<div class="sidebar sidebar-custom-right-admin sidebar-light sidebar-right sidebar-expand-md">--}}

        {{--<!-- Sidebar mobile toggler -->--}}
        {{--<div class="sidebar-mobile-toggler text-center">--}}
            {{--<a href="#" class="sidebar-mobile-secondary-toggle">--}}
                {{--<i class="icon-arrow-left8"></i>--}}
            {{--</a>--}}
            {{--<span class="font-weight-semibold">Secondary sidebar</span>--}}
            {{--<a href="#" class="sidebar-mobile-expand">--}}
                {{--<i class="icon-screen-full"></i>--}}
                {{--<i class="icon-screen-normal"></i>--}}
            {{--</a>--}}
        {{--</div>--}}
        {{--<!-- /sidebar mobile toggler -->--}}


        {{--<!-- Sidebar content -->--}}
        {{--<div class="sidebar-content">--}}


            {{--<!-- Sub navigation -->--}}
            {{--<div class="card mb-2">--}}


                {{--<div class="card-body p-0">--}}
                    {{--<ul class="nav nav-sidebar" data-nav-type="accordion">--}}

                        {{--<li class="nav-item-header">--}}
                            {{--Groups--}}
                            {{--btn-add-group--}}
                            {{--@if (Auth::id() == 1)--}}
                                {{--<button type="button" class="btn btn-sm btn-link float-right admin-btn-add-group">--}}
                                    {{--<i class="icon-plus-circle2"></i>--}}
                                {{--</button>--}}
                            {{--@else--}}
                                {{--<button type="button" class="btn btn-sm btn-link float-right btn-add-group">--}}
                                    {{--<i class="icon-plus-circle2"></i>--}}
                                {{--</button>--}}
                            {{--@endif--}}
                        {{--</li>--}}
                        {{--<div id="user-group-menu">--}}

                        {{--</div>--}}


                    {{--</ul>--}}
                {{--</div>--}}
                {{--<div id="admin-users-list">--}}
                    {{--<chat-component></chat-component>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<!-- /sub navigation -->--}}


        {{--</div>--}}
        {{--<!-- /sidebar content -->--}}

    {{--</div>--}}
    <!-- /secondary sidebar -->

</div>
<!-- /page content -->

<!-- Scripts -->
<script src="{{ asset('theme_assets/js/main/jquery.min.js')}}"></script>

<script src="{{ asset('js/app.js') }}"></script>
{{--Chat--}}
<script src="{{ asset('theme_assets/js/main/bootstrap.bundle.min.js')}}"></script>
<script src="{{ asset('theme_assets/js/demo_pages/chat_layouts.js')}}"></script>

<!-- Theme JS files -->
<!-- Core JS files -->
<script src="{{ asset('theme_assets/js/plugins/loaders/blockui.min.js')}}"></script>
<script src="{{ asset('theme_assets/js/plugins/ui/ripple.min.js')}}"></script>
<!-- /core JS files -->
<script src="{{ asset('theme_assets/js/plugins/forms/styling/uniform.min.js')}}"></script>
<script src="{{ asset('theme_assets/js/plugins/extensions/jquery_ui/interactions.min.js')}}"></script>
<script src="{{ asset('theme_assets/js/plugins/forms/selects/select2.min.js')}}"></script>
<script src="{{ asset('theme_assets/js/demo_pages/form_select2.js')}}"></script>
<script src="{{ asset('theme_assets/js/demo_pages/form_input_groups.js')}}"></script>

<!-- Load plugin -->
<script src="{{ asset('theme_assets/js/plugins/visualization/d3/d3.min.js')}}"></script>
<script src="{{ asset('theme_assets/js/plugins/visualization/d3/d3_tooltip.js')}}"></script>
<script src="{{ asset('theme_assets/js/plugins/forms/styling/switchery.min.js')}}"></script>
<script src="{{ asset('theme_assets/js/plugins/forms/selects/bootstrap_multiselect.js')}}"></script>
<script src="{{ asset('theme_assets/js/plugins/ui/moment/moment.min.js')}}"></script>
<script src="{{ asset('theme_assets/js/plugins/pickers/daterangepicker.js')}}"></script>
<script src="{{ asset('theme_assets/js/plugins/notifications/jgrowl.min.js')}}"></script>
<script src="{{ asset('theme_assets/js/plugins/uploaders/dropzone.min.js')}}"></script>
<script src="{{ asset('theme_assets/js/plugins/ui/moment/moment.min.js')}}"></script>
<script src="{{ asset('theme_assets/js/plugins/ui/fullcalendar/fullcalendar.min.js')}}"></script>
<script src="{{ asset('theme_assets/js/plugins/pickers/anytime.min.js')}}"></script>
<script src="{{ asset('theme_assets/js/plugins/pickers/pickadate/picker.js')}}"></script>
<script src="{{ asset('theme_assets/js/plugins/pickers/pickadate/picker.date.js')}}"></script>
<script src="{{ asset('theme_assets/js/plugins/pickers/pickadate/picker.time.js')}}"></script>
<script src="{{ asset('theme_assets/js/plugins/pickers/pickadate/legacy.js')}}"></script>
<script src="{{ asset('theme_assets/js/demo_pages/picker_date.js')}}"></script>
<script src="{{asset('theme_assets/js/plugins/tables/datatables/datatables.min.js')}}"></script>
<script src="{{ asset('theme_assets/js/plugins/loaders/pace.min.js')}}"></script>
<script src="{{ asset('theme_assets/js/demo_pages/invoice_grid.js')}}"></script>



<!-- Theme JS files -->
<script src="{{ asset('theme_assets/js/plugins/forms/styling/uniform.min.js')}}"></script>
<script src="{{ asset('theme_assets/js/plugins/notifications/pnotify.min.js')}}"></script>
<script src="{{ asset('theme_assets/js/plugins/forms/selects/bootstrap_multiselect.js')}}"></script>

<script src="{{ asset('theme_assets/js/demo_pages/form_multiselect.js')}}"></script>
<!-- /theme JS files -->


<!-- /Load plugin -->
<script src=" {{ asset('theme_assets/js/demo_pages/widgets_content.js')}}"></script>
<script src="{{ asset('template_assets/js/app.js')}}"></script>
<script src="{{ asset('theme_assets/js/demo_pages/dashboard.js') }}"></script>

<script src="{{asset('theme_assets/js/plugins/visualization/echarts/echarts.min.js')}}"></script>

<script src="{{asset('theme_assets/js/demo_pages/charts/echarts/pies_donuts.js')}}"></script>

@yield('pageSpecificScripts')

<script>

    $(".js-example-tags").select2({
        tags: false,
        theme: "classic"
    });


    $('.datatable-basic').DataTable({
        // "order": [[ 0, "asc" ]],

        autoWidth: false,
        dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
        language: {
            search: '<span>Filter:</span> _INPUT_',
            lengthMenu: '<span>Show:</span> _MENU_',
            paginate: {'first': 'First', 'last': 'Last', 'next': '→', 'previous': '←'}
        }
    });
    $('.datatable-basic-desc').DataTable( {
        "order": [[ 0, "desc" ]],
        autoWidth: false,
        dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
        language: {
            search: '<span>Filter:</span> _INPUT_',
            lengthMenu: '<span>Show:</span> _MENU_',
            paginate: {'first': 'First', 'last': 'Last', 'next': '→', 'previous': '←'}
        }    } );


    $('.datatable-basic-user').DataTable({
        autoWidth: false,
        dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
        language: {
            search: '<span>Filter:</span> _INPUT_',
            lengthMenu: '<span>Show:</span> _MENU_',
            paginate: {'first': 'First', 'last': 'Last', 'next': '→', 'previous': '←'}
        }
    });


    $(document).ready(function() {
        var table = $('.datatable-basic-user').DataTable();

        $('.datatable-basic-user tbody').on('click', 'tr', function (event) {
            var data = table.row( this ).data();
// alert( 'You clicked on '+data[0]+'\'s row' );

            var href = $(data[1]).find("a").attr("href");
            var edit = $(event.target).html();
            console.log(JSON.stringify(edit));
            if (edit === "Edit" || edit === "Approve" || edit === "Unapprove" || edit === "Delete"){
// alert(edit);

            }else {
                if(href) {
                    window.location = href;
                }
            }


// event.preventDefault();

        } );
    } );


    $('.datatable-basic-teams').DataTable({
        autoWidth: false,
        dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
        language: {
            search: '<span>Filter:</span> _INPUT_',
            lengthMenu: '<span>Show:</span> _MENU_',
            paginate: {'first': 'First', 'last': 'Last', 'next': '→', 'previous': '←'}
        }
    });

    //datatable teams
    $(document).ready(function() {
        var table = $('.datatable-basic-teams').DataTable();

        $('.datatable-basic-teams tbody').on('click', 'tr', function (event) {
            var data = table.row( this ).data();
// alert( 'You clicked on '+data[0]+'\'s row' );

            var href = $(data[1]).attr("href");
            var edit = $(event.target).html();
// alert(href);
            if (edit === "Members" || edit === "Asset Details" || edit === "Edit Time Limit" || edit === "Generate Manual Invoice"){

            }else {
                if(href) {
                    window.location = href;
                }
            }


// event.preventDefault();

        } );
    } );


    $('.datatable-basic-team-members').DataTable({
        autoWidth: false,
        dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
        language: {
            search: '<span>Filter:</span> _INPUT_',
            lengthMenu: '<span>Show:</span> _MENU_',
            paginate: {'first': 'First', 'last': 'Last', 'next': '→', 'previous': '←'}
        }
    });

    // datatable teams
    $(document).ready(function() {
        var table = $('.datatable-basic-team-members').DataTable();

        $('.datatable-basic-team-members tbody').on('click', 'tr', function (event) {
            var data = table.row( this ).data();
// alert( 'You clicked on '+data[0]+'\'s row' );

            var href = $(data[0]).attr("href");
            var edit = $(event.target).html();
// alert(href);

            if(href) {
                window.location = href;
            }



// event.preventDefault();

        } );
    } );




    $('.datatable-basic-desc-announcements').DataTable( {
        "order": [[ 0, "desc" ]],
        "columnDefs": [ {
            targets: 2,
            render: function ( data, type, row ) {
// return type === 'display' && data.length > 10 ?
//     data.substr( 0, 10 ) +'…' :
//     data;
                return ( (type === 'display' && data.length > 100) ? data.substr( 0, 100 ) +'…' : data);
// return data + "<br> "+data.length;
            }
        } ]
    } );



    $('input[type=number]').change(function () {
        return calc_total($(this).attr('num'));
    });



    $('input[type=number]').change(function () {
        return calc_total($(this).attr('num'));
    });

    function calc_total(x) {
        var q = parseFloat($('#quantity' + x).val());
        var p = parseFloat($('#price' + x).val());

        if (q > 0 && p > 0) {
            $('#total' + x).html('Rs' + (q * p));
        }
    }

    function remove_item(x) {
        $('#' + x).remove();
    }




</script>
<!-- /theme JS files -->
</body>
</html>
