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
                    <div class="col-md-12">
                        <h3 class="">Help Centre @can('create-contact-reason',\Illuminate\Support\Facades\Auth::user())<a style="float:right;" href="{{url('/help-centre/contact-reasons')}}" id="new_contact_reason_btn" title="Create New Contact Reason" class="btn btn-primary "><i class="fas fa-plus"></i> New Contact Reason</a>@endcan</h3>
                        <hr style="margin: 0;margin-bottom: 10px;"/>
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
                        <div id="filters_action">
                            <form class="row" id="filters_action_form" style="height:56px; margin: 0;" action="{{url('/task-management/list')}}/{{$page_var}}" method="GET">
                                {{ csrf_field() }}
                                <div class="col-md-2">
                                    <h4 style="line-height: 25px;padding: 0;">Sort Filters</h4>
                                </div>
                                @can('staff-filter-tasks',\Illuminate\Support\Facades\Auth::user())
                                <div class="col-md-3">
                                    <select id="student_filter" name="student_filter" class="form-control">
                                        <option value="">Sort by student</option>
                                        <?php
                                        foreach($students as $student){
                                        ?>
                                        <option {{(Request::query('student_filter') == $student->user_id)? 'selected=""':''}} value="{{$student->user_id}}">{{$student->first_name}} {{$student->last_name}}</option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                @endcan

                                <div class="col-md-3">
                                    <select id="status_filter" name="status_filter" class="form-control">
                                        <option value="">Sort by status</option>
                                        <option {{(Request::query('status_filter') === 'open')? 'selected=""':''}} value="open">Open</option>
                                        <option {{(Request::query('status_filter') === 'closed')? 'selected=""':''}} value="closed">Closed</option>
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <select id="criteria_filter" name="criteria_filter" class="form-control">
                                        <option value="">Sort by criteria</option>
                                        <option {{(Request::query('criteria_filter') === 'completion_date')? 'selected=""':''}} value="completion_date">Completion Date</option>
                                        <option {{(Request::query('criteria_filter') === 'start_date')? 'selected=""':''}} value="start_date">Start Date</option>
                                        <option {{(Request::query('criteria_filter') === 'created_date')? 'selected=""':''}} value="created_date">Created Date</option>
                                    </select>
                                </div>
                            </form>
                        </div>
                    </div>


                    <form id="edit_course_form" action="{{url('/tasks-management/')}}/{{$page_var}}" method="POST">
                        {{ csrf_field() }}
                            <div class="col-md-12">
                                <div id="actions_bar">
                                    <div id="actions_bar_left">
                                        {{--<a class="nav-link action_buttons" href="{{url('/students')}}/11/edit" title="Edit Student"><i class="far fa-edit"></i></a>--}}
                                        <a class="btn btn-outline-secondary tiny-action-btn" href="#" id="multiple_resolve_select" title="Close Selected Tasks"><i class="fas fa-wrench"></i> Close Selected</a>
                                        @can('create-tasks',\Illuminate\Support\Facades\Auth::user())
                                        <a class="btn btn-outline-secondary tiny-action-btn" href="#" id="multiple_delete_select" title="Delete Selected Tasks"><i class="far fa-trash-alt"></i> Delete Selected</a>
                                        @endcan
                                        <span class="selected_label">0 Selected</span>
                                    </div>


                                </div>

                                <table class="table tasks_table">
                                    <thead>
                                    <tr>
                                        <th scope="col" class="checkbox_col checkbox_container_th">
                                            <input class="selector_checkbox checkbox" title="Select / Deselect All Records" type="checkbox" id="select_all_records" name="select_all_records"/>
                                            <span class="checkmark"></span>
                                        </th>
                                        <th class="name_col" scope="col">Subject</th>
                                        <th class="roll_no_col" scope="col">Status</th>
                                        <th class="name_col" scope="col">Created By</th>
                                        <th class="name_col" scope="col">Assigned To</th>
                                        <th class="name_col" scope="col">Created On</th>
                                        <th class="roll_no_col" scope="col">Priority</th>
                                        <th class="actions_col" scope="col">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $count = 1;
                                    if(count($tasks) >= 1){
                                    ?>
                                    @foreach($tasks as $task)
                                        <tr class="record_row record_{{ $task->id }}">
                                            <td class="checkbox_container checkbox_col">
                                                <input class="task_checkbox checkbox" id="{{ $task->id }}" value="{{ $task->id }}" name="delete_checkbox" type="checkbox"/>
                                                <span class="checkmark"></span>
                                            </td>
                                            <td>{{ $task->subject }}</td>
                                            <td>{{ $task->status }}</td>
                                            <?php
                                            $task_creator_name = \App\Http\Controllers\UserController::getUserName($task->created_by);
                                            $task_assigned_to = \App\Http\Controllers\UserController::getUserName($task->assigned_to);
                                            ?>
                                            <td>{{ $task_creator_name->first_name.' '.$task_creator_name->last_name }}</td>
                                            <td>{{ $task_assigned_to->first_name.' '.$task_assigned_to->last_name }}</td>
                                            <td>{{ date("d-m-Y", strtotime($task->created_at)) }}</td>
                                            <td>
                                                <?php
                                                if($task->priority === 'low'){
                                                    echo '<i style="color: cadetblue;" class="fas fa-level-down-alt"></i> Low';
                                                }elseif($task->priority === 'medium'){
                                                    echo '<i style="color:darkorange" class="fas fa-level-up-alt"></i> Medium';
                                                }if($task->priority === 'high'){
                                                    echo '<i style="color:orangered" class="fas fa-level-up-alt"></i> High';
                                                }
                                                ?>
                                                </td>
                                            <td><a href="{{url('/task-management/conversation/').'/'.$task->id}}" class="btn tiny btn-outline-secondary" title="View Conversation"><i class="far fa-comments"></i> Conversation</a></td>
                                        </tr>
                                        <?php $count++;?>
                                    @endforeach
                                    <?php
                                    }else{
                                        echo '<tr><td colspan="7"> No Ticket Found </td></tr>';
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
                                    <a class="action_buttons" href="{{url('/task-management/list/')}}/{{$page_var-1}}?_token={{ csrf_token() }}" title="Previous"><i class="fas fa-chevron-left"> </i> Previous</a>
                                    <?php
                                    }
                                    ?>
                                    <?php
                                    //eg: total 5 > current 5
                                    if($page_var  < $totalPages){
                                    ?>
                                    <a class="action_buttons" href="{{url('/task-management/list/')}}/{{$page_var+1}}?_token={{ csrf_token() }}" title="Next">Next <i class="fas fa-chevron-right"></i></a>
                                    <?php
                                    }
                                    }
                                    ?>
                                </div>
                            </div>
                    </form>

                    <div id="modal_resolve_action" class="modal modal_resolve_action" tabindex="-1" role="dialog">
                        <div class="resolve-modal-dialog modal_resolve_dialog" role="document">
                            <div class="modal-content align-items-center">
                                <div class="modal-body">
                                    <h3>Confirm resolve selected tasks? <a href="#" title="close dialog" id="close_resolve_dialog" style="float: right;margin: 0 10px;"><i class="fa fa-close"></i></a></h3>
                                    <p>This will set selected tasks status to closed.</p>
                                </div>
                                <div class="modal-footer">
                                    <form id="del_selected_form" action="{{url('/task-management/list')}}/{{$page_var}}" method="POST">
                                        {{ csrf_field() }}
                                        <input type="hidden" id="total" name="total" value="{{$total}}" />
                                        <input type="hidden" id="totalPages" name="totalPages" value="{{$totalPages}}" />
                                        <input type="hidden" id="page_var" name="page_var" value="{{$page_var}}" />
                                        <input type="hidden" id="method" name="method" value="resolve" />
                                        <input type="hidden" id="resolve_ids" name="resolve_ids" value="" />
                                        <input class="btn btn-primary" type="submit" id="confirmed_resolve" name="confirmed_resolve" value="resolve" />
                                        <button type="button" class="btn btn-outline-secondary" id="cancelled_resolve">Cancel</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    
                    <div id="modal_delete_action" class="modal modal_delete_action" tabindex="-1" role="dialog">
                        <div class="delete-modal-dialog modal_delete_dialog" role="document">
                            <div class="modal-content align-items-center">
                                <div class="modal-body">
                                    <h3>Confirm Delete Task? <a href="#" title="close dialog" id="close_delete_dialog" style="float: right;margin: 0 10px;"><i class="fa fa-close"></i></a></h3>
                                    <p>This action cannot be undone.</p>
                                </div>
                                <div class="modal-footer">
                                    <form id="del_selected_form" action="{{url('/task-management/list')}}/{{$page_var}}" method="POST">
                                        {{ method_field('delete') }}
                                        {{ csrf_field() }}
                                        <input type="hidden" id="total" name="total" value="{{$total}}" />
                                        <input type="hidden" id="totalPages" name="totalPages" value="{{$totalPages}}" />
                                        <input type="hidden" id="page_var" name="page_var" value="{{$page_var}}" />
                                        <input type="hidden" id="ids" name="ids" value="" />
                                        <input class="btn btn-primary" type="submit" id="confirmed_delete" name="confirmed_delete" value="Delete" />
                                        <button type="button" class="btn btn-outline-secondary" id="cancelled_delete">Cancel</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{--new task modal--}}
                    <div id="modal_task_action" class="modal modal_task_action" tabindex="-1" role="dialog">
                        <div class="task-modal-dialog modal_task_dialog" role="document">
                            <div class="modal-content align-items-center" style="padding: 0 20px;">
                                <div class="modal-body">
                                    <h3>Add task <a href="#" title="close dialog" id="close_dialog" style="float: right;margin: 0 10px;"><i class="fa fa-close"></i></a></h3>
                                </div>
                                <div class="modal-footer">
                                    <form id="add_task_form" action="{{url('/task-management/list/')}}/{{$page_var}}" method="POST">
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
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            Assign To
                                                            <select id="assigned_to" name="assigned_to"  class="form-control lb-lg">
                                                                <option value="none">No option selected</option>
                                                                <option value="" disabled><b>Tutors</b></option>
                                                                <?php
                                                                foreach($students as $student){
                                                                    echo '<option value="'.$student->user_id.'">'.$student->first_name.' '.$student->last_name.'</option>';
                                                                }
                                                                ?>
{{--                                                                <option value="" disabled>Admin Support</option>--}}
                                                                <?php
