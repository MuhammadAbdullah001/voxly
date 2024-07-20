$(document).on('change', '.registration-status', function () {
        var user_id = $(this).data('id');
          var status = $(this).val();


        if(confirm("Are you sure you want to change status of this user?"))
        {
            $.ajax({

                url: '/admin/admission/changeStatus/',
                type: 'get',
                dataType: 'json',
                data: {
                    'status': status,
                    'user_id': user_id,

                },
                success: function (data) {
                      $.jGrowl(data.data.msg, {
                            theme: 'bg-success',
                        }
                    );
                    $('.loading-bar').css('display', 'none');
                    // location.reload();
                },
                error: function (data) {
                     $.jGrowl(data.data.msg, {
                        theme: 'bg-danger'
                    });
                }
            });
        }
        else
        {
            return false;
        }

    });

 $(document).on('change', '.student-status', function () {
        var student_id = $(this).data('id');
     var status = $(this).val();

        if(confirm("Are you sure you want to change status of this user?"))
        {
            $.ajax({

                url: '/admin/student/changeStatus/',
                type: 'get',
                dataType: 'json',
                data: {
                    'status': status,
                    'student_id': student_id,

                },
                success: function (data) {
                      $.jGrowl(data.data.msg, {
                            theme: 'bg-success',
                        }
                    );
                      // location.reload();
                    $('.loading-bar').css('display', 'none');

                },
                error: function (data) {
                     $.jGrowl(data.data.msg, {
                        theme: 'bg-danger'
                    });
                }
            });
        }
        else
        {
            return false;
        }




    });

 $(document).on('change', '.teacher-status', function () {
        var staff_id = $(this).data('id');
     var status = $(this).val();

        if(confirm("Are you sure you want to change status of this user?"))
        {
            $.ajax({

                url: '/admin/staff/changeStatus/',
                type: 'get',
                dataType: 'json',
                data: {
                    'status': status,
                    'staff_id': staff_id

                },
                success: function (data) {
                      $.jGrowl(data.data.msg, {
                            theme: 'bg-success',
                        }
                    );
                    $('.loading-bar').css('display', 'none');
                    // location.reload();
                },
                error: function (data) {
                     $.jGrowl(data.data.msg, {
                        theme: 'bg-danger'
                    });
                }
            });
        }
        else
        {
            return false;
        }




    });


 $(document).on('change', '#fee-status', function () {
        var student_fee_id = $(this).data('id');
        var status = $(this).val();

        if(confirm("Are you sure you want to change Fee status of this user?"))
        {
            $.ajax({

                url: '/admin/student-fee/changeFeeStatus',
                type: 'get',
                dataType: 'json',
                data: {
                    'status': status,
                    'student_fee_id': student_fee_id,
                    '_method': 'put'

                },
                success: function (data) {
                      $.jGrowl(data.data.msg, {
                            theme: 'bg-success',
                        }
                    );
                    $('.loading-bar').css('display', 'none');

                },
                error: function (data) {
                     $.jGrowl(data.data.msg, {
                        theme: 'bg-danger'
                    });
                }
            });
        }
        else
        {
            return false;
        }




    });



