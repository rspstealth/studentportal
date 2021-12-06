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

                        <h3 class="">Automatic Emails @can('create-resources',\Illuminate\Support\Facades\Auth::user())<a style="float:right;" href="#" id="new_task_btn" title="Add New Email Template" class="btn btn-primary "><i class="far fa-envelope"></i> New Email Template</a>@endcan</h3>
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
                            <h3>Template Updated Successfully</h3>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div id="filters_action">
                            <form class="row" id="resources_filters_action_form" style="height:76px;margin: 0;" action="{{url('communication/automatic-emails/list')}}/{{$page_var}}" method="GET">
                                {{ csrf_field() }}
                                <div class="col-md-4">
                                    Filter by Status
                                    <select id="template_status_filter" name="template_status_filter" class="form-control">
                                        <option <?php if(Request::input('template_status_filter') === 'all'){ echo "selected=''";}?> value="all">All</option>
                                        <option <?php if(Request::input('template_status_filter') === 'active'){ echo "selected=''";}?> value="active">Active</option>
                                        <option <?php if(Request::input('template_status_filter') === 'inactive'){ echo "selected=''";}?> value="inactive">Inactive</option>
                                    </select>
                                </div>
                            </form>
                        </div>
                    </div>


                    <form id="edit_course_form" action="{{url('communication/automatic-emails/')}}/{{$page_var}}" method="POST">
                        {{ csrf_field() }}
                            <div class="col-md-12">
                                <div id="actions_bar">
                                    <div id="actions_bar_left">
                                        {{--<a class="nav-link action_buttons" href="{{url('/students')}}/11/edit" title="Edit Student"><i class="far fa-edit"></i></a>--}}
                                        @can('delete-resources',\Illuminate\Support\Facades\Auth::user())
                                        <a class="btn btn-outline-secondary tiny-action-btn" href="#" id="multiple_delete_select" title="Delete Selected Resources"><i class="far fa-trash-alt"></i> Delete Selected</a>
                                        @endcan
                                        <span class="selected_label">0 Selected</span>
                                    </div>
                                </div>

                                <table class="table resources_table">
                                    <?php
                                    $count = 1;
                                    if(count($automatic_emails) >= 1){
                                    ?>
                                    <thead>
                                    <tr>
                                        <th scope="col" class="checkbox_col checkbox_container_th">
                                            <input class="selector_checkbox checkbox" title="Select / Deselect All Records" type="checkbox" id="select_all_records" name="select_all_records"/>
                                            <span class="checkmark"></span>
                                        </th>
                                        <th class="template_title_col" scope="col">Label</th>
                                        <th class="roll_no_col" scope="col">Is Active</th>
                                        <th class="subject_col" scope="col">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($automatic_emails as $automatic_email)
                                        <tr class="record_row record_{{ $automatic_email->id }}">
                                            <td class="checkbox_container checkbox_col">
                                                <input class="task_checkbox checkbox" id="{{ $automatic_email->id }}" value="{{ $automatic_email->id }}" name="delete_checkbox" type="checkbox"/>
                                                <span class="checkmark"></span>
                                            </td>
                                            <td>{{ $automatic_email->title  }}</td>
                                            <td>{{ ($automatic_email->is_active ? 'Active' : 'Inactive')  }}</td>
                                            <td><a id="edit_action_{{ $automatic_email->id }}" class="action_buttons edit_action btn-outline-secondary tiny-action-btn" href="#" title="Edit"><i class="fas fa-edit"></i> Edit Template</a></td>
                                        </tr>
                                        <?php $count++;?>
                                    @endforeach
                                    <?php
                                    }else{
                                        echo '<tr><td colspan="7"> No Template Found </td></tr>';
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
                                    <a class="action_buttons" href="{{url('communication/automatic-emails/list/')}}/{{$page_var-1}}?_token={{ csrf_token() }}&template_status_filter={{((Request::query('template_status_filter')) ? Request::query('template_status_filter') : "" )}}" title="Previous"><i class="fas fa-chevron-left"> </i> Previous</a>
                                    <?php
                                    }
                                    ?>
                                    <?php
                                    //eg: total 5 > current 5
                                    if($page_var  < $totalPages){
                                    ?>
                                    <a class="action_buttons" href="{{url('communication/automatic-emails/list/')}}/{{$page_var+1}}?_token={{ csrf_token() }}&template_status_filter={{((Request::query('template_status_filter')) ? Request::query('template_status_filter') : "" )}}" title="Next">Next <i class="fas fa-chevron-right"></i></a>
                                    <?php
                                    }
                                    }
                                    ?>
                                </div>
                            </div>
                    </form>


                    <div id="modal_delete_action" class="modal modal_delete_action" tabindex="-1" role="dialog">
                        <div class="delete-modal-dialog modal_delete_dialog" role="document">
                            <div class="modal-content align-items-center">
                                <div class="modal-body">
                                    <h3>Confirm Delete Template(s)? <a href="#" title="close dialog" id="close_delete_dialog" style="float: right;margin: 0 10px;"><i class="fa fa-close"></i></a></h3>
                                    <p>This action cannot be undone.</p>
                                </div>
                                <div class="modal-footer">
                                    <form id="del_selected_form" action="{{url('communication/automatic-emails/list')}}/{{$page_var}}" method="POST">
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

                    {{--new template modal--}}
                    <div id="modal_task_action" class="modal modal_task_action" tabindex="-1" role="dialog">
                        <div class="task-modal-dialog modal_task_dialog" style="    width: 50%;    left: 25%;    margin-top: 2% !important;" role="document">
                            <div class="modal-content align-items-center" style="padding: 0 20px;">
                                <div class="modal-body">
                                    <h3>New Email Template <a href="#" title="close dialog" id="close_dialog" style="float: right;margin: 0 10px;"><i class="fa fa-close"></i></a></h3>
                                </div>
                                <div class="modal-footer">
                                    <form id="add_template_form" action="{{url('communication/automatic-emails/list/')}}/{{$page_var}}" method="POST">
                                        {{ csrf_field() }}
                                        <div class="col-md-12 no-padding">
                                            <div class="col-md-12 no-padding">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        Template Title <i class="fas fa-asterisk"></i>
                                                        <input type="text" id="title" name="title" class="form-control lb-lg"/>
                                                        <small class="text-danger" id="title_errors"></small>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        Subject <i class="fas fa-asterisk"></i>
                                                        <input type="text" id="subject" name="subject" class="form-control lb-lg"/>
                                                        <small class="text-danger error_msg" id="subject_errors"></small>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        Email Body <i class="fas fa-asterisk"></i>
                                                        <textarea id="description" name="description" class="form-control lb-lg" cols="1" rows="12"></textarea>
                                                        <small class="text-danger error_msg" id="description_errors"></small>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        Active? <i class="fas fa-asterisk"></i>
                                                        <hr style="    margin: 5px 0;"/>
                                                        <label><input checked="" type="radio" name="is_active" value="1"/> Active</label>
                                                        <label>&nbsp;&nbsp;<input type="radio" name="is_active" value="0"/> Inactive</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <input type="hidden" id="total" name="total" value="{{$total}}" />
                                        <input type="hidden" id="totalPages" name="totalPages" value="{{$totalPages}}" />
                                        <input type="hidden" id="method" name="method" value="new_email_template" />
                                        <input type="hidden" id="page_var" name="page_var" value="{{$page_var}}" />
                                        <div class="col-md-12">
                                            <label>Shortcodes</label>
                                            <hr style="margin:0;padding:5px;"/>
                                            <h4 style="padding:5px 0;margin:0;">{first_name} {last_name} {email} {password} {recommendation_1} {recommendation_2} {recommendation_3}</h4>
                                            <hr/>
                                            <input class="btn btn-primary" type="submit" id="new_template_btn" name="new_template_btn" value="Add Email Template" />
                                            <button type="button" id="cancelled_new_resource_btn" class="btn btn-outline-secondary ">Cancel</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{--edit template modal--}}
                    <div id="modal_template_action" class="modal modal_template_action" tabindex="-1" role="dialog">
                        <div class="template-modal-dialog modal_template_dialog" style="    width: 70%;    left: 15%;    margin-top: 2% !important;" role="document">
                            <div class="modal-content align-items-center" style="padding: 0 20px;">
                                <div class="modal-body" style="padding: 0;">
                                    <h3>Edit Email Template <a href="#" title="close dialog" id="close_edit_dialog" style="float: right;margin: 0 10px;"><i class="fa fa-close"></i></a></h3>
                                </div>
                                <div class="modal-footer">
                                    <form id="edit_template_form" action="{{url('communication/automatic-emails/list/')}}/{{$page_var}}" method="POST">
                                        {{ csrf_field() }}
                                        <div class="col-md-12 no-padding">
                                            <div class="col-md-12 no-padding">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        Template Title <i class="fas fa-asterisk"></i>
                                                        <input type="text" id="edit_title" name="edit_title" class="form-control lb-lg"/>
                                                        <small class="text-danger" id="edit_title_errors"></small>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        Subject <i class="fas fa-asterisk"></i>
                                                        <input type="text" id="edit_subject" name="edit_subject" class="form-control lb-lg"/>
                                                        <small class="text-danger error_msg" id="edit_subject_errors"></small>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        Email Body <i class="fas fa-asterisk"></i>
                                                        <textarea id="edit_description" name="edit_description" class="form-control lb-lg" cols="1" rows="5"></textarea>
                                                        <small class="text-danger error_msg" id="edit_description_errors"></small>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        Active? <i class="fas fa-asterisk"></i>
                                                        <hr style="    margin: 5px 0;"/>
                                                        <label><input type="radio" id="active_state" name="edit_is_active" value="1"/> Active</label>
                                                        <label>&nbsp;&nbsp;<input type="radio" id="in_active_state" name="edit_is_active" value="0"/> Inactive</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <input type="hidden" id="method" name="method" value="edit_email_template" />
                                        <input type="hidden" id="total" name="total" value="{{$total}}" />
                                        <input type="hidden" id="edit_template_id" name="edit_template_id" value="" />
                                        <input type="hidden" id="totalPages" name="totalPages" value="{{$totalPages}}" />
                                        <input type="hidden" id="page_var" name="page_var" value="{{$page_var}}" />
                                        <div class="col-md-12">
                                            <label>Shortcodes</label>
                                            <hr style="margin:0;padding:5px;"/>
                                            <h4 style="padding:5px 0;margin:0;">{first_name} {last_name} {email} {password} {recommendation_1} {recommendation_2} {recommendation_3}</h4>
                                            <hr/>
                                            <input class="btn btn-primary" type="submit" id="edit_template_btn" name="edit_template_btn" value="Update Email Template" />
                                            <button type="button" id="cancelled_edit_resource_btn" class="btn btn-outline-secondary ">Cancel</button>
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
        $("#template_status_filter").on("change", function () {
            console.log("Changed....");
            this.form.submit();
        });



        $("#cancelled_new_resource_btn").on("click", function (e) {
            console.log("Cancelling course");
            $(".modal_task_action").hide();
        });

        $("#cancelled_edit_resource_btn").on("click", function (e) {
            console.log("Cancelling course");
            $(".modal_template_action").hide();
        });

        $("#close_dialog").on("click", function (e) {
            e.preventDefault();
            console.log("Cancelling course");
            $(".modal_task_action").hide();
        });

        $("#close_edit_dialog").on("click", function (e) {
            e.preventDefault();
            console.log("Cancelling template");
            $(".modal_template_action").hide();
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


        //edit template ajax func to get template date from db
        $(".edit_action").on("click", function (e) {
            console.log("Processing Del Request:"+this.id);
            var str = this.id;
            var id = str.split(/[\s_]+/);
            console.log("SPLITTED:" + id[2]);
            $("#edit_template_id").val(id[2]);

            //perform ajax call to get selected user data for modal dialog to be updated
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-XSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var formdata = new FormData($("#edit_template_form")[0]);
            console.log("formdata");
            console.log(formdata);

            $.ajax({
                url: '{{ url('/get-email-template-by-id-ajax') }}',
                type: 'get',
                data:'edit_template_id='+id[2]+'&method=edit_email_template',
                processData: false,
                contentType: false,
                success: function (response) {
                     console.log('response :');
                     console.log(response);
                    console.log('response title:');
                     console.log(response['title']);
                    //set values to edit tutor dialog fields
                    $("#edit_title").val(response['title']);
                    $("#edit_subject").val(response['subject']);
                    $("#edit_description").val(response['description']);
                    //$("#edit_is_active").val(response['is_active']);
                    if(response['is_active'] === 1){
                        console.log('RADIO 1 is '+ response['is_active']);
                        $("#active_state").attr('checked', 'checked');
                    }
                    if(response['is_active'] === 0){
                        console.log('RADIO 0 is '+ response['is_active']);
                        $("#in_active_state").attr('checked', 'checked');
                    }
                },
                error: function (data) {
                    console.log(data);
                    console.log('scroll error'+error_scroll);
                    $('#'+error_scroll).focus();
                }
            });
            $("#modal_template_action").css('display','block');
            $("#modal_template_action").css({ top: '0%' });
        });


        $("#edit_template_btn").click(function (e) {
            var error_scroll = '';
            //add rules
            //min length
            if ($('#edit_title').val().length <= 0) {
                $('#edit_title_errors').text('Please provide title');
                return false;
            } else {
                $('#edit_title_errors').text('');
            }

            if ($('#edit_subject').val().length <= 0) {
                $('#edit_subject_errors').text('Please provide subject');
                return false;
            } else {
                $('#edit_subject_errors').text('');
            }

            if ($('#edit_description').val().length <= 0) {
                $('#edit_description_errors').text('Please provide email body');
                return false;
            } else {
                $('#edit_description_errors').text('');
            }

            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-XSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var formdata = new FormData($("#edit_template_form")[0]);
            console.log("formdata");
            console.log(formdata);

            $.ajax({
                url: '{{ url('/communication/automatic-emails/list/').'/'.$page_var }}',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (response) {
                    $('#success-alert').html('<h3>Template Updated Successfully</h3>');
                    $("#edit_template_btn").attr('disabled',true);

                    $('#success-alert').focus();
                    $("#success-alert").fadeTo(2000, 500).slideUp(500, function () {
                        //$("#create_users").attr("disabled", true);
                        //$("#create-user-form").css("display", 'none');
                        $("#success-alert").css("height", "0px");
                        $("#success-alert").css("display", "block");
                        var page = '{{url("/")}}/communication/automatic-emails/list/{{$page_var}}';
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


        $(".selector_checkbox").on("click", function () {
            if($(".selector_checkbox").prop('checked') == true){
                $(".task_checkbox").prop('checked', true);
                $(".record_row").css('background', '#f5f5f5');
                $("#actions_bar_left").css('display', 'block');

                var $checkboxes = $('.task_checkbox');
                var countCheckedCheckboxes = $checkboxes.filter(':checked').length;
                $('.selected_label').text(countCheckedCheckboxes + ' Template(s) Selected');


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
                $('.selected_label').text(countCheckedCheckboxes + ' Template(s) Selected');


            }else{
                $(".task_checkbox").closest('.record_'+this.id).css('background', '#fff');
                if ($(".checkbox_container input:checkbox:checked").length < 1)
                {
                    // no one is checked
                    $("#actions_bar_left").css('display', 'none');
                }

                var $checkboxes = $('.task_checkbox');
                var countCheckedCheckboxes = $checkboxes.filter(':checked').length;
                $('.selected_label').text(countCheckedCheckboxes + ' Template(s) Selected');


            }
        });


        //add resource
        $("#new_template_btn").click(function (e) {
            var error_scroll = '';
            if ($('#title').val().length <= 0) {
                $('#title_errors').text('Please provide title to the template');
                return false;
            } else {
                $('#title_errors').text('');
            }


            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-XSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var formdata = new FormData($("#add_template_form")[0]);
            console.log("formdata");
            console.log(formdata);

            $.ajax({
                url: '{{ url('communication/automatic-emails/list/').'/'.$page_var }}',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (response) {
                    $('#success-alert').html('<h3>Template Created Successfully</h3>');
                    $("#new_template_btn").attr('disabled',true);
                    $('#success-alert').focus();
                    $("#success-alert").fadeTo(2000, 500).slideUp(500, function () {
                        $("#success-alert").css("height", "0px");
                        $("#success-alert").css("display", "block");
                        var page = '<?php echo url("/")?>'+'/communication/automatic-emails/list/<?php echo $page_var;?>';
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

        //check for unique email template title
        $('#title').on('input', function (e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var title = $('#title').val();

            $.ajax({
                url: '{{ url("/check-if-email-template-already-exists-ajax") }}',
                type: 'get',
                data: 'title=' + title,
                processData: false,
                contentType: false,
                success: function (response) {
                    console.log('response:'+response);
                    if (response === 'exists') {
                        $('#title_errors').html('Email template already exists, please use different title.')
                        return false;
                    }
                    if (response === 'unique') {
                        $('#title_errors').html('')
                        return false;
                    }
                },
                error: function (data) {
                    console.log('failure:');
                    console.log(data);
                }
            });
        });






    })();
</script>
@endsection