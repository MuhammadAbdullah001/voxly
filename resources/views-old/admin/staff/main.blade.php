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
					<h4><span class="font-weight-semibold">Staff</span> - Main</h4>
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

			<div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
				{{--				<div class="d-flex">--}}
{{--					<div class="breadcrumb">--}}
{{--						<a href="{{asset('/admin/booking')}}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Dashboard</a>--}}
{{--						<span class="breadcrumb-item active">Record Attendance</span>--}}
{{--					</div>--}}

{{--					<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>--}}
{{--				</div>--}}
			</div>
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

		<!-- Basic datatable -->
			<div class="card">
				<div class="card-header header-elements-inline">
					<h5 class="card-title">All Staff/Teachers</h5>
					<div class="header-elements">
						<a href="{{asset('/admin/staff/add')}}" class="btn btn-primary legitRipple">Add New</a>
					</div>
				</div>


				<table class="table datatable-basic table-responsive table-bordered">
					<thead>
					<tr>
						<th>#</th>
						<th>Name</th>
                        <th>Email</th>
                        <th>Assigned Groups</th>
						<th>Assigned Subjects</th>


						<th>Contact No</th>
						<th>Address</th>
						<th>Status</th>
						<th>Type</th>
						<th>Roll Assigned</th>
						<th>Per Hour Rate</th>
						<th>Daily Working Hours</th>
						<th>Salary</th>
						<th>Comments</th>
						<th>Joining Date</th>
						<th>Address</th>
						<th>Resigning Date</th>
 						<th class="text-center">Actions</th>
					</tr>
					</thead>
					<tbody>
                    <?php if(isset($data['staff_register']) && count($data['staff_register'])>0){ foreach($data['staff_register']  as $d){ ?>
					<tr <?php if (isset($d->is_resigned) && $d->is_resigned == 1){ ?> class="bg bg-warning" <?php } ?>>
 						<td>{{$d->id }}</td>
						<td>{{$d->name }}</td>
                        <td>{{$d->email }}</td>
                        <td>{{$d->assignedSubjects['assigned_group'] }}</td>

                        <td>{{$d->assignedSubjects['subjects_name'] }}</td>

						<td>{{$d->contact_number }}</td>
 						<td>{{$d->address }} </td>
						<td>
							<select style="opacity: initial; height: auto;" name="status" class="teacher-status form-control form-control-select2" data-placeholder="Select Status"  data-id= "<?php echo $d->id;?>"  >
 								<option <?php if($d->is_resigned == "0"){ echo "selected"; }?> value="0">Active</option>
								<option <?php if($d->is_resigned == "1"){ echo "selected"; }?>  value="1">Resigned</option>

							</select>

						</td>
						<td>{{$d->type }} </td>

						<td <?php if ($d->user->user_role == "super_admin"){ ?> class ="badge badge-danger"   <?php } ?>>
							<?php if ($d->is_resigned == 0){ ?>
							<select style="opacity: initial; height: auto;" name="status" class="form-control form-control-select2" data-user_id= "<?php echo $d->user_id;?>" id="teacher-roll-assigned">
								<?php
								}else{ ?>
									<select style="opacity: initial; height: auto;" disabled name="status" class="form-control form-control-select2" data-user_id= "<?php echo $d->user_id;?>" id="teacher-roll-assigned">

									<?php	} ?>
								{{--<option <?php if($d->user->user_role == ""){ echo "selected"; }?> value="">Please Select</option>--}}
								<option <?php if($d->user->user_role == "teacher"){ echo "selected"; }?> value="teacher">Teacher</option>
								<option class="bg badge-primary" <?php if($d->user->user_role== "super_admin"){ echo "selected"; }?>  value="super_admin">Super Admin</option>

							</select>

						</td>
 						<td>{{$d->per_hour_rate }} </td>
 						<td>{{$d->daily_working_hours }} </td>
 						<td>{{$d->pay }} </td>
 						<td>{{$d->comments }} </td>
 						<td>{{$d->joining_date }} </td>
 						<td>{{$d->address }} </td>
 						<td>@if($d->is_resigned == 1) {{  $d->resigning_date  }} @endif </td>

                         <?php

                        //                                $start = explode(':',$d->time_start);
                        //                                $start_h =$start[0];
                        //                                $end = explode(':',$d->time_end);
                        //                                $end_h =$end[0];
                        //                                  $wh = $end_h - $start_h;

                        ?>
 						<td class="text-center">
							<div class="list-icons">
								<div class="dropdown">
									<a href="#" class="list-icons-item" data-toggle="dropdown">
										<i class="icon-menu9"></i>
									</a>

									<div class="dropdown-menu dropdown-menu-right">
										<!--												<a href="--><?php //echo site_url('AttendenceFixed/view/'.$d->id); ?><!--" class="dropdown-item"><i class="icon-pencil3"></i> View</a>-->
										<a href="<?php echo url('admin/staff/edit/'.$d->id); ?>" class="dropdown-item"><i class="icon-pencil3"></i> Edit</a>
										<a href="<?php echo url('admin/staff/assign-subjects/'.$d->id); ?>" class="dropdown-item"><i class="icon-book2"></i>Assign Subjects</a>
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

