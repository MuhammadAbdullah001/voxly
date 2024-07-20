@extends('layouts.admin.master')

@section('content')
    <!-- Main content -->
    <div class="content-wrapper">

        <!-- Page header -->
        <div class="page-header page-header-light">
            <div class="page-header-content header-elements-md-inline">
                <div class="page-title d-flex">
                    <h4><span class="font-weight-semibold">Staff/Teacher</span> - Add</h4>
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

{{--            <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">--}}
{{--                <div class="d-flex">--}}
{{--                    <div class="breadcrumb">--}}
{{--                        <a href="{{asset('/admin/booking')}}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Dashboard</a>--}}
{{--                        <span class="breadcrumb-item active">Record Attendance</span>--}}
{{--                    </div>--}}

{{--                    <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>--}}
{{--                </div>--}}
{{--            </div>--}}
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

            <div class="card">
                <div class="card-header">
                    <div class="header-elements-inline">
                        <h4 class="card-title">Assign Teacher's Subject </h4>
                    </div>
                </div>
                <hr>

                <div class="card-body">

                    <form action="{{url('admin/staff/assign-subjects')}}" method="post">
                        @csrf

                       <input type="hidden" name="id" value="<?= $data['staff']->id; ?>">
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label"> Subjects:</label>
                            <div class="col-lg-10">
                                <div class="input-group">
                                    <select style="" id="" class="multiselect" name="subject_id[]" multiple="multiple"
                                            data-placeholder="Select Subjects">

                                        <?php if (isset($data['subjects']) && count($data['subjects']) > 0) { foreach ($data['subjects'] as $subject) { ?>

                                        <option id="subject<?php echo $subject->id ?>"  <?php if (isset($subject->selected)) echo "selected"; ?>
                                        value="<?= $subject->id .'/' . $subject->name.'/' . $subject->group->name.'/' . $subject->group->id;  ?>"><?php echo $subject->group->name . ' - ' . $subject->name; ?></option>
                                        <?php } } ?>
                                    </select></div>
                            </div>
                        </div>


                        <div class="mt-5 mb-2 d-md-flex  justify-content-md-between flex-md-wrap">
                             <button type="submit" id="" class="btn bg-primary d-flex align-items-center">
                                Submit <i class="icon-paperplane ml-2"></i> </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
        <!-- /content area -->
        @include('layouts.footer')

    </div>

    <!-- /main content -->

@endsection
