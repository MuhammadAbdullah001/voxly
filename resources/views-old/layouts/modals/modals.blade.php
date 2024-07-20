<!-- Chanel modal -->
<div id="channel_modal" class="modal fade" tabindex="-1">
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
                            <input type="text" placeholder="Channel Name" class="form-control">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Add Users To Channel</label>
                        <div class="col-sm-8">
                            <div class="form-group">
                                <select multiple="multiple" class="form-control select" data-fouc>
                                    <optgroup label="Mountain Time Zone">
                                        <option value="AZ">Arizona</option>
                                        <option value="CO">Colorado</option>
                                        <option value="ID">Idaho</option>
                                        <option value="WY">Wyoming</option>
                                    </optgroup>
                                    <optgroup label="Central Time Zone">
                                        <option value="AL">Alabama</option>
                                        <option value="IA" selected>Iowa</option>
                                        <option value="KS" selected>Kansas</option>
                                        <option value="KY">Kentucky</option>
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <button type="submit" class="btn bg-primary">Add Channel</button>
                        <button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /Channel modal -->

<!-- Group modal -->
<div id="user-group-modal" class="modal fade" tabindex="-1">
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
                            <input type="text" placeholder="Group Name" class="form-control" id="user-group-name">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Add Users To Group</label>
                        <div class="col-sm-8">
                            <div class="form-group">
                                <select multiple="multiple" class="form-control select" data-fouc id="users-users">
                                    <optgroup label="Select User">

                                    </optgroup>

                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <button type="button" class="btn bg-primary" id="user-group-add-submit">Add Group</button>
                        <button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /Channel modal -->






<div id="team_history_utilization_user" class="modal fade" tabindex="-1">
    <div class=" loading-bar "></div>
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Utilization </h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <table class="table table-bordered table datatable-basic table table-responsive">
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
                <tbody id="utilization_user">
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









<!-- Group modal -->
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
                                <select data-placeholder="Select Users"  multiple="multiple" class="form-control select" data-fouc id="edit-users">
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
<!-- All User Modal -->
<div class="modal fade" id="allusersModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                <button type="button" class="btn btn-primary btn-group-edit-user">Add More</button>
            </div>
        </div>
    </div>
</div>
<!-- Add user chat modal -->
<div id="user_modal" class="modal fade" tabindex="-1">
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
                                <select class="form-control select" data-placeholder="Find or start a conversation" data-fouc>
                                    <optgroup label="Users">
                                        <option></option>
                                        <option value="0">Ali</option>
                                        <option value="1">Imran</option>
                                        <option value="2">James</option>
                                        <option value="3">Martin</option>
                                    </optgroup>
                                </select>
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
<!-- /Add user chat modal -->

