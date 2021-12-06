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
                            <h2 class="">Courses <a style="float:right;" href="#" id="new_course_btn" title="Add New Course" class="btn btn-outline-primary ">Add New Course</a></h2>
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
                            <h3>Course added Successfully</h3>
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <th class="rollno_col" scope="col">#</th>
                                    <th class="description_col" scope="col">Course Name</th>
                                    <th class="description_col" scope="col">Actions</th>
                                </tr>
                                <tbody>
                                <?php
                                $index = 1;
                                foreach($courses as $course){
                                ?>
                                <tr class="record_row record_{{$course->id}}">
                                    <td>{{$index}}</td>
                                    <td>{{$course->name}}</td>
                                    <td>
                                        <a class="action_buttons edit_action btn-outline-secondary tiny-action-btn" href="{{url('/courses/edit').'/'.$course->id}}" title="Edit Course in new page"><i class="fas fa-external-link-alt"></i> Edit</a>
                                        <a id="delete_action_{{ $course->id }}" class="action_buttons delete_action btn-outline-secondary tiny-action-btn" href="#" title="Remove Course"><i class="far fa-trash-alt"></i> Remove</a>
                                    </td>
                                </tr>
                                <?php
                                $index++;
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
                                <a class="action_buttons" href="{{url('/courses/')}}/list/{{$page_var-1}}?_token={{ csrf_token() }}" title="Previous"><i class="fas fa-chevron-left"> </i> Previous</a>
                                <?php
                                }
                                ?>
                                <?php
                                //eg: total 5 > current 5
                                if($page_var  < $totalPages){
                                ?>
                                <a class="action_buttons" href="{{url('/courses/')}}/list/{{$page_var+1}}?_token={{ csrf_token() }}" title="Next">Next <i class="fas fa-chevron-right"></i></a>
                                <?php
                                }
                                }
                                ?>
                            </div>

                        </div>

                    </div>

                    {{--Admin modal--}}
                    <div id="modal_course_action" class="modal modal_course_action" tabindex="-1" role="dialog">
                        <div class="course-modal-dialog modal_course_dialog" role="document">
                            <div class="modal-content align-items-center" style="padding: 0 20px;">
                                <div class="modal-body">
                                    <h3>Add Course <a href="#" title="close dialog" id="close_course_dialog" style="float: right;margin: 0 10px;"><i class="fa fa-close"></i></a></h2>
                                </div>
                                <div class="modal-footer">
                                    <form id="add_course_form" action="{{url('/courses/list/')}}/{{$page_var}}" method="POST">
                                        {{ csrf_field() }}
                                        <div class="col-md-12 no-padding">
                                            <div class="col-md-12 no-padding">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        Course Name
                                                        <input class="form-control lb-lg"  id="course_name" name="course_name" />
                                                        <small class="text-danger error_msg" id="course_name_errors"></small>
                                                    </div>

                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                    Description
                                                    <textarea style="min-height: 60px;" id="description" name="description" class="form-control lb-lg"></textarea>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        Full Price
                                                        <input class="form-control lb-lg"  id="full_price" name="full_price" />
                                                        <small class="text-danger error_msg" id="full_price_errors"></small>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        Course Deposit
                                                        <input class="form-control lb-lg"  id="course_deposit" name="course_deposit" />
                                                        <small class="text-danger error_msg" id="course_deposit_errors"></small>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        Course Instalment Price
                                                        <input class="form-control lb-lg"  id="instalment_price" name="instalment_price" />
                                                        <small class="text-danger error_msg" id="instalment_price_errors"></small>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        Course Support Price
                                                        <input class="form-control lb-lg"  id="support_price" name="support_price" />
                                                        <small class="text-danger error_msg" id="support_price_errors"></small>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        Course Sale Price
                                                        <input class="form-control lb-lg"  id="sale_price" name="sale_price" />
                                                        <small class="text-danger error_msg" id="sale_price_errors"></small>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        Number of Assignments
                                                        <input class="form-control lb-lg"  id="number_of_assignments" name="number_of_assignments" />
                                                        <small class="text-danger error_msg" id="number_of_assignments_errors"></small>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        Course Type
                                                        <select class="form-control lb-lg"  id="type" name="type">
                                                            <option value="standard">Standard</option>
                                                            <option value="work_based">Work based qual/QCF</option>
                                                        </select>
                                                        <small class="text-danger error_msg" id="type_errors"></small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <input type="hidden" id="total" name="total" value="{{$total}}" />
                                        <input type="hidden" id="totalPages" name="totalPages" value="{{$totalPages}}" />
                                        <input type="hidden" id="method" name="method" value="new_course" />
                                        <input type="hidden" id="page_var" name="page_var" value="{{$page_var}}" />
                                        <div class="col-md-12">
                                            <hr/>
                                            <input class="btn btn-primary" type="submit" id="confirmed_course" name="confirmed_course" value="Create Course" />
                                            <button type="button" id="cancelled_course" class="btn btn-outline-secondary ">Cancel</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{--Edit Admin modal--}}
                    <div id="modal_course_edit_action" class="modal modal_course_edit_action" tabindex="-1" role="dialog">
                        <div class="edit-course-modal-dialog modal_course_edit_dialog" role="document">
                            <div class="modal-content align-items-center" style="padding: 0 20px;">
                                <div class="modal-body">
                                    <h3>Updating Course <a href="#" title="close dialog" id="close_course_edit_dialog" style="float: right;margin: 0 10px;"><i class="fa fa-close"></i></a></h3>
                                </div>
                                <div class="modal-footer">
                                    <form id="edit_course_form" action="{{url('/courses/list/')}}/{{$page_var}}" method="POST">
                                        {{ csrf_field() }}
                                        <div class="col-md-12 no-padding">
                                            <div class="col-md-12 no-padding">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        Course Name
                                                        <input class="form-control lb-lg"  id="edit_course_name" name="edit_course_name" />
                                                        <small class="text-danger error_msg" id="edit_course_name_errors"></small>
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
                                                        Course Deposit
                                                        <input class="form-control lb-lg"  id="edit_course_deposit" name="edit_course_deposit" />
                                                        <small class="text-danger error_msg" id="edit_course_deposit_errors"></small>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        Course Instalment Price
                                                        <input class="form-control lb-lg"  id="edit_instalment_price" name="edit_instalment_price" />
                                                        <small class="text-danger error_msg" id="edit_instalment_price_errors"></small>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        Course Support Price
                                                        <input class="form-control lb-lg"  id="edit_support_price" name="edit_support_price" />
                                                        <small class="text-danger error_msg" id="edit_support_price_errors"></small>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        Course Sale Price
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
                                                        Course Type
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
                                        <input type="hidden" id="method" name="method" value="course_edit" />
                                        <input type="hidden" id="edit_course_id" name="edit_course_id" value="" />
                                        <input type="hidden" id="page_var" name="page_var" value="{{$page_var}}" />
                                        <div class="col-md-12">
                                            <hr/>
                                            <input class="btn btn-primary" type="submit" id="edit_confirmed_course" name="edit_confirmed_course" value="Create Course" />
                                            <button type="button" id="edit_cancelled_course" class="btn btn-outline-secondary ">Cancel</button>
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
                                    <form id="del_selected_form" action="{{url('/courses/list/')}}/{{$page_var}}" method="POST">
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

        $("#cancelled_course").on("click", function (e) {
            console.log("Cancelling course");
            $(".modal_course_action").hide();
        });

        $("#close_course_dialog").on("click", function (e) {
            e.preventDefault();
            console.log("Cancelling course");
            $(".modal_course_action").hide();
        });

        $("#cancelled_delete").on("click", function (e) {
            console.log("Cancelling delete");
            $(".modal_delete_action").hide();
        });

        $("#close_delete_dialog").on("click", function (e) {
            e.preventDefault();
            $(".modal_delete_action").hide();
        });

        $("#close_course_edit_dialog").on("click", function (e) {
            e.preventDefault();
            console.log("Cancelling course edit");
            $(".modal_course_edit_action").hide();
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

        //get anchor id => delete_action_{1} and concatenate it to create modal id
        $("#new_course_btn").on("click", function () {
                //process course request
                $("#modal_course_action").css('display','block');
                $("#modal_course_action").css({ top: '0%' });
        });

        //edit
        {{--$(".edit_action").on("click", function (e) {--}}
        {{--    console.log("Processing Del Request:"+this.id);--}}
        {{--    var str = this.id;--}}
        {{--    var id = str.split(/[\s_]+/);--}}
        {{--    console.log("SPLITTED:" + id[2]);--}}
        {{--    $("#edit_course_id").val(id[2]);--}}
        {{--    //perform ajax call to get selected user data for modal dialog to be updated--}}
        {{--    e.preventDefault();--}}
        {{--    $.ajaxSetup({--}}
        {{--        headers: {--}}
        {{--            'X-XSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')--}}
        {{--        }--}}
        {{--    });--}}

        {{--    var formdata = new FormData($("#edit_course_form")[0]);--}}
        {{--    console.log("formdata");--}}
        {{--    console.log(formdata);--}}

        {{--    $.ajax({--}}
        {{--        url: '{{ url('/get-course-by-id-ajax') }}',--}}
        {{--        type: 'get',--}}
        {{--        data:'edit_course_id='+id[2]+'&method=course_edit',--}}
        {{--        processData: false,--}}
        {{--        contentType: false,--}}
        {{--        success: function (response) {--}}
        {{--            // console.log('full resp:');--}}
        {{--            // console.log(response);--}}

        {{--            //set values to edit course dialog fields--}}
        {{--            $("#edit_course_name").val(response[0]['name']);--}}
        {{--            $("#edit_description").val(response[0]['description']);--}}
        {{--            $("#edit_type").val(response[0]['type']);--}}
        {{--            $("#edit_number_of_assignments").val(response[0]['number_of_assignments']);--}}
        {{--            $("#edit_full_price").val(response[0]['full_price']);--}}
        {{--            $("#edit_course_deposit").val(response[0]['deposit']);--}}
        {{--            $("#edit_instalment_price").val(response[0]['instalment_price']);--}}
        {{--            $("#edit_support_price").val(response[0]['support_price']);--}}
        {{--            $("#edit_sale_price").val(response[0]['sale_price']);--}}

        {{--        },--}}
        {{--        error: function (data) {--}}
        {{--            console.log(data);--}}
        {{--            console.log('scroll error'+error_scroll);--}}
        {{--            $('#'+error_scroll).focus();--}}
        {{--        }--}}
        {{--    });--}}

        {{--    //process course request--}}
        {{--    $("#modal_course_edit_action").css('display','block');--}}
        {{--    $("#modal_course_edit_action").css({ top: '0%' });--}}
        {{--});--}}



        //add course form submission code
        $("#confirmed_course").click(function (e) {
            var error_scroll = '';
            //add rules
            //min length
            if ($('#course_name').val().length <= 0) {
                $('#course_name_errors').text('Please provide course name');
                return false;
            } else {
                $('#course_name_errors').text('');
            }

            if ($('#full_price').val().length <= 0) {
                $('#full_price_errors').text('Please provide full price');
                return false;
            } else {
                $('#full_price_errors').text('');
            }

            if ($('#course_deposit').val().length <= 0) {
                $('#course_deposit_errors').text('Please provide course deposit price');
                return false;
            } else {
                $('#course_deposit_errors').text('');
            }

            if ($('#instalment_price').val().length <= 0) {
                $('#instalment_price_errors').text('Please provide course instalment price');
                return false;
            } else {
                $('#instalment_price_errors').text('');
            }

            if ($('#support_price').val().length <= 0) {
                $('#support_price_errors').text('Please provide course support price');
                return false;
            } else {
                $('#support_price_errors').text('');
            }

            if ($('#sale_price').val().length <= 0) {
                $('#sale_price_errors').text('Please provide course sale price');
                return false;
            } else {
                $('#sale_price_errors').text('');
            }

            if ($('#number_of_assignments').val().length <= 0) {
                $('#number_of_assignments_errors').text('Please provide a value for course assignments');
                return false;
            } else {
                $('#number_of_assignments_errors').text('');
            }

            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-XSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var formdata = new FormData($("#add_course_form")[0]);
            console.log("formdata");
            console.log(formdata);

            $.ajax({
                url: '{{ url('/courses/list/1') }}',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (response) {
                    $('#success-alert').html('<h3>Course Added Successfully</h3>');
                    $("#confirmed_course").attr('disabled',true);
                    $('#success-alert').focus();
                    $("#success-alert").fadeTo(2000, 500).slideUp(500, function () {
                        $("#success-alert").css("height", "0px");
                        $("#success-alert").css("display", "block");
                        var page = '<?php echo url("/")?>'+'/courses/list/1';
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

        //add student form submission code
        $("#edit_confirmed_course").click(function (e) {
            var error_scroll = '';
            //add rules
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
                url: '{{ url('/courses/list/1') }}',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (response) {
                    $('#success-alert').html('<h3>Course Updated Successfully</h3>');
                    $("#confirmed_edit_course").attr('disabled',true);
                    //clear all fields
                    $('#success-alert').focus();
                    $("#success-alert").fadeTo(2000, 500).slideUp(500, function () {
                        //$("#create_users").attr("disabled", true);
                        //$("#create-user-form").css("display", 'none');
                        $("#success-alert").css("height", "0px");
                        $("#success-alert").css("display", "block");
                        var page = '<?php echo url("/")?>'+'/courses/list/1';
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