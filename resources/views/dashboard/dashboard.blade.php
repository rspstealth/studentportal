@extends('layouts.dashboard')
@section('content')
    <div class="container main-content">
            <div class="row col-md-12 no-padding">
                    <div class="col-md-2" id="sidebar-menu">
                            <ul class="nav navbar-nav">
                                @include('layouts.get-user-menu')
                            </ul>
                    </div>

                    <div id="right-content" class="col-md-10">
                        <div>
                            <h4 class="">Dashboard</h4>
                        </div>

                        <div id="task_management" class="dash_card">
                            <div class="col-md-12 no-padding">
                                <h4>Task Management <span class="text-muted">({{$total_tasks}})</span></h4>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-2 no-padding">
                                        <a href="{{url('/task-management/list/1')}}" class="text-heading">
                                            <span class=""><i style="color:orangered;" class="fas fa-level-up-alt"></i> High: {{$total_high_tasks}}</span>
                                        </a>
                                </div>
                                <div class="col-md-2 no-padding" style="margin-left:10px;">
                                        <a href="{{url('/task-management/list/1')}}" class="text-heading">
                                            <span class=""><i style="color: darkorange;" class="fas fa-level-up-alt"></i> Medium: {{$total_medium_tasks}}</span>
                                        </a>
                                </div>
                                <div class="col-md-2 no-padding" style="margin-left:10px;">
                                        <a href="{{url('/task-management/list/1')}}"  class="text-heading">
                                            <span class=""><i style="color: cadetblue;" class="fas fa-level-down-alt"></i> Low: {{$total_low_tasks}}</span>
                                        </a>
                                </div>

                            </div>

                        </div>

                        <div class="row col-md-12 no-padding no-margin">
                            <div class="col-md-7 dash_card_left">
                                <div class="card">
                                    <div class="col-md-12 no-padding">
                                        <h4>Course Management</h4>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-12 no-padding">
                                            <ul>
                                                <li>
                                                    <a style="margin:10px 0;margin-top: 14px;font-size:16px;display:block" target="_blank" href="{{url('/courses/list/1')}}" title="Courses">
                                                        Courses ({{$total_courses}})<span class="float-right"><i class="fas fa-external-link-square-alt"></i></span>
                                                    </a>
                                                    <hr>
                                                </li>
                                                <li>
                                                    <a style="margin:10px 0;margin-top: 14px;font-size:16px;display:block" target="_blank" href="{{url('/materials/list/1')}}" title="Materials">
                                                        Course Materials ({{$total_materials}})<span class="float-right"><i class="fas fa-external-link-square-alt"></i></span>
                                                    </a>
                                                    <hr>
                                                </li>
                                                <li>
                                                    <a style="margin:10px 0;margin-top: 14px;font-size:16px;display:block" target="_blank" href="{{url('/resources/list/1')}}" title="Resources">
                                                        Resources ({{$total_resources}})<span class="float-right"><i class="fas fa-external-link-square-alt"></i></span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 dash_card_left">
                                    <div class="card">
                                        <div class="col-md-12 no-padding ">
                                            <h4>Manage Users</h4>
                                        </div>
                                        <div class="col-md-12">
                                            <ul>
                                                <li>
                                                    <a style="margin:10px 0;margin-top: 14px;font-size:16px;display:block" target="_blank" href="{{url('/students/list/1')}}" title="Students">
                                                        Students ({{$total_students}})<span class="float-right"><i class="fas fa-external-link-square-alt"></i></span>
                                                    </a>
                                                    <hr>
                                                </li>
                                                <li>
                                                    <a style="margin:10px 0;margin-top: 14px;font-size:16px;display:block" target="_blank" href="{{url('/manage-users/list/1?t=tutors')}}" title="Courses">
                                                        Tutors ({{$total_tutors}})<span class="float-right"><i class="fas fa-external-link-square-alt"></i></span>
                                                    </a>
                                                    <hr>
                                                </li>
                                                <li>
                                                    <a style="margin:10px 0;margin-top: 14px;font-size:16px;display:block" target="_blank" href="{{url('/manage-users/list/1?t=admins')}}" title="Tutors">
                                                        Administrators ({{$total_admins}})<span class="float-right"><i class="fas fa-external-link-square-alt"></i></span>
                                                    </a>
                                                    <hr>
                                                </li>
                                                <li>
                                                    <a style="margin:10px 0;margin-top: 14px;font-size:16px;display:block" target="_blank" href="{{url('/manage-users/list/1?t=ivs')}}" title="IVs">
                                                        IVs ({{$total_ivs}})<span class="float-right"><i class="fas fa-external-link-square-alt"></i></span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-5 dash_card_right">
                                <div class="card">
                                    <div class="col-md-12">
                                        <a href="#" class="">
                                            <h4>Help Centre</h4>
                                        </a>
                                        <br>
                                        <a style="text-decoration: none" href="#" class=""><span class="number_label">0 Tickets</span>
                                        </a>
                                        <br>
                                        <br>
                                        <i style="float:right;font-size:100px;margin-top: -120px;" class="fas fa-comments"></i>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="col-md-12">
                                        <a href="{{url('/stats')}}" class="">
                                            <h4>Stats</h4>
                                        </a>
                                        <i style="float:right;font-size:100px;margin-top: -50px;" class="far fa-chart-bar"></i>
                                    </div>
                                </div>
                                    <div class="card">
                                        <div class="col-md-12">
                                            <a href="{{url('/manage-users/list/1?t=tutors')}}" class="">
                                                <h4>Manage Tutors</h4>
                                            </a>
                                            <i style="float:right;font-size:100px;margin-top: -50px;" class="fas fa-user-tie"></i>
                                        </div>
                                    </div>
                                </div>


                            </div>

                        </div>


                    </div>
            </div>
    </div>
@endsection
