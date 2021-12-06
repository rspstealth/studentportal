@extends('layouts.app-demo')
@section('content')
    <!-- CONTENT
    ================================================== -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-5 col-xl-4 my-5">
                <h1 class="display-4 text-center mb-3">
                    Sign Up
                </h1>

                <!-- Subheading -->
                <p class="text-muted text-center mb-5">
                    For Basic User Access
                </p>

                    <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="control-label lb-lg text-left">Name</label>
                            <input placeholder="Enter your name" id="name" type="text" class="form-control lb-lg"
                                   name="name" value="{{ old('name') }}" required autofocus>
                            @if ($errors->has('name'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                            <label for="username" class="control-label lb-lg text-left">Username</label>


                                <input id="username" type="text" placeholder="Enter username" class="form-control lb-lg" name="username" value="{{ old('username') }}" required
                                       autofocus>

                                @if ($errors->has('username'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @endif

                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="control-label">Email Address</label>

                            <input placeholder="name@company.com" id="email" type="email" class="form-control lb-lg"
                                   name="email" value="{{ old('email') }}" required>

                            @if ($errors->has('email'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                            @endif
                        </div>




                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class=" control-label lb-lg">Password</label>

                            <input placeholder="Type your password" id="password" type="password" class="form-control"
                                   name="password" required>

                            @if ($errors->has('password'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class=" control-label">Confirm Password</label>

                            <input placeholder="Type your password" id="password-confirm" type="password"
                                   class="form-control" name="password_confirmation" required>
                        </div>
                        <input readonly id="role_id" type="hidden" name="role_id" value="2"/>
                        <div class="form-group">
                            <div class="">
                                <button type="submit" class="btn btn-lg btn-block btn-primary mb-3">
                                    Sign Up
                                </button>
                            </div>
                        </div>

                        <div class="text-center">
                            <small class="text-muted text-center">
                                Already have an account? <a href="{{ route('login') }}">Log in</a>.
                            </small>
                        </div>
                    </form>
            </div>
        </div>
    </div>
@endsection
