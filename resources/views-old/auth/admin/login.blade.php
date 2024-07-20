@extends('layouts.admin.app')

@section('content')

    {{--<div class="container-fluid">--}}

        <!-- Page content -->
        <div class="page-content">

            <!-- Main content -->
            <div class="content-wrapper">

                <!-- Content area -->
                <div class="content d-flex justify-content-center align-items-center" style="margin-top: 5%">

                    <!-- Login card -->
                    <form class="login-form" method="POST" action="{{ route('adminLoginAttempt') }}" aria-label="{{ __('Login') }}">
                        @csrf
                        <div class="card mb-0">
                            <div class="card-body">
                                <div class="text-center mb-3">
                                    {{--<i class="icon-people icon-2x text-warning-400 border-warning-400 border-3 rounded-round p-3 mb-3 mt-1"></i>--}}
                                    <img class="   p-3 mb-3 mt-1" src="{{asset('images/logo.png')}}" >

                                    {{--<img src="{{asset('images/logo.png')}}" width="130" height="99" alt="">--}}

                                    <h5 class="mb-0">Login to your account (Super-Admin Portal)</h5>
                                    <span class="d-block text-muted">Your credentials</span>
                                </div>

                                @if ($errors->any())

                                    <div class="alert alert-danger  alert-styled-left">
                                        {{--{{  $errors->first('email') . $errors->first('password') }}--}}
                                        Wrong Email or password or Authentication status not approved

                                    </div>
                                @endif
                                <div class="form-group form-group-feedback form-group-feedback-left">
                                    <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}" required autofocus>
                                    <div class="form-control-feedback">
                                        <i class="icon-user text-muted"></i>
                                    </div>
                                </div>

                                <div class="form-group form-group-feedback form-group-feedback-left">
                                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                                    <div class="form-control-feedback">
                                        <i class="icon-lock2 text-muted"></i>
                                    </div>
                                </div>

                                {{--<div class="form-group d-flex align-items-center">--}}
                                {{--<div class="form-check mb-0">--}}
                                {{--<label class="form-check-label">--}}
                                {{--<input type="checkbox" name="remember" class="form-input-styled" checked >--}}
                                {{--Remember--}}
                                {{--</label>--}}
                                {{--</div>--}}

                                {{--<a href="login_password_recover.html" class="ml-auto">Forgot password?</a>--}}
                                {{--</div>--}}

                                <div class="form-group">
                                    <button type="submit" class="btn custom-dk-bg-color btn-block">Sign in <i class="icon-circle-right2 ml-2"></i></button>
                                </div>

                            </div>
                        </div>
                    </form>
                    <!-- /login card -->

                </div>
                <!-- /content area -->

            </div>
            <!-- /main content -->

        </div>
        <!-- /page content -->

    {{--</div>--}}

@endsection
