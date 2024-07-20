

{{--<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">--}}
<link href="{{ asset('css/app.css') }}" rel="stylesheet">
<link href="{{ asset('theme_assets/css/icons/icomoon/styles.css')}}" rel="stylesheet" type="text/css">
<link href="{{ asset('template_assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('template_assets/css/bootstrap_limitless.min.css')}}" rel="stylesheet" type="text/css">
<link href="{{ asset('template_assets/css/layout.min.css')}}" rel="stylesheet" type="text/css">
<link href="{{ asset('template_assets/css/components.min.css')}}" rel="stylesheet" type="text/css">
<link href="{{ asset('template_assets/css/colors.min.css')}}" rel="stylesheet" type="text/css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

<style>
    .input_wrapper{position:relative}
    .plastic_select, input[type=url], input[type=text], input[type=tel], input[type=number], input[type=email], input[type=password], select, textarea {
        font-size: 1.25rem;
        line-height: normal;
        padding: .75rem;
        border: 1px solid #C5C5C5;
        border-radius: .25rem;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        outline: 0;
        color: #555459;
        width: 100%;
        max-width: 100%;
        font-family: Slack-Lato,appleLogo,sans-serif;
        margin: 0 0 .5rem;
        -webkit-transition: box-shadow 70ms ease-out,border-color 70ms ease-out;
        -moz-transition: box-shadow 70ms ease-out,border-color 70ms ease-out;
        transition: box-shadow 70ms ease-out,border-color 70ms ease-out;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        box-shadow: none;
        height: auto;
    }
    .no_touch .plastic_select:hover,.no_touch input:hover,.no_touch select:hover,.no_touch textarea:hover{border-color:#2780f8}
    .focus,.plastic_select:active,.plastic_select:focus,input[type=url]:active,input[type=url]:focus,input[type=text]:active,input[type=text]:focus,input[type=number]:active,input[type=number]:focus,input[type=email]:active,input[type=email]:focus,input[type=password]:active,input[type=password]:focus,select:active,select:focus,textarea:active,textarea:focus{border-color:#2780f8;box-shadow:0 0 7px rgba(39,128,248,.15);outline-offset:0;outline:0}

    .large_bottom_margin {
        margin-bottom: 2rem!important;
    }
    .split_input{display:table;border-spacing:0}
    .split_input_item{display:table-cell;border:1px solid #9e9ea6}
    .split_input_item:not(:first-child){border-left:none}
    .split_input_item:first-child{border-top-left-radius:5px;border-bottom-left-radius:5px}
    .split_input_item:last-child{border-top-right-radius:5px;border-bottom-right-radius:5px}
    .split_input_item.focused{border:1px double #2780f8;box-shadow:0 0 7px rgba(39,128,248,.3)}
    .split_input_item input{height:5rem;text-align:center;font-size:2.5rem;border:none;background:0 0;box-shadow:none}
    .split_input_item input:active,.split_input_item input:focus,.split_input_item input:hover{box-shadow:none}


    .fs_split{position:absolute;overflow:hidden;width:100%;top:0;bottom:0;left:0;right:0;background-color:#e8e8e8;-webkit-transition:background-color .2s ease-out 0s;-moz-transition:background-color .2s ease-out 0s;transition:background-color .2s ease-out 0s}
    .fs_split h1{font-size:2.625rem;line-height:3rem;font-weight:300;margin-bottom:2rem}
    .fs_split label{margin-bottom:.5rem}
    .fs_split .desc{font-size:1.25rem;color:#9e9ea6;margin-bottom:2rem}
    .fs_split .email{color:#555459;font-weight:700}
    .fs_split .header_error_message{margin:0 11%;padding:1rem 2rem;background:#fff1e1;border:none;border-left:.5rem solid #ffa940;border-radius:.25rem}
    .fs_split .header_error_message h3{margin:0}
    .fs_split .error_message{display:none;font-weight:700;color:#ffa940}
    .fs_split .error input,.fs_split .error textarea{border:1px solid #ffa940;background:#fff1e1}
    .fs_split .error input:focus,.fs_split .error textarea:focus{border-color:#fff1e1;box-shadow:0 0 7px rgba(255,185,100,.15)}
    .fs_split .error .error_message{display:inline}
    .confirmation_code_span_cell{display:table-cell;font-weight:700;font-size:2rem;text-align:center;padding:0 .5rem;width:2rem}
    .confirmation_code_state_message{position:absolute;width:100%;opacity:0;-webkit-transition:opacity .2s;-moz-transition:opacity .2s;transition:opacity .2s}
    .confirmation_code_state_message.error,.confirmation_code_state_message.processing,.confirmation_code_state_message.ratelimited{font-size:1.25rem;font-weight:700;line-height:2rem}
    .confirmation_code_state_message.processing{color:#3aa3e3}
    .confirmation_code_state_message.error,.confirmation_code_state_message.ratelimited{color:#ffa940}
    .confirmation_code_state_message ts-icon:before{font-size:2.5rem}
    .confirmation_code_state_message svg.ts_icon_spinner{height:2rem;width:2rem}
    .confirmation_code_checker{position:relative;height:12rem;text-align:center}
    .confirmation_code_checker[data-state=unchecked] .confirmation_code_state_message.unchecked,.confirmation_code_checker[data-state=error] .confirmation_code_state_message.error,.confirmation_code_checker[data-state=processing] .confirmation_code_state_message.processing,.confirmation_code_checker[data-state=ratelimited] .confirmation_code_state_message.ratelimited{opacity:1}
    .large_bottom_margin {
        margin-bottom: 2rem !important;
    }
</style>

<!------ Include the above in your HEAD tag ---------->
<!-- Main navbar -->
<div class="navbar navbar-expand-md navbar-dark custom-dk-bg-color navbar-static" id="nav">


    <div  class="d-md-none">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-mobile">
            <i class="icon-tree5"></i>
        </button>
        <button class="navbar-toggler sidebar-mobile-main-toggle" type="button">
            <i class="icon-paragraph-justify3"></i>
        </button>
        <button class="navbar-toggler sidebar-mobile-secondary-toggle" type="button">
            <i class="icon-more"></i>
        </button>
    </div>

    <div class="collapse navbar-collapse" id="navbar-mobile">
        <ul class="navbar-nav">

            <div class="navbar-brand" style="padding: 0 !important;">
                <a href="{{route('admin.home')}}" class="d-inline-block">
                    {{--<img src="{{asset('theme_assets/images/logo.png')}}" alt="">--}}
                    <img style="width: 200px; height: 35px;" src="{{asset('images/logo_white.png')}}" alt="">

                </a>
            </div>



        </ul>

        </ul>
    </div>
</div>
<div class="content">


    <div class="row" style="padding-top: 10%;">
        <br><br><br><br>
        <div class="col-sm-1"></div>
        <div class="col-sm-9">

            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                <div class="form-group row">
                    <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                    <div class="col-md-6">
                        <input id="email" style="border-top-color: lightgray !important;" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                        @error('email')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                    <div class="col-md-6">
                        <input id="password" style="border-top-color: lightgray !important;" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                        @error('password')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                    <div class="col-md-6">
                        <input id="password-confirm" style="border-top-color: lightgray !important;" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Reset Password') }}
                        </button>
                    </div>
                </div>
            </form>


        </div>


    </div>

</div>
<div class="navbar navbar-expand-lg navbar-light">
    <div class="text-center d-lg-none w-100">
        <button type="button" class="navbar-toggler dropdown-toggle" data-toggle="collapse" data-target="#navbar-footer">
            <i class="icon-unfold mr-2"></i>
            Footer
        </button>
    </div>

    <div class="navbar-collapse collapse" id="navbar-footer">
					<span class="navbar-text">
						&copy; <?php echo date('Y');?>. <a href="#">{{ config('app.name') }}</a>
					</span>

    </div>
</div>
