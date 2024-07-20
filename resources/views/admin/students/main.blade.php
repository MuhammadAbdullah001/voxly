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
						<h4><span class="font-weight-semibold">Record Attendance</span> - Main</h4>
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

{{--				<div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">--}}
{{--					<div class="d-flex">--}}
{{--						<div class="breadcrumb">--}}
{{--                            <a href="{{asset('/admin/booking')}}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Dashboard</a>--}}
{{--							<span class="breadcrumb-item active">Record Attendance</span>--}}
{{--						</div>--}}

{{--						<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>--}}
{{--					</div>--}}
{{--				</div>--}}
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

					<div class="alert alert-success">
						{{ session()->get('success') }}
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

				<!-- Basic datatable -->
				<div class="card">
					<div class="card-header header-elements-inline">
						<h5 class="card-title">Record Attendance</h5>
                        <div class="header-elements">
                            <a href="{{asset('/admin/admission/add')}}" class="btn btn-primary legitRipple">Add New</a>
                        </div>
					</div>


                    <table class="table datatable-basic table-bordered">
						<thead>
							<tr>
								<th>#</th>
								<th>Admission No</th>
								<th>Parent Name</th>
								<th>Email</th>
								<th>Contact Number</th>
								<th>Remarks</th>
{{--								<th>Address</th>--}}
								<th>Projected Revenue</th>
								<th>Child Care</th>
								<th>Registration Date</th>
								<th>Status</th>s
 								<th class="text-center">Actions</th>
							</tr>
						</thead>
						<tbody>
							<?php if(isset($data['admission_registration']) && count($data['admission_registration'])>0){ foreach($data['admission_registration']  as $d){ ?>
							<tr <?php if (isset($d->is_update) && $d->is_update == 1){ ?> class="bg bg-warning" <?php } ?>>
								<td>{{$d->admission_no }}</td>
								<td>{{$d->parent_name }}</td>
								<td>{{$d->email }}</td>
								<td>{{$d->contact_number }} </td>
								<td>{{$d->Status }} </td>
								<td>{{$d->remarks }}</td>
                                <?php

//                                $start = explode(':',$d->time_start);
//                                $start_h =$start[0];
//                                $end = explode(':',$d->time_end);
//                                $end_h =$end[0];
//                                  $wh = $end_h - $start_h;

                                ?>
{{--								<td>{{$d->address }}</td>--}}
								<td>{{$d->projected_revenue }}</td>
								<td>{{$d->child_care }}</td>
								<td>{{$d->date }}</td>
 								<td class="text-center">
									<div class="list-icons">
										<div class="dropdown">
											<a href="#" class="list-icons-item" data-toggle="dropdown">
												<i class="icon-menu9"></i>
											</a>

											<div class="dropdown-menu dropdown-menu-right">
<!--												<a href="--><?php //echo site_url('AttendenceFixed/view/'.$d->id); ?><!--" class="dropdown-item"><i class="icon-pencil3"></i> View</a>-->
												<a href="<?php echo site_url('AttendenceFixed/edit/'.$d->id); ?>" class="dropdown-item"><i class="icon-pencil3"></i> Edit</a>
<!--												<a href="--><?php //echo site_url('AttendenceFixed/delete/'.$d->id); ?><!--" onclick="return confirm('Are you sure you want to delete this?')" class="dropdown-item"><i class="icon-trash"></i> Delete</a>-->
											</div>
										</div>
									</div>
								</td>
							</tr>
							<?php }} ?>
						</tbody>
					</table>
				</div>
				<!-- /basic datatable -->

			</div>
			<!-- /content area -->

		</div>
		<!-- /main content -->

@endsection

