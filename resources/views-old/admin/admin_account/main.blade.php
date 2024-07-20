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
					<h4><span class="font-weight-semibold">Super Admin Account</span> - Main</h4>
					<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
				</div>

{{--				<div class="header-elements d-none">--}}
{{--					<div class="d-flex justify-content-center">--}}
{{--						<a href="{{asset('/admin/booking')}}" class="btn btn-link btn-float font-size-sm font-weight-semibold text-default">--}}
{{--							<i class="icon-store text-pink-300"></i>--}}
{{--							<span>Inventory</span>--}}
{{--						</a>--}}
{{--						<a href="{{asset('/admin/booking')}}" class="btn btn-link btn-float font-size-sm font-weight-semibold text-default">--}}
{{--							<i class="icon-paypal2 text-pink-300"></i>--}}
{{--							<span>Payment</span>--}}
{{--						</a>--}}
{{--						<a href="{{asset('/admin/booking')}}" class="btn btn-link btn-float font-size-sm font-weight-semibold text-default">--}}
{{--							<i class="icon-alarm text-pink-300"></i>--}}
{{--							<span>Timesheet</span>--}}
{{--						</a>--}}
{{--					</div>--}}
{{--				</div>--}}
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
					<h5 class="card-title">All Admin Accounts</h5>
					<div class="header-elements">
						<a href="{{asset('/admin/account/add')}}" class="btn btn-primary legitRipple">Add New</a>
					</div>
				</div>


				<table class="table datatable-basic table-responsive table-bordered">
					<thead>
					<tr>
						<th>#</th>
 						<th> Name</th>
						<th>Email</th>
						<th>Type</th>
						<th>Status</th>
						<th>Address</th>
						<th>Contact Number</th>
						<th>Cnic</th>
						<th>DOB</th>
						<th>Registration Date</th>
						<th class="text-center">Actions</th>
					</tr>
					</thead>
					<tbody>
                    <?php if(isset($data['admin_accounts']) && count($data['admin_accounts'])>0){ foreach($data['admin_accounts']  as $d){ ?>
					<tr <?php if (isset($d->status) && $d->status == 0){ ?> class="bg bg-warning" <?php } ?>>
 						<td>{{$d->id }}</td>
						<td>{{$d->name }}</td>
						<td>{{$d->email }}</td>
						<td>{{$d->type}}</td>
 						<td>
							<?php if (auth()->user()->id == $d->id){ ?>

							<select style="opacity: initial; height: auto;" name="status" disabled class="form-control form-control-select2" data-id= "<?php echo $d->id;?>" id="admin-status">
						<?php		}else{ ?>
							<select style="opacity: initial; height: auto;" name="status"  class="form-control form-control-select2" data-id= "<?php echo $d->id;?>" id="admin-status">

							<?php }?>
								<option <?php if($d->status == ""){ echo "selected"; }?> value="">Please Select</option>
								<option <?php if($d->status == "1"){ echo "selected"; }?> value="1">Active</option>
								<option <?php if($d->status == "0"){ echo "selected"; }?>  value="0">Not Active</option>

							</select>

						</td>
 						<td>{{$d->address}} </td>
 						<td>{{$d->contact_number}} </td>
 						<td>{{$d->cnic}} </td>
 						<td>{{$d->dob_day.'-'.$d->dob_month.'-'.$d->dob_year}} </td>
						<td>{{date('M-d-Y',strtotime($d->created_at))}} </td>

						<td class="text-center">
							<div class="list-icons">
								<div class="dropdown">
									<a href="#" class="list-icons-item" data-toggle="dropdown">
										<i class="icon-menu9"></i>
									</a>

									<div class="dropdown-menu dropdown-menu-right">
										<!--												<a href="--><?php //echo site_url('AttendenceFixed/view/'.$d->id); ?><!--" class="dropdown-item"><i class="icon-pencil3"></i> View</a>-->
										<a href="<?php echo url('admin/account/edit/'.$d->id); ?>" class="dropdown-item"><i class="icon-pencil3"></i> Edit</a>
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

