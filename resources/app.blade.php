<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="https://fonts.googleapis.com/css?family=Lato|Roboto" rel="stylesheet">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Icons Css -->
    <link media="all" type="text/css" rel="stylesheet" href="{{ asset('css/font-awesome/css/font-awesome.min.css') }}">
    <link media="all" type="text/css" rel="stylesheet" href="{{ asset('css/icomoon/style.css') }}">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <script src="{{ asset('css/bootstrap-3.3.7-dist/js/jquery-3.2.1.min.js') }}"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    {{--<!-- Latest compiled and minified JavaScript -->--}}
    {{--<script src="{{ asset('css/bootstrap-3.3.7-dist/css/bootstrap.css') }}"></script>--}}
    {{--<script src="{{ asset('css/bootstrap-3.3.7-dist/css/bootstrap-theme.css') }}"></script>--}}
    {{--<script src="{{ asset('css/bootstrap-3.3.7-dist/js/bootstrap.min.js') }}"></script>--}}
    <!-- Country Code Jquery -->


    <!-- Angular JS -->
    {{--<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.2/angular.min.js"></script>--}}
    {{--<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.2/angular-route.min.js"></script>--}}
    <link media="all" type="text/css" rel="stylesheet" href="{{ asset('css/style.css') }}">

    <!-- MY App -->
    {{--<script src="{{ asset('app/packages/dirPagination.js') }}"></script>--}}
    {{--<script src="{{ asset('angular/routes.js') }}"></script>--}}
</head>
<body >
    <div id="app">
        <nav class="navbar navbar-default navbar-fixed-top padding-y-md">
            <div class="container-fluid">
                <div class="navbar-header">
                    <?php
                    if (\Request::is('register') || \Request::is('login') || \Request::is('my-account') || \Request::is('setup-dashboard')) {
                    }else{
                        echo '<button type="button" class="btn btn-default menu-circle btn-lg" id="menu-toggle">
                                <i class="fa fa-bars"></i>
                            </button>';
                    }
                    ?>


                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="logo" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">

                        <!-- Authentication Links -->
                        @guest
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @else
                            <?php
                            if (\Request::is('register') || \Request::is('login') || \Request::is('my-account') || \Request::is('setup-dashboard')) {

                            }else{
                            ?>
                            <li class="dropdown head-dpdn">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-envelope"></i><span class="badge">3</span></a>
                                <ul class="dropdown-menu anti-dropdown-menu w3l-msg">
                                    <li>
                                        <div class="notification_header">
                                            <p>You have 3 new messages</p>
                                        </div>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="user_img"><img src="images/1.png" alt="no img">
                                                Lorem ipsum dolor amet
                                            </div>
                                            <div class="clearfix"></div>
                                        </a>
                                    </li>
                                    <li class="odd">
                                        <a href="#">
                                            <div class="user_img"><img src="images/1.png" alt="no img">
                                                Lorem ipsum dolor amet
                                            </div>
                                            <div class="clearfix"></div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="user_img"><img src="images/1.png" alt="no img">
                                                Lorem ipsum dolor amet
                                            </div>
                                            <div class="clearfix"></div>
                                        </a>
                                    <li>
                                        <div class="notification_bottom">
                                            <a href="#">See all messages</a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <li class="dropdown head-dpdn">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-bell"></i><span class="badge blue">3</span></a>
                                <ul class="dropdown-menu anti-dropdown-menu agile-notification">
                                    <li>
                                        <div class="notification_header">
                                            <h3>You have 3 new notifications</h3>
                                        </div>
                                    </li>
                                    <li><a href="#">
                                            <div class="user_img"><img src="images/2.png" alt=""></div>
                                            <div class="notification_desc">
                                                <p>Lorem ipsum dolor amet</p>
                                                <p><span>1 hour ago</span></p>
                                            </div>
                                            <div class="clearfix"></div>
                                        </a></li>
                                    <li class="odd"><a href="#">
                                            <div class="user_img"><img src="images/1.png" alt=""></div>
                                            <div class="notification_desc">
                                                <p>Lorem ipsum dolor amet </p>
                                                <p><span>1 hour ago</span></p>
                                            </div>
                                            <div class="clearfix"></div>
                                        </a></li>
                                    <li><a href="#">
                                            <div class="user_img"><img src="images/3.png" alt=""></div>
                                            <div class="notification_desc">
                                                <p>Lorem ipsum dolor amet </p>
                                                <p><span>1 hour ago</span></p>
                                            </div>
                                            <div class="clearfix"></div>
                                        </a></li>
                                    <li>
                                        <div class="notification_bottom">
                                            <a href="#">See all notifications</a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <li class="dropdown head-dpdn">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-tasks"></i><span class="badge blue1">15</span></a>
                                <ul class="dropdown-menu anti-dropdown-menu agile-task">
                                    <li>
                                        <div class="notification_header">
                                            <h3>You have 8 pending tasks</h3>
                                        </div>
                                    </li>
                                    <li><a href="#">
                                            <div class="task-info">
                                                <span class="task-desc">Database update</span><span class="percentage">40%</span>
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="progress progress-striped active">
                                                <div class="bar yellow" style="width:40%;"></div>
                                            </div>
                                        </a></li>
                                    <li><a href="#">
                                            <div class="task-info">
                                                <span class="task-desc">Dashboard done</span><span class="percentage">90%</span>
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="progress progress-striped active">
                                                <div class="bar green" style="width:90%;"></div>
                                            </div>
                                        </a></li>
                                    <li><a href="#">
                                            <div class="task-info">
                                                <span class="task-desc">Mobile App</span><span class="percentage">33%</span>
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="progress progress-striped active">
                                                <div class="bar red" style="width: 33%;"></div>
                                            </div>
                                        </a></li>
                                    <li><a href="#">
                                            <div class="task-info">
                                                <span class="task-desc">Issues fixed</span><span class="percentage">80%</span>
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="progress progress-striped active">
                                                <div class="bar  blue" style="width: 80%;"></div>
                                            </div>
                                        </a></li>
                                    <li>
                                        <div class="notification_bottom">
                                            <a href="#">See all pending tasks</a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <?php
                                }
                                ?>

                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle profile-logo" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                                    <?php
                                    $words = explode(" ", Auth::user()->name);
                                    $acronym = "";
                                    foreach ($words as $w) {
                                        $acronym .= $w[0];
                                    }
                                    echo strtoupper($acronym);
                                    ?>
                                </a>
                                {{--<span class="caret"></span>--}}
                                <ul class="dropdown-menu profile-panel">
                                    <div class="row margin-bottom-md">
                                        <div class="col-md-4 no-padding">
                                            <div class="profile-logo-medium margin-left-md">
                                                <img src="" title="No Image"/>
                                            </div>
                                        </div>
                                        <div class="col-md-6 no-padding">
                                            <b>{{Auth::user()->name}}</b>
                                        </div>
                                        <div class="col-md-6 no-padding">
                                            <p>{{Auth::user()->email}}</p>
                                        </div>
                                    </div>
                                    <div class="row profile-panel padding-y-lg">
                                        <div class="col-md-6 no-padding">
                                                <a class="btn-block" href="/my-account">
                                                    My Account
                                                </a>
                                        </div>
                                        <div class="col-md-6 no-padding text-right">
                                                <a class="btn-block" href="{{ route('logout') }}"
                                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                                    Logout
                                                </a>

                                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                    {{ csrf_field() }}
                                                </form>
                                        </div>


                                    </div>

                                </ul>
                            </li>
                            <div class="clearfix"> </div>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container-fluid" id="wrapper">
        @section('sidebar')
            <!-- Sidebar -->
                <div class="sidebar-menu" id="sidebar-wrapper">
                    <ul id="main-menu" class="main-menu" style="">
                        <!-- add class "multiple-expanded" to allow multiple submenus to open -->
                        <!-- class "auto-inherit-active-class" will automatically add "active" class for parent elements who are marked already with class "active" -->

                        <!-- DASHBOARD -->
                        <li class="root-level">
                            <a href="/home">
                                <i class="icon-dashboard"></i>
                                <span style="">Dashboard</span>
                            </a>
                        </li>

                        <!-- SESSION -->
                        <li class="root-level">
                            <a href="/session">
                                <i class="icon-calendar"></i>
                                <span style="">Manage Session</span>
                            </a>
                        </li>

                        <!-- STUDENT -->
                        <li id="students" class="has-sub root-level">
                            <a href="#">
                                <i class="icon-users"></i>
                                <span style="">Students</span>
                                <i class="fa fa-angle-down dropdown-b down-arrow"></i>
                            </a>
                            <ul class="sub-menu" id="students_ul">
                                <!-- STUDENT ADMISSION -->
                                <li>
                                    <a href="/add-student">
                                        <i class="icon-dot-single"></i>
                                        <span> Add Student</span>
                                    </a>
                                </li>

                                <!-- STUDENT BULK ADMISSION -->
                                <li class=" ">
                                    <a href="">
                                        <i class="icon-dot-single"></i>
                                        <span>Add Bulk Student</span>
                                    </a>
                                </li>

                                <!-- STUDENT INFORMATION -->
                                <li class="has-sub">
                                    <a href="#">
                                        <i class="icon-dot-single"></i>
                                        <span> Student Information</span>
                                    </a>
                                    <ul class="sub-menu cosellap">
                                        <li class="">
                                            <a href="">
                                                <i class="icon-dot-single"></i>
                                                <span style="">class KG</span>
                                            </a>
                                        </li>
                                        <li class="">
                                            <a href="">
                                                <i class="icon-dot-single"></i>
                                                <span style="">class Primary One</span>
                                            </a>
                                        </li>
                                        <li class="">
                                            <a href="">
                                                <i class="icon-dot-single"></i>
                                                <span style="">class PRIMARY THREE</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>



                            </ul>
                        </li>

                        <!-- ENQUIRY TABLE INFO -->
                        <li class="root-level">
                            <a href="academic_syllabus">
                                <i class="icon-books"></i>
                                <span style="">Academic Syllabus</span>
                            </a>
                        </li>

                        <!-- TEACHER -->
                        <li class="root-level">
                            <a href="/teacher">
                                <i class="icon-users"></i>
                                <span style="">Teachers</span>
                            </a>
                        </li>

                        <!-- PARENTS -->
                        <li class="root-level">
                            <a href="">
                                <i class="icon-users"></i>
                                <span style="">Parents</span>
                            </a>
                        </li>

                        <!-- LIBRARIAN -->
                        <li class="root-level">
                            <a href="">
                                <i class="icon-library"></i>
                                <span style="">Librarians</span>
                            </a>
                        </li>

                        <!-- LIBRARIAN -->
                        <li class="root-level">
                            <a href="">
                                <i class="icon-users"></i>
                                <span style="">Manage Alumni</span>
                            </a>
                        </li>

                        <!-- MEDIA -->
                        <li class="root-level">
                            <a href="">
                                <i class="icon-film2"></i>
                                <span style="">Manage Media</span>
                            </a>
                        </li>

                        <!-- ENQUIRY TABLE INFO -->
                        <li class="root-level">
                            <a href="">
                                <i class="icon-book2"></i>
                                <span style="">All Enquiries</span>
                            </a>
                        </li>

                        <!-- LOAN PAGE -->
                        <li  id="loan" class="has-sub root-level">
                            <a href="#">
                                <i class="icon-tree"></i>
                                <span style="">Manage Loan</span>
                                <i class="fa fa-angle-down dropdown-b down-arrow"></i>
                            </a>
                            <ul class="sub-menu cosellap" id="loan_ul">
                                <li class=" ">
                                    <a href="">
                                        <i class="icon-dot-single"></i>
                                        <span>Manage Loan Applicants</span>
                                    </a>
                                </li>
                                <li class=" ">
                                    <a href="">
                                        <i class="icon-dot-single"></i>
                                        <span>Manage Loan Approvals</span>
                                    </a>
                                </li>
                            </ul>
                        </li>


                        <!-- ENQUIRY TABLE INFO -->
                        <li class="root-level">
                            <a href="">
                                <i class="icon-cog3"></i>
                                <span style="">Enquiry Category</span>
                            </a>
                        </li>

                        <!-- ACCOUNTANT -->
                        <li class="root-level">
                            <a href="">
                                <i class="icon-users"></i>
                                <span style="">Accountants</span>
                            </a>
                        </li>

                        <!-- HOSTEL MANAGER -->
                        <li class="root-level">
                            <a href="">
                                <i class="icon-users"></i>
                                <span style="">Hostel Manager</span>
                            </a>
                        </li>

						<!--GENERATE ID CARDS-->
                        <li id="idcards" class="has-sub root-level">
                            <a href="#">
                                <i class="icon-id-badge"></i>
                                <span>Generate ID Cards</span>
                                <i class="fa fa-angle-down dropdown-b down-arrow"></i>
                            </a>
                            <ul class="sub-menu" id="idcards_ul">
                                <li class=" ">
                                    <a href="">
                                        <i class="icon-dot-single"></i>
                                        <span>Teachers</span>
                                    </a>
                                </li>
                                <li class=" ">
                                    <a href="">
                                        <i class="icon-dot-single"></i>
                                        <span>Hostel Manager</span>
                                    </a>
                                </li>
                                <li class=" ">
                                    <a href="">
                                        <i class="icon-dot-single"></i>
                                        <span style="">Accountants</span>
                                    </a>
                                </li>
                                <li class=" ">
                                    <a href="">
                                        <i class="icon-dot-single"></i>
                                        <span>Librarians</span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- CLASS -->
                        <li id="class" class="has-sub root-level">
                            <a href="#">
                                <i class="icon-tree"></i>
                                <span>Class</span>
                                <i class="fa fa-angle-down dropdown-b down-arrow"></i>
                            </a>
                            <ul class="sub-menu cosellap" id="class_ul">
                                <li class=" ">
                                    <a href="">
                                        <span style=""><i class="icon-dot-single"></i> Manage Classes</span>
                                    </a>
                                </li>
                                <li class=" ">
                                    <a href="">
                                        <span style=""><i class="icon-dot-single"></i> Manage Sections</span>
                                    </a>
                                </li>
                                <li class=" ">
                                    <a href="">
                                        <span style=""><i class="icon-dot-single"></i> Academic Syllabus</span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- SUBJECT -->
                        <li  id="subjects" class="has-sub root-level">
                        <a href="#">
                        <i class="icon-documents"></i>
                        <span>Subjects</span>
                        <i class="fa fa-angle-down dropdown-b down-arrow"></i>
                        </a>
                        <ul class="sub-menu cosellap" id="subjects_ul">
                        <li class="">
                        <a href="">
                        <i class="icon-dot-single"></i>
                        <span>Classs KG</span>
                        </a>
                        </li>
                        <li class="">
                        <a href="">
                        <i class="icon-dot-single"></i>
                        <span>Classs Primary One</span>
                        </a>
                        </li>
                        <li class="">
                        <a href="">
                        <i class="icon-dot-single"></i>
                        <span>Classs PRIMARY THREE</span>
                        </a>
                        </li>
                        </ul>
                        </li>

                        <!-- CLASS ROUTINE -->
                        <li class="root-level">
                            <a href="">
                                <i class="icon-hair-cross"></i>
                                <span style="">Class Routines</span>
                            </a>
                        </li>

                        <!-- CLUB -->
                        <li class="root-level">
                            <a href="">
                                <i class="icon-book2"></i>
                                <span style="">School Clubs</span>
                            </a>
                        </li>

                        <!-- CIRCULAR MANAGER -->
                        <li class="root-level">
                            <a href="">
                            	<i class="icon-book3"></i>
                                <span style="">Manage Circular</span>
                            </a>
                        </li>

                        <!-- TASK MANAGER -->
                        <li class="root-level">
                            <a href="">
                            	<i class="icon-book3"></i>
                                <span style="">Task Manager</span>
                            </a>
                        </li>

                        <!-- STUDY MATERIALS -->
                        <li class="root-level">
                            <a href="">
                                <i class="icon-hair-cross"></i>
                                <span style="">Study Materials</span>
                            </a>
                        </li>

                        <!-- DAILY ATTENDANCE -->
                        <li class="root-level">
                            <a href="">
                                <i class="icon-area-graph"></i>
                                <span style="">Daily Attendances</span>
                            </a>

                        </li>



                        <!-- MANAGE CBT -->
                        <li id="managecbt" class="root-level has-sub">
                            <a href="#">
                                <i class="icon-graduation-cap"></i>
                                <span style="">Manage CBT</span>
                                <i class="fa fa-angle-down dropdown-b down-arrow"></i>
                            </a>
                            <ul class="sub-menu cosellap" id="managecbt_ul">

                                <li class=" ">
                                    <a href="">
                                        <span style=""><i class="icon-dot-single"></i> Add Exams</span>
                                    </a>
                                </li>

                                <li class=" ">
                                    <a href="">
                                        <span style=""><i class="icon-dot-single"></i> List Exams</span>
                                    </a>
                                </li>

                                <li class=" ">
                                    <a href="">
                                        <span style=""><i class="icon-dot-single"></i> View Result</span>
                                    </a>
                                </li>

                            </ul>
                        </li>


                        <!-- EXAMS -->
                        <li id="exam" class="root-level has-sub">
                            <a href="#">
                                <i class="icon-graduation-cap"></i>
                                <span style="">Exams</span>
                                <i class="fa fa-angle-down dropdown-b down-arrow"></i>
                            </a>
                            <ul class="sub-menu cosellap" id="exam_ul">
                                <li class=" ">
                                    <a href="">
                                        <span style=""><i class="icon-dot-single"></i> Manage Exam Questions</span>
                                    </a>
                                </li>
                                <li class=" ">
                                    <a href="">
                                        <span style=""><i class="icon-dot-single"></i> exam list</span>
                                    </a>
                                </li>
                                <li class=" ">
                                    <a href="">
                                        <span style=""><i class="icon-dot-single"></i> Exam Grades</span>
                                    </a>
                                </li>
                                <li class=" ">
                                    <a href="">
                                        <span style=""><i class="icon-dot-single"></i> manage marks</span>
                                    </a>
                                </li>
                                <li class=" ">
                                    <a href="">
                                        <span style=""><i class="icon-dot-single"></i> Send Marks By Sms</span>
                                    </a>
                                </li>
                                <li class=" ">
                                    <a href="">
                                        <span style=""><i class="icon-dot-single"></i> Tabulation Sheet</span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- AASIGNMENTS -->
                        <li class="root-level">
                            <a href="">
                                <i class="icon-book3"></i>
                                <span style="">Assignments</span>
                            </a>
                        </li>

                        <!-- PAYMENT -->
                        <!-- <li class=" ">
                            <a href="index.php?admin/invoice">
                                <i class="entypo-credit-card"></i>
                                <span></span>
                            </a>
                        </li> -->

                        <!-- ACCOUNTING -->
                        <li id="Accounting" class="root-level has-sub">
                            <a href="#">
                                <i class="icon-suitcase"></i>
                                <span style="">Accounting</span>
                                <i class="fa fa-angle-down dropdown-b down-arrow"></i>
                            </a>
                            <ul class="sub-menu cosellap" id="Accounting_ul">
                                <li class=" ">
                                    <a href="">
                                    <i class="icon-dot-single"></i>
                                        <span style="">Create Student Payment</span>
                                    </a>
                                </li>
                                <li class=" ">
                                    <a href="">
                                    <i class="icon-dot-single"></i>
                                        <span style="">Student Payments</span>
                                    </a>
                                </li>
                                <li class=" ">
                                    <a href="">
                                    <i class="icon-dot-single"></i>
                                        <span style="">Expense</span>
                                    </a>
                                </li>
                                <li class=" ">
                                    <a href="">
                                    <i class="icon-dot-single"></i>
                                        <span style="">Expense Category</span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- LIBRARY -->
                        <li class="root-level">
                            <a href="">
                                <i class="icon-book3"></i>
                                <span style="">Libraries</span>
                            </a>
                        </li>

                        <!-- TRANSPORT -->
                        <li class="root-level">
                            <a href="">
                                <i class="icon-location"></i>
                                <span style="">Transports</span>
                            </a>
                        </li>

                        <!-- DORMITORY -->
                        <li class="root-level">
                            <a href="">
                                <i class="icon-home"></i>
                                <span style="">Dormitories</span>
                            </a>
                        </li>

                        <!-- NOTICEBOARD -->
                        <li class="root-level">
                            <a href="">
                                <i class="icon-text-document-inverted"></i>
                                <span style="">Noticeboards</span>
                            </a>
                        </li>


                        <!-- HOLIDAYS -->
                        <li class="root-level">
                            <a href="">
                                <i class="icon-hair-cross"></i>
                                <span style="">Manage Holiday</span>
                            </a>
                        </li>

                        <!-- TODAYS THOUGHT -->
                        <li class="root-level">
                            <a href="">
                                <i class="icon-book2"></i>
                                <span style="">Manage Thoughts</span>
                            </a>
                        </li>

                        <!-- MESSAGE -->
                        <li class="root-level">
                            <a href="">
                                <i class="icon-envelop"></i>
                                <span>Messages</span>
                            </a>
                        </li>

                        <!-- SETTINGS -->
                        <li id="setting" class="root-level has-sub">
                            <a href="#">
                                <i class="icon-cog3"></i>
                                <span style="">settings</span>
                                <i class="fa fa-angle-down dropdown-b down-arrow"></i>
                            </a>
                            <ul class="sub-menu cosellap" id="setting_ul">
                                <li>
                                    <a href="">
                                    <i class="icon-dot-single"></i>
                                        <span style="">General Settings</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="">
                                    <i class="icon-dot-single"></i>
                                        <span style="">Sms Settings</span>
                                    </a>
                                </li>
                                <li class=" ">
                                    <a href="">
                                    <i class="icon-dot-single"></i>
                                        <span style="">Language Settings</span>
                                    </a>
                                </li>

                                <li class=" ">
                                    <a href="">
                                    <i class="icon-dot-single"></i>
                                        <span style="">Manage Banners</span>
                                    </a>
                                </li>

                                <li class=" ">
                                    <a href="">
                                    <i class="icon-dot-single"></i>
                                        <span style="">Front Ends</span>
                                    </a>
                                </li>

                                <li class=" ">
                                    <a href="">
                                    <i class="icon-dot-single"></i>
                                        <span style="">News Settings</span>
                                    </a>
                                </li>


                            </ul>
                        </li>

                        <li class="root-level">
                            <a href="">
                                <i class="icon-book2"></i>
                                <span style="">Manage Help Link</span>
                            </a>
                        </li>

                        <!-- HELP DESK -->
                        <li class="root-level">
                            <a href="">
                                <i class="icon-users"></i>
                                <span style="">Manage Help Desks</span>
                            </a>
                        </li>

                        <!-- ACCOUNT -->
                        <li class="root-level">
                            <a href="">
                                <i class="icon-lock"></i>
                                <span style="">Accounts</span>
                            </a>
                        </li>

                    </ul>

                </div>
        @show
        @yield('content')
    </div>
 <script>
     $("#menu-toggle").click(function (e) {
         e.preventDefault();
         $("#wrapper").toggleClass("active");
         $("#main-content").toggleClass("expanded");
     });

     $('li.has-sub').click(function (e) {
         e.preventDefault();
         $('#' + this.id + ' .down-arrow').toggleClass('rotate');
         $('#' + this.id).toggleClass('active');
         $('#' + this.id + '_ul').toggle();
     });

     $('.breadcrumb_type ul li').click(function (e) {
         console.log('clicked:' + this.id);
         e.preventDefault();
         $('.breadcrumb_type ul li').removeClass('active');
         $('.breadcrumb_type ul #' + this.id).addClass('active');

         $('#basic_info_panel').removeClass('active');
         $('#profile_info_panel').removeClass('active');
         $('#profile_photo_panel').removeClass('active');
         $('#' + this.id + '_panel').toggleClass('active');
     });

 </script>
</body>
</html>
