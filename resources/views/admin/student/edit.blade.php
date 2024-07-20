@extends('layouts.admin.master')

@section('content')
    <!-- Main content -->
    <div class="content-wrapper">

        <!-- Page header -->
        <div class="page-header page-header-light">
            <div class="page-header-content header-elements-md-inline">
                <div class="page-title d-flex">
                    <h4><span class="font-weight-semibold">Student</span> - Edit</h4>
                    <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
                </div>

                <div class="header-elements d-none">
                    <div class="d-flex justify-content-center">
                        <a href="{{asset('/admin/booking')}}"
                           class="btn btn-link btn-float font-size-sm font-weight-semibold text-default">
                            <i class="icon-store text-pink-300"></i>
                            <span>Inventory</span>
                        </a>
                        <a href="{{asset('/admin/booking')}}"
                           class="btn btn-link btn-float font-size-sm font-weight-semibold text-default">
                            <i class="icon-paypal2 text-pink-300"></i>
                            <span>Payment</span>
                        </a>
                        <a href="{{asset('/admin/booking')}}"
                           class="btn btn-link btn-float font-size-sm font-weight-semibold text-default">
                            <i class="icon-alarm text-pink-300"></i>
                            <span>Timesheet</span>
                        </a>
                    </div>
                </div>
            </div>

