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
                        <div class="col-12" style="padding:20px 0;padding-bottom: 0;">
                            <div class="col-md-6">
                                    <div class="stats_card col-md-12">
                                        <h3 class="text-center">Student log in stats</h3>
                                        <div class=" col-md-4">
                                            <h3 class="text-center">0</h3>
                                            <h5 class="text-center">Today</h5>
                                        </div>
                                        <div class=" col-md-4">
                                            <h3 class="text-center">0</h3>
                                            <h5 class="text-center">Weekly</h5>
                                        </div>
                                        <div class=" col-md-4">
                                            <h3 class="text-center">0</h3>
                                            <h5 class="text-center">Monthly</h5>
                                        </div>
                                    </div>

                                    <div class="stats_card col-md-12">
                                        <h3 class="text-center">Tutor log in stats</h3>
                                        <div class=" col-md-4">
                                            <h3 class="text-center">0</h3>
                                            <h5 class="text-center">Today</h5>
                                        </div>
                                        <div class=" col-md-4">
                                            <h3 class="text-center">0</h3>
                                            <h5 class="text-center">Weekly</h5>
                                        </div>
                                        <div class=" col-md-4">
                                            <h3 class="text-center">0</h3>
                                            <h5 class="text-center">Monthly</h5>
                                        </div>
                                    </div>

                                <div class="stats_card col-md-12">
                                    <h3 class="text-center">Current week assignments</h3>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>
                                            <tr><td>student name</td><td>0</td></tr>
                                            <tr><td>student name</td><td>0</td></tr>
                                            <tr><td>student name</td><td>0</td></tr>
                                            <tr><td>student name</td><td>0</td></tr>
                                            <tr><td>student name</td><td>0</td></tr>
                                            <tr><td>student name</td><td>0</td></tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="stats_card col-md-12">
                                    <h3 class="text-center">Current week units</h3>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>
                                            <tr><td>student name</td><td><small>Last 30 days: 00</small></td><td><small>Current week: 0</small></td></tr>
                                            <tr><td>student name</td><td><small>Last 30 days: 00</small></td><td><small>Current week: 0</small></td></tr>
                                            <tr><td>student name</td><td><small>Last 30 days: 00</small></td><td><small>Current week: 0</small></td></tr>
                                            <tr><td>student name</td><td><small>Last 30 days: 00</small></td><td><small>Current week: 0</small></td></tr>
                                            <tr><td>student name</td><td><small>Last 30 days: 00</small></td><td><small>Current week: 0</small></td></tr>
                                            <tr><td>student name</td><td><small>Last 30 days: 00</small></td><td><small>Current week: 0</small></td></tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="stats_card col-md-12">
                                    <h3 class="text-center">Current week assignments</h3>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>
                                            <tr><td>student name - 0</td><td>(Avg: 0 Days)</td></tr>
                                            <tr><td>student name - 0</td><td>(Avg: 0 Days)</td></tr>
                                            <tr><td>student name - 0</td><td>(Avg: 0 Days)</td></tr>
                                            <tr><td>student name - 0</td><td>(Avg: 0 Days)</td></tr>
                                            <tr><td>student name - 0</td><td>(Avg: 0 Days)</td></tr>
                                            <tr><td>student name - 0</td><td>(Avg: 0 Days)</td></tr>
                                            <tr><td>student name - 0</td><td>(Avg: 0 Days)</td></tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>

                            <div class="col-md-6">
                                <div class="stats_card col-md-12">
                                    <h3 class="text-center">Admin log in stats</h3>
                                    <div class=" col-md-4">
                                        <h3 class="text-center">0</h3>
                                        <h5 class="text-center">Today</h5>
                                    </div>
                                    <div class=" col-md-4">
                                        <h3 class="text-center">0</h3>
                                        <h5 class="text-center">Weekly</h5>
                                    </div>
                                    <div class=" col-md-4">
                                        <h3 class="text-center">0</h3>
                                        <h5 class="text-center">Monthly</h5>
                                    </div>
                                </div>

                                <div class="stats_card col-md-12">
                                    <h3 class="text-center">Active Students stats</h3>
                                    <div class=" col-md-4">
                                        <h3 class="text-center">0</h3>
                                        <h5 class="text-center">Last 30 days</h5>
                                    </div>
                                    <div class=" col-md-4">
                                        <h3 class="text-center">0</h3>
                                        <h5 class="text-center">Last 60 days</h5>
                                    </div>
                                    <div class=" col-md-4">
                                        <h3 class="text-center">0</h3>
                                        <h5 class="text-center">Completed Course</h5>
                                    </div>
                                </div>

                                <div class="stats_card col-md-12">
                                    <h3 class="text-center">Marking average time</h3>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>
                                            <tr><td>student name</td><td>(Avg: 0 Min)</td></tr>
                                            <tr><td>student name</td><td>(Avg: 0 Min)</td></tr>
                                            <tr><td>student name</td><td>(Avg: 0 Min)</td></tr>
                                            <tr><td>student name</td><td>(Avg: 0 Min)</td></tr>
                                            <tr><td>student name</td><td>(Avg: 0 Min)</td></tr>
                                            <tr><td>student name</td><td>(Avg: 0 Min)</td></tr>
                                            <tr><td>student name</td><td>(Avg: 0 Min)</td></tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="stats_card col-md-12">
                                    <h3 class="text-center">Ticket reply stats last 30 days</h3>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <td>Admin Support</td>
                                                <td>Tutors</td>
                                                <td>Admin</td>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td></td> <td>student name (0)</td> <td>(Avg: 0 Min)</td>   </tr>
                                                <td></td> <td>student name (0)</td> <td>(Avg: 0 Min)</td>   </tr>
                                                <td></td> <td>student name (0)</td> <td>(Avg: 0 Min)</td>   </tr>
                                                <td></td> <td>student name (0)</td> <td>(Avg: 0 Min)</td>   </tr>
                                                <td></td> <td>student name (0)</td> <td>(Avg: 0 Min)</td>   </tr>
                                                <td></td> <td>student name (0)</td> <td>(Avg: 0 Min)</td>   </tr>
                                                <td></td> <td>student name (0)</td> <td>(Avg: 0 Min)</td>   </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <script>


        (function () {
            setTimeout(function () {
                $('.alert-success').fadeOut('slow');
            }, 3000); // <-- time in milliseconds
            setTimeout(function () {
                $('.alert-danger').fadeOut('slow');
            }, 3000); // <-- time in milliseconds

            $(".save_settings").click(function (e) {
                e.preventDefault();

                //min length
                // if ($('#overdue_assignment_duration').val().length <= 0) {
                //     $('#overdue_assignment_duration_errors').text('Days value must be a number');
                //     return false;
                // } else {
                //     $('#overdue_assignment_duration_errors').text('');
                // }
                // if ($('#priority_students_marking_duration').val().length <= 0) {
                //     $('#priority_students_marking_duration_errors').text('Days value must be a number');
                //     return false;
                // } else {
                //     $('#priority_students_marking_duration_errors').text('');
                // }


                $.ajaxSetup({
                    headers: {
                        'X-XSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                var formdata = new FormData($("#system_settings_form")[0]);
                console.log("formdata");
                console.log(formdata);

                $.ajax({
                    url: '{{ url('/settings/system-settings/') }}',
                    type: 'POST',
                    data: formdata,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        console.log('response');
                        console.log(response);
                        if(response == 'Success'){
                            $("#success-alert").css("height", "50px");
                            $('#success-alert').html('<h3>Settings Updated Successfully</h3>');
                            $('#success-alert').focus();
                            $("#success-alert").fadeTo(2000, 500).slideUp(500, function () {
                                $("#success-alert").css("height", "0px");
                                $("#success-alert").css("display", "block");
                            });
                        }
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