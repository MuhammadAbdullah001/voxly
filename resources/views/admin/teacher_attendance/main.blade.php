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
						<h4><span class="font-weight-semibold">Attendance</span> - Main(Teacher)</h4>
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


			<!-- Basic datatable -->
				<div class="card">
					<div class="card-header header-elements-inline">
						<h5 class="card-title">All Attendance</h5>
                        <div class="header-elements">
                            <a href="{{asset('/admin/teacher-attendance/add')}}" class="btn btn-primary legitRipple">Add New</a>
                        </div>
					</div>


                    <table id="attendance-table" class="table table-bordered">
						<thead>
							<tr>
								<th>#</th>
								<th>Teacher Name</th>
								<th>Date</th>
								<th>Time Start</th>
								<th>Time End</th>
 								<th>Updated By</th>
								<th>Description</th>
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
	$('#attendance-table').DataTable({
  processing: true,
  serverSide: true,
  ajax: {
   url: "teacher-attendance",
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
    data: 'date',
    name: 'date',
   },
      {
    data: 'start_time',
    name: 'start_time'
   },
      {
    data: 'end_time',
    name: 'end_time'
   },
      {
    data: 'updated_by',
    name: 'updated_by'
   },
   {
    data: 'description',
    name: 'description'
   },
   {
	data:'actions',
	name:'actions',
	orderable:false,
	searchable:false,
   }
  ]

 });
</script>
@endpush


