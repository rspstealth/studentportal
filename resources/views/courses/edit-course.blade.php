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
                        <a style="margin-top: 23px;" href="{{url('/courses/list/1')}}" id="new_course_btn" title="Back to Courses List" class="btn btn-outline-secondary "><i class="fas fa-arrow-left"></i> Back to Courses</a>
                         <a style="float:right;margin-top: 23px;" href="#" id="new_canned_response_btn" title="Add New Canned Response" class="btn btn-outline-primary "><i class="fas fa-plus"></i> Add Canned Response</a>
                        <a style="float:right;margin-top: 23px;margin-right:15px;" href="#" id="new_feedback_btn" title="Add New Feedback Template" class="btn btn-outline-primary "><i class="fas fa-plus"></i> Add Feedback Template</a>
                        <?php
                        if($course->type==='work_based'){
                        ?>
                        <a style="float:right;margin-top: 23px;margin-right:15px;" href="#" id="evidence_assessment_btn" title="Evidence Assessment" class="btn btn-outline-primary "><i class="fas fa-file-word"></i> Evidence Assessment</a>
                        <a style="float:right;margin-top: 23px;margin-right:15px;" href="#" id="course_evidence_btn" title="Evidence Work" class="btn btn-outline-primary "><i class="fas fa-file-word"></i> Evidence</a>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="col-md-12">
                        <hr style="margin-top:10px;"/>
                        <h3 style="padding-top: 0px;">{{$course->name}}</h3>
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

                    <form id="edit_course_form" action="{{url('/courses/edit/')}}/{{$course_id}}" method="POST">
                        {{ csrf_field() }}
                            <div class="col-md-12 no-padding">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        Course Name
                                        <input class="form-control lb-lg" id="edit_course_name" name="edit_course_name" value="{{$course->name}}"/>
                                        <small class="text-danger error_msg" id="edit_course_name_errors"></small>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        Description
                                        <textarea style="min-height: 60px;" id="edit_description" name="edit_description" class="form-control lb-lg">{{$course->description}}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        Full Price
                                        <input class="form-control lb-lg"  id="edit_full_price" name="edit_full_price" value="{{$course->full_price}}"/>
                                        <small class="text-danger error_msg" id="edit_full_price_errors"></small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        Course Deposit
                                        <input class="form-control lb-lg"  id="edit_course_deposit" name="edit_course_deposit" value="{{$course->deposit}}"/>
                                        <small class="text-danger error_msg" id="edit_course_deposit_errors"></small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        Course Instalment Price
                                        <input class="form-control lb-lg"  id="edit_instalment_price" name="edit_instalment_price" value="{{$course->instalment_price}}"/>
                                        <small class="text-danger error_msg" id="edit_instalment_price_errors"></small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        Course Support Price
                                        <input class="form-control lb-lg"  id="edit_support_price" name="edit_support_price" value="{{$course->support_price}}"/>
                                        <small class="text-danger error_msg" id="edit_support_price_errors"></small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        Course Sale Price
                                        <input class="form-control lb-lg"  id="edit_sale_price" name="edit_sale_price" value="{{$course->sale_price}}"/>
                                        <small class="text-danger error_msg" id="edit_sale_price_errors"></small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        Number of Assignments
                                        <input class="form-control lb-lg"  id="edit_number_of_assignments" name="edit_number_of_assignments" value="{{$course->number_of_assignments}}"/>
                                        <small class="text-danger error_msg" id="edit_number_of_assignments_errors"></small>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        Course Type
                                        <select class="form-control lb-lg"  id="edit_type" name="edit_type">
                                            <option <?php ($course->type === 'standard')? print 'selected=""': ''; ?> value="standard">Standard</option>
                                            <option <?php ($course->type === 'work_based')? print 'selected=""': ''; ?> value="work_based">Work based qual/QCF</option>
                                        </select>
                                        <small class="text-danger error_msg" id="edit_type_errors"></small>
                                    </div>
                                    <hr/>
                                </div>
                                <div class="col-md-12">
                                    <div class="col-md-2 no-padding">
                                        <div class="form-group">
                                            <b>Feedback Templates:</b>
                                        </div>
                                    </div>
                                    <?php

                                            if(count($course_feedback_templates)>0){
                                                $inner_feedback_templates = $course_feedback_templates;
                                                $counter = min(array_keys($course_feedback_templates));
                                                $current_assignment_number = '';

                                                $first = $course_feedback_templates[$counter]->assignment_number;
                                                $current = $course_feedback_templates[$counter]->assignment_number;

                                                //var_export($course_feedback_templates);
                                                foreach($course_feedback_templates as $template){
                                                    if($first === $template->assignment_number){
                                                        echo '<div class="col-md-2 text-center">';
                                                        echo 'Template: '.($template->assignment_number);

                                                        echo '<a href="#" id="edit_feedback_action_btn_'.$template->id.'" class="btn btn-outline-secondary full-width edit_feedback_action" title="View / Edit Feedback Template"><i class="fas fa-edit"></i> View / Edit</a> ';
                                                        echo '<a href="#" id="delete_feedback_action_btn_'.$template->id.'" class="btn btn-outline-secondary full-width delete_feedback_action" title="Delete Canned Response Template"><i class="fas fa-trash"></i> Delete</a> ';
                                                        echo '</div>';
                                                    }elseif($current === $template->assignment_number){
                                                        echo '<div class="col-md-2 text-center">';
                                                        echo 'Template: '.($template->assignment_number);

                                                        echo '<a href="#" id="edit_feedback_action_btn_'.$template->id.'" class="btn btn-outline-secondary full-width edit_feedback_action" title="View / Edit Feedback Template"><i class="fas fa-edit"></i> View / Edit</a> ';
                                                        echo '<a href="#" id="delete_feedback_action_btn_'.$template->id.'" class="btn btn-outline-secondary full-width delete_feedback_action" title="Delete Canned Response Template"><i class="fas fa-trash"></i> Delete</a> ';
                                                        echo '</div>';
                                                    }else{
                                                        $current = $template->assignment_number;
                                                        echo '<div class="col-md-2 text-center">';
                                                        echo 'Template: '.($template->assignment_number);

                                                        echo '<a href="#" id="edit_feedback_action_btn_'.$template->id.'" class="btn btn-outline-secondary full-width edit_feedback_action" title="View / Edit Feedback Template"><i class="fas fa-edit"></i> View / Edit</a> ';
                                                        echo '<a href="#" id="delete_feedback_action_btn_'.$template->id.'" class="btn btn-outline-secondary full-width delete_feedback_action" title="Delete Canned Response Template"><i class="fas fa-trash"></i> Delete</a> ';
                                                        echo '</div>';
                                                    }
                                                }

                                            }else{
                                                echo 'No feedback template found';
                                            }
                                            ?>
                                </div>
                                <div class="col-md-12">
                                    <hr/>
                                    <div class="col-md-2 no-padding">
                                        <div class="form-group">
                                            <b>Canned Responses:</b>
                                        </div>
                                    </div>
                                            <?php
                                            $counter = 1;
                                            if(count($canned_responses)>0){
                                                foreach($canned_responses as $template){
                                                    echo '<div class="col-md-2 text-center">';
                                                    echo 'Template '.$counter;
                                                    echo '<a href="#" id="edit_canned_action_btn_'.$template->id.'" class="btn btn-outline-secondary full-width edit_canned_action" title="View / Edit Canned Response Template"><i class="fas fa-edit"></i> View / Edit</a> ';
                                                    echo '<a href="#" id="delete_canned_action_btn_'.$template->id.'" class="btn btn-outline-secondary full-width delete_canned_action" title="View / Edit Feedback Response Template"><i class="fas fa-trash"></i> Delete</a> ';
                                                    echo '</div>';
                                                    $counter++;
                                                }
                                            }else{
                                                echo 'No canned response template found';
                                            }
                                            ?>
                                </div>
                            </div>
                        <input type="hidden" id="method" name="method" value="course_edit" />
                        <input type="hidden" id="edit_course_id" name="edit_course_id" value="{{$course_id}}" />
                        <div class="col-md-12">
                            <hr/>
                            <input class="btn btn-primary" type="submit" id="edit_confirmed_course" name="edit_confirmed_course" value="Update Course" />
                        </div>
                    </form>

                    {{--feedback modal--}}
                    <div id="modal_feedback_action" class="modal modal_feedback_action" tabindex="-1" role="dialog">
                        <div class="feedback-modal-dialog modal_feedback_dialog" role="document">
                            <div class="modal-content align-items-center" style="padding: 0 20px;">
                                <div class="modal-body">
                                    <h3>Add Feedback Template <a href="#" title="close dialog" id="close_feedback_dialog" style="float: right;margin: 0 10px;"><i class="fa fa-close"></i></a></h3>
                                </div>
                                <div class="modal-footer">
                                    <form id="add_feedback_form" action="{{url('/courses/edit/')}}/{{$course_id}}" method="POST">
                                        {{ csrf_field() }}
                                        <div class="col-md-12 no-padding">
                                            <div class="col-md-12 no-padding">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        Assignment Number
                                                        <input class="form-control lb-lg"  id="assignment_number" name="assignment_number" />
                                                        <small class="text-danger error_msg" id="assignment_number_errors"></small>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                    Comments
                                                    <textarea style="min-height: 100px;" id="comments" name="comments" class="form-control lb-lg"></textarea>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        Further Actions (Pass)
                                                        <textarea class="form-control lb-lg"  id="further_actions" name="further_actions"></textarea>
                                                        <small class="text-danger error_msg" id="further_actions_errors"></small>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        Further Actions (Refer)
                                                        <textarea class="form-control lb-lg"  id="further_actions_refer" name="further_actions_refer"></textarea>
                                                        <small class="text-danger error_msg" id="further_actions_refer_errors"></small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" id="method" name="method" value="new_feedback" />
                                        <input type="hidden" id="feedback_course_id" name="feedback_course_id" value="{{$course_id}}" />
                                        <div class="col-md-12">
                                            <hr/>
                                            <input class="btn btn-primary" type="submit" id="confirmed_feedback" name="confirmed_feedback" value="Create Template" />
                                            <button type="button" id="cancelled_feedback" class="btn btn-outline-secondary ">Cancel</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="modal_evidence_action" class="modal modal_evidence_action" tabindex="-1" role="dialog">
                        <div class="evidence-modal-dialog modal_evidence_dialog" role="document">
                            <div class="modal-content align-items-center" style="padding: 0 20px;">
                                <div class="modal-body">
                                    <h3>Manage Evidence <a href="#" title="close dialog" id="close_evidence_dialog" style="float: right;margin: 5px 10px;"><i class="fas fa-times-circle"></i></a><a href="#" class="btn btn-outline-secondary" title="Evidence dialog" id="new_evidence_dialog_btn" style="float: right;margin: 0px 10px;"><i class="fa fa-plus"></i> Add New Evidence</a></h3>
                                </div>
                                <div class="modal-footer">
                                    <table class="table">
                                        <tr>
                                            <th class="name_col" scope="col">Unit #</th>
                                            <th class="name_col" scope="col">Unit Name</th>
                                            <th class="evidence_description_col" scope="col">Description</th>
                                            <th class="course_col" scope="col">Actions</th>
                                        </tr>
                                        <tbody>
                                        <?php
                                        foreach($assessment_parent_units as $evi){
                                        ?>
                                        <tr class="record_row record_">
                                            <td><span class="numeric_big">{{(!empty($evi->unit_parent)?'--  ':'') . $evi->unit_number}}</span></td>
                                            <td>{{$evi->unit_name}}</td>
                                            <td>{{$evi->evidence_description}}</td>
                                            <td>
                                                <a href="#" id="edit_evidence_{{$evi->id}}" class="edit_evidence_btn btn tiny-action-btn" title="Edit Course Evidence"><i class="fas fa-edit"></i> Edit</a>
                                                <a id="delete_evidence_{{$evi->id}}" class="delete_evidence btn tiny-action-btn" href="#" title="Remove Evidence"><i class="fas fa-trash"></i> Delete</a>
                                            </td>
                                        </tr>
                                            <?php
                                            foreach($assessment_children[$evi->unit_number] as $evidence){
                                                if($evi->unit_number === $evidence->unit_parent){
                                                   ?>
                                                    <tr class="record_row record_">
                                                        <td><span class="numeric_big">{{(!empty($evidence->unit_parent)?'--  ':'') . $evidence->unit_number}}</span></td>
                                                        <td>{{$evidence->unit_name}}</td>
                                                        <td>{{$evidence->evidence_description}}</td>
                                                        <td>
                                                            <a href="#" id="edit_evidence_{{$evidence->id}}" class="edit_evidence_btn btn tiny-action-btn" title="Edit Course Evidence"><i class="fas fa-edit"></i> Edit</a>
                                                            <a id="delete_evidence_{{$evidence->id}}" class="delete_evidence btn tiny-action-btn" href="#" title="Remove Evidence"><i class="fas fa-trash"></i> Delete</a>
                                                        </td>
                                                    </tr>
                                                <?php
                                                }
                                                if($evi->unit_number === $evidence->unit_parent){
                                                    $sub_item = $evidence->unit_number;
                                                    foreach($assessment_children[$evi->unit_number] as $evidence){
                                                        if($sub_item === $evidence->unit_parent){
                                                        ?>
                                                        <tr class="record_row record_">
                                                            <td><span class="numeric_big">{{(!empty($evidence->unit_parent)?'--  ':'') . $evidence->unit_number}}</span></td>
                                                            <td>{{$evidence->unit_name}}</td>
                                                            <td>{{$evidence->evidence_description}}</td>
                                                            <td>
                                                                <a href="#" id="edit_evidence_{{$evidence->id}}" class="edit_evidence_btn btn tiny-action-btn" title="Edit Course Evidence"><i class="fas fa-edit"></i> Edit</a>
                                                                <a id="delete_evidence_{{$evidence->id}}" class="delete_evidence btn tiny-action-btn" href="#" title="Remove Evidence"><i class="fas fa-trash"></i> Delete</a>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="modal_new_evidence_action" class="modal modal_new_evidence_action" tabindex="-1" role="dialog">
                        <div class="new-evidence-modal-dialog modal_new_evidence_dialog" role="document">
                            <div class="modal-content" style="padding: 0 20px;">
                                <div class="modal-body">
                                    <h3>New Evidence <a href="#" title="close dialog" id="close_new_evidence_dialog" style="float: right;margin: 5px 10px;"><i class="fa fa-close"></i></a></h3>
                                </div>
                                <div class="modal-footer">
                                    <form id="new_evidence_form" action="{{url('/courses/edit/')}}/{{$course_id}}" method="POST">
                                        {{ csrf_field() }}
                                        <div class="col-md-12 no-padding">
                                            <div class="col-md-12 no-padding">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        Parent Unit
                                                        <select id="parent_unit" name="parent_unit" class="form-control lb-lg">
                                                            <option value="">No Parent</option>
                                                            <?php
                                                            foreach($assessment_parent_units as $evidence){
                                                                if($evidence->unit_parent !== NULL){
                                                                    echo '<option value="'.$evidence->unit_number.'"> > '.$evidence->unit_number.'</option>';
                                                                }else{
                                                                    echo '<option value="'.$evidence->unit_number.'">'.$evidence->unit_number.'</option>';
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                            <?php
                                                            foreach($assessment_parent_units as $evidence){
                                                                if(count($assessment_children[$evidence->unit_number])>0){
                                                                    echo '<select style="display:none" id="child_sub_unit_'.$evidence->unit_number.'" name="child_sub_unit_'.$evidence->unit_number.'" class="child_sub_units form-control lb-lg">';
                                                                    echo '<option value="">Select Sub Unit</option>';
                                                                    foreach($assessment_children[$evidence->unit_number] as $children){
                                                                        if($children->unit_parent == $evidence->main_parent){
                                                                            echo '<option value="'.$children->unit_number.'">'.$children->unit_number.'</option>';
                                                                        }
                                                                    }
                                                                    echo '</select>';
                                                                }
                                                            }
                                                        ?>
                                                        <small class="text-danger error_msg" id="parent_unit_errors"></small>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        Unit Number
                                                        <input type="text" id="unit_number" name="unit_number" class="form-control lb-lg"/>
                                                        <small class="text-danger error_msg" id="unit_number_errors"></small>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        Unit Name
                                                        <input type="text" id="unit_name" name="unit_name" class="form-control lb-lg"/>
                                                        <small class="text-danger error_msg" id="unit_name_errors"></small>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        Evidence Description
                                                        <textarea style="min-height: 60px;" id="evidence_description" name="evidence_description" class="form-control lb-lg"></textarea>
                                                        <small class="text-danger error_msg" id="evidence_description_errors"></small>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        Evidence Documents Required
                                                        <input class="form-control lb-lg" value="1" type="number" id="evidence_documents_required" name="evidence_documents_required" />
                                                        <small class="text-danger error_msg" id="evidence_documents_required_errors"></small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" id="method" name="method" value="new_evidence" />
                                        <input type="hidden" id="new_evidence_course_id" name="new_evidence_course_id" value="{{$course_id}}" />
                                        <div class="col-md-12">
                                            <hr/>
                                            <input class="btn btn-primary" type="submit" id="new_evidence_btn" name="new_evidence_btn" value="Add New Evidence" />
                                            <button type="button" id="cancelled_new_evidence_btn" class="btn btn-outline-secondary ">Cancel</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="modal_new_assessment_action" class="modal modal_new_assessment_action" tabindex="-1" role="dialog">
                        <div class="new-assessment-modal-dialog modal_new_assessment_dialog" role="document">
                            <div class="modal-content" style="padding: 0 20px;   height: 600px;overflow-y: scroll;">
                                <div class="modal-body">
                                    <h3>New Assessment <a href="#" title="close dialog" id="close_new_assessment_dialog" style="float: right;margin: 5px 10px;"><i class="fa fa-close"></i></a></h3>
                                </div>
                                <div class="modal-footer">
                                    <form id="new_assessment_form" action="{{url('/courses/edit/')}}/{{$course_id}}" method="POST">
                                        {{ csrf_field() }}
                                        <div class="col-md-12 no-padding">
                                            <div class="col-md-12 no-padding">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        Parent Unit
                                                        <select id="unit_id" name="unit_id" class="form-control lb-lg">
                                                            <option value="">Select Unit</option>
                                                            <?php
                                                            foreach($assessment_parent_units as $evidence){
                                                                if($evidence->unit_parent === NULL){
                                                                    echo '<option value="'.$evidence->unit_number.'">'.$evidence->unit_name.'</option>';
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                        <small class="text-danger error_msg" id="unit_id_errors"></small>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        Assessment Detail
                                                        <textarea style="min-height: 60px;" id="assessment_detail" name="assessment_detail" class="form-control lb-lg"></textarea>
                                                        <small class="text-danger error_msg" id="assessment_detail_errors"></small>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        Units Required
                                                        <hr style="margin:5px;"/>
                                                        <?php
                                                        foreach($assessment_parent_units as $evi){
                                                            echo '<div id="unit_items_'.$evi->unit_number.'" class="unit_items">';
                                                            foreach($assessment_children[$evi->unit_number] as $evidence){
                                                                if($evidence->unit_parent !== NULL){
                                                                    if(is_numeric($evidence->unit_number)){
                                                                        if($evi->unit_number == $evidence->main_parent){
                                                                        echo '<label>'.$evidence->unit_number.' <input name="units_selection" type="checkbox" value="'.$evidence->unit_number.'"/></label>&nbsp;&nbsp;&nbsp;&nbsp;';
                                                                         }
                                                                    }
                                                                }
                                                            }
                                                        echo '</div>';
                                                        }
                                                        ?>
                                                        <small class="text-danger error_msg" id="units_required_errors"></small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" id="method" name="method" value="new_assessment" />
                                        <input type="hidden" id="selected_units" name="selected_units" value="" />
                                        <input type="hidden" id="new_assessment_course_id" name="new_assessment_course_id" value="{{$course_id}}" />
                                        <div class="col-md-12" style="margin-bottom: 10px;">
                                            <hr/>
                                            <input class="btn btn-primary" type="submit" id="new_assessment_btn" name="new_assessment_btn" value="Add New Assessment" />
                                            <button type="button" id="cancelled_new_assessment_btn" class="btn btn-outline-secondary ">Cancel</button>
                                        </div>
                                    </form>
                                    <table class="table">
                                        <tr>
                                            <th class="rollno_col" scope="col">Assessment</th>
                                            <th class="name_col" scope="col">Units</th>
                                            <th class="actions_col" scope="col">Actions</th>
                                        </tr>
                                        <tbody>
                                        <?php
                                        foreach($assessments as $assessment){
                                        ?>
                                        <tr class="record_row record_">
                                            <td>{{$assessment->detail}}</td>
                                            <td>{{$assessment->units_required}}</td>
                                            <td>
                                                <a id="delete_assessment_{{$assessment->id}}" class="delete_assessment btn tiny-action-btn" href="#" title="Remove Assessment"><i class="fas fa-trash"></i> Delete</a>
                                            </td>
                                        </tr>
                                        <?php
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- EDIT EVIDENCE --}}
                    <div id="modal_edit_evidence_action" class="modal modal_edit_evidence_action" tabindex="-1" role="dialog">
                        <div class="edit-evidence-modal-dialog modal_edit_evidence_dialog" role="document">
                            <div class="modal-content" style="padding: 0 20px;">
                                <div class="modal-body">
                                    <h3>Edit Evidence <a href="#" title="close dialog" id="close_edit_evidence_dialog" style="float: right;margin: 5px 10px;"><i class="fa fa-close"></i></a></h3>
                                </div>
                                <div class="modal-footer">
                                    <form id="edit_evidence_form" action="{{url('/courses/edit/')}}/{{$course_id}}" method="POST">
                                        {{ csrf_field() }}
                                        <div class="col-md-12 no-padding">
                                            <div class="col-md-12 no-padding">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <small class="text-danger error_msg" id="edit_parent_unit_errors"></small>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        Unit Number
                                                        <input type="text" id="edit_unit_number" name="edit_unit_number" class="form-control lb-lg"/>
                                                        <small class="text-danger error_msg" id="edit_unit_number_errors"></small>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        Unit Name
                                                        <input type="text" id="edit_unit_name" name="edit_unit_name" class="form-control lb-lg"/>
                                                        <small class="text-danger error_msg" id="edit_unit_name_errors"></small>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        Evidence Description
                                                        <textarea style="min-height: 60px;" id="edit_evidence_description" name="edit_evidence_description" class="form-control lb-lg"></textarea>
                                                        <small class="text-danger error_msg" id="edit_evidence_description_errors"></small>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        Evidence Documents Required
                                                        <input class="form-control lb-lg" type="number" id="edit_evidence_documents_required" name="edit_evidence_documents_required" />
                                                        <small class="text-danger error_msg" id="edit_evidence_documents_required_errors"></small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" id="method" name="method" value="edit_evidence" />
                                        <input type="hidden" id="edit_evidence_id" name="edit_evidence_id" value="" />
                                        <input type="hidden" id="edit_evidence_course_id" name="edit_evidence_course_id" value="{{$course_id}}" />
                                        <div class="col-md-12">
                                            <hr/>
                                            <input class="btn btn-primary" type="submit" id="confirm_edit_evidence_btn" name="confirm_edit_evidence_btn" value="Update Evidence" />
                                            <button type="button" id="cancelled_confirm_edit_evidence_btn" class="btn btn-outline-secondary ">Cancel</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="modal_delete_evidence_action" class="modal modal_delete_evidence_action" tabindex="-1" role="dialog">
                        <div class="delete-evidence-modal-dialog modal_delete_evidence_dialog" role="document">
                            <div class="modal-content align-items-center">
                                <div class="modal-body">
                                    <h3>Confirm Evidence Removal? <a href="#" title="close dialog" id="close_delete_evidence_dialog" style="float: right;margin: 0 10px;"><i class="fa fa-close"></i></a></h3>
                                        <p>This action cannot be undone.</p>
                                </div>
                                <div class="modal-footer">
                                    <form id="del_selected_form" action="{{url('/courses/edit/')}}/{{$course_id}}" method="POST">
                                        {{ method_field('delete') }}
                                        {{ csrf_field() }}
                                        <input type="hidden" id="delete_evidence_id" name="delete_evidence_id" value="" />
                                        <input type="hidden" id="method" name="method" value="delete_evidence" />
                                        <input class="btn btn-outline-secondary " type="submit" id="confirmed_evidence_delete" name="confirmed_evidence_delete" value="Delete" />
                                        <button type="button" id="cancelled_evidence_delete" class="btn btn-outline-secondary ">Cancel</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="modal_delete_assessment_action" class="modal modal_delete_assessment_action" tabindex="-1" role="dialog">
                        <div class="delete-assessment-modal-dialog modal_delete_assessment_dialog" role="document">
                            <div class="modal-content align-items-center">
                                <div class="modal-body">
                                    <h3>Confirm assessment Removal? <a href="#" title="close dialog" id="close_delete_assessment_dialog" style="float: right;margin: 0 10px;"><i class="fa fa-close"></i></a></h3>
                                    <p>This action cannot be undone.</p>
                                </div>
                                <div class="modal-footer">
                                    <form id="del_selected_form" action="{{url('/courses/edit/')}}/{{$course_id}}" method="POST">
                                        {{ method_field('delete') }}
                                        {{ csrf_field() }}
                                        <input type="hidden" id="delete_assessment_id" name="delete_assessment_id" value="" />
                                        <input type="hidden" id="method" name="method" value="delete_assessment" />
                                        <input class="btn btn-outline-secondary " type="submit" id="confirmed_assessment_delete" name="confirmed_assessment_delete" value="Delete" />
                                        <button type="button" id="cancelled_assessment_delete" class="btn btn-outline-secondary ">Cancel</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{--feedback modal--}}
                    <div id="modal_edit_feedback_action" class="modal modal_edit_feedback_action" tabindex="-1" role="dialog">
                        <div class="edit-feedback-modal-dialog modal_edit_feedback_dialog" role="document">
                            <div class="modal-content align-items-center" style="padding: 0 20px;">
                                <div class="modal-body">
                                    <h3>Edit Feedback Template <a href="#" title="close dialog" id="close_edit_feedback_dialog" style="float: right;margin: 0 10px;"><i class="fa fa-close"></i></a></h3>
                                </div>
                                <div class="modal-footer">
                                    <form id="edit_feedback_form" action="{{url('/courses/edit/')}}/{{$course_id}}" method="POST">
                                        {{ csrf_field() }}
                                        <div class="col-md-12 no-padding">
                                            <div class="col-md-12 no-padding">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        Assignment Number
                                                        <input class="form-control lb-lg"  id="edit_assignment_number" name="edit_assignment_number" />
                                                        <small class="text-danger error_msg" id="edit_assignment_number_errors"></small>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        Comments
                                                        <textarea style="min-height: 100px;" id="edit_comments" name="edit_comments" class="form-control lb-lg"></textarea>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        Further Actions (Pass)
                                                        <textarea class="form-control lb-lg"  id="edit_further_actions" name="edit_further_actions" ></textarea>
                                                        <small class="text-danger error_msg" id="edit_further_actions_errors"></small>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        Further Actions (Refer)
                                                        <textarea class="form-control lb-lg"  id="edit_further_actions_refer" name="edit_further_actions_refer"></textarea>
                                                        <small class="text-danger error_msg" id="edit_further_actions_refer_errors"></small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" id="method" name="method" value="edit_feedback" />
                                        <input type="hidden" id="edit_feedback_id" name="edit_feedback_id" value="" />
                                        <input type="hidden" id="edit_feedback_course_id" name="edit_feedback_course_id" value="{{$course_id}}" />
                                        <div class="col-md-12">
                                            <hr/>
                                            <input class="btn btn-primary" type="submit" id="confirmed_edit_feedback" name="confirmed_edit_feedback" value="Edit Template" />
                                            <button type="button" id="cancelled_edit_feedback" class="btn btn-outline-secondary ">Cancel</button>
                                        </div>
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
                                    <form id="add_canned_response_form" action="{{url('/courses/edit/')}}/{{$course_id}}" method="POST">
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
                                        <input type="hidden" id="canned_response_course_id" name="canned_response_course_id" value="{{$course_id}}" />
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

                    {{--edit canned_response modal--}}
                    <div id="modal_edit_canned_response_action" class="modal modal_edit_canned_response_action" tabindex="-1" role="dialog">
                        <div class="edit-canned-response-modal-dialog modal_edit_canned_response_dialog" role="document">
                            <div class="modal-content" style="padding: 0 20px;">
                                <div class="modal-body">
                                    <h3>Add Canned Response Template <a href="#" title="close dialog" id="close_edit_canned_response_dialog" style="float: right;margin: 0 10px;"><i class="fa fa-close"></i></a></h3>
                                </div>
                                <div class="modal-footer">
                                    <form id="edit_canned_response_form" action="{{url('/courses/edit/')}}/{{$course_id}}" method="POST">
                                        {{ csrf_field() }}
                                        <div class="col-md-12 no-padding">
                                            <div class="col-md-12 no-padding">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        Comments
                                                        <textarea style="min-height: 100px;" id="edit_canned_comments" name="edit_canned_comments" class="form-control lb-lg"></textarea>
                                                        <small class="text-danger error_msg" id="edit_canned_comments_errors"></small>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        Type
                                                        <select class="form-control lb-lg"  id="edit_canned_type" name="edit_canned_type">
                                                            <option value="normal">Normal</option>
                                                            <option value="evidence">Evidence</option>
                                                        </select>
                                                        <small class="text-danger error_msg" id="edit_canned_type_errors"></small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" id="method" name="method" value="edit_canned_response" />
                                        <input type="hidden" id="edit_canned_id" name="edit_canned_id" value="{{$course_id}}" />
                                        <div class="col-md-12">
                                            <hr/>
                                            <input class="btn btn-primary" type="submit" id="confirmed_edit_canned_response" name="confirmed_edit_canned_response" value="Update Template" />
                                            <button type="button" id="cancelled_edit_canned_response" class="btn btn-outline-secondary ">Cancel</button>
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
                                    <h3>Confirm Course Removal? <a href="#" title="close dialog" id="close_delete_dialog" style="float: right;margin: 0 10px;"><i class="fa fa-close"></i></a></h3>
                                    <p>This action cannot be undone.</p>
                                </div>
                                <div class="modal-footer">
                                    <form id="del_selected_form" action="{{url('/courses/list/')}}/{{$course_id}}" method="POST">
                                        {{ method_field('delete') }}
                                        {{ csrf_field() }}
                                        <input type="hidden" id="id" name="id" value="" />
                                        <input class="btn btn-outline-secondary " type="submit" id="confirmed_delete" name="confirmed_delete" value="Delete" />
                                        <button type="button" id="cancelled_delete" class="btn btn-outline-secondary ">Cancel</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{--Delete Confirmation Modal--}}
                    <div id="modal_delete_feedback_action" class="modal modal_delete_feedback_action" tabindex="-1" role="dialog">
                        <div class="delete-feedback-modal-dialog modal_delete_feedback_dialog" role="document">
                            <div class="modal-content align-items-center">
                                <div class="modal-body">
                                    <h3>Confirm Remove Feedback Template ? <a href="#" title="close dialog" id="close_delete_feedback_dialog" style="float: right;margin: 0 10px;"><i class="fa fa-close"></i></a></h3>
                                        <p>This action cannot be undone.</p>
                                </div>
                                <div class="modal-footer">
                                    <form id="del_selected_form" action="{{url('/courses/edit/')}}/{{$course_id}}" method="POST">
                                        {{ method_field('delete') }}
                                        {{ csrf_field() }}
                                        <input type="hidden" id="delete_feedback_id" name="delete_feedback_id" value="" />
                                        <input type="hidden" id="method" name="method" value="delete_feedback" />
                                        <input class="btn btn-outline-secondary " type="submit" id="confirmed_delete_feedback" name="confirmed_delete_feedback" value="Delete" />
                                        <button type="button" id="cancelled_delete_feedback" class="btn btn-outline-secondary ">Cancel</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{--Delete Confirmation Modal--}}
                    <div id="modal_delete_canned_action" class="modal modal_delete_canned_action" tabindex="-1" role="dialog">
                        <div class="delete-canned-modal-dialog modal_delete_canned_dialog" role="document">
                            <div class="modal-content align-items-center">
                                <div class="modal-body">
                                    <h3>Confirm Remove Canned Response Template? <a href="#" title="close dialog" id="close_delete_canned_dialog" style="float: right;margin: 0 10px;"><i class="fa fa-close"></i></a></h3>
                                    <p>This action cannot be undone.</p>
                                </div>
                                <div class="modal-footer">
                                    <form id="del_selected_form" action="{{url('/courses/edit/')}}/{{$course_id}}" method="POST">
                                        {{ method_field('delete') }}
                                        {{ csrf_field() }}
                                        <input type="hidden" id="delete_canned_id" name="delete_canned_id" value="" />
                                        <input type="hidden" id="method" name="method" value="delete_canned" />
                                        <input class="btn btn-outline-secondary " type="submit" id="confirmed_delete_canned" name="confirmed_delete_canned" value="Delete" />
                                        <button type="button" id="cancelled_delete_canned" class="btn btn-outline-secondary ">Cancel</button>
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

        $("#unit_id").on("change", function (e) {
            console.log("Cancelling course");
            $('.unit_items').hide();
            $('#unit_items_'+$(this).val()).show();
            $('input[name="units_selection"]').each(function() {
                this.checked = false;
            });
        });

        $("#parent_unit").on("change", function (e) {
            console.log("Cancelling course");
            $('.child_sub_units').hide();
            $('#child_sub_unit_'+$(this).val()).show();
        });

        $("#cancelled_feedback").on("click", function (e) {
            console.log("Cancelling course");
            $(".modal_feedback_action").hide();
        });

        $("#cancelled_new_evidence_btn").on("click", function (e) {
            console.log("Cancelling course");
            $(".modal_new_evidence_action").hide();
        });

        $("#close_feedback_dialog").on("click", function (e) {
            e.preventDefault();
            console.log("Cancelling course");
            $(".modal_feedback_action").hide();
        });

        $("#close_new_evidence_dialog").on("click", function (e) {
            e.preventDefault();
            $(".modal_new_evidence_action").hide();
        });

        $("#close_new_assessment_dialog").on("click", function (e) {
            e.preventDefault();
            $(".modal_new_assessment_action").hide();
        });

        $("#cancelled_new_assessment_btn").on("click", function (e) {
            console.log("Cancelling evidence");
            $(".modal_new_assessment_action").hide();
        });

        $("#cancelled_evidence").on("click", function (e) {
            console.log("Cancelling evidence");
            $(".modal_evidence_action").hide();
        });

        $("#close_evidence_dialog").on("click", function (e) {
            e.preventDefault();
            console.log("Cancelling evidence");
            $(".modal_evidence_action").hide();
        });

        $("#close_delete_evidence_dialog").on("click", function (e) {
            console.log("Cancelling evidence");
            $(".modal_delete_evidence_action").hide();
        });
        $("#cancelled_evidence_delete").on("click", function (e) {
            e.preventDefault();
            console.log("Cancelling evidence");
            $(".modal_delete_evidence_action").hide();
        });
        $("#close_delete_assessment_dialog").on("click", function (e) {
            console.log("Cancelling assessment");
            $(".modal_delete_assessment_action").hide();
        });
        $("#cancelled_assessment_delete").on("click", function (e) {
            e.preventDefault();
            console.log("Cancelling assessment");
            $(".modal_delete_assessment_action").hide();
        });

        $("#cancelled_confirm_edit_evidence_btn").on("click", function (e) {
            e.preventDefault();
            console.log("Cancelling evidence");
            $(".modal_edit_evidence_action").hide();
        });

        $("#cancelled_edit_canned_response").on("click", function (e) {
            console.log("Cancelling course");
            $(".modal_edit_canned_response_action").hide();
        });

        $("#close_edit_canned_response_dialog").on("click", function (e) {
            e.preventDefault();
            console.log("Cancelling course");
            $(".modal_edit_canned_response_action").hide();
        });

        $("#cancelled_delete_feedback").on("click", function (e) {
            console.log("Cancelling course");
            $(".modal_delete_feedback_action").hide();
        });

        $("#close_delete_feedback_dialog").on("click", function (e) {
            e.preventDefault();
            console.log("Cancelling course");
            $(".modal_delete_feedback_action").hide();
        });

        $("#cancelled_delete_canned").on("click", function (e) {
            console.log("Cancelling canned");
            $(".modal_delete_canned_action").hide();
        });

        $("#close_delete_canned_dialog").on("click", function (e) {
            e.preventDefault();
            console.log("Cancelling canned");
            $(".modal_delete_canned_action").hide();
        });

        $("#close_edit_feedback_dialog").on("click", function (e) {
            e.preventDefault();
            console.log("Cancelling feedback");
            $(".modal_edit_feedback_action").hide();
        });

        $("#cancelled_delete").on("click", function (e) {
            console.log("Cancelling delete");
            $(".modal_delete_action").hide();
        });
        $("#cancelled_edit_feedback").on("click", function (e) {
            console.log("Cancelling cancelled_edit_feedback");
            $(".modal_edit_feedback_action").hide();
        });
        $("#cancelled_canned_response").on("click", function (e) {
            console.log("Cancelling delete");
            $(".modal_canned_response_action").hide();
        });

        $("#close_delete_dialog").on("click", function (e) {
            e.preventDefault();
            console.log("Cancelling delete");
            $(".modal_delete_action").hide();
        });
        $("#close_canned_response_dialog").on("click", function (e) {
            e.preventDefault();
            console.log("Cancelling delete");
            $(".modal_canned_response_action").hide();
        });

        $("#close_course_edit_dialog").on("click", function (e) {
            e.preventDefault();
            console.log("Cancelling course edit");
            $(".modal_course_edit_action").hide();
        });

        $("#new_evidence_dialog_btn").on("click", function (e) {
            e.preventDefault();
            $(".modal_new_evidence_action").show();
        });
        $("#evidence_assessment_btn").on("click", function (e) {
            e.preventDefault();
            $(".modal_new_assessment_action").show();
        });

        $(".delete_evidence").on("click", function (e) {
            e.preventDefault();
            console.log("Processing Del Request:"+this.id);
            var str = this.id;
            var id = str.split(/[\s_]+/);
            console.log("SPLITTED:" + id[2]);
            $("#delete_evidence_id").val(id[2]);
            $(".modal_delete_evidence_action").show();
        });

        $(".delete_assessment").on("click", function (e) {
            e.preventDefault();
            console.log("Processing Del Request:"+this.id);
            var str = this.id;
            var id = str.split(/[\s_]+/);
            console.log("SPLITTED:" + id[2]);
            $("#delete_assessment_id").val(id[2]);
            $(".modal_delete_assessment_action").show();
        });

        $("#close_edit_evidence_dialog").on("click", function (e) {
            e.preventDefault();
            console.log("Cancelling course edit");
            $(".modal_edit_evidence_action").hide();
        });
        $("#cancelled_edit_evidence_btn").on("click", function (e) {
            e.preventDefault();
            console.log("Cancelling course edit");
            $(".modal_edit_evidence_action").hide();
        });

        $(".edit_evidence_btn").on("click", function (e) {
            $(".modal_edit_evidence_action").show();
            console.log("Processing Del Request:"+this.id);
            var str = this.id;
            var id = str.split(/[\s_]+/);
            console.log("SPLITTED:" + id[2]);
            $("#edit_evidence_id").val(id[2]);
            //perform ajax call to get selected user data for modal dialog to be updated
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-XSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var formdata = new FormData($("#edit_evidence_form")[0]);
            console.log("formdata");
            console.log(formdata);
            $.ajax({
                url: '{{ url('/get-evidence-by-id-ajax') }}',
                type: 'get',
                data:'edit_evidence_id='+id[2],
                processData: false,
                contentType: false,
                success: function (response) {
                    //set values to edit tutor dialog fields
                    //$("#edit_parent_unit").val(response[0]['unit_parent']);
                    $("#edit_unit_number").val(response[0]['unit_number']);
                    $("#edit_unit_name").val(response[0]['unit_name']);
                    $("#edit_evidence_description").val(response[0]['evidence_description']);
                    $("#edit_evidence_documents_required").val(response[0]['evidence_documents_required']);
                },
                error: function (data) {
                    console.log(data);
                    console.log('scroll error'+error_scroll);
                    $('#'+error_scroll).focus();
                }
            });
        });

        $("#confirm_edit_evidence_btn").click(function (e) {
            var error_scroll = '';
            //min length
            if ($('#edit_unit_number').val().length <= 0) {
                $('#edit_unit_number_errors').text('Please provide unit number');
                return false;
            } else {
                $('#edit_unit_number_errors').text('');
            }

            if ($('#edit_unit_name').val().length <= 0) {
                $('#edit_unit_name_errors').text('Please provide unit name');
                return false;
            } else {
                $('#edit_unit_name_errors').text('');
            }

            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-XSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var formdata = new FormData($("#edit_evidence_form")[0]);
            console.log("formdata");
            console.log(formdata);

            $.ajax({
                url: '{{ url('/courses/edit/').'/'.$course_id }}',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (response) {
                    $('#success-alert').html('<h3>Evidence Updated Successfully</h3>');
                    $("#confirm_edit_evidence_btn").attr('disabled',true);
                    $('#success-alert').focus();
                    $("#success-alert").fadeTo(2000, 500).slideUp(500, function () {
                        $("#success-alert").css("height", "0px");
                        $("#success-alert").css("display", "block");
                        var page = '<?php echo url("/")?>'+'/courses/edit/<?php echo $course_id;?>';
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

        $("#new_assessment_btn").click(function (e) {
            var error_scroll = '';
            //min length
            if ($('#unit_id').val().length <= 0) {
                $('#unit_id_errors').text('Please select a unit');
                return false;
            } else {
                $('#unit_id_errors').text('');
            }

            var units_selected = '';
            $('input[name="units_selection"]:checked').each(function() {
                console.log('values:'+this.value);
                    units_selected += this.value+',';
            });
            $('#selected_units').val(units_selected);

            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-XSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var formdata = new FormData($("#new_assessment_form")[0]);
            console.log("formdata");
            console.log(formdata);

            $.ajax({
                url: '{{ url('/courses/edit/').'/'.$course_id }}',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (response) {
                    $('#success-alert').html('<h3>Assessment Added Successfully</h3>');
                    $("#new_assessment_btn").attr('disabled',true);

                    $('#success-alert').focus();
                    $("#success-alert").fadeTo(2000, 500).slideUp(500, function () {
                        $("#success-alert").css("height", "0px");
                        $("#success-alert").css("display", "block");
                        var page = '<?php echo url("/")?>'+'/courses/edit/<?php echo $course_id;?>';
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

        $("#edit_cancelled_course").on("click", function (e) {
            e.preventDefault();
            console.log("Cancelling course edit");
            $(".modal_course_edit_action").hide();
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

        $(".delete_feedback_action").on("click", function (e) {
            e.preventDefault();
            $("#modal_delete_feedback_action").css('display','block');
            $("#modal_delete_feedback_action").css({ top: '0%' });
            console.log("Processing Del Request:"+this.id);
            var str = this.id;
            var ids = str.split(/[\s_]+/);
            console.log("SPLITTED:" + ids[4]);
            $("#delete_feedback_id").val(ids[4]);
        });

        $(".delete_canned_action").on("click", function (e) {
            e.preventDefault();
            $("#modal_delete_canned_action").css('display','block');
            $("#modal_delete_canned_action").css({ top: '0%' });
            console.log("Processing Del Request:"+this.id);
            var str = this.id;
            var ids = str.split(/[\s_]+/);
            console.log("SPLITTED:" + ids[4]);
            $("#delete_canned_id").val(ids[4]);
        });

        $(".edit_feedback_action").on("click", function (e) {
                console.log("Processing edit Request:"+this.id);
                var str = this.id;
                var id = str.split(/[\s_]+/);
                console.log("SPLITTED:" + id[4]);
                $("#edit_feedback_id").val(id[4]);
                //perform ajax call to get selected user data for modal dialog to be updated
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-XSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: '{{ url('/get-feedback-by-id-ajax') }}',
                    type: 'get',
                    data:'edit_feedback_id='+id[4]+'&method=edit_feedback_template',
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        console.log(response);
                        //set values to edit tutor dialog fields
                        $("#edit_assignment_number").val(response[0]['assignment_number']);
                        $("#edit_comments").val(response[0]['comments']);
                        $("#edit_grades_awarded").val(response[0]['grades_awarded']);
                        $("#edit_further_actions").val(response[0]['further_actions']);
                        $("#edit_further_actions_refer").val(response[0]['further_actions_refer']);
                    },
                    error: function (data) {
                        console.log(data);
                        console.log('scroll error'+error_scroll);
                        $('#'+error_scroll).focus();
                    }
                });

                //process feedback request
                $("#modal_edit_feedback_action").css('display','block');
                $("#modal_edit_feedback_action").css({ top: '0%' });
            });

        $(".edit_canned_action").on("click", function (e) {
            console.log("Processing edit Request:"+this.id);
            var str = this.id;
            var id = str.split(/[\s_]+/);
            console.log("SPLITTED:" + id[4]);
            $("#edit_canned_id").val(id[4]);
            //perform ajax call to get selected user data for modal dialog to be updated
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-XSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: '{{ url('/get-canned-response-by-id-ajax') }}',
                type: 'get',
                data:'edit_canned_it='+id[4]+'&method=edit_canned_response',
                processData: false,
                contentType: false,
                success: function (response) {
                    console.log(response);
                    //set values to edit tutor dialog fields
                    $("#edit_canned_comments").val(response[0]['comments']);
                    $("#edit_canned_type").val(response[0]['type']);
                },
                error: function (data) {
                    console.log(data);
                    console.log('scroll error'+error_scroll);
                    $('#'+error_scroll).focus();
                }
            });
            //process feedback request
            $("#modal_edit_canned_response_action").css('display','block');
            $("#modal_edit_canned_response_action").css({ top: '0%' });
        });

        //get anchor id => delete_action_{1} and concatenate it to create modal id
        $("#new_feedback_btn").on("click", function () {
                $("#modal_feedback_action").css('display','block');
                $("#modal_feedback_action").css({ top: '0%' });
        });

        //get anchor id => delete_action_{1} and concatenate it to create modal id
        $("#course_evidence_btn").on("click", function () {
            $("#modal_evidence_action").css('display','block');
            $("#modal_evidence_action").css({ top: '0%' });
        });

        $("#new_canned_response_btn").on("click", function () {
            $("#modal_canned_response_action").css('display','block');
            $("#modal_canned_response_action").css({ top: '0%' });
        });

        //add feedback
        $("#confirmed_feedback").click(function (e) {
            var error_scroll = '';
            if ($('#assignment_number').val().length <= 0) {
                $('#assignment_number_errors').text('Please provide assignment number');
                return false;
            } else {
                $('#assignment_number_errors').text('');
            }

            if ($('#comments').val().length <= 0) {
                $('#comments_errors').text('Please provide comments about the feedback');
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

            var formdata = new FormData($("#add_feedback_form")[0]);
            console.log("formdata");
            console.log(formdata);
            $.ajax({
                url: '{{ url('/courses/edit/').'/'.$course_id }}',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (response) {
                    $('#success-alert').html('<h3>Feedback Template Added Successfully</h3>');
                    $("#confirmed_feedback").attr('disabled',true);
                    $('#success-alert').focus();
                    $("#success-alert").fadeTo(2000, 500).slideUp(500, function () {
                        $("#success-alert").css("height", "0px");
                        $("#success-alert").css("display", "block");
                        var page = '<?php echo url("/")?>'+'/courses/edit/<?php echo $course_id?>';
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

        //add feedback
        $("#new_evidence_btn").click(function (e) {
            var error_scroll = '';
            if ($('#unit_number').val().length <= 0) {
                $('#unit_number_errors').text('Please provide unit number');
                return false;
            } else {
                $('#unit_number_errors').text('');
            }
            if ($('#unit_name').val().length <= 0) {
                $('#unit_name_errors').text('Please provide unit name');
                return false;
            } else {
                $('#unit_name_errors').text('');
            }

            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-XSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var formdata = new FormData($("#new_evidence_form")[0]);
            console.log("formdata");
            console.log(formdata);

            $.ajax({
                url: '{{ url('/courses/edit/').'/'.$course_id }}',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (response) {
                    $('#success-alert').html('<h3>Evidence Added Successfully</h3>');
                    $("#new_evidence_btn").attr('disabled',true);
                    $('#success-alert').focus();
                    $("#success-alert").fadeTo(2000, 500).slideUp(500, function () {
                        $("#success-alert").css("height", "0px");
                        $("#success-alert").css("display", "block");
                        var page = '<?php echo url("/")?>'+'/courses/edit/<?php echo $course_id?>';
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

        //add feedback
        $("#confirmed_edit_feedback").click(function (e) {
            var error_scroll = '';
            if ($('#edit_assignment_number').val().length <= 0) {
                $('#edit_assignment_number_errors').text('Please provide assignment number');
                return false;
            } else {
                $('#edit_assignment_number_errors').text('');
            }

            if ($('#edit_comments').val().length <= 0) {
                $('#edit_comments_errors').text('Please provide comments about the feedback');
                return false;
            } else {
                $('#edit_comments_errors').text('');
            }

            if ($('#edit_further_actions').val().length <= 0) {
                $('#edit_further_actions_errors').text('This field is required');
                return false;
            } else {
                $('#edit_further_actions_errors').text('');
            }

            if ($('#edit_further_actions_refer').val().length <= 0) {
                $('#edit_further_actions_refer_errors').text('This field is required');
                return false;
            } else {
                $('#edit_further_actions_refer_errors').text('');
            }

            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-XSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var formdata = new FormData($("#edit_feedback_form")[0]);
            console.log("formdata");
            console.log(formdata);

            $.ajax({
                url: '{{ url('/courses/edit/').'/'.$course_id }}',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (response) {
                    $('#success-alert').html('<h3>Feedback Template Updated Successfully</h3>');
                    $("#confirmed_edit_feedback").attr('disabled',true);
                    $('#success-alert').focus();
                    $("#success-alert").fadeTo(2000, 500).slideUp(500, function () {
                        $("#success-alert").css("height", "0px");
                        $("#success-alert").css("display", "block");
                        var page = '<?php echo url("/")?>'+'/courses/edit/<?php echo $course_id?>';
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

        $("#confirmed_canned_response").click(function (e) {
            var error_scroll = '';
            if ($('#comments').innerHTML.length <= 0) {
                $('#comments_errors').text('Please provide some comments');
                return false;
            } else {
                $('#comments_errors').text('');
            }
            if ($('#type').val().length <= 0) {
                $('#type_errors').text('Please provide type');
                return false;
            } else {
                $('#type_errors').text('');
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
                url: '{{ url('/courses/edit/').'/'.$course_id }}',
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
                        var page = '<?php echo url("/")?>'+'/courses/edit/<?php echo $course_id?>';
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

        //edit canned response
        $("#confirmed_edit_canned_response").click(function (e) {
            var error_scroll = '';
            if ($('#edit_canned_comments').innerHTML.length <= 0) {
                $('#edit_canned_comments_errors').text('Please provide some comments');
                return false;
            } else {
                $('#edit_canned_comments_errors').text('');
            }
            if ($('#edit_canned_type').val().length <= 0) {
                $('#edit_canned_type_errors').text('Please provide type');
                return false;
            } else {
                $('#edit_canned_type_errors').text('');
            }

            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-XSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var formdata = new FormData($("#edit_canned_response_form")[0]);
            console.log("formdata");
            console.log(formdata);

            $.ajax({
                url: '{{ url('/courses/edit/').'/'.$course_id }}',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (response) {
                    $('#success-alert').html('<h3>Canned Response Template Updated Successfully</h3>');
                    $("#confirmed_edit_canned_response").attr('disabled',true);
                    $('#success-alert').focus();
                    $("#success-alert").fadeTo(2000, 500).slideUp(500, function () {
                        $("#success-alert").css("height", "0px");
                        $("#success-alert").css("display", "block");
                        var page = '<?php echo url("/")?>'+'/courses/edit/<?php echo $course_id?>';
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

        //edit course
        $("#edit_confirmed_course").click(function (e) {
            var error_scroll = '';
            //min length
            if ($('#edit_course_name').val().length <= 0) {
                $('#edit_course_name_errors').text('Please provide course name');
                return false;
            } else {
                $('#edit_course_name_errors').text('');
            }

            if ($('#edit_full_price').val().length <= 0) {
                $('#edit_full_price_errors').text('Please provide full price');
                return false;
            } else {
                $('#edit_full_price_errors').text('');
            }

            if ($('#edit_course_deposit').val().length <= 0) {
                $('#edit_course_deposit_errors').text('Please provide course deposit price');
                return false;
            } else {
                $('#edit_course_deposit_errors').text('');
            }

            if ($('#edit_instalment_price').val().length <= 0) {
                $('#edit_instalment_price_errors').text('Please provide course instalment price');
                return false;
            } else {
                $('#edit_instalment_price_errors').text('');
            }

            if ($('#edit_support_price').val().length <= 0) {
                $('#edit_support_price_errors').text('Please provide course support price');
                return false;
            } else {
                $('#edit_support_price_errors').text('');
            }

            if ($('#edit_sale_price').val().length <= 0) {
                $('#edit_sale_price_errors').text('Please provide course sale price');
                return false;
            } else {
                $('#edit_sale_price_errors').text('');
            }

            if ($('#edit_number_of_assignments').val().length <= 0) {
                $('#edit_number_of_assignments_errors').text('Please provide a value for course assignments');
                return false;
            } else {
                $('#edit_number_of_assignments_errors').text('');
            }

            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-XSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var formdata = new FormData($("#edit_course_form")[0]);
            console.log("formdata");
            console.log(formdata);

            $.ajax({
                url: '{{ url('/courses/edit/').'/'.$course_id }}',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (response) {
                    $('#success-alert').html('<h3>Course Updated Successfully</h3>');
                    $("#confirmed_edit_course").attr('disabled',true);
                    $('#success-alert').focus();
                    $("#success-alert").fadeTo(2000, 500).slideUp(500, function () {
                        $("#success-alert").css("height", "0px");
                        $("#success-alert").css("display", "block");
                        var page = '<?php echo url("/")?>'+'/courses/edit/<?php echo $course_id?>';
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