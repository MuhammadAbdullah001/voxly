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
					<h4><span class="font-weight-semibold">Contact Us</span> - Main</h4>
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



				<table class="table datatable-basic table-responsive table-bordered">
					<thead>
					<tr>
						<th>#</th>
 						<th> Name/Admission no</th>
{{--						<th>Email</th>--}}
{{-- 						<th>Contact Number</th>--}}
						<th>Subject</th>
						<th>Message</th>
						<th>Date</th>
						<th>Status</th>
 					</tr>
					</thead>
					<tbody>
                    <?php if(isset($data['contactUs']) && count($data['contactUs'])>0){ foreach($data['contactUs']  as $d){ ?>
					<tr <?php if (isset($d->is_update) && $d->is_update == 1){ ?> class="bg bg-success" <?php } ?>>
 						<td>{{$d->id }}</td>
						<td>{{$d->name }}</td>
{{--						<td>{{$d->email }}</td>--}}
{{--						<td>{{$d->contact_number}}</td>--}}

 						<td>{{$d->subject}} </td>
 						<td>

							<textarea placeholder="Enter Your Remarks Here" class="form-control" name=" remarks" id=" remarks" rows="3" cols="50" value="">{{$d->message}}</textarea>

						</td>
 						<td>{{ date('Y-m-d',strtotime( $d->created_at)) }} </td>
						<td <?php if ($d->status == "resolved"){ ?>  style="background-color: aqua;"  <?php } ?>>
                            <?php if ($d->status == "resolved"){ ?>

							<select style="opacity: initial; height: auto;" name="status" disabled class="form-control form-control-select2" data-id= "<?php echo $d->id;?>" id="contact-us-status">
                                <?php		}else{ ?>
								<select style="opacity: initial; height: auto;" name="status"  class="form-control form-control-select2" data-id= "<?php echo $d->id;?>" id="contact-us-status">

                                    <?php }?>
									<option <?php if($d->status == ""){ echo "selected"; }?> value="">Please Select</option>
									<option <?php if($d->status == "active"){ echo "selected"; }?> value="active">Active</option>
									<option <?php if($d->status == "resolved"){ echo "selected"; }?>  value="resolved">Resolved</option>

								</select>

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

