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

                        <h3 class="">Resources @can('create-resources',\Illuminate\Support\Facades\Auth::user())<a style="float:right;" href="#" id="new_task_btn" title="Add New Resource" class="btn btn-primary "><i class="fas fa-plus"></i> New Resource</a>@endcan</h3>
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
                            <form class="row" id="resources_filters_action_form" style="height:76px;margin: 0;" action="{{url('/resources/list')}}/{{$page_var}}" method="GET">
                                {{ csrf_field() }}
                                <div class="col-md-7 no-padding">
                                    Search by Course
                                    <input type="text" id="single_course_search" name="single_course_search" class="form-control lb-lg" placeholder="Type course name" value="<?php if(Request::input('single_course_search')){ echo  Request::input('single_course_search');}?>" />
                                    <input type="hidden" id="searched_course_id" name="searched_course_id" value=""/>
                                    <div id="found_courses">
                                        <a href="#" title="Course Name">Course Name</a>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    Sort By
                                    <select id="accessibility_filter" name="accessibility_filter" class="form-control">
                                        <option <?php if(Request::input('single_course_search') == ''){ echo "selected=''";}?> value="all">Generic Resources</option>
                                        <option <?php if(Request::input('single_course_search') != ''){ echo "selected=''";}?> value="course">Course</option>
                                    </select>
                                </div>

