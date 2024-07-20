<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//header('Content-Type: application/json');
//header('Access-Control-Allow-Origin: *');
//header('Access-Control-Allow-Credentials: true');


//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
Route::post('login', 'Auth\LoginController@applogin');
Route::post('logout', 'Api\ApiController@logout');
Route::post('password/email', 'Auth\ForgotPasswordController@appSendResetLinkEmail');
Route::post('password/changePassword', 'Api\ApiController@changePassword');
Route::post('profile', 'Api\ApiController@profile');
Route::post('contactUs', 'Api\ApiController@contactUs');
Route::get('AllTeachersList', 'Api\ApiController@AllTeachersList');
Route::get('AllUsersList', 'Api\ApiController@AllUsersList');

Route::get('specificParentList', 'Api\ApiController@specificParentList');
Route::get('specificParentListCommunication', 'Api\ApiController@specificParentListCommunication');
Route::post('generateNotification', 'Api\ApiController@generateNotification');
Route::post('notificationReply', 'Api\ApiController@notification_reply');
Route::get('responseCheck', 'Api\ApiController@responseCheck');
// view all notification by user sent
Route::get('notificationAll', 'Api\ApiController@notification_sent_all');
Route::get('getnotificationAll', 'Api\ApiController@notification_all');
Route::get('usersListHistory', 'Api\ApiController@user_list_for_history');
Route::get('getChatById', 'Api\ApiController@get_chat_by_id');
Route::get('getChatByIdCommunication', 'Api\ApiController@get_chat_by_id_communication');
Route::get('notificationRead', 'Api\ApiController@notification_read');
Route::get('dashboard', 'Api\ApiController@dashboard');

Route::post('home', 'Api\ApiController@index');
Route::post('team', 'Api\ApiController@team_view_for_leader');
Route::get('TeamMemberById', 'Api\ApiController@TeamMemberById');
Route::get('getBookingAssetsByBranch', 'Api\ApiController@getBookingAssetsByBranch');
Route::get('getBookingDetails', 'Api\ApiController@BookingDetailById');
Route::get('timeTo', 'Api\ApiController@timeTo');
Route::post('addBooking', 'Api\ApiController@addBooking');
Route::post('reserveBooking', 'Api\ApiController@reserveBooking');
Route::get('showBookings', 'Api\ApiController@showBookings');
Route::get('showBookingMore', 'Api\ApiController@showBookingMore');
Route::get('showGuests', 'Api\ApiController@showGuests');
Route::get('showGuestMore', 'Api\ApiController@showGuestMore');
Route::post('createTicket', 'Api\ApiController@createTicket');
Route::get('showTicketById', 'Api\ApiController@showTicketById');
Route::get('showTickets', 'Api\ApiController@showTickets');
Route::get('showTicketMore', 'Api\ApiController@showTicketMore');

Route::get('Billing', 'Api\ApiController@Billing');
Route::get('allInvoicesReport', 'Api\ApiController@allInvoicesReport');
Route::get('walletBillingMore', 'Api\ApiController@walletBillingMore');
Route::get('walletBookingMore', 'Api\ApiController@walletBookingMore');
Route::get('walletPrintingMore', 'Api\ApiController@walletPrintingMore');
Route::get('allInvoicesMore', 'Api\ApiController@allInvoicesMore');
Route::get('show', 'Api\ApiController@show');
Route::post('insert_guest', 'Api\ApiController@insert_guest');
Route::get('guestTimeTo', 'Api\ApiController@guestTimeTo');
Route::get('editGuest', 'Api\ApiController@editGuest');
Route::post('updateGuest', 'Api\ApiController@updateGuest');

Route::group(['middleware' => 'auth:api'], function() {




});