{{--            <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">--}}
{{--                <div class="d-flex">--}}
{{--                    <div class="breadcrumb">--}}
{{--                        <a href="{{asset('/admin/booking')}}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i>--}}
{{--                            Dashboard</a>--}}
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
                <div class="card-header">
                    <div class="header-elements-inline">
                        <h4 class="card-title">Edit Student</h4>
                    </div>
                </div>
                <hr>

                <div class="card-body">
                    <?php
                    if (isset($data['student_edit']) && !empty($data['student_edit'])){
                    $d = $data['student_edit'];
                    //                    print_r($data['student_admissions']);
                    ?>

                    <form action="{{url('admin/student/edit')}}" method="post">
                        @csrf
                       <input type="hidden" name="id" value="<?php echo $d->id;?>">
                       <input type="hidden" name="admission_no" value="<?php echo $d->admission_no;?>">
                       <input type="hidden" name="group_id" value="<?php echo $d->group_id;?>">
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Admission No:</label>
                            <div class="col-md-10">
                                <select id="admission_no" name="admission_no" disabled
                                        data-placeholder="Select Admission No" class="form-control form-control-select2"
                                        data-fouc>
                                    @if(isset($data['student_admissions']))
                                        <option value="">Please Select Admission No</option>

                                        @foreach($data['student_admissions'] as $user)

                                            <option <?php if ($d->admission_no == $user->admission_no) {
                                                echo "selected";
                                            } ?> value="{{$user->admission_no}}">{{$user->admission_no}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Student Name:</label>
                            <div class="col-md-10">
                                <input type="text" value="<?= $d->student_name ?>" id="student_name" name="student_name" class="form-control"
                                       placeholder="Enter Student Name" required>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Student Group:</label>
                            <div class="col-md-10">
                                <select id="group_id_change" name="group_id"  data-placeholder="Select Student Group"
                                        class="form-control form-control-select2" data-fouc>
                                    @if(isset($data['groups']))
                                        <option value="">Please Select Student Group</option>

                                        @foreach($data['groups'] as $group)
                                            <option <?php if ($d->group_id == $group->id) { echo "selected";  } ?> value="{{$group->id}}">{{$group->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Student Subjects:</label>
                            <div class="col-lg-10">
                                <div class="input-group">
                                    <select style="" id="student_subjects" class="form-control-select2" name="subject_id[]" multiple="multiple" data-placeholder="Select Student Subjects">
                                        <?php
                                         if (isset($data['subjects']) && count($data['subjects']) > 0) { foreach ($data['subjects'] as $subject) { ?>

                                            <option id="subject<?php echo $subject->id ?>" <?php if (isset($subject->selected)) echo "selected"; ?>
                                                    value="<?= $subject->id . '/' . $subject->name ?>"><?= $subject->name; ?></option>
                                        <?php } } ?>
                                    </select></div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">School Name:</label>
                            <div class="col-md-10">
                                <input type="text" value="<?= $d->school_name ?>" id="school_name" name="school_name" class="form-control"
                                       placeholder="Enter School Name" required>
                            </div>
                        </div>



                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Package Type:</label>
                            <div class="col-md-10">
                                <select id="package_type" name="package_type" data-placeholder="Select Package Type"   class="form-control form-control-select2" data-fouc>
                                    <option value="">Please Select</option>
                                    <option <?php if ($d->package_type == "weekly") { echo "selected";  } ?> value="weekly">Weekly</option>
                                    <option <?php if ($d->package_type == "bi_weekly") { echo "selected";  } ?> value="bi_weekly">Bi-Weekly</option>
                                    <option <?php if ($d->package_type == "tri_weekly") { echo "selected";  } ?> value="tri_weekly">Tri-Weekly</option>
                                    <option <?php if ($d->package_type == "monthly") { echo "selected";  } ?> value="monthly">Monthly</option>

                                </select>
                            </div>
                        </div>

                        <div class="form-group row  ">
                            <label class="col-md-2 col-form-label   ">Assessment Result</label>
                            <div class="col-md-10">
                                <textarea placeholder="Enter Your Assessment Result Here" class="form-control" value="{{ old('assessment_result') }}" name=" assessment_result" id=" assessment_result" rows="4" cols="50" value=""><?php echo $d->assessment_result;?></textarea>

                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Agreed Fee Per Hour:</label>
                            <div class="col-md-10">
                                <input type="number" value="<?= $d->agreed_fee_per_hr ?>" step="any" min="0.001"   id="agreed_fee_per_hr"   name="agreed_fee_per_hr" class="form-control" placeholder="Agreed Fee Per Hour" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Agreed Hours:</label>
                            <div class="col-md-10">
                                <input type="number" value="<?= $d->agreed_hrs ?>" step="any" min="0.001"   id="agreed_hrs"   name="agreed_hrs" class="form-control" placeholder="Agreed Hours" required>
                            </div>
                        </div>
<?php /*
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Address:</label>
                            <div class="col-md-10">

                                <input type="text" value="<?= $d->address ?>" id="address" name="address" class="form-control"
                                       placeholder="Enter Address" required>
                            </div>
                        </div>
 */ ?>
                        <div class="form-group row">

                            <label class="col-lg-2 col-form-label">Registration Date:</label>
                            <div class="col-lg-10">
                               <input type="date" id="date" name="date" value="<?php echo date('Y-m-d',strtotime($d->date)); ?>" class="form-control " required>

                             </div>

                        </div>

                        <div class="form-group row">
                            <label class="col-lg-2 col-form-label">Status:</label>
                            <div class="col-lg-10">
                                <select id="status" name="status" data-placeholder="Select Status" required class="form-control form-control-select2" data-fouc>
                                    <option <?php if ($d->status == "confirmed"){  echo"selected"; } ?>  value="confirmed">Confirmed</option>
                                    <option <?php if ($d->status == "on_hold"){  echo"selected"; } ?> value="on_hold">On-Hold</option>
                                    <option <?php if ($d->status == "pending"){  echo"selected"; } ?> value="pending">Pending</option>
                                    <option <?php if ($d->status == "discontinued"){  echo"selected"; } ?> value="discontinued">Discontinued</option>
                                    <option <?php if ($d->status == "cancelled"){  echo"selected"; } ?> value="cancelled">Cancelled</option>

                                </select>
                            </div>

                        </div>

                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Remarks:</label>
                            <div class="col-md-10">
                                <textarea placeholder="Enter Your Remarks Here" class="form-control" name=" remarks"
                                          id=" remarks" rows="4" cols="50" value=""><?php echo $d->remarks;?></textarea>
                            </div>
                        </div>

                        <div class="mt-5 mb-2 d-md-flex  justify-content-md-between flex-md-wrap">
                            <button type="submit" id="" class="btn bg-primary d-flex align-items-center">
                                Submit <i class="icon-paperplane ml-2"></i></button>
                        </div>

                    </form>
                    <?php }else {
                        echo "An Error Occured While Processing";
                    }
                    ?>

                </div>
            </div>

        </div>
        <!-- /content area -->
        @include('layouts.footer')
     </div>

     <!-- /main content -->

@endsection
