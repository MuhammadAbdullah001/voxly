<!-- Theme JS files -->
<!--	<script src="--><?php //echo base_url('assetsb'); ?><!--/js/plugins/tables/datatables/datatables.min.js"></script>-->
<!--	<script src="--><?php //echo base_url('assetsb'); ?><!--/js/plugins/forms/selects/select2.min.js"></script>-->
<!--	<script src="--><?php //echo base_url('assetsb'); ?><!--/js/demo_pages/datatables_basic.js"></script>-->
<!-- /theme JS files -->
@extends('layouts.admin.master')

@section('content')


    <!-- Main content -->
    <div class="content-wrapper">

        <!-- Page header -->
        <div class="page-header page-header-light">
            <div class="page-header-content header-elements-md-inline">
                <div class="page-title d-flex">
                    <h4><span class="font-weight-semibold">Student Fees  </span> - Paid</h4>
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
{{--                        <span class="breadcrumb-item active">Groups</span>--}}
{{--                    </div>--}}

{{--                    <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>--}}
{{--                </div>--}}
{{--            </div>--}}
        </div>
        <!-- /page header -->


        <!-- Content area -->
        <div class="content">
            @if (session('status'))

                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-success alert-styled-left alert-arrow-left alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                            <span class="font-weight-semibold">Well done!</span> 					{{ session('status') }}

                        </div>
                    </div>
                </div>
            @endif
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


            <div class="card">
                <div class="card-header ">
                    <form action="{{ url('admin/student-fee-paid') }}" method="post">

                        <div class="row">
                            @csrf
                            <div class="col-md-5 form-group" id="">

                                <label class="checkbox-inline">Start date <b>(Current-Selection=><?php echo date('d-M-Y',strtotime($data['start_date']))?>)</b>
                                    <input type="date" class="pickadate-year form-control" name="start_date" required></label>
                            </div>
                            <div class="col-md-5 form-group" id="">

                                <label class="checkbox-inline"> End date <b>(Current-Selection=><?php echo date('d-M-Y',strtotime($data['end_date']))?>)</b>
                                    <input type="date" class="pickadate-year form-control"  name="end_date" required></label>
                            </div>
                            <div class="header-elements">
                                <input class="  btn bg-success" type="submit" value="Submit" class="btn btn-primary legitRipple">
                            </div>

                        </div>
                    </form>

                </div>
            </div>

            <!-- Basic datatable -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Fees Paid</h5><br>
                    <p><b>Note:</b>This List Show Current Month Entries By Default. Select Date-Range For Older Entries</p><br>




                </div>


                <table class="table datatable-basic-desc table table-responsive table-bordered">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Admission No</th>
                        <th>Student Name</th>
                        <th>Fee From Date</th>
                        <th>Fee To Date</th>
                        <th>Fee Entry Date</th>
                        <th>Paid Duration</th>
                        <th>Agreed Fee/hr</th>
                        <th>Agreed hrs</th>
                        <th>Payment Type</th>
                        <th>Expected Fee</th>
                        <th>Fee Taken</th>
                        <th>Created By</th>
                        <th>Status</th>
                        <th>description</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(isset($data['student_fees']) && count($data['student_fees'])>0){ foreach($data['student_fees']  as $d){ ?>
                    <tr <?php if (isset($d->is_update) && $d->is_update == 1){ ?> class="bg bg-warning" <?php } ?>>
                        <td>{{$d->id }}</td>
                        <td>{{$d->admission_no }}</td>
                        <td>{{$d->student->student_name }}</td>
                        <td>{{$d->from_date }}</td>
                        <td>{{$d->to_date }}</td>
                        <td>{{$d->entry_date }}</td>
                        <td>{{$d->paid_duration }}</td>
                        <td>{{$d->agreed_fee_per_hr }}</td>
                        <td>{{$d->agreed_hrs }}</td>
                        <td> {{ strtoupper(str_replace('_',' ',$d->payment_type)) }}</td>
                        <td>{{ number_format($d->expected_amount,0) }}</td>
                        <td>{{ number_format($d->amount_taken,0) }}</td>
                        <td>
                            @if(isset($d->admin) && !empty($d->admin))
                                {{$d->admin->name }}
                            @else
                            @endif
                        </td>
                        <td class="bg bg-success text-center">{{  $d->status }}</td>

                        <td >{{  $d->description }}</td>


                    </tr>
                    <?php }} ?>
                    </tbody>
                </table>
                <div class="card-footer ">
                    <div class="header-elements row">

                        <h5 class="col-md-10"></h5>
                        <h5 class="col-md-1">Total </h5>

                        <p  class="col-md-1  btn btn-primary legitRipple">&pound;{{ number_format($data['total'],0) }}</p>
                    </div>
                </div>
            </div>
            <!-- /basic datatable -->

        </div>
        <!-- /content area -->

    </div>
    <!-- /main content -->

@endsection