$(document).on('change', '#salary-status', function () {
    var teacher_salary_id = $(this).data('id');
    var status = $(this).val();

    if(confirm("Are you sure you want to change Fee status of this user?"))
    {
        $.ajax({

            url: '/admin/teacher-salary/changeSalaryStatus',
            type: 'get',
            dataType: 'json',
            data: {
                'status': status,
                'teacher_salary_id': teacher_salary_id,
                '_method': 'put'

            },
            success: function (data) {
                $.jGrowl(data.data.msg, {
                        theme: 'bg-success',
                    }
                );
                $('.loading-bar').css('display', 'none');

            },
            error: function (data) {
                $.jGrowl(data.data.msg, {
                    theme: 'bg-danger'
                });
            }
        });
    }
    else
    {
        return false;
    }




});
 $(document).on('change', '#admin-status', function () {
        var admin_id = $(this).data('id');
          var status = $(this).val();
         if(confirm("Are you sure you want to change status of this user?"))
        {
            $.ajax({

                url: '/admin/account/changeStatus/',
                type: 'get',
                dataType: 'json',
                data: {
                    'status': status,
                    'admin_id': admin_id

                },
                success: function (data) {
                      $.jGrowl(data.data.msg, {
                            theme: 'bg-success',
                        }
                    );
                    $('.loading-bar').css('display', 'none');

                },
                error: function (data) {
                     $.jGrowl(data.data.msg, {
                        theme: 'bg-danger'
                    });
                }
            });
        }
        else
        {
            return false;
        }




    });


 $(document).on('change', '#contact-us-status', function () {
        var id = $(this).data('id');
          var status = $(this).val();
         if(confirm("Are you sure you want to change status of this query?"))
        {
            $.ajax({

                url: '/admin/account/changeStatusContactUs/',
                type: 'get',
                dataType: 'json',
                data: {
                    'status': status,
                    'id': id

                },
                success: function (data) {
                      $.jGrowl(data.data.msg, {
                            theme: 'bg-success',
                        }
                    );
                    $('.loading-bar').css('display', 'none');

                },
                error: function (data) {
                     $.jGrowl(data.data.msg, {
                        theme: 'bg-danger'
                    });
                }
            });
        }
        else
        {
            return false;
        }




    });

 $(document).on('change', '#teacher-roll-assigned', function () {
        var user_id = $(this).data('user_id');
          var roll_assigned = $(this).val();
         if(confirm("Are you sure you want to change status of this user?"))
        {
            $.ajax({

                url: '/admin/staff/rollAssign/',
                type: 'get',
                dataType: 'json',
                data: {
                    'roll_assigned': roll_assigned,
                    'user_id': user_id,


                },
                success: function (data) {
                      $.jGrowl(data.data.msg, {
                            theme: 'bg-success',
                        }
                    );
                    $('.loading-bar').css('display', 'none');

                },
                error: function (data) {
                    if (data.data){
                        var msg = data.data.msg;
                    }else{
                        msg= 'Some Internal Error Occurred';
                    }
                     $.jGrowl(msg, {
                        theme: 'bg-danger'
                    });
                }
            });
        }
        else
        {
            return false;
        }




    });





$("#student_attendance_date").on("click", function(){
    $("#admission_attendance").val('').trigger('change');

    $("#student_list").empty();
    var html = '';

    html += '<option selected value="">--- Select ---</option>';
    $("#student_list").append(html);




    // $('#admission_attendance').val("");
    // $('#student_admissions_id').val("");
});

$("#admission_attendance").on("change", function(){
    var admission_no = $(this).val();
     var date = $("#student_attendance_date").val();
    $.ajax({
        url: '/admin/attendance/getStudents/',
        type:'get',
        datatype:'json',
        data:{
            'date':date,
            'admission_no':admission_no,

        },
        success:function (data)
        {
             $("#student_list").empty();
            var html = '';
            html += '<option selected value="">--- Select ---</option>';

                 $.each(data.data, function (j, item){
                    // console.log(item);
                    html += '<option value="'+item.id +'">'+item.student_name+'</option>';
                });

            $("#student_list").append(html);
        },
        error:function () {
            $("#student_list").empty();
            var html = '';
            html += '<option selected value="">--- Select Admission Number First ---</option>';

            $("#student_list").append(html);
        }
    })
});
$('#expected_salary_container').hide();

$(document).on("click","#salary_amount",function(){
    var salary_from_date = $('#salary_from_date').val();
    var salary_to_date = $('#salary_to_date').val();
    var teacher_id = $('#teacher_list').val();
    var salary_duration = $('#salary_duration').val();
    // alert(student_id);


    // alert(fee_from_date);


    $.ajax({
        url: '/admin/teacher-salary/getSelectedTeacher/',
        type:'get',
        datatype:'json',
        data:{
            'teacher_id':teacher_id,
            'salary_from_date':salary_from_date,
            'salary_to_date':salary_to_date,
            'salary_duration':salary_duration

        },
        success:function (data)
        {
            // var  agreed_fee_per_hrs = data.data.per_hour_rate;
            // var  agreed_hrs = data.data.daily_working_hours;
            // var  per_day = agreed_hrs*agreed_fee_per_hrs;
            // var  expected_fee = per_day*salary_duration;

            $('#expected_fee_label').html("Expected Salary("+data.data.expected_salary_duration+ " Days)");
            $('#expected_salary_value').val(data.data.expected_salary.toFixed(2));
            $('#expected_salary_container').show();
            $('#salary_submit_btn').attr('disabled',false);
        },
        error:function (data) {

            data = data.responseJSON;
            if (data.data){
                var msg = data.data.msg;
            }else{
                if (data) {
                    var msg = data.msg;
                }else{
                    msg= 'Some Internal Error Occurred';

                }
            }
            $.jGrowl(msg, {
                theme: 'bg-danger'
            });
            $('#salary_submit_btn').prop('disabled', true);

        }
    })




    // alert("finally bye");
});




