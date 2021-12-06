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
                                        <h4>Marking</h4>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-12 no-padding">
                                            <ul>
                                                <li>
                                                    <a style="margin:10px 0;margin-top: 14px;font-size:16px;display:block" target="_blank" href="{{url('/marking/list/1?q=priority_students')}}" title="Courses">
                                                        Priority Students ({{$total_priority_markings}})<span class="float-right"><i class="fas fa-external-link-square-alt"></i></span>
                                                    </a>
                                                    <hr>
                                                </li>
                                                <li>
                                                    <a style="margin:10px 0;margin-top: 14px;font-size:16px;display:block" target="_blank" href="{{url('/marking/list/1?q=current_marking')}}" title="Current Marking">
                                                        Marking ({{$total_courses_marking}})<span class="float-right"><i class="fas fa-external-link-square-alt"></i></span>
                                                    </a>
                                                    <hr>
                                                </li>
                                                <li>
                                                    <a style="margin:10px 0;margin-top: 14px;font-size:16px;display:block" target="_blank" href="{{url('/marking/list/1?q=current_unit_marking')}}" title="Current Unit Marking">
                                                        Unit Marking ({{$total_courses_unit_marking}})<span class="float-right"><i class="fas fa-external-link-square-alt"></i></span>
                                                    </a>
                                                    <hr>
                                                </li>
                                                <li>
                                                    <a style="margin:10px 0;margin-top: 14px;font-size:16px;display:block" target="_blank" href="{{url('/marking/list/1?q=pending_resource_approval')}}" title="Resources">
                                                        Pending Resource Approval ({{$total_resources}})<span class="float-right"><i class="fas fa-external-link-square-alt"></i></span>
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
                                        <a href="{{url('/revenue/list/1')}}" class="">
                                            <h4>Revenue</h4>
                                        </a>
                                        <i style="float:right;font-size:100px;margin-top: -50px;" class="far fa-chart-bar"></i>
                                    </div>
                                </div>
                                    <div class="card">
                                        <div class="col-md-12">
                                            <a href="{{url('/request-holidays')}}" class="">
                                                <h4>Holidays</h4>
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
