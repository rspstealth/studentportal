@extends('layouts.dashboard')
@section('content')


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
                            <h3 class="">Announcements <a style="float:right;" href="#" id="new_annoucement_btn" title="New Annuoncement" class="btn btn-primary">Add New Announcenment</a></h3>
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