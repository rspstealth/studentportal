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
                            <h3 class="">New Holidays Request</h3>
                            <hr>
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

                                    <form id="request_new_holidays" class="col-md-8" action="{{url('/request-holidays/')}}" method="POST">
                                        {{ csrf_field() }}
                                        <div class="col-md-12 no-padding">
                                            <div class="col-md-6 no-padding">
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
                                                    <div style="width:98%;" class="input-group input-append date" id="datePicker">
                                                        <input value="" placeholder="Choose a date" type="text" class="margin-top-none datepicker2 form-control lb-lg" id="from_date" name="from_date">
                                                        <span class="input-group-addon add-on"><i class="far fa-calendar-alt datepicker_icon"></i></span>
                                                        <small class="text-danger" id="from_date_errors"></small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 no-padding">
                                                <script>
                                                    $(function () {
                                                        $('.datepicker2').datepicker();
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
                                            <div class="col-md-12 no-padding">
                                                    <div class="form-group">
                                                        Description of Holidays
                                                        <div class="input-group input-append date" id="datePicker">
                                                            <textarea id="message" name="message" placeholder="Type your message here" style="min-height: 100px;" class="form-control lb-lg"></textarea>
                                                            <small class="text-danger" id="message_errors"></small>
                                                        </div>
                                                    </div>
                                            </div>
                                        </div>
                                        <input class="btn btn-primary" type="submit" id="confirmed_holiday" name="confirmed_holiday" value="Submit" />
                                    </form>
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