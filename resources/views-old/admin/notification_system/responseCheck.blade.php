@extends('layouts.admin.master')

@section('content')
    <!-- Main content -->
    <div class="content-wrapper">
        <!-- Content area -->
        <div class="content d-flex align-items-stretch">
              @if(isset($data['notification']))
            <div class="card w-100 h-100 position-relative">
                <div class="card-header bg-dark">
                    <div class="text-center">
                        <h5 class="card-title d-inline-block"> Response Check: <span class="text-info">

                                {{$data['notification']->title}}
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
                        @if(isset($data['notification']))

                            <li class="media  ">
                                <div class="media-body">
                                    <div class="media-chat-item">{{$data['notification']->description}}</div>
                                    <div class="font-size-sm text-muted mt-2">
                                        {{ time_elapsed_string($data['notification']->created_at) }}

                                     </div>
                                </div>
                            </li>
                            @if(isset($data['notification']->notif_reply))
                            <li class="media <?php if( ($data['notification']->notif_reply) ) echo 'media-chat-item-reverse'; ?>">
                                <div class="media-body">
                                    <div class="media-chat-item">{{$data['notification']->notif_reply->message}}</div>
                                    <div class="font-size-sm text-muted mt-2">
                                        {{ time_elapsed_string($data['notification']->notif_reply->created_at) }}
                                          </div>
                                </div>
                            </li>


                         @endif
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