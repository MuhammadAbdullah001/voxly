@extends('layouts.admin.master')

@section('content')
    <!-- Main content -->
    <div class="content-wrapper">

        <!-- Page header -->
        <div class="page-header page-header-light">
            <div class="page-header-content header-elements-md-inline">
                <div class="page-title d-flex">
                    <h4><span class="font-weight-semibold">Admission</span> - Edit</h4>
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
                        <h4 class="card-title">Edit Admission</h4>
                    </div>
                </div>
                <hr>

                <div class="card-body">
                    <?php
                    if (isset($data['admission_registration_edit']) && !empty($data['admission_registration_edit'])){
                    $d = $data['admission_registration_edit']; ?>
                    <form action="{{url('admin/admission/edit')}}" method="post">
                        @csrf

                       <input type="hidden" name="id" value="<?php echo $d->id; ?>">

                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Admission No:</label>
                            <div class="col-md-10">
                                <input type="text" value="<?php echo $d->admission_no; ?>" readonly   id="admission_no"   name="admission_no" class="form-control" placeholder="Enter Admission No" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Parent Name:</label>
                            <div class="col-md-10">
                                <input type="text"  value="<?php echo $d->parent_name; ?>" id="parent_name"   name="parent_name" class="form-control" placeholder="Enter Parent Name" required>
                            </div>
                        </div>

                        <div class="form-group row" id="phone_number">
                            <label class="col-form-label col-lg-2">Contact Number</label>
                            <div class="col-lg-10">
                                <div class="input-group">
                                    <input type="text"  value="<?php echo $d->contact_number; ?>" name="contact_number" id="contact_number" class="form-control" placeholder="Contact Number"  required="" value="">
                                </div>
                            </div>
                        </div>

                        <div class="form-group row  " id="phone_number control-label">
                            <label class="col-form-label col-lg-2 ">Emergency Contact Number</label>
                            <div class="col-lg-10">
                                <div class="input-group">
                                    <input type="text" name="emergency_contact_no" value="<?php echo $d->emergency_contact_no; ?>" id="emergency_contact_no" class="form-control" placeholder="Emergency Contact Number"   >
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Mailing Address:</label>
                            <div class="col-md-10">

                                <input type="text" id="address" name="address" value="<?php echo $d->address; ?>"  class="form-control" placeholder="Enter Address" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Email:</label>
                            <div class="col-md-10">
                                <input type="email"  value="<?php echo $d->email; ?>" id="email"  readonly name="email" class="form-control" placeholder="Enter Email" required>
                            </div>
                        </div>

                        {{--<div class="form-group row">--}}
                            {{--<label class="col-md-2 col-form-label">Password:</label>--}}
                            {{--<div class="col-md-10">--}}
                                {{--<input type="password"   id="password"   name="password" class="form-control" placeholder="Enter User Password" required>--}}
                            {{--</div>--}}
                        {{--</div>--}}


                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Projected Revenue:</label>
                            <div class="col-md-10">

                                <input type="text" id="projected_revenue" value="<?php echo $d->projected_revenue; ?>" name="projected_revenue" class="form-control" placeholder="Projected Revenue"  >
                            </div>
                        </div>

                        <div class="form-group row" id="">
                            <label class="col-form-label col-lg-2">Child Care</label>
                            <div class="col-lg-10">
                                <div class="input-group">
                                    <div><input type="radio" name="child_care" <?php if ($d->child_care == 1){  echo "checked"; } ?> class="" id="child_care" value="1" required=""> <span class="tax-span">Yes</span></div>
                                </div>
                                <div class="input-group">
                                    <div><input type="radio" name="child_care" class="" <?php if ($d->child_care == 0){  echo "checked"; } ?> id="child_care" required="" value="0"> <span class="tax-span">No</span></div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">

                            <label class="col-lg-2 col-form-label">Registration Date:</label>
                            <div class="col-lg-10">
                                <input type="text" id="date" name="date" value="<?php echo date('d-m-Y',strtotime($d->date)); ?>" class="form-control pickadate-limits-attendance" required>
                            </div>

                        </div>

                        <div class="form-group row  ">

                            <label class="col-lg-2 col-form-label">Post-Code</label>
                            <div class="col-lg-10">
                                <input type="text" id="post_code" name="post_code" value="<?php echo $d->post_code; ?>" class="form-control" placeholder="Post Code"  >
                            </div>

                        </div>

                        <div class="form-group row ">

                            <label class="col-lg-2 col-form-label">Landline No</label>
                            <div class="col-lg-10">
                                <input type="text" id="landline_no" name="landline_no" value="<?php echo $d->landline_no; ?>" class="form-control " placeholder="Landline No" >
                            </div>

                        </div>

                        <div class="form-group row ">

                            <label class="col-lg-2 col-form-label">Reffered By</label>
                            <div class="col-lg-10">
                                <input type="text" id="reffered_by" name="reffered_by" value="<?php echo $d->reffered_by; ?>" class="form-control" placeholder="Reffered By">
                            </div>

                        </div>

                        <div class="form-group row">

                            <label class="col-lg-2 col-form-label">Relation</label>
                            <div class="col-lg-10">
                                <input type="text" id="relation" name="relation" value="<?php echo $d->relation; ?>" class="form-control" placeholder="Relation">
                            </div>

                        </div>

                        <div class="form-group row required">
                            <label class="col-lg-2 col-form-label control-label">Class Mode:</label>
                            <div class="col-lg-10">
                                <select id="class_mode" name="class_mode" data-placeholder="Class Mode" required class="form-control form-control-select2" data-fouc>
                                    <option value="">Please Select</option>
                                    <option <?php if ($d->class_mode == "online"){  echo"selected"; } ?> value="online">Online</option>
                                    <option <?php if ($d->class_mode == "offline"){  echo"selected"; } ?> value="offline">Offline</option>
                                </select>
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
                                <textarea placeholder="Enter Your Remarks Here"  class="form-control" name=" remarks" id=" remarks" rows="4" cols="50"> <?php echo $d->remarks; ?></textarea>
                            </div>
                        </div>

                        <div class="mt-5 mb-2 d-md-flex  justify-content-md-between flex-md-wrap">
                             <button type="submit" id="" class="btn bg-primary d-flex align-items-center">
                                Submit <i class="icon-paperplane ml-2"></i> </button>
                        </div>

                    </form>
                    <?php }else{
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
