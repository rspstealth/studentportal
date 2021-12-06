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
                            <h3 class="">Staff Holidays <a style="float:right;" href="#" id="new_holiday_btn" title="New Staff Holiday" class="btn btn-primary">Assign New Holiday</a></h3>
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

                                <div class="table-responsive">
                                    <table class="table">
                                        <tr>
                                            <th class="rollno_col" scope="col">#</th>
                                            <th class="name_col" scope="col">Tutor Name</th>
                                            <th class="description_col" scope="col">Message</th>
                                            <th class="class_col" scope="col">From Date</th>
                                            <th class="class_col" scope="col">To Date</th>
                                            <th class="actions_col" scope="col">Actions</th>
                                        </tr>
                                        <tbody>
                                            <?php
                                                $index = 1;
                                                foreach($holidays as $holiday){
                                                ?>
                                                <tr class="record_row record_{{ $holiday->id }}">
                                                    <td><?php echo $index;?></td>
                                                    <td>
                                                        <?php
                                                        foreach($holiday_tutor_names as $tutor_id=>$tutor_name){
                                                            if($holiday->tutor_id === $tutor_id){
                                                                echo $tutor_name;
                                                            }
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>{{ $holiday->message }}</td>
                                                    <td>{{ $holiday->from_date }}</td>
                                                    <td>{{ $holiday->to_date }}</td>
                                                    <td>
                                                        <a id="delete_action_{{ $holiday->id }}" class="action_buttons delete_action btn btn-outline-secondary" href="#" title="Remove Holiday"><i class="far fa-trash-alt"></i> Remove</a>
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

                    {{--Delete Confirmation Modal--}}
                    <div id="modal_delete_action" class="modal modal_delete_action" tabindex="-1" role="dialog">
                        <div class="delete-modal-dialog modal_delete_dialog" role="document">
                            <div class="modal-content align-items-center">
                                <div class="modal-body">
                                    <h3>Confirm Remove Holiday? <a href="#" title="close dialog" id="close_delete_dialog" style="float: right;margin: 0 10px;"><i class="fa fa-close"></i></a></h2>
                                    <p>This action cannot be undone.</p>
                                </div>
                                <div class="modal-footer">
                                    <form id="del_selected_form" action="{{url('/staff-holidays/list')}}/{{$page_var}}" method="POST">
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

                    {{--holiday Modal--}}
                    <div id="modal_holiday_action" class="modal modal_holiday_action" tabindex="-1" role="dialog">
                        <div class="holiday-modal-dialog modal_holiday_dialog" role="document">
                            <div class="modal-content align-items-center" style="padding: 0 20px;">
                                <div class="modal-body">
                                    <h3>Assign New Staff Holiday <a href="#" title="close dialog" id="close_dialog" style="float: right;margin: 0 10px;"><i class="fa fa-close"></i></a></h2>
                                </div>
                                <div class="modal-footer">
                                    <form id="del_selected_form" action="{{url('/staff-holidays/list')}}/{{$page_var}}" method="POST">
                                        {{ csrf_field() }}
                                        <div class="col-md-12 no-padding">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    Tutor Name
                                                    <select class="form-control lb-lg"  id="tutor_name" name="tutor_name" >
                                                        @foreach($tutors as $tutor)
                                                        <option value="{{$tutor->id}}">{{$tutor->first_name .' '.$tutor->last_name}}</option>
                                                        @endforeach
                                                    </select>
                                                    <small class="text-danger error_msg" id="scode_errors"></small>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
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
                                                        <input value="" placeholder="Choose a date" type="text" class="margin-top-none datepicker2 form-control lb-lg" id="from_date" name="from_date">
                                                        <span class="input-group-addon add-on"><i class="far fa-calendar-alt datepicker_icon"></i></span>
                                                        <small class="text-danger" id="from_date_errors"></small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <script>
                                                    $(function () {
                                                        $('.datepicker2').datepicker({
                                                            changeMonth: true,
                                                            changeYear: true,
                                                            yearRange: "2000:2099",
                                                            dateFormat: "dd-mm-yy",
                                                            defaultDate: '<?php echo Date("18-3-2021")?>'
                                                        });
                                                    });
                                                </script>

                                                <div class="form-group">
                                                    End Date
                                                    <div class="input-group input-append date" id="datePicker">
                                                        <input value="" placeholder="Choose a date" type="text" class="margin-top-none datepicker form-control lb-lg" id="to_date" name="to_date">
                                                        <span class="input-group-addon add-on"><i class="far fa-calendar-alt datepicker_icon"></i></span>
                                                        <small class="text-danger" id="to_date_errors"></small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                    <div class="form-group">
                                                        Reason For Leave
                                                        <div class="input-group input-append date" id="datePicker">
                                                            <textarea id="message" name="message" style="min-height: 100px;" class="form-control lb-lg">On Holiday</textarea>
                                                            <small class="text-danger" id="message_errors"></small>
                                                        </div>
                                                    </div>
                                            </div>
                                        </div>

                                        <input type="hidden" id="total" name="total" value="{{$total}}" />
                                        <input type="hidden" id="totalPages" name="totalPages" value="{{$totalPages}}" />
                                        <input type="hidden" id="page_var" name="page_var" value="{{$page_var}}" />
                                        <input type="hidden" id="id" name="id" value="" />
                                        <input class="btn btn-outline-secondary " type="submit" id="confirmed_holiday" name="confirmed_holiday" value="Assign Holiday" />
                                        <button type="button" id="cancelled_holiday" class="btn btn-outline-secondary ">Cancel</button>
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

        $("#cancelled_holiday").on("click", function (e) {
            console.log("Cancelling holiday");
            $(".modal_holiday_action").hide();
        });

        $("#cancelled_delete").on("click", function (e) {
            console.log("Cancelling holiday");
            $(".modal_delete_action").hide();
        });

        $("#close_delete_dialog").on("click", function (e) {
            e.preventDefault();
            console.log("Cancelling delete");
            $(".modal_delete_action").hide();
        });

        $("#close_dialog").on("click", function (e) {
            e.preventDefault();
            console.log("Cancelling holiday");
            $(".modal_holiday_action").hide();
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
        $("#new_holiday_btn").on("click", function () {
                //process holiday request
                $("#modal_holiday_action").css('display','block');
                $("#modal_holiday_action").css({ top: '0%' });
        });

    })();
</script>
@endsection