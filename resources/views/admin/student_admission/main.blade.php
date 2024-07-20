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
					<h4><span class="font-weight-semibold">Admission</span> - Main</h4>
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
					<h5 class="card-title">All Admissions</h5>
					<div class="header-elements">
						<a href="{{asset('/admin/admission/add')}}" class="btn btn-primary legitRipple">Add New</a>
					</div>
				</div>


				<table id="admission-table" style="width:100%" class="table table-responsive table-bordered">
					<thead>
					<tr>
						<th>#</th>
						<th>Admission No</th>
						<th>Parent Name</th>
						<th>Email</th>
						<th>Contact Number</th>
						<th>Status</th>
						<th>Remarks</th>
						<th>Address</th>

                        <th>Class Mode</th>
                        <th>Post Code</th>
                        <th>Landline No</th>
                        <th>Referred By</th>
                        <th>Relation</th>
                        <th>Emergency Contact No.</th>

						<th>Projected Revenue</th>
						<th>Child Care</th>
						<th>Registration Date</th>
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
	$('#admission-table').DataTable({
  processing: true,
  serverSide: true,
  ajax: {
   url: "admission",
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
    data: 'admission_no',
    name: 'admission_no'
   },
   {
    data: 'parent_name',
    name: 'parent_name',
   },
      {
    data: 'email',
    name: 'email'
   },
      {
    data: 'contact_number',
    name: 'contact_number'
   },
   {
    data: 'status_select',
    name: 'status_select'
   },
   
   {
    data: 'remarks',
    name: 'remarks'
   },
   
   {
    data: 'address',
    name: 'address'
   },
   
   {
    data: 'class_mode',
    name: 'class_mode'
   },
   
   {
    data: 'post_code',
    name: 'post_code'
   },
   
   {
    data: 'landline_no',
    name: 'landline_no'
   },
   
   {
    data: 'referred_by',
    name: 'referred_by'
   },
   
   {
    data: 'relation',
    name: 'relation'
   },
   
   {
    data: 'emergency_contact_no',
    name: 'emergency_contact_no'
   },
   {
    data: 'project_revenue',
    name: 'project_revenue'
   },
   
   {
    data: 'is_child_care',
    name: 'is_child_care'
   },
   

   
   {
	data:'actions',
	name:'actions',
	orderable:false,
	searchable:false,
   }
  ]

 });
 $('#admission-table').on('draw.dt', function() {
            $('.form-control-select2').select2();
        });
</script>
@endpush