<!-- Add Booking modal -->
<div id="add_booking_modal" class="modal fade" tabindex="-1">

    <div class=" loading-bar "></div>
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title booking-modal-title" style="">Add a Booking</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <hr class="hr">

            <form class="form-horizontal" id="booking_form">




                <div class="modal-body">

                        <div class="form-group row">
                            <label class="col-form-label col-md-4 Select-Site mt-0">Select Site</label>
                            <div class="col-md-12">
                                <div id="user_booking_branch_radio"></div>
                            </div>
                        </div>
                    <hr class="hr-2">
                    <div class="form-group row">
                        <label class="col-form-label col-md-4 Select-Site mt-0 mb-2">Booking Date</label>
                        <div class="offset-md-2 col-md-6">
                                <div class="input-group">
                                    <img class="input-left-icon" src="<?php echo asset('images/website_logo/calendar.png'); ?>" alt="">
                                    <input type="date" class="calender pickadate-year-booking " id="new-booking-date" placeholder="CHOOSE BOOKING DATE"  required>
                                    <div class="right-carets">
                                        <div class="row">
                                            <div class="col-md-12 mt-0">
                                                <i class="fa fa-caret-up pull-left" aria-hidden="true"></i>
                                            </div>
                                            <div class="col-md-12 mt-0">
                                                <i class="fa fa-caret-down pull-left" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            {{--<label for="email" class="calender-icon" rel="tooltip" title="email"> --}}
                            {{--</label>--}}
                        </div>
                    </div>
                    <hr class="hr-2">
                    <div class="form-group row">
                        <label class="col-form-label col-md-4 Select-Site mt-0 mb-2">Select Room:</label>
                        <div class="col-md-8">
                            <div class="input-group">
                                <select  placeholder="Select an Item..." id="new-booking-item"   class="calender select-room opacity-n " data-fouc required>
                                    <option value="0">Select Room</option>
                                </select>
                                <div class="right-carets">
                                    <div class="row">
                                        <div class="col-md-12 mt-0">
                                            <i class="fa fa-caret-up pull-left" aria-hidden="true"></i>
                                        </div>
                                        <div class="col-md-12 mt-0">
                                            <i class="fa fa-caret-down pull-left" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="hr-2">
                    <div class="form-group row booking-times">

                        <label class="col-form-label col-md-6 Select-Site mt-0 mb-2">Start Time</label>
                        <label class="col-form-label col-md-6 Select-Site mt-0 mb-2">End Time</label>
                        {{--<label class="col-form-label col-sm-4  Select-Site m-t-25">Booking Time</label>--}}
                        <div class="col-md-6">
                            <div class="input-group">
                                <select id="booking_time_from" class="calender select-room opacity-n margin-left-0 time-class"  required>
                                </select>
                                <div class="right-carets">
                                    <div class="row">
                                        <div class="col-md-12 mt-0">
                                            <i class="fa fa-caret-up pull-left" aria-hidden="true"></i>
                                        </div>
                                        <div class="col-md-12 mt-0">
                                            <i class="fa fa-caret-down pull-left" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group">
                                <select id="booking_time_to" class="calender select-room opacity-n margin-left-0 time-class" required>
                                </select>
                                <div class="right-carets">
                                    <div class="row">
                                        <div class="col-md-12 mt-0">
                                            <i class="fa fa-caret-up pull-left" aria-hidden="true"></i>
                                        </div>
                                        <div class="col-md-12 mt-0">
                                            <i class="fa fa-caret-down pull-left" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <hr class="hr-2">
                    <div class="form-group row">
                        <div class="col-form-label col-md-4 col-6 text-center">
                            <label class="col-form-label col-md-12 Select-Site mt-0">
                                Your Balance
                            </label>
                            <div class="col-md-12">
                                <label class="price-labels" id="your_balance_label"> </label>
                                <input type="hidden" class="price-val" id="your_balance" readonly>
                            </div>
                        </div>

                        <div class="col-form-label col-md-4 col-6 text-center">
                            <label class="col-form-label col-md-12 Select-Site mt-0">
                                Room Price Per Hour
                            </label>
                            <div class="col-md-12">
                                <label class="price-labels" id="room_price_label"> </label>
                                <input type="hidden" class="price-val" id="room_price" readonly>
                            </div>
                        </div>

                        <div class="col-form-label col-md-4 col-6 text-center">
                            <label class="col-form-label col-md-12 Select-Site mt-0">
                                Total booking price
                            </label>
                            <div class="col-md-12">
                                <label class="price-labels" id="booking_price_label"> </label>
                                <input type="hidden" class="price-val" id="booking_price"  readonly>
                            </div>
                        </div>





                        {{--<label class="col-form-label col-sm-4  Select-Site m-t-25">Room Price Per Hour</label>--}}




                        {{--<label class="col-form-label col-sm-4  Select-Site m-t-25">Total booking price</label>--}}




                    {{--<label class="col-sm-4">--}}
                        {{--<input type="text" class="price-val"  id="your_balance" readonly>--}}
                    {{--</label>--}}

                    {{--<div class="col-sm-4">--}}
                        {{--<input type="text" class="price-val" id="room_price"  readonly>--}}
                    {{--</div>--}}

                    {{--<div class="col-sm-4">--}}
                        {{--<input type="text" class="price-val" id="booking_price"  readonly>--}}
                    {{--</div>--}}

                    </div>




                    <hr class="hr">

                    <div class="form-group row">

                        <div class="col-sm-12">
                            <p class="bg-danger text-white text-lg-center" id="msg">Sorry You cannot perform booking please top up your booking wallet.<br>
                            Note: Reserved booking will valid within current day till before 1 hour of booking time in case of no payment.
                            </p>

                        </div>
                        <div class="col-sm-8">
                            <input type="hidden"  id="hidden_team_id">
                            <input type="hidden"  id="hidden_branch_id" value="{{Auth::user()->branch->id}}">
                            <input type="hidden" value="{{Auth::user()->id}}" id="hidden_user_id"  >
                            <button type="button" class="btn btn-link mt-26 cancel-button" data-dismiss="modal">Cancel</button>
                            <button type="button" id="reserve-booking-button"  class="btn btn-warning mt-26" style="float: right;">Reserve Booking</button>

                        </div>
                        <div class="col-sm-4">
                            <button type="button" id="post-booking-button" class="btn btn-success mt-26">Confirm Booking</button>

                        </div>


                    </div>
                </div>
            </form>
        </div>
    </div>

