

{{--<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">--}}
  <link href="{{ asset('template_assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('template_assets/css/bootstrap_limitless.min.css')}}" rel="stylesheet" type="text/css">
<link href="{{ asset('template_assets/css/layout.min.css')}}" rel="stylesheet" type="text/css">


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

                     <img style="width: 200px; height: 35px;" src="{{asset('images/logo_white.png')}}" alt="">

            </div>

        </ul>

        </ul>
    </div>
</div>
<div class="page-content">

    <!-- Main content -->
    <div class="content-wrapper">

        <!-- Content area -->
        <div class="content d-flex justify-content-center align-items-center" style="    flex-grow:0.3 !important;" >

            <!-- Login card -->
                 <div class="card mb-0">
                    <div class="card-body">
                        <div class="text-center mb-3">
                            {{--<i class="icon-people icon-2x text-warning-400 border-warning-400 border-3 rounded-round p-3 mb-3 mt-1"></i>--}}
                            <img class="   p-3 mb-3 mt-1" src="{{asset('images/logo.png')}}" >

                            {{--<img src="{{asset('images/logo.png')}}" width="130" height="99" alt="">--}}

                            <h5 class="mb-0">You Have Successfully Reset Your Password!</h5>
                            <span class="d-block text-muted">You Can Login To Our App With Your New Password</span>
                        </div>


                    </div>
                </div>
             <!-- /login card -->

        </div>
        <!-- /content area -->

    </div>
    <!-- /main content -->

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