{{--                                <div class="col-md-2">--}}
{{--                                    Order By--}}
{{--                                    <select id="resource_filter" name="resource_filter" class="form-control">--}}
{{--                                        <option value="name">Sort by name</option>--}}
{{--                                        <option value="date">Sort by created on</option>--}}
{{--                                    </select>--}}
{{--                                </div>--}}
                                <div class="col-md-2">
                                    <br>
                                   <button class="btn btn-outline-secondary full-width" type="submit"><i class="fas fa-filter"></i>Filter</button>
                                </div>
                            </form>
                        </div>
                    </div>


                    <form id="edit_course_form" action="{{url('/resources/')}}/{{$page_var}}" method="POST">
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
                                    <thead>
                                    <tr>
                                        <th scope="col" class="checkbox_col checkbox_container_th">
                                            <input class="selector_checkbox checkbox" title="Select / Deselect All Records" type="checkbox" id="select_all_records" name="select_all_records"/>
                                            <span class="checkmark"></span>
                                        </th>
                                        <th class="course_name_col" scope="col">Accessibility</th>
                                        <th class="resource_description_col" scope="col">Description</th>
                                        <th class="resource_file_col" scope="col">Resource File</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $count = 1;
                                    if($resources->count() >= 1){
                                    ?>
                                    @foreach($resources as $resource)
                                        <tr class="record_row record_{{ $resource->id }}">
                                            <td class="checkbox_container checkbox_col">
                                                <input class="task_checkbox checkbox" id="{{ $resource->id }}" value="{{ $resource->id }}" name="delete_checkbox" type="checkbox"/>
                                                <span class="checkmark"></span>
                                            </td>
                                            <td>{{ ($resource->course_specific === 'all')? 'Generic Resource' : \App\Http\Controllers\CourseController::getCourseNameById($resource->course_specific)  }}</td>
                                            <td>{{ $resource->description }}</td>
                                            <td><a href="{{ url('/public').'/resources/'.$resource->resource_file }}" title="Download Resource"><i class="fas fa-download"></i> Download</a></td>
                                        </tr>
                                        <?php $count++;?>
                                    @endforeach
                                    <?php
                                    }else{
                                        echo '<tr><td colspan="7"> No Resource Found </td></tr>';
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
                                    <a class="action_buttons" href="{{url('/resources/list/')}}/{{$page_var-1}}?_token={{ csrf_token() }}&single_course_search={{((Request::query('single_course_search')) ? Request::query('single_course_search') : "" )}}&accessibility_filter={{((Request::query('accessibility_filter')) ? Request::query('accessibility_filter') : "" )}}" title="Previous"><i class="fas fa-chevron-left"> </i> Previous</a>
                                    <?php
                                    }
                                    ?>
                                    <?php
                                    //eg: total 5 > current 5
                                    if($page_var  < $totalPages){
                                    ?>
                                    <a class="action_buttons" href="{{url('/resources/list/')}}/{{$page_var+1}}?_token={{ csrf_token() }}&single_course_search={{((Request::query('single_course_search')) ? Request::query('single_course_search') : "" )}}&accessibility_filter={{((Request::query('accessibility_filter')) ? Request::query('accessibility_filter') : "" )}}" title="Next">Next <i class="fas fa-chevron-right"></i></a>
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
                                    <h3>Confirm Delete Resource? <a href="#" title="close dialog" id="close_delete_dialog" style="float: right;margin: 0 10px;"><i class="fa fa-close"></i></a></h3>
                                    <p>This action cannot be undone.</p>
                                </div>
                                <div class="modal-footer">
                                    <form id="del_selected_form" action="{{url('/resources/list')}}/{{$page_var}}" method="POST">
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
                        <div class="task-modal-dialog modal_task_dialog" style="    width: 50%;    left: 25%;" role="document">
                            <div class="modal-content align-items-center" style="padding: 0 20px;">
                                <div class="modal-body">
                                    <h3>Add Resource <a href="#" title="close dialog" id="close_dialog" style="float: right;margin: 0 10px;"><i class="fa fa-close"></i></a></h3>
                                </div>
                                <div class="modal-footer">
                                    <form id="add_resource_form" action="{{url('/resources/list/')}}/{{$page_var}}" method="POST" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <div class="col-md-12 no-padding">
                                            <div class="col-md-12 no-padding">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label><input checked="" type="radio" class="course_specific" name="course_specific" value="all">Generic Resource (Available for all courses)</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label><input type="radio" class="course_specific" name="course_specific" value="course_specific">Course Specific</label>
                                                    </div>
                                                </div>

                                                <div id="course_specific_search" style="display: none" class="col-md-12 no-padding">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            Search Course
                                                            <input type="text" id="course_search" name="course_search" class="form-control lb-lg"/>
                                                            <small class="text-danger" id="course_search_errors"></small>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                            <select id="all_courses" name="all_courses" size="<?php echo count($courses)?>" style="height: 150px;" class="form-control" >
                                                                <?php
                                                                foreach($courses as $course){
                                                                    echo '<option value="'.$course->id.'">'.$course->name.'</option>';
                                                                }
                                                                ?>
                                                            </select>
                                                        <br>
                                                        <small class="text-danger" id="all_courses_errors"></small>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        Resource File
                                                        <input required="" type="file" class="form-control lb-lg"  id="resource_file" name="resource_file" />
                                                        <small class="text-danger error_msg" id="resource_file_errors"></small>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        Description (Max Characters : 100)
                                                        <textarea maxlength="100" id="description" name="description" class="form-control lb-lg" cols="1" rows="2"></textarea>
                                                        <small class="text-danger error_msg" id="description_errors"></small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <input type="hidden" id="total" name="total" value="{{$total}}" />
                                        <input type="hidden" id="totalPages" name="totalPages" value="{{$totalPages}}" />
                                        <input type="hidden" id="method" name="method" value="new_resource" />
                                        <input type="hidden" id="course_id" name="course_id" value="" />
                                        <input type="hidden" id="page_var" name="page_var" value="{{$page_var}}" />
                                        <div class="col-md-12">
                                            <hr/>
                                            <input class="btn btn-primary" type="submit" id="new_resource_btn" name="new_resource_btn" value="Add Resource" />
                                            <button type="button" id="cancelled_new_resource_btn" class="btn btn-outline-secondary ">Cancel</button>
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
        $("#staff_filter").on("change", function () {
            console.log("Changed....");
            this.form.submit();
        });

        $("#accessibility_filter").on("change", function () {
              if($(this).val() === 'all'){
                  $("#single_course_search").val('');
              }
        });

        $("#status_filter").on("change", function () {
            console.log("Changed....");
            this.form.submit();
        });

        $("#criteria_filter").on("change", function () {
            console.log("Changed....");
            this.form.submit();
        });

        $(".course_specific").on("change", function () {
            if($(this).val() === 'all'){
                $("#course_specific_search").hide();
            }
            if($(this).val() === 'course_specific'){
                $("#course_search").focus();
                $("#course_specific_search").show();
            }
        });

        $('#all_courses').on('input', function (e) {
            $('#all_courses :selected').each(function(i, selected){
                $('#course_search').val($(this).text());
                $('#course_id').val($(this).val());
            });
        });

        $("#cancelled_new_resource_btn").on("click", function (e) {
            console.log("Cancelling course");
            $(".modal_task_action").hide();
        });

        $("#close_dialog").on("click", function (e) {
            e.preventDefault();
            console.log("Cancelling course");
            $(".modal_task_action").hide();
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
            var allVals = [];
            $.each($("input[name='delete_checkbox']:checked"), function(){
                allVals.push($(this).val());
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
                $('.selected_label').text(countCheckedCheckboxes + ' Resource(s) Selected');
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
                $('.selected_label').text(countCheckedCheckboxes + ' Resource(s) Selected');
            }else{
                $(".task_checkbox").closest('.record_'+this.id).css('background', '#fff');
                if ($(".checkbox_container input:checkbox:checked").length < 1)
                {
                    // no one is checked
                    $("#actions_bar_left").css('display', 'none');
                }
                var $checkboxes = $('.task_checkbox');
                var countCheckedCheckboxes = $checkboxes.filter(':checked').length;
                $('.selected_label').text(countCheckedCheckboxes + ' Resource(s) Selected');
            }
        });

        //add resource
        $("#new_resource_btn").click(function (e) {
            var error_scroll = '';
            if ($('#resource_file').val().length <= 0) {
                $('#resource_file_errors').text('Please select a resource file to upload');
                return false;
            } else {
                $('#resource_file_errors').text('');
            }

            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-XSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var formdata = new FormData($("#add_resource_form")[0]);
            console.log("formdata");
            console.log(formdata);

            $.ajax({
                url: '{{ url('/resources/list/').'/'.$page_var }}',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (response) {
                    $('#success-alert').html('<h3>Resource Created Successfully</h3>');
                    $("#new_resource_btn").attr('disabled',true);
                    $('#success-alert').focus();
                    $("#success-alert").fadeTo(2000, 500).slideUp(500, function () {
                        $("#success-alert").css("height", "0px");
                        $("#success-alert").css("display", "block");
                        var page = '<?php echo url("/")?>'+'/resources/list/<?php echo $page_var;?>';
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

        //find searched courses
        $('#single_course_search').on('input', function (e) {
            $('#found_courses').show();
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var searched_course = $('#single_course_search').val();
            $.ajax({
                url: '{{ url("/get-courses-ajax") }}',
                type: 'get',
                data: 'course=' + searched_course,
                processData: false,
                contentType: false,
                success: function (response) {
                    console.log('response:'+response);
                    if (response !== 'NULL') {
                        var courses = response;
                        var data_holder = '';
                        $('#found_courses').html('');
                        courses.forEach(function(course){
                            //console.log('$(this).val()'+course['id']);
                            $("#found_courses").html( $("#found_courses").html() + '<a href="#" onclick="$(\'#single_course_search\').val(this.id);$(\'#accessibility_filter\').val(\'course\');$(\'#searched_course_id\').val('+course["id"]+');$(\'#found_courses\').hide();this.preventDefault;" id="'+course['name']+'">'+course['name']+'</a>');
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
        $('#course_search').on('input', function (e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var searched_course = $('#course_search').val();

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
    })();
</script>
@endsection