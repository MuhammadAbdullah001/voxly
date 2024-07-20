<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    {{--<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">--}}

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->


    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    <link href="{{ asset('theme_assets/css/icons/icomoon/styles.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('template_assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('template_assets/css/bootstrap_limitless.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('template_assets/css/layout.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('template_assets/css/components.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('template_assets/css/colors.min.css')}}" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->

</head>
<body class="" style="background-color:#5E91CC; " >

    <div class="container-fluid" id="app">
        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" ></script>


    <!-- Core JS files -->
    {{--files commented by waqar ali--}}
    {{--<script src="../../../../global_assets/js/main/jquery.min.js"></script>--}}
    {{--<script src="../../../../global_assets/js/main/bootstrap.bundle.min.js"></script>--}}

    <script src="{{ asset('theme_assets/js/plugins/loaders/blockui.min.js')}}"></script>
    <script src="{{ asset('theme_assets/js/plugins/ui/ripple.min.js')}}"></script>
    <!-- /core JS files -->

    <!-- Theme JS files -->
    <script src="{{ asset('template_assets/js/app.js')}}"></script>
    {{--<script src="{{ asset('theme_assets/js/demo_pages/dashboard.js') }}"></script>--}}
    <!-- /theme JS files -->

    <script src="{{ asset('theme_assets/js/plugins/forms/styling/uniform.min.js')}}"></script>

    <script src="{{ asset('theme_assets/js/plugins/extensions/jquery_ui/interactions.min.js')}}"></script>


    <script src="{{ asset('theme_assets/js/plugins/forms/selects/select2.min.js')}}"></script>

    <script src="{{ asset('theme_assets/js/demo_pages/form_select2.js')}}"></script>
    <script src="{{ asset('theme_assets/js/demo_pages/form_inputs.js')}}"></script>

    <!-- Theme JS files -->
    {{--<script src="{{ asset('theme_assets/js/plugins/visualization/d3/d3.min.js')}}"></script>--}}
    {{--<script src="{{ asset('theme_assets/js/plugins/visualization/d3/d3_tooltip.js')}}"></script>--}}
    {{--<script src="{{ asset('theme_assets/js/plugins/forms/styling/switchery.min.js')}}"></script>--}}
    {{--<script src="{{ asset('theme_assets/js/plugins/forms/selects/bootstrap_multiselect.js')}}"></script>--}}
    {{--<script src="{{ asset('theme_assets/js/plugins/ui/moment/moment.min.js')}}"></script>--}}
    {{--<script src="{{ asset('theme_assets/js/plugins/pickers/daterangepicker.js')}}"></script>--}}

    {{--<script src="{{ asset('template_assets/js/app.js')}}"></script>--}}
    {{--<script src="{{ asset('theme_assets/js/demo_pages/dashboard.js') }}"></script>--}}
    <!-- /theme JS files -->

</body>
</html>