</div>
<!-- /Add Booking modal -->

{{--Guest Add Modal--}}
<div id="add-guest-modal" class="modal fade" tabindex="-1">
    <div class=" loading-bar "></div>
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Visitor</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <hr class="hr">
            <form   class="form-horizontal">

                <div class="modal-body">

                    <div class="form-group row">
                        <label class="col-form-label col-md-4 Select-Site mt-0 mb-2">Name</label>
                        <div class="col-md-8">
                            <input type="text" class=" form-control visitor-text " placeholder="Enter guest name" maxlength="190" id="guest_name" name="admin-user-name"
                                   required>
                        </div>
                    </div>
                    <hr class="hr-2">
                    <div class="form-group row">
                        <label class="col-form-label col-md-4 Select-Site mt-0 mb-2">Email</label>
                        <div class="col-md-8">
                            <input  type="email"
                                    pattern="/^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/"
                                    required class="form-control visitor-text" placeholder="Enter guest email" id="guest_email" maxlength="190" name="admin-user-email"
                                   >
                        </div>
                    </div>
                    <hr class="hr-2">
                    <div class="form-group row">
                        <label class="col-form-label col-md-4 Select-Site mt-0 mb-2">Contact Number</label>
                        <div class="col-md-8">
                            <input type="number" class="form-control visitor-text " placeholder="Enter guest number" name="guest_contact_number" maxlength="190" id="guest_contact_number" required>
                        </div>
                    </div>

                    <hr class="hr-2">
                    <div class="form-group row">
                        <label class="col-form-label col-md-4 Select-Site mt-0 mb-2">Guest Date</label>
                        <div class="offset-md-2 col-md-6">
                            <div class="input-group">
                                <img class="input-left-icon" src="<?php echo asset('images/website_logo/calendar.png'); ?>" alt="">
                                <input type="date" class="calender pickadate-year-booking " id="visitor_date"
                                   placeholder="CHOOSE GUEST DATE" required>
                                <div class="right-carets">
                                    <div class="row">
                                        <div class="col-md-12 mt-0">
                                            <i class="fa fa-caret-up pull-left" aria-hidden="true"></i>
                                        </div>
                                        <div class="col-md-12 mt-0">
                                            <i class="fa fa-caret-down pull-left" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <hr class="hr-2">
                    <div class="form-group row booking-times">
                        <label class="col-form-label col-md-6 Select-Site mt-0 mb-2"> Time From</label>
                        <label class="col-form-label col-md-6 Select-Site mt-0 mb-2"> Time To</label>
                        {{--<label class="col-form-label col-sm-4  Select-Site m-t-25">Booking Time</label>--}}
                        <div class="col-md-6">
                            <div class="input-group">
                                <select id="guest_time_from" placeholder="Select time from" class="calender select-room opacity-n margin-left-0 time-class" required>
                                </select>
                                <div class="right-carets">
                                    <div class="row">
                                        <div class="col-md-12 mt-0">
                                            <i class="fa fa-caret-up pull-left" aria-hidden="true"></i>
                                        </div>
                                        <div class="col-md-12 mt-0">
                                            <i class="fa fa-caret-down pull-left" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group">
                                <select id="guest_time_to"  placeholder="Select time to" class="calender select-room opacity-n margin-left-0 time-class" required>
                                </select>
                                <div class="right-carets">
                                    <div class="row">
                                        <div class="col-md-12 mt-0">
                                            <i class="fa fa-caret-up pull-left" aria-hidden="true"></i>
                                        </div>
                                        <div class="col-md-12 mt-0">
                                            <i class="fa fa-caret-down pull-left" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>


                    <hr class="hr">




                    <div class="form-group row">
                        <input type="hidden" id="guest_team_id">
                        <button type="button" class="col-sm-2    float-left btn btn-link mt-26 cancel-button" data-dismiss="modal">Cancel</button>

                        <button type="button" class="col-sm-3 offset-sm-7 float-right btn btn-success submit-button  mt-26" id="btn-add-guest">Add Visitor</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- Guest edit Modal--start--}}

