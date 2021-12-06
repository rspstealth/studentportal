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
                            <h3>My Courses</h3>
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

                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <th class="rollno_col" scope="col">#</th>
                                    <th class="course_col" scope="col">Course Name</th>
                                    <th class="name_col" scope="col">Progress</th>
                                    <th class="date_col" scope="col">Course Materials</th>
                                    <th class="actions_col" scope="col">Actions</th>
                                </tr>
                                <tbody>
                                <?php
                                $index = 1;
                                foreach($my_courses as $course){
                                ?>
                                <tr class="record_row record_{{$course->id}}">
                                    <td>{{$index}}</td>
                                    <td>{{\app\Http\Controllers\CourseController::getCourseNameById($course->course_id)}}</td>
                                    <td>
                                        0%
                                    </td>
                                    <td>
                                        <a href="{{url('/course/'.$course->course_id.'/reader/1')}}" class="btn btn-outline-secondary"><i class="fas fa-book"></i> Materials</a>
                                    </td>
                                    <td>
                                        <a href="{{ url('/course/'.$course->course_id.'/dash/') }}" class="btn btn-outline-secondary"  title="View Course Dashboard"><i class="fas fa-caret-right"></i> Continue Learning</a>
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

    })();
</script>
@endsection