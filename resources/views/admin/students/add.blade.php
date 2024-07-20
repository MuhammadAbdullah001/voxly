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
                    <h4><span class="font-weight-semibold">Record Attendance</span> - Add New</h4>
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
{{--                        <a href="<?=base_url()?>index.php/user" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Dashboard</a>--}}
{{--                        <a href="<?=base_url()?>index.php/AttendenceFixed" class="breadcrumb-item">Record Attendance</a>--}}
{{--                        <span class="breadcrumb-item active">Add New</span>--}}
{{--                    </div>--}}

{{--                    <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>--}}
{{--                </div>--}}
{{--            </div>--}}
        </div>
        <!-- /page header -->


        <!-- Content area -->
        <div class="content">
            <?php echo validation_errors(); ?>
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
            <!-- Input group addons -->
            <div class="card">
                <div class="card-header header-elements-inline">
                    <h5 class="card-title">Add New Record Attendance</h5>

                </div>

                <div class="card-body">

                    <form action="" method="POST">
                        <fieldset class="mb-3">
                            <legend class="text-uppercase font-size-sm font-weight-bold">Add</legend>

                            <div class="form-group row">
                                <label class="col-form-label col-lg-2">Date</label>
                                <div class="col-lg-10">
                                    <div class="input-group">
                                        <input type="text" name="date" id="date" placeholder="Select Date" class="daterange-single form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-form-label col-lg-2">Employee Type</label>
                                <div class="col-lg-10">
                                    <div class="input-group">
                                        <select name="" class="form-control select" id="type">
                                            <option value="0">--- Select ---</option>
                                            <option value="monthly_wager">Monthly Wager</option>
                                            <option value="weekly_wager">Weekly Wager</option>
                                            <option value="daily_wager">Daily Wager</option>
                                        </select>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="col-form-label col-lg-2">Employee</label>
                                <div class="col-lg-10">
                                    <div class="input-group">
                                        <select class="js-example-basic-single form-control js-example-theme-single select" id="employee_list" name="employee_id">
                                            <option value = "0">--Please Select--</option>

                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-form-label col-lg-2">Time Start</label>
                                <div class="col-lg-4">
                                    <div class="input-group">
                                        <input type="text" name="time_start" class="form-control " id="anytime-time-start" placeholder="--Please Select--"  value="">
                                    </div>
                                </div>
                                <label class="col-form-label col-lg-2 text-center">Time End</label>
                                <div class="col-lg-4">
                                    <div class="input-group">



                                        <input type="text" name="time_end" class="form-control anytime-time" id="anytime-time-end" placeholder="--Please Select--"  value="">


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

<script>

    $("#date").on("click", function(){
        $('#type').prop('selectedIndex',0);
    });

    $("#type").on("change", function(){
        var employee_type = $("#type").val();
        var date = $("#date").val();
        $.ajax({
            url: '<?=base_url()?>index.php/AttendenceFixed/getData/'+employee_type,
            type:'get',
            datatype:'json',
            data:{
                'date':date,

            },
            success:function (data)
            {
                $("#employee_list").empty();
                var html = '';
                html += '<option value="">--- Select ---</option>';
                $.each(data, function (i, item){
                    html += '<optgroup label="'+i+'">';
                    $.each(item, function (j, item2){

                        html += '<option value="'+item2['id'] +'">'+item2['name']+'</option>';
                    });
                });
                $("#employee_list").append(html);
            }
        })
    });


</script>

</body>
</html>
