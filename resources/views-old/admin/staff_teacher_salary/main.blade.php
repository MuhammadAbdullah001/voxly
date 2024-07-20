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
					<h4><span class="font-weight-semibold">Teacher Salary  </span> - Unpaid</h4>
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

{{--			<div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">--}}
{{--				<div class="d-flex">--}}
{{--					<div class="breadcrumb">--}}
{{--						<a href="{{asset('/admin/booking')}}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Dashboard</a>--}}
{{--						<span class="breadcrumb-item active">Groups</span>--}}
{{--					</div>--}}

{{--					<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>--}}
{{--				</div>--}}
{{--			</div>--}}
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

		<!-- Basic datatable -->
			<div class="card">
				<div class="card-header header-elements-inline">
					<h5 class="card-title">Salary Unpaid</h5>
					<div class="header-elements">
						<a href="{{asset('/admin/teacher-salary/add')}}" class="btn btn-primary legitRipple">Add New</a>
					</div>
				</div>


				<table class="table datatable-basic-desc table table-responsive table-bordered">
					<thead>
					<tr>
						<th>#</th>
 						<th>Staff Salary</th>
						<th>Salary From Date</th>
						<th>Salary To Date</th>
						<th>Salary Entry Date</th>
						<th>Paid Duration</th>
						<th>Agreed Salary/hr</th>
						<th>Agreed hrs</th>
						<th>Payment Type</th>
						<th>Expected Salary</th>
						<th>Salary Taken</th>
 						<th>Status</th>
						<th>description</th>
 						<th class="text-center">Actions</th>
					</tr>
					</thead>
					<tbody>
                    <?php if(isset($data['staff_salary']) && count($data['staff_salary'])>0){ foreach($data['staff_salary']  as $d){ ?>
					<tr <?php if (isset($d->is_update) && $d->is_update == 1){ ?> class="bg bg-warning" <?php } ?>>
						<td>{{$d->id }}</td>
 						<td>{{$d->teacher->name }}</td>
						<td>{{$d->salary_from_date }}</td>
						<td>{{$d->salary_to_date }}</td>
						<td>{{$d->entry_date }}</td>
						<td>{{$d->paid_duration }}</td>
						<td>{{$d->per_hour_rate }}</td>
						<td>{{$d->working_hours }}</td>
						<td> {{ strtoupper(str_replace('_',' ',$d->payment_type)) }}</td>
						<td>{{ number_format($d->expected_amount,0) }}</td>
 						<td>{{ number_format($d->amount_taken,0) }}</td>
						<td>

							<select style="opacity: initial; height: auto;" name="fee_status" class="form-control form-control-select2" data-id= "<?php echo $d->id;?>" id="salary-status">
								<option <?php if($d->status == ""){ echo "selected"; }?> value="">Please Select</option>
								<option <?php if($d->status == "paid"){ echo "selected"; }?> value="paid">Paid</option>
								<option <?php if($d->status == "unpaid"){ echo "selected"; }?>  value="unpaid">Un-Paid</option>

							</select>
							 </td>
						<td><textarea>{{  $d->description }}</textarea></td>

						<td class="text-center">
							<div class="list-icons">
								<div class="dropdown">
									<a href="#" class="list-icons-item" data-toggle="dropdown">
										<i class="icon-menu9"></i>
									</a>

									<div class="dropdown-menu dropdown-menu-right">
										<!--												<a href="--><?php //echo site_url('AttendenceFixed/view/'.$d->id); ?><!--" class="dropdown-item"><i class="icon-pencil3"></i> View</a>-->
										<a href="<?php echo url('admin/teacher-salary/edit/'.$d->id); ?>" class="dropdown-item"><i class="icon-pencil3"></i> Edit</a>
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