<div id="edit-guest-modal" class="modal fade" tabindex="-1">
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
                            <input type="text" class="form-control" id="edit_guest_name" name="admin-user-name"
                                   required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Contact Number</label>
                        <div class="col-sm-8">
                            <input type="number" class="form-control" name="guest_contact_number" id="edit_guest_contact_number" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Guest Date</label>
                        <div class="col-sm-8">
                            <input type="date" class="form-control pickadate-year-booking" disabled id="edit_visitor_date"
                                   placeholder="CHOOSE BOOKING DATE" required>
                        </div>
                    </div>

                    <div class="form-group row" id="div_team_time_limit_from">
                        <label class="col-form-label col-sm-4">Guest Time  From</label>
                        <div class="col-sm-8">
                            <input type="date" class="form-control  pickatime-intervals-team" id="edit_guest_time_from"
                                   placeholder="Choose time from" required>
                        </div>
                    </div>
                    <div class="form-group row " id="div_team_time_limit_to">
                        <label class="col-form-label col-sm-4">Guest Time  To</label>
                        <div class="col-sm-8">
                            <input type="date" class="form-control  pickatime-intervals-team" id="edit_guest_time_to"
                                   placeholder="Choose time to" required>
                        </div>

                    </div>

                    <div class="form-group row " id="div_guest_actual_arrival_time">
                        <label class="col-form-label col-sm-4">Actual Arrival Time</label>
                        <div class="col-sm-8">
                            <input type="text" disabled class="form-control " id="edit_guest_actual_arrival_time"
                                   placeholder="Choose time to" required>
                        </div>

                    </div>



                    <div class="form-group row">
                        <input type="hidden" id="edit_guest_team_id">
                        <button type="button" class="btn bg-teal  " id="btn-update-guest">Update</button>
                        <button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

