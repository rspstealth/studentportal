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
                            <h3 class="">Staff Area</h3>
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
                        <div class="col-12 staff_area_card">
                            <h3 class="no-padding">Announcements @can('create-announcements',\Illuminate\Support\Facades\Auth::user())<a href="#" class="btn btn-primary" title="Add New Announcement" id="new_announcement_btn" style="float: right;margin: -7px 0px 0px 0px;"><i class="fa fa-plus"></i> Add Announcement</a>@endcan</h3>
                            <?php
                            foreach($announcements as $announcement){
                                ?>
                            <div class="col-md-12 single_announcement">
                                <a href="#" title="Announcement Title" id="announcement_{{$announcement->id}}" class="show_hide_panel inactive">{{$announcement->headline}} <i style="float: right;margin: 10px;" id="a_{{$announcement->id}}_icon" class="fa fa-plus"></i></a>
                                <div id="announcement_{{$announcement->id}}_panel" style="display:none">
                                    <p>{{$announcement->message}}</p>
                                    @can('delete-announcements',\Illuminate\Support\Facades\Auth::user())<a href="#" id="delete_announcement_{{$announcement->id}}" class="btn btn-outline-secondary action_buttons delete_action" title="Remove Announcement"><i class="fa fa-trash-alt"></i> Remove</a>@endcan
                                </div>
                            </div>
                            <?php
                            }
                            ?>
                        </div>
                        <br>
                        <div class="col-12 staff_area_card">
                            <h3 class="no-padding">Resources @can('create-staff-resources',\Illuminate\Support\Facades\Auth::user())<a href="#" class="btn btn-primary" title="Add New Resource" id="new_resource_btn" style="float: right;margin: -7px 0px 0px 0px;"><i class="fa fa-plus"></i> Add Resource</a>@endcan</h3>
                            <?php
                            foreach($staff_resources as $resource){
                            ?>
                            <div class="col-md-12 single_resource">
                                <a href="#" title="Resource Title" id="resource_{{$resource->id}}" class="show_hide_panel inactive">{{$resource->course}} <i style="float: right;margin: 10px;" id="a_{{$resource->id}}_icon" class="fa fa-plus"></i></a>
                                <div id="resource_{{$resource->id}}_panel" style="display:none">
                                    <a download href="{{url('/')}}/public/{{$resource->resource_file}}" title="Resource File" class="btn btn-primary">Download <i class="fa fa-download"></i></a>
                                    <br>
                                    <br>
                                    <p>{{$resource->description}}</p>
                                    @can('delete-staff-resources',\Illuminate\Support\Facades\Auth::user())<a href="#" id="delete_resource_{{$resource->id}}" class="btn btn-outline-secondary action_buttons delete_action" title="Remove Resource"><i class="fa fa-trash-alt"></i> Remove</a>@endcan
                                </div>
                            </div>
                            <?php
                            }
                            ?>


                        </div>
                        
                    </div>

                    {{--announcement Modal--}}
                    <div id="modal_announcement_action" class="modal modal_announcement_action" tabindex="-1" role="dialog">
                        <div class="announcement-modal-dialog modal_announcement_dialog" role="document">
                            <div class="modal-content" style="padding: 0 20px;">
                                <div class="modal-body">
                                    <h3>New Announcement<a href="#" title="close dialog" id="close_announcement_dialog" style="float: right;margin: 0 10px;"><i class="fa fa-close"></i></a></h3>
                                </div>
                                <div class="modal-footer">
                                    <form id="del_selected_form" style="text-align: left" action="{{url('/staff-area/')}}" method="post">
                                        {{ csrf_field() }}
                                        <div class="col-md-12 no-padding">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    Headline
                                                    <input type="text" id="headline" name="headline" class="form-control lb-lg"/>
                                                    <small class="text-danger error_msg" id="headline_errors"></small>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    Message
                                                    <div class="input-group input-append date" id="datePicker">
                                                        <textarea id="message" name="message" style="min-height: 100px;" class="form-control lb-lg">On Holiday</textarea>
                                                        <small class="text-danger" id="message_errors"></small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" id="method" name="method" value="announcement" />
                                        <input class="btn btn-outline-secondary " type="submit" id="confirmed_announcement" name="confirmed_announcement" value="Submit" />
                                        <button type="button" id="cancelled_announcement" class="btn btn-outline-secondary ">Cancel</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{--resource Modal--}}
                    <div id="modal_resource_action" class="modal modal_resource_action" tabindex="-1" role="dialog">
                        <div class="resource-modal-dialog modal_resource_dialog" role="document">
                            <div class="modal-content" style="padding: 0 20px;">
                                <div class="modal-body">
                                    <h3>New Resource<a href="#" title="close dialog" id="close_resource_dialog" style="float: right;margin: 0 10px;"><i class="fa fa-close"></i></a></h3>
                                </div>
                                <div class="modal-footer">
                                    <form id="add_resource_form" style="text-align: left" action="{{url('/staff-area/')}}" method="POST" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <div class="col-md-12 no-padding">
                                            <div class="col-md-12 no-padding">
                                                <div class="form-group">
                                                    Visible To:
                                                    <select name="shared_with" id="shared_with" class="form-control lb-lg">
                                                        <option value="all">All</option>
                                                        <option value="tutors">Tutors</option>
                                                        <option value="admin_support">Admin Support</option>
                                                        <option value="iv">IV</option>
                                                    </select>
                                                    <small class="text-danger error_msg" id="shared_with_errors"></small>
                                                </div>
                                            </div>
                                            <div class="col-md-12 no-padding">
                                                <div class="form-group">
                                                    Course
                                                    <input type="text" id="course" name="course" class="form-control lb-lg"/>
                                                    <small class="text-danger error_msg" id="course_errors"></small>
                                                </div>
                                            </div>
                                            <div class="col-md-12 no-padding">
                                                <div class="form-group">
                                                    Upload File
                                                    <input type="file" id="resource_file" name="resource_file" class="form-control lb-lg"/>
                                                    <small class="text-danger error_msg" id="resource_file_errors"></small>
                                                </div>
                                            </div>
                                            <div class="col-md-12 no-padding">
                                                <div class="form-group">
                                                        Description
                                                        <textarea id="description" name="description" style="min-height: 100px;" class="form-control lb-lg"></textarea>
                                                        <small class="text-danger" id="description_errors"></small>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" id="method" name="method" value="resource" />
                                        <input class="btn btn-outline-secondary" type="submit" id="confirmed_resource" name="confirmed_resource" value="Add Resource" />
                                        <button type="button" id="cancelled_resource" class="btn btn-outline-secondary ">Cancel</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{--Delete Confirmation Modal--}}
                    <div id="modal_delete_announcement_action" class="modal modal_delete_announcement_action" tabindex="-1" role="dialog">
                        <div class="delete-announcement-modal-dialog modal_delete_announcement_dialog" role="document">
                            <div class="modal-content align-items-center">
                                <div class="modal-body">
                                    <h3>Confirm Delete Announcement? <a href="#" title="close dialog"
                                                                   id="close_delete_announcement_dialog"
                                                                   style="float: right;margin: 0 10px;"><i
                                                    class="fa fa-close"></i></a></h3>
                                    <p>This action cannot be undone.</p>
                                </div>
                                <div class="modal-footer">
                                    <form id="del_selected_form"
                                          action="{{url('/staff-area')}}" method="POST">
                                        {{ method_field('delete') }}
                                        {{ csrf_field() }}
                                        <input type="hidden" id="id" name="id" value=""/>
                                        <input type="hidden" id="delete_type" name="delete_type" value="announcement"/>
                                        <input class="btn btn-outline-secondary " type="submit"
                                               id="confirmed_delete_announcement" name="confirmed_delete_announcement" value="Delete"/>
                                        <button type="button" id="cancelled_delete_announcement"
                                                class="btn btn-outline-secondary ">Cancel
                                        </button>
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
            $(".modal_delete_announcement_action").hide();
        });

        $("#cancelled_delete_announcement").on("click", function (e) {
            $(".modal_delete_announcement_action").hide();
        });

        $("#close_delete_dialog").on("click", function (e) {
            e.preventDefault();
            $(".modal_delete_announcement_action").hide();
        });
        $("#close_delete_announcement_dialog").on("click", function (e) {
            e.preventDefault();
            $(".modal_delete_announcement_action").hide();
        });

        $("#close_announcement_dialog").on("click", function (e) {
            e.preventDefault();
            $(".modal_announcement_action").hide();
        });
        $("#close_resource_dialog").on("click", function (e) {
            e.preventDefault();
            $(".modal_resource_action").hide();
        });
        $("#cancelled_announcement").on("click", function (e) {
            e.preventDefault();
            $(".modal_announcement_action").hide();
        });

        $("#cancelled_resource").on("click", function (e) {
            e.preventDefault();
            $(".modal_resource_action").hide();
        });

        $(".delete_action").on("click", function (e) {
            e.preventDefault();
            $("#modal_delete_announcement_action").css('display','block');

            $("#modal_delete_announcement_action").css({ top: '0%' });
            console.log("Processing Del Request:"+this.id);
            var str = this.id;
            var ids = str.split(/[\s_]+/);
            console.log("type:" + ids[1]);
            console.log("SPLITTED:" + ids[2]);
            $("#id").val(ids[2]);
            $("#type").val(ids[1]);
        });

        //get anchor id => delete_action_{1} and concatenate it to create modal id
        $("#new_announcement_btn").on("click", function () {
                //process announcement request
                $("#modal_announcement_action").css('display','block');
                $("#modal_announcement_action").css({ top: '0%' });
        });

        //get anchor id => delete_action_{1} and concatenate it to create modal id
        $("#new_resource_btn").on("click", function () {
                //process announcement request
                $("#modal_resource_action").css('display','block');
                $("#modal_resource_action").css({ top: '0%' });
        });

        $(".show_hide_panel").on("click", function (e) {
            e.preventDefault();
            var panel_id = this.id;
            $('#'+panel_id+'_panel').slideToggle();
            if ($("#"+panel_id).hasClass("active")) {
                console.log("ACTIVE:::");
                $("#"+panel_id).removeClass("active");
                $("#"+panel_id).addClass("inactive");
                $("#"+panel_id+ ' i').removeClass("fa-minus");
                $("#"+panel_id+ ' i').addClass("fa-plus");
               // $("#"+panel_id+' i').html('Title <i style="float: right;margin: 10px;;" class="fa fa-plus"></i>');
            }else if($("#"+panel_id).hasClass("inactive")){
                console.log("NOT ACTIVE:::");
                $("#"+panel_id).removeClass("inactive");
                $("#"+panel_id).addClass("active");
                $("#"+panel_id+ ' i').removeClass("fa-plus");
                $("#"+panel_id+ ' i').addClass("fa-minus");
               // $("#"+panel_id+' span').html('Title <i style="float: right;margin: 10px;" class="fa fa-minus"></i>');
            }
        });

    })();
</script>
@endsection