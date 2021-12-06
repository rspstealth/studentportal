@extends('layouts.dashboard')
@section('content')
    <div class="wrapper" id="header">
        <div class="container">
            <div class="row">
                <div id="header_left" class="col-md-6">
                    <a href="#" class="logo"><h2><b>Student Portal</b></h2></a>
                </div>
                <div id="header_right" class="col-md-6">
                    @include('layouts.my-account')
                </div>
            </div>
        </div>
    </div>

    <div class="container main-content">
        <div class="row col-md-12 no-padding">
            <div id="sidebar-menu" class="col-md-2">
                <ul class="nav navbar-nav">
                    @include('layouts.get-user-menu')
                </ul>
            </div>
            <div id="right-content" class="col-md-10">
                <div class="row justify-content-center">

                    <div class="col-12 col-lg-12 col-xl-12">
                        <div class="col-6">
                            <h3 class="">Revenues <a style="float:right;" href="#" id="add_credit_btn" title="Add Credit" class="btn btn-primary">Add Credit</a><a style="float:right;margin-right:10px;" href="#" id="add_sale_btn" title="Add Sales Entry" class="btn btn-primary">Add Sales Entry</a></h3>
                        </div>
                        @if(session()->has('message'))
                            <div class="alert alert-success">
                                {{ session()->get('message') }}
                            </div>
                        @endif
                        @if(session()->has('error'))
                            <div class="alert alert-danger">
                                {{ session()->get('error') }}
                            </div>
                        @endif

                        <div class="row justify-content-center">
                            <div class="col-12 col-lg-12 col-xl-12" style="border-radius:6px;border:1px solid #dcdcdc;padding:20px;background:#f5f5f5;margin:0 2% 2% 2%;width:96%;">
                                <form id="" action="{{url('/revenue/list')}}/{{$page_var}}"
                                      method="GET">
                                    {{ csrf_field() }}
                                <div class="col-md-8 no-padding">
                                    <div class="col-md-12 no-padding">
                                        <h4 style="margin:0;padding:0 0 20px 0;">Choose a date range to display sales records:</h4>
                                    </div>
                                    <div class="col-md-5 no-padding">
                                        <link media="all" type="text/css" rel="stylesheet" href="{{ url("/") }}/css/datepicker/css/datepicker.css">
                                        <script src="{{ url("/") }}/css/datepicker/js/bootstrap-datepicker.js">
                                        </script>
                                        <script>
                                            $(function () {
                                                $('.datepicker').datepicker();
                                            });
                                        </script>
                                        <div class="form-group">
                                            Start Date
                                            <div class="input-group input-append date" id="datePicker">
                                                <input style="width:98%;" value="<?php if(!empty(Request::input('from_date'))){echo $_GET['from_date'];}?>" placeholder="Choose a date" type="text" class="margin-top-none datepicker2 form-control lb-lg" id="from_date" name="from_date">
                                                <span class="input-group-addon add-on"><i class="far fa-calendar-alt datepicker_icon"></i></span>
                                                <small class="text-danger" id="from_date_errors"></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-5 no-padding">
                                        <script>
                                            $(function () {
                                                $('.datepicker').datepicker();
                                            });
                                        </script>
                                        <div class="form-group">
                                           Estimate Completion Date
                                            <div class="input-group input-append date" id="datePicker">
                                                <input style="width:98%;" value="<?php if(!empty(Request::input('estimated_completion_date'))){echo $_GET['estimated_completion_date'];}?>" placeholder="Choose a date" type="text" class="margin-top-none datepicker2 form-control lb-lg" id="estimated_completion_date" name="estimated_completion_date">
                                                <span class="input-group-addon add-on"><i class="far fa-calendar-alt datepicker_icon"></i></span>
                                                <small class="text-danger" id="estimated_completion_date_errors"></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 no-padding">
                                        <div class="form-group">
                                        <br>
                                        <input type="submit" style="height: 34px;" class="btn btn-outline-secondary full-width" value="Apply"/>
                                        </div>
                                    </div>
                                </div>
                                </form>
                                <div class="col-md-4">
                                    <div class="col-md-12 no-padding">
                                        <h4 style="margin:8px 0; padding:0;"><i class="far fa-file-alt"></i> <a style="text-decoration: underline" href="#" title="View Past Invoices">View Past Invoices</a></h4>
                                    </div>
                                    <?php
                                    if( count($revenues) > 0){
                                    ?>
                                        <div class="col-md-12 no-padding">
                                            <h4 style="margin:8px 0; padding:0;"><i class="far fa-file-alt"></i> <a style="text-decoration: underline" href="{{url('/revenue/invoice').'/?from_date='.Request::input("from_date").'&estimated_completion_date='.Request::input("estimated_completion_date")}}" title="Generate Invoice For Dates">Generate Invoice For Dates</a>
                                            </h4>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                    <div class="col-md-12 no-padding">
                                        <h4 style="margin:8px 0; padding:0;"><i class="far fa-file-alt"></i> <a style="text-decoration: underline" href="#" title="Download Sales Report">Download Sales Report</a>
                                        </h4>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-lg-12 col-xl-12">
                                <div class="table-responsive">
                                    <table class="table">
                                        <tr>
                                            <th class="rollno_col" scope="col">Date</th>
                                            <th class="name_col" scope="col">Student Number</th>
                                            <th class="description_col" scope="col">Description / Course</th>
                                            <th class="class_col" scope="col">Cost</th>
                                            <th class="name_col" scope="col">Running Total</th>
                                            <th class="actions_col" scope="col">Actions</th>
                                        </tr>
                                        <tbody>
                                            <?php
                                                $index = 1;
                                                $running_total = 0;
                                                foreach($revenues as $revenue){
                                                ?>
                                                <tr class="record_row record_{{ $revenue->id }}">
                                                    <td>
                                                        {{ date("d-m-Y", strtotime($revenue->date)) }}
                                                    </td>
                                                    <td>{{ $revenue->student_number }}</td>
                                                    <td>{{ $revenue->description }}</td>
                                                    <td>{{ $revenue->cost }}</td>
                                                    <td>
                                                        <?php
                                                        if($revenue->entry_type === 'sale') {
                                                            $running_total += $revenue->cost;
                                                        }else{
                                                            $running_total -= $revenue->cost;
                                                        }
                                                        echo $running_total;
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <a id="delete_action_{{ $revenue->id }}" class="action_buttons delete_action btn btn-outline-secondary" href="#" title="Remove Record"><i class="far fa-trash-alt"></i> Void Record</a>
                                                    </td>
                                                </tr>
                                            <?php
                                                $index++;
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                    <div id="filters_out_form" class="col-md-12 text-right" style="margin-top: 16px;">
                                        Records found: <span class="numeric_big">{{$total}}</span>&nbsp;
                                        Page: <span class="numeric_big">{{$page_var}}</span> of <span class="numeric_big">{{$totalPages}}</span>
                                        <?php
                                        if($total>0){
                                        if($page_var > 1){
                                        ?>
                                        <a class="action_buttons" href="{{url('/students')}}/list/{{$page_var-1}}?_token={{ csrf_token() }}&start_date={{((Request::query('start_date')) ? Request::query('start_date') : '' )}}&end_date={{(Request::query('end_date') ?: print Request::query('end_date')  )}}&search_by_name_or_number={{((Request::query('search_by_name_or_number')) ? Request::query('search_by_name_or_number') : '' )}}&filter_by_course={{((Request::query('filter_by_course')) ? Request::query('filter_by_course') : "" )}}&student_status={{((Request::query('student_status')) ? Request::query('student_status') : "" )}}&sort_by={{((Request::query('sort_by')) ? Request::query('sort_by') : "" )}}&filter_by_college={{((Request::query('filter_by_college')) ? Request::query('filter_by_college') : "" )}}" title="Previous"><i class="fas fa-chevron-left"> </i> Previous</a>
                                        <?php
                                        }
                                        ?>
                                        <?php
                                        //eg: total 5 > current 5
                                        if($page_var  < $totalPages){
                                        ?>
                                        <a class="action_buttons" href="{{url('/students')}}/list/{{$page_var+1}}?_token={{ csrf_token() }}&start_date={{((Request::query('start_date')) ? Request::query('start_date') : "" )}}&end_date={{(Request::query('end_date') ?: print Request::query('end_date') )}}&search_by_name_or_number={{((Request::query('search_by_name_or_number')) ? Request::query('search_by_name_or_number') : "" )}}&filter_by_course={{((Request::query('filter_by_course')) ? Request::query('filter_by_course') : "" )}}&student_status={{((Request::query('student_status')) ? Request::query('student_status') : "" )}}&sort_by={{((Request::query('sort_by')) ? Request::query('sort_by') : "" )}}&filter_by_college={{((Request::query('filter_by_college')) ? Request::query('filter_by_college') : "" )}}" title="Next">Next <i class="fas fa-chevron-right"></i></a>
                                        <?php
                                        }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            </div>
                    </div>

                    {{--Delete Confirmation Modal--}}
                    <div id="modal_delete_action" class="modal modal_delete_action" style="    z-index: 99999;" tabindex="-1" role="dialog">
                        <div class="delete-modal-dialog modal_delete_dialog" role="document">
                            <div class="modal-content align-items-center">
                                <div class="modal-body">
                                    <h3>Confirm Remove Record? <a href="#" title="close dialog" id="close_delete_dialog" style="float: right;margin: 0 10px;"><i class="fa fa-close"></i></a></h3>
                                    <p>This action cannot be undone.</p>
                                </div>
                                <div class="modal-footer">
                                    <form id="del_selected_form" action="{{url('/revenue/list')}}/{{$page_var}}" method="POST">
                                        {{ method_field('delete') }}
                                        {{ csrf_field() }}
                                        <input type="hidden" id="total" name="total" value="{{$total}}" />
                                        <input type="hidden" id="totalPages" name="totalPages" value="{{$totalPages}}" />
                                        <input type="hidden" id="page_var" name="page_var" value="{{$page_var}}" />
                                        <input type="hidden" id="id" name="id" value="" />
                                        <input class="btn btn-outline-secondary " type="submit" id="confirmed_delete" name="confirmed_delete" value="Delete" />
                                        <button type="button" id="cancelled_delete" class="btn btn-outline-secondary ">Cancel</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{--revenue Modal--}}
                    <div id="modal_revenue_action" class="modal modal_revenue_action" tabindex="-1" role="dialog">
                        <div class="revenue-modal-dialog modal_revenue_dialog" role="document">
                            <div class="modal-content" style="padding: 0 20px;">
                                <div class="modal-body">
                                    <h3>Add Sales Entry <a href="#" title="close dialog" id="close_dialog" style="float: right;margin: 0 10px;"><i class="fa fa-close"></i></a></h3>
                                </div>
                                <div class="modal-footer">
                                    <form id="add_sales_form" style="text-align:left;" action="{{url('/revenue/list')}}/{{$page_var}}" method="POST">
                                        {{ csrf_field() }}
                                        <div class="col-md-12 no-padding">
                                            <div class="col-md-12 no-padding">
                                                <script>
                                                    $(function () {
                                                        $('.datepicker').datepicker({
                                                            changeMonth: true,
                                                            changeYear: true,
                                                            yearRange: "2000:2099",
                                                            dateFormat: "dd-mm-yy",
                                                            defaultDate: '<?php echo Date("18-3-2021")?>'
                                                        });
                                                    });
                                                </script>

                                                <div class="form-group">
                                                    Date
                                                    <div class="input-group input-append date" id="datePicker">
                                                        <input value=""
                                                               placeholder="Choose a date" type="text"
                                                               class="margin-top-none datepicker form-control lb-lg"
                                                               id="invoice_date" name="invoice_date">
                                                        <span class="input-group-addon add-on"><i
                                                                    class="far fa-calendar-alt datepicker_icon"></i></span>
                                                        <small class="text-danger" id="invoice_date_errors"></small>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12 no-padding">
                                                    <div class="form-group">
                                                        Description
                                                            <textarea id="description" placeholder="Description" name="description" style="min-height: 100px;" class="form-control lb-lg"></textarea>
                                                            <small class="text-danger" id="description_errors"></small>
                                                    </div>
                                            </div>
                                            <div class="col-md-12 no-padding">
                                                <div class="form-group">
                                                    £
                                                    <input type="number" placeholder="Cost" name="cost" id="cost" class="form-control lb-lg"/>
                                                </div>
                                            </div>
                                        </div>

                                        <input type="hidden" id="entry_type" name="entry_type" value="sale" />
                                        <input class="btn btn-outline-secondary " type="submit" id="add_sale" name="add_sale" value="Submit" />
                                        <button type="button" id="cancelled_sale" class="btn btn-outline-secondary ">Cancel</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{--credit Modal--}}
                    <div id="modal_credit_action" class="modal modal_credit_action" tabindex="-1" role="dialog">
                        <div class="credit-modal-dialog modal_credit_dialog" role="document">
                            <div class="modal-content" style="padding: 0 20px;">
                                <div class="modal-body">
                                    <h3>Add Credit Entry <a href="#" title="close dialog" id="close_dialog" style="float: right;margin: 0 10px;"><i class="fa fa-close"></i></a></h3>
                                </div>
                                <div class="modal-footer">
                                    <form id="add_credit_form" style="text-align:left;" action="{{url('/revenue/list')}}/{{$page_var}}" method="POST">
                                        {{ csrf_field() }}
                                        <div class="col-md-12 no-padding">
                                            <div class="col-md-12 no-padding">
                                                <script>
                                                    $(function () {
                                                        $('.datepicker').datepicker({
                                                            changeMonth: true,
                                                            changeYear: true,
                                                            yearRange: "2000:2099",
                                                            dateFormat: "dd-mm-yy",
                                                            defaultDate: '<?php echo Date("18-3-2021")?>'
                                                        });
                                                    });
                                                </script>

                                                <div class="form-group">
                                                    Date
                                                    <div class="input-group input-append date" id="datePicker">
                                                        <input value=""
                                                               placeholder="Choose a date" type="text"
                                                               class="margin-top-none datepicker form-control lb-lg"
                                                               id="invoice_date" name="invoice_date">
                                                        <span class="input-group-addon add-on"><i
                                                                    class="far fa-calendar-alt datepicker_icon"></i></span>
                                                        <small class="text-danger" id="invoice_date_errors"></small>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12 no-padding">
                                                <div class="form-group">
                                                    Description
                                                    <textarea id="description" placeholder="Description" name="description" style="min-height: 100px;" class="form-control lb-lg"></textarea>
                                                    <small class="text-danger" id="description_errors"></small>
                                                </div>
                                            </div>
                                            <div class="col-md-12 no-padding">
                                                <div class="form-group">
                                                    Student Number
                                                    <input type="text" placeholder="Student Number" name="student_number" id="student_number" class="form-control lb-lg"/>
                                                </div>
                                            </div>
                                            <div class="col-md-12 no-padding">
                                                <div class="form-group">
                                                    £
                                                    <input type="number" placeholder="Cost" name="cost" id="cost" class="form-control lb-lg"/>
                                                </div>
                                            </div>
                                        </div>

                                        <input type="hidden" id="entry_type" name="entry_type" value="credit" />
                                        <input class="btn btn-outline-secondary " type="submit" id="add_credit" name="add_credit" value="Submit" />
                                        <button type="button" id="cancelled_credit" class="btn btn-outline-secondary ">Cancel</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    
                </div>
        </div>
    </div>
    </div>

<script>
    (function(){
        setTimeout(function() {
            $('.alert-success').fadeOut('slow');
        }, 3000); // <-- time in milliseconds
        setTimeout(function() {
            $('.alert-danger').fadeOut('slow');
        }, 3000); // <-- time in milliseconds

        $("#cancelled_revenue").on("click", function (e) {
            console.log("Cancelling revenue");
            $(".modal_revenue_action").hide();
        });
        $("#cancelled_credit").on("click", function (e) {
            console.log("Cancelling revenue");
            $(".modal_credit_action").hide();
        });

        $("#cancelled_delete").on("click", function (e) {
            console.log("Cancelling revenue");
            $(".modal_delete_action").hide();
        });

        $("#close_delete_dialog").on("click", function (e) {
            e.preventDefault();
            console.log("Cancelling delete");
            $(".modal_delete_action").hide();
        });

        $("#close_dialog").on("click", function (e) {
            e.preventDefault();
            console.log("Cancelling revenue");
            $(".modal_revenue_action").hide();
            $(".modal_credit_action").hide();
        });

        $(".delete_action").on("click", function (e) {
            e.preventDefault();
            $("#modal_delete_action").css('display','block');
            $("#modal_delete_action").css({ top: '0%' });
            console.log("Processing Del Request:"+this.id);
            var str = this.id;
            var ids = str.split(/[\s_]+/);
            console.log("SPLITTED:" + ids[2]);
            $("#id").val(ids[2]);
        });

        //get anchor id => delete_action_{1} and concatenate it to create modal id
        $("#add_sale_btn").on("click", function () {
                //process revenue request
                $("#modal_revenue_action").css('display','block');
                $("#modal_revenue_action").css({ top: '0%' });
        });

        $("#add_credit_btn").on("click", function () {
                //process revenue request
                $("#modal_credit_action").css('display','block');
                $("#modal_credit_action").css({ top: '0%' });
        });

    })();
</script>
@endsection