@extends('layouts.admin.master')

@section('content')
    <!-- Main content -->
    <div class="content-wrapper">

        <!-- Page header -->
        <div class="page-header page-header-light">
            <div class="page-header-content header-elements-md-inline">
                <div class="page-title d-flex">
                    <h4><span class="font-weight-semibold">Attendance</span> - Add</h4>
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
         <!-- Input group addons -->
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
             <?php if(!empty($errors->all()) && $errors->all()){ ?>
             <div class="row">
                 <div class="col-md-12">
                     <div class="alert alert-danger alert-styled-left alert-dismissible">


                         <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                         @foreach ($errors->all() as $error)

                             <span class="font-weight-semibold">Oh snap!</span> {{ $error }}
                             <br>
                         @endforeach


                     </div>
                 </div>

             </div>
             <?php } ?>

             <div class="card">
                <div class="card-header header-elements-inline">
                    <h5 class="card-title">Add New Attendance (Student)</h5>

                </div>

                <div class="card-body">

                    <form action="{{url('admin/attendance/add')}}" method="post">
                        @csrf
                        <fieldset class="mb-3">
                            <legend class="text-uppercase font-size-sm font-weight-bold">Add</legend>

                            <div class="form-group required row">
                                <label class="col-form-label col-lg-2 control-label">Date</label>
                                <div class="col-lg-10">
                                    <div class="input-group">
                                        <input type="text" name="date" id="student_attendance_date" placeholder="Select Date" class="pickadate-limits-attendance form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group required row">
                                <label class="col-form-label col-lg-2 control-label">Admission No</label>
                                <div class="col-lg-10">
                                    <div class="input-group">
                                        <select   required  class="form-control  js-example-tags " name="admission_no" id="admission_attendance">
                                            <option value="">--- Select ---</option>

                                        <?php
                                           if( isset($data['admissions']) && !empty($data['admissions'])){
                                                foreach ($data['admissions'] as $admission){ ?>
                                            <option value="<?php  echo $admission->admission_no; ?>"><?php echo $admission->admission_no.' - '; echo $admission->parent_name; ?> </option>

                                        <?php }
                                            }

                                            ?>


                                        </select>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group required row">
                                <label class="col-form-label col-lg-2 control-label">Student</label>
                                <div class="col-lg-10">
                                    <div class="input-group">
                                        <select required class="js-example-basic-single form-control js-example-theme-single select" id="student_list" name="student_admissions_id">
                                            <option value = "">--Please Select--</option>

                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-form-label col-lg-2">Time Start</label>
                                <div class="col-lg-4">
                                    <div class="input-group">
                                        <input  type="text" name="start_time" class="form-control start_time_student" id="anytime-time-start" placeholder="--Please Select--"  >
                                    </div>
                                </div>
                                <label class="col-form-label col-lg-2 text-center">Time End</label>
                                <div class="col-lg-4">
                                    <div class="input-group">



                                        <input  type="text" name="end_time" class="form-control anytime-time end_time_student" id="anytime-time-end" placeholder="--Please Select--"  >


                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-form-label col-lg-2">Description</label>
                                <div class="col-lg-10">
                                    <div class="input-group">
                                        <input type="text" name="description" class="form-control" id="" placeholder="--Enter Description Here--" >

                                    </div>
                                </div>
                            </div>





                            <div class="row">
                                <div class="col-md-4 col-md-offset-8">
                                    <button class="btn btn-primary attendance_submit_student" type="submit">Save</button>
                                </div>
                            </div>

                        </fieldset>

                    </form>
                </div>
            </div>
            <!-- /input group addons -->

        </div>

        <!-- /content area -->
        @include('layouts.footer')

    </div>

    <!-- /main content -->

@endsection



