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


				<table id="staff-table" style="width:100%" class="table table-responsive table-bordered">
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
						<th>Resigning Date</th>
 						<th class="text-center">Actions</th>
					</tr>
					</thead>
				</table>
			</div>
			<!-- /basic datatable -->

		</div>
		<!-- /content area -->

	</div>
	<!-- /main content -->

@endsection
@push('footer-scripts')
<script>
	$('#staff-table').DataTable({
  processing: true,
  serverSide: true,
  ajax: {
   url: "staff",
  },
  columnDefs: [{
    "defaultContent": "-",
    "targets": "_all"
  }],
  columns: [
   {
    data: 'id',
    name: 'id'
   },
   {
    data: 'name',
    name: 'name'
   },
   {
    data: 'email',
    name: 'email',
   },				
      {
    data: 'assigned_group',
    name: 'assigned_group'
   },
       			
      {
    data: 'subjects_name',
    name: 'subjects_name'
   },
   {
    data: 'contact_number',
    name: 'contact_number'
   },
   
   {
    data: 'address',
    name: 'address'
   },
   {
    data: 'status_select',
    name: 'status_select'
   },
   
   {
    data: 'type',
    name: 'type'
   },
   
   {
    data: 'assigned_role',
    name: 'assigned_role'
   },
   {
    data: 'per_hour_rate',
    name: 'per_hour_rate'
   },
   
   {
    data: 'daily_working_hours',
    name: 'daily_working_hours'
   },
   
   {
    data: 'pay',
    name: 'pay'
   },
   
   {
    data: 'comments',
    name: 'comments'
   },
   
   {
    data: 'joining_date',
    name: 'joining_date'
   },
   
   {
    data: 'resigning_date',
    name: 'resigning_date'
   },
   {
	data:'actions',
	name:'actions',
	orderable:false,
	searchable:false,
   }
  ]

 });
 $('#staff-table').on('draw.dt', function() {
            $('.form-control-select2').select2();
        });
</script>
@endpush

