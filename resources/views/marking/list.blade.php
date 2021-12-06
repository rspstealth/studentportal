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
                            <h3 style="line-height: 36px;">Marking
                                <a style="float:right;" href="#" id="sam_assignment" onclick="SAMAssignmentMarking()" title="SAM Assignment" class="btn btn-primary ">SAM Assignment</a>
                                <a style="float:right;margin-right:10px" href="#" id="new_canned_response" title="New Canned Response" class="btn btn-primary">New Canned Response</a>
                                <a style="float:right;margin-right:10px" href="#" id="sam_evidence" onclick="SAMEvidenceMarking()" title="SAM Evidence" class="btn btn-primary ">SAM Evidence</a>
                            </h3>
                            <hr/>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <div class="btn-group" style="height: 50px;" role="group" aria-label="Basic example">
                                    <button id="priority_students" type="button" class="btn btn-outline-secondary btn-group-item {{(Request::query('q') === 'priority_students'  ? 'active' : '') }}">Priority Students ({{$total_priority_students}})</button>
                                    <button id="current_marking" type="button" class="btn btn-outline-secondary btn-group-item {{(Request::query('q') === 'current_marking'  ? 'active' : '') }}">Current Marking ({{$total_current_marking}})</button>
                                    <button id="current_unit_marking" type="button" class="btn btn-outline-secondary btn-group-item {{(Request::query('q') === 'current_unit_marking'  ? 'active' : '') }}">Current Unit Marking ({{$total_current_unit_marking}})</button>
                                    <button id="overdue_unit_marking" type="button" class="btn btn-outline-secondary btn-group-item {{(Request::query('q') === 'overdue_unit_marking'  ? 'active' : '') }}">Overdue Unit Marking ({{$total_overdue_unit_marking}})</button>
                                    <button id="pending_resource_approval" type="button" class="btn btn-outline-secondary btn-group-item {{ (Request::query('q') === 'pending_resource_approval' ? 'active' : '') }}">Pending Resource Approval ({{$total_pending_resource_approval}})</button>
                                </div>
                                <hr style="margin-top:10px;"/>
                            </div>
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
                        <div class="app_notifications label label-success" id="success-alert">
                            <h3 id="message"></h3>
                        </div>
                        <div class="table-responsive">
                            <?php
                            if(Request::input('q') == 'pending_resource_approval'){
                                ?>
                                <table class="table">
                                    <tr>
                                        <th class="course_col" scope="col">Resource Type</th>
                                        <th class="description_col" scope="col">Description</th>
                                        <th style="text-align:center" class="rollno_col" scope="col">File</th>
                                        <th style="text-align:center" class="rollno_col" scope="col">Action</th>
                                    </tr>
                                    <tbody>
                                    <?php
                                    foreach($pending_resources as $resource){
                                    ?>
                                    <tr class="record_row record_{{$resource->id}}">
                                        <td>{{ ($resource->course_specific === 'all')? 'Generic Resource' : App\Http\Controllers\CourseController::getCourseNameById($resource->course_specific)  }}</td>
                                        <td>{{ $resource->description }}</td>
                                        <td style="text-align:center"><a href="{{ url('/public').'/resources/'.$resource->resource_file }}" title="Download Resource"><i class="fas fa-download"></i> Download</a></td>
                                        <td style="text-align:center"><a id="approve_action_{{ $resource->id }}" href="#" class="action_buttons approve_action tiny-action-btn btn-outline-secondary " title=""><i class="fas fa-check"></i> Approve</a></td>
                                    </tr>
                                    <?php
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            <?php
                            }
                            if(Request::input('q') != 'pending_resource_approval' AND  Request::input('q') != 'current_unit_marking' AND  Request::input('q') != 'overdue_unit_marking'){
                            ?>
                            <table class="table">
                                <tr>
                                    <th class="course_col" scope="col">Course</th>
                                    <th style="text-align:center" class="course_col" scope="col">Student</th>
                                    <th style="text-align:center" class="rollno_col" scope="col">Download</th>
                                    <th style="text-align:center" class="evidence_date_col" scope="col">Date</th>
                                    <th style="text-align:center" class="evidence_action_col" scope="col">Action</th>
                                </tr>
                                <tbody>
                                <?php
                                foreach($markings as $marking){
                                ?>
                                <tr class="record_row record_{{$marking->id}}">
                                    <td>{{\App\Http\Controllers\CourseController::getCourseNameById($marking->course_id)}}</td>
                                    <td style="text-align:center"><?php echo App\Http\Controllers\UserController::getStudentNameById($marking->student_id);?></td>
                                    <td style="text-align:center"><a href="{{url('/public').$marking->assignment_file}}" title="Download File"><i class="far fa-file-alt"></i></a></td>
                                    <td style="text-align:center">{{date('d-m-Y', strtotime($marking->created_at))}}</td>
                                    <td style="text-align:center">
                                    <?php
                                        $course_type = App\Http\Controllers\CourseController::getCourseTypeById($marking->course_id);
                                        if($course_type==='work_based'){
                                            ?>
                                            <a href="#" id="student_course_{{$marking->student_id}}" onclick="{{(($course_type==='standard')? 'courseMarking': 'workBasedCourseMarking')}}({{$marking->student_id}},{{$marking->course_id}})" class="student_course_feedback_btn tiny-action-btn btn-outline-secondary " title="Course Feedback"><i class="fas fa-user-check"></i> Feedback</a>
                                            <?php
                                        }
                                        ?><?php
                                        if($course_type==='standard'){
                                            ?>
                                        <a href="#" id="student_{{$marking->student_id}}" class="student_marking_btn tiny-action-btn btn-outline-secondary " title="Start Marking Student Assignments"><i class="fas fa-highlighter"></i> Mark</a></td>
                                        <?php
                                        }
                                        ?>
                                </tr>
                                <?php
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
                                    <a class="action_buttons" href="{{url('/marking/')}}/list/{{$page_var-1}}?_token={{ csrf_token() }}" title="Previous"><i class="fas fa-chevron-left"> </i> Previous</a>
                                    <?php
                                    }
                                    ?>
                                    <?php
                                    //eg: total 5 > current 5
                                    if($page_var  < $totalPages){
                                    ?>
                                    <a class="action_buttons" href="{{url('/marking/')}}/list/{{$page_var+1}}?_token={{ csrf_token() }}" title="Next">Next <i class="fas fa-chevron-right"></i></a>
                                    <?php
                                    }
                                    }
                                ?>
                                    </div>
                                <?php
                                }


                                if(Request::input('q') == 'current_unit_marking'){
                                ?>
                                <table class="table">
                                    <tr>
                                        <th class="course_col" scope="col">Course</th>
                                        <th style="text-align:center" class="course_col" scope="col">Student</th>
                                        <th style="text-align:center" class="evidence_date_col" scope="col">Date</th>
                                        <th style="text-align:center" class="evidence_action_col" scope="col">Action</th>
                                    </tr>
                                    <tbody>
                                    <?php
                                    foreach($markings as $marking){
                                    ?>
                                    <tr class="record_row record_{{$marking->id}}">
                                        <td>{{\App\Http\Controllers\CourseController::getCourseNameById($marking->course_id)}}</td>
                                        <td style="text-align:center">{{\App\Http\Controllers\UserController::getStudentNameById($marking->student_id)}}</td>
                                        <td style="text-align:center">{{date('d-m-Y', strtotime($marking->created_at))}}</td>
                                        <td style="text-align:center">
                                            <a href="#" id="student_course_{{$marking->student_id}}" onclick="{{(($course_type==='standard')? 'courseMarking': 'workBasedCourseMarking')}}({{$marking->student_id}},{{$marking->course_id}})" class="student_course_feedback_btn tiny-action-btn btn-outline-secondary " title="Course Feedback"><i class="fas fa-user-check"></i> Feedback</a>
                                            <?php
                                            if($course_type==='standard'){
                                            ?>
                                            <a href="#" id="student_{{$marking->student_id}}" class="student_marking_btn tiny-action-btn btn-outline-secondary " title="Start Marking Student Assignments"><i class="fas fa-highlighter"></i> Mark</a></td>
                                        <?php
                                        }
                                        ?>
                                    </tr>
                                    <?php
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
                                    <a class="action_buttons" href="{{url('/marking/')}}/list/{{$page_var-1}}?_token={{ csrf_token() }}" title="Previous"><i class="fas fa-chevron-left"> </i> Previous</a>
                                    <?php
                                    }
                                    ?>
                                    <?php
                                    //eg: total 5 > current 5
                                    if($page_var  < $totalPages){
                                    ?>
                                    <a class="action_buttons" href="{{url('/marking/')}}/list/{{$page_var+1}}?_token={{ csrf_token() }}" title="Next">Next <i class="fas fa-chevron-right"></i></a>
                                    <?php
                                    }
                                    }
                                    ?>
                                </div>
                            <?php
                                }

                                if(Request::input('q') == 'overdue_unit_marking'){
                                ?>
                                <table class="table">
                                    <tr>
                                        <th class="course_col" scope="col">Course</th>
                                        <th style="text-align:center" class="course_col" scope="col">Student</th>
                                        <th style="text-align:center" class="evidence_date_col" scope="col">Date</th>
                                        <th style="text-align:center" class="evidence_action_col" scope="col">Action</th>
                                    </tr>
                                    <tbody>
                                    <?php
                                    foreach($markings as $marking){
                                    ?>
                                    <tr class="record_row record_{{$marking->id}}">
                                        <td>{{\App\Http\Controllers\CourseController::getCourseNameById($marking->course_id)}}</td>
                                        <td style="text-align:center">{{\App\Http\Controllers\UserController::getStudentNameById($marking->student_id)}}</td>
                                        <td style="text-align:center">{{date('d-m-Y', strtotime($marking->created_at))}}</td>
                                        <td style="text-align:center">
                                            <a href="#" id="student_course_{{$marking->student_id}}" onclick="{{(($course_type==='standard')? 'courseMarking': 'workBasedCourseMarking')}}({{$marking->student_id}},{{$marking->course_id}})" class="student_course_feedback_btn tiny-action-btn btn-outline-secondary " title="Course Feedback"><i class="fas fa-user-check"></i> Feedback</a>
                                            <?php
                                            if($course_type==='standard'){
                                            ?>
                                            <a href="#" id="student_{{$marking->student_id}}" class="student_marking_btn tiny-action-btn btn-outline-secondary " title="Start Marking Student Assignments"><i class="fas fa-highlighter"></i> Mark</a></td>
                                        <?php
                                        }
                                        ?>
                                    </tr>
                                    <?php
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
                                    <a class="action_buttons" href="{{url('/marking/')}}/list/{{$page_var-1}}?_token={{ csrf_token() }}" title="Previous"><i class="fas fa-chevron-left"> </i> Previous</a>
                                    <?php
                                    }
                                    ?>
                                    <?php
                                    //eg: total 5 > current 5
                                    if($page_var  < $totalPages){
                                    ?>
                                    <a class="action_buttons" href="{{url('/marking/')}}/list/{{$page_var+1}}?_token={{ csrf_token() }}" title="Next">Next <i class="fas fa-chevron-right"></i></a>
                                    <?php
                                    }
                                    }
                                    ?>
                                </div>
                            <?php
                                }
                                ?>

                        </div>
                    </div>

                    {{--approve Confirmation Modal--}}
                    <div id="modal_approve_action" class="modal modal_approve_action" tabindex="-1" role="dialog">
                        <div class="approve-modal-dialog modal_approve_dialog" role="document">
                            <div class="modal-content align-items-center">
                                <div class="modal-body">
                                    <h3>Confirm Resource Approval? <a href="#" title="close dialog" id="close_approve_dialog" style="float: right;margin: 0 10px;"><i class="fa fa-close"></i></a></h3>
                                    <p>This publishes the resource for other students</p>
                                </div>
                                <div class="modal-footer">
                                    <form id="del_selected_form" action="{{url('marking/list/'.$page_var.'?q=pending_resource_approval')}}" method="POST">
                                        {{ csrf_field() }}
                                        <input type="hidden" id="total" name="total" value="{{$total}}" />
                                        <input type="hidden" id="totalPages" name="totalPages" value="{{$totalPages}}" />
                                        <input type="hidden" id="page_var" name="page_var" value="{{$page_var}}" />
                                        <input type="hidden" id="method" name="method" value="approve_resource" />
                                        <input type="hidden" id="approve_id" name="approve_id" value="" />
                                        <input class="btn btn-primary " type="submit" id="confirmed_approve" name="confirmed_approve" value="approve" />
                                        <button type="button" id="cancelled_approve" class="btn btn-outline-secondary ">Cancel</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{--Admin modal--}}
                    <div id="modal_marking_action" class="modal modal_marking_action" tabindex="-1" role="dialog">
                        <div class="marking-modal-dialog modal_marking_dialog" role="document">
                            <div class="modal-content align-items-center" style="padding: 0 20px;">
                                <div class="modal-body">
                                    <h3>Give Feedback for <span id="student_name"></span><a href="#" title="close dialog" id="close_marking_dialog" style="float: right;margin: 0 10px;"><i class="fa fa-close"></i></a></h3>
                                </div>
                                <div class="modal-footer">
                                    <form id="add_marking_form" action="{{url('/marking/list/')}}/{{$page_var}}" method="POST">
                                        {{ csrf_field() }}
                                        <div id="marking_content" class="col-md-12 no-padding">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{--Admin modal--}}
                    <div id="modal_single_marking_action" class="modal modal_single_marking_action" tabindex="-1" role="dialog">
                        <div class="single-marking-modal-dialog modal_single_marking_dialog" role="document">
                            <div class="modal-content align-items-center" style="padding: 0 20px;">
                                <div class="modal-body">
                                    <h3 style="padding: 0px;">Feedback<a href="#" title="close dialog" id="close_single_marking_dialog" style="float: right;margin: 0 10px;"><i class="fa fa-close"></i></a></h3>
                                </div>
                                <div class="modal-footer">
                                    <form id="add_single_marking_form" action="{{url('/single_marking/list/')}}/{{$page_var}}" method="POST">
                                        {{ csrf_field() }}
                                        <div id="single_marking_content">

                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{--Admin modal--}}
                    <div id="modal_sam_assignment_marking_action" class="modal modal_sam_assignment_marking_action" tabindex="-1" role="dialog">
                        <div class="sam-assignment-marking-modal-dialog modal_sam_assignment_marking_dialog" role="document">
                            <div class="modal-content align-items-center" style="padding: 0 20px;">
                                <div class="modal-body">
                                    <h3 style="padding: 0px;">Feedback<a href="#" title="close dialog" id="close_sam_assignment_marking_dialog" style="float: right;margin: 0 10px;"><i class="fa fa-close"></i></a></h3>
                                </div>
                                <div class="modal-footer">
                                    <form id="add_sam_assignment_marking_form" action="{{url('/sam_assignment_marking/list/')}}/{{$page_var}}" method="POST">
                                        {{ csrf_field() }}
                                        <div id="sam_assignment_marking_content">

                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{--Admin modal--}}
                    <div id="modal_sam_evidence_marking_action" class="modal modal_sam_evidence_marking_action" tabindex="-1" role="dialog">
                        <div class="sam-evidence-marking-modal-dialog modal_sam_evidence_marking_dialog" role="document">
                            <div class="modal-content align-items-center" style="padding: 0 20px;">
                                <div class="modal-body">
                                    <h3 style="padding: 0px;">Feedback<a href="#" title="close dialog" id="close_sam_evidence_marking_dialog" style="float: right;margin: 0 10px;"><i class="fa fa-close"></i></a></h3>
                                </div>
                                <div class="modal-footer">
                                    <form id="add_sam_evidence_marking_form" action="{{url('/sam_evidence_marking/list/')}}/{{$page_var}}" method="POST">
                                        {{ csrf_field() }}
                                        <div id="sam_evidence_marking_content">

                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="modal_course_marking_action" class="modal modal_course_marking_action" tabindex="-1" role="dialog">
                        <div class="course-marking-modal-dialog modal_course_marking_dialog" role="document">
                            <div class="modal-content align-items-center" style="padding: 0 20px;">
                                <div class="modal-body">
                                    <h3 style="padding: 0px;">Course Feedback<a href="#" title="close dialog" id="close_course_marking_dialog" style="float: right;margin: 0 10px;"><i class="fa fa-close"></i></a></h3>
                                </div>
                                <div class="modal-footer">
                                    <form id="add_course_marking_form" action="{{url('/mark-course-progress-ajax')}}/" method="GET">
                                        {{ csrf_field() }}

                                        <div id="course_marking_content">

                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div id="modal_work_based_marking_action" class="modal modal_work_based_marking_action" tabindex="-1" role="dialog">
                        <div class="work-based-marking-modal-dialog modal_work_based_marking_dialog" role="document">
                            <div class="modal-content align-items-center" style="padding: 0 20px;">
                                <div class="modal-body">
                                    <h3 style="padding: 0px;">Course Feedback<a href="#" title="close dialog" id="close_work_based_marking_dialog" style="float: right;margin: 0 10px;"><i class="fa fa-close"></i></a></h3>
                                </div>
                                <div class="modal-footer">
                                    <form id="add_work_based_marking_form" action="{{url('/mark-unit-course-progress-ajax')}}/" method="GET">
                                        {{ csrf_field() }}

                                        <div id="work_based_marking_content">

                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{--Admin modal--}}
                    <div id="modal_notes_action" class="modal modal_notes_action" tabindex="-1" role="dialog">
                        <div class="notes-modal-dialog modal_notes_dialog" role="document">
                            <div class="modal-content align-items-center" style="padding: 0 20px;">
                                <div class="modal-body">
                                    <h3 style="padding: 0px;">Notes<a href="#" title="close dialog" id="close_notes_dialog" style="float: right;margin: 0 10px;"><i class="fa fa-close"></i></a></h3>
                                </div>
                                <div class="modal-footer">
                                    <form id="add_notes_form" action="{{url('/marking/list/')}}/{{$page_var}}/?q={{Request::input("q")}}" method="POST">
                                        {{ csrf_field() }}
                                        <div class="col-md-12 no-padding text-left">
                                            <div class="col-md-12 no-padding">
                                                <div class="form-group">
                                                    <textarea style="min-height: 60px;" id="note" name="note" class="form-control lb-lg"></textarea>
                                                    <small class="text-danger error_msg" id="note_errors"></small>
                                                </div>
                                            </div>
                                            <div class="col-md-12 no-padding text-left">
                                                <input type="hidden" id="note_student_id" name="note_student_id" value="" />
                                                <input type="hidden" id="note_tutor_id" name="note_tutor_id" value="" />
                                                <input type="hidden" id="note_course_id" name="note_course_id" value="" />
                                                <input type="hidden" id="note_assignment_id" name="note_assignment_id" value="" />
                                                <input type="hidden" id="method" name="method" value="add_note" />
                                                <input class="btn btn-primary" style="margin: 15px 0;" type="submit" id="add_note_btn" name="add_note_btn" value="Add Note" />
                                                <hr/>
                                            </div>
                                        </div>

                                        <div id="notes_content">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{--markers modal--}}
                    <div id="modal_markers_action" class="modal modal_markers_action" tabindex="-1" role="dialog">
                        <div class="markers-modal-dialog modal_markers_dialog" role="document">
                            <div class="modal-content align-items-center" style="padding: 0 20px;">
                                <div class="modal-body">
                                    <h3 style="padding: 0px;">Markers<a href="#" title="close dialog" id="close_markers_dialog" style="float: right;margin: 0 10px;"><i class="fa fa-close"></i></a></h3>
                                </div>
                                <div class="modal-footer">
                                    <form id="add_markers_form" action="{{url('/marking/list/')}}/{{$page_var}}/?q={{Request::input("q")}}" method="POST">
                                        {{ csrf_field() }}
                                        <div class="col-md-12 no-padding text-left">
                                            <div class="col-md-12 no-padding">
                                                <div class="form-group">
                                                    <textarea style="min-height: 60px;" id="marker" name="marker" class="form-control lb-lg"></textarea>
                                                    <small class="text-danger error_msg" id="marker_errors"></small>
                                                </div>
                                            </div>
                                            <div class="col-md-12 no-padding text-left">
                                                <input type="hidden" id="marker_student_id" name="marker_student_id" value="" />
                                                <input type="hidden" id="marker_tutor_id" name="marker_tutor_id" value="" />
                                                <input type="hidden" id="marker_course_id" name="marker_course_id" value="" />
                                                <input type="hidden" id="marker_assignment_id" name="marker_assignment_id" value="" />
                                                <input type="hidden" id="method" name="method" value="add_marker" />
                                                <input class="btn btn-primary" style="margin: 15px 0;" type="submit" id="add_marker_btn" name="add_marker_btn" value="Add marker" />
                                                <hr/>
                                            </div>
                                        </div>

                                        <div id="markers_content">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>


                    {{--Admin modal--}}
                    <div id="modal_course_notes_action" class="modal modal_course_notes_action" tabindex="-1" role="dialog">
                        <div class="course-notes-modal-dialog modal_course_notes_dialog" role="document">
                            <div class="modal-content align-items-center" style="padding: 0 20px;">
                                <div class="modal-body">
                                    <h3 style="padding: 0px;">Notes<a href="#" title="close dialog" id="close_course_notes_dialog" style="float: right;margin: 0 10px;"><i class="fa fa-close"></i></a></h3>
                                </div>
                                <div class="modal-footer">
                                    <form id="add_course_notes_form" action="{{url('/marking/list/')}}/{{$page_var}}/?q={{Request::input("q")}}" method="POST">
                                        {{ csrf_field() }}
                                        <div class="col-md-12 no-padding text-left">
                                            <div class="col-md-12 no-padding">
                                                <div class="form-group">
                                                    <textarea style="min-height: 60px;" id="course_note" name="course_note" class="form-control lb-lg"></textarea>
                                                    <small class="text-danger error_msg" id="course_note_errors"></small>
                                                </div>
                                            </div>
                                            <div class="col-md-12 no-padding text-left">
                                                <input type="hidden" id="course_note_student_id" name="course_note_student_id" value="" />
                                                <input type="hidden" id="course_note_tutor_id" name="course_note_tutor_id" value="" />
                                                <input type="hidden" id="course_note_course_id" name="course_note_course_id" value="" />
                                                <input type="hidden" id="method" name="method" value="add_course_note" />
                                                <input class="btn btn-primary" style="margin: 15px 0;" type="submit" id="add_course_note_btn" name="add_course_note_btn" value="Add Note" />
                                                <hr/>
                                            </div>
                                        </div>

                                        <div id="course_notes_content">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{--course_markers modal--}}
                    <div id="modal_course_markers_action" class="modal modal_course_markers_action" tabindex="-1" role="dialog">
                        <div class="course-markers-modal-dialog modal_course_markers_dialog" role="document">
                            <div class="modal-content align-items-center" style="padding: 0 20px;">
                                <div class="modal-body">
                                    <h3 style="padding: 0px;">Markers<a href="#" title="close dialog" id="close_course_markers_dialog" style="float: right;margin: 0 10px;"><i class="fa fa-close"></i></a></h3>
                                </div>
                                <div class="modal-footer">
                                    <form id="add_course_markers_form" action="{{url('/marking/list/')}}/{{$page_var}}/?q={{Request::input("q")}}" method="POST">
                                        {{ csrf_field() }}
                                        <div class="col-md-12 no-padding text-left">
                                            <div class="col-md-12 no-padding">
                                                <div class="form-group">
                                                    <textarea style="min-height: 60px;" id="course_marker" name="course_marker" class="form-control lb-lg"></textarea>
                                                    <small class="text-danger error_msg" id="course_marker_errors"></small>
                                                </div>
                                            </div>
                                            <div class="col-md-12 no-padding text-left">
                                                <input type="hidden" id="course_marker_student_id" name="course_marker_student_id" value="" />
                                                <input type="hidden" id="course_marker_tutor_id" name="course_marker_tutor_id" value="" />
                                                <input type="hidden" id="course_marker_course_id" name="course_marker_course_id" value="" />
                                                <input type="hidden" id="course_marker_assignment_id" name="course_marker_assignment_id" value="" />
                                                <input type="hidden" id="method" name="method" value="add_course_marker" />
                                                <input class="btn btn-primary" style="margin: 15px 0;" type="submit" id="add_course_marker_btn" name="add_course_marker_btn" value="Add marker" />
                                                <hr/>
                                            </div>
                                        </div>

                                        <div id="course_markers_content">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    {{--Edit Admin modal--}}
                    <div id="modal_marking_edit_action" class="modal modal_marking_edit_action" tabindex="-1" role="dialog">
                        <div class="edit-marking-modal-dialog modal_marking_edit_dialog" role="document">
                            <div class="modal-content align-items-center" style="padding: 0 20px;">
                                <div class="modal-body">
                                    <h3>Updating Marking <a href="#" title="close dialog" id="close_marking_edit_dialog" style="float: right;margin: 0 10px;"><i class="fa fa-close"></i></a></h3>
                                </div>
                                <div class="modal-footer">
                                    <form id="edit_marking_form" action="{{url('/marking/list/')}}/{{$page_var}}" method="POST">
                                        {{ csrf_field() }}
                                        <div class="col-md-12 no-padding">
                                            <div class="col-md-12 no-padding">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        Marking Name
                                                        <input class="form-control lb-lg"  id="edit_marking_name" name="edit_marking_name" />
                                                        <small class="text-danger error_msg" id="edit_marking_name_errors"></small>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        Description
                                                        <textarea style="min-height: 60px;" id="edit_description" name="edit_description" class="form-control lb-lg"></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        Full Price
                                                        <input class="form-control lb-lg"  id="edit_full_price" name="edit_full_price" />
                                                        <small class="text-danger error_msg" id="edit_full_price_errors"></small>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        Marking Deposit
                                                        <input class="form-control lb-lg"  id="edit_marking_deposit" name="edit_marking_deposit" />
                                                        <small class="text-danger error_msg" id="edit_marking_deposit_errors"></small>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        Marking Instalment Price
                                                        <input class="form-control lb-lg"  id="edit_instalment_price" name="edit_instalment_price" />
                                                        <small class="text-danger error_msg" id="edit_instalment_price_errors"></small>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        Marking Support Price
                                                        <input class="form-control lb-lg"  id="edit_support_price" name="edit_support_price" />
                                                        <small class="text-danger error_msg" id="edit_support_price_errors"></small>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        Marking Sale Price
                                                        <input class="form-control lb-lg"  id="edit_sale_price" name="edit_sale_price" />
                                                        <small class="text-danger error_msg" id="edit_sale_price_errors"></small>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        Number of Assignments
                                                        <input class="form-control lb-lg"  id="edit_number_of_assignments" name="edit_number_of_assignments" />
                                                        <small class="text-danger error_msg" id="edit_number_of_assignments_errors"></small>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        Marking Type
                                                        <select class="form-control lb-lg"  id="edit_type" name="edit_type">
                                                            <option value="standard">Standard</option>
                                                            <option value="work_based">Work based qual/QCF</option>
                                                        </select>
                                                        <small class="text-danger error_msg" id="edit_type_errors"></small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" id="total" name="total" value="{{$total}}" />
                                        <input type="hidden" id="totalPages" name="totalPages" value="{{$totalPages}}" />
                                        <input type="hidden" id="method" name="method" value="marking_edit" />
                                        <input type="hidden" id="edit_marking_id" name="edit_marking_id" value="" />
                                        <input type="hidden" id="page_var" name="page_var" value="{{$page_var}}" />
                                        <div class="col-md-12">
                                            <hr/>
                                            <input class="btn btn-primary" type="submit" id="edit_confirmed_marking" name="edit_confirmed_marking" value="Create Marking" />
                                            <button type="button" id="edit_cancelled_marking" class="btn btn-outline-secondary ">Cancel</button>
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
                                    <h3>Confirm Marking Removal? <a href="#" title="close dialog" id="close_delete_dialog" style="float: right;margin: 0 10px;"><i class="fa fa-close"></i></a></h3>
                                    <p>This action cannot be undone.</p>
                                </div>
                                <div class="modal-footer">
                                    <form id="del_selected_form" action="{{url('/marking/list/')}}/{{$page_var}}" method="POST">
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

                    {{--Delete note Modal--}}
                    <div id="modal_delete_note_action" class="modal modal_delete_note_action" tabindex="-1" role="dialog">
                        <div class="delete-note-modal-dialog modal_delete_note_dialog" role="document">
                            <div class="modal-content align-items-center">
                                <div class="modal-body">
                                    <h3>Confirm Delete Note? <a href="#" title="close dialog" id="close_delete_note_dialog" style="float: right;margin: 0 10px;"><i class="fa fa-close"></i></a></h3>
                                    <p>This action cannot be undone.</p>
                                </div>
                                <div class="modal-footer">
                                    <form id="del_note_selected_form" action="{{url('marking/list/'.$page_var)}}/" method="POST">
                                        {{ csrf_field() }}
                                        <input type="hidden" id="post_method" name="post_method" value="delete_note" />
                                        <input type="hidden" id="note_id" name="note_id" value="" />
                                        <input class="btn btn-outline-secondary " type="button" id="confirmed_delete_note" name="confirmed_delete_note" value="Delete" />
                                        <button type="button" id="cancelled_delete_note" class="btn btn-outline-secondary ">Cancel</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{--canned_response modal--}}
                    <div id="modal_canned_response_action" class="modal modal_canned_response_action" tabindex="-1" role="dialog">
                        <div class="canned-response-modal-dialog modal_canned_response_dialog" role="document">
                            <div class="modal-content" style="padding: 0 20px;">
                                <div class="modal-body">
                                    <h3>Add Canned Response Template <a href="#" title="close dialog" id="close_canned_response_dialog" style="float: right;margin: 0 10px;"><i class="fa fa-close"></i></a></h3>
                                </div>
                                <div class="modal-footer">
                                    <form id="add_canned_response_form" action="{{url('marking/list/'.$page_var)}}" method="POST">
                                        {{ csrf_field() }}
                                        <div class="col-md-12 no-padding">
                                            <div class="col-md-12 no-padding">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        Comments
                                                        <textarea style="min-height: 100px;" id="comments" name="comments" class="form-control lb-lg"></textarea>
                                                        <small class="text-danger error_msg" id="comments_errors"></small>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        Type
                                                        <select class="form-control lb-lg"  id="type" name="type">
                                                            <option value="normal">Normal</option>
                                                            <option value="evidence">Evidence</option>
                                                        </select>
                                                        <small class="text-danger error_msg" id="type_errors"></small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" id="method" name="method" value="new_canned_response" />
                                        <input type="hidden" id="canned_response_course_id" name="canned_response_course_id" value="" />
                                        <div class="col-md-12">
                                            <hr/>
                                            <input class="btn btn-primary" type="submit" id="confirmed_canned_response" name="confirmed_canned_response" value="Create Template" />
                                            <button type="button" id="cancelled_canned_response" class="btn btn-outline-secondary ">Cancel</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{--Delete note Modal--}}
                    <div id="modal_delete_marker_action" class="modal modal_delete_marker_action" tabindex="-1" role="dialog">
                        <div class="delete-marker-modal-dialog modal_delete_marker_dialog" role="document">
                            <div class="modal-content align-items-center">
                                <div class="modal-body">
                                    <h3>Confirm Delete Marker? <a href="#" title="close dialog" id="close_delete_marker_dialog" style="float: right;margin: 0 10px;"><i class="fa fa-close"></i></a></h3>
                                    <p>This action cannot be undone.</p>
                                </div>
                                <div class="modal-footer">
                                    <form id="del_marker_selected_form" action="{{url('marking/list/'.$page_var)}}/" method="POST">
                                        {{ csrf_field() }}
                                        <input type="hidden" id="post_marker_method" name="post_marker_method" value="delete_marker" />
                                        <input type="hidden" id="marker_id" name="marker_id" value="" />
                                        <input class="btn btn-outline-secondary " type="button" id="confirmed_delete_marker" name="confirmed_delete_marker" value="Delete" />
                                        <button type="button" id="cancelled_delete_marker" class="btn btn-outline-secondary ">Cancel</button>
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
    function getAssignmentNotes(student_id,course_id,assignment_id){
        console.log('LOG s & c & a:'+student_id+' , '+course_id+' , '+assignment_id);
        $("#note_student_id").val(student_id);
        $("#note_course_id").val(course_id);
        $("#note_assignment_id").val(assignment_id);
        $("#modal_notes_action").css('display','block');
        $("#modal_notes_action").css({ top: '0%' });
        return false;
    }

    function getCourseNotes(student_id,course_id){
        console.log('LOG s & c & a:'+student_id+' , '+course_id);
        $("#note_student_id").val(student_id);
        $("#note_course_id").val(course_id);
        $("#modal_notes_action").css('display','block');
        $("#modal_notes_action").css({ top: '0%' });
        return false;
    }

    function getAssignmentMarkers(student_id,course_id,assignment_id){
        console.log('LOG s & c & a:'+student_id+' , '+course_id+' , '+assignment_id);
        $("#marker_student_id").val(student_id);
        $("#marker_course_id").val(course_id);
        $("#marker_assignment_id").val(assignment_id);
        $("#modal_markers_action").css('display','block');
        $("#modal_markers_action").css({ top: '0%' });
        return false;
    }

    function markAssignment(student_id,course_id,assignment_id){
        console.log('LOG s & c & a:'+student_id+' , '+course_id+' , '+assignment_id);
        var template_content = $('#template_content').html();
        var additional_comments = $('#additional_comments').val();
        var grade_awarded_hidden = $('#grade_awarded_hidden').val();
        var assignment_number = $('#assignment_number').val();
        var feedback_template_id = $('#feedback_template_id').val();
        var save_as_template = $('#save_as_template:checkbox:checked').val();
        console.log('LOG Checkbox:'+save_as_template);

        //process marking request
        $.ajaxSetup({
            headers: {
                'X-XSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: '{{ url('/mark-student-assignment-ajax') }}',
            type: 'get',
            data:'student_id='+student_id+'&course_id='+course_id+'&assignment_id='+assignment_id+'&method=mark_assignment&template_content='+template_content+'&additional_comments='+additional_comments+'&grade_awarded_hidden='+grade_awarded_hidden+'&save_as_template='+save_as_template+'&assignment_number='+assignment_number+'&feedback_template_id='+feedback_template_id,
            processData: false,
            contentType: false,
            success: function (response) {
                console.log('resp:');
                console.log(response);
                if(response == 'success'){
                    $("#mark_assignment_btn").attr('disabled',true);
                    $('#success-alert').focus();
                    $('#message').html('Assignment Marked Successfully!');
                    $("#success-alert").fadeTo(2000, 500).slideUp(500, function () {
                        $("#success-alert").css("height", "0px");
                        $("#success-alert").css("display", "block");
                        var page = '<?php echo url("/")?>'+'/marking/list/<?php echo $page_var.'?q='.Request::input("q");?>';
                        window.location.href = page // Go
                    });
                }

            },
            error: function (data) {
                console.log(data);
            }
        });
        return false;
    }

    function slideCannedResponsePanel(){
        console.log("sliding");
        $("#canned_responses_panel").slideToggle();
    }

    function slideUnitCannedResponsePanel(id){
        console.log("slide unit");
        $("#unit_canned_responses_panel_"+id).slideToggle();
    }

    $("#new_canned_response").on("click", function () {
        $("#modal_canned_response_action").css('display','block');
        $("#modal_canned_response_action").css({ top: '0%' });
    });

    $("#close_canned_response_dialog").on("click", function (e) {
        e.preventDefault();
        console.log("Cancelling canned_response");
        $(".modal_canned_response_action").hide();
    });

    $("#cancelled_canned_response").on("click", function (e) {
        e.preventDefault();
        console.log("Cancelling cancelled_canned_response");
        $(".modal_canned_response_action").hide();
    });

    function pass_refer(id){
        if(id == 'pass'){
            console.log('PASS');
            $("#pass").removeClass('active');
            $("#refer").removeClass('active');
            $("#pass").addClass('active');
            $("#grade_awarded_hidden").val('pass');
        }
        if(id == 'refer'){
            console.log('refer');
            $("#refer").removeClass('active');
            $("#pass").removeClass('active');
            $("#refer").addClass('active');
            $("#grade_awarded_hidden").val('refer');
        }
    }

    //delete note by id
    function deleteNote(id){
        $("#note_id").val(id);

        $("#modal_delete_note_action").css('display','block');
        $("#modal_delete_note_action").css({ top: '0%' });
        return false;
    }

    //delete marker by id
    function deleteMarker(id){
        $("#marker_id").val(id);
        $("#modal_delete_marker_action").css('display','block');
        $("#modal_delete_marker_action").css({ top: '0%' });
        return false;
    }

    function getCannedResponse(id){
            console.log("canned id:"+id);
            var template_content = $('#template_content').html();
            $('#template_content').css('line-height','20px');
            $('#template_content').html($('#canned_content_'+id).html() + '\n' + template_content);
    }

    function getUnitCannedResponse(id,evidence_id){
        console.log("canned id:"+id);
        console.log("evi id:"+evidence_id);
        //$('#template_content').css('line-height','20px');
        $('#unit_feedback_'+evidence_id).html($('#unit_canned_content_'+id).html());
    }

    $("#confirmed_canned_response").click(function (e) {
        var error_scroll = '';
        if ($('#comments').innerHTML.length <= 0) {
            $('#comments_errors').text('Please provide some comments');
            return false;
        } else {
            $('#comments_errors').text('');
        }

        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-XSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var formdata = new FormData($("#add_canned_response_form")[0]);
        console.log("formdata");
        console.log(formdata);

        $.ajax({
            url: '{{ url('/marking/list/').'/'.$page_var.'?q='.Request::input("q") }}',
            type: 'POST',
            data: formdata,
            processData: false,
            contentType: false,
            success: function (response) {
                $('#success-alert').html('<h3>Canned Response Template Added Successfully</h3>');
                $("#confirmed_feedback").attr('disabled',true);
                $('#success-alert').focus();
                $("#success-alert").fadeTo(2000, 500).slideUp(500, function () {
                    $("#success-alert").css("height", "0px");
                    $("#success-alert").css("display", "block");
                    var page = '{{ url('/marking/list/').'/'.$page_var.'?q='.Request::input("q") }}';
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

    function assignmentMarking(student_id,course_id){
        console.log('LOG s & c:'+student_id+' , '+course_id);
        //process marking request
        $.ajaxSetup({
            headers: {
                'X-XSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: '{{ url('/get-student-assignment-marking-by-id-ajax') }}',
            type: 'get',
            data:'student_id='+student_id+'&course_id='+course_id,
            processData: false,
            contentType: false,
            success: function (response) {
                $('#single_marking_content').html(response['html']);
                $('#notes_content').html(response['notes']);
                $('#markers_content').html(response['markers']);
            },
            error: function (data) {
                console.log(data);
            }
        });

        $("#modal_single_marking_action").css('display','block');
        $("#modal_single_marking_action").css({ top: '0%' });
        return false;
    }

    //SAM assignment marking
    function SAMAssignmentMarking(){
        console.log('MARKING SAM ASSIGNMENT::::::');
        $("#modal_sam_assignment_marking_action").css('display','block');
        $("#modal_sam_assignment_marking_action").css({ top: '0%' });
        //process marking request
        $.ajaxSetup({
            headers: {
                'X-XSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: '{{ url('/get-next-sam-assignment-marking-ajax') }}',
            type: 'get',
            data:'',
            processData: false,
            contentType: false,
            success: function (response) {
                $('#sam_assignment_marking_content').html(response['html']);
                $('#notes_content').html(response['notes']);
                $('#markers_content').html(response['markers']);
            },
            error: function (data) {
                console.log(data);
            }
        });


        return false;
    }

    //SAM evidence marking
    function SAMEvidenceMarking(){
        console.log('MARKING SAM Evidence::::::');
        $("#modal_sam_evidence_marking_action").css('display','block');
        $("#modal_sam_evidence_marking_action").css({ top: '0%' });
        //process marking request
        $.ajaxSetup({
            headers: {
                'X-XSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: '{{ url('/get-next-sam-evidence-marking-ajax') }}',
            type: 'get',
            data:'',
            processData: false,
            contentType: false,
            success: function (response) {
                $('#sam_evidence_marking_content').html(response['html']);
                $('#notes_content').html(response['notes']);
                $('#markers_content').html(response['markers']);
                // $('#work_based_marking_content').append(response['html']);
                // $('#notes_content').html(response['notes']);
                // $('#markers_content').html(response['markers']);
            },
            error: function (data) {
                console.log(data);
            }
        });
        return false;
    }

    function markCourseProgress(student_id,course_id){
        console.log("mark_course_progress_btn");
        var mark_all_completed = $('#mark_all_completed').val();
        console.log("mark_all_completed:"+mark_all_completed);
        var mark_all_progress = $('#mark_all_progress').val();
        console.log("mark_all_progress:"+mark_all_progress);
        var course_progress_method = $('#course_progress_method').val();
        console.log("course_progress_method:"+course_progress_method);
        var completed_portfolio = $('#completed_portfolio').val();
        console.log("completed_portfolio:"+completed_portfolio);

        //process marking request
        $.ajaxSetup({
            headers: {
                'X-XSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var formdata = new FormData($("#add_course_marking_form")[0]);
        console.log("formdata");
        console.log(formdata);

        $.ajax({
            url: '{{ url('/mark-course-progress-ajax/') }}',
            type: 'GET',
            data:'student_id='+student_id+'&course_id='+course_id+'&mark_all_completed='+mark_all_completed+'&mark_all_progress='+mark_all_progress+'&completed_portfolio='+completed_portfolio+'&method='+course_progress_method,
            processData: false,
            contentType: false,
            success: function (response) {
                console.log('resp:');
                console.log(response);
                if(response['msg'] == 'Course Marking Completed'){
                    $('#success-alert').focus();
                    $('#message').html('Course Marking Completed!');
                    $("#success-alert").css("height", "50px");
                    $("#success-alert").fadeTo(2000, 500).slideUp(500, function () {
                        $("#success-alert").css("height", "0px");
                        $("#success-alert").css("display", "block");
                    });
                   // $('#notes_content').html(response['notes']);
                }
            },
            error: function (data) {
                console.log(data);
            }
        });
    }

    //unit marking
    function markUnitCourseProgress(student_id,course_id){
        // console.log("mark_unit_course_progress_btn");
        // var mark_all_units_completed = $('#mark_all_units_completed').val();
        // console.log("mark_all_units_completed:"+mark_all_units_completed);
        // var mark_all_units_progress = $('#mark_all_units_progress').val();
        // console.log("mark_all_units_progress:"+mark_all_units_progress);
        // var unit_method = $('#unit_method').val();
        // console.log("unit_method:"+unit_method);
        // var completed_unit_portfolio = $('#completed_unit_portfolio').val();
        // console.log("completed_unit_portfolio:"+completed_unit_portfolio);
       var data = $("#add_work_based_marking_form").serialize();
        //process marking request
        $.ajaxSetup({
            headers: {
                'X-XSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        console.log("formdata");
        console.log(data);

        $.ajax({
            url: '{{ url('/mark-unit-course-progress-ajax/') }}',
            type: 'GET',
            data: data,
            processData: false,
            contentType: false,
            success: function (response) {
                console.log('resp:');
                console.log(response);
                if(response['msg'] == 'Course Marking Completed'){
                    $("#mark_unit_course_progress_btn").attr('disabled',true);
                    $('#success-alert').focus();
                    $('#message').html('Course Marking Completed!');
                    $("#success-alert").css("height", "50px");
                    $("#success-alert").fadeTo(2000, 500).slideUp(500, function () {
                        $("#success-alert").css("height", "0px");
                        $("#success-alert").css("display", "block");
                        var page = '<?php echo url("/")?>'+'/marking/list/1?q=<?php echo Request::input("q");?>';
                        window.location.href = page // Go
                    });

                    // $('#notes_content').html(response['notes']);
                }
            },
            error: function (data) {
                console.log(data);
            }
        });
    }


    //SAM unit marking
    function markSAMUnitCourseProgress(student_id,course_id){
        // console.log("mark_unit_course_progress_btn");
        // var mark_all_units_completed = $('#mark_all_units_completed').val();
        // console.log("mark_all_units_completed:"+mark_all_units_completed);
        // var mark_all_units_progress = $('#mark_all_units_progress').val();
        // console.log("mark_all_units_progress:"+mark_all_units_progress);
        // var unit_method = $('#unit_method').val();
        // console.log("unit_method:"+unit_method);
        // var completed_unit_portfolio = $('#completed_unit_portfolio').val();
        // console.log("completed_unit_portfolio:"+completed_unit_portfolio);
        var data = $("#add_sam_evidence_marking_form").serialize();
        //process marking request
        $.ajaxSetup({
            headers: {
                'X-XSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        console.log("formdata");
        console.log(data);

        $.ajax({
            url: '{{ url('/mark-sam-unit-course-progress-ajax/') }}',
            type: 'GET',
            data: data,
            processData: false,
            contentType: false,
            success: function (response) {
                console.log('resp:');
                console.log(response);
                if(response['msg'] == 'Course Marking Completed'){
                    $("#mark_sam_unit_course_progress_btn").attr('disabled',true);
                    $('#success-alert').focus();
                    $('#message').html('Course Marking Completed!');
                    $("#success-alert").css("height", "50px");
                    $("#success-alert").fadeTo(2000, 500).slideUp(500, function () {
                        $("#success-alert").css("height", "0px");
                        $("#success-alert").css("display", "block");
                        var page = '<?php echo url("/")?>'+'/marking/list/1?q=<?php echo Request::input("q");?>';
                        window.location.href = page // Go
                    });

                    // $('#notes_content').html(response['notes']);
                }
            },
            error: function (data) {
                console.log(data);
            }
        });
    }

    function setRadioActive(id){
        console.log('ID:'+id);
        $('#mark_all_progress').val('0');
        $('#mark_all_completed').val('0');
        $('#'+id).val('1');
    }

    function setPassProgressRadioValue(value,id){
        console.log('this ID:'+ id);
        console.log('this value:'+ value);
        if(value == 'pass'){
            $('#unit_status_'+id).val('1');
        }
        if(value == 'progress'){
            $('#unit_status_'+id).val('0');
        }

    }

    function setUnitRadioActive(id){
        console.log('ID:'+id);
        if(id == 'mark_all_units_completed'){
            $('#mark_all_set').val('all_pass');
        }
        if(id == 'mark_all_units_progress'){
            $('#mark_all_set').val('all_progress');
        }
    }

    function toggleCheckbox(id){
        var value = $('#completed_portfolio').val();
        if(value == '1'){
            $('#completed_portfolio').val('0');
        }
        if(value == '0'){
            $('#completed_portfolio').val('1');
        }
    }

    function toggleUnitCheckbox(id){
        var value = $('#mark_course_as_completed').val();
        if(value == '1'){
            $('#mark_course_as_completed').val('0');
        }
        if(value == '0'){
            $('#mark_course_as_completed').val('1');
        }
    }

    function courseMarking(student_id,course_id){
        console.log('LOG s & c:'+student_id+' , '+course_id);
        //process marking request
        $.ajaxSetup({
            headers: {
                'X-XSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: '{{ url('/get-student-course-marking-by-id-ajax') }}',
            type: 'get',
            data:'student_id='+student_id+'&course_id='+course_id,
            processData: false,
            contentType: false,
            success: function (response) {
                $('#course_marking_content').html(response['html']);
                $('#notes_content').html(response['notes']);
                $('#markers_content').html(response['markers']);
            },
            error: function (data) {
                console.log(data);
            }
        });

        $("#modal_course_marking_action").css('display','block');
        $("#modal_course_marking_action").css({ top: '0%' });
        return false;
    }

    //course unit marking
    function workBasedCourseMarking(student_id,course_id){
        console.log('LOG s & c:'+student_id+' , '+course_id);
        //process marking request
        $.ajaxSetup({
            headers: {
                'X-XSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: '{{ url('/get-student-work-based-course-marking-by-id-ajax') }}',
            type: 'get',
            data:'student_id='+student_id+'&course_id='+course_id,
            processData: false,
            contentType: false,
            success: function (response) {
                console.log('response:');
                console.log(response);
                $('#work_based_marking_content').append(response['html']);
                $('#notes_content').html(response['notes']);
                $('#markers_content').html(response['markers']);
            },
            error: function (data) {
                console.log(data);
            }
        });

        $("#modal_work_based_marking_action").css('display','block');
        $("#modal_work_based_marking_action").css({ top: '0%' });
        return false;
    }

    (function(){
        setTimeout(function() {
            $('.alert-success').fadeOut('slow');
        }, 3000); // <-- time in milliseconds
        setTimeout(function() {
            $('.alert-danger').fadeOut('slow');
        }, 3000); // <-- time in milliseconds

        //delete note
        $("#confirmed_delete_note").on("click", function (e) {
            e.preventDefault();
            var note_id = $("#note_id").val();
            console.log("noteID:"+note_id);
            var student_id = $("#note_student_id").val();
            var post_method = $("#post_method").val();
            var course_id = $("#note_course_id").val();
            var assignment_id = $("#note_assignment_id").val();

            $.ajaxSetup({
                headers: {
                    'X-XSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: '{{ url("/delete-assignment-note/") }}',
                type: 'GET',
                data:'note_id='+note_id+'&student_id='+student_id+'&course_id='+course_id+'&assignment_id='+assignment_id+'&post_method='+post_method,
                processData: false,
                contentType: false,
                success: function (response) {
                    console.log('Success');
                    console.log(response);
                    if(response['msg'] == 'success') {
                        $("#modal_delete_note_action").hide();

                        $('#success-alert').focus();
                        $('#message').html('Note Deleted Successfully!');
                        $("#success-alert").css("height", "50px");
                        $("#success-alert").fadeTo(2000, 500).slideUp(500, function () {
                            $("#success-alert").css("height", "0px");
                            $("#success-alert").css("display", "block");
                        });
                        $('#notes_content').html(response['notes']);
                    }
                },
                error: function (data) {
                    console.log(data);
                }
            });
        });

        //delete note
        $("#confirmed_delete_marker").on("click", function (e) {
            e.preventDefault();
            var marker_id = $("#marker_id").val();
            console.log("markerID:"+marker_id);
            var student_id = $("#marker_student_id").val();
            var post_marker_method = $("#post_marker_method").val();
            var course_id = $("#marker_course_id").val();
            var assignment_id = $("#marker_assignment_id").val();

            $.ajaxSetup({
                headers: {
                    'X-XSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: '{{ url("/delete-assignment-marker/") }}',
                type: 'GET',
                data:'marker_id='+marker_id+'&student_id='+student_id+'&course_id='+course_id+'&assignment_id='+assignment_id+'&post_marker_method='+post_marker_method,
                processData: false,
                contentType: false,
                success: function (response) {
                    console.log('Success');
                    console.log(response);
                    if(response['msg'] == 'success') {
                        $("#modal_delete_marker_action").hide();
                        $('#success-alert').focus();
                        $('#message').html('Marker Deleted Successfully!');
                        $("#success-alert").css("height", "50px");
                        $("#success-alert").fadeTo(2000, 500).slideUp(500, function () {
                            $("#success-alert").css("height", "0px");
                            $("#success-alert").css("display", "block");
                        });
                        $('#markers_content').html(response['markers']);
                    }
                },
                error: function (data) {
                    console.log(data);
                }
            });
        });

        //add new note
        $("#add_note_btn").on("click", function (e) {
            console.log("add_note_btn");
            e.preventDefault();
            var course_id = $('#note_course_id').val();
            var student_id = $('#note_student_id').val();
            var assignment_id = $('#note_assignment_id').val();
            var note = $('#note').html();
            if (note != '') {
                $('#note_errors').text('Please add some note first');
                return false;
            } else {
                $('#note_errors').text('');
            }

            //process marking request
            $.ajaxSetup({
                headers: {
                    'X-XSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var formdata = new FormData($("#add_notes_form")[0]);
            console.log("formdata");
            console.log(formdata);

            $.ajax({
                url: '{{ url('/marking/list').'/'.$page_var.'?q='.Request::input("q") }}',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (response) {
                    console.log('resp:');
                    console.log(response);
                    if(response['msg'] == 'Note Added Successfully'){
                        $('#success-alert').focus();
                        $('#message').html('Note Added Successfully!');
                        $("#success-alert").css("height", "50px");
                        $("#success-alert").fadeTo(2000, 500).slideUp(500, function () {
                            $("#success-alert").css("height", "0px");
                            $("#success-alert").css("display", "block");
                        });
                        $('#notes_content').html(response['notes']);
                    }
                },
                error: function (data) {
                    console.log(data);
                }
            });
        });

        //mark course progress / complete


        //add new marker
        $("#add_marker_btn").on("click", function (e) {
            console.log("add_marker_btn");
            e.preventDefault();

            var marker = $('#marker').html();
            if (marker != '') {
                $('#marker_errors').text('Please add some text first');
                return false;
            } else {
                $('#marker_errors').text('');
            }

            //process marking request
            $.ajaxSetup({
                headers: {
                    'X-XSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var formdata = new FormData($("#add_markers_form")[0]);
            console.log("formdata");
            console.log(formdata);

            $.ajax({
                url: '{{ url('/marking/list').'/'.$page_var.'?q='.Request::input("q") }}',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (response) {
                    console.log('resp:');
                    console.log(response);
                    if(response['msg'] == 'Marker Added Successfully'){
                        $('#success-alert').focus();
                        $('#message').html('Marker Added Successfully!');
                        $("#success-alert").css("height", "50px");
                        $("#success-alert").fadeTo(2000, 500).slideUp(500, function () {
                            $("#success-alert").css("height", "0px");
                            $("#success-alert").css("display", "block");
                        });
                        $('#markers_content').html(response['markers']);
                    }
                },
                error: function (data) {
                    console.log(data);
                }
            });
        });

        //cancel marking
        $("#cancelled_marking").on("click", function (e) {
            console.log("Cancelling marking");
            $(".modal_marking_action").hide();
        });

        //closse course marking
        $("#close_course_marking_dialog").on("click", function (e) {
            console.log("Cancelling course marking");
            $(".modal_course_marking_action").hide();
        });

        $("#close_work_based_marking_dialog").on("click", function (e) {
            console.log("Cancelling work_based marking");
            $(".modal_work_based_marking_action").hide();
        });

        //close marking
        $("#close_marking_dialog").on("click", function (e) {
            e.preventDefault();
            console.log("Cancelling marking");
            $(".modal_marking_action").hide();
        });

        //cancel delete
        $("#cancelled_delete").on("click", function (e) {
            console.log("Cancelling delete");
            $(".modal_delete_action").hide();
        });

        //close delete dialog
        $("#close_delete_dialog").on("click", function (e) {
            e.preventDefault();
            $(".modal_delete_action").hide();
        });

        $("#cancelled_delete_note").on("click", function (e) {
            console.log("Cancelling delete");
            $(".modal_delete_note_action").hide();
        });

        $("#close_delete_note_dialog").on("click", function (e) {
            e.preventDefault();
            $(".modal_delete_note_action").hide();
        });

        $("#cancelled_delete_marker").on("click", function (e) {
            console.log("Cancelling delete marker");
            $(".modal_delete_marker_action").hide();
        });

        $("#close_delete_marker_dialog").on("click", function (e) {
            e.preventDefault();
            $(".modal_delete_marker_action").hide();
        });

        $("#cancelled_approve").on("click", function (e) {
            $(".modal_approve_action").hide();
        });

        $("#close_single_marking_dialog").on("click", function (e) {
            e.preventDefault();
            $(".modal_single_marking_action").hide();
        });

        $("#close_sam_assignment_marking_dialog").on("click", function (e) {
            e.preventDefault();
            $(".modal_sam_assignment_marking_action").hide();
        });

        $("#close_sam_evidence_marking_dialog").on("click", function (e) {
            e.preventDefault();
            $(".modal_sam_evidence_marking_action").hide();
        });

        $("#close_notes_dialog").on("click", function (e) {
            $(".modal_notes_action").hide();
        });

        $("#close_markers_dialog").on("click", function (e) {
            $(".modal_markers_action").hide();
        });

        $("#cancelled_approve").on("click", function (e) {
            $(".modal_approve_action").hide();
        });

        $("#close_approve_dialog").on("click", function (e) {
            e.preventDefault();
            $(".modal_approve_action").hide();
        });

        $("#close_marking_edit_dialog").on("click", function (e) {
            e.preventDefault();
            console.log("Cancelling marking edit");
            $(".modal_marking_edit_action").hide();
        });

        $("#edit_cancelled_marking").on("click", function (e) {
            e.preventDefault();
            console.log("Cancelling marking edit");
            $(".modal_marking_edit_action").hide();
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



        $(".approve_action").on("click", function (e) {
            e.preventDefault();
            $("#modal_approve_action").css('display','block');
            $("#modal_approve_action").css({ top: '0%' });
            console.log("Processing Del Request:"+this.id);
            var str = this.id;
            var ids = str.split(/[\s_]+/);
            console.log("SPLITTED:" + ids[2]);
            $("#approve_id").val(ids[2]);
        });

        $(".student_marking_btn").on("click", function (e) {
            e.preventDefault();
            var str = this.id;
            var ids = str.split(/[\s_]+/);
            //perform ajax call to get selected user data for modal dialog to be updated
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-XSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: '{{ url('/get-student-assigned-courses-by-id-ajax') }}',
                type: 'get',
                data:'student_id='+ids[1],
                processData: false,
                contentType: false,
                success: function (response) {
                    //console.log(response['html']);
                    $('#student_name').html(response['student_name']);
                    $('#marking_content').html(response['html']);
                },
                error: function (data) {
                    console.log(data);
                    console.log('scroll error'+error_scroll);
                    $('#'+error_scroll).focus();
                }
            });
            //process marking request
            $("#modal_marking_action").css('display','block');
            $("#modal_marking_action").css({ top: '0%' });
        });

        //get anchor id => delete_action_{1} and concatenate it to create modal id
        $("#new_marking_btn").on("click", function () {
                //process marking request
                $("#modal_marking_action").css('display','block');
                $("#modal_marking_action").css({ top: '0%' });
        });

        $("#priority_students").on("click", function (e) {
            console.log("clicked priority_students");
            var page = '<?php echo url("/")?>'+'/marking/list/1?q=priority_students';
            window.location.href = page // Go
        });

        $("#pending_resource_approval").on("click", function (e) {
            console.log("clicked pending_resource_approval");
            var page = '<?php echo url("/")?>'+'/marking/list/1?q=pending_resource_approval';
            window.location.href = page // Go
        });

        $("#current_marking").on("click", function (e) {
            console.log("clicked current_marking");
            var page = '<?php echo url("/")?>'+'/marking/list/1?q=current_marking';
            window.location.href = page // Go
        });

        $("#current_unit_marking").on("click", function (e) {
            console.log("clicked current_unit_marking");
            var page = '<?php echo url("/")?>'+'/marking/list/1?q=current_unit_marking';
            window.location.href = page // Go
        });

        $("#overdue_unit_marking").on("click", function (e) {
            console.log("clicked overdue_unit_marking");
            var page = '<?php echo url("/")?>'+'/marking/list/1?q=overdue_unit_marking';
            window.location.href = page // Go
        });
    })();
</script>
@endsection