$("#teacher-group").on("change", function(){
    var group_id = $(this).val();
     $.ajax({
        url: '/admin/teacher-salary/getTeachersByGroup/',
        type:'get',
        datatype:'json',
        data:{
             'group_id':group_id ,

        },
        success:function (data)
        {
             $("#teacher_list").empty();
            var html = '';
            html += '<option selected value="">--- Select ---</option>';

                 $.each(data.data, function (j, item){
                    // console.log(item);
                    html += '<option value="'+item.id +'">'+item.name+'</option>';
                });

            $("#teacher_list").append(html);
        },
        error:function () {
            $("#teacher_list").empty();
            var html = '';
            html += '<option selected value="">--- Select Group First/No Teacher Found ---</option>';

            $("#teacher_list").append(html);
        }
    })
});

$('#expected_fee_container').hide();
// $(document).on("focusout","#amount",function(){
$(document).on("click","#fee_amount",function(){
    var fee_from_date = $('#fee_from_date').val();
    var fee_to_date = $('#fee_to_date').val();
    var student_id = $('#student_list').val();
    var fee_duration = $('#fee_duration').val();
    // alert(student_id);

    $('#expected_fee_label').html("Expected Fee("+fee_duration+ " Days)");

  // alert(fee_from_date);


    $.ajax({
        url: '/admin/student-fee/getSelectedStudent/',
        type:'get',
        datatype:'json',
        data:{
             'student_id':student_id,
             'fee_from_date':fee_from_date,
             'fee_to_date':fee_to_date,
             'fee_duration':fee_duration

        },
        success:function (data)
        {
            var  agreed_fee_per_hrs = data.data.agreed_fee_per_hr;
          var  agreed_hrs = data.data.agreed_hrs;
          var  per_day = agreed_hrs*agreed_fee_per_hrs;
          var  expected_fee = per_day*fee_duration;

            $('#expected_fee_value').val(expected_fee.toFixed(2));
            $('#expected_fee_container').show();
            $('#fee_submit_btn').attr('disabled',false);
        },
        error:function (data) {

            data = data.responseJSON;
            if (data.data){
                var msg = data.data.msg;
            }else{
                if (data) {
                    var msg = data.msg;
                }else{
                    msg= 'Some Internal Error Occurred';

                }
            }
            $.jGrowl(msg, {
                theme: 'bg-danger'
            });
            $('#fee_submit_btn').prop('disabled', true);

        }
    })




    // alert("finally bye");
});

$("#expense_category").on("change", function(){
      var expense_category = $(this).val();
    $.ajax({
        url: '/admin/expenses/getExpenseCategory/',
        type:'get',
        datatype:'json',
        data:{
             'expense_category':expense_category,

        },
        success:function (data)
        {
            console.log(data);
            $("#expense_type").empty();
            var html = '';
            html += '<option selected value="">--- Select ---</option>';

                 $.each(data.data, function (j, item){
                    // console.log(item);
                    html += '<option value="'+item.name +'">'+item.name+'</option>';
                });

            $("#expense_type").append(html);
        },
        error:function () {
            $("#expense_type").empty();

            $("#expense_type").append(html);
        }
    })
});


$("#teacher_attendance_date").on("change", function(){

    var date = $(this).val();
    $.ajax({
        url: '/admin/teacher-attendance/getStudents/',
        type:'get',
        datatype:'json',
        data:{
            'date':date,

        },
        success:function (data)
        {
            $("#staff_teacher_select").empty();
            var html = '';
            html += '<option selected value="a">--- Select ---</option>';

            $.each(data.data, function (j, item){
                // console.log(item);
                html += '<option value="'+item.id +'">'+item.name+'</option>';
            });

            $("#staff_teacher_select").append(html);
        },
        error:function () {
            $("#staff_teacher_select").empty();

            $("#staff_teacher_select").append(html);
        }
    })
});


$(".end_time").on("change", function() {
    var start_time = $('.start_time').val();
    var end_time = $('.end_time').val();
    // var staff_teacher_select = $('.staff_teacher_select').val();

    if( start_time  > end_time  ){
        $('.attendance_submit').prop('disabled','disabled');
    }else{
        $('.attendance_submit').prop('disabled',false);

    }
});

$(".end_time_student").on("change", function() {
    var start_time = $('.start_time_student').val();
    var end_time = $('.end_time_student').val();
    // var staff_teacher_select = $('.staff_teacher_select').val();

    if( start_time  > end_time  ){
        $('.attendance_submit_student').prop('disabled','disabled');
    }else{
        $('.attendance_submit_student').prop('disabled',false);

    }
});

$("#group_id_change").on("change", function(){

    var group_id = $(this).val();
    $.ajax({
        url: '/admin/student/getSubjects/',
        type:'get',
        datatype:'json',
        data:{
            'group_id':group_id,

        },
        success:function (data) {
              data = $.parseJSON(data);


                $("#student_subjects").empty();


            $("#student_subjects").select2({
                data: data
            });
        }

    })
});
