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
                <div>
                    <div class="col-6">
                        <h2 class="">Create User  <a href="admin_bulk_register.php" class="btn btn-outline-secondary float-right">BULK ENROLMENT</a></h2>
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
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="scode" class="form_label lb-lg">Select Number </label>
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
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="scode" class="form_label lb-lg">&nbsp;</label>
                                            <input placeholder="" id="student_number" type="text"
                                                   class="form-control lb-lg"
                                                   name="student_number" value="{{ $last_student_id+1}}" required="" >
                                            <small class="text-danger error_msg" id="student_number_errors"></small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="teacher" class="form_label lb-lg">First Name</label>
                                        <input class="form-control lb-lg" placeholder="Ali" id="first_name" name="first_name"/>
                                        <small class="text-danger error_msg" id="first_name_errors"></small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="teacher" class="form_label lb-lg">Last Name</label>
                                        <input class="form-control lb-lg" placeholder="Usman" id="last_name" name="last_name"/>
                                        <small class="text-danger error_msg" id="last_name_errors"></small>
                                    </div>
                                </div>
                            </div>

                            <div class="row col-md-12 no-padding" style="width: 103.7%;">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email" class="form_label lb-lg">Email Address</label>
                                        <input required="" class="form-control lb-lg" placeholder="name@company.com" id="email" name="email"/>
                                        <small class="text-danger error_msg" id="email_errors"></small>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="teacher" class="form_label lb-lg">Phone Number</label>
                                        <input class="form-control lb-lg" placeholder="" id="phone_number" name="phone_number"/>
                                        <small class="text-danger error_msg" id="phone_number_errors"></small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="teacher" class="form_label lb-lg">Mobile Number</label>
                                        <input class="form-control lb-lg" placeholder="" id="mobile_number" name="mobile_number"/>
                                        <small class="text-danger error_msg" id="mobile_number_errors"></small>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="teacher" class="form_label lb-lg">Address</label>
                                        <textarea style="height:36px;" class="form-control lb-lg" placeholder="" id="address" name="address"></textarea>
                                        <small class="text-danger error_msg" id="address_errors"></small>
                                    </div>
                                </div>
                            </div>
{{--                            <div class="row">--}}
{{--                                <div class="col-md-6">--}}
{{--                                    <div class="form-group course_box">--}}
{{--                                        <select id="course_1" style="min-height: 250px;" name="course_1" class="form-control lb-lg" multiple="">--}}
{{--                                            @foreach($courses as $course)--}}
{{--                                                {{ print '<option value="'.$course->id.'">'.$course->name.'</option>'}}--}}
{{--                                            @endforeach--}}
{{--                                        </select>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group course_box">
                                        <label for="teacher" class="form_label lb-lg">Current Course</label>
                                        <input class="form-control lb-lg course_finder" placeholder="" id="current_course" name="current_course" required=""/>
                                        <div id="current_course_found" class="user_course_search minimized"></div>
                                        <small class="text-danger error_msg" id="current_course_errors"></small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="teacher" class="form_label lb-lg">Course Tutor</label>
                                        <input class="form-control lb-lg" placeholder="" id="current_course_tutor" name="current_course_tutor"/>
                                        <div id="tutors_found" class="user_tutors_search minimized"></div>
                                        <small class="text-danger error_msg" id="current_course_tutor_errors"></small>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="teacher" class="form_label lb-lg">Secondary Course</label>
                                        <input class="form-control lb-lg course_finder" placeholder="" id="secondary_course" name="secondary_course"/>
                                        <div id="secondary_course_found" class="user_course_search minimized"></div>
                                        <small class="text-danger error_msg" id="secondary_course_errors"></small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="teacher" class="form_label lb-lg">Secondary Course Tutor</label>
                                        <input class="form-control lb-lg" placeholder="" id="secondary_course_tutor" name="secondary_course_tutor"/>
                                        <div id="secondary_tutors_found" class="user_tutors_search minimized"></div>
                                        <small class="text-danger error_msg" id="secondary_course_tutor_errors"></small>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-right">
                                    <div class="form-group">
                                        <a href="#!" class="btn btn-outline-secondary" id="add_course_row"  title="add course row">Add More Courses</a>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 additional_courses_rows">
                                    <div class="form-group">
                                        <label for="teacher" class="form_label lb-lg">Additional Course(s)</label>
                                        <input class="form-control lb-lg course_finder" placeholder="" id="course_3" name="course_3"/>
                                        <div id="course_3_found" class="user_course_search minimized"></div>
                                        <small class="text-danger error_msg" id="course_3_errors"></small>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
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
                                        <label for="">Join Date</label>
                                        <div class="input-group input-append date" id="datePicker">
                                            <input required="" value="" placeholder="mm/dd/year" type="text"  class="margin-top-none datepicker form-control lb-lg" id="join_date" name="join_date">
                                            <span class="input-group-addon add-on"><i class="far fa-calendar-alt datepicker_icon"></i></span>
                                            <small class="text-danger" id="join_date_errors"></small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <hr/>
                                    <h4>Considerations</h4>
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
                                    <hr/>
                                    <h4>Payment Method</h4>
                                    <div class="col-md-4"><label><input type="radio" name="payment" value="na" checked=""> Not Applicable</label></div><!-- col -->
                                    <div class="col-md-4 text-center"><label><input type="radio" name="payment" value="f"> Paid in Full</label></div><!-- col -->
                                    <div class="col-md-4 text-center"><label><input type="radio" name="payment" value="i"> Instalment Plan</label>

                                </div>
                                <br><br>
                                </div><!-- col -->
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <hr/>
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

            </div>
        </div>
    </div>
    <script>
        (function () {
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
                // if(e.target.name !== course_input){
                //     $('.user_course_search').addClass('maximized');
                // }else{
                //     console.log('maxing');
                //     $('.user_course_search').removeClass('maximized');
                //     $('.user_course_search').addClass('minimized');
                // }

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


            //show hide notes for sen student
            $("#sen").change(function() {
                if(this.checked) {
                    $('#sen_notes').show();
                }else{
                    $('#sen_notes').hide();
                }
            });

            // if($("#fast_track").prop("checked") == false){
            //     if($("#discounted").prop("checked") == false){
            //         if($("#sen").prop("checked") == false){
            //             console.log('return false.');
            //             return false;
            //         }
            //     }
            // }

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
            //console.log('course :' + $(this).attr("id"));
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
                            /// $('#'+course_input_id+'_found').removeClass('minimized')
                            //console.log("info:"+$(this).next('.user_course_search').attr("id"));
                            ///$('#'+course_input_id+'_found').addClass('maximized');
                            $('#'+course_input_id+'_found').show();

                            var courses = response;
                            var data_holder = '';
                            courses.forEach(function(course){
                                //console.log("Key Exists:"+ course["id"]);
                                data_holder += '<a href="#!" onclick="( $(\'#'+course_input_id+'\').val( $(this).html() ) );$(this).parent().hide();">'+course["name"]+'</a>';
                            });
                            //fill in the search results
                            //$('#courses_found').html(data_holder);
                            //current_course_found
                            console.log( 'final id:'+'#' + course_input_id+'_found' );
                            $('#'+course_input_id+'_found').html(data_holder);
                        } else {
                            /// $('#'+course_input_id+'_found').removeClass('maximized');
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
                //$('#username').removeClass('highlighter');
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
            //console.log('course :' + $(this).attr("id"));
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
                           /// $('#'+course_input_id+'_found').removeClass('minimized')
                            //console.log("info:"+$(this).next('.user_course_search').attr("id"));
                            ///$('#'+course_input_id+'_found').addClass('maximized');
                            $('#'+course_input_id+'_found').show();

                            var courses = response;
                            var data_holder = '';
                            courses.forEach(function(course){
                                    //console.log("Key Exists:"+ course["id"]);
                                    data_holder += '<a href="#!" onclick="( $(\'#'+course_input_id+'\').val( $(this).html() ) );$(this).parent().hide();">'+course["name"]+'</a>';
                            });
                            //fill in the search results
                            //$('#courses_found').html(data_holder);
                            //current_course_found
                            console.log( 'final id:'+'#' + course_input_id+'_found' );
                            $('#'+course_input_id+'_found').html(data_holder);
                        } else {
                           /// $('#'+course_input_id+'_found').removeClass('maximized');
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
                //$('#username').removeClass('highlighter');
                $('#'+course_input_id+'_found').removeClass('maximized');
                $('#'+course_input_id+'_found').removeClass('minimized');
            }
        });

        //search on input - parent_name
        $('#current_course_tutor').on('input', function (e) {
            var selectedEmails = {};
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var tutor = $('#current_course_tutor').val();
            console.log('course :' + tutor);
            if (tutor !== '') {
                $.ajax({
                    url: '{{ url("/get-tutors-ajax") }}',
                    type: 'get',
                    data: 'tutor=' + tutor,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        if (response !== 'NULL') {
                            // $('#username').removeClass('highlighter');
                            $('#tutors_found').removeClass('minimized');
                            $('#tutors_found').addClass('maximized');
                            console.log("Success:");
                            //console.log("NULL:" + response[0]['name']);
                            var tutors = response;
                            var data_holder = '';
                            $('#tutors_found').html('');

                            tutors.forEach(function(tutor){
                                //if(!('user_email_item_'+tutor["id"] in selectedEmails)){
                                    console.log("Key Exists:"+ tutor["id"]);
                                    data_holder += '<a href="#!" onclick="($(\'#current_course_tutor\').val($(this).html()));">'+tutor["tutor"]+'</a>';
                                //}

                            });

                            //fill in the search results
                            $('#tutors_found').html(data_holder);

                        } else {
                            $('#tutors_found').removeClass('maximized');
                            $('#tutors_found').addClass('minimized');
                            console.log("NULL:" + response);
                        }
                    },
                    error: function (data) {
                        console.log('failure:');
                        console.log(data);
                    }
                });
            } else {
                //$('#username').removeClass('highlighter');
                $('#tutors_found').removeClass('maximized');
                $('#tutors_found').addClass('minimized');
            }
        });

        //search secondary course tutor
        $('#secondary_course_tutor').on('input', function (e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var tutor = $('#secondary_course_tutor').val();
            console.log('tutor :' + tutor);
            if (tutor !== '') {
                $.ajax({
                    url: '{{ url("/get-tutors-ajax") }}',
                    type: 'get',
                    data: 'tutor=' + tutor,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        if (response !== 'NULL') {
                            // $('#username').removeClass('highlighter');
                            $('#secondary_tutors_found').removeClass('minimized');
                            $('#secondary_tutors_found').addClass('maximized');
                            console.log("Success:");
                            //console.log("NULL:" + response[0]['name']);
                            var tutors = response;
                            var data_holder = '';
                            $('#secondary_tutors_found').html('');

                            tutors.forEach(function(tutor){
                                //if(!('user_email_item_'+tutor["id"] in selectedEmails)){
                                console.log("Key Exists:"+ tutor["id"]);
                                data_holder += '<a href="#!" onclick="($(\'#secondary_course_tutor\').val($(this).html()));">'+tutor["tutor"]+'</a>';
                                //}

                            });

                            //fill in the search results
                            $('#secondary_tutors_found').html(data_holder);

                        } else {
                            $('#secondary_tutors_found').removeClass('maximized');
                            $('#secondary_tutors_found').addClass('minimized');
                            console.log("NULL:" + response);
                        }
                    },
                    error: function (data) {
                        console.log('failure:');
                        console.log(data);
                    }
                });
            } else {
                //$('#username').removeClass('highlighter');
                $('#tutors_found').removeClass('maximized');
                $('#tutors_found').addClass('minimized');
            }
        });


        //add student form submission code
        $("#create_users").click(function (e) {
            var error_scroll = '';
            //add rules

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
                    console.log('Old Number:'+number_value);
                    $('#create-user-form')[0].reset();
                    $('#student_number').val(+number_value + 1);
                    console.log('Old Number:'+number_value);
                    console.log(response);
                    $('#success-alert').focus();
                    $("#success-alert").fadeTo(2000, 500).slideUp(500, function () {
                        //$("#create_users").attr("disabled", true);
                        //$("#create-user-form").css("display", 'none');
                        $("#success-alert").css("height", "0px");
                        $("#success-alert").css("display", "block");

                    });



                    //$(".form_inside").attr("disabled", true);
                        //$("#added_student_panel").css("display", "block");
                        // $('html, body').animate({
                        //     scrollTop: ($('#success-alert').offset().top - 166)
                        // },500);
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