{{--  Ticket Modal--}}
<div id="add-ticket-modal" class="modal fade" tabindex="-1">
    <div class=" loading-bar "></div>
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Support Ticket</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <hr class="hr">
            <form   class="form-horizontal">

                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-form-label col-md-6 Select-Site mt-0 mb-2">Select Location</label>
                        <div class="col-md-6">
                            <select data-placeholder="Select Site" id="add_ticket_branches"
                                    class="calender select-room opacity-n margin-left-0 time-class ticket-branch" data-fouc required></select>

                        </div>
                    </div>

                    <hr class="hr-2">
                    <div class="form-group row">
                        <label class="col-form-label col-md-6 Select-Site mt-0 mb-2">Issue Type</label>
                        <div class="col-md-6">
                            <select data-placeholder="Select Issue" id="title"
                                    class="calender select-room opacity-n margin-left-0 time-class ticket-branch" data-fouc required>

                                <option>Select Category</option>
                                <option value="Internet">Internet</option>
                                <option value="UPS">UPS</option>
                                <option value="Printer">Printer</option>
                                <option value="Wash Room">Wash Room</option>
                                <option value="Electricity">Electricity</option>
                                <option value="Furniture">Furniture</option>
                                <option value="Other">Other</option>

                            </select>
                        </div>
                    </div>

                    <hr class="hr-2">
                    <div class="form-group row">
                        <label class="col-form-label col-md-2 Select-Site mt-0 mb-2">Subject</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control visitor-text" placeholder="Enter Subject" name="guest_contact_number" id="ticket_subject" maxlength="190" required>
                        </div>
                    </div>

                    <hr class="hr-2">
                    <div class="form-group row">
                        <label class="col-form-label col-md-2 Select-Site mt-0 mb-2">Description</label>
                        <div class="col-md-10">
                            {{--<input type="text" class="form-control visitor-text mt-32" placeholder="Enter Subject" name="guest_contact_number" id="guest_contact_number" required>--}}
                            <textarea rows="5" cols="5" name="description" id="description" class="form-control visitor-text" maxlength="190" placeholder="Enter your message here" ></textarea>
                        </div>
                    </div>

                    <hr class="hr-2">
                    <div class="form-group row">
                        <input type="hidden" id="guest_team_id">
                        <button type="button" class="col-sm-2    float-left btn btn-link mt-0 cancel-button mb-2" data-dismiss="modal">Cancel</button>

                        <button type="button" class="col-sm-3 offset-sm-7 float-right btn btn-success submit-button mt-0 mb-2" id="create_new_ticket">Create Ticket</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- Ticket Modal --}}

<!-- Add BookingEdit modal -->
<div id="edit_booking_modal" class="modal fade" tabindex="-1">
    <div class=" loading-bar "></div>

    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Your Booking</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <form class="form-horizontal">
                <div class="modal-body">

                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Booking Time</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="timefrom_edit" name="booking-time-hours-from" placeholder="From"  required>
                        </div>
                        <div class="col-sm-2 text-center font-weight-bold">

                        </div>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="timeto_edit" name="booking-time-hours-to" placeholder="To"  required>
                        </div>

                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Booking Date</label>
                        <div class="col-sm-8">
                            <input type="date" class="form-control pickadate-year"  id="booking_date_edit" placeholder="CHOOSE DATE" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Select Room:</label>
                        <div class="col-sm-8">
                            <select  id="book_room_edit"  class="form-control select" data-fouc required>



                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <input type="hidden" id="booking_id">
                        <button type="button" id="btn-booking-update" class="btn bg-primary">Update Booking</button>
                        <button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /Add BookingEdit modal -->


<!-- Add Printing modal -->
<div id="add_print_modal" class="modal fade" tabindex="-1">
    <div class=" loading-bar "></div>

    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Printing</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>


                <div class="modal-body">

                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Per Page Price</label>
                        <div class="col-sm-8">
                            <input type="number" readonly class="form-control" id="per_page_price" required>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Printing Balance</label>
                        <div class="col-sm-8">
                            <input type="number" readonly class="form-control" id="printing_balance" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-sm-4">Printing Quantity</label>
                        <div class="col-sm-8">
                            <input type="number" min="1" value="1" class="form-control" id="printing_quantity" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-lg-4">File Upload</label>
                        <div class="col-lg-8">
                            <input type="file" class="form-control"  id="fileuploadprint">
                        </div>
                    </div>
                    <div class="form-group row">
                        <input type="hidden" id="branch_id" value="{{ auth()->user()->branch_id }}">
                        <button type="button" id="submit_print_upload" class="btn bg-primary">Print</button>
                        <button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
        </div>
    </div>
</div>
<!-- /Add Printing modal -->




