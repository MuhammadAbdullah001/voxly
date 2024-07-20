@extends('layouts.admin.master')

@section('content')
    <!-- Main content -->
    <div class="content-wrapper">

        <!-- Page header -->
        <div class="page-header page-header-light">
            <div class="page-header-content header-elements-md-inline">
                <div class="page-title d-flex">
                    <h4><span class="font-weight-semibold">Expense </span> - Edit</h4>
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
                <div class="card-header">
                    <div class="header-elements-inline">
                        <h4 class="card-title">Edit Expense  </h4>
                    </div>
                </div>
                <hr>

                <div class="card-body">
                    <?php
                    if (isset($data['expense']) && !empty($data['expense'])){
                    $d = $data['expense'];
                    //                                            print_r($d->expenseCategory->type);die;
                    ?>
                    <form action="{{url('admin/expenses/edit')}}" method="post">
                        @csrf
                        <input type="hidden" name="id" value="<?php echo $d->id;?>">

                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Type</label>
                            <div class="col-lg-10">
                                <div class="input-group">
                                    <select name="type" class=" form-control-select2 form-control" required id="expense_category">
                                        <option value="">--- SELECT ---</option>
                                        <option <?php if ($d->expenseCategory->type == "utilities"){ echo "selected"; } ?> value="utilities">Utilities</option>
                                        <option <?php if ($d->expenseCategory->type == "other_expenses"){ echo "selected"; } ?> value="other_expenses">Other Expense</option>
                                        <option <?php if ($d->expenseCategory->type == "immovable_assets"){ echo "selected"; } ?> value="immovable_assets">Immovable assets</option>
                                        <option <?php if ($d->expenseCategory->type == "general"){ echo "selected"; } ?> value="general">General</option>

                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Expense Category Name</label>
                            <div class="col-lg-10">
                                <div class="input-group">
                                    <select name="expense_category_name" class=" form-control-select2 form-control" required id="expense_type">
                                        <option value="">--- SELECT ---</option>
                                        <option selected value="<?php echo $d->expense_category_name ?>"><?php echo $d->expense_category_name; ?></option>

                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Amount</label>
                            <div class="col-md-10">
                                <input type="number"   value="<?php echo $d->amount ?>"   name="amount" class="form-control" placeholder="Enter Expense Amount" required>
                            </div>
                        </div>

                        <div class="form-group row">

                            <label class="col-md-2 col-form-label">Expense Date:</label>
                            <div class="col-md-10">
                                <input type="text" id="date" value="<?php echo date('d-m-Y',strtotime($d->date)) ?>" name="date" class="form-control daterange-single" required>
                            </div>

                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Description</label>
                            <div class="col-lg-10">
                                <div class="input-group">
                                    <textarea name="description" class="form-control" ></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="mt-5 mb-2 d-md-flex  justify-content-md-between flex-md-wrap">
                            <button type="submit" id="" class="btn bg-primary d-flex align-items-center">
                                Submit <i class="icon-paperplane ml-2"></i> </button>
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