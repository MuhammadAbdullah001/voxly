@extends('layouts.admin.master')

@section('content')
    <!-- Main content -->
    <div class="content-wrapper">

        <!-- Page header -->
        <div class="page-header page-header-light">
            <div class="page-header-content header-elements-md-inline">
                <div class="page-title d-flex">
                    <h4><span class="font-weight-semibold">Notification</span> - Generator</h4>
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
                        <h4 class="card-title">Add New Notification</h4>
                    </div>
                </div>
                <hr>

                <div class="card-body">

                    <form action="{{url('admin/notification-generator/add')}}" enctype="multipart/form-data" method="post">
                        @csrf


                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Title:</label>
                            <div class="col-md-10">
                                <input type="text" id="title" name="title" value="{{ old('title') }}"  placeholder="Title" required="required" class="form-control">                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Description:</label>
                            <div class="col-md-10">
                                <textarea placeholder="Enter Description Here" value="{{ old('description') }}"  name="description" id=" remarks" rows="4" cols="50"   class="form-control"> {{ old('description') }}</textarea>
                            </div>
                        </div>
<br><br>

                        <div class="form-group row">
                            <label class="col-form-label col-lg-2 ">Confirmational</label>
                            <div class="col-lg-4">
                                <div class="input-group">
                                    <input type="radio" name="is_answerable" <?php if ( old('is_answerable') == 1){ echo "checked";} ?> class="form-control  "     value="1" >
                                </div>
                            </div>
                            <label class="col-form-label col-lg-2 text-center">Occasional</label>
                            <div class="col-lg-4">
                                <div class="input-group">
                                    <input type="radio" <?php if ( old('is_answerable') == 0){ echo "checked";} ?> name="is_answerable" class="form-control "     value="0">
                                </div>
                            </div>

                        </div>
                        <br><br>
                        <!-- Select All and filtering options -->
                         <div class="form-group row">
                            <label class="col-form-label col-lg-2">Teacher</label>
                            <div class="col-lg-4">
                                <div class="input-group">
                                    <select class="multiselect-select-all-filtering" name="teachers[]" multiple="multiple">
                                        <?php
                                        if( isset($data['teachers']) && !empty($data['teachers'])){
                                        foreach ($data['teachers'] as $teacher){ ?>
                                        <option value="<?php  echo $teacher->id; ?>"><?php  echo $teacher->parent_name; ?> </option>

                                        <?php }
                                        }

                                        ?>


                                    </select>
                                </div>
                            </div>
                            <label class="col-form-label col-lg-2 text-center">Parent</label>
                            <div class="col-lg-4">
                                <div class="input-group">

                                    <select class="multiselect-select-all-filtering" name="parents[]" multiple="multiple">
                                        <?php
                                        if( isset($data['parents']) && !empty($data['parents'])){
                                        foreach ($data['parents'] as $parent){ ?>
                                            <option value="<?php  echo $parent->id; ?>"><?php echo $parent->admission_no.' - '; echo $parent->parent_name; ?> </option>

                                        <?php }
                                        }

                                        ?>
                                    </select>

                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Attachment:</label>
                            <div class="col-lg-10">
                                <div class="form-group">
                                    <input type="file" class="form-control" name="notif_img" >
                                </div>
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

<script>
    var config = {
    apiKey: "{{ config('services.firebase.api_key') }}",
    authDomain: "{{ config('services.firebase.auth_domain') }}",
    databaseURL: "{{ config('services.firebase.database_url') }}",
    storageBucket: "{{ config('services.firebase.storage_bucket') }}",
    };
    firebase.initializeApp(config);

    var database = firebase.database();


    firebase.database().ref('notification/').set({
        name: "title notif",
        email: "title desc",
    });


</script>
    <!-- /main content -->

@endsection
