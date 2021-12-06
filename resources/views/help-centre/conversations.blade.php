@extends('layouts.conversation')
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
                    <div class="col-md-12">
                        <a style="margin-top: 20px;" href="{{url('/task-management/list/1')}}" id="" title="Back to Tasks List" class="btn btn-outline-secondary "><i class="fas fa-arrow-left"></i> Back to Tasks</a>
                        @can('edit-tasks',\Illuminate\Support\Facades\Auth::user())
                        <a class="edit_task_btn btn btn-primary float-right" style="margin-top: 20px;" href="#" id="" title="Edit Task" class="btn btn-outline-secondary "><i class="fa fa-edit"></i> Edit Task</a>
                        @endcan
                        <hr style="margin: 20px 0"/>
                    </div>
                    <div class="col-12 col-lg-12 col-xl-12">
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
                        <div class="app_notifications label label-success" id="success-alert">
                            <h3>Course Updated Successfully</h3>
                        </div>

                    </div>

                    <div class="col-md-12">
                            <form id="task_form" action="{{url('/task-management/list')}}/{{$task->id}}" method="GET">
                                {{ csrf_field() }}
                                <div class="card single-task">
                                    <div class="col-md-2 text-center single-task-left">
                                        <div class="form-group">
                                            <img class="profile_thumb" src="<?php
                                            if($task->created_by === $logged_in_user->user_id){
                                                echo url("/").'/public/'.$logged_in_user->photo_id;
                                            }elseif($task->created_by === $other_user->user_id){
                                                echo url("/").'/public/'.$other_user->photo_id;
                                            }
                                            ?>" alt="user photo"/>
                                            <br>
                                            <br>
                                            <span>
                                                <?php
                                                if($task->created_by === $logged_in_user->user_id){
                                                    echo $logged_in_user->first_name.' '.$logged_in_user->last_name;
                                                }elseif($task->created_by === $other_user->user_id){
                                                    echo $other_user->first_name.' '.$other_user->last_name;
                                                }
                                                ?>
                                                </span>
                                            <br>
                                            <span>(<?php
                                                if($task->created_by === $logged_in_user->user_id){
                                                    echo $logged_in_user_role;
                                                }elseif($task->created_by === $other_user->user_id){
                                                    echo $other_user_role;
                                                }
                                                ?>)</span>
                                        </div>
                                    </div>
                                    <div class="col-md-10 single-task-right">
                                        <div class="form-group">
                                            <h4 style="margin-bottom: 0;margin: 0;padding-top: 5px;padding-bottom: 5px;">{{$task->subject}}<?php if($task->priority === 'low'){
                                                    echo ' ( <span><i style="color: cadetblue;" class="fas fa-level-down-alt"></i> Low</span> )';
                                                }elseif($task->priority === 'medium'){
                                                    echo ' ( <span><i style="color:darkorange" class="fas fa-level-up-alt"></i> Medium</span> )';
                                                }if($task->priority === 'high'){
                                                    echo ' ( <span><i style="color:orangered" class="fas fa-level-up-alt"></i> High</span> )';
                                                }
                                                ?>
                                            </h4>
                                            <span>
                                                {{$task->description}}
                                            </span>
                                            <br>
                                            <br>
                                            <p>Task Started: <span style="color:black;">{{date("d-m-Y", strtotime($task->start_date))}}</span></p>
                                            <p>Estimated Completion Date: <span style="color:black;">{{date("d-m-Y", strtotime($task->estimated_completion_date))}} ( {{\Carbon\Carbon::parse($task->estimated_completion_date)->diffForHumans()}} )</span></p>
                                        </div>
                                    </div>
                                </div>
                            </form>
                                <div id="conversation_box" class="col-md-12 no-padding">
                                    <?php

                                    if(count($messages) > 0){
                                        foreach($messages as $message){
//                                            echo '$logged_in_user->user_id:'.$logged_in_user->user_id;
//                                            echo '$other_user:'.$other_user->photo_id;
                                            //if tassk initiated by logged in usser
                                            if($message->initiator === $task->created_by){
                                                echo '<div class="chat_message initiator_message">
                                            <div class="col-md-2 text-center">
                                                    <img class="profile_thumb" src="';
                                                if($message->initiator === $logged_in_user->user_id){
                                                    echo url("/").'/public/'.$logged_in_user->photo_id;
                                                }elseif($message->initiator === $other_user->user_id){
                                                    echo url("/").'/public/'.$other_user->photo_id;
                                                }
                                                echo '" alt=""/><br><span>';
                                                if($message->initiator === $logged_in_user->user_id){
                                                    echo $logged_in_user->first_name.' '.$logged_in_user->last_name;
                                                }elseif($message->initiator === $other_user->user_id){
                                                    echo $other_user->first_name.' '.$other_user->last_name;
                                                }
                                                echo '</span>
                                            </div>
                                                <div class="col-md-10"><p>'.$message->message;
                                                echo '</p><br>';
                                                echo '<small class="message_time">'.date("d-m-Y h:m:s", strtotime($message->created_at)).'</small>';
                                                echo '</div></div>';
                                            }

                                            if($message->initiator !== $task->created_by){
                                                echo '<div class="chat_message assigned_to_message">

                                                <div class="col-md-10"><p>'.$message->message;
                                                echo '</p><br>';
                                                echo '<small class="message_time">'.date("d-m-Y h:m:s", strtotime($message->created_at)).'</small>';
                                                echo '</div>';
                                                echo '<div class="col-md-2 text-center">
                                                    <img class="profile_thumb" src="';
                                                if($message->initiator === $logged_in_user->user_id){
                                                    echo url("/").'/public/'.$logged_in_user->photo_id;
                                                }elseif($message->initiator === $other_user->user_id){
                                                    echo url("/").'/public/'.$other_user->photo_id;
                                                }
                                                echo '" alt=""/><br><span>';
                                                if($message->initiator === $logged_in_user->user_id){
                                                    echo $logged_in_user->first_name.' '.$logged_in_user->last_name;
                                                }elseif($message->initiator === $other_user->user_id){
                                                    echo $other_user->first_name.' '.$other_user->last_name;
                                                }
                                                echo '</span>
                                            </div>';
                                                echo '</div>';
                                            }

                                        }
                                    }else{
                                        echo 'No conversation yet.';
                                    }
                                    ?>
                                </div>
                                <div style="margin-top:10px;" class="col-md-12 no-padding">



                                    <form action="{{url('/task-management/conversation')}}/{{$task->id}}" method="POST">
                                        {{ csrf_field() }}
                                        <div class="form-group">
                                            <input type="hidden" id="creator_id" name="creator_id" value="{{$task->created_by}}"/>
                                            <input type="hidden" id="task_id" name="task_id" value="{{$task->id}}"/>
                                            <input type="hidden" id="assigned_to" name="assigned_to" value="{{$task->assigned_to}}"/>
                                            <textarea placeholder="Write your message..." name="message" id="message" cols="1" rows="6" class="form-control lb-lg"></textarea>
                                        </div>
                                        <input class="btn btn-primary" type="submit" id="send_message" name="send_message" value="Send Message" />
                                    </form>
                                </div>


                        {{--new task modal--}}
                        <div id="modal_task_action" class="modal modal_task_action" tabindex="-1" role="dialog">
                            <div class="task-modal-dialog modal_task_dialog" role="document">
                                <div class="modal-content align-items-center" style="padding: 0 20px;">
                                    <div class="modal-body">
                                        <h3>Update task <a href="#" title="close dialog" id="close_dialog" style="float: right;margin: 0 10px;"><i class="fa fa-close"></i></a></h3>
                                    </div>
                                    <div class="modal-footer">
                                        <form id="edit_task_form" action="{{url('/task-management/conversation//')}}/{{$task->id}}" method="POST">
                                            {{ csrf_field() }}
                                            <div class="col-md-12 no-padding">
                                                <div class="col-md-12 no-padding">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            Subject
                                                            <input required="" class="form-control lb-lg"  id="subject" name="subject" />
                                                            <small class="text-danger error_msg" id="subject_errors"></small>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            Description ( Max Characters : 100 )
                                                            <textarea maxlength="100" id="description" name="description" class="form-control lb-lg" cols="1" rows="2"></textarea>
                                                            <small class="text-danger error_msg" id="description_errors"></small>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12 no-padding">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                Status
                                                                <select id="status" name="status"  class="form-control lb-lg">
                                                                    <option value="open">Open</option>
                                                                    <option value="closed">Closed</option>
                                                                </select>
                                                                <small class="text-danger error_msg" id="status_errors"></small>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                Assign To
                                                                <select id="task_assigned_to" name="task_assigned_to"  class="form-control lb-lg">
                                                                    <option value="">No option selected</option>
                                                                    <option disabled><b>Tutors</b></option>
                                                                    <?php
                                                                    foreach($tutors as $tutor){
                                                                        echo '<option value="'.$tutor->user_id.'">'.$tutor->first_name.' '.$tutor->last_name.'</option>';
                                                                    }
                                                                    ?>

                                                                </select>
                                                                <small class="text-danger error_msg" id="task_assigned_to_errors"></small>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                Priority
                                                                <select id="priority" name="priority"  class="form-control lb-lg">
                                                                    <option value=low>Low</option>
                                                                    <option value="medium">Medium</option>
                                                                    <option value="high">High</option>
                                                                </select>
                                                                <small class="text-danger error_msg" id="priority_errors"></small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 no-padding">
                                                        <div class="col-md-6">
                                                            <link media="all" type="text/css" rel="stylesheet" href="{{ url("/") }}/css/datepicker/css/datepicker.css">
                                                            <script src="{{ url("/") }}/css/datepicker/js/bootstrap-datepicker.js">
                                                            </script>
                                                            <script>
                                                                $(function () {
                                                                    $('.datepicker').datepicker({format: 'dd/mm/yyyy'});
                                                                });
                                                            </script>
                                                            <div class="form-group">
                                                                Start Date
                                                                <div class="input-group input-append date" id="datePicker">
                                                                    <input value="" placeholder="Choose a date" type="text" class="margin-top-none datepicker form-control lb-lg" id="start_date" name="start_date">
                                                                    <span class="input-group-addon add-on"><i class="far fa-calendar-alt datepicker_icon"></i></span>
                                                                    <small class="text-danger" id="start_date_errors"></small>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <script>
                                                                $(function () {
                                                                    $('.datepicker2').datepicker({format: 'dd/mm/yyyy'});
                                                                });
                                                            </script>
                                                            <div class="form-group">
                                                                End Date
                                                                <div class="input-group input-append date" id="datePicker">
                                                                    <input value="" placeholder="Choose a date" type="text" class="margin-top-none datepicker2 form-control lb-lg" id="end_date" name="end_date">
                                                                    <span class="input-group-addon add-on"><i class="far fa-calendar-alt datepicker_icon"></i></span>
                                                                    <small class="text-danger" id="end_date_errors"></small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <input type="hidden" id="method" name="method" value="edit_task" />
                                            <input type="hidden" id="task_id" name="task_id" value="{{$task->id}}" />
                                            <div class="col-md-12">
                                                <hr/>
                                                <input class="btn btn-primary" type="submit" id="confirmed_task" name="confirmed_task" value="Create task" />
                                                <button type="button" id="cancelled_task" class="btn btn-outline-secondary ">Cancel</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
      <script type="text/javascript">
        tinymce.init({
            selector: '#message',
            height: 200,
            menubar: false,
            statusbar: false,
            plugins: [
                'advlist autolink lists link image charmap print preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table paste code help wordcount'
            ],
            toolbar: 'undo redo | formatselect | ' +
                'bold italic forecolor backcolor | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'removeformat | help',
            content_css: '//www.tiny.cloud/css/codepen.min.css'
        });
    </script>
