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
                <div>
                    <div class="col-6">
                        <h3 class="">Add New Reason of Contact </h3>
                        <hr/>
                    </div>

                    @if(session()->has('message'))
                        <div class="alert alert-success">
                            {{ session()->get('message') }}
                        </div>
                    @endif
                    <div class="app_notifications label label-success" id="success-alert">
                        <h3>Contact Reason is created!</h3>
                    </div>
                </div>


                <form id="create-contact-reason-form" class="card" name="create-contact-reason-form" action="{{ url('/create-users') }}" method="POST">
                    {{ csrf_field() }}
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12 no-padding">
                                    <div class="col-md-12 no-padding">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <input id="reason" type="text"
                                                       class="form-control lb-lg" placeholder="Reason of Contact"
                                                       name="reason" value="" required="" >
                                                <small class="text-danger error_msg" id="reason_errors"></small>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <select class="form-control lb-lg"  id="priority" name="priority" >
                                                    <option value="low">Low</option>
                                                    <option value="medium">Medium</option>
                                                    <option value="high">High</option>
                                                    <option value="urgent">Urgent</option>
                                                    <option value="emergency">Emergency</option>
                                                    <option value="critical">Critical</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <select class="form-control lb-lg"  id="assigned_staff" name="assigned_staff" >
                                                    <option value="3">Tutor</option>
                                                    <option value="4">Admin Support</option>
                                                </select>
                                                <small class="text-danger error_msg" id="scode_errors"></small>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <button type="submit" id="create_contact_reason" name="create_contact_reason" class="btn btn-primary">
                                                    CREATE
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </form>

                <form id="edit_course_form" action="{{url('/help-centre/contact-reasons/')}}" method="POST">
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
                                <th class="description_col" scope="col">Reason of Contact</th>
                                <th class="name_col" scope="col">Priority</th>
                                <th class="name_col" scope="col">Contact To</th>
                                <th class="actions_col" scope="col">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $count = 1;
                            if(count($contact_reasons) >= 1){
                            ?>
                            @foreach($contact_reasons as $reason)
                                <tr class="record_row record_{{ $reason->id }}">
                                    <td class="checkbox_container checkbox_col">
                                        <input class="task_checkbox checkbox" id="{{ $reason->id }}" value="{{ $reason->id }}" name="delete_checkbox" type="checkbox"/>
                                        <span class="checkmark"></span>
                                    </td>
                                    <td>{{ $reason->reason }}</td>
                                    <td>{{ $reason->priority }}</td>
                                    <td>{{ $reason->assigned_staff }}</td>
                                    <td><a href="{{url('/help-centre/contact-reasons').'/'.$reason->id}}" class="btn tiny btn-outline-secondary" title="Remove"><i class="fa fa-trash-alt"></i> Remove</a></td>
                                </tr>
                                <?php $count++;?>
                            @endforeach
                            <?php
                            }else{
                                echo '<tr><td colspan="7"> No Record Found </td></tr>';
                            }
                            ?>
                            </tbody>
                        </table>

                    </div>
                </form>

            </div>
        </div>
    </div>
    <script>
        (function () {
            //courses and tutors counter i
            window.course_count=0;
            setTimeout(function() {
                $('.alert-success').fadeOut('slow');
            }, 3000); // <-- time in milliseconds

            $(document).mouseup(function (e) {
                var course_input = $(this).attr("id");
                var container = $("#"+course_input);
                console.log('target:' + e.target.name);
                // // if the target of the click isn't the container nor a descendant of the container
                if (!container.is(e.target) && container.has(e.target).length === 0) {
                    $('#'+course_input+'_found').removeClass('maximized');
                    $('#'+course_input+'_found').addClass('minimized');
                } else {
                    console.log('maxing');
                    $('#'+course_input+'_found').addClass('maximized');
                }

                //for tutors search items holder
                var container = $("#current_course_tutor");
                console.log('target:' + e.target.name);
                // // if the target of the click isn't the container nor a descendant of the container
                if (!container.is(e.target) && container.has(e.target).length === 0) {
                    $('#tutors_found').removeClass('maximized');
                    $('#tutors_found').addClass('minimized');
                } else {
                    $('#tutors_found').addClass('maximized');
                }

                var container = $("#secondary_course_tutor");
                console.log('target:' + e.target.name);
                // // if the target of the click isn't the container nor a descendant of the container
                if (!container.is(e.target) && container.has(e.target).length === 0) {
                    $('#secondary_tutors_found').removeClass('maximized');
                    $('#secondary_tutors_found').addClass('minimized');
                } else {
                    $('#secondary_tutors_found').addClass('maximized');
                }
            });

            $("#add_course_btn").on("click", function (e) {
                e.preventDefault();
                $(".modal_tutor_action").show();
                $("#course_search").focus();
            });

            $("#close_dialog").on("click", function (e) {
                e.preventDefault();
                $(".modal_tutor_action").hide();
            });
            $("#cancel_choose_course").on("click", function (e) {
                $(".modal_tutor_action").hide();
            });

            //show hide notes for sen student
            $("#sen").change(function() {
                if(this.checked) {
                    $('#sen_notes').show();
                }else{
                    $('#sen_notes').hide();
                }
            });
            //add additional course row
            course_counter = 3;
            $("#add_course_row").click(function (e) {
                course_counter = course_counter+1;
                $('.additional_courses_rows .form-group:last').append('<div class="form-group"><input class="form-control lb-lg course_finder" placeholder="" id="course_'+course_counter+'" name="course_'+course_counter+'"/><div id="course_'+course_counter+'_found" class="user_course_search minimized"></div></div>');
            });
        })();

        //search on input - parent_name
        $(document).on('input','.course_finder', function (e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var current_course = $(this).val();
            var course_input_id = $(this).attr("id");
            var search_items_holder_class = $(this).next().attr("class").split(' ')[0];
            console.log("info:"+search_items_holder_class);
            if (current_course !== '') {
                $.ajax({
                    url: '{{ url("/get-courses-ajax") }}',
                    type: 'get',
                    data: 'course=' + current_course,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        if (response !== 'NULL') {
                            console.log('Not empty courses');
                            $('#'+course_input_id+'_found').show();
                            var courses = response;
                            var data_holder = '';
                            courses.forEach(function(course){
                                data_holder += '<a href="#!" onclick="( $(\'#'+course_input_id+'\').val( $(this).html() ) );$(this).parent().hide();">'+course["name"]+'</a>';
                            });
                            //fill in the search results
                            //current_course_found
                            //console.log( 'final id:'+'#' + course_input_id+'_found' );
                            $('#'+course_input_id+'_found').html(data_holder);
                        } else {
                            $('#'+course_input_id+'_found').hide();
                            // console.log("NULL:" + response);
                        }
                    },
                    error: function (data) {
                        console.log('failure:');
                        console.log(data);
                    }
                });
            } else {
                $('#'+course_input_id+'_found').removeClass('maximized');
                $('#'+course_input_id+'_found').removeClass('minimized');
            }
        });

        $('.course_finder').on('input', function (e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var current_course = $(this).val();
            var course_input_id = $(this).attr("id");
            var search_items_holder_class = $(this).next().attr("class").split(' ')[0];
            console.log("info:"+search_items_holder_class);
            if (current_course !== '') {
                $.ajax({
                    url: '{{ url("/get-courses-ajax") }}',
                    type: 'get',
                    data: 'course=' + current_course,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        if (response !== 'NULL') {
                            console.log('Not empty courses');
                            $('#'+course_input_id+'_found').show();
                            var courses = response;
                            var data_holder = '';
                            courses.forEach(function(course){
                                data_holder += '<a href="#!" onclick="( $(\'#'+course_input_id+'\').val( $(this).html() ) );$(this).parent().hide();">'+course["name"]+'</a>';
                            });
                            //fill in the search results
                            console.log( 'final id:'+'#' + course_input_id+'_found' );
                            $('#'+course_input_id+'_found').html(data_holder);
                        } else {
                            $('#'+course_input_id+'_found').hide();
                            console.log("NULL:" + response);
                        }
                    },
                    error: function (data) {
                        console.log('failure:');
                        console.log(data);
                    }
                });
            } else {
                $('#'+course_input_id+'_found').removeClass('maximized');
                $('#'+course_input_id+'_found').removeClass('minimized');
            }
        });

        $('#all_courses').on('input', function (e) {
            $('#all_courses :selected').each(function(i, selected){
                $('#course_search').val($(this).text());
            });
        });

        $('#all_tutors').on('input', function (e) {
            $('#all_tutors :selected').each(function(i, selected){
                $('#tutor_search').val($(this).text());
            });
        });

        $('#reset_courses').on('click', function (e) {
            e.preventDefault();
            course_count = 0;
            //remove selected courses
            $('#chosen_courses').html('');
            //remove selected course ids from hidden input
            $('#added_courses_ids').val('');
        });

        $('#course_search').on('click', function (e) {
            var chosen_one = $('#confirm_choose_course').val();
            if(chosen_one === ''){
                console.log();
                $('#course_search_errors').text('Please select a course');
                return false;
            }
        });

        //add course to selected
        $('#confirm_choose_course').on('click', function (e) {
            e.preventDefault();
            console.log();
            var selected_course = '';
            var selected_tutor = '';
            $('#all_courses option:selected').each(function(i, item){
                selected_course += $('#added_courses_ids').val()+$(this).val()+',';
            });

            if(selected_course == ''){
                console.log();
                $('#all_courses_errors').text('Please select a course first');
                return false;
            }

            $('#all_tutors option:selected').each(function(i, item){
                selected_tutor += $('#added_courses_ids').val()+$(this).val()+',';
            });

            if(selected_tutor == ''){
                console.log();
                $('#all_tutors_errors').text('Please select a tutor');
                return false;
            }

            //add selected course to chosen course ids input
            $('#added_courses_ids').val($('#added_courses_ids').val()+selected_course);
            var text_for_chosen_courses = $('#chosen_courses').html();

            //add 1 to count
            course_count++;

            $('#all_courses option:selected').each(function(i, item){
                text_for_chosen_courses += '<h3 class="chosen_course"><span class="numeric">'+course_count+'.</span> <span class="chosen_course_title">'+$(this).text()+'</span> <i class="fas fa-random"></i> ';
                text_for_chosen_courses += '<input type="hidden" id="course_'+course_count+'" name="course_'+course_count+'" value="'+$(this).val()+'"/>';
            });
            $('#all_tutors option:selected').each(function(i, item){
                text_for_chosen_courses += '<input type="hidden" id="tutor_'+course_count+'" name="tutor_'+course_count+'" value="'+$(this).val()+'"/>';
                text_for_chosen_courses += '<span class="chosen_course_tutor">'+$(this).text()+'</span></h3>';
            });

            //add course and tutor to the frontend
            $('#chosen_courses').html(text_for_chosen_courses);
            //remove options from select
            $('#all_courses option:selected').each(function(i, item){
                $(this).remove();
            });

            //empty the search boxes
            $("#course_search").val('');
            $("#tutor_search").val('');
            //hide the dialog now dont allow multiple button clicks
            $(".modal_tutor_action").hide();
        });

        //add student form submission code
        $("#create_contact_reason").click(function (e) {
            var error_scroll = '';
            //min length
            if ($('#reason').val().length <= 2) {
                $('#reason_errors').text('This field is required');
                error_scroll = 'reason';
                $('html, body').animate({
                    scrollTop: ($('#reason').offset().top - 166)
                },500);
                $('#reason').focus();
                return false;
            } else {
                $('#reason_errors').text('');
            }

            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-XSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var formdata = new FormData($("#create-contact-reason-form")[0]);
            console.log("formdata");
            console.log(formdata);

            $.ajax({
                url: '{{ url('/help-centre/contact-reasons') }}',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (response) {
                    var number_value = $('#student_number').val();
                    $('#create-contact-reason-form')[0].reset();
                    $('#success-alert').focus();
                    $("#success-alert").fadeTo(2000, 500).slideUp(500, function () {
                        $("#success-alert").slideUp();
                    });
                },
                error: function (data) {
                    console.log(data);
                    console.log('scroll error'+error_scroll);
                    $('#'+error_scroll).focus();
                }
            });
        });
    </script>
@endsection


