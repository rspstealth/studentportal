@extends('layouts.app-demo')

@section('content')
{{--<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading lb-lg text-center"><h3>Log In</h3></div>

                <div class="login-panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class=" control-label lb-lg">E-Mail Address</label>

                                <input placeholder="name@company.com" id="email" type="email" class="form-control lb-lg" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="control-label lb-lg">Password</label>

                                <input placeholder="Type your password" id="password" type="password" class="form-control lb-lg" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                        </div>

                        <div class="form-group  lb-lg">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                    </label>
                                </div>
                        </div>

                        <div class="form-group  text-center">
                                <button type="submit" class="btn btn-primary btn-block lb-xl">
                                    Log In
                                </button>
                                <br>
                                <a class="btn btn-link lb-lg" href="{{ route('password.request') }}">
                                    Forgot Your Password?
                                </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>--}}

<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-5 col-xl-4 my-5">

            <!-- Heading -->
            <h1 class="display-4 text-center mb-3">
                Student Sign in
            </h1>

            <!-- Subheading -->
            <p class="text-muted text-center mb-5">
                To Access Your Dashboard
            </p>

            <form class="form-horizontal" method="POST" action="{{ route('login') }}">
            {{ csrf_field() }}

                <!-- Email address -->
                <div class="form-group">
                    <label for="login" class="control-label lb-lg text-left">
                        {{ __('Username or Email') }}
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
                    <div class="row">
                        <div class="col">
                            <!-- Label -->
                            <label>Password</label>
                        </div>
                        <div class="col-auto">
                            <a class="form-text small text-muted" href="{{ route('password.request') }}">
                                Forgot Your Password?
                            </a>
                        </div>
                    </div> <!-- / .row -->

                    <!-- Input group -->
                    <div class="input-group input-group-merge">

                        <!-- Input -->
                        <input type="password" id="password" name="password" class="form-control form-control-appended" placeholder="Enter your password" required>
                        <!-- Icon -->
                        <div class="input-group-append">
                              <span class="input-group-text">
                                <i class="fa fa-eye"></i>
                              </span>
                        </div>

                        @if ($errors->has('password'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>

                <!-- Submit -->
                <button type="submit" class="btn btn-lg btn-block btn-primary mb-3">
                    Sign in
                </button>

                <!-- Link -->
                <div class="text-center">
                    <small class="text-muted text-center">
                        Don't have an account yet? <a href="{{ route('register') }}">Sign up</a>.
                    </small>
                </div>

            </form>

        </div>
    </div> <!-- / .row -->
</div>


@endsection
