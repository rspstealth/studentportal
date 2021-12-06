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
                            <h3><a class="btn btn-outline-secondary" href="{{url('/my-courses/list/1')}}" title="Back to Course"><i class="fas fa-chevron-left"></i> Back to My Courses</a>
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
                            <h3>Notes Added Successfully</h3>
                        </div>
                        <div class="col-md-12" style="padding: 10px;">
                            <div id="my_pdf_viewer">
                                <div class="col-md-12" style="    padding: 10px;
    height: 56px;
    background: linear-gradient(
180deg
 , #dcdcdcdc,#f5f5f5);
    border: 1px solid #dcdcdc;
    border-radius: 6px;
    margin-bottom: 20px;">
                                    <div class="col-md-3 no-padding">
                                        <a  href="{{url('/course/'.$course_id.'/reader/'.($page_var-1))}}" {{(($page_var == 1)? print 'disabled=""' : print '')}} class="btn btn-outline-secondary" id="go_previous_fixed"><i class="fas fa-chevron-left"></i></a>
                                        <a  href="{{url('/course/'.$course_id.'/reader/'.($page_var-1))}}" {{(($page_var == 1)? print 'disabled=""' : print '')}} class="btn btn-outline-secondary full-width" id="go_previous"><i class="fas fa-chevron-left"></i> Previous Page</a>
                                    </div>
                                    <div class="col-md-2 text-right">
                                        <label style="padding: 7px 0;">Jump to Page</label>
                                    </div>
                                    <div class="col-md-2">
                                        <div id="navigation_controls">
                                            <input class="form-control lb-lg" id="current_page" value="{{$page_var}}" type="number"/>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div id="navigation_controls">
                                            <a href="{{url('/course/'.$course_id.'/reader/'.$page_var)}}" class="btn btn-outline-secondary" id="find_page">GO</a>
                                        </div>
                                    </div>
                                    <div class="col-md-3 no-padding">
                                        <a href="{{url('/course/'.$course_id.'/reader/'.($page_var+1))}}" class="btn btn-outline-secondary full-width" id="go_next">Next Page <i class="fas fa-chevron-right"></i></a>
                                        <a href="{{url('/course/'.$course_id.'/reader/'.($page_var+1))}}" class="btn btn-outline-secondary" id="go_next_fixed"><i class="fas fa-chevron-right"></i></a>
                                    </div>
                                </div>
                                <div id="canvas_container" style="overflow:scroll !important;    background: whitesmoke;    padding: 3px;">
                                    <h4 class="text-center">Course Material</h4>
                                    <canvas id="pdf_renderer"></canvas>
                                </div>
                            </div>

                            <script>
                                var myState = {
                                    pdf: null,
                                    currentPage: {{$page_var}},
                                    zoom: 1.5
                                }

                                pdfjsLib.getDocument('{{url("/public/materials/")}}/{{$material_file}}').then((pdf) => {
                                    var numPages = pdf.numPages;
                                    console.log('# Document Loaded');
                                    console.log('Number of Pages: ' + numPages);
                                    myState.pdf = pdf;
                                    render();
                                    $('#total_pdf_pages').html(numPages);

                                });

                                function render() {
                                    myState.pdf.getPage(myState.currentPage).then((page) => {

                                        var canvas = document.getElementById("pdf_renderer");
                                        var ctx = canvas.getContext('2d');

                                        var viewport = page.getViewport(myState.zoom);

                                        canvas.width = viewport.width;
                                        canvas.height = viewport.height;

                                        page.render({
                                            canvasContext: ctx,
                                            viewport: viewport
                                        });
                                    });
                                }
                            </script>
                        </div>

                        <div class="col-md-12">
                            <form class="row" id="notes_form" action="{{url('/course/'.$course_id.'/reader/')}}/{{$page_var}}" method="POST">
                                {{ csrf_field() }}
                                <div class="col-md-12">

                                    <h3>Notes</h3>
                                    <div class="form-group">
                                        <input required="" value="{{(isset($course_notes[0]->notes_title)?$course_notes[0]->notes_title:'')}}" placeholder="Notes Title" class="form-control lb-lg"  id="notes_title" name="notes_title" />
                                        <small class="text-danger error_msg" id="notes_title_errors"></small>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <textarea placeholder="Write Notes For This Page..." maxlength="100" id="notes_description" name="notes_description" class="form-control lb-lg" cols="1" rows="3">{{(isset($course_notes[0]->notes_description)?$course_notes[0]->notes_description:'')}}</textarea>
                                        <small class="text-danger error_msg" id="notes_description_errors"></small>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <input type="hidden" id="id" name="id" value="{{((!empty($course_notes[0]->id) ? $course_notes[0]->id: ''))}}"/>
                                    <input type="hidden" id="method" name="method" value="{{((!empty($course_notes[0]->notes_title) ? 'update_notes': 'new_notes'))}}"/>
                                    <hr/>
                                    <input class="btn btn-primary" type="submit" id="save_notes" name="save_notes" value="Save Notes" />
                                </div>
                            </form>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
<script>
    (function(){
        $("#find_page").on("click", function (e) {
            e.preventDefault();
            var url_string = '{{url("/course")}}/{{$course_id}}/reader';
            $("#current_page").val();
            console.log('URL:'+url_string+'/'+$("#current_page").val());
            window.location.replace(url_string+'/'+$("#current_page").val());
        });

        //add notes
        $("#save_notes").click(function (e) {
            var error_scroll = '';
            if ($('#notes_title').val().length <= 0) {
                $('#notes_title_errors').text('Please provide notes title');
                return false;
            } else {
                $('#notes_title_errors').text('');
            }
            if ($('#notes_description').val() == '') {
                $('#notes_description_errors').text('Please add notes detail...');
                return false;
            } else {
                $('#notes_description_errors').text('');
            }

            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-XSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var formdata = new FormData($("#notes_form")[0]);
            console.log("formdata");
            console.log(formdata);

            $.ajax({
                url: '{{url("/course")}}/{{$course_id}}/reader/{{$page_var}}',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (response) {
                    $('#success-alert').html('<h3>Notes Added Successfully</h3>');
                    $("#save_notes").attr('disabled',true);
                    $('#success-alert').focus();
                    $("#success-alert").fadeTo(2000, 500).slideUp(500, function () {
                        $("#success-alert").css("height", "0px");
                        $("#success-alert").css("display", "block");
                        var page = '{{url("/course")}}/{{$course_id}}/reader/{{$page_var}}';
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