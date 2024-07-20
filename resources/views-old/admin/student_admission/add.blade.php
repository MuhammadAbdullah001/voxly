@extends('layouts.admin.master')

@section('content')
    <!-- Main content -->
    <div class="content-wrapper">

        <!-- Page header -->
        <div class="page-header page-header-light">
            <div class="page-header-content header-elements-md-inline">
                <div class="page-title d-flex">
                    <h4><span class="font-weight-semibold">Admission</span> - Add</h4>
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
                        <h4 class="card-title">Add New Admission</h4>
                    </div>
                </div>
                <hr>

                <div class="card-body">

                    <form action="{{url('admin/admission/add')}}" method="post">
                        @csrf

                        <div class="form-group row required">
                            <label class="col-md-2 col-form-label control-label">Admission No:</label>
                            <div class="col-md-10">
                                <input type="text"   id="admission_no" value="{{ old('admission_no') }}"   name="admission_no" class="form-control" placeholder="Enter Admission No" required>
                            </div>
                        </div>

                        <div class="form-group row required">
                            <label class="col-md-2 col-form-label control-label">Parent Name:</label>
                            <div class="col-md-10">
                                <input type="text"   id="parent_name" value="{{ old('parent_name') }}"   name="parent_name" class="form-control" placeholder="Enter Parent Name" required>
                            </div>
                        </div>

                        <div class="form-group row required" id="phone_number control-label">
                            <label class="col-form-label col-lg-2 control-label">Contact Number</label>
                            <div class="col-lg-10">
                                <div class="input-group">
                                    <input type="text" name="contact_number" value="{{ old('contact_number') }}" id="contact_number" class="form-control" placeholder="Contact Number"  required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row  " id="phone_number control-label">
                            <label class="col-form-label col-lg-2 ">Emergency Contact Number</label>
                            <div class="col-lg-10">
                                <div class="input-group">
                                    <input type="text" name="emergency_contact_no" value="{{ old('emergency_contact_no') }}" id="emergency_contact_number" class="form-control" placeholder="Emergency Contact Number"   >
                                </div>
                            </div>
                        </div>

                        <div class="form-group row required">
                            <label class="col-md-2 col-form-label control-label">Mailing Address:</label>
                            <div class="col-md-10">

                                <input type="text" id="address" value="{{ old('address') }}" name="address" class="form-control" placeholder="Enter Address" required>
                            </div>
                        </div>

                        <div class="form-group row required">
                            <label class="col-md-2 col-form-label control-label">Email:</label>
                            <div class="col-md-10">
                                <input type="email"   id="email"  value="{{ old('email') }}"  name="email" class="form-control" placeholder="Enter Email" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Password:</label>
                            <div class="col-md-10">
                                <input type="password"   id="password"   name="password" class="form-control" placeholder="Enter User Password"  >
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Projected Revenue:</label>
                            <div class="col-md-10">

                                <input type="text" id="projected_revenue" value="{{ old('projected_revenue') }}" name="projected_revenue" class="form-control" placeholder="Projected Revenue"  >
                            </div>
                        </div>

                        <div class="form-group row" id="">
                            <label class="col-form-label col-lg-2">Child Care</label>
                            <div class="col-lg-10">
                                <div class="input-group">
                                    <div><input type="radio" name="child_care" class="" id="child_care" value="1"  > <span class="tax-span">Yes</span></div>
                                </div>
                                <div class="input-group">
                                    <div><input type="radio" name="child_care" class="" id="child_care"  value="0"> <span class="tax-span">No</span></div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row required">

                            <label class="col-lg-2 col-form-label control-label">Registration Date:</label>
                            <div class="col-lg-10">
                                <input type="text" id="date" name="date" value="{{ old('date') }}" class="form-control pickadate-limits-attendance" required>
                            </div>

                        </div>


                        <div class="form-group row  ">

                            <label class="col-lg-2 col-form-label">Post-Code</label>
                            <div class="col-lg-10">
                                <input type="text" id="post_code" name="post_code" value="{{ old('post_code') }}" class="form-control" placeholder="Post Code"  >
                            </div>

                        </div>

                        <div class="form-group row ">

                            <label class="col-lg-2 col-form-label">Landline No</label>
                            <div class="col-lg-10">
                                <input type="text" id="landline_no" name="landline_no" value="{{ old('post_code') }}" class="form-control " placeholder="Landline No" >
                            </div>

                        </div>

                        <div class="form-group row ">

                            <label class="col-lg-2 col-form-label">Reffered By</label>
                            <div class="col-lg-10">
                                <input type="text" id="reffered_by" name="reffered_by" value="{{ old('reffered_by') }}" class="form-control" placeholder="Reffered By">
                            </div>

                        </div>

                        <div class="form-group row">

                            <label class="col-lg-2 col-form-label">Relation</label>
                            <div class="col-lg-10">
                                <input type="text" id="relation" name="relation" value="{{ old('relation') }}" class="form-control" placeholder="Relation">
                            </div>

                        </div>

                        <div class="form-group row required">
                            <label class="col-lg-2 col-form-label control-label">Class Mode:</label>
                            <div class="col-lg-10">
                                <select id="class_mode" name="class_mode" data-placeholder="Class Mode" required class="form-control form-control-select2" data-fouc>
                                    <option value="">Please Select</option>
                                    <option value="online">Online</option>
                                    <option value="offline">Offline</option>
                                </select>
                            </div>

                        </div>

                        <div class="form-group row required">
                            <label class="col-lg-2 col-form-label control-label">Status:</label>
                            <div class="col-lg-10">
                                <select id="status" name="status" data-placeholder="Select Status" required class="form-control form-control-select2" data-fouc>
                                    <option value="">Please Select</option>
                                    <option value="confirmed">Confirmed</option>
                                    <option value="on_hold">On-Hold</option>
                                    <option value="pending">Pending</option>
                                    <option value="discontinued">Discontinued</option>
                                    <option value="cancelled">Cancelled</option>

                                </select>
                            </div>

                        </div>

                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Remarks:</label>
                            <div class="col-md-10">
                                <textarea placeholder="Enter Your Remarks Here" class="form-control" name=" remarks" id=" remarks" rows="4" cols="50" value=""></textarea>
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
