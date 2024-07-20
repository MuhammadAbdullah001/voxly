@extends('layouts.admin.master')

@section('content')
    <!-- Main content -->
    <div class="content-wrapper">

        <!-- Page header -->
        <div class="page-header page-header-light">
            <div class="page-header-content header-elements-md-inline">
                <div class="page-title d-flex">
                    <h4><span class="font-weight-semibold">Student Fee </span> - Edit</h4>
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


            <div class="card">
                <div class="card-header">
                    <div class="header-elements-inline">
                        <h4 class="card-title">Edit Fee  </h4>
                    </div>
                </div>
                <hr>

                <div class="card-body">
                    <?php
                    if (isset($data['student_fee_edit']) && !empty($data['student_fee_edit'])){
                        $d = $data['student_fee_edit'];
//                                            print_r($d->expenseCategory->type);die;
                        ?>


                        <form action="{{url('admin/student-fee/edit')}}" method="post">
                            @csrf
                            <input type="hidden" name="id" value="<?php echo $d->id;?>">

                            <div class="form-group row">
                                <label class="col-form-label col-lg-2">Fee From Date</label>
                                <div class="col-lg-4">
                                    <div class="input-group">
                                        <input type="text" id="fee_from_date" value="<?php echo date('d-m-Y',strtotime($d->from_date));?>" name="fee_from_date" class="form-control daterange-single" required>
                                    </div>
                                </div>
                                <label class="col-form-label col-lg-2 text-center">Fee To Date</label>
                                <div class="col-lg-4">
                                    <div class="input-group">

                                        <input type="text" id="fee_to_date" value="<?php echo date('d-m-Y',strtotime($d->to_date)); ?>" name="fee_to_date" class="form-control daterange-single" required>

                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-form-label col-lg-2">Admission No</label>
                                <div class="col-lg-10">
                                    <div class="input-group">
                                        <input type="text" id="admission_no" value="<?php echo $d->admission_no; ?>" readonly name="admission_no" class="form-control" required>

                                    </div>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="col-form-label col-lg-2">Student</label>
                                <div class="col-lg-10">
                                    <div class="input-group">

                                             <input type="hidden"  value="<?php echo $d->student_admissions_id; ?>"   name="student_admissions_id" >
                                             <input type="text" id="admission_no" value="<?php echo $d->student->student_name; ?>" readonly name="student_admissions_id" class="form-control" required>

                                     </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-2 col-form-label">Fee Duration(Days)</label>
                                <div class="col-md-10">
                                    <input type="number"   id="fee_duration" value="<?php echo $d->paid_duration; ?>"    name="fee_duration" class="form-control" placeholder="Enter Fee Duration(Days)" required>
                                </div>
                            </div>



                            <div class="form-group row">
                                <label class="col-md-2 col-form-label">Amount</label>
                                <div class="col-md-10">
                                    <input type="number" value="<?php echo $d->amount_taken; ?>"  step="any" min="0.001"   name="amount" class="form-control" placeholder="Enter Fee Amount" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-form-label col-lg-2">Payment Type</label>
                                <div class="col-lg-10">
                                    <div class="input-group">
                                        <select name="payment_type" class=" form-control-select2 form-control" required id="expense_category">
                                            <option value="">--- SELECT ---</option>
                                            <option <?php if ($d->payment_type == "cash"){ echo "selected"; } ?> value="cash">Cash</option>
                                            <option <?php if ($d->payment_type == "bank_transfer"){ echo "selected"; } ?> value="bank_transfer">Bank Transfer</option>
                                            <option <?php if ($d->payment_type == "card"){ echo "selected"; } ?> value="card">Card</option>
                                        </select>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group row">

                                <label class="col-md-2 col-form-label">Entry Date:</label>
                                <div class="col-md-10">
                                    <input type="text" id="date" value="<?php echo date('d-m-Y',strtotime($d->entry_date));?>"   name="date" class="form-control daterange-single" required>
                                </div>

                            </div>

                            <div class="form-group row">
                                <label class="col-form-label col-lg-2">Description</label>
                                <div class="col-lg-10">
                                    <div class="input-group">
                                        <textarea   name="description" class="form-control" ><?php echo $d->description; ?></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-5 mb-2 d-md-flex  justify-content-md-between flex-md-wrap">
                                <button type="submit" id="fee_submit_btn" class="btn bg-primary d-flex align-items-center">
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
