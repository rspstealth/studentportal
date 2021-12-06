@extends('layouts.login')

@section('content')
<style>
    a:hover{
        color: #2c7be5;
        text-decoration: underline;
    }
</style>
<div class="wrapper" id="header">
    <div class="container">
        <div class="row">
            <div id="header_left" class="col-md-6">
                <a href="#" class="logo"><h2><b>Student Portal</b></h2></a>
            </div>
            <div id="header_right" class="col-md-6">
                <p style="font-size:22px;">Student Support Line - 0113 3200406</p>
            </div>
        </div>
    </div>
</div>

<div class="container main-content" id="login_bg">
    <div class="row">
        <div class="col-12 text-center">
            <h3 style="padding:30px;color:#2c7be5"><b>Login To Your Personalized Dashboard</b></h3>
            <hr class="hr-login"/>
        </div>

        <div class="col-md-6 justify-content-center">
            <div class="col-md-10" style="padding-left: 60px;">
            <!-- Heading -->
            <h3 class="display-4 text-center mb-3">
                <b>User Login</b>
            </h3>

            <!-- Subheading -->
            <p class="text-muted text-center mb-5">
                Login to your account to access all
                your course information
            </p>
            <br>
            <form method="POST" action="{{ route('login') }}">
            {{ csrf_field() }}
                <!-- Email address -->
                <div class="form-group">
                    <label for="login" class="control-label lb-lg text-left">
                        {{ __('Username / Email') }}
                    </label>

                        <input id="login" type="text" placeholder="Enter username or email"
                               class="form-control{{ $errors->has('username') || $errors->has('email') ? ' is-invalid' : '' }}"
                               name="login" value="{{ old('username') ?: old('email') }}" required autofocus>

                        @if ($errors->has('username') || $errors->has('email'))
                            <span class="invalid-feedback">
                                        <strong>{{ $errors->first('username') ?: $errors->first('email') }}</strong>
                            </span>
                        @endif
                </div>

                <!-- Password -->
                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <!-- Label -->
                    <label>Password</label>
                    <!-- Input -->
                    <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password" required>
                    @if ($errors->has('password'))
                        <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="col">
                    <div class="col-md-6 no-padding" >
                        <a style="padding: 15px 0;display: block;" class="form-text small" href="{{ route('password.request') }}">
                            Forgot Your Password?
                        </a>
                    </div>
                    <div class="col-md-6 no-padding">
                        <!-- Submit -->
                        <button type="submit" class="btn btn-lg btn-block btn-primary mb-3">
                            Sign in
                        </button>
                    </div>
                </div>
                <!-- Intentional spacing -->
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <!-- Intentional spacing ends -->

            </form>
            </div>
        </div>
    </div> <!-- / .row -->
    <div class="row">
        <div id="info_banner" class="col-md-12 text-center">
            <div class="col-md-4"><p><i class="fas fa-download"></i>&nbsp;&nbsp;No Installation</p></div>
            <div class="col-md-4"><p><i class="far fa-edit"></i>&nbsp;&nbsp;No Contracts</p></div>
            <div class="col-md-4"><p><i class="fab fa-cc-visa"></i>&nbsp;&nbsp;No Credit Card</p></div>
        </div>
    </div> <!-- / .row -->
    <div class="row" style="padding:90px 0px;">
        <div class="col-md-6 text-center">
            <br>
            <br>
            <h3><b>WELCOME TO YOUR "ONE-STOP SHOP" FOR ALL YOUR STUDENT SUPPORT NEEDS.</b></h3>
            <p>This unique and user-friendly system has been designed
                specifically for you to make it as easy and painless as possible
                for you to get personal tutor support, submit and get critique
                on your assignments, and interact with your fellow students
                through the exclusive student forums. Enjoy!</p>
        </div>
        <div class="col-md-6 text-center">
            <img src="images/comp1.png"/>
        </div>

    </div> <!-- / .row -->
    <hr class="hr-login"/>
    <div class="row" style="padding:80px 0px;">
        <div class="col-md-6 text-center">
            <img src="images/comp2.png"/>
        </div>
        <div class="col-md-6 text-center">
            <br>
            <br>
            <div style="text-align:left;padding:15px 20px 0px 0px;">
                <p class="clearfix"><i style="color:green;font-size:18px;" class="fas fa-check-circle"></i>&nbsp;&nbsp;<b>ACCESS TO YOUR COURSE TUTOR.</b>  </p>
                <p class="clearfix"><i style="color:green;font-size:18px;" class="fas fa-check-circle"></i>&nbsp;&nbsp;<b>SUBMIT YOUR ASSIGNMENTS FOR MARKING.</b> </p>
                <p class="clearfix"><i style="color:green;font-size:18px;" class="fas fa-check-circle"></i>&nbsp;&nbsp;<b>RECEIVE FEEDBACK AND CONSTRUCTIVE COMMENT ON YOUR WORK.</b></p>
                <br>
            </div>
        </div>
    </div> <!-- / .row -->
    <hr class="hr-login"/>
    <div class="row" style="padding:80px 0px;">
        <div class="col-md-6 text-center">
            <img src="images/comp3.png"/>
            <h5><b>GET INSTANT ACCESS TO THE FULL RANGE OF<br> RESOURCES AT YOUR DISPOSAL.</b></h5>
        </div>
        <div class="col-md-6 text-center">
            <img src="images/comp4.png"/>
            <h5><b>RECEIVE UPDATES AND NEWS "HOT OFF THE PRESS"<br> BEFORE THE GENERAL PUBLIC.</b></h5>
        </div>
    </div> <!-- / .row -->
    <hr class="hr-login"/>
    <div class="row text-center">
        <div class="col-12">
            <h3><a href="#"><b>Student Portal</b></a></h3>
            <br>
            <br>
            <br>
        </div>
    </div>

    <div id="footer" class="row">
        <div class="col-md-2">
            <h3><b>Links</b></h3>
            <ul>
                <li><a href="{{url('/')}}/about-us" title="About us">Who we are</a></li>
                <li><a href="{{url('/')}}/pricing" title="Pricing">Pricing</a></li>
            </ul>
        </div>
        <div class="col-md-3">
            <h3>&nbsp;</h3>
            <ul>
                <li><a href="{{url('/')}}/privacy-policy" title="Privacy policy">Privacy Policy</a></li>
                <li><a href="{{url('/')}}/terms-and-conditions" title="Terms & Conditions">Terms & Conditions</a></li>
            </ul>
        </div>
        <div class="col-md-4">

        </div>
        <div class="col-md-3 text-right">
            <div class="ft-links" style="text-align:right;">
                <h3><b>Get in Touch</b></h3>
                <a href="#">Silicon House,</a><br>
                <a href="#"> Farfield Park,</a><br>
                <a href="#">Manvers</a><br>
                <a href="#">Rotherham</a><br>
                <a href="#">S63 5DB</a><br>
                <br><br>
                <a href="tel:08006226157"><strong>t : 0843 289 3711</strong></a>
            </div>
        </div>
    </div>
    <div class="row text-center" id="footer_bottom">
        <p>Registered Office: I Learn It Easy LTD, 136 Gray Street, Workington, England, CA14 2LU, Registered In England: 08041995</p>
    </div>
</div>
@endsection
