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
                        <div class="col-12" style="padding:20px 0;">
                            <div class="form-group">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <button id="tutors" type="button" class="btn btn-outline-secondary btn-group-ite {{(Request::query('t') === 'tutors'  ? 'active' : '') }}">Tutors</button>
                                    <button id="admins" type="button" class="btn btn-outline-secondary btn-group-item {{ (Request::query('t') === 'admins' ? 'active' : '') }}">Administrators</button>
                                    <button id="iv" type="button" class="btn btn-outline-secondary btn-group-item {{(Request::query('t') === 'ivs'  ? 'active' : '') }}">IV</button>
                                </div>
                                <hr style="margin-top:10px;"/>


                            </div>
                        </div>

                        <?php
                        //tutors only
                        if(Request::query('t') === 'tutors'){
                        ?>
                        <div class="col-6">
                            <h3 class="">Tutors <a style="float:right;" href="#" id="new_tutor_btn" title="New Staff Tutor" class="btn btn-primary">Add New Tutor</a></h3>
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
                            <h3>Tutor added Successfully</h3>
                        </div>
                            <table class="table">
                                <tr>
                                    <th class="rollno_col" scope="col">#</th>
                                    <th class="description_col" scope="col">Tutor Name</th>
                                    <th class="description_col" scope="col">Created On</th>
                                    <th class="description_col" scope="col">Actions</th>
                                </tr>
                                <tbody>
                                <?php
                                $index = 1;
                                foreach($users as $user){
                                ?>
                                <tr class="record_row record_{{$user->id}}">
                                    <td>{{$index}}</td>
                                    <td>{{$user->first_name .' '. $user->last_name}} <a href="{{url('/impersonate/user/'.App\Http\Controllers\UserController::getUserIdByTutorId($user->id))}}" id="impersonate_user_{{$user->id}}" class="impersonate_user_btn no-margin" title="Login as {{$user->first_name .' '. $user->last_name}}"><i class="fas fa-sign-in-alt"></i></a></td>
                                    <td>{{date("m-d-Y", strtotime($user->created_at))}}</td>
                                    <td>
                                        <a id="edit_action_{{ $user->id }}" class="action_buttons edit_action btn-outline-secondary tiny-action-btn" href="#" title="Edit Tutor"><i class="far fa-edit"></i> Edit</a>
                                        <a id="delete_action_{{ $user->id }}" class="action_buttons delete_action btn-outline-secondary tiny-action-btn" href="#" title="Remove Tutor"><i class="far fa-trash-alt"></i> Remove</a>
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
                                <a class="action_buttons" href="{{url('/manage-users/')}}/list/{{$page_var-1}}?_token={{ csrf_token() }}&t={{((Request::query('t')) ? Request::query('t') : "" )}}" title="Previous"><i class="fas fa-chevron-left"> </i> Previous</a>
                                <?php
                                }
                                ?>
                                <?php
                                //eg: total 5 > current 5
                                if($page_var  < $totalPages){
                                ?>
                                <a class="action_buttons" href="{{url('/manage-users/')}}/list/{{$page_var+1}}?_token={{ csrf_token() }}&t={{((Request::query('t')) ? Request::query('t') : "" )}}" title="Next">Next <i class="fas fa-chevron-right"></i></a>
                                <?php
                                }
                                }
                                ?>
                            </div>

                        <?php
                        }
                        ?>

                        <?php
                        //tutors only
                        if(Request::query('t') === 'ivs'){
                        ?>
                        <div class="col-6">
                            <h3 class="">IV <a style="float:right;" href="#" id="new_iv_btn" title="New IV" class="btn btn-primary">Add New IV</a></h3>
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
                            <h3>IV added Successfully</h3>
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <th class="rollno_col" scope="col">#</th>
                                    <th class="description_col" scope="col">IV Name</th>
                                    <th class="description_col" scope="col">Created On</th>
                                    <th class="description_col" scope="col">Actions</th>
                                </tr>
                                <tbody>
                                <?php
                                $index = 1;
                                foreach($users as $user){
                                ?>
                                <tr class="record_row record_{{$user->id}}">
                                    <td>{{$index}}</td>
                                    <td>{{$user->first_name .' '. $user->last_name}} <a href="{{url('/impersonate/user/'.App\Http\Controllers\UserController::getUserIdByIVId($user->id))}}" id="impersonate_user_{{$user->id}}" class="impersonate_user_btn no-margin" title="Login as {{$user->first_name .' '. $user->last_name}}"><i class="fas fa-sign-in-alt"></i></a></td>
                                    <td>{{date("m-d-Y", strtotime($user->created_at))}}</td>
                                    <td>
                                        <a id="edit_iv_action_{{ $user->id }}" class="action_buttons edit_iv_action btn-outline-secondary tiny-action-btn" href="#" title="edit IV"><i class="far fa-edit"></i> Edit</a>
                                        <a id="delete_iv_action_{{ $user->id }}" class="action_buttons delete_iv_action btn-outline-secondary tiny-action-btn" href="#" title="Remove IV"><i class="far fa-trash-alt"></i> Remove</a>
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
                                <a class="action_buttons" href="{{url('/manage-users/')}}/list/{{$page_var-1}}?_token={{ csrf_token() }}&t={{((Request::query('t')) ? Request::query('t') : "" )}}" title="Previous"><i class="fas fa-chevron-left"> </i> Previous</a>
                                <?php
                                }
                                ?>
                                <?php
                                //eg: total 5 > current 5
                                if($page_var  < $totalPages){
                                ?>
                                <a class="action_buttons" href="{{url('/manage-users/')}}/list/{{$page_var+1}}?_token={{ csrf_token() }}&t={{((Request::query('t')) ? Request::query('t') : "" )}}" title="Next">Next <i class="fas fa-chevron-right"></i></a>
                                <?php
                                }
                                }
                                ?>
                            </div>
                        </div>
                        <?php
                        }
                        ?>

                        <?php
                        //admins only
                        if(Request::query('t') === 'admins'){
                        ?>
                        <div class="col-6">
                            <h3 class="">Admins <a style="float:right;" href="#" id="new_admin_btn" title="New Admin" class="btn btn-primary">Add New Admin</a></h3>
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
                            <h3>Admin Created Successfully</h3>
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <th class="rollno_col" scope="col">#</th>
                                    <th class="description_col" scope="col">Tutor Name</th>
                                    <th class="description_col" scope="col">Created On</th>
                                    <th class="description_col" scope="col">Actions</th>
                                </tr>
                                <tbody>
                                <?php
                                $index = 1;
                                foreach($users as $user){
                                ?>
                                <tr class="record_row record_{{$user->id}}">
                                    <td>{{$index}}</td>
                                    <td>{{$user->first_name .' '. $user->last_name}}</td>
                                    <td>{{date("m-d-Y", strtotime($user->created_at))}}</td>
                                    <td>
                                        <a id="edit_admin_action_{{ $user->id }}" class="action_buttons edit_admin_action btn-outline-secondary tiny-action-btn" href="#" title="Edit Admin"><i class="far fa-edit"></i> Edit</a>
                                        <a id="delete_admin_action_{{ $user->id }}" class="action_buttons delete_admin_action btn-outline-secondary tiny-action-btn" href="#" title="Remove Admin"><i class="far fa-trash-alt"></i> Remove</a>
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
                                <a class="action_buttons" href="{{url('/students')}}/list/{{$page_var-1}}?_token={{ csrf_token() }}&start_date={{((Request::query('start_date')) ? Request::query('start_date') : '' )}}&end_date={{(Request::query('end_date') ?: print Request::query('end_date')  )}}&search_by_name_or_number={{((Request::query('search_by_name_or_number')) ? Request::query('search_by_name_or_number') : '' )}}&filter_by_course={{((Request::query('filter_by_course')) ? Request::query('filter_by_course') : "" )}}&student_status={{((Request::query('student_status')) ? Request::query('student_status') : "" )}}&sort_by={{((Request::query('sort_by')) ? Request::query('sort_by') : "" )}}&filter_by_college={{((Request::query('filter_by_college')) ? Request::query('filter_by_college') : "" )}}" title="Previous"><i class="fas fa-chevron-left"> </i> Previous</a>
                                <?php
                                }
                                ?>
                                <?php
                                //eg: total 5 > current 5
                                if($page_var  < $totalPages){
                                ?>
                                <a class="action_buttons" href="{{url('/students')}}/list/{{$page_var+1}}?_token={{ csrf_token() }}&start_date={{((Request::query('start_date')) ? Request::query('start_date') : "" )}}&end_date={{(Request::query('end_date') ?: print Request::query('end_date') )}}&search_by_name_or_number={{((Request::query('search_by_name_or_number')) ? Request::query('search_by_name_or_number') : "" )}}&filter_by_course={{((Request::query('filter_by_course')) ? Request::query('filter_by_course') : "" )}}&student_status={{((Request::query('student_status')) ? Request::query('student_status') : "" )}}&sort_by={{((Request::query('sort_by')) ? Request::query('sort_by') : "" )}}&filter_by_college={{((Request::query('filter_by_college')) ? Request::query('filter_by_college') : "" )}}" title="Next">Next <i class="fas fa-chevron-right"></i></a>
                                <?php
                                }
                                }
                                ?>
                            </div>

                        </div>
                        <?php
                        }
                        ?>
                    </div>

                    {{--Admin modal--}}
                    <div id="modal_admin_action" class="modal modal_admin_action" tabindex="-1" role="dialog">
                        <div class="admin-modal-dialog modal_admin_dialog" role="document">
                            <div class="modal-content align-items-center" style="padding: 0 20px;">
                                <div class="modal-body">
                                    <h3>Add Admin <a href="#" title="close dialog" id="close_admin_dialog" style="float: right;margin: 0 10px;"><i class="fa fa-close"></i></a></h2>
                                </div>
                                <div class="modal-footer">
                                    <form id="add_admin_form" action="{{url('/manage-users/list/')}}/{{$page_var}}" method="POST" enctype="multipart/form-data" >
                                        {{ csrf_field() }}
                                        <div class="col-md-12 no-padding">
                                            <div class="col-md-12 no-padding">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        First Name
                                                        <input class="form-control lb-lg"  id="admin_first_name" name="admin_first_name" />
                                                        <small class="text-danger error_msg" id="admin_first_name_errors"></small>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        Last Name
                                                        <input class="form-control lb-lg"  id="admin_last_name" name="admin_last_name" />
                                                        <small class="text-danger error_msg" id="admin_last_name_errors"></small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    Email
                                                    <input class="form-control lb-lg"  id="admin_email" name="admin_email" />
                                                    <small class="text-danger error_msg" id="admin_email_errors"></small>
                                                </div>
                                            </div>
                                        </div>

                                        <input type="hidden" id="total" name="total" value="{{$total}}" />
                                        <input type="hidden" id="totalPages" name="totalPages" value="{{$totalPages}}" />
                                        <input type="hidden" id="page_var" name="page_var" value="{{$page_var}}" />
                                        <input type="hidden" id="method" name="method" value="admins" />
                                        <div class="col-md-12">
                                            <hr/>
                                            <input class="btn btn-primary" type="submit" id="confirmed_admin" name="confirmed_admin" value="Create Admin" />
                                            <button type="button" id="cancelled_admin" class="btn btn-outline-secondary ">Cancel</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{--Edit Admin modal--}}
                    <div id="modal_admin_edit_action" class="modal modal_admin_edit_action" tabindex="-1" role="dialog">
                        <div class="edit-admin-modal-dialog modal_admin_edit_dialog" role="document">
                            <div class="modal-content align-items-center" style="padding: 0 20px;">
                                <div class="modal-body">
                                    <h3>Update Admin <a href="#" title="close dialog" id="close_admin_edit_dialog" style="float: right;margin: 0 10px;"><i class="fa fa-close"></i></a></h3>
                                </div>
                                <div class="modal-footer">
                                    <form id="edit_admin_form" action="{{url('/manage-users/list/')}}/{{$page_var}}" method="POST" enctype="multipart/form-data" >
                                        {{ csrf_field() }}
                                        <div class="col-md-12 no-padding">
                                            <div class="col-md-12 no-padding">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        First Name
                                                        <input class="form-control lb-lg"  id="edit_admin_first_name" name="edit_admin_first_name" />
                                                        <small class="text-danger error_msg" id="edit_admin_first_name_errors"></small>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        Last Name
                                                        <input class="form-control lb-lg"  id="edit_admin_last_name" name="edit_admin_last_name" />
                                                        <small class="text-danger error_msg" id="edit_admin_last_name_errors"></small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    Email
                                                    <input class="form-control lb-lg"  id="edit_admin_email" name="edit_admin_email" />
                                                    <small class="text-danger error_msg" id="edit_admin_email_errors"></small>
                                                </div>
                                            </div>
                                        </div>

                                        <input type="hidden" id="total" name="total" value="{{$total}}" />
                                        <input type="hidden" id="totalPages" name="totalPages" value="{{$totalPages}}" />
                                        <input type="hidden" id="page_var" name="page_var" value="{{$page_var}}" />
                                        <input type="hidden" id="edit_admin_id" name="edit_admin_id" value="" />
                                        <input type="hidden" id="method" name="method" value="admins_edit" />
                                        <div class="col-md-12">
                                            <hr/>
                                            <input class="btn btn-primary" type="submit" id="confirmed_edit_admin" name="confirmed_edit_admin" value="Update Admin" />
                                            <button type="button" id="cancelled_edit_admin" class="btn btn-outline-secondary ">Cancel</button>
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
                                    <h3>Confirm Tutor Removal? <a href="#" title="close dialog" id="close_delete_dialog" style="float: right;margin: 0 10px;"><i class="fa fa-close"></i></a></h3>
                                    <p>This action cannot be undone.</p>
                                </div>
                                <div class="modal-footer">
                                    <form id="del_selected_form" action="{{url('/manage-users/list/')}}/{{$page_var}}" method="POST">
                                        {{ method_field('delete') }}
                                        {{ csrf_field() }}
                                        <input type="hidden" id="total" name="total" value="{{$total}}" />
                                        <input type="hidden" id="totalPages" name="totalPages" value="{{$totalPages}}" />
                                        <input type="hidden" id="page_var" name="page_var" value="{{$page_var}}" />
                                        <input type="hidden" id="delete_method" name="delete_method" value="tutors" />
                                        <input type="hidden" id="id" name="id" value="" />
                                        <input class="btn btn-outline-secondary " type="submit" id="confirmed_delete" name="confirmed_delete" value="Delete" />
                                        <button type="button" id="cancelled_delete" class="btn btn-outline-secondary ">Cancel</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{--Delete Confirmation Modal--}}
                    <div id="modal_delete_admin_action" class="modal modal_delete_admin_action" tabindex="-1" role="dialog">
                        <div class="delete-admin-modal-dialog modal_delete_admin_dialog" role="document">
                            <div class="modal-content align-items-center">
                                <div class="modal-body">
                                    <h3>Confirm Admin Removal? <a href="#" title="close dialog" id="close_delete_admin_dialog" style="float: right;margin: 0 10px;"><i class="fa fa-close"></i></a></h2>
                                        <p>This action cannot be undone.</p>
                                </div>
                                <div class="modal-footer">
                                    <form id="del_selected_form" action="{{url('/manage-users/list/')}}/{{$page_var}}" method="POST">
                                        {{ method_field('delete') }}
                                        {{ csrf_field() }}
                                        <input type="hidden" id="total" name="total" value="{{$total}}" />
                                        <input type="hidden" id="totalPages" name="totalPages" value="{{$totalPages}}" />
                                        <input type="hidden" id="page_var" name="page_var" value="{{$page_var}}" />
                                        <input type="hidden" id="admin_delete_id" name="admin_delete_id" value="" />
                                        <input type="hidden" id="delete_method" name="delete_method" value="admins" />
                                        <input class="btn btn-outline-secondary " type="submit" id="confirmed_admin_delete" name="confirmed_admin_delete" value="Delete" />
                                        <button type="button" id="cancelled_admin_delete" class="btn btn-outline-secondary ">Cancel</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{--Delete Confirmation Modal--}}
                    <div id="modal_delete_iv_action" class="modal modal_delete_iv_action" tabindex="-1" role="dialog">
                        <div class="iv-delete-modal-dialog modal_delete_iv_dialog" role="document">
                            <div class="modal-content align-items-center">
                                <div class="modal-body">
                                    <h3>Confirm IV Removal? <a href="#" title="close dialog" id="close_delete_iv_dialog" style="float: right;margin: 0 10px;"><i class="fa fa-close"></i></a></h3>
                                        <p>This action cannot be undone.</p>
                                </div>
                                <div class="modal-footer">
                                    <form id="del_selected_form" action="{{url('/manage-users/list/')}}/{{$page_var}}" method="POST">
                                        {{ method_field('delete') }}
                                        {{ csrf_field() }}
                                        <input type="hidden" id="total" name="total" value="{{$total}}" />
                                        <input type="hidden" id="totalPages" name="totalPages" value="{{$totalPages}}" />
                                        <input type="hidden" id="page_var" name="page_var" value="{{$page_var}}" />
                                        <input type="hidden" id="delete_method" name="delete_method" value="ivs" />
                                        <input type="hidden" id="iv_delete_id" name="iv_delete_id" value="" />
                                        <input class="btn btn-outline-secondary " type="submit" id="confirmed_iv_delete" name="confirmed_iv_delete" value="Delete" />
                                        <button type="button" id="cancelled_iv_delete" class="btn btn-outline-secondary ">Cancel</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{--tutor modal--}}
                    <div id="modal_tutor_action" class="modal modal_tutor_action" tabindex="-1" role="dialog">
                        <div class="tutor-modal-dialog modal_tutor_dialog" role="document">
                            <div class="modal-content align-items-center" style="padding: 0 20px;">
                                <div class="modal-body">
                                    <h3>Add Tutor <a href="#" title="close dialog" id="close_dialog" style="float: right;margin: 0 10px;"><i class="fa fa-close"></i></a></h3>
                                        <span class="info">Required fields marked with </span>(<i class="fas fa-asterisk"></i>)
                                </div>
                                <div class="modal-footer">
                                    <form id="add_tutor_form" action="{{url('/manage-users/list/')}}/{{$page_var}}" method="POST" enctype="multipart/form-data" >
                                        {{ csrf_field() }}
                                        <div class="col-md-12 no-padding">
                                            <div class="col-md-12 no-padding">
                                                <div class="col-md-3 no-padding">
                                                    <div class="form-group">
                                                        First Name <i class="fas fa-asterisk"></i>
                                                        <input style="width:98%;" required="" class="form-control lb-lg"  id="first_name" name="first_name" />
                                                        <small class="text-danger error_msg" id="first_name_errors"></small>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 no-padding">
                                                    <div class="form-group">
                                                        Last Name <i class="fas fa-asterisk"></i>
                                                        <input style="width:98%;" class="form-control lb-lg"  id="last_name" name="last_name" />
                                                        <small class="text-danger error_msg" id="last_name_errors"></small>
                                                    </div>
                                                </div>

                                                <div class="col-md-3 no-padding">
                                                        <div class="form-group">
                                                            Email <i class="fas fa-asterisk"></i>
                                                            <input style="width:98%;" class="form-control lb-lg"  id="tutor_email" name="tutor_email" />
                                                            <small class="text-danger error_msg" id="tutor_email_errors"></small>
                                                        </div>
                                                </div>

                                                <div class="col-md-3 no-padding">
                                                    <div class="form-group">
                                                        Employment Status
                                                        <select style="width:98%;" class="form-control lb-lg"  id="employment_status" name="employment_status">
                                                            <option value="employed">Employed</option>
                                                            <option value="self_employed">Self Employed</option>
                                                        </select>
                                                        <small class="text-danger error_msg" id="signature_errors"></small>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12 no-padding">
                                                    <div class="form-group">
                                                        Address
                                                            <input type="text" id="tutor_address" name="tutor_address" class="form-control lb-lg"/>
                                                            <small class="text-danger" id="tutor_address_errors"></small>
                                                    </div>
                                            </div>

                                            <div class="col-md-12 no-padding">
                                                <div class="col-md-6 no-padding">
                                                    Select Desired Courses
                                                    <select id="all_courses" name="all_courses" style="min-height: 120px;" class="form-control" multiple>
                                                    <?php
                                                        foreach($courses as $course){
                                                            echo '<option value="'.$course->id.'">'.$course->name.'</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                    <br>
                                                    <a href="#" id="add_courses_to_tutor_list" class="btn btn-outline-secondary elastic" title="add to tutor courses">Add Selected to Tutor Courses <i class="fas fa-arrow-right"></i></a>
                                                </div>
                                                <div class="col-md-6 no-padding">
                                                    Courses <i class="fas fa-asterisk"></i> (Which Tutor Provides Support For)
                                                    <select id="chosen_courses" name="chosen_courses" style="min-height: 120px;" class="form-control" multiple>
                                                    </select>
                                                    <br>
                                                    <a href="#" id="remove_courses_from_tutor_list" class="btn btn-outline-secondary elastic" title="add to tutor courses"><i class="fas fa-arrow-left"></i> Remove Selected from Tutor Courses</a>
                                                </div>
                                            </div>
                                            <div class="col-md-12 no-padding">
                                                <div class="form-group">
                                                    <br>
                                                    Tutor Signature
                                                    <input type="file" class=" lb-lg"  id="signature" name="signature" />
                                                    <small class="text-danger error_msg" id="signature_errors"></small>
                                                </div>
                                                <hr/>
                                            </div>
                                        </div>

                                        <input type="hidden" id="total" name="total" value="{{$total}}" />
                                        <input type="hidden" id="totalPages" name="totalPages" value="{{$totalPages}}" />
                                        <input type="hidden" id="page_var" name="page_var" value="{{$page_var}}" />
                                        <input type="hidden" id="chosen_courses_ids" name="chosen_courses_ids" value="" />
                                        <input type="hidden" id="method" name="method" value="tutors" />
                                        <div class="col-md-12 no-padding">
                                            <input class="btn btn-primary" type="submit" id="confirmed_tutor" name="confirmed_tutor" value="Assign Tutor" />
                                            <button type="button" id="cancelled_tutor" class="btn btn-outline-secondary ">Cancel</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{--tutor modal--}}
                    <div id="modal_iv_action" class="modal modal_iv_action" tabindex="-1" role="dialog">
                        <div class="iv-modal-dialog modal_iv_dialog" role="document">
                            <div class="modal-content align-items-center" style="padding: 0 20px;">
                                <div class="modal-body">
                                    <h3>Add IV <a href="#" title="close dialog" id="close_iv_dialog" style="float: right;margin: 0 10px;"><i class="fa fa-close"></i></a></h2>
                                </div>
                                <div class="modal-footer">
                                    <form id="add_iv_form" action="{{url('/manage-users/list/')}}/{{$page_var}}" method="POST" enctype="multipart/form-data" >
                                        {{ csrf_field() }}
                                        <div class="col-md-12 no-padding">
                                            <div class="col-md-12 no-padding">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        First Name
                                                        <input class="form-control lb-lg"  id="iv_first_name" name="iv_first_name" />
                                                        <small class="text-danger error_msg" id="iv_first_name_errors"></small>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        Last Name
                                                        <input class="form-control lb-lg"  id="iv_last_name" name="iv_last_name" />
                                                        <small class="text-danger error_msg" id="iv_last_name_errors"></small>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        Email
                                                        <input class="form-control lb-lg"  id="iv_email" name="iv_email" />
                                                        <small class="text-danger error_msg" id="iv_email_errors"></small>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    Address
                                                    <input type="text" id="iv_address" name="iv_address" class="form-control lb-lg"/>
                                                    <small class="text-danger" id="iv_address_errors"></small>
                                                </div>
                                            </div>

                                            <div class="col-md-12 no-padding">
                                                <div class="col-md-6">
                                                    Select Desired Courses
                                                    <select id="iv_all_courses" name="iv_all_courses" style="min-height: 120px;" class="form-control" multiple>
                                                        <?php
                                                        foreach($courses as $course){
                                                            echo '<option value="'.$course->id.'">'.$course->name.'</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                    <br>
                                                    <a href="#" id="add_courses_to_iv_list" class="btn btn-outline-secondary elastic" title="add to IV courses">Add Selected to IV Courses <i class="fas fa-arrow-right"></i></a>
                                                </div>
                                                <div class="col-md-6">
                                                    Courses (Which IV Provides Support For)
                                                    <select id="iv_chosen_courses" name="iv_chosen_courses" style="min-height: 120px;" class="form-control" multiple>
                                                    </select>
                                                    <br>
                                                    <a href="#" id="remove_courses_from_iv_list" class="btn btn-outline-secondary elastic" title="add to IV courses"><i class="fas fa-arrow-left"></i> Remove Selected from IV Courses</a>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <br>
                                                    IV Signature
                                                    <input type="file" class=" lb-lg"  id="iv_signature" name="iv_signature" />
                                                    <small class="text-danger error_msg" id="iv_signature_errors"></small>
                                                </div>
                                                <hr/>
                                            </div>
                                        </div>

                                        <input type="hidden" id="total" name="total" value="{{$total}}" />
                                        <input type="hidden" id="totalPages" name="totalPages" value="{{$totalPages}}" />
                                        <input type="hidden" id="page_var" name="page_var" value="{{$page_var}}" />
                                        <input type="hidden" id="iv_chosen_courses_ids" name="iv_chosen_courses_ids" value="" />
                                        <input type="hidden" id="method" name="method" value="ivs" />
                                        <div class="col-md-12">
                                            <input class="btn btn-primary" type="submit" id="confirmed_iv" name="confirmed_iv" value="Create IV" />
                                            <button type="button" id="cancelled_iv" class="btn btn-outline-secondary ">Cancel</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{--tutor Modal--}}
                    <div id="modal_tutor_edit_action" class="modal modal_tutor_edit_action" tabindex="-1" role="dialog">
                        <div class="edit-tutor-modal-dialog modal_tutor_edit_dialog" role="document">
                            <div class="modal-content align-items-center" style="padding: 0 20px;">
                                <div class="modal-body">
                                    <h3>Update Tutor <a href="#" title="close dialog" id="close_edit_dialog" style="float: right;margin: 0 10px;"><i class="fa fa-close"></i></a></h3>
                                </div>
                                <div class="modal-footer">
                                    <form id="add_tutor_edit_form" action="{{url('/manage-users/list/')}}/{{$page_var}}" method="POST" enctype="multipart/form-data" >
                                        {{ csrf_field() }}
                                        <div class="col-md-12 no-padding">
                                            <div class="col-md-12 no-padding">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        First Name
                                                        <input class="form-control lb-lg"  id="edit_first_name" name="edit_first_name" />
                                                        <small class="text-danger error_msg" id="edit_first_name_errors"></small>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        Last Name
                                                        <input class="form-control lb-lg"  id="edit_last_name" name="edit_last_name" />
                                                        <small class="text-danger error_msg" id="edit_last_name_errors"></small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 no-padding">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        Email
                                                        <input class="form-control lb-lg"  id="edit_tutor_email" name="edit_tutor_email" />
                                                        <small class="text-danger error_msg" id="edit_tutor_email_errors"></small>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        Employment Status
                                                        <select class="form-control lb-lg"  id="edit_employment_status" name="edit_employment_status">
                                                            <option value="employed">Employed</option>
                                                            <option value="self_employed">Self Employed</option>
                                                        </select>
                                                        <small class="text-danger error_msg" id="edit_employment_status_errors"></small>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    Address
                                                        <input type="text" id="edit_tutor_address" name="edit_tutor_address" class="form-control lb-lg"/>
                                                        <small class="text-danger" id="edit_tutor_address_errors"></small>
                                                </div>
                                            </div>

                                            <div class="col-md-12 no-padding">
                                                <div class="col-md-6">
                                                    Select Desired Courses
                                                    <select id="edit_all_courses" name="edit_all_courses" style="min-height: 120px;" class="form-control" multiple>
                                                        <?php
                                                        foreach($courses as $course){
                                                            echo '<option value="'.$course->id.'">'.$course->name.'</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                    <br>
                                                    <a href="#" id="add_courses_to_edit_tutor_list" class="btn btn-outline-secondary elastic" title="add to tutor courses">Add Selected to Tutor Courses <i class="fas fa-arrow-right"></i></a>
                                                </div>
                                                <div class="col-md-6">
                                                    Courses (Which Tutor Provides Support For)
                                                    <select id="edit_chosen_courses" name="edit_chosen_courses" style="min-height: 120px;" class="form-control" multiple>
                                                    </select>
                                                    <br>
                                                    <a href="#" id="remove_courses_from_edit_tutor_list" class="btn btn-outline-secondary elastic" title="add to tutor courses"><i class="fas fa-arrow-left"></i> Remove Selected from Tutor Courses</a>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <br>
                                                    Upload New Signature
                                                    <input type="file" class=" lb-lg"  id="edit_signature" name="edit_signature" />
                                                    <small class="text-danger error_msg" id="edit_signature_errors"></small>
                                                </div>
                                                <hr/>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <br>
                                                    Existing Signature
                                                    <img id="tutor_existing_signature" class="signature" src="{{url('/public/')}}" alt="tutor signature"/>
                                                </div>
                                                <hr/>
                                            </div>
                                        </div>

                                        <input type="hidden" id="total" name="total" value="{{$total}}" />
                                        <input type="hidden" id="totalPages" name="totalPages" value="{{$totalPages}}" />
                                        <input type="hidden" id="page_var" name="page_var" value="{{$page_var}}" />
                                        <input type="hidden" id="edit_tutor_id" name="edit_tutor_id" value="" />
                                        <input type="hidden" id="edit_chosen_courses_ids" name="edit_chosen_courses_ids" value="" />
                                        <input type="hidden" id="method" name="method" value="tutors_edit" />
                                        <div class="col-md-12">
                                            <input class="btn btn-primary" type="submit" id="confirmed_edit_tutor" name="confirmed_edit_tutor" value="Update Tutor" />
                                            <button type="button" id="cancelled_edit_tutor" class="btn btn-outline-secondary ">Cancel</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{--tutor Modal--}}
                    <div id="modal_iv_edit_action" class="modal modal_iv_edit_action" tabindex="-1" role="dialog">
                        <div class="edit-iv-modal-dialog modal_iv_edit_dialog" role="document">
                            <div class="modal-content align-items-center" style="padding: 0 20px;">
                                <div class="modal-body">
                                    <h3>Update IV <a href="#" title="close dialog" id="close_edit_iv_dialog" style="float: right;margin: 0 10px;"><i class="fa fa-close"></i></a></h3>
                                </div>
                                <div class="modal-footer">
                                    <form id="iv_edit_form" action="{{url('/manage-users/list/')}}/{{$page_var}}" method="POST" enctype="multipart/form-data" >
                                        {{ csrf_field() }}
                                        <div class="col-md-12 no-padding">
                                            <div class="col-md-12 no-padding">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        First Name
                                                        <input class="form-control lb-lg"  id="edit_iv_first_name" name="edit_iv_first_name" />
                                                        <small class="text-danger error_msg" id="edit_iv_first_name_errors"></small>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        Last Name
                                                        <input class="form-control lb-lg"  id="edit_iv_last_name" name="edit_iv_last_name" />
                                                        <small class="text-danger error_msg" id="edit_iv_last_name_errors"></small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 no-padding">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        Email
                                                        <input class="form-control lb-lg"  id="edit_iv_email" name="edit_iv_email" />
                                                        <small class="text-danger error_msg" id="edit_iv_email_errors"></small>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    Address
                                                    <input type="text" id="edit_iv_address" name="edit_iv_address" class="form-control lb-lg"/>
                                                    <small class="text-danger" id="edit_iv_address_errors"></small>
                                                </div>
                                            </div>

                                            <div class="col-md-12 no-padding">
                                                <div class="col-md-6">
                                                    Select Desired Courses
                                                    <select id="edit_iv_all_courses" name="edit_iv_all_courses" style="min-height: 120px;" class="form-control" multiple>
                                                        <?php
                                                        foreach($courses as $course){
                                                            echo '<option value="'.$course->id.'">'.$course->name.'</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                    <br>
                                                    <a href="#" id="add_courses_to_edit_iv_list" class="btn btn-outline-secondary elastic" title="add to IV courses">Add Selected to IV Courses <i class="fas fa-arrow-right"></i></a>
                                                </div>
                                                <div class="col-md-6">
                                                    Courses (Which Iv Provides Support For)
                                                    <select id="edit_iv_chosen_courses" name="edit_iv_chosen_courses" style="min-height: 120px;" class="form-control" multiple>
                                                    </select>
                                                    <br>
                                                    <a href="#" id="remove_courses_from_edit_iv_list" class="btn btn-outline-secondary elastic" title="add to IV courses"><i class="fas fa-arrow-left"></i> Remove Selected from IV Courses</a>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <br>
                                                    Upload New Signature
                                                    <input type="file" class=" lb-lg"  id="edit_iv_signature" name="edit_iv_signature" />
                                                    <small class="text-danger error_msg" id="edit_iv_signature_errors"></small>
                                                </div>
                                                <hr/>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <br>
                                                    Existing Signature
                                                    <img id="iv_existing_signature" class="signature" src="{{url('/public/')}}" alt="iv signature"/>
                                                </div>
                                                <hr/>
                                            </div>
                                        </div>

                                        <input type="hidden" id="total" name="total" value="{{$total}}" />
                                        <input type="hidden" id="totalPages" name="totalPages" value="{{$totalPages}}" />
                                        <input type="hidden" id="page_var" name="page_var" value="{{$page_var}}" />
                                        <input type="hidden" id="edit_iv_id" name="edit_iv_id" value="" />
                                        <input type="hidden" id="edit_iv_chosen_courses_ids" name="edit_iv_chosen_courses_ids" value="" />
                                        <input type="hidden" id="method" name="method" value="ivs_edit" />
                                        <div class="col-md-12">
                                            <input class="btn btn-primary" type="submit" id="confirmed_edit_iv" name="confirmed_edit_iv" value="Update IV" />
                                            <button type="button" id="cancelled_edit_iv" class="btn btn-outline-secondary ">Cancel</button>
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
        }, 3000);

        $("#add_courses_to_tutor_list").on("click", function (e) {
            var items = [];
            $("#all_courses").children("option:selected").each(function(){
                    $("#chosen_courses").html( $("#chosen_courses").html() + '<option value="'+$(this).val()+'">'+$(this).text()+'</option>');
                    $(this).remove();
                }
            );
        });

        $("#remove_courses_from_tutor_list").on("click", function (e) {
            var items = [];
            $("#chosen_courses").children("option:selected").each(function(){
                    $("#all_courses").html( $("#all_courses").html() + '<option value="'+$(this).val()+'">'+$(this).text()+'</option>');
                    $(this).remove();
                }
            );
        });


        //IV
        $("#add_courses_to_iv_list").on("click", function (e) {
            var items = [];
            $("#iv_all_courses").children("option:selected").each(function(){
                    $("#iv_chosen_courses").html( $("#iv_chosen_courses").html() + '<option value="'+$(this).val()+'">'+$(this).text()+'</option>');
                    $(this).remove();
                }
            );
        });

        $("#remove_courses_from_iv_list").on("click", function (e) {
            var items = [];
            $("#iv_chosen_courses").children("option:selected").each(function(){
                    $("#iv_all_courses").html( $("#iv_all_courses").html() + '<option value="'+$(this).val()+'">'+$(this).text()+'</option>');
                    $(this).remove();
                }
            );
        });

        //for edit tutors dialog
        $("#add_courses_to_edit_tutor_list").on("click", function (e) {
            var items = [];
            $("#edit_all_courses").children("option:selected").each(function(){
                    $("#edit_chosen_courses").html( $("#edit_chosen_courses").html() + '<option value="'+$(this).val()+'">'+$(this).text()+'</option>');
                    $(this).remove();
                }
            );
        });

        $("#remove_courses_from_edit_tutor_list").on("click", function (e) {
            var items = [];
            $("#edit_chosen_courses").children("option:selected").each(function(){
                    $("#edit_all_courses").html( $("#edit_all_courses").html() + '<option value="'+$(this).val()+'">'+$(this).text()+'</option>');
                    $(this).remove();
                }
            );
        });

        //for edit iv dialog
        $("#add_courses_to_edit_iv_list").on("click", function (e) {
            var items = [];
            $("#edit_iv_all_courses").children("option:selected").each(function(){
                    $("#edit_iv_chosen_courses").html( $("#edit_iv_chosen_courses").html() + '<option value="'+$(this).val()+'">'+$(this).text()+'</option>');
                    $(this).remove();
                }
            );
        });

        $("#remove_courses_from_edit_iv_list").on("click", function (e) {
            var items = [];
            $("#edit_iv_chosen_courses").children("option:selected").each(function(){
                    $("#edit_iv_all_courses").html( $("#edit_iv_all_courses").html() + '<option value="'+$(this).val()+'">'+$(this).text()+'</option>');
                    $(this).remove();
                }
            );
        });

        $("#tutors").on("click", function (e) {
            console.log("clicked tutor");
            var page = '<?php echo url("/")?>'+'/manage-users/list/1?t=tutors';
            window.location.href = page // Go
        });

        $("#admins").on("click", function (e) {
            console.log("clicked admins");
            var page = '<?php echo url("/")?>'+'/manage-users/list/1?t=admins';
            window.location.href = page // Go
        });

        $("#iv").on("click", function (e) {
            console.log("clicked iv");
            var page = '<?php echo url("/")?>'+'/manage-users/list/1?t=ivs';
            window.location.href = page // Go
        });

        $("#cancelled_tutor").on("click", function (e) {
            console.log("Cancelling tutor");
            $(".modal_tutor_action").hide();
        });

        $("#cancelled_iv").on("click", function (e) {
            console.log("Cancelling iv");
            $(".modal_iv_action").hide();
        });

        $("#cancelled_edit_iv").on("click", function (e) {
            console.log("Cancelling iv");
            $(".modal_iv_edit_action").hide();
        });

        $("#cancelled_admin").on("click", function (e) {
            console.log("Cancelling admin");
            $(".modal_admin_action").hide();
        });

        $("#cancelled_edit_admin").on("click", function (e) {
            console.log("Cancelling admin");
            $(".modal_admin_edit_action").hide();
        });

        $("#cancelled_edit_tutor").on("click", function (e) {
            console.log("Cancelling tutor");
            $(".modal_tutor_edit_action").hide();
        });

        $("#cancelled_delete").on("click", function (e) {
            console.log("Cancelling tutor");
            $(".modal_delete_action").hide();
        });

        $("#cancelled_admin_delete").on("click", function (e) {
            console.log("Cancelling admin");
            $(".modal_delete_admin_action").hide();
        });

        $("#cancelled_iv_delete").on("click", function (e) {
            console.log("Cancelling IV");
            $(".modal_delete_iv_action").hide();
        });

        $("#close_delete_dialog").on("click", function (e) {
            e.preventDefault();
            console.log("Cancelling delete");
            $(".modal_delete_action").hide();
        });

        $("#close_delete_admin_dialog").on("click", function (e) {
            e.preventDefault();
            console.log("Cancelling delete");
            $(".modal_delete_admin_action").hide();
        });

        $("#close_iv_dialog").on("click", function (e) {
            e.preventDefault();
            console.log("Cancelling delete");
            $(".modal_iv_action").hide();
        });

        $("#close_delete_iv_dialog").on("click", function (e) {
            e.preventDefault();
            console.log("Cancelling delete");
            $(".modal_delete_iv_action").hide();
        });

        $("#close_edit_iv_dialog").on("click", function (e) {
            e.preventDefault();
            console.log("Cancelling edit");
            $(".modal_iv_edit_action").hide();
        });

        $("#close_dialog").on("click", function (e) {
            e.preventDefault();
            console.log("Cancelling tutor");
            $(".modal_tutor_action").hide();
        });

        $("#close_admin_dialog").on("click", function (e) {
            e.preventDefault();
            console.log("Cancelling admin");
            $(".modal_admin_action").hide();
        });

        $("#close_admin_edit_dialog").on("click", function (e) {
            e.preventDefault();
            console.log("Cancelling admin edit");
            $(".modal_admin_edit_action").hide();
        });

        $("#close_edit_dialog").on("click", function (e) {
            e.preventDefault();
            console.log("Cancelling tutor");
            $(".modal_tutor_edit_action").hide();
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

        $(".delete_iv_action").on("click", function (e) {
            e.preventDefault();
            $("#modal_delete_iv_action").css('display','block');
            $("#modal_delete_iv_action").css({ top: '0%' });
            console.log("Processing Del Request:"+this.id);
            var str = this.id;
            var ids = str.split(/[\s_]+/);
            console.log("SPLITTED:" + ids[3]);
            $("#iv_delete_id").val(ids[3]);
        });

        $(".delete_admin_action").on("click", function (e) {
            e.preventDefault();
            $("#modal_delete_admin_action").css('display','block');
            $("#modal_delete_admin_action").css({ top: '0%' });
            console.log("Processing Del Request:"+this.id);
            var str = this.id;
            var ids = str.split(/[\s_]+/);
            console.log("SPLITTED:" + ids[3]);
            $("#admin_delete_id").val(ids[3]);
        });

        //get anchor id => delete_action_{1} and concatenate it to create modal id
        $("#new_tutor_btn").on("click", function () {
                //process tutor request
                $("#modal_tutor_action").css('display','block');
                $("#modal_tutor_action").css({ top: '0%' });
        });

        $("#new_iv_btn").on("click", function () {
                //process tutor request
                $("#modal_iv_action").css('display','block');
                $("#modal_iv_action").css({ top: '0%' });
        });

        $("#new_admin_btn").on("click", function () {
            //process tutor request
            $("#modal_admin_action").css('display','block');
            $("#modal_admin_action").css({ top: '0%' });
        });

        //get anchor id => delete_action_{1} and concatenate it to create modal id
        $(".edit_iv_action").on("click", function (e) {
            console.log("Processing Del Request:"+this.id);
            var str = this.id;
            var id = str.split(/[\s_]+/);
            console.log("SPLITTED:" + id[3]);
            $("#edit_iv_id").val(id[3]);

            //perform ajax call to get selected user data for modal dialog to be updated
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-XSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var formdata = new FormData($("#iv_edit_form")[0]);
            console.log("formdata");
            console.log(formdata);

            $.ajax({
                url: '{{ url('/get-user-by-id-ajax') }}',
                type: 'get',
                data:'edit_iv_id='+id[3]+'&method=ivs',
                processData: false,
                contentType: false,
                success: function (response) {
                    // console.log('full resp:');
                    // console.log(response);

                    //set values to edit tutor dialog fields
                    $("#edit_iv_first_name").val(response[0]['first_name']);
                    $("#edit_iv_last_name").val(response[0]['last_name']);
                    $("#edit_iv_email").val(response[0]['email']);
                    $("#edit_iv_address").val(response[0]['address']);
                    $("#iv_existing_signature").attr("src", '<?php echo url("/");?>/public/'+response[0]["signature"]);
                    //console.log('asssigned courses:'+response[0]['assigned_courses']);
                    var chosen_course_ids = response[0]['assigned_courses'].split(',');
                    chosen_course_ids = chosen_course_ids.filter(item => item);

                    $("#edit_iv_all_courses").children().each(function(){
                        if(chosen_course_ids.includes($(this).val())){
                            console.log('GOT IT:'+$(this).val());
                            $("#edit_iv_chosen_courses").html( $("#edit_iv_chosen_courses").html() + '<option value="'+$(this).val()+'">'+$(this).text()+'</option>');
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
            //process tutor request
            $("#modal_iv_edit_action").css('display','block');
            $("#modal_iv_edit_action").css({ top: '0%' });
        });

        //edit IV
        $(".edit_action").on("click", function (e) {
            console.log("Processing Del Request:"+this.id);
            var str = this.id;
            var id = str.split(/[\s_]+/);
            console.log("SPLITTED:" + id[2]);
            $("#edit_tutor_id").val(id[2]);

            //perform ajax call to get selected user data for modal dialog to be updated
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-XSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var formdata = new FormData($("#add_tutor_edit_form")[0]);
            console.log("formdata");
            console.log(formdata);

            $.ajax({
                url: '{{ url('/get-user-by-id-ajax') }}',
                type: 'get',
                data:'edit_tutor_id='+id[2]+'&method=tutors',
                processData: false,
                contentType: false,
                success: function (response) {
                    // console.log('full resp:');
                    // console.log(response);

                    //set values to edit tutor dialog fields
                    $("#edit_first_name").val(response[0]['first_name']);
                    $("#edit_last_name").val(response[0]['last_name']);
                    $("#edit_tutor_email").val(response[0]['email']);
                    $("#edit_tutor_address").val(response[0]['address']);
                    $("#edit_employment_status").val(response[0]['employment_status']);
                    $("#tutor_existing_signature").attr("src", '<?php echo url("/");?>/public/'+response[0]["signature"]);
                    //console.log('asssigned courses:'+response[0]['assigned_courses']);
                    var chosen_course_ids = response[0]['assigned_courses'].split(',');
                    chosen_course_ids = chosen_course_ids.filter(item => item);
                    //console.log('array:');
                    //console.log(chosen_course_ids);

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

            //process tutor request
            $("#modal_tutor_edit_action").css('display','block');
            $("#modal_tutor_edit_action").css({ top: '0%' });
        });


        //get anchor id => delete_action_{1} and concatenate it to create modal id
        $(".edit_admin_action").on("click", function (e) {
            console.log("Processing Del Request:"+this.id);
            var str = this.id;
            var id = str.split(/[\s_]+/);
            console.log("SPLITTED:" + id[3]);
            $("#edit_admin_id").val(id[3]);

            //perform ajax call to get selected user data for modal dialog to be updated
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-XSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: '{{ url('/get-user-by-id-ajax') }}',
                type: 'get',
                data:'edit_admin_id='+id[3]+'&method=admins',
                processData: false,
                contentType: false,
                success: function (response) {
                    //set values to edit tutor dialog fields
                    $("#edit_admin_first_name").val(response[0]['first_name']);
                    $("#edit_admin_last_name").val(response[0]['last_name']);
                    $("#edit_admin_email").val(response[0]['email']);
                },
                error: function (data) {
                    console.log(data);
                    console.log('scroll error'+error_scroll);
                    $('#'+error_scroll).focus();
                }
            });

            //process tutor request
            $("#modal_admin_edit_action").css('display','block');
            $("#modal_admin_edit_action").css({ top: '0%' });
        });


        function formatDate(date) {
            var d = new Date(date),
                month = '' + (d.getMonth() + 1),
                day = '' + d.getDate(),
                year = d.getFullYear();

            if (month.length < 2) month = '0' + month;
            if (day.length < 2) day = '0' + day;

            return [day, month, year ].join('/');
        }

        //add student form submission code
        $("#confirmed_edit_tutor").click(function (e) {
            var error_scroll = '';
            //add rules
            //min length
            if ($('#edit_first_name').val().length <= 0) {
                $('#edit_first_name_errors').text('Please provide first name');
                return false;
            } else {
                $('#edit_first_name_errors').text('');
            }

            if ($('#edit_last_name').val().length <= 0) {
                $('#edit_last_name_errors').text('Please provide last name');
                return false;
            } else {
                $('#edit_last_name_errors').text('');
            }

            if ($('#edit_tutor_email').val().length <= 0) {
                $('#edit_tutor_email_errors').text('Please provide tutor email');
                return false;
            } else {
                $('#edit_tutor_email_errors').text('');
            }

            var course_ids_str = '';
            $("#edit_chosen_courses option").each(function(){
                console.log('current:'+$(this).val());
                course_ids_str += $(this).val()+',';
            });
            $('#edit_chosen_courses_ids').val(course_ids_str);
            console.log('choses courses:'+course_ids_str);

            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-XSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var formdata = new FormData($("#add_tutor_edit_form")[0]);
            console.log("formdata");
            console.log(formdata);

            $.ajax({
                url: '{{ url('/manage-users/list/1') }}',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (response) {
                    $('#success-alert').html('<h3>Tutor Updated Successfully</h3>');

                    $("#confirmed_edit_tutor").attr('disabled',true);

                    //clear all fields

                    $('#success-alert').focus();
                    $("#success-alert").fadeTo(2000, 500).slideUp(500, function () {
                        //$("#create_users").attr("disabled", true);
                        //$("#create-user-form").css("display", 'none');
                        $("#success-alert").css("height", "0px");
                        $("#success-alert").css("display", "block");
                        var page = '<?php echo url("/")?>'+'/manage-users/list/1?t=tutors';
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
        $("#confirmed_edit_iv").click(function (e) {
            var error_scroll = '';
            //add rules
            //min length
            if ($('#edit_iv_first_name').val().length <= 0) {
                $('#edit_iv_first_name_errors').text('Please provide first name');
                return false;
            } else {
                $('#edit_iv_first_name_errors').text('');
            }

            if ($('#edit_iv_last_name').val().length <= 0) {
                $('#edit_iv_last_name_errors').text('Please provide last name');
                return false;
            } else {
                $('#edit_iv_last_name_errors').text('');
            }

            if ($('#edit_iv_email').val().length <= 0) {
                $('#edit_iv_email_errors').text('Please provide email');
                return false;
            } else {
                $('#edit_iv_email_errors').text('');
            }

            var course_ids_str = '';
            $("#edit_iv_chosen_courses option").each(function(){
                console.log('current:'+$(this).val());
                course_ids_str += $(this).val()+',';
            });
            $('#edit_iv_chosen_courses_ids').val(course_ids_str);
            console.log('choses courses:'+course_ids_str);

            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-XSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var formdata = new FormData($("#iv_edit_form")[0]);
            console.log("formdata");
            console.log(formdata);

            $.ajax({
                url: '{{ url('/manage-users/list/1') }}',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (response) {
                    $('#success-alert').html('<h3>IV Updated Successfully</h3>');

                    $("#confirmed_edit_iv").attr('disabled',true);

                    //clear all fields

                    $('#success-alert').focus();
                    $("#success-alert").fadeTo(2000, 500).slideUp(500, function () {
                        //$("#create_users").attr("disabled", true);
                        //$("#create-user-form").css("display", 'none');
                        $("#success-alert").css("height", "0px");
                        $("#success-alert").css("display", "block");
                        var page = '<?php echo url("/")?>'+'/manage-users/list/1?t=ivs';
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

        //add tutor form submission code
        $("#confirmed_tutor").click(function (e) {
            var error_scroll = '';
            //add rules
            //min length
            if ($('#first_name').val().length <= 0) {
                $('#first_name_errors').text('Please provide first name');
                return false;
            } else {
                $('#first_name_errors').text('');
            }

            if ($('#last_name').val().length <= 0) {
                $('#last_name_errors').text('Please provide last name');
                return false;
            } else {
                $('#last_name_errors').text('');
            }

            if ($('#tutor_email').val().length <= 0) {
                $('#tutor_email_errors').text('Please provide tutor email');
                return false;
            } else {
                $('#tutor_email_errors').text('');
            }

            var course_ids_str = '';
            $("#chosen_courses option").each(function(){
                console.log('current:'+$(this).val());
                course_ids_str += $(this).val()+',';
            });
            $('#chosen_courses_ids').val(course_ids_str);

            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-XSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var formdata = new FormData($("#add_tutor_form")[0]);
            console.log("formdata");
            console.log(formdata);

            $.ajax({
                url: '{{ url('/manage-users/list/1') }}',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (response) {
                    $("#confirmed_tutor").attr('disabled',true);
                    //clear all fields
                    $('#success-alert').focus();
                    $("#success-alert").fadeTo(2000, 500).slideUp(500, function () {
                        $("#success-alert").css("height", "0px");
                        $("#success-alert").css("display", "block");
                        var page = '<?php echo url("/")?>/manage-users/list/1?t=tutors';
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


        //add tutor form submission code
        $("#confirmed_iv").click(function (e) {
            var error_scroll = '';
            //add rules
            //min length
            if ($('#iv_first_name').val().length <= 0) {
                $('#iv_first_name_errors').text('Please provide first name');
                return false;
            } else {
                $('#iv_first_name_errors').text('');
            }

            if ($('#iv_last_name').val().length <= 0) {
                $('#iv_last_name_errors').text('Please provide last name');
                return false;
            } else {
                $('#iv_last_name_errors').text('');
            }

            if ($('#iv_email').val().length <= 0) {
                $('#iv_email_errors').text('Please provide email');
                return false;
            } else {
                $('#iv_email_errors').text('');
            }

            var course_ids_str = '';
            $("#iv_chosen_courses option").each(function(){
                console.log('current:'+$(this).val());
                course_ids_str += $(this).val()+',';
            });
            $('#iv_chosen_courses_ids').val(course_ids_str);

            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-XSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var formdata = new FormData($("#add_iv_form")[0]);
            console.log("formdata");
            console.log(formdata);

            $.ajax({
                url: '{{ url('/manage-users/list/1') }}',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (response) {
                    $("#confirmed_iv").attr('disabled',true);
                    //clear all fields
                    $('#success-alert').focus();
                    $("#success-alert").fadeTo(2000, 500).slideUp(500, function () {
                        $("#success-alert").css("height", "0px");
                        $("#success-alert").css("display", "block");
                        var page = '<?php echo url("/")?>/manage-users/list/1?t=ivs';
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

        //add admin form submission code
        $("#confirmed_admin").click(function (e) {
            var error_scroll = '';
            //add rules
            //min length
            if ($('#admin_first_name').val().length <= 0) {
                $('#admin_first_name_errors').text('Please provide first name');
                return false;
            } else {
                $('#admin_first_name_errors').text('');
            }

            if ($('#admin_last_name').val().length <= 0) {
                $('#admin_last_name_errors').text('Please provide last name');
                return false;
            } else {
                $('#admin_last_name_errors').text('');
            }

            if ($('#admin_email').val().length <= 0) {
                $('#admin_email_errors').text('Please provide admin email');
                return false;
            } else {
                $('#admin_email_errors').text('');
            }

            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-XSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var formdata = new FormData($("#add_admin_form")[0]);
            console.log("formdata");
            console.log(formdata);

            $.ajax({
                url: '{{ url('/manage-users/list/1') }}',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (response) {
                    console.log('we are here');
                    $("#confirmed_admin").attr('disabled',true);
                    $('#success-alert').html('<h3>Admin Created Successfully</h3>');

                    //clear all fields
                    $('#success-alert').focus();
                    $("#success-alert").fadeTo(2000, 500).slideUp(500, function () {
                        //$("#create_users").attr("disabled", true);
                        //$("#create-user-form").css("display", 'none');
                        $("#success-alert").css("height", "0px");
                        $("#success-alert").css("display", "block");
                        var page = '<?php echo url("/")?>/manage-users/list/1?t=admins';
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
        $("#confirmed_edit_admin").click(function (e) {
            var error_scroll = '';
            //add rules
            //min length
            if ($('#edit_admin_first_name').val().length <= 0) {
                $('#edit_admin_first_name_errors').text('Please provide first name');
                return false;
            } else {
                $('#edit_admin_first_name_errors').text('');
            }

            if ($('#edit_admin_last_name').val().length <= 0) {
                $('#edit_admin_last_name_errors').text('Please provide last name');
                return false;
            } else {
                $('#edit_admin_last_name_errors').text('');
            }

            if ($('#edit_admin_email').val().length <= 0) {
                $('#edit_admin_email_errors').text('Please provide admin email');
                return false;
            } else {
                $('#edit_admin_email_errors').text('');
            }

            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-XSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var formdata = new FormData($("#edit_admin_form")[0]);
            console.log("formdata");
            console.log(formdata);

            $.ajax({
                url: '{{ url('/manage-users/list/1') }}',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (response) {
                    $('#success-alert').html('<h3>Admin Updated Successfully</h3>');
                    $("#confirmed_edit_admin").attr('disabled',true);
                    //clear all fields
                    $('#success-alert').focus();
                    $("#success-alert").fadeTo(2000, 500).slideUp(500, function () {
                        $("#success-alert").css("height", "0px");
                        $("#success-alert").css("display", "block");
                        var page = '<?php echo url("/")?>'+'/manage-users/list/1?t=admins';
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