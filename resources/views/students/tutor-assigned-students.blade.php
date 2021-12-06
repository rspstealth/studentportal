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
                            <h3>Students List</h3>
                        </div>
                        @if(session()->has('message'))
                            <div class="alert alert-success">
                                {{ session()->get('message') }}
                            </div>
                        @endif
                        <div class="app_notifications label label-success" id="success-alert">
                            <h3>Success!</h3>
                        </div>

                        <div class="table-responsive">
                            <div class="col-md-12 no-padding">
                                <form class="row" id="filters_action_form" action="{{url('/students/list')}}/1"
                                      method="GET">
                                    {{ csrf_field() }}
                                    <div class="col-md-12 no-padding">
                                        <h4 class="underline"
                                            style="padding:0;height: 30px;line-height: 20px;letter-spacing: 1px;">
                                            Filters <small><a href="#" id="show_hide_panel" class="show_filters">Show
                                                    filters <i class="fas fa-chevron-circle-down"></i></a></small></h4>
                                    </div>
                                    <div class="col-md-6">
                                        <link media="all" type="text/css" rel="stylesheet"
                                              href="{{ url("/") }}/css/datepicker/css/datepicker.css">
                                        <script src="{{ url("/") }}/css/datepicker/js/bootstrap-datepicker.js">
                                        </script>
                                        <script>
                                            $(function () {
                                                $(function () {
                                                    $('.datepicker2').datepicker();
                                                });
                                            });
                                        </script>
                                        <div class="form-group">
                                            Start Date
                                            <div class="input-group input-append date" id="datePicker">
                                                <input value="<?php ((Request::query('start_date')) ? print Request::query('start_date') : "");?>"
                                                       placeholder="Choose a date" type="text"
                                                       class="margin-top-none datepicker2 form-control lb-lg"
                                                       id="start_date" name="start_date">
                                                <span class="input-group-addon add-on"><i
                                                            class="far fa-calendar-alt datepicker_icon"></i></span>
                                                <small class="text-danger" id="start_date_errors"></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <script>
                                            $(function () {
                                                $('.datepicker').datepicker();
                                            });
                                        </script>

                                        <div class="form-group">
                                            End Date
                                            <div class="input-group input-append date" id="datePicker">
                                                <input value="<?php (Request::query('end_date') ? print Request::query('end_date') : print '');?>"
                                                       placeholder="Choose a date" type="text"
                                                       class="margin-top-none datepicker form-control lb-lg"
                                                       id="end_date" name="end_date">
                                                <span class="input-group-addon add-on"><i
                                                            class="far fa-calendar-alt datepicker_icon"></i></span>
                                                <small class="text-danger" id="end_date_errors"></small>
                                            </div>
                                        </div>
                                    </div>
                                    <hr/>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            Search By Student Name or Number
                                            <input value="<?php ((Request::query('search_by_name_or_number')) ? print Request::query('search_by_name_or_number') : "");?>"
                                                   id="search_by_name_or_number" name="search_by_name_or_number"
                                                   class="form-control"/>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            Select College
                                            <select id="filter_by_college" name="filter_by_college"
                                                    class="form-control lb-lg">
                                                <option
                                                    <?php ((Request::query('filter_by_college')) ? (Request::query('filter_by_college') == 'ALL' ? print "selected" : "") : "");?> value="">
                                                    ALL
                                                </option>
                                                <option
                                                    <?php ((Request::query('filter_by_college')) ? (Request::query('filter_by_college') == 'GR' ? print "selected" : "") : "");?> value="GR">
                                                    GR
                                                </option>
                                                <option
                                                    <?php ((Request::query('filter_by_college')) ? (Request::query('filter_by_college') == 'CO' ? print "selected" : "") : "");?> value="CO">
                                                    CO
                                                </option>
                                                <option
                                                    <?php ((Request::query('filter_by_college')) ? (Request::query('filter_by_college') == 'CH' ? print "selected" : "") : "");?> value="CH">
                                                    CH
                                                </option>
                                                <option
                                                    <?php ((Request::query('filter_by_college')) ? (Request::query('filter_by_college') == 'BU' ? print "selected" : "") : "");?> value="BU">
                                                    BU
                                                </option>
                                                <option
                                                    <?php ((Request::query('filter_by_college')) ? (Request::query('filter_by_college') == 'DL' ? print "selected" : "") : "");?> value="DL">
                                                    DL
                                                </option>
                                                <option
                                                    <?php ((Request::query('filter_by_college')) ? (Request::query('filter_by_college') == 'EDU' ? print "selected" : "") : "");?> value="EDU">
                                                    EDU
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <hr/>

                                    <div class="col-md-8">
                                        Filter By Course
                                        <select id="filter_by_course" name="filter_by_course" class="form-control">
                                            <option
                                                <?php ((Request::query('filter_by_course')) ? (Request::query('filter_by_course') === '' ? print "selected" : "") : "");?> value="">
                                                Select Course
                                            </option>
                                            @foreach($courses as $course)
                                                <option
                                                <?php ((Request::query('filter_by_course')) ? (Request::query('filter_by_course') == $course->id ? print "selected" : "") : "");?> value="{{$course->id}}">{{$course->name}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-2">
                                        Student Status
                                        <select id="student_status" name="student_status" class="form-control">
                                            <option
                                                <?php ((Request::query('student_status')) ? (Request::query('student_status') === 'active' ? print "selected" : "") : "");?> value="active">
                                                Active
                                            </option>
                                            <option
                                                <?php ((Request::query('student_status')) ? (Request::query('student_status') === 'completed_courses' ? print "selected" : "") : "");?> value="completed_courses">
                                                Completed Courses
                                            </option>
                                            <option
                                                <?php ((Request::query('student_status')) ? (Request::query('student_status') === 'suspended_students' ? print "selected" : "") : "");?> value="suspended_students">
                                                Suspended Students
                                            </option>
                                            <option
                                                <?php ((Request::query('student_status')) ? (Request::query('student_status') === 'due_expiry' ? print "selected" : "") : "");?> value="due_expiry">
                                                Due Expiry
                                            </option>
                                            <option
                                                <?php ((Request::query('student_status')) ? (Request::query('student_status') === 'expired_courses' ? print "selected" : "") : "");?> value="expired_courses">
                                                Expired Courses
                                            </option>
                                            <option
                                                <?php ((Request::query('student_status')) ? (Request::query('student_status') === 'requested_certificate' ? print "selected" : "") : "");?> value="requested_certificate">
                                                Requested Certificate
                                            </option>
                                            <option
                                                <?php ((Request::query('student_status')) ? (Request::query('student_status') === 'archived_students' ? print "selected" : "") : "");?> value="archived_students">
                                                Archived Students
                                            </option>
                                        </select>
                                    </div>

                                    <div class="col-md-2">
                                        Sort By
                                        <select id="sort_by" name="sort_by" class="form-control">
                                            <option
                                                <?php ((Request::query('sort_by')) ? (Request::query('sort_by') === 'surname' ? print 'selected' : "") : "");?> value="surname">
                                                Surname
                                            </option>
                                            <option
                                                <?php ((Request::query('sort_by')) ? (Request::query('sort_by') === 'join_date' ? print 'selected' : "") : "");?> value="join_date">
                                                Join Date
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-4" style="margin-top: 16px;">
                                        <button type="submit" href="#" id="filter_btn"
                                                class="btn btn-outline-secondary "><i class="fa fa-filter"></i> Filter
                                            Records
                                        </button>
                                        <button type="button" href="#" id="reset_btn"
                                                class="btn btn-outline-secondary "><i class="fas fa-broom"></i> Clear
                                            Filters
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <div class="table student_list_table">
                                <div class="col-md-12 no-padding tablehead">
                                    <div class="col-md-3"><h4>Name - #</h4></div>
                                    <div class="col-md-3"><h4>Email</h4></div>
                                    <div class="col-md-2"><h4>Phone</h4></div>
                                    <div class="col-md-4"><h4>Actions</h4></div>
                                </div>
                                <?php
                                foreach($students as $student){
                                ?>
                                <div class="col-md-12 no-padding tablerow">
                                    <div class="col-md-3">{{ $student->first_name .' '. $student->last_name }}
                                        - <a href="#" id="edit_profile_action_{{$student->id}}" class="edit_profile_action" title="View {{$student->first_name .' '. $student->last_name}} profile">{{ $student->student_number }}</a>
                                        <a href="{{url('/impersonate/user/'.App\Http\Controllers\UserController::getUserIdByStudentId($student->id))}}" id="impersonate_user_{{$student->id}}" class="impersonate_user_btn" title="Login as {{$student->first_name .' '. $student->last_name}}"><i class="fas fa-sign-in-alt"></i></a>
                                    </div>
                                    <div class="col-md-3">{{ $student->email }}</div>
                                    <div class="col-md-2">{{ $student->phone_number }}</div>
                                    <div class="col-md-2">
                                        <select id="actions_select_{{ $student->id }}"
                                                class="form-control lb-lg action_select">
                                            <option value="none">Choose an Action</option>
                                            <option value="priority">Priority student</option>
                                            <option value="delete">Delete</option>
                                            <?php
                                            if(!empty(App\Http\Controllers\UserController::checkIfStudentSuspended($student->id))){
                                                echo '<option value="unsuspend">Unsuspend</option>';
                                            }else{
                                                echo '<option value="suspend">Suspend - Unpaid Fees</option>';
                                            }
                                            ?>
                                            <option value="archive">Move to Archive</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <a href="#!" class="btn btn-outline-secondary" id="toggle_{{$student->id}}"
                                           onclick="showStudentCourses({{$student->id}})">Submitted Work <i
                                                    class="fas fa-angle-double-down"></i></a>
                                    </div>
                                </div>
                                <div style="display:none;"
                                     class="col-md-12 no-padding hidden_row_wrap hidden_row_wrap_{{$student->id}}">
                                    <?php
                                    $counter = 0;
                                    foreach($student_assigned_courses[$student->id] as $a_course){
                                    if($counter === 0 ){
                                    ?>
                                    <div class="col-md-12 no-padding tablerow hidden_rows_{{$student->id}}">
                                        <div class="col-md-6"><h5>Course</h5></div>
                                        <div class="col-md-3"><h5>Join / Expiry Date</h5></div>
                                        <div class="col-md-3"><h5>Actions</h5></div>
                                    </div>
                                    <?php
                                    $counter++;
                                    }
                                    ?>
                                    <div class="col-md-12 no-padding tablerow hidden_rows_{{$student->id}}">
                                        <div class="col-md-6">
                                            <?php echo App\Http\Controllers\CourseController::getCourseNameById($a_course->course_id);?>
                                        </div>
                                        <div class="col-md-3">{{date('d-m-Y',strtotime($a_course->join_date))}}
                                            / {{date('d-m-Y',strtotime($a_course->expiry_date))}}</div>
                                        <div class="col-md-3">
                                            <select id="mark_completed_{{ $student->id }}_{{$a_course->course_id}}_<?php echo App\Http\Controllers\CourseController::getCourseTypeById($a_course->course_id);?>"
                                                    class="mark_action form-control lb-lg">
                                                <option selected="" value="upload_for_marking">Choose an
                                                    Action
                                                </option>
                                                <option value="upload_for_marking">Upload for Marking</option>
                                                <option value="upload_to_dashboard">Upload to Dashboard Only
                                                </option>
                                                <option value="mark_as_completed">Mark as Completed</option>
                                            </select>
                                        </div>
                                    </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                                <?php
                                }
                                ?>
                            </div>
                            <div id="filters_out_form" class="col-md-12 text-right" style="margin-top: 16px;">
                                Records found: <span class="numeric_big">{{$total}}</span>&nbsp;
                                Page: <span class="numeric_big">{{$page_var}}</span> of <span
                                        class="numeric_big">{{$totalPages}}</span>
                                <?php
                                if($total > 0){
                                if($page_var > 1){
                                ?>
                                <a class="action_buttons"
                                   href="{{url('/students')}}/list/{{$page_var-1}}?_token={{ csrf_token() }}&start_date={{((Request::query('start_date')) ? Request::query('start_date') : '' )}}&end_date={{(Request::query('end_date') ?: print Request::query('end_date')  )}}&search_by_name_or_number={{((Request::query('search_by_name_or_number')) ? Request::query('search_by_name_or_number') : '' )}}&filter_by_course={{((Request::query('filter_by_course')) ? Request::query('filter_by_course') : "" )}}&student_status={{((Request::query('student_status')) ? Request::query('student_status') : "" )}}&sort_by={{((Request::query('sort_by')) ? Request::query('sort_by') : "" )}}&filter_by_college={{((Request::query('filter_by_college')) ? Request::query('filter_by_college') : "" )}}"
                                   title="Previous"><i class="fas fa-chevron-left"> </i> Previous</a>
                                <?php
                                }
                                ?>
                                <?php
                                //eg: total 5 > current 5
                                if($page_var < $totalPages){
                                ?>
                                <a class="action_buttons"
                                   href="{{url('/students')}}/list/{{$page_var+1}}?_token={{ csrf_token() }}&start_date={{((Request::query('start_date')) ? Request::query('start_date') : "" )}}&end_date={{(Request::query('end_date') ?: print Request::query('end_date') )}}&search_by_name_or_number={{((Request::query('search_by_name_or_number')) ? Request::query('search_by_name_or_number') : "" )}}&filter_by_course={{((Request::query('filter_by_course')) ? Request::query('filter_by_course') : "" )}}&student_status={{((Request::query('student_status')) ? Request::query('student_status') : "" )}}&sort_by={{((Request::query('sort_by')) ? Request::query('sort_by') : "" )}}&filter_by_college={{((Request::query('filter_by_college')) ? Request::query('filter_by_college') : "" )}}"
                                   title="Next">Next <i class="fas fa-chevron-right"></i></a>
                                <?php
                                }
                                }
                                ?>
                            </div>

                            {{--Edit Admin modal--}}
                            <div id="modal_student_edit_action" class="modal modal_student_edit_action" tabindex="-1" role="dialog">
                                <div class="edit-student-modal-dialog modal_student_edit_dialog" role="document">
                                    <div class="modal-content align-items-center" style="padding: 0 20px;">
                                        <div class="modal-body">
                                            <h3>Student Account Details <a href="#" title="close dialog" id="close_student_profile_dialog" style="float: right;margin: 0 10px;"><i class="fa fa-close"></i></a></h3>
                                        </div>
                                        <div class="modal-footer">
                                            <form style="text-align:left;" id="edit_student_profile_form" action="{{url('/students/list/')}}/{{$page_var}}" method="POST">
                                                {{ csrf_field() }}
                                                <div class="col-md-12 no-padding">
                                                    <div class="col-md-12 no-padding">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                Student Number
                                                                <input class="form-control lb-lg"  id="student_number" name="student_number" />
                                                                <small class="text-danger error_msg" id="student_number_errors"></small>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                First Name
                                                                <input class="form-control lb-lg"  id="first_name" name="first_name" />
                                                                <small class="text-danger error_msg" id="first_name_errors"></small>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                Last Name
                                                                <input class="form-control lb-lg"  id="last_name" name="last_name" />
                                                                <small class="text-danger error_msg" id="last_name_errors"></small>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12 no-padding">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                Email
                                                                <input class="form-control lb-lg"  id="email" name="email" />
                                                                <small class="text-danger error_msg" id="email_errors"></small>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                Phone
                                                                <input class="form-control lb-lg"  id="phone" name="phone" />
                                                                <small class="text-danger error_msg" id="phone_errors"></small>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                Mobile
                                                                <input class="form-control lb-lg"  id="mobile" name="mobile" />
                                                                <small class="text-danger error_msg" id="mobile_errors"></small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 no-padding">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                Awarding Body Reg. Num.
                                                                <input class="form-control lb-lg"  id="awarding_body_reg_no" name="awarding_body_reg_no" />
                                                                <small class="text-danger error_msg" id="awarding_body_reg_no_errors"></small>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                Address
                                                                <textarea style="min-height: 60px;" id="address" name="address" class="form-control lb-lg"></textarea>
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <h3>Documents Uploaded</h3>
                                                        <hr>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="is_reseller" class="form_label lb-lg">
                                                                    Reseller <input type="checkbox" id="is_reseller" name="is_reseller">
                                                                </label>
                                                                &nbsp;
                                                                &nbsp;
                                                                &nbsp;
                                                                <label class="form_label lb-lg">Discounted Student <input type="checkbox" id="is_discounted" name="is_discounted"></label>
                                                                &nbsp;
                                                                &nbsp;
                                                                &nbsp;
                                                                <label  class="form_label lb-lg">SEN <input type="checkbox" id="is_sen" name="is_sen"></label>
                                                                <hr>
                                                            </div>
                                                        </div>

{{--                                                        <div class="col-md-4">--}}
{{--                                                            <div class="form-group">--}}
{{--                                                                Username--}}
{{--                                                                <input autocomplete="off" type="text" class="form-control lb-lg"  id="username" name="username" />--}}
{{--                                                                <small class="text-danger error_msg" id="username_errors"></small>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                        <div class="col-md-4">--}}
{{--                                                            <div class="form-group">--}}
{{--                                                                Password--}}
{{--                                                                <input autocomplete="off" type="password" class="form-control lb-lg"  id="password" name="password" />--}}
{{--                                                                <small class="text-danger error_msg" id="username_errors"></small>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
                                                        <div id="assigned_courses_panel"></div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <a href="#" class="btn btn-outline-primary" id="add_more_course_btn" name="add_more_course_btn">Add More Courses</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <input type="hidden" id="method" name="method" value="student_profile_edit" />
                                                <input type="hidden" id="student_id" name="student_id" value="" />
                                                <div class="col-md-12">
                                                    <hr/>
                                                    <input class="btn btn-primary" type="submit" id="confirm_student_profile_edit" name="confirm_student_profile_edit" value="Update" />
                                                    <button type="button" id="cancelled_student_profile" class="btn btn-outline-secondary ">Cancel</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{--Delete Confirmation Modal--}}
                            <div id="modal_delete_action" class="modal modal_delete_action" tabindex="-1" role="dialog">
                                <div class="delete-modal-dialog modal_delete_dialog" role="document">
                                    <div class="modal-content align-items-center">
                                        <div class="modal-body">
                                            <h3>Confirm Delete Student? <a href="#" title="close dialog"
                                                                           id="close_dialog"
                                                                           style="float: right;margin: 0 10px;"><i
                                                            class="fa fa-close"></i></a></h3>
                                                <p>This action cannot be undone.</p>
                                        </div>
                                        <div class="modal-footer">
                                            <form id="del_selected_form"
                                                  action="{{url('/students/list')}}/{{$page_var}}" method="POST">
                                                {{ method_field('delete') }}
                                                {{ csrf_field() }}
                                                <input type="hidden" id="total" name="total" value="{{$total}}"/>
                                                <input type="hidden" id="totalPages" name="totalPages"
                                                       value="{{$totalPages}}"/>
                                                <input type="hidden" id="page_var" name="page_var"
                                                       value="{{$page_var}}"/>
                                                <input type="hidden" id="id" name="id" value=""/>
                                                <input class="btn btn-outline-secondary " type="submit"
                                                       id="confirmed_delete" name="confirmed_delete" value="Delete"/>
                                                <button type="button" id="cancelled_delete"
                                                        class="btn btn-outline-secondary ">Cancel
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{--Archive Confirmation Modal--}}
                            <div id="modal_archive_action" class="modal modal_archive_action" tabindex="-1"
                                 role="dialog">
                                <div class="archive-modal-dialog modal_archive_dialog" role="document">
                                    <div class="modal-content align-items-center">
                                        <div class="modal-body">
                                            <h3>Confirm Archive Student? <a href="#" title="close dialog"
                                                                            id="close_archive_dialog"
                                                                            style="float: right;margin: 0 10px;"><i
                                                            class="fa fa-close"></i></a></h3>
                                                <p>This will remove user from the active student list.</p>
                                        </div>
                                        <div class="modal-footer">
                                            <form id="del_archive_form" action="{{url('/students/list')}}/{{$page_var}}"
                                                  method="POST">
                                                {{ csrf_field() }}
                                                <input type="hidden" id="method" name="method" value="archive"/>
                                                <input type="hidden" id="total" name="total" value="{{$total}}"/>
                                                <input type="hidden" id="totalPages" name="totalPages"
                                                       value="{{$totalPages}}"/>
                                                <input type="hidden" id="page_var" name="page_var"
                                                       value="{{$page_var}}"/>
                                                <input type="hidden" id="archived_student_id" name="archived_student_id"
                                                       value=""/>
                                                <input class="btn btn-outline-secondary " type="submit"
                                                       id="confirmed_archive" name="confirmed_archive" value="Archive"/>
                                                <button type="button" id="cancelled_archive"
                                                        class="btn btn-outline-secondary ">Cancel
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{--Suspend Confirmation Modal--}}
                            <div id="modal_suspend_action" class="modal modal_suspend_action" tabindex="-1"
                                 role="dialog">
                                <div class="suspend-modal-dialog modal_suspend_dialog" role="document">
                                    <div class="modal-content align-items-center">
                                        <div class="modal-body">
                                            <h3>Confirm Student Suspension? <a href="#" title="close dialog"
                                                                               id="close_suspend_dialog"
                                                                               style="float: right;margin: 0 10px;"><i
                                                            class="fa fa-close"></i></a></h3>
                                                <p>This will remove user's access to the dashboard.</p>
                                        </div>
                                        <div class="modal-footer">
                                            <form id="del_suspend_form" action="{{url('/students/list')}}/{{$page_var}}"
                                                  method="POST">
                                                {{ csrf_field() }}
                                                <input type="hidden" id="method" name="method" value="suspend"/>
                                                <input type="hidden" id="total" name="total" value="{{$total}}"/>
                                                <input type="hidden" id="totalPages" name="totalPages"
                                                       value="{{$totalPages}}"/>
                                                <input type="hidden" id="page_var" name="page_var"
                                                       value="{{$page_var}}"/>
                                                <input type="hidden" id="suspended_student_id"
                                                       name="suspended_student_id" value=""/>
                                                <input class="btn btn-outline-secondary " type="submit"
                                                       id="confirmed_suspend" name="confirmed_suspend" value="Suspend"/>
                                                <button type="button" id="cancelled_suspend"
                                                        class="btn btn-outline-secondary ">Cancel
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{--unsuspend Confirmation Modal--}}
                            <div id="modal_unsuspend_action" class="modal modal_unsuspend_action" tabindex="-1"
                                 role="dialog">
                                <div class="unsuspend-modal-dialog modal_unsuspend_dialog" role="document">
                                    <div class="modal-content align-items-center">
                                        <div class="modal-body">
                                            <h3>Confirm Student Unsuspension? <a href="#" title="close dialog"
                                                                               id="close_unsuspend_dialog"
                                                                               style="float: right;margin: 0 10px;"><i
                                                            class="fa fa-close"></i></a></h3>
                                            <p>This will allow user's access to the dashboard.</p>
                                        </div>
                                        <div class="modal-footer">
                                            <form id="del_unsuspend_form" action="{{url('/students/list')}}/{{$page_var}}"
                                                  method="POST">
                                                {{ csrf_field() }}
                                                <input type="hidden" id="method" name="method" value="unsuspend"/>
                                                <input type="hidden" id="total" name="total" value="{{$total}}"/>
                                                <input type="hidden" id="totalPages" name="totalPages"
                                                       value="{{$totalPages}}"/>
                                                <input type="hidden" id="page_var" name="page_var"
                                                       value="{{$page_var}}"/>
                                                <input type="hidden" id="unsuspended_student_id"
                                                       name="unsuspended_student_id" value=""/>
                                                <input class="btn btn-outline-secondary " type="submit"
                                                       id="confirmed_unsuspend" name="confirmed_unsuspend" value="Unsuspend"/>
                                                <button type="button" id="cancelled_unsuspend"
                                                        class="btn btn-outline-secondary ">Cancel
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{--Priority Confirmation Modal--}}
                            <div id="modal_priority_action" class="modal modal_priority_action" tabindex="-1"
                                 role="dialog">
                                <div class="priority-modal-dialog modal_priority_dialog" role="document">
                                    <div class="modal-content align-items-center">
                                        <div class="modal-body">
                                            <h3>Set Student Priority? <a href="#" title="close dialog"
                                                                         id="close_priority_dialog"
                                                                         style="float: right;margin: 0 10px;"><i
                                                            class="fa fa-close"></i></a></h3>
                                            <p>This will set all student's current courses set to priority list.</p>
                                        </div>
                                        <div class="modal-footer">
                                            <form id="del_priority_form"
                                                  action="{{url('/students/list')}}/{{$page_var}}" method="POST">
                                                {{ csrf_field() }}
                                                <input type="hidden" id="method" name="method" value="priority"/>
                                                <input type="hidden" id="total" name="total" value="{{$total}}"/>
                                                <input type="hidden" id="totalPages" name="totalPages"
                                                       value="{{$totalPages}}"/>
                                                <input type="hidden" id="page_var" name="page_var"
                                                       value="{{$page_var}}"/>
                                                <input type="hidden" id="priority_student_id" name="priority_student_id"
                                                       value=""/>
                                                <input class="btn btn-outline-secondary " type="submit"
                                                       id="confirmed_priority" name="confirmed_priority"
                                                       value="priority"/>
                                                <button type="button" id="cancelled_priority"
                                                        class="btn btn-outline-secondary ">Cancel
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{--Admin modal--}}
                        <div id="modal_upload_for_marking_action" class="modal modal_upload_for_marking_action"
                             tabindex="-1" role="dialog">
                            <div class="upload-for-marking-modal-dialog modal_upload_for_marking_dialog text-align-left"
                                 role="document">
                                <div class="modal-content" style="padding: 0 20px;">
                                    <div class="modal-body">
                                        <h3>Upload File<a href="#" title="Close Dialog"
                                                          id="close_upload_for_marking_dialog"
                                                          style="float: right;margin: 0 10px;"><i
                                                        class="fa fa-close"></i></a></h3>
                                    </div>
                                    <div class="modal-footer">
                                        <form id="add_upload_for_marking_form"
                                              action="{{url('/students/list/')}}/{{$page_var}}"
                                              method="POST">
                                            {{ csrf_field() }}
                                            <div class="col-md-12 no-padding">
                                                <div class="col-md-12 no-padding">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <h3>Course Name</h3>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <h3>Student Name</h3>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            Assignment #:
                                                            <select name="assignment_number" id="assignment_number">
                                                                <option>Choose Assignment</option>
                                                                <option value=""></option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="">Full Price
                                                                <input type="checkbox" id="resubmission"
                                                                       name="resubmission"/>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            Upload File
                                                            <input type="file" class="form-control lb-lg"
                                                                   id="uploaded_file" name="uploaded_file"/>
                                                            <small class="text-danger error_msg"
                                                                   id="uploaded_file_errors"></small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <input type="hidden" id="method" name="method"
                                                   value="admin_assignment_upload"/>
                                            <div class="col-md-12">
                                                <hr/>
                                                <input class="btn btn-primary" type="submit" id="confirmed_admin_upload"
                                                       name="confirmed_admin_upload" value="Submit"/>
                                                <button type="button" id="cancelled_admin_marking_upload"
                                                        class="btn btn-outline-secondary ">Cancel
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{--upload to dashboard--}}
                        <div id="upload_to_dashboard_action" class="modal upload_to_dashboard_action" tabindex="-1"
                             role="dialog">
                            <div class="upload-to-dashboard-modal-dialog upload_to_dashboard_dialog text-align-left"
                                 role="document">
                                <div class="modal-content" style="padding: 0 20px;">
                                    <div class="modal-body">
                                        <h3>Upload File<a href="#" title="close dialog"
                                                          id="close_upload_for_dashboard_dialog"
                                                          style="float: right;margin: 0 10px;"><i
                                                        class="fa fa-close"></i></a></h3>
                                    </div>
                                    <div class="modal-footer">
                                        <form id="add_upload_for_dashboard_form"
                                              action="{{url('/students/list/')}}/{{$page_var}}"
                                              method="POST" enctype="multipart/form-data">
                                            {{ csrf_field() }}
                                            <div class="col-md-12 no-padding">
                                                <div class="col-md-12 no-padding">
                                                    <div class="col-md-12 no-padding">
                                                        <div class="form-group">
                                                            <h4 style="padding:5px 0" id="dashboard_course_name">Course Name</h4>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 no-padding">
                                                        <div class="form-group">
                                                            <h4 style="padding:5px 0" id="dashboard_student_name">Student Name</h4>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 no-padding">
                                                        <div class="form-group">
                                                            Assignment #:
                                                            <select class="form-control lb-lg" name="dashboard_assignment_number"
                                                                    id="dashboard_assignment_number">
                                                                <option>Choose Assignment</option>
                                                            </select>
                                                            <small class="text-danger error_msg"
                                                                   id="dashboard_assignment_number_errors"></small>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12 no-padding">
                                                        <div class="form-group">
                                                            <label>Re-submission
                                                                <input type="checkbox" id="resubmission"
                                                                       name="resubmission"/>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 no-padding">
                                                        <div class="form-group">
                                                            Upload File
                                                            <input type="file" class="form-control lb-lg"
                                                                   id="uploaded_file" name="uploaded_file"/>
                                                            <small class="text-danger error_msg"
                                                                   id="uploaded_file_errors"></small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <input type="hidden" id="method" name="method"
                                                   value="assignment_upload_for_dashboard"/>
                                            <input type="hidden" id="assignment_dashboard_course_id" name="assignment_dashboard_course_id"
                                                   value=""/>
                                            <input type="hidden" id="assignment_dashboard_course_type" name="assignment_dashboard_course_type"
                                                   value=""/>
                                            <input type="hidden" id="assignment_dashboard_student_id" name="assignment_dashboard_student_id"
                                                   value=""/>
                                            <div class="col-md-12">
                                                <hr/>
                                                <input class="btn btn-primary" type="submit" id="upload_assignment_to_dashboard_btn"
                                                       name="upload_assignment_to_dashboard_btn" value="Submit"/>
                                                <button type="button" id="cancelled_admin_dashboard_upload"
                                                        class="btn btn-outline-secondary ">Cancel
                                                </button>
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
        function showStudentCourses(student_id) {
            console.log("SHOW ROWS for Student:" + student_id);
            var html = $('#toggle_' + student_id).html();
            $(".hidden_row_wrap_" + student_id).slideToggle();

            if (html == 'Submitted Work <i class="fas fa-angle-double-down"></i>') {
                $('#toggle_' + student_id).html('Submitted Work <i class="fas fa-angle-double-up"></i>');
                $('#toggle_' + student_id).css('border-color', 'salmon');
            }
            if (html == 'Submitted Work <i class="fas fa-angle-double-up"></i>') {
                $('#toggle_' + student_id).html('Submitted Work <i class="fas fa-angle-double-down"></i>');
                $('#toggle_' + student_id).css('border-color', 'lightblue');
            }
        }

        //event handler registered for dynamically added button
        $(document.body).on('click', '.current_course_extend_support_btn' ,function(e){
            console.log('Keep moving>>>');
            console.log('Log ID:'+this.id);
            var str = this.id;
            var id = str.split(/[\s_]+/);
            var extension_period = $('#course_'+id[1]+'_extend_select').val();
            var assigned_course_id = id[2];
            var student_id = id[3];
            //if not extension was selected return doing nothing
            if(extension_period === ''){
                return false;
            }else{
                console.log("Splitted Val:" + extension_period);
            }
            console.log("assigned course id:" + assigned_course_id);
            console.log("stud id:" + student_id);

            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: '{{ url("/extend-course-subscription") }}',
                type: 'get',
                data: 'assigned_course_id='+assigned_course_id+'&student_id='+student_id+'&extension_period='+extension_period,
                processData: false,
                contentType: false,
                success: function (response) {
                    console.log('response:'+response);
                    if(response=='success'){
                        $('#success-alert').html('<h3>Extended Course Subscription Successfully!</h3>');
                        $('#success-alert').focus();
                        $("#success-alert").fadeTo(2000, 500).slideUp(500, function () {
                            $("#success-alert").css("height", "0px");
                            $("#success-alert").css("display", "block");
                            var page = '<?php echo url("/")?>'+'/students/list/{{$page_var}}';
                            window.location.href = page
                        });
                    }
                },
                error: function (data) {
                    console.log('failure:');
                    console.log(data);
                }
            });
        });


        (function () {
            setTimeout(function () {
                $('.alert-success').fadeOut('slow');
            }, 3000); // time in milliseconds

            $("#filter_btn").on("click", function (e) {
                this.form.submit();
            });


            $("#reset_btn").on("click", function (e) {
                $(':input', '#filters_action_form')
                    .not(':button, :submit, :reset, :hidden')
                    .val('')
                    .removeAttr('checked')
                    .removeAttr('selected');
            });

            $('#all_courses').on('input', function (e) {
                $('#all_courses :selected').each(function(i, selected){
                    $('#course_search').val($(this).text());
                });
            });

            $('#all_courses2').on('input', function (e) {
                $('#all_courses2 :selected').each(function(i, selected){
                    $('#course_search2').val($(this).text());
                });
            });

            $(".edit_profile_action").on("click", function (e) {
                //process request
                //console.log("Processing Edit Request:"+this.id);
                var str = this.id;
                var id = str.split(/[\s_]+/);
                console.log("Splitted Id:" + id[3]);
                $("#student_id").val(id[3]);

                //perform ajax call to get selected user data for modal dialog to be updated
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-XSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                var formdata = new FormData($("#edit_student_profile_form")[0]);
                console.log("formdata");
                console.log(formdata);

                $.ajax({
                    url: '{{ url('/get-user-by-id-ajax') }}',
                    type: 'get',
                    data:'edit_student_id='+id[3]+'&method=students',
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        console.log('full resp:');
                        console.log(response);
                        //set values to edit tutor dialog fields
                        $("#student_number").val(response[0]['student_number']);
                        $("#first_name").val(response[0]['first_name']);
                        $("#last_name").val(response[0]['last_name']);
                        $("#email").val(response[0]['email']);
                        $("#phone").val(response[0]['phone_number']);
                        $("#mobile").val(response[0]['mobile_number']);
                        $("#address").html(response[0]['address']);

                        var considerations = response[1];
                        considerations.forEach(function(consideration){
                            console.log("title:"+consideration['title'] );
                            switch(consideration['title']) {
                                case 'reseller':
                                    $( "#is_reseller" ).prop( "checked", true );
                                    break;
                                case 'discounted':
                                    $( "#is_discounted" ).prop( "checked", true );
                                    break;
                                case 'sen':
                                    $( "#is_sen" ).prop( "checked", true );
                                    break;
                                case 'fast_track':
                                    $( "#is_fast_track" ).prop( "checked", true );
                                    break;
                                default:
                                    $( "#is_sen" ).prop( "checked", false );
                            }
                        });

                        //assigned courses
                        var courses = response[2];
                        var counter = 0;
                        var assigned_courses_panel = $('#assigned_courses_panel');
                        assigned_courses_panel.html('');
                        var html_string = '';
                        courses.forEach(function(course){
                            console.log('Iteration:'+counter);
                            counter++;
                            html_string  = html_string + '<div class="col-md-12 settings_card" style="margin-bottom:15px;">' +
                                '<div class="col-md-12">' +
                                '<div class="form-group"> Course Title' +
                                '<input type="hidden" id="course_'+counter+'_id" name="course_'+counter+'_id" value="'+course["id"]+'"/>' +
                                '<input type="text" value="'+course["name"]+'" id="course_title_'+counter+'" placeholder="Search Course By Name" name="course_title_'+counter+'" class="form-control lb-lg"/>' +
                                '<small class="text-danger" id="course_search_errors"></small>' +
                                '</div></div>';

                            html_string  = html_string + '<div class="col-md-12">'+
                                '<div class="form-group">'+
                                'Course Tutor<select  class="form-control lb-lg"  id="course_tutor'+counter+'" name="course_tutor'+counter+'" >'+
                                '<?php foreach($tutors as $tutor){echo '<option value="'.$tutor->id.'">'.$tutor->first_name.' '.$tutor->last_name.'</option>';}?>'+
                                '</select><small class="text-danger error_msg" id="course_tutor'+counter+'_errors"></small>'+
                                '</div></div>';
                            var dateAr = course["expiry_date"].split('-');
                            var exp_date = dateAr[2] + '-' + dateAr[1] + '-' + dateAr[0].slice(-2);

                            html_string  = html_string + '<div class="col-md-12 no-padding ">'+
                                '<div class="col-md-3"><div class="form-group">Expired '+
                                '<input class="form-control lb-lg" readonly="" id="course_'+counter+'_extend_support" value="'+exp_date+'" name="course_'+counter+'_extend_support" />'+
                                '<small class="text-danger error_msg" id="course_'+counter+'_extend_support_errors"></small></div></div>'+
                                '<div class="col-md-3"><div class="form-group">Select Extension Duration '+
                                '<select class="form-control lb-lg"  id="course_'+counter+'_extend_select" name="course_'+counter+'_extend_select">'+
                                '<option value="">Select Extended Period</option>'+
                                '<option value="30">1 Month</option>'+
                                '<option value="60">3 Months</option>'+
                                '<option value="180">6 Months</option>'+
                                '<option value="365">1 Year</option></select>'+
                                '<small class="text-danger error_msg" id="course_'+counter+'_extend_select_errors"></small></div></div>'+
                                '<div class="col-md-3">'+
                                '<div class="form-group">&nbsp;<br>' +
                                '<a href="#" id="course_'+counter+'_'+course["id"]+'_'+id[3]+'_extend_support_btn" class="current_course_extend_support_btn form-control btn btn-primary-outline full-width text-primary"><i class="fa fa-plus"></i> EXTEND SUPPORT</a>' +
                                '</div></div></div></div></div>';

                            assigned_courses_panel.html(html_string);
                            $( "#is_reseller" ).prop( "checked", true );
                        });

                        var chosen_course_ids = response[0]['assigned_courses'].split(',');
                        chosen_course_ids = chosen_course_ids.filter(item => item);

                        $("#edit_all_courses").children().each(function(){
                                if(chosen_course_ids.includes($(this).val())){
                                    console.log('GOT IT:'+$(this).val());
                                    $("#edit_chosen_courses").html( $("#edit_chosen_courses").html() + '<option value="'+$(this).val()+'">'+$(this).text()+'</option>');
                                    $(this).remove();
                                }
                            }
                        );
                    },
                    error: function (data) {
                        console.log(data);
                        console.log('scroll error'+error_scroll);
                        $('#'+error_scroll).focus();
                    }
                });
                $(".modal_student_edit_action").show();
            });

            //find searched courses
            $('.course_search').on('input', function (e) {
                console.log('Log ID:'+this.id);
                return false;

                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                var searched_course = $('#'+this.id).val();

                $.ajax({
                    url: '{{ url("/get-courses-where-not-in-ajax") }}',
                    type: 'get',
                    data: 'course=' + searched_course+'&added_courses_ids=',
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        console.log('response:'+response);
                        if (response !== 'NULL') {
                            var courses = response;
                            var data_holder = '';
                            $('#all_courses').html('');
                            courses.forEach(function(course){
                                //console.log('$(this).val()'+course['id']);
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

            //find searched courses
            $('#course_search2').on('input', function (e) {
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var searched_course = $('#course_search2').val();

                $.ajax({
                    url: '{{ url("/get-courses-where-not-in-ajax") }}',
                    type: 'get',
                    data: 'course=' + searched_course+'&added_courses_ids=',
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        console.log('response:'+response);
                        if (response !== 'NULL') {
                            var courses = response;
                            var data_holder = '';
                            $('#all_courses2').html('');
                            courses.forEach(function(course){
                                //console.log('$(this).val()'+course['id']);
                                $("#all_courses2").html( $("#all_courses2").html() + '<option value="'+course['id']+'">'+course['name']+'</option>');
                            });
                        }
                    },
                    error: function (data) {
                        console.log('failure:');
                        console.log(data);
                    }
                });
            });

            $("#show_hide_panel").on("click", function (e) {
                if ($("#show_hide_panel").hasClass("hide_filters")) {
                    $("#show_hide_panel").removeClass("hide_filters");
                    $("#show_hide_panel").addClass("show_filters");
                    $("#show_hide_panel").html('Show filters <i class=\"fas fa-chevron-circle-down\"></i>');
                    $("#filters_action_form").css('height', '46px');
                } else if ($("#show_hide_panel").hasClass("show_filters")) {
                    $("#show_hide_panel").removeClass("show_filters");
                    $("#show_hide_panel").addClass("hide_filters");
                    $("#show_hide_panel").html('Hide filters <i class=\"fas fa-chevron-circle-up\"></i>');
                    $("#filters_action_form").css('height', '370px');
                }
            });

            $("#close_student_profile_dialog").on("click", function (e) {
                console.log("Cancelling profile edit");
                $(".modal_student_edit_action").hide();
            });

            $("#cancelled_student_profile").on("click", function (e) {
                console.log("Cancelling profile edit");
                $(".modal_student_edit_action").hide();
            });

            $("#confirmed_delete").on("click", function (e) {
                console.log("Confirmed Delete");
            });

            $("#cancelled_delete").on("click", function (e) {
                console.log("Cancelling Delete");
                $(".modal_delete_action").hide();
                $('.action_select :nth-child(1)').prop('selected', true);
            });

            $("#cancelled_admin_dashboard_upload").on("click", function (e) {
                console.log("Cancelling upload");
                $("#upload_to_dashboard_action").hide();
            });

            $("#cancelled_admin_marking_upload").on("click", function (e) {
                console.log("Cancelling upload");
                $("#modal_upload_for_marking_action").hide();
            });

            $("#close_upload_for_dashboard_dialog").on("click", function (e) {
                console.log("Cancelling upload");
                $("#upload_to_dashboard_action").hide();
            });

            $("#close_upload_for_marking_dialog").on("click", function (e) {
                console.log("Cancelling upload");
                $("#modal_upload_for_marking_action").hide();
            });

            $("#cancelled_archive").on("click", function (e) {
                console.log("Cancelling archive");
                $(".modal_archive_action").hide();
                $('.action_select :nth-child(1)').prop('selected', true);
            });
            $("#cancelled_suspend").on("click", function (e) {
                console.log("Cancelling suspend");
                $(".modal_suspend_action").hide();
                $('.action_select :nth-child(1)').prop('selected', true);
            });

            $("#cancelled_unsuspend").on("click", function (e) {
                console.log("Cancelling unsuspend");
                $(".modal_unsuspend_action").hide();
                $('.action_select :nth-child(1)').prop('selected', true);
            });
            $("#cancelled_priority").on("click", function (e) {
                console.log("Cancelling priority");
                $(".modal_priority_action").hide();
                $('.action_select :nth-child(1)').prop('selected', true);
            });

            $("#close_dialog").on("click", function (e) {
                e.preventDefault();
                console.log("Cancelling Delete");
                $(".modal_delete_action").hide();
                $('.action_select :nth-child(1)').prop('selected', true);
            });

            $("#close_priority_dialog").on("click", function (e) {
                e.preventDefault();
                console.log("Cancelling priority");
                $(".modal_priority_action").hide();
                $('.action_select :nth-child(1)').prop('selected', true);
            });

            $("#close_archive_dialog").on("click", function (e) {
                e.preventDefault();
                console.log("Cancelling archive");
                $(".modal_archive_action").hide();
                $('.action_select :nth-child(1)').prop('selected', true);
            });

            $("#close_suspend_dialog").on("click", function (e) {
                e.preventDefault();
                console.log("Cancelling suspend");
                $(".modal_suspend_action").hide();
                $('.action_select :nth-child(1)').prop('selected', true);
            });

            $("#close_unsuspend_dialog").on("click", function (e) {
                e.preventDefault();
                console.log("Cancelling unsuspend");
                $(".modal_unsuspend_action").hide();
                $('.action_select :nth-child(1)').prop('selected', true);
            });

            //get mark action
            $(".mark_action").on("change", function (e) {
                var str = this.id;
                var chosen_value = $('#' + str).val()
                var exploded = str.split(/[\s_]+/);
                console.log("mark ID:" + str);
                console.log("Student:" + exploded[2]);
                console.log("course:" + exploded[3]);
                console.log("course type:" + exploded[4]);
                console.log("chosen option:" + chosen_value);

                //process delete request
                if (chosen_value === 'upload_for_marking') {

                    if(exploded[4] === 'standard'){
                        $('#assignment_dashboard_student_id').val(exploded[2]);
                        $('#assignment_dashboard_course_id').val(exploded[3]);
                        $('#assignment_dashboard_course_type').val(exploded[4]);

                        e.preventDefault();
                        $.ajaxSetup({
                            headers: {
                                'X-XSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        $.ajax({
                            url: '{{ url('/get-course-upload-for-dashboard-by-id-ajax') }}',
                            type: 'get',
                            data: 'student_id=' + exploded[2] + '&course_id=' + exploded[3] + '&course_type=' + exploded[4],
                            processData: false,
                            contentType: false,
                            success: function (response) {
                                console.log('response :');
                                console.log(response);
                                console.log('response title:');
                                console.log(response['course_title']);
                                console.log('response type:');
                                console.log(response['course_type']);
                                console.log('assignments:');
                                console.log(response['total_assignments']);

                                var html = '<option>Choose Assignment</option>';
                                var i;
                                for (i = 1; i <= response['total_assignments']; i++) {
                                    html += '<option value="'+i+'">'+i+'</option>';
                                }
                                $('#dashboard_assignment_number').html(html);
                                $("#dashboard_course_name").html('Course: <span class="text-muted">'+response['course_title']+"</span>");
                                $("#dashboard_student_name").html('Student: <span class="text-muted">'+response['student_name']+"</span>");

                                if (response['is_active'] === 1) {
                                    console.log('RADIO 1 is ' + response['is_active']);
                                    $("#active_state").attr('checked', 'checked');
                                }
                                if (response['is_active'] === 0) {
                                    console.log('RADIO 0 is ' + response['is_active']);
                                    $("#in_active_state").attr('checked', 'checked');
                                }
                            },
                            error: function (data) {
                                console.log(data);
                                console.log('scroll error' + error_scroll);
                                $('#' + error_scroll).focus();
                            }
                        });

                        $("#upload_to_dashboard_action").css('display', 'block');
                        $("#upload_to_dashboard_action").css({top: '0%'});
                    }

                    if(exploded[4] === 'work'){
                        e.preventDefault();
                        $.ajaxSetup({
                            headers: {
                                'X-XSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        $.ajax({
                            url: '{{ url('/get-course-upload-for-marking-by-id-ajax') }}',
                            type: 'get',
                            data: 'student_id=' + exploded[2] + '&course_id=' + exploded[3] + '&course_type=' + exploded[4],
                            processData: false,
                            contentType: false,
                            success: function (response) {
                                console.log('response :');
                                console.log(response);
                                console.log('response title:');
                                console.log(response['title']);
                                console.log('assignments:');
                                console.log(response['total_assignments']);
                                //set values to edit tutor dialog fields
                                $("#edit_title").val(response['title']);
                                $("#edit_subject").val(response['subject']);
                                $("#edit_description").val(response['description']);
                                //$("#edit_is_active").val(response['is_active']);
                                if (response['is_active'] === 1) {
                                    console.log('RADIO 1 is ' + response['is_active']);
                                    $("#active_state").attr('checked', 'checked');
                                }
                                if (response['is_active'] === 0) {
                                    console.log('RADIO 0 is ' + response['is_active']);
                                    $("#in_active_state").attr('checked', 'checked');
                                }
                            },
                            error: function (data) {
                                console.log(data);
                                console.log('scroll error' + error_scroll);
                                $('#' + error_scroll).focus();
                            }
                        });

                        $("#modal_upload_for_marking_action").css('display', 'block');
                        $("#modal_upload_for_marking_action").css({top: '0%'});
                    }
                }
                //archive
                if (chosen_value === 'upload_to_dashboard') {
                    $('#assignment_dashboard_student_id').val(exploded[2]);
                    $('#assignment_dashboard_course_id').val(exploded[3]);
                    $('#assignment_dashboard_course_type').val(exploded[4]);

                    e.preventDefault();
                    $.ajaxSetup({
                        headers: {
                            'X-XSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        url: '{{ url('/get-course-upload-for-dashboard-by-id-ajax') }}',
                        type: 'get',
                        data: 'student_id=' + exploded[2] + '&course_id=' + exploded[3] + '&course_type=' + exploded[4],
                        processData: false,
                        contentType: false,
                        success: function (response) {
                            console.log('response :');
                            console.log(response);
                            console.log('response title:');
                            console.log(response['course_title']);
                            console.log('response type:');
                            console.log(response['course_type']);
                            console.log('assignments:');
                            console.log(response['total_assignments']);

                            var html = '<option>Choose Assignment</option>';
                            var i;
                            for (i = 1; i <= response['total_assignments']; i++) {
                                html += '<option value="'+i+'">'+i+'</option>';
                            }
                            $('#dashboard_assignment_number').html(html);
                            $("#dashboard_course_name").html('Course: <span class="text-muted">'+response['course_title']+"</span>");
                            $("#dashboard_student_name").html('Student: <span class="text-muted">'+response['student_name']+"</span>");

                            if (response['is_active'] === 1) {
                                console.log('RADIO 1 is ' + response['is_active']);
                                $("#active_state").attr('checked', 'checked');
                            }
                            if (response['is_active'] === 0) {
                                console.log('RADIO 0 is ' + response['is_active']);
                                $("#in_active_state").attr('checked', 'checked');
                            }
                        },
                        error: function (data) {
                            console.log(data);
                            console.log('scroll error' + error_scroll);
                            $('#' + error_scroll).focus();
                        }
                    });

                    $("#upload_to_dashboard_action").css('display', 'block');
                    $("#upload_to_dashboard_action").css({top: '0%'});
                }
                //
                if ($('#' + str).val() === 'mark_as_completed') {
                    $("#modal_mark_as_completed_action").css('display', 'block');
                    $("#modal_mark_as_completed_action").css({top: '0%'});
                }
            });

            //add course form submission code
            $("#upload_assignment_to_dashboard_btn").click(function (e) {
                var error_scroll = '';
                //add rules
                //min length
                if ($('#dashboard_assignment_number').val().length <= 0) {
                    $('#dashboard_assignment_number_errors').text('Please select assignment number');
                    return false;
                } else {
                    $('#dashboard_assignment_number_errors').text('');
                }

                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-XSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var formdata = new FormData($("#add_upload_for_dashboard_form")[0]);
                console.log("formdata");
                console.log(formdata);

                $.ajax({
                    url: '{{ url('/students/list/1') }}',
                    type: 'POST',
                    data: formdata,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        console.log('response');
                        console.log(response);
                        $('#success-alert').html('<h3>Assignment Uploaded to Student\'s Dashboard</h3>');
                        $("#upload_assignment_to_dashboard_btn").attr('disabled',true);
                        $('#success-alert').focus();
                        $("#success-alert").fadeTo(2000, 500).slideUp(500, function () {
                            $("#success-alert").css("height", "0px");
                            $("#success-alert").css("display", "block");
                            var page = '<?php echo url("/")?>'+'/students/list/{{$page_var}}';
                            window.location.href = page // refresh page
                        });
                    },
                    error: function (data) {
                        console.log(data);
                        console.log('scroll error'+error_scroll);
                        $('#'+error_scroll).focus();
                    }
                });
            });

            //get anchor id => delete_action_{1} and concatenate it to create modal id
            $(".action_select").on("change", function () {
                //console.log("Processing Del Request:"+this.id);
                var str = this.id;
                //process delete request
                if ($('#' + str).val() === 'delete') {
                    $("#modal_delete_action").css('display', 'block');
                    $("#modal_delete_action").css({top: '0%'});
                    var ids = str.split(/[\s_]+/);
                    console.log("SPLITTED:" + ids[2]);
                    $("#id").val(ids[2]);
                }
                //archive
                if ($('#' + str).val() === 'archive') {
                    $("#modal_archive_action").css('display', 'block');
                    $("#modal_archive_action").css({top: '0%'});
                    var ids = str.split(/[\s_]+/);
                    console.log("SPLITTED:" + ids[2]);
                    $("#archived_student_id").val(ids[2]);
                }
                //suspend
                if ($('#' + str).val() === 'suspend') {
                    $("#modal_suspend_action").css('display', 'block');
                    $("#modal_suspend_action").css({top: '0%'});
                    var ids = str.split(/[\s_]+/);
                    console.log("SPLITTED:" + ids[2]);
                    $("#suspended_student_id").val(ids[2]);
                }
                //suspend
                if ($('#' + str).val() === 'unsuspend') {
                    $("#modal_unsuspend_action").css('display', 'block');
                    $("#modal_unsuspend_action").css({top: '0%'});
                    var ids = str.split(/[\s_]+/);
                    console.log("SPLITTED:" + ids[2]);
                    $("#unsuspended_student_id").val(ids[2]);
                }
                //priority
                if ($('#' + str).val() === 'priority') {
                    $("#modal_priority_action").css('display', 'block');
                    $("#modal_priority_action").css({top: '0%'});
                    var ids = str.split(/[\s_]+/);
                    console.log("SPLITTED:" + ids[2]);
                    $("#priority_student_id").val(ids[2]);
                }
            });


            //add resource
            $("#confirm_student_profile_edit").click(function (e) {
                var error_scroll = '';
                if ($('#student_number').val().length <= 0) {
                    $('#student_number_errors').text('Required');
                    error_scroll = 'student_number';
                    $('html, body').animate({
                        scrollTop: ($('#student_number').offset().top - 166)
                    },500);
                    $('#student_number').focus();
                    return false;
                } else {
                    $('#student_number_errors').text('');
                }

                if ($('#first_name').val().length <= 0) {
                    $('#first_name_errors').text('Required');
                    error_scroll = 'first_name';
                    $('html, body').animate({
                        scrollTop: ($('#first_name').offset().top - 166)
                    },500);
                    $('#first_name').focus();
                    return false;
                } else {
                    $('#first_name_errors').text('');
                }

                if ($('#last_name').val().length <= 0) {
                    $('#last_name_errors').text('Required');
                    error_scroll = 'last_name';
                    $('html, body').animate({
                        scrollTop: ($('#last_name').offset().top - 166)
                    },500);
                    $('#last_name').focus();
                    return false;
                } else {
                    $('#last_name_errors').text('');
                }
                if ($('#email').val().length <= 0) {
                    $('#email_errors').text('Required');
                    error_scroll = 'email';
                    $('html, body').animate({
                        scrollTop: ($('#email').offset().top - 166)
                    },500);
                    $('#email').focus();
                    return false;
                } else {
                    $('#email_errors').text('');
                }
                if ($('#phone').val().length <= 0) {
                    $('#phone_errors').text('Required');
                    error_scroll = 'phone';
                    $('html, body').animate({
                        scrollTop: ($('#phone').offset().top - 166)
                    },500);
                    $('#phone').focus();
                    return false;
                } else {
                    $('#phone_errors').text('');
                }
                if ($('#mobile').val().length <= 0) {
                    $('#mobile_errors').text('Required');
                    error_scroll = 'mobile';
                    $('html, body').animate({
                        scrollTop: ($('#mobile').offset().top - 166)
                    },500);
                    $('#mobile').focus();
                    return false;
                } else {
                    $('#mobile_errors').text('');
                }

                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-XSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                var formdata = new FormData($("#edit_student_profile_form")[0]);
                console.log("formdata");
                console.log(formdata);

                $.ajax({
                    url: '{{ url('/students/list/').'/'.$page_var }}',
                    type: 'POST',
                    data: formdata,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        $('#success-alert').html('<h3>Student Updated Successfully</h3>');
                        $("#new_resource_btn").attr('disabled',true);
                        $('#success-alert').focus();
                        $("#success-alert").fadeTo(2000, 500).slideUp(500, function () {
                            $("#success-alert").css("height", "0px");
                            $("#success-alert").css("display", "block");
                            var page = '<?php echo url("/")?>'+'/students/list/<?php echo $page_var;?>';
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