<script>
    (function(){
        setTimeout(function() {
            $('.alert-success').fadeOut('slow');
        }, 3000); // <-- time in milliseconds
        setTimeout(function() {
            $('.alert-danger').fadeOut('slow');
        }, 3000); // <-- time in milliseconds

        $("#cancelled_task").on("click", function (e) {
            console.log("Cancelling course");
            $(".modal_task_action").hide();
        });

        $("#close_dialog").on("click", function (e) {
            e.preventDefault();
            console.log("Cancelling course");
            $(".modal_task_action").hide();
        });
        // $(".edit_task_btn").on("click", function (e) {
        //     e.preventDefault();
        //     $("#modal_task_action").css('display','block');
        //     $("#modal_task_action").css({ top: '0%' });
        // });

//get anchor id => delete_action_{1} and concatenate it to create modal id
        $(".edit_task_btn").on("click", function (e) {
            var task_id = $('#task_id').val();
            console.log("task id:"+task_id);

            //perform ajax call to get selected user data for modal dialog to be updated
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-XSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            //var formdata = new FormData($("#edit_task_form")[0]);
            //console.log("formdata");
            //console.log(formdata);

            $.ajax({
                url: '{{ url('/get-task-by-id-ajax') }}',
                type: 'get',
                data:'task_id='+task_id+'&method=edit_task',
                processData: false,
                contentType: false,
                success: function (response) {
                    // console.log('full resp:');
                    // console.log(response);

                    //set values to edit tutor dialog fields
                    $("#subject").val(response[0]['subject']);
                    $("#description").val(response[0]['description']);
                    $("#status").val(response[0]['status']);
                    $("#priority").val(response[0]['priority']);
                    $("#task_assigned_to").val(response[0]['assigned_to']);
                    $("#status").val(response[0]['status']);
                    $("#start_date").val(response[0]['start_date']);
                    $("#end_date").val(response[0]['estimated_completion_date']);
                },
                error: function (data) {
                    console.log(data);
                    console.log('scroll error'+error_scroll);
                    $('#'+error_scroll).focus();
                }
            });

            //process tutor request
            $("#modal_task_action").css('display','block');
            $("#modal_task_action").css({ top: '0%' });
        });


        //update task
        $("#confirmed_task").click(function (e) {
            var error_scroll = '';
            if ($('#subject').val().length <= 0) {
                $('#subject_errors').text('Please provide task subject');
                return false;
            } else {
                $('#subject_errors').text('');
            }
            if ($('#task_assigned_to').val() == 'none') {
                $('#task_assigned_to_errors').text('Please select a user for this task');
                return false;
            } else {
                $('#task_assigned_to_errors').text('');
            }

            if ($('#start_date').val().length <= 0) {
                $('#start_date_errors').text('Please provide task start date');
                return false;
            } else {
                $('#start_date_errors').text('');
            }
            if ($('#end_date').val().length <= 0) {
                $('#end_date_errors').text('Please provide task end date');
                return false;
            } else {
                $('#end_date_errors').text('');
            }

            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-XSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var formdata = new FormData($("#edit_task_form")[0]);
            console.log("formdata");
            console.log(formdata);

            $.ajax({
                url: '{{ url('/task-management/conversation/').'/'.$task->id }}',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (response) {
                    $('#success-alert').html('<h3>Task Created Successfully</h3>');
                    $("#confirmed_task").attr('disabled',true);
                    $('#success-alert').focus();
                    $("#success-alert").fadeTo(2000, 500).slideUp(500, function () {
                        $("#success-alert").css("height", "0px");
                        $("#success-alert").css("display", "block");
                        var page = '<?php echo url("/")?>'+'/task-management/conversation/<?php echo $task->id;?>';
                        window.location.href = page // Go
                    });
                },
                error: function (data) {
                    console.log(data);
                    console.log('scroll error'+error_scroll);
                    $('#'+error_scroll).focus();
                }
            });
        });

    })();
</script>
@endsection