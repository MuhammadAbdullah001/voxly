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
					<h4><span class="font-weight-semibold">Staff Salary Expected</span> - Main</h4>
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

				</div>


				<table class="table datatable-basic-desc table-responsive table-bordered">
					<thead>
					<tr>
						<th>#</th>
						<th>Name</th>
						<th>Assigned Subjects</th>
						<th>Assigned Groups</th>
 						<th>Per Hour Rate</th>
						<th>Daily Working Hours</th>
						<th>Outstanding Salary By Attendance</th>
						<th>Outstanding Salary days</th>
						<th>Contact No</th>
						<th>Type</th>
						<th>Status</th>
 						<th>Joining Date</th>
 					</tr>
					</thead>
					<tbody>
                    <?php if(isset($data['teachers']) && count($data['teachers'])>0){ foreach($data['teachers']  as $d){ ?>
					<tr <?php if (isset($d->is_resigned) && $d->is_resigned == 1){ ?> class="bg bg-warning" <?php } ?>>
 						<td>{{$d->id }}</td>
						<td>{{$d->name }}</td>
						<td>{{$d->assignedSubjects['subjects_name'] }}</td>
						<td>{{$d->assignedSubjects['assigned_group'] }}</td>
 						<td>{{$d->per_hour_rate }} </td>
 						<td>{{$d->daily_working_hours }} </td>
 						<td class="bg bg-warning">
                            @if(isset($d->expected_salary) && $d->expected_salary >0)
                            {{$d->expected_salary }}
                            @else
                                {{ 0  }}
                            @endif
                        </td>
 						<td class="bg bg-warning">
                            @if(isset($d->expected_salary) && $d->expected_salary >0)
                            {{$d->expected_salary_duration }}
                            @else
                                {{ "No Attendance"  }}
                            @endif
                        </td>
                        <td >{{$d->contact_number }}</td>
                        <td>{{$d->type }} </td>
  						<td><?php
                            if ($d->is_resigned == 1){
                                echo 'Resigned';
                            }else{
                                echo 'Active';
                            }
                            ?> </td>
  						<td>{{$d->joining_date }} </td>

                         <?php

                        //                                $start = explode(':',$d->time_start);
                        //                                $start_h =$start[0];
                        //                                $end = explode(':',$d->time_end);
                        //                                $end_h =$end[0];
                        //                                  $wh = $end_h - $start_h;

                        ?>

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