//                                                                foreach($admins as $admin){
//                                                                    echo '<option value="'.$admin->user_id.'">'.$admin->first_name.' '.$admin->last_name.'</option>';
//                                                                }
                                                                ?>
                                                            </select>
                                                            <small class="text-danger error_msg" id="assigned_to_errors"></small>
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

                                        <input type="hidden" id="total" name="total" value="{{$total}}" />
                                        <input type="hidden" id="totalPages" name="totalPages" value="{{$totalPages}}" />
                                        <input type="hidden" id="page_var" name="page_var" value="{{$page_var}}" />
                                        <input type="hidden" id="method" name="method" value="new_task" />
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
<script>
    (function(){
        setTimeout(function() {
            $('.alert-success').fadeOut('slow');
        }, 3000); // <-- time in milliseconds
        setTimeout(function() {
            $('.alert-danger').fadeOut('slow');
        }, 3000); // <-- time in milliseconds

        //filters
        $("#student_filter").on("change", function () {
            console.log("CHanged....");
            this.form.submit();
        });
        $("#status_filter").on("change", function () {
            console.log("CHanged....");
            this.form.submit();
        });
        $("#criteria_filter").on("change", function () {
            console.log("CHanged....");
            this.form.submit();
        });



        $("#cancelled_task").on("click", function (e) {
            console.log("Cancelling course");
            $(".modal_task_action").hide();
        });

        $("#close_dialog").on("click", function (e) {
            e.preventDefault();
            console.log("Cancelling course");
            $(".modal_task_action").hide();
        });

        $("#cancelled_resolve").on("click", function (e) {
            console.log("Cancelling resolve");
            $(".modal_resolve_action").hide();
        });

        $("#close_resolve_dialog").on("click", function (e) {
            e.preventDefault();
            console.log("Cancelling resolve");
            $(".modal_resolve_action").hide();
        });

        $("#cancelled_delete").on("click", function (e) {
            console.log("Cancelling delete");
            $(".modal_delete_action").hide();
        });

        $("#close_delete_dialog").on("click", function (e) {
            e.preventDefault();
            console.log("Cancelling delete");
            $(".modal_delete_action").hide();
        });

        //get anchor id => delete_action_{1} and concatenate it to create modal id
        $("#new_task_btn").on("click", function () {
                //process course request
                $("#modal_task_action").css('display','block');
                $("#modal_task_action").css({ top: '0%' });
        });

        $("#multiple_delete_select").on("click", function (e) {
            e.preventDefault();
            $("#modal_delete_action").css('display','block');
            $("#modal_delete_action").css({ top: '0%' });
            console.log("Processing Del Request:"+this.id);

            var allVals = [];

            $.each($("input[name='delete_checkbox']:checked"), function(){
                allVals.push($(this).val());
                //console.log($(this).val());
            });


            $("#ids").val(allVals);

        });

        $("#multiple_resolve_select").on("click", function (e) {
            e.preventDefault();
            $("#modal_resolve_action").css('display','block');
            $("#modal_resolve_action").css({ top: '0%' });
            console.log("Processing resolve Request:"+this.id);
            var allVals = [];
            $.each($("input[name='delete_checkbox']:checked"), function(){
                allVals.push($(this).val());
            });
            $("#resolve_ids").val(allVals);
        });

        $(".selector_checkbox").on("click", function () {
            if($(".selector_checkbox").prop('checked') == true){
                $(".task_checkbox").prop('checked', true);
                $(".record_row").css('background', '#f5f5f5');
                $("#actions_bar_left").css('display', 'block');

                var $checkboxes = $('.task_checkbox');
                var countCheckedCheckboxes = $checkboxes.filter(':checked').length;
                $('.selected_label').text(countCheckedCheckboxes + ' Task(s) Selected');


            }else{
                $(".task_checkbox").prop('checked', false);
                $(".record_row").css('background', '#fff');
                $("#actions_bar_left").css('display', 'none');

            }
        });

        // highlight selected row
        $(".task_checkbox").on("click", function () {
            console.log("clicked");
            console.log('"#'+this.id+'"');
            if($('#'+this.id).prop('checked') == true){
                $(".task_checkbox").closest('.record_'+this.id).css('background', '#f5f5f5');
                console.log("checking");
                $("#actions_bar_left").css('display', 'block');

                var $checkboxes = $('.task_checkbox');
                var countCheckedCheckboxes = $checkboxes.filter(':checked').length;
                $('.selected_label').text(countCheckedCheckboxes + ' Task(s) Selected');


            }else{
                $(".task_checkbox").closest('.record_'+this.id).css('background', '#fff');
                if ($(".checkbox_container input:checkbox:checked").length < 1)
                {
                    // no one is checked
                    $("#actions_bar_left").css('display', 'none');
                }

                var $checkboxes = $('.task_checkbox');
                var countCheckedCheckboxes = $checkboxes.filter(':checked').length;
                $('.selected_label').text(countCheckedCheckboxes + ' Task(s) Selected');


            }
        });


        //add feedback
        $("#confirmed_task").click(function (e) {
            var error_scroll = '';
            if ($('#subject').val().length <= 0) {
                $('#subject_errors').text('Please provide task subject');
                return false;
            } else {
                $('#subject_errors').text('');
            }
            if ($('#assigned_to').val() == 'none') {
                $('#assigned_to_errors').text('Please select a user for this task');
                return false;
            } else {
                $('#assigned_to_errors').text('');
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

            var formdata = new FormData($("#add_task_form")[0]);
            console.log("formdata");
            console.log(formdata);

            $.ajax({
                url: '{{ url('/task-management/list/').'/'.$page_var }}',
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
                        var page = '<?php echo url("/")?>'+'/task-management/list/<?php echo $page_var;?>';
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