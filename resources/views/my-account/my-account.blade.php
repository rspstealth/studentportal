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
                        <h3>My Account</h3>
                        <hr/>
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
                            <h3>Account Updated Successfully</h3>
                        </div>
                    </div>

                    <form id="user_profile_form" action="{{url('/my-account')}}/" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
                                <div class="col-md-12 no-padding">
                                    <div class="col-md-8 no-padding">
                                        <div class="col-md-12 no-padding">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    First Name
                                                    <input class="form-control lb-lg" required="" id="first_name" name="first_name" value="{{$user->first_name}}"/>
                                                    <small class="text-danger error_msg" id="first_name_errors"></small>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    Last Name
                                                    <input class="form-control lb-lg" required="" id="last_name" name="last_name" value="{{$user->last_name}}"/>
                                                    <small class="text-danger error_msg" id="last_name_errors"></small>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12 no-padding">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    Email
                                                    <input class="form-control lb-lg" required="" id="email" name="email" value="{{$user->email}}"/>
                                                    <small class="text-danger error_msg" id="email_errors"></small>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    Mobile Number
                                                    <input class="form-control lb-lg"  id="mobile" name="mobile" value="{{$user->mobile_number}}"/>
                                                    <small class="text-danger error_msg" id="mobile_errors"></small>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                Address
                                                <textarea class="form-control lb-lg" id="address" name="address" cols="1" rows="2">{{$user->address}}</textarea>
                                                <small class="text-danger error_msg" id="email_errors"></small>
                                            </div>
                                        </div>
                                        <?php
                                        //when to show signature
                                        if(array_key_exists('signature_text',$user)){
                                        ?>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                Signature Text
                                                <textarea class="form-control lb-lg" id="signature_text" name="signature_text" cols="1" rows="2">{{$user->signature_text}}</textarea>
                                                <small class="text-danger error_msg" id="signature_text_errors"></small>
                                            </div>
                                        </div>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        Profile Photo
                                        <br>
                                        <div class="upload-btn-wrapper">
                                            <?php
                                            if(!empty($user->photo_id)){
                                            ?>
                                                <img id="user_photo" name="user_photo" src="{{url('/public').'/'.$user->photo_id}}" alt="{{$user->first_name}} profile image"/>
                                            <?php
                                            }else{
                                                echo '<i class="profile_image fas fa-user"></i>';
                                            }
                                            ?>
                                            <br>
                                            <input type="file" id="photo" name="photo">
                                        </div>
                                        <br>
                                        <br>
                                        Click Portrait to Upload Profile Photo
                                        <br>
                                        <br>
                                        <a href="#" id="delete_photo" class="">Delete Profile Photo</a>
                                    </div>
                                </div>

                               <div class="col-md-12">
                                   <br>
                                   <br>
                                   <br>
                                   <br>
                                   <br>
                                   <hr/>
                                   <input class="btn btn-primary" type="submit" id="update_profile" name="update_profile" value="Update Profile" />
                                   <br><br><br><br>
                               </div>
                    </form>

                    <div id="modal_delete_action" class="modal modal_delete_action" tabindex="-1" role="dialog">
                        <div class="delete-modal-dialog modal_delete_dialog" role="document">
                            <div class="modal-content align-items-center">
                                <div class="modal-body">
                                    <h3>Confirm Photo Removal? <a href="#" title="Close Dialog" id="close_delete_dialog" style="float: right;margin: 0 10px;"><i class="fa fa-close"></i></a></h3>
                                </div>
                                <div class="modal-footer">
                                    <form id="del_selected_form" action="{{url('/my-account/')}}" method="POST">
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
                </div>
            </div>
        </div>
    </div>

<script>
    (function(){
        $("#cancelled_delete").on("click", function (e) {
            console.log("Cancelling delete");
            $(".modal_delete_action").hide();
        });
        $("#close_delete_dialog").on("click", function (e) {
            console.log("Cancelling delete");
            $(".modal_delete_action").hide();
        });

        $("#delete_photo").on("click", function (e) {
            e.preventDefault();
            $("#modal_delete_action").css('display','block');
            $("#modal_delete_action").css({ top: '0%' });
             console.log("Processing Del Request:"+this.id);
        });

        $("#update_profile").click(function (e) {
            var error_scroll = '';
            //min length
            if ($('#first_name').val().length <= 0) {
                $('#first_name_errors').text('Please enter your first name');
                return false;
            } else {
                $('#first_name_errors').text('');
            }
            if ($('#last_name').val().length <= 0) {
                $('#last_name_errors').text('Please enter your last name');
                return false;
            } else {
                $('#last_name_errors').text('');
            }
            if ($('#email').val().length <= 0) {
                $('#email_errors').text('Please enter a valid email address');
                return false;
            } else {
                $('#email_errors').text('');
            }

            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-XSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var formdata = new FormData($("#user_profile_form")[0]);
            console.log("formdata");
            console.log(formdata);

            $.ajax({
                url: '{{ url('/my-account/') }}',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (response) {
                    console.log(response);
                    $('#success-alert').html('<h3>Account Updated Successfully</h3>');
                    $('#success-alert').focus();
                    $("#success-alert").fadeTo(2000, 500).slideUp(500, function () {
                        $("#success-alert").css("height", "0px");
                        $("#success-alert").css("display", "block");
                        var page = '<?php echo url("/")?>'+'/my-account';
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