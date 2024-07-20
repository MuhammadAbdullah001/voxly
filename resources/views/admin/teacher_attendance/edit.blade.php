@extends('layouts.admin.master')

@section('content')
    <!-- Main content -->
    <div class="content-wrapper">

        <!-- Page header -->
        <div class="page-header page-header-light">
            <div class="page-header-content header-elements-md-inline">
                <div class="page-title d-flex">
                    <h4><span class="font-weight-semibold">Attendance</span> - Edit</h4>
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

            <div class="card">
                <div class="card-header header-elements-inline">
                    <h5 class="card-title">Edit Attendance (Teacher)</h5>

                </div>

                <div class="card-body">
                    <?php
                    if (isset($data['attendance']) && !empty($data['attendance'])){
                    $d = $data['attendance'];
                    //                    print_r($data['student_admissions']);
                    ?>
                    <form action="{{url('admin/teacher-attendance/edit')}}" method="post">
                        @csrf
                        <input type="hidden" name="id" value="<?php echo $d->id;?>">

                        <fieldset class="mb-3">
                            <legend class="text-uppercase font-size-sm font-weight-bold">Edit</legend>

                            <div class="form-group row">
                                <label class="col-form-label col-lg-2">Date</label>
                                <div class="col-lg-10">
                                    <div class="input-group">
                                        <input type="text" readonly name="date" value="<?php  echo $d->date; ?>" id="date" placeholder="Select Date" class=" form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-form-label col-lg-2"> Teacher</label>
                                <div class="col-lg-10">
                                    <div class="input-group">
                                        <select   class="form-control select" name="staff_teacher_id" id=" ">



                                            <option selected value="<?php  echo $d->id; ?>"><?php   echo $d->teacher->name; ?> </option>



                                        </select>
                                    </div>
                                </div>
                            </div>



                            <div class="form-group row">
                                <label class="col-form-label col-lg-2">Time Start</label>
                                <div class="col-lg-4">
                                    <div class="input-group">

                                        <?php
                                        $time_start  = date('h:i',strtotime($d->start_time));
                                        if (isset($d->start_time) && !empty($d->start_time) && $d->start_time != '00:00:00'){

                                        ?>
                                        <input type="text" name="start_time" class="form-control " id="anytime-time-start" placeholder="--Please Select--"  value="<?= $time_start; ?>" >

                                        <?php    }else{ ?>
                                        <input type="text" name="start_time" class="form-control " id="anytime-time-start" placeholder="--Please Select--"    >

                                        <?php     }
                                        ?>

                                    </div>
                                </div>
                                <label class="col-form-label col-lg-2 text-center">Time End</label>
                                <div class="col-lg-4">
                                    <div class="input-group">

                                        <?php
                                        $end_start  = date('h:i',strtotime($d->end_time));
                                        if (isset($d->start_time) && !empty($d->start_time) && $d->start_time != '00:00:00'){

                                        ?>
                                        <input type="text" name="end_time" class="form-control " id="anytime-time-end" placeholder="--Please Select--"  value="<?= $end_start; ?>" >

                                        <?php    }else{ ?>
                                        <input type="text" name="end_time" class="form-control " id="anytime-time-end" placeholder="--Please Select--"    >

                                        <?php     }
                                        ?>


                                    </div>
                                </div>


                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-lg-2">Description</label>
                                <div class="col-lg-10">
                                    <div class="input-group">
                                        <input type="text" name="description" class="form-control" id="" placeholder="--Enter Description Here--" value="<?= $d->description; ?> ">

                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-4 col-md-offset-8">
                                    <button class="btn btn-primary" type="submit">Save</button>
                                </div>
                            </div>

                        </fieldset>

                    </form>

                        <?php }else {
                            echo "An Error Occured While Processing";
                        }
                        ?>

                </div>
            </div>
            <!-- /input group addons -->

        </div>

        <!-- /content area -->
        @include('layouts.footer')

    </div>

    <!-- /main content -->

@endsection



