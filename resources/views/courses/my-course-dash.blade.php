@extends('layouts.my-course-dash')
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
                            <h3>
                                <a class="btn btn-outline-secondary" href="{{url('/my-courses/list/1')}}" title="Back to Course"><i class="fas fa-chevron-left"></i> Back to My Courses</a>
                                <a href="#" id="contact_tutor" title="Contact Tutor" class="float-right btn btn-outline-secondary "><i class="fas fa-envelope"></i> Contact Tutor</a>
                                <a href="{{url('/course/'.$my_course->course_id.'/reader/1')}}" style="margin-right:15px;" class="btn btn-outline-secondary float-right"><i class="fas fa-book"></i> Course Materials</a>
                                <?php
                                if($course->type==='work_based'){
                                ?>
                                <a style="margin-right:15px;" href="#" id="upload_evidence_btn" title="Evidence Work" class="float-right btn btn-outline-secondary "><i class="fas fa-file-word"></i> Submit Evidence Work</a>
                                <?php
                                }
                                if($course->type==='standard'){
                                    if($awaiting_feedback>0){
                                        ?>
                                         <a style="margin-right:15px;" href="#" id="upload_assignment_btn" title="Upload Assignment #" class="float-right btn btn-danger "><i class="fas fa-file-upload"></i> Awaiting Feedback</a>
                                    <?php
                                    }else{
                                        ?>
                                        <a style="margin-right:15px;" href="#" id="upload_assignment_btn" title="Upload Assignment #" class="float-right btn btn-outline-secondary "><i class="fas fa-file-upload"></i> Submit Assignment #{{$next_assignment}}</a>
                                    <?php
                                    }
                                    ?>
                                <?php
                                }
                                ?>
                            </h3>
                            <hr/>
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
                            <h3>Successfully</h3>
                        </div>
                        <div class="col-12 col-lg-12 col-xl-12 no-padding">
                            <div class="col-md-12 no-padding">
                                <h3 style="padding: 5px;">{{$course_title}}</h3>
                                <div class="meter">
                                    <?php
                                    $course_progress = \App\Http\Controllers\CourseController::getCourseProgress($student_id,$course->id,$course->type);
                                    if($course_progress == '100'){
                                        $class = 'full-width';
                                    }else{
                                        $class = '';
                                    }
                                    ?>
                                    <span class="{{$class}}" style="width: {{$course_progress}}%;display: block;
                                            color: rgb(37, 37, 37);
                                            font-weight: bold;
                                            border-radius: 25px;"></span>
                                   <div style="position: absolute;top: 4px;color: #049f6a;background: white;border-radius: 100px;padding: 0 10px;height: 20px;line-height: 17px;border: 2px solid #34bb91;">{{$course_progress}}% Complete</div>
                                </div>
                                <h4 style="padding: 5px 0;">My Progress
                                    <span class="float-right" style="    margin-top: -6px;line-height: 20px;"><small style=" line-height: 35px;">Support Expiry: December 8th 2022&nbsp;</small>
                                    <a href="#" class="float-right btn btn-primary" title="Purchase Support">Purchase Support</a>
                                    </span>
                                </h4>
                                <hr style="margin: 15px 0;"/>
                            </div>

                            <div class="col-md-12 no-padding">
                                <div class="panel-group">
                                    <?php
                                    foreach($assessment_parent_units as $evi){
                                    ?>
                                        <div class="panel panel-default">
                                            <div class="panel-body">
                                                {{$evi->unit_number}} - {{$evi->evidence_description}}
                                                <a id="{{$evi->id}}" href="#" style="border-radius: 100% !important;width: 46px;height: 46px;line-height: 40px;" class="float-right toggle_sub_btn btn btn-outline-secondary"><i class="fas fa-chevron-down"></i></a>
                                                <hr/>
                                        <?php
                                        foreach($assessment_children[$evi->unit_number] as $evidence){
                                                if($evi->unit_number === $evidence->unit_parent){
                                                ?>
                                                <div id="sub_items_{{$evi->id}}" style="margin-top: 34px;" class="panel panel-default sub_items_{{$evi->id}}">
                                                    <div class="panel-body">
                                                        {{$evidence->unit_number}} - {{$evidence->evidence_description}}
                                                        <a id="{{$evidence->id}}" href="#" style="border-radius: 100% !important;width: 46px;height: 46px;line-height: 40px;" class="float-right toggle_btn btn btn-outline-secondary"><i class="fas fa-chevron-down"></i></a>
                                                        <hr/>
                                                    <table id="item_{{$evidence->id}}" style="display:none;margin-top: 30px;" class="table">
                                                        <tr>
                                                            <th class="evidence_detail_col" scope="col">Unit Name</th>
                                                            <th class="evidence_file_col" scope="col">Evidence Files</th>
                                                            <th class="evidence_date_col" scope="col">Marking</th>
                                                            <th class="evidence_status_col" scope="col">Status</th>
                                                        </tr>
                                                        <tbody>
                                                <?php
                                                $sub_item = $evidence->unit_number;
                                                foreach($assessment_children[$evi->unit_number] as $evidence){
                                                    if($sub_item === $evidence->unit_parent){
                                                    ?>
                                                    <tr class="record_row record_">
                                                        <td>{{$evidence->unit_number}} - {{$evidence->evidence_description}}</td>
                                                        <td>
                                                            <?php
                                                            $course_evidence_file = \App\Http\Controllers\CourseController::getEvidenceFile($evidence->id);
                                                            foreach($course_evidence_file as $file){
                                                                echo '<a download href="'.url('/public').$file->assignment_file.'" title="Download Evidence"><i class="fas fa-download"></i> Download</a><br>';
                                                            }
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            $marking_dates = \App\Http\Controllers\CourseController::getEvidenceMarkingDate($evidence->id);
                                                            foreach($marking_dates as $marking_date){
                                                                echo date('d-m-Y', strtotime($marking_date->updated_at)).'<br>';
                                                            }
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            $statuses = \App\Http\Controllers\CourseController::getEvidenceStatus($evidence->id);
                                                            foreach($statuses as $status){
                                                                if($status->status === 'pass'){
                                                                    echo '<i style="color:darkseagreen;font-size: 20px;vertical-align: middle;" class="fas fa-check-circle"></i> PASS<br>';

                                                                }
                                                                if($status->status === 'awaiting_feedback'){
                                                                    echo '<i style="color:coral;font-size: 20px;vertical-align: middle;" class="fas fa-clock"></i> Awaiting Feedback<br>';

                                                                }
                                                                if($status->status === 'refer'){
                                                                    echo '<i style="color:silver;font-size: 20px;vertical-align: middle;" class="fas fa-retweet"></i> Retry<br>';
                                                                }
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                    }
                                                }
                                                echo '</tbody></table></div></div>';
                                            }
                                    }
                                    echo '</div></div>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

                    {{--evidence modal--}}
                    <div id="modal_evidence_action" class="modal modal_evidence_action" tabindex="-1" role="dialog">
                        <div class="evidence-modal-dialog modal_evidence_dialog" role="document">
                            <div class="modal-content align-items-center" style="padding: 0 20px;">
                                <div class="modal-body">
                                    <h3>Upload Evidence #1<a href="#" title="close dialog" id="close_evidence_dialog" style="float: right;margin: 0 10px;"><i class="fa fa-close"></i></a></h3>
                                </div>
                                <div class="modal-footer">
                                    <form id="add_evidence_form" action="{{url('/course/')}}/{{$course->id}}/dash" method="POST" enctype="multipart/form-data" >
                                        {{ csrf_field() }}
                                        <div class="col-md-12 no-padding">
                                            <div class="col-md-12 no-padding">
                                                <div class="panel-group">
                                                    <?php
                                                    foreach($assessment_parent_units as $evi){
                                                    ?>
                                                    <div class="panel panel-default">
                                                        <div class="panel-body">
                                                            {{$evi->unit_number}} - {{$evi->evidence_description}}
                                                            <a id="{{$evi->id}}" href="#" style="border-radius: 100% !important;width: 46px;height: 46px;line-height: 40px;" class="float-right toggle_upload_sub_btn btn btn-outline-secondary"><i class="fas fa-chevron-down"></i></a>
                                                            <hr/>
                                                            <?php
                                                            foreach($assessment_children[$evi->unit_number] as $evidence){
                                                            if($evi->unit_number === $evidence->unit_parent){
                                                            ?>
                                                            <div id="upload_sub_items_{{$evi->id}}" style="margin-top: 34px;" class="panel panel-default upload_sub_items_{{$evi->id}}">
                                                                <div class="panel-body">
                                                                    {{$evidence->unit_number}} - {{$evidence->evidence_description}}
                                                                    <a id="{{$evidence->id}}" href="#" style="border-radius: 100% !important;width: 46px;height: 46px;line-height: 40px;" class="float-right toggle_upload_btn btn btn-outline-secondary"><i class="fas fa-chevron-down"></i></a>
                                                                    <hr/>
                                                                    <table id="upload_item_{{$evidence->id}}" style="display:none;margin-top: 30px;" class="table">
                                                                        <tr>
                                                                            <th class="name_col" scope="col">Unit #</th>
                                                                            <th class="name_col" scope="col">Detail</th>
                                                                            <th class="actions_col" scope="col">Check for Marking</th>
                                                                        </tr>
                                                                        <tbody>
                                                                        <?php
                                                                        $sub_item = $evidence->unit_number;
                                                                        foreach($assessment_children[$evi->unit_number] as $evidence){
                                                                        if($sub_item === $evidence->unit_parent){
                                                                        ?>
                                                                        <tr class="record_row record_">
                                                                            <td>{{$evidence->unit_number}}</td>
                                                                            <td>{{$evidence->evidence_description}}</td>
                                                                            <td><input type="checkbox" id="{{$evidence->id}}" name="upload_units_selection" class="upload_units_selection"/></td>
                                                                        </tr>
                                                                    <?php
                                                                    }
                                                                    }
                                                                    echo '</tbody></table></div></div>';
                                                                    }
                                                                    }
                                                                    echo '</div></div>';
                                                                    }
                                                                    ?>
                                                                </div>
                                                            </div>
                                            <div class="col-md-12 text-left">
                                                <label>Evidence File ( Allowed File Types: jpg, bmp, png, gif, svg, doc, docx )</label>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <input type="file" class=" lb-lg"  id="evidence_file" name="evidence_file" />
                                                </div>
                                            </div>
                                            <div class="col-md-12 text-left">
                                                <small class="text-danger error_msg" id="evidence_file_errors"></small>
                                                <hr/>
                                            </div>
                                        </div>

                                        <input type="hidden" id="method" name="method" value="upload_evidence" />
                                        <input type="hidden" id="selected_units_ids" name="selected_units_ids" value="" />
                                        <div class="col-md-12 no-padding">
                                            <input class="btn btn-primary" type="submit" id="confirmed_evidence" name="confirmed_evidence" value="Upload" />
                                            <button type="button" id="cancelled_evidence" class="btn btn-outline-secondary ">Cancel</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{--assignment modal--}}
                    <div id="modal_assignment_action" class="modal modal_assignment_action" tabindex="-1" role="dialog">
                        <div class="assignment-modal-dialog modal_assignment_dialog" role="document">
                            <div class="modal-content align-items-center" style="padding: 0 20px;">
                                <div class="modal-body">
                                    <h3>Upload Assignment #1<a href="#" title="close dialog" id="close_dialog" style="float: right;margin: 0 10px;"><i class="fa fa-close"></i></a></h3>
                                </div>
                                <div class="modal-footer">
                                    <form id="add_assignment_form" action="{{url('/course/')}}/{{$course->id}}/dash" method="POST" enctype="multipart/form-data" >
                                        {{ csrf_field() }}
                                        <div class="col-md-12 no-padding">
                                            <div class="col-md-12 text-left">
                                                <label>Assignment File ( only docx file type is allowed )</label>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <input type="file" class=" lb-lg"  id="assignment_file" name="assignment_file" />
                                                </div>
                                            </div>
                                            <div class="col-md-12 text-left">
                                                <small class="text-danger error_msg" id="assignment_file_errors"></small>
                                                <hr/>
                                            </div>
                                        </div>
                                        <input type="hidden" id="method" name="method" value="upload_assignment" />
                                        <input type="hidden" id="assignment_number" name="assignment_number" value="{{$next_assignment}}" />
                                        <div class="col-md-12 no-padding">
                                            <input class="btn btn-primary" type="submit" id="confirmed_assignment" name="confirmed_assignment" value="Upload" />
                                            <button type="button" id="cancelled_assignment" class="btn btn-outline-secondary ">Cancel</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
<script>
    (function(){
        $(".meter > span").each(function () {
            $(this)
                .data("origWidth", $(this).width())
                .width(0)
                .animate(
                    {
                        width: $(this).data("origWidth")
                    },
                    1200
                );
        });

        $(".toggle_sub_btn").on("click", function (e) {
            e.preventDefault();
            console.log('this.id:'+this.id);
            if($('#sub_items_'+this.id).css('display') === 'none'){
                $('#'+this.id).html('<i class="fas fa-chevron-down"></i>');
            }else{
                $('#'+this.id).html('<i class="fas fa-chevron-up"></i>');
            }
            $('.sub_items_'+this.id).slideToggle();
        });

        $(".toggle_btn").on("click", function (e) {
            e.preventDefault();
            console.log('this.id:'+this.id);
            if($('#item_'+this.id).css('display') === 'none'){
                $('#'+this.id).html('<i class="fas fa-chevron-down"></i>');
            }else{
                $('#'+this.id).html('<i class="fas fa-chevron-up"></i>');
            }
            $('#item_'+this.id).slideToggle();
        });

        $(".toggle_upload_btn").on("click", function (e) {
            e.preventDefault();
            console.log('this.id:'+this.id);
            if($('#upload_item_'+this.id).css('display') === 'none'){
                $('#'+this.id).html('<i class="fas fa-chevron-down"></i>');
            }else{
                $('#'+this.id).html('<i class="fas fa-chevron-up"></i>');
            }
            $('#upload_item_'+this.id).slideToggle();
        });

        $(".toggle_upload_sub_btn").on("click", function (e) {
            e.preventDefault();
            console.log('this.id:'+this.id);
            if($('#upload_sub_items_'+this.id).css('display') === 'none'){
                $('#'+this.id).html('<i class="fas fa-chevron-down"></i>');
            }else{
                $('#'+this.id).html('<i class="fas fa-chevron-up"></i>');
            }
            $('.upload_sub_items_'+this.id).slideToggle();
        });

        $("#close_dialog").on("click", function (e) {
            e.preventDefault();
            console.log("Cancelling assignment");
            $(".modal_assignment_action").hide();
        });

        $("#cancelled_assignment").on("click", function (e) {
            e.preventDefault();
            console.log("Cancelling assignment");
            $(".modal_assignment_action").hide();
        });

        $("#close_evidence_dialog").on("click", function (e) {
            e.preventDefault();
            console.log("Cancelling evidence");
            $(".modal_evidence_action").hide();
        });

        $("#cancelled_evidence").on("click", function (e) {
            e.preventDefault();
            console.log("Cancelling evidence");
            $(".modal_evidence_action").hide();
        });

        <?php
        if($awaiting_feedback<1){
        ?>
        $("#upload_assignment_btn").on("click", function () {
            //process tutor request
            $("#modal_assignment_action").css('display','block');
            $("#modal_assignment_action").css({ top: '0%' });
        });
        <?php
        }
        ?>

        $("#upload_evidence_btn").on("click", function () {
            //process tutor request
            $("#modal_evidence_action").css('display','block');
            $("#modal_evidence_action").css({ top: '0%' });
        });

        //get all checked checkboxes
        $(".upload_units_selection").on("change", function () {
            $('#selected_units_ids').val('');
            //
            $('input:checkbox.upload_units_selection').each(function () {
                (this.checked ? $('#selected_units_ids').val($('#selected_units_ids').val()+','+$(this).attr("id")) : "");
            });
            console.log('this value:'+$('#selected_units_ids').val());
        });

        //
        $("#confirmed_assignment").click(function (e) {
            var error_scroll = '';
            if ($('#assignment_file').val().length <= 0) {
                $('#assignment_file_errors').text('Please choose an assignment file to upload');
                return false;
            } else {
                $('assignment_file_errors').text('');
            }
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-XSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var formdata = new FormData($("#add_assignment_form")[0]);
            console.log("formdata");
            console.log(formdata);

            $.ajax({
                url: '{{ url('/course/').'/'.$course_id.'/dash' }}',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (response) {
                    $('#success-alert').html('<h3>Assignment Uploaded Successfully</h3>');
                    $("#confirmed_assignment").attr('disabled',true);
                    $('#success-alert').focus();
                    $("#success-alert").fadeTo(2000, 500).slideUp(500, function () {
                        $("#success-alert").css("height", "0px");
                        $("#success-alert").css("display", "block");
                        var page = '<?php echo url("/")?>'+'/course/<?php echo $course_id?>/dash';
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

        $("#confirmed_evidence").click(function (e) {
            var error_scroll = '';
            if ($('#evidence_file').val().length <= 0) {
                $('#evidence_file_errors').text('Please choose an evidence file to upload');
                return false;
            } else {
                $('evidence_file_errors').text('');
            }

            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-XSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var formdata = new FormData($("#add_evidence_form")[0]);
            console.log("formdata");
            console.log(formdata);

            $.ajax({
                url: '{{ url('/course/').'/'.$course_id.'/dash' }}',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (response) {
                    $('#success-alert').html('<h3>Evidence Uploaded Successfully</h3>');
                    $("#confirmed_evidence").attr('disabled',true);
                    $('#success-alert').focus();
                    $("#success-alert").fadeTo(2000, 500).slideUp(500, function () {
                        $("#success-alert").css("height", "0px");
                        $("#success-alert").css("display", "block");
                        var page = '<?php echo url("/")?>'+'/course/<?php echo $course_id?>/dash';
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