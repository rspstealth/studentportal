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
                        <h3 class="">Create User  <a href="admin_bulk_register.php" class="btn btn-outline-secondary float-right">BULK ENROLMENT</a></h3>
                        <hr/>
                    </div>

                    @if(session()->has('message'))
                        <div class="alert alert-success">
                            {{ session()->get('message') }}
                        </div>
                    @endif
                    <div class="app_notifications label label-success" id="success-alert">
                        <h3>User is created!</h3>
                    </div>
                </div>


                <form id="create-user-form" name="create-user-form" action="{{ url('/create-users') }}" method="POST">

                    {{ csrf_field() }}
                    <div class="row justify-content-center form_inside">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12 no-padding">
                                    <div class="col-md-12 no-padding">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                Select Number
                                                <select class="form-control lb-lg"  id="scode" name="scode" >
                                                        <option value="GR">GR</option>
                                                        <option value="CO">CO</option>
                                                        <option value="CH">CH</option>
                                                        <option value="BU">BU</option>
                                                        <option value="DL">DL</option>
                                                        <option value="EDU">EDU</option>
                                                </select>
                                                <small class="text-danger error_msg" id="scode_errors"></small>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                &nbsp;
                                                <input placeholder="" id="student_number" type="text"
                                                       class="form-control lb-lg"
                                                       name="student_number" value="{{ $last_student_id+1}}" required="" >
                                                <small class="text-danger error_msg" id="student_number_errors"></small>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 no-padding">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            First Name
                                            <input class="form-control lb-lg" placeholder="" id="first_name" name="first_name"/>
                                            <small class="text-danger error_msg" id="first_name_errors"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            Last Name
                                            <input class="form-control lb-lg" placeholder="" id="last_name" name="last_name"/>
                                            <small class="text-danger error_msg" id="last_name_errors"></small>
                                        </div>
                                    </div>

                            </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 no-padding">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            Phone Number
                                            <input class="form-control lb-lg" placeholder="" id="phone_number" name="phone_number"/>
                                            <small class="text-danger error_msg" id="phone_number_errors"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            Mobile Number
                                            <input class="form-control lb-lg" placeholder="" id="mobile_number" name="mobile_number"/>
                                            <small class="text-danger error_msg" id="mobile_number_errors"></small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row col-md-12 no-padding" style="width: 103.7%;">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        Email Address
                                        <input required="" class="form-control lb-lg" placeholder="name@company.com" id="email" name="email"/>
                                        <small class="text-danger error_msg" id="email_errors"></small>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <link media="all" type="text/css" rel="stylesheet" href="{{ url("/") }}/css/datepicker/css/datepicker.css">
                                    <script src="{{ url("/") }}/css/datepicker/js/bootstrap-datepicker.js">
                                    </script>
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
                                        Join Date
                                        <div class="input-group input-append date" id="datePicker">
                                            <input required="" value="" placeholder="dd/mm/year" type="text"  class="margin-top-none datepicker form-control lb-lg" id="join_date" name="join_date">
                                            <span class="input-group-addon add-on"><i class="far fa-calendar-alt datepicker_icon"></i></span>
                                            <small class="text-danger" id="join_date_errors"></small>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        Address
                                        <textarea style="height:36px;" class="form-control lb-lg" placeholder="" id="address" name="address"></textarea>
                                        <small class="text-danger error_msg" id="address_errors"></small>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    Choose Student Courses
                                    <div id="student_courses" class="col-md-12">
                                        <div id="chosen_courses">
                                        </div>

                                        <a id="add_course_btn" href="#" class="btn btn-outline-secondary" title="Add Course"><i class="fas fa-plus"></i> Add Course</a>
                                        <a id="reset_courses" style="margin-right: 10px;" href="#" class="btn btn-outline-secondary float-right" title="Reset Course(s) Selection"><i class="fas fa-redo"></i> Reset Selection</a>
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-12">
                                    <br>
                                    Considerations
                                    <hr/>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="fast_track" class="form_label lb-lg"><input type="checkbox" class="" id="fast_track" name="fast_track"/>
                                            Fast Track</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="discounted" class="form_label lb-lg"><input type="checkbox" class="" id="discounted" name="discounted"/>
                                                Discounted Student</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="sen" class="form_label lb-lg"><input type="checkbox" class="" id="sen" name="sen"/>
                                            SEN</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <textarea placeholder="Special Note for student" style="display:none" name="sen_notes" id="sen_notes" cols="50" rows="6"></textarea>
                                        </div>

                                    </div>

                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <br>
                                    <br>
                                    Payment Method
                                    <hr/>
                                    <div class="col-md-3"><label><input type="radio" name="payment" value="na" checked=""> Not Applicable</label></div><!-- col -->
                                    <div class="col-md-3"><label><input type="radio" name="payment" value="f"> Paid in Full</label></div><!-- col -->
                                    <div class="col-md-3"><label><input type="radio" name="payment" value="i"> Instalment Plan</label>

                                </div>
                                <br><br>
                                </div><!-- col -->
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <hr/>
                                    <br>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <button type="submit" id="create_users" name="create_users" class="btn btn-primary">
                                        CREATE
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>

                {{--tutor modal--}}
                <div id="modal_tutor_action" class="modal modal_tutor_action" tabindex="-1" role="dialog">
                    <div style="top:15%;" class="tutor-modal-dialog modal_tutor_dialog" role="document">
                        <div class="modal-content align-items-center" style="padding: 0 20px;">
                            <div class="modal-body">
                                <h3>Select Course & Tutor <a href="#" title="close dialog" id="close_dialog" style="float: right;margin: 0 10px;"><i class="fa fa-close"></i></a></h2>
                            </div>
                            <div class="modal-footer">
                                <form id="add_tutor_form" action="{{url('/create-users')}}" method="POST" >
                                    {{ csrf_field() }}
                                    <div class="col-md-12 no-padding">
                                        <div class="col-md-12 no-padding">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    Search Course
                                                    <input type="text" id="course_search" name="course_search" class="form-control lb-lg"/>
                                                    <small class="text-danger" id="course_search_errors"></small>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    Search Tutor
                                                    <input type="text" id="tutor_search" name="tutor_search" class="form-control lb-lg"/>
                                                    <small class="text-danger" id="tutor_search_errors"></small>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12 no-padding">
                                            <div class="col-md-6">
                                                <select id="all_courses" name="all_courses" size="<?php echo count($courses)?>" style="height: 150px;" class="form-control" >
                                                    <?php
                                                    foreach($courses as $course){
                                                        echo '<option value="'.$course->id.'">'.$course->name.'</option>';
                                                    }
                                                    ?>
                                                </select>
                                                <small class="text-danger" id="all_courses_errors"></small>
                                            </div>
                                            <div class="col-md-6">
                                                <select id="all_tutors" name="all_tutors" size="<?php echo count($tutors)?>" style="min-height: 150px;" class="form-control" >
                                                    <?php
                                                    foreach($tutors as $tutor){
                                                        echo '<option value="'.$tutor->id.'">'.$tutor->first_name.' '.$tutor->last_name.'</option>';
                                                    }
                                                    ?>
                                                </select>
                                                <small class="text-danger" id="all_tutors_errors"></small>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 text-center">
                                        <br>
                                        <br>
                                        <input type="hidden" id="added_courses_ids" name="added_courses_ids" value="" />
                                        <input class="btn btn-primary" type="submit" id="confirm_choose_course" name="confirm_choose_course" value="Select Course" />
                                        <button type="button" id="cancel_choose_course" class="btn btn-outline-secondary ">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


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

        //find searched courses
        $('#course_search').on('input', function (e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var searched_course = $('#course_search').val();
            var added_courses_ids = $('#added_courses_ids').val();
                $.ajax({
                    url: '{{ url("/get-courses-where-not-in-ajax") }}',
                    type: 'get',
                    data: 'course=' + searched_course+'&added_courses_ids='+added_courses_ids,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        //console.log('response:'+response);

                        if (response !== 'NULL') {
                            var courses = response;
                            var data_holder = '';
                            $('#all_courses').html('');
                            courses.forEach(function(course){
                                $("#all_courses").html( $("#all_courses").html() + '<option value="'+course['id']+'">'+course['name']+'</option>');
                            });
                        }
                    },
                    error: function (data) {
                        console.log('failure:');
                        console.log(data);
                    }
                });
        });

        //find searched tutors
        $('#tutor_search').on('input', function (e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var searched_tutor = $('#tutor_search').val();
            $.ajax({
                url: '{{ url("/get-tutors-ajax") }}',
                type: 'get',
                data: 'tutor=' + searched_tutor,
                processData: false,
                contentType: false,
                success: function (response) {
                    console.log('response:'+response);
                    if (response !== 'NULL') {
                        var tutors = response;
                        var data_holder = '';
                        $('#all_tutors').html('');
                        tutors.forEach(function(tutor){
                            //console.log('$(this).val()'+tutor['id']);
                            $("#all_tutors").html( $("#all_tutors").html() + '<option value="'+tutor['id']+'">'+tutor['first_name']+' '+tutor['last_name']+'</option>');
                        });
                    }
                },
                error: function (data) {
                    console.log('failure:');
                    console.log(data);
                }
            });
        });

        //add student form submission code
        $("#create_users").click(function (e) {
            var error_scroll = '';
            //min length
            if ($('#student_number').val().length <= 0) {
                $('#student_number_errors').text('Please provide student number');
                error_scroll = 'student_number';
                $('html, body').animate({
                    scrollTop: ($('#student_number').offset().top - 166)
                },500);
                $('#student_number').focus();
                return false;
            } else {
                $('#student_number_errors').text('');
            }

            //min length
            if ($('#first_name').val().length <= 2) {
                $('#first_name_errors').text('First name must be provided');
                error_scroll = 'first_name';
                $('html, body').animate({
                    scrollTop: ($('#first_name').offset().top - 166)
                },500);
                $('#first_name').focus();
                return false;
            } else {
                $('#first_name_errors').text('');
            }

            if ($('#last_name').val().length <= 2) {
                $('#last_name_errors').text('Last name must be provided');
                error_scroll = 'last_name';
                $('html, body').animate({
                    scrollTop: ($('#last_name').offset().top - 166)
                },500);
                $('#last_name').focus();
                return false;
            } else {
                $('#last_name_errors').text('');
            }

            if ($('#email').val().length <= 2) {
                $('#email_errors').text('Email must be provided');
                error_scroll = 'email';
                $('html, body').animate({
                    scrollTop: ($('#email').offset().top - 166)
                },500);
                $('#email').focus();
                return false;
            } else {
                $('#email_errors').text('');
            }

            if ($('#phone_number').val().length <= 0) {
                $('#phone_number_errors').text('Phone number must be provided');
                error_scroll = 'phone_number';
                $('html, body').animate({
                    scrollTop: ($('#phone_number').offset().top - 166)
                },500);
                $('#phone_number').focus();
                return false;
            } else {
                $('#phone_number_errors').text('');
            }

            if ($('#mobile_number').val().length <= 0) {
                $('#mobile_number_errors').text('Mobile number must be provided');
                error_scroll = 'mobile_number';
                $('html, body').animate({
                    scrollTop: ($('#mobile_number').offset().top - 166)
                },500);
                $('#mobile_number').focus();
                return false;
            } else {
                $('#mobile_number_errors').text('');
            }

            //min length
            if ($('#join_date').val().length <= 0) {
                $('#join_date_errors').text('Please choose a date');
                error_scroll = 'join_date';
                $('html, body').animate({
                    scrollTop: ($('#join_date').offset().top - 166)
                },500);
                $('#join_date').focus();
                return false;
            } else {
                $('#join_date_errors').text('');
            }

            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-XSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var formdata = new FormData($("#create-user-form")[0]);
            console.log("formdata");
            console.log(formdata);

            $.ajax({
                url: '{{ url('/create-users') }}',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (response) {
                    //clear all fields
                    var number_value = $('#student_number').val();
                    //console.log('Old Number:'+number_value);
                    $('#create-user-form')[0].reset();
                    //remove selected courses
                    $('#chosen_courses').html('');
                    //remove selected course ids from hidden input
                    $('#added_courses_ids').val('');
                    $('#student_number').val(+number_value + 1);
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


