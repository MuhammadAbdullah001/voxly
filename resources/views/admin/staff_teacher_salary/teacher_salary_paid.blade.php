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
					<h4><span class="font-weight-semibold">Teacher Salary  </span> - Paid</h4>
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
					<h5 class="card-title">Salary Paid</h5>
{{--					<div class="header-elements">--}}
{{--						<a href="{{asset('/admin/teacher-salary/add')}}" class="btn btn-primary legitRipple">Add New</a>--}}
{{--					</div>--}}
				</div>


				<table id="staff-salary" style="width:100%" class="table table-responsive table-bordered">
					<thead>
					<tr>
						<th>#</th>
						<th>Teacher Name</th>
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
	$('#staff-salary').DataTable({
  processing: true,
  serverSide: true,
  ajax: {
   url: "teacher-salary-paid",
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
    data: 'teacher.name',
    name: 'teacher.name'
   },			
				
   {
    data: 'salary_from_date',
    name: 'salary_from_date',
   },				
      {
    data: 'salary_to_date',
    name: 'salary_to_date'
   },
       			
      {
    data: 'entry_date',
    name: 'entry_date'
   },
   {
    data: 'paid_duration',
    name: 'paid_duration'
   },
   {
    data: 'per_hour_rate',
    name: 'per_hour_rate'
   },
   {
    data: 'working_hours',
    name: 'working_hours'
   },
   {
    data: 'payment_type',
    name: 'payment_type'
   },
   
   {
    data: 'expected_amount',
    name: 'expected_amount'
   },
   {
    data: 'amount_taken',
    name: 'amount_taken'
   },
   
   {
    data: 'status',
    name: 'status'
   },
   
   {
    data: 'description',
    name: 'description'
   },
  ]

 });
 $('#staff-salary').on('draw.dt', function() {
            $('.form-control-select2').select2();
        });
</script>
@endpush

