@extends('layouts.admin.master')

@section('content')
    <!-- Main content -->
    <div class="content-wrapper">
        <!-- Content area -->
        <div class="content">

            <div class="card">
                <div class="card-header">
                    <div class="header-elements-inline">
                        <h4 class="card-title">New Invoice</h4>
                    </div>
                </div>
                <hr>

                <div class="card-body">

                    <form action="{{url('admin/finance/create/invoice')}}" method="post">
                        @csrf
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Issue to:</label>
                            <div class="col-md-10">
                                <select id="new_invoice_user" name="new_invoice_user" data-placeholder="Select user" class="form-control form-control-select2" data-fouc>
                                    @if(isset($users))
                                    @foreach($users as $user)
                                        <option value="{{$user->id}}">{{$user->name}}</option>
                                    @endforeach
                                        @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Billed to name:</label>
                            <div class="col-md-10">
                                <input type="text" readonly id="new_invoice_user_name" value="@if(isset($user)){{$user->name}}@endif" name="new_invoice_user_name" class="form-control" placeholder="Enter name" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Billed to address:</label>
                            <div class="col-md-10">
                                <input type="text" id="new_invoice_user_address" name="new_invoice_user_address" class="form-control" placeholder="Enter Address" required>
                            </div>
                        </div>

                        <div class="form-group row">

                            <label class="col-md-2 col-form-label">Invoice Date:</label>
                            <div class="col-md-4">
                                <input type="text" id="new_invoice_date" name="new_invoice_date" class="form-control daterange-single" required>
                            </div>

                            <label class="col-md-2 col-form-label">Invoice Due Date:</label>
                            <div class="col-md-4">
                                <input type="text" id="new_invoice_due_date" name="new_invoice_due_date" class="form-control daterange-single" required>
                            </div>

                        </div>

                        <div class="mt-4 mb-2 d-md-flex  justify-content-md-between flex-md-wrap">
                            <h5 class="card-title d-flex align-items-center font-weight-semibold">Items</h5>
                            <button id="add_item_invoice" class="btn bg-teal d-flex align-items-center">
                                <i class="icon-plus-circle2 mr-1"></i> Add Item </button>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <div class="card card-table table-responsive shadow-0 mb-0">
                                    <table id="invoice_items_table" name="invoice_items_table" class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>
                                                #
                                            </th>
                                            <th>
                                                Item
                                            </th>
                                            {{--<th>--}}
                                                {{--Quantity--}}
                                            {{--</th>--}}
                                            <th>
                                                Price
                                            </th>
                                            {{--<th>--}}
                                                {{--Total--}}
                                            {{--</th>--}}
                                            <th>

                                            </th>

                                        </tr>

                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>
                                                1
                                            </td>
                                            <td>
                                                <input type="text" name="item_name[]" id="item_name[]" class="form-control" placeholder="Item Name" required>
                                            </td>
                                            {{--<td>--}}
                                                {{--<input type="number" name="item_quantity[]" id="item_quantity[]" class="form-control" placeholder="Quantity" required>--}}
                                            {{--</td>--}}
                                            <td>
                                                <input type="number" name="item_price[]" id="item_price[]" min="0" class="form-control" placeholder="Price" required>

                                            </td>
                                            {{--<td>--}}
                                                {{--<span class="total_price"  name="item_total[]" id="item_total[]"></span> PKR--}}
                                            {{--</td>--}}
                                            <td></td>

                                        </tr>
                                        </tbody>
                                    </table>

                                </div>
                            </div>

                        </div>

                        <div class="form-group row">

                            <label class="col-md-2 col-form-label">Discount%:</label>
                            <div class="col-md-4">
                                <input type="number" id="new_invoice_disount" name="new_invoice_disount" class="form-control" value="0" placeholder="Enter discount %">
                            </div>

                            <label class="col-md-2 col-form-label">Tax%:</label>
                            <div class="col-md-4">
                                <input type="number" id="new_invoice_tax" min="0" max="50" name="new_invoice_tax" value="0" class="form-control" placeholder="Enter tax %">
                            </div>

                        </div>

                        <div class="form-group row">

                            <label class="col-md-2 col-form-label">Payment Note:</label>
                            <div class="col-md-10">
                                <textarea rows="5" cols="5" id="new_invoice_payment_note" name="new_invoice_payment_note" required class="form-control"  placeholder="Enter Payment Note here"></textarea>
                            </div>
                        </div>


                        <div class="mt-5 mb-2 d-md-flex  justify-content-md-between flex-md-wrap">
                            <h3 class="card-title d-flex align-items-center font-weight-semibold"> <span class="total_invoice_price ml-2" id="total_invoice_price">  </span></h3>
                            <button type="submit" id="add_item_invoice" class="btn bg-primary d-flex align-items-center">
                                Generate Invoice <i class="icon-paperplane ml-2"></i> </button>
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