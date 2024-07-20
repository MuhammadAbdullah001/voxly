<!-- Theme JS files -->

<script src="<?php echo base_url('assetsb'); ?>/js/plugins/forms/styling/uniform.min.js"></script>
<script src="<?php echo base_url('assetsb'); ?>/js/plugins/forms/styling/switchery.min.js"></script>
<script src="<?php echo base_url('assetsb'); ?>/js/plugins/forms/inputs/touchspin.min.js"></script>
<script src="<?php echo base_url('assetsb'); ?>/js/demo_pages/form_input_groups.js"></script>
<!-- /theme JS files -->
<body>

<?php $this->load->view('back/includes/nav'); ?>


<!-- Page content -->
<div class="page-content">

    <?php $this->load->view('back/includes/sidebar'); ?>

    <!-- Main content -->
    <div class="content-wrapper">

        <!-- Page header -->
        <div class="page-header page-header-light">
            <div class="page-header-content header-elements-md-inline">
                <div class="page-title d-flex">
                    <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Attendence Fixed</span> - Edit</h4>
                    <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
                </div>

                <div class="header-elements d-none">
                    <div class="d-flex justify-content-center">
                        <a href="<?=base_url()?>index.php/Inventory" class="btn btn-link btn-float font-size-sm font-weight-semibold text-default">
                            <i class="icon-store text-pink-300"></i>
                            <span>Inventory</span>
                        </a>
                        <a href="<?=base_url()?>index.php/Payment" class="btn btn-link btn-float font-size-sm font-weight-semibold text-default">
                            <i class="icon-paypal2 text-pink-300"></i>
                            <span>Payment</span>
                        </a>
                        <a href="<?=base_url()?>index.php/Production/view_time_sheet" class="btn btn-link btn-float font-size-sm font-weight-semibold text-default">
                            <i class="icon-alarm text-pink-300"></i>
                            <span>Timesheet</span>
                        </a>
                    </div>
                </div>
            </div>

{{--            <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">--}}
{{--                <div class="d-flex">--}}
{{--                    <div class="breadcrumb">--}}
{{--                        <a href="index.html" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Attendence Fixed</a>--}}
{{--                        <span class="breadcrumb-item active">Edit</span>--}}
{{--                    </div>--}}

{{--                    <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>--}}
{{--                </div>--}}

{{--                <div class="header-elements d-none">--}}
{{--                    <div class="breadcrumb justify-content-center">--}}

{{--                        <div class="breadcrumb-elements-item dropdown p-0">--}}
{{--                            <a href="#" class="breadcrumb-elements-item" >--}}
{{--                                <!-- <a href="#" class="breadcrumb-elements-item dropdown-toggle" data-toggle="dropdown"> -->--}}
{{--                                <i class="icon-gear mr-2"></i>--}}
{{--                                Settings--}}
{{--                            </a>--}}

                            <!-- <div class="dropdown-menu dropdown-menu-right">
                                <a href="#" class="dropdown-item"><i class="icon-user-lock"></i> Account security</a>
                                <a href="#" class="dropdown-item"><i class="icon-statistics"></i> Analytics</a>
                                <a href="#" class="dropdown-item"><i class="icon-accessibility"></i> Accessibility</a>
                                <div class="dropdown-divider"></div>
                                <a href="#" class="dropdown-item"><i class="icon-gear"></i> All settings</a>
                            </div> -->
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
        </div>
        <!-- /page header -->


        <!-- Content area -->
        <div class="content">

            <!-- Input group addons -->
            <div class="card">
                <div class="card-header header-elements-inline">
                    <h5 class="card-title">Edit Attendence Fixed</h5>

                </div>

                <div class="card-body">

                    <form action="" method="POST">
                        <fieldset class="mb-3">
                            <legend class="text-uppercase font-size-sm font-weight-bold">Edit</legend>


                            <div class="form-group row">
                                <label class="col-form-label col-lg-2">Employee</label>
                                <div class="col-lg-10">
                                    <div class="input-group">
                                        <select name="employee_id" class="form-control">
                                            <option value="0">--- Select ---</option>
                                            <?php if(isset($employees) && count($employees)>0){ foreach ($employees as $employee){ ?>
                                                <option value="<?=$employee->id?>" <?php if($employee->id == $attendence_fixed->employee_id){ echo "selected"; } ?> ><?=$employee->name ?></option>
                                            <?php } } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-form-label col-lg-2">Date</label>
                                <div class="col-lg-10">
                                    <div class="input-group">
                                        <input type="date" name="date" class="form-control" value="<?=$attendence_fixed->date?>" >
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-form-label col-lg-2">Time Start</label>
                                <div class="col-lg-4">
                                    <div class="input-group">
                                        <input type="time" name="time_start" class="form-control" value="<?=$attendence_fixed->time_start?>">
                                    </div>
                                </div>
                                <label class="col-form-label col-lg-2">Time End</label>
                                <div class="col-lg-4">
                                    <div class="input-group">
                                        <input type="time" name="time_end" class="form-control" value="<?=$attendence_fixed->time_end?>">
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
                </div>
            </div>
            <!-- /input group addons -->

        </div>
        <!-- /content area -->


        <!-- Footer -->
        <div class="navbar navbar-expand-lg navbar-light">
            <div class="text-center d-lg-none w-100">
                <button type="button" class="navbar-toggler dropdown-toggle" data-toggle="collapse" data-target="#navbar-footer">
                    <i class="icon-unfold mr-2"></i>
                    Footer
                </button>
            </div>

            <div class="navbar-collapse collapse" id="navbar-footer">
					<span class="navbar-text">
						&copy; 2019. <a href="#">Souchaj</a> by <a href="http://droidor.com" target="_blank">Droidor</a>
					</span>

            </div>
        </div>
        <!-- /footer -->

    </div>
    <!-- /main content -->

</div>
</body>
</html>